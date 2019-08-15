<?php

namespace App\Http\Controllers\Admin\Customers;

use App\Shop\Campaigns\Campaign;
use App\Shop\Customer\Customer;
use App\Shop\Customers\Transformations\CustomerTransformable;
use App\Http\Controllers\Controller;
use App\Shop\Employees\Employee;
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
        $campaign = Campaign::all();
        $employees = DB::table('employees as e')
            ->select('e.*')
            ->join('role_user as ru', 'ru.user_id', '=', 'e.id')
            ->where('ru.role_id', 3)
            ->orderBy('e.created_at', 'desc')
            ->get();
        return view('admin.customers.list', [
            'campaign' => $campaign,
            'employees' => $employees
        ]);
    }

    /*
     * Get list data Campaign
     * use : Datatable
     */
    public function getListData()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $toDate = (new \DateTime(now()))->format('Y-m-d');
        $customer = DB::table('customer as c')
            ->select('c.*', 's.name as service_name', 'ca.name as campaign_name', 'e.name as employees_name')
            ->join('local_user as lu', 'lu.id', '=', 'c.local_user_id')
            ->join('services as s', 's.id', '=', 'c.service')
            ->join('campaign as ca', 'ca.id', '=', 'lu.campaign_id')
            ->join('employees as e', 'e.id', '=', 'lu.user_id');
//            ->orderBy('c.created_at', 'desc')
//            ->get();
        $datatables = DataTables::of($customer);
        if (!is_null($datatables->request->get('name'))) {
            $customer->where('c.name', 'LIKE', '%' . $datatables->request->get('name') . '%');
        }
        if (!is_null($datatables->request->get('phone'))) {
            $customer->where('c.phone', 'LIKE', '%' . $datatables->request->get('phone') . '%');
        }
        if (!is_null($datatables->request->get('campaign'))) {
            if (is_array($datatables->request->get('campaign')))
                $customer->whereIn('ca.id', $datatables->request->get('campaign'));
            else
                $customer->where('ca.id', $datatables->request->get('campaign'));
        }
        if (!is_null($datatables->request->get('user'))) {
            if (is_array($datatables->request->get('user')))
                $customer->whereIn('e.id', $datatables->request->get('user'));
            else
                $customer->where('e.id', $datatables->request->get('user'));
        }
        if (!is_null($datatables->request->get('created_at'))) {
            $dateTimeArr = explode('-', $datatables->request->get('created_at'));
            $fromDate = trim($dateTimeArr[0]);
            $toDate = trim($dateTimeArr[1]);
            $fromDate = (new \DateTime($fromDate))->format('Y-m-d');
            $toDate = (new \DateTime($toDate))->format('Y-m-d');
            $customer->whereDate('c.created_at', '>=', $fromDate);
            $customer->whereDate('c.created_at', '<=', $toDate);
        } else {
            $customer->whereDate('c.created_at', '=', $toDate);
        }
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
            $paren = Customer::where('parent_id', $id)->first();

            if (isset($paren)) {
                request()->session()->flash('error', 'Có người thân !!!');
                return redirect()->route('admin.customer.index');
            } else {
                Customer::where('id', $id)->delete();
                request()->session()->flash('message', 'Xóa thành công !!!');
                return redirect()->route('admin.customer.index');
            }
        }
        request()->session()->flash('error', 'Xóa thất bại !!!');
        return redirect()->route('admin.customer.index');
    }
}
