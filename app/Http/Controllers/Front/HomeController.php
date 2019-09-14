<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Shop\Campaigns\Campaign;
use App\Shop\Customer\Customer;
use App\Shop\Local\Local;
use App\Shop\Local\LocalUser;
use App\Shop\Service\LocalServices;
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
            ->select('c.*', 'l.user_id', 'l.campaign_id', 'b.name as nameAddress', 'lo.name as local_name', 'lo.address', 'l.taget as user_taget', 'l.local_id', 'l.id as local_user_id')
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
        $local = LocalUser::where('id', $id)->first();
        $service = DB::table('local_services as ls')
            ->select('ls.*', 's.name as name_service')
            ->join('services as s', 's.id', '=', 'ls.service_id')
            ->where('ls.local_id', $local->local_id)
            ->where('campaign_id', $local->campaign_id)
            ->orderBy('ls.created_at', 'desc')
            ->get();

        return view('front.employee.add', [
            'id' => $id,
            'user_id' => $user_id,
            'service' => $service
        ]);
    }

    public function AddRelatives($id)
    {
        $customer = Customer::where('id', $id)->first();
        $local = LocalUser::where('id', $customer->local_user_id)->first();
        $service = DB::table('local_services as ls')
            ->select('ls.*', 's.name as name_service')
            ->join('services as s', 's.id', '=', 'ls.service_id')
            ->where('ls.local_id', $local->local_id)
            ->where('campaign_id', $local->campaign_id)
            ->orderBy('ls.created_at', 'desc')
            ->get();
        return view('front.employee.addRelatives', [
            'customer' => $customer,
            'service' => $service
        ]);
    }

    public function customer($id)
    {
        if ($id == 0) {
            $customer = Customer::all();
        } else {
//            $customer = Customer::where('local_user_id', $id)->pa();
            $customer = DB::table('customer as c')
                ->select('c.*')
                ->where('c.local_user_id', $id)
                ->orderBy('c.created_at', 'desc')
                ->paginate(20);
//            dd($customer);
        }
        return view('front.employee.customer', [
            'customer' => $customer,
        ]);
    }

    public function postAddCustomer(Request $request)
    {
        if (isset($request->phone)) {
            $phonecheck = strlen($request->phone);
            if ($phonecheck != 10) {
                request()->session()->flash('error', 'Sai số điện thoại !!!');
                return redirect(url('employee/add') . '/' . $request->local_id);
            }
            $checkPhone = Customer::where('phone', $request->phone)->get();
            if (count($checkPhone) > 0) {
                request()->session()->flash('error', 'Số điện thoại tồn tại !!!');
                return redirect(url('employee/add') . '/' . $request->local_id);
            }

            if (isset($request->date)) {
                $arrDate = explode("/", $request->date);
                if ($arrDate[0] > 31) {
                    request()->session()->flash('error', 'Nhập sai ngày sinh rồi bạn ơi -> ' . $request->date);
                    return redirect(url('employee/add') . '/' . $request->local_id);
                }
                if ($arrDate[1] > 12) {
                    request()->session()->flash('error', 'Nhập sai tháng sinh rồi bạn ơi -> ' . $request->date);
                    return redirect(url('employee/add') . '/' . $request->local_id);
                }
//                dd($request->date);
                $dateNow = Carbon::now();
                $yearAge = substr($request->date, -4);
                $yearNow = date_format($dateNow, 'Y');
                $age = $yearNow - $yearAge;
                $localUsser = LocalUser::where('id', $request->local_id)->first();
                $campaign = Campaign::where('id', $localUsser->campaign_id)->first();
                if ($campaign->age > $age) {
                    request()->session()->flash('error', 'Xin lỗi ! Bạn chưa đủ tuổi tham gia chương trình !!!');
                    return redirect(url('employee/add') . '/' . $request->local_id);
                }
            }
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
            if ($request->submit == 'Thêm khách hàng') {
                request()->session()->flash('message', 'Thêm thành công !!!');
                return redirect(url('employee/add') . '/' . $request->local_id);
            } else {
                request()->session()->flash('message', 'Thêm thành công !!!');
                return redirect(url('employee/addRelatives') . '/' . $customer->id);
            }
        }
    }

    public function postAddRelatives(Request $request)
    {
        if (isset($request->phone)) {
            $checkPhone = Customer::where('phone', $request->phone)->get();
            if (count($checkPhone) > 0) {
                request()->session()->flash('error', 'Số điện thoại trùng !!!');
                return redirect(url('employee/addRelatives') . '/' . $request->customer);
            }
            $phonecheck = strlen($request->phone);
            if ($phonecheck != 10) {
                request()->session()->flash('error', 'Số điện thoại sai !!!');
                return redirect(url('employee/addRelatives') . '/' . $request->customer);
            }
            if (isset($request->date)) {
                $arrDate = explode("/", $request->date);
                if ($arrDate[0] > 31) {
                    request()->session()->flash('error', 'Nhập sai ngày sinh rồi bạn ơi -> ' . $request->date);
                    return redirect(url('employee/add') . '/' . $request->local_id);
                }
                if ($arrDate[1] > 12) {
                    request()->session()->flash('error', 'Nhập sai tháng sinh rồi bạn ơi -> ' . $request->date);
                    return redirect(url('employee/add') . '/' . $request->local_id);
                }
                
                $dateNow = Carbon::now();
                $yearNow = date_format($dateNow, 'Y');
                $yearAge = substr($request->date, -4);
                $age = $yearNow - $yearAge;
                $User = Customer::where('id', $request->customer)->first();
                $localUsser = LocalUser::where('id', $User->local_user_id)->first();
                $campaign = Campaign::where('id', $localUsser->campaign_id)->first();
                if ($campaign->age > $age) {
                    request()->session()->flash('error', 'Xin lỗi ! Bạn chưa đủ tuổi tham gia chương trình !!!');
                    return redirect(url('employee/addRelatives') . '/' . $request->customer);
                }
            }
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->birthday = $request->date;
            $customer->email = $request->email;
            $customer->service = $request->service;
            $customer->parent_id = $request->customer;
            $localUser = Customer::where('id', $request->customer)->first();
            $customer->local_user_id = $localUser->local_user_id;
            $customer->note = $request->note;
            $customer->created_at = Carbon::now();
            $customer->updated_at = Carbon::now();
            $customer->save();
            if ($request->submit == 'Thêm khách hàng') {
                request()->session()->flash('message', 'Thêm thành công !!!');
                return redirect(url('employee/add') . '/' . $localUser->local_user_id);
            } else {
                request()->session()->flash('message', 'Thêm thành công !!!');
                return redirect(url('employee/addRelatives') . '/' . $request->customer);
            }
        }
    }
}
