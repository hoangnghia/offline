<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Shop\Customer\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $id = Auth::guard('employee')->user();
        $campaign = DB::table('campaign as c')
            ->select('c.*', 'l.user_id', 'l.campaign_id', 'b.name as nameAddress', 'lo.name as local_name', 'lo.address','l.taget as user_taget','l.local_id','l.id as local_user_id')
            ->join('local_user as l', 'l.campaign_id', '=', 'c.id')
            ->join('branchs as b', 'b.id', '=', 'c.address')
            ->join('local as lo', 'lo.id', '=', 'l.local_id')
            ->where('l.user_id', $id->id)
            ->orderBy('l.created_at', 'desc')
            ->get();
        return view('front.employee.campaign', [
            'campaign' => $campaign,
        ]);
    }

    public function add($id)
    {
        $user_id = Auth::guard('employee')->user();
        return view('front.employee.add', [
            'id' => $id,
            'user_id' => $user_id,
        ]);
    }

    public function customer($id)
    {
        if ($id == 0) {
            $customer = Customer::all();
        } else {
            $customer = Customer::where('local_user_id', $id)->get();
        }
        return view('front.employee.customer', [
            'customer' => $customer,
        ]);
    }

    public function postAddCustomer(Request $request)
    {
//        dd($request->local_id);
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->birthday = $request->date;
        $customer->email = $request->email;
        $customer->service = $request->service;
        if ($request->local_id != 0) {
            $customer->local_user_id = $request->local_id;
        }
        $customer->note = $request->note;
        $customer->created_at = Carbon::now();
        $customer->updated_at = Carbon::now();
        $customer->save();
        request()->session()->flash('message', 'Thêm thành công !!!');
        return redirect(url('employee/add') . '/' . $request->local_id);

    }
}
