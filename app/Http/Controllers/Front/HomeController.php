<?php

namespace App\Http\Controllers\Front;

use App\Shop\Categories\Category;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Customer\Customer;
use App\Shop\Products\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;

class HomeController
{
    use AuthenticatesUsers;
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepo;
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepo;

    /**
     * HomeController constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository, CartRepositoryInterface $cartRepository)
    {
        $this->categoryRepo = $categoryRepository;
        $this->cartRepo = $cartRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $id = Auth::guard('employee')->user();
        $campaign = DB::table('campaign as c')
            ->select('c.*', 'l.user_id', 'l.campaign_id', 'b.name as nameAddress')
            ->join('local_user as l', 'l.campaign_id', '=', 'c.id')
            ->join('branchs as b', 'b.id', '=', 'c.address')
            ->where('l.user_id', $id->id)
            ->orderBy('l.created_at', 'desc')
            ->get();
        return view('front.employee.campaign', [
            'campaign' => $campaign,
        ]);
    }

    public function add($id)
    {
        return view('front.employee.add', [
            'id' => $id,
        ]);
    }

    public function customer($id)
    {
        if ($id == 0) {
            $customer = Customer::all();
        } else {
            $customer = Customer::where('campaign_id', $id)->get();
        }

        return view('front.employee.customer', [
            'customer' => $customer,
        ]);
    }

    public function postAddCustomer(Request $request)
    {
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->birthday = $request->date;
        $customer->email = $request->email;
        $customer->service = $request->service;
        if ($request->campaign_id != 0) {
            $customer->campaign_id = $request->campaign_id;
        }
        $customer->note = $request->note;
        $customer->created_at = Carbon::now();
        $customer->updated_at = Carbon::now();
        $customer->save();
        request()->session()->flash('message', 'Thêm thành công !!!');
        return redirect(url('employee/add') . '/' . $request->campaign_id);
//        return redirect()->route('employee.add');
    }
}
