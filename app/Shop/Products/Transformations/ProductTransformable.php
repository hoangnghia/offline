<?php

namespace App\Shop\Products\Transformations;

use App\Shop\Products\Product;
use Illuminate\Support\Facades\Storage;

trait ProductTransformable
{
    /**
     * Transform the product
     *
     * @param Product $product
     * @return Product
     */
    protected function transformProduct(Product $product)
    {
        $prod = new Product;
        $prod->id = (int) $product->id;
        $prod->name = $product->name;
        $prod->sku = $product->sku;
        $prod->slug = $product->slug;
        $prod->description = $product->description;
        $prod->cover = asset("storage/$product->cover");
        $prod->quantity = (int)$product->quantity;
        $prod->price = (int)$product->price;
        $prod->status = $product->status;
        $prod->weight = (float) $product->weight;
        $prod->mass_unit = $product->mass_unit;
        $prod->sale_price = (int)$product->sale_price;
        $prod->brand_id = (int) $product->brand_id;
        $prod->quantity_buy = (int) $product->quantity_buy;
        $prod->timer_buy = (int) $product->timer_buy;
        $prod->description_short = $product->description_short;
        $prod->best_sale = (int )$product->best_sale;
        $prod->date_sale = $product->date_sale;

        return $prod;
    }
}
