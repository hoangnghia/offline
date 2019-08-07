<?php

namespace App\Shop\Categories\Repositories;

use App\Shop\Categories\CategoryType;
use Carbon\Carbon;
use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Categories\Category;
use App\Shop\Categories\Exceptions\CategoryInvalidArgumentException;
use App\Shop\Categories\Exceptions\CategoryNotFoundException;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Products\Product;
use App\Shop\Products\Transformations\ProductTransformable;
use App\Shop\Tools\UploadableTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use App\Shop\Api\ConnectApi;
use App\Shop\Api\Socaial;
use Image;


class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    use UploadableTrait, ProductTransformable, ConnectApi;

    /**
     * CategoryRepository constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        parent::__construct($category);
        $this->model = $category;
    }

    /**
     * List all the categories
     *
     * @param string $order
     * @param string $sort
     * @param array $except
     * @return \Illuminate\Support\Collection
     */
    public function listCategories(string $order = 'id', string $sort = 'desc', $except = []): Collection
    {
        return $this->model->orderBy($order, $sort)->get()->except($except);
    }

    /**
     * List all root categories
     *
     * @param  string $order
     * @param  string $sort
     * @param  array $except
     * @return \Illuminate\Support\Collection
     */
    public function rootCategories(string $order = 'id', string $sort = 'desc', $except = []): Collection
    {
        return $this->model->whereIsRoot()
            ->orderBy($order, $sort)
            ->get()
            ->except($except);
    }

    /**
     * Create the category
     *
     * @param array $params
     *
     * @return Category
     * @throws CategoryInvalidArgumentException
     * @throws CategoryNotFoundException
     */
    public function createCategory(array $params): Category
    {
        try {
            $collection = collect($params);
            if (isset($params['name'])) {
                $slug = str_slug($params['name']);
            }

            if (isset($params['cover']) && ($params['cover'] instanceof UploadedFile)) {
                $cover = $this->uploadOne($params['cover'], 'categories');
            }
            $merge = $collection->merge(compact('slug', 'cover'));

            $category = new Category($merge->all());

            if (isset($params['parent'])) {
                $parent = $this->findCategoryById($params['parent']);
                $category->parent()->associate($parent);
            }
//            $image = 'http://127.0.0.1:8000/storage/'.$category->cover;
            $image = 'https://www.thammyvienngocdung.com/wp-content/uploads/2019/07/c6df0af5dfde2ff8cf314e578592dd39.jpg';
            $url = 'https://zaloapidev.ngocdunggroup.com.vn/shops/' . Socaial::PAGE_ID_ZALO . '/upload-photo?product=' . Socaial::PRODUCT_ZALO . '&token=' . Socaial::TOKEN_ZALO;
            $str_data = '{"url": "' . $image . '","type":  "' . Socaial::TYPE_ZALO . '"}';
            $result = $this->httpZalo($url, $str_data);
            $argsGet = json_decode($result, true);

            $imageUpload = $argsGet['data']['id'];
            $status = 'hide';
            if ($category->status == 1) {
                $status = 'show';
            }
            $category->save();
            $url = 'https://zaloapidev.ngocdunggroup.com.vn/shops/' . Socaial::PAGE_ID_ZALO . '/categories?product=' . Socaial::PRODUCT_ZALO . '&token=' . Socaial::TOKEN_ZALO;
            $str_data = '{"name": "' . $category->name . '","description":  "' . $category->description . '","photoId":  "' . $imageUpload . '","status":  "' . $status . '"}';
            $createCategory = $this->httpZalo($url, $str_data);
            $categoryGet = json_decode($createCategory, true);

            $categoryType = new CategoryType();
            $categoryType->local_id = $category->id;
            $categoryType->social_id = $categoryGet['data']['id'];
            $categoryType->type = 1;
            $categoryType->created_at = Carbon::now();
            $categoryType->updated_at = Carbon::now();
            $categoryType->save();
            return $category;
        } catch (QueryException $e) {
            throw new CategoryInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Create the category
     *
     * @param array $params
     *
     * @return Category
     * @throws CategoryInvalidArgumentException
     * @throws CategoryNotFoundException
     */
    public function createCategoryAPI(array $params)
    {
        $data = [];
        try {
            $url = 'https://zaloapidev.ngocdunggroup.com.vn/shops/' . Socaial::PAGE_ID_ZALO . '/categories?product=' . Socaial::PRODUCT_ZALO . '&token=' . Socaial::TOKEN_ZALO;
            $result = $this->httpGetCategoryZalo($url);
            $argsGet = json_decode($result, true);
            foreach ($argsGet['data']['list'] as $item) {
                $categoryType = CategoryType::where('social_id', $item['id'])->first();

                if ($categoryType == null) {
                    $collection = collect($item);
                    if (isset($collection['name'])) {
                        $slug = str_slug($collection['name']);
                    }
                    if (isset($collection['photo_link'])) {
//                        $path = 'https://i.stack.imgur.com/koFpQ.png';
                        $filename = basename($collection['photo_link']);
                        $image = Image::make($collection['photo_link'])->save(public_path('storage/categories/' . $filename));
                    }
                    $cover = 'categories/' . $image->basename;
                    if ($collection['status'] == 'show') {
                        $collection['status'] = 1;
                    } else {
                        $collection['status'] = 0;
                    }
                    $merge = $collection->merge(compact('slug', 'cover', 'status'));
                    $category = new Category($merge->all());
                    $category->save();
                    $categoryType = new CategoryType();
                    $categoryType->local_id = $category->id;
                    $categoryType->social_id = $item['id'];
                    $categoryType->type = 1;
                    $categoryType->created_at = Carbon::now();
                    $categoryType->updated_at = Carbon::now();
                    $categoryType->save();
                    array_push($data, $categoryType);
                }
            }
            return true;
        } catch (QueryException $e) {
            throw new CategoryInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Update the category
     *
     * @param array $params
     *
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function updateCategory(array $params): Category
    {
        $category = $this->findCategoryById($this->model->id);
        $collection = collect($params)->except('_token');
        $slug = str_slug($collection->get('name'));

        if (isset($params['cover']) && ($params['cover'] instanceof UploadedFile)) {
            $cover = $this->uploadOne($params['cover'], 'categories');
        }
        $merge = $collection->merge(compact('slug', 'cover'));

        // set parent attribute default value if not set
        $params['parent'] = $params['parent'] ?? 0;

        // If parent category is not set on update
        // just make current category as root
        // else we need to find the parent
        // and associate it as child
        if ((int)$params['parent'] == 0) {
            $category->saveAsRoot();
        } else {
            $parent = $this->findCategoryById($params['parent']);
            $category->parent()->associate($parent);
        }
        $category->update($merge->all());
        $image = 'https://www.thammyvienngocdung.com/wp-content/uploads/2019/07/c6df0af5dfde2ff8cf314e578592dd39.jpg';
        $url = 'https://zaloapidev.ngocdunggroup.com.vn/shops/' . Socaial::PAGE_ID_ZALO . '/upload-photo?product=' . Socaial::PRODUCT_ZALO . '&token=' . Socaial::TOKEN_ZALO;
        $str_data = '{"url": "' . $image . '","type":  "' . Socaial::TYPE_ZALO . '"}';
        $result = $this->httpZalo($url, $str_data);
        $argsGet = json_decode($result, true);
        $iamgeUpload = $argsGet['data']['id'];
        $status = 'hide';
        if ($category->status == 1) {
            $status = 'show';
        }
        $categoryType = CategoryType::where('local_id', $category->id)->first();
        $url = 'https://zaloapidev.ngocdunggroup.com.vn/shops/' . Socaial::PAGE_ID_ZALO . '/categories/' . $categoryType->social_id . '?product=' . Socaial::PRODUCT_ZALO . '&token=' . Socaial::TOKEN_ZALO;
        $str_data = '{"name": "' . $category->name . '","description":  "' . $category->description . '","photoId":  "' . $iamgeUpload . '","status":  "' . $status . '"}';
        $this->httpUploadZalo($url, $str_data);
        $categoryType->updated_at = Carbon::now();
        $categoryType->save();
        return $category;
    }

    /**
     * @param int $id
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function findCategoryById(int $id): Category
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundException($e->getMessage());
        }
    }

    /**
     * Delete a category
     *
     * @return bool
     * @throws \Exception
     */
    public function deleteCategory(): bool
    {
        return $this->model->delete();
    }

    /**
     * Associate a product in a category
     *
     * @param Product $product
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function associateProduct(Product $product)
    {
        return $this->model->products()->save($product);
    }

    /**
     * Return all the products associated with the category
     *
     * @return mixed
     */
    public function findProducts(): Collection
    {
        return $this->model->products;
    }

    /**
     * @param array $params
     */
    public function syncProducts(array $params)
    {
        $this->model->products()->sync($params);
    }


    /**
     * Detach the association of the product
     *
     */
    public function detachProducts()
    {
        $this->model->products()->detach();
    }

    /**
     * @param $file
     * @param null $disk
     * @return bool
     */
    public function deleteFile(array $file, $disk = null): bool
    {
        return $this->update(['cover' => null], $file['category']);
    }

    /**
     * Return the category by using the slug as the parameter
     *
     * @param array $slug
     *
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function findCategoryBySlug(array $slug): Category
    {
        try {
            return $this->findOneByOrFail($slug);
        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundException($e);
        }
    }

    /**
     * @return mixed
     */
    public function findParentCategory()
    {
        return $this->model->parent;
    }

    /**
     * @return mixed
     */
    public function findChildren()
    {
        return $this->model->children;
    }
}
