<?php

namespace App\Http\Controllers\Admin\Agencys;

use App\Http\Controllers\Controller;
use App\Shop\Agency\Agency;
use App\Shop\Agency\EmployeesAgency;
use App\Shop\Campaigns\Campaign;
use App\Shop\Customer\Customer;
use App\Shop\Employees\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.agencys.list');
    }

    public function getListData()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $customers = DB::table('agency as a')
            ->select('a.*')
//            ->where('a.status',true)
            ->orderBy('a.created_at', 'desc');
        $datatables = DataTables::of($customers);
        $datatables->addColumn('list_user', function ($model) {
            $user = DB::table('employees_agency as ea')
                ->select('e.*')
                ->join('employees as e', 'e.id', '=', 'ea.employees_id')
                ->where('ea.agency_id', $model->id)
                ->orderBy('ea.created_at', 'desc')
                ->get();
            $listUsser = '';
            foreach ($user as $item) {
                $listUsser .= $item->name . ', ';
            }
//            dd($listUsser);
            return $listUsser;
        });
        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAddAgency()
    {
        $user = DB::table('employees as e')
            ->select('e.*', 'ea.employees_id')
            ->join('role_user as r', 'r.user_id', '=', 'e.id')
            ->leftJoin('employees_agency as ea', 'ea.employees_id', '=', 'e.id')
            ->where('r.role_id', 3)
            ->where('e.status', true)
            ->where('ea.employees_id', null)
            ->orderBy('e.created_at', 'desc')
            ->get();
        return view('admin.agencys.create', [
            'user' => $user
        ]);
    }

    public function postAddAgency(Request $request)
    {
        if (isset($request)) {
            $agency = new Agency();
            $agency->name = $request->name;
            $agency->phone = $request->phone;
            $agency->email = $request->email;
            $agency->address = $request->address;
            $agency->note = $request->description;
            $agency->created_at = Carbon::now();
            $agency->updated_at = Carbon::now();
            $agency->save();
            if (isset($agency->id)) {
                foreach ($request->agency_user as $item) {
                    $employeesAgency = new EmployeesAgency();
                    $employeesAgency->agency_id = $agency->id;
                    $employeesAgency->employees_id = $item;
                    $agency->created_at = Carbon::now();
                    $agency->updated_at = Carbon::now();
                    $agency->save();
                    $employeesAgency->save();
                }
            }
            request()->session()->flash('message', 'Thêm thành công !!!');
            return redirect()->route('admin.agencys.index');
        }
    }

    /**
     * Update phone number
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function status($id)
    {
        $agency = Agency::where('id', $id)->first();
        if (!is_null($agency)) {
            $agency->status = !$agency->status;
            $agency->save();
            request()->session()->flash('message', 'Cập nhật thành công !!!');
            return redirect()->route('admin.agencys.index');
        }
        request()->session()->flash('message', 'Cập nhật thất bại !!!');
        return redirect()->route('admin.agencys.index');
    }

    /**
     * Update phone number
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {

        if (isset($id)) {
            $check = Campaign::where('agency_id', $id)->first();
            if (!isset($check)) {
                $agency = Agency::where('id', $id)->delete();
                $employeesAgency = EmployeesAgency::where('agency_id', $id)->delete();
                request()->session()->flash('message', 'Xóa thành công !!!');
                return redirect()->route('admin.agencys.index');
            }
            request()->session()->flash('error', 'Có liên kết, không thể xóa !!!');
            return redirect()->route('admin.agencys.index');
        }
        request()->session()->flash('error', 'Xóa thất bại !!!');
        return redirect()->route('admin.agencys.index');
    }

    /**
     * Update phone number
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function edit($id)
    {
        if (isset($id)) {
            $user = DB::table('employees as e')
                ->select('e.*', 'ea.employees_id')
                ->join('role_user as r', 'r.user_id', '=', 'e.id')
                ->leftJoin('employees_agency as ea', 'ea.employees_id', '=', 'e.id')
                ->where('r.role_id', 3)
                ->where('e.status', true)
                ->orderBy('e.created_at', 'desc')
                ->get();
            $agency = Agency::where('id', $id)->first();
            $employeesAgency = EmployeesAgency::where('agency_id', $agency->id)->get();
//dd($user);
            return view('admin.agencys.edit', [
                'agency' => $agency,
                'employeesAgency' => $employeesAgency,
                'user' => $user

            ]);
        }
        request()->session()->flash('message', 'ID không tồn tại hoặc Null !!!');
        return redirect()->route('admin.agencys.index');

    }

    public function destroy(Request $request)
    {
        if (isset($request)) {
            $agency = Agency::where('id', $request->id)->first();
            $agency->name = $request->name;
            $agency->phone = $request->phone;
            $agency->email = $request->email;
            $agency->address = $request->address;
            $agency->note = $request->description;
            $agency->created_at = Carbon::now();
            $agency->updated_at = Carbon::now();
            $agency->save();
            if (isset($agency->id)) {
                EmployeesAgency::where('agency_id', $request->id)->delete();
                foreach ($request->agency_user as $item) {
                    $employeesAgency = new EmployeesAgency();
                    $employeesAgency->agency_id = $agency->id;
                    $employeesAgency->employees_id = $item;
                    $employeesAgency->created_at = Carbon::now();
                    $employeesAgency->updated_at = Carbon::now();
                    $employeesAgency->save();
                }
            }
            request()->session()->flash('message', 'Thêm thành công !!!');
            return redirect()->route('admin.agencys.index');
        }
    }
}
