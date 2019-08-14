<?php

namespace App\Http\Controllers\Admin\Customers;

use App\Shop\Customer\Customer;
use App\Shop\Customers\Transformations\CustomerTransformable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.customers.list');
    }

    /*
     * Get list data Campaign
     * use : Datatable
     */
    public function getListData()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $customer = DB::table('customer as c')
            ->select('c.*', 's.name as service_name', 'ca.name as campaign_name', 'e.name as employees_name')
            ->join('local_user as lu', 'lu.id', '=', 'c.local_user_id')
            ->join('services as s', 's.id', '=', 'c.service')
            ->join('campaign as ca', 'ca.id', '=', 'lu.campaign_id')
            ->join('employees as e', 'e.id', '=', 'lu.user_id')
            ->orderBy('c.created_at', 'desc')
            ->get();
//            dd($customer);
        $datatables = DataTables::of($customer);
        $datatables->addColumn('name_parent', function ($model) {
            if (isset($model->parent_id)) {
                $customerParent = DB::table('customer as c')
                    ->select('c.*', 'e.name as employees_name', 'lu.user_id', 'lu.local_id', 'lu.campaign_id', 'lu.taget', 'lu.local_campaign_id')
                    ->join('local_user as lu', 'lu.id', '=', 'c.local_user_id')
                    ->join('employees as e', 'e.id', '=', 'lu.user_id')
                    ->where('c.id', $model->parent_id)
                    ->first();
                $name = $customerParent->name;
            } else {
                $name = null;
            }

            return $name;
        });
        return $datatables->make(true);
    }

    public function detail($id)
    {
        $detail = DB::table('customer as c')
            ->select('c.*', 's.name as service_name', 'ca.name as campaign_name', 'e.name as employees_name', 'ca.time_start', 'ca.time_end', 'ca.taget', 'b.name as branch_name', 'a.name as agency_name', 'l.name as local_name')
            ->join('local_user as lu', 'lu.id', '=', 'c.local_user_id')
            ->join('services as s', 's.id', '=', 'c.service')
            ->join('campaign as ca', 'ca.id', '=', 'lu.campaign_id')
            ->join('employees as e', 'e.id', '=', 'lu.user_id')
            ->join('branchs as b', 'b.id', '=', 'ca.address')
            ->join('agency as a', 'a.id', '=', 'ca.agency_id')
            ->join('local as l', 'l.id', '=', 'lu.local_id')
            ->where('c.id', $id)
            ->orderBy('c.created_at', 'desc')
            ->first();
        $parent = DB::table('customer as c')
            ->select('c.*', 's.name as service_name')
            ->join('services as s', 's.id', '=', 'c.service')
            ->where('c.id', $detail->parent_id)
            ->orderBy('c.created_at', 'desc')
            ->first();
        return view('admin.customers.detail', [
            'detail' => $detail,
            'parent' => $parent
        ]);
    }

    public function detailUpload(Request $request)
    {
        if (isset($request->id)) {
            $customer = Customer::where('id', $request->id)->first();
            $customer->name = $request['name-customer'];
            $customer->phone = $request['phone-customer'];
            $customer->note = $request['note-customer'];
            $customer->save();
            request()->session()->flash('message', 'Cập nhật thành công !!!');
            return redirect('admin/customer/detail/' . $request->id);
        }
        request()->session()->flash('error', 'Cập nhật thất bại !!!');
        return redirect('admin/customer/detail/' . $request->id);
    }

    public function status($id)
    {
        $customer = Customer::where('id', $id)->first();
        if (!is_null($customer)) {
            $customer->status = !$customer->status;
            $customer->save();
            request()->session()->flash('message', 'Cập nhật thành công !!!');
            return redirect()->route('admin.customer.index');
        }
        request()->session()->flash('message', 'Cập nhật thất bại !!!');
        return redirect()->route('admin.customer.index');

    }

    public function delete($id)
    {
        if (isset($id)) {
            Customer::where('id', $id)->delete();
            request()->session()->flash('message', 'Xóa thành công !!!');
            return redirect()->route('admin.customer.index');
        }
        request()->session()->flash('message', 'Xóa thất bại !!!');
        return redirect()->route('admin.customer.index');
    }
}
