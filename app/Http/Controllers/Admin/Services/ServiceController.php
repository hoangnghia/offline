<?php

namespace App\Http\Controllers\Admin\Services;

use App\Http\Controllers\Controller;
use App\Shop\Service\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.services.list');
    }

    public function getListData()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $customers = DB::table('services as s')
            ->select('s.*')
            ->orderBy('s.created_at', 'desc');
        $datatables = DataTables::of($customers);
        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAddService()
    {
        return view('admin.services.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAddService(Request $request)
    {

        if (isset($request->name)) {
            $service = new Service();
            $service->name = $request->name;
            $service->descriptions = $request->description;
            $service->created_at = Carbon::now();
            $service->updated_at = Carbon::now();
            $service->save();
            request()->session()->flash('message', 'Thêm thành công !!!');
            return redirect()->route('admin.services.create');
        }
        request()->session()->flash('error', 'Lỗi ! Không thêm được !!!');
        return redirect()->route('admin.services.create');
    }

    /**
     * Update phone number
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function status($id)
    {
        $service = Service::where('id', $id)->first();
        if (!is_null($service)) {
            $service->status = !$service->status;
            $service->save();
            request()->session()->flash('message', 'Cập nhật thành công !!!');
            return redirect()->route('admin.services.index');
        }
        request()->session()->flash('error', 'Cập nhật thất bại !!!');
        return redirect()->route('admin.services.index');
    }

    /**
     * Update phone number
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {

        if (isset($id)) {
            $services = Service::where('id', $id)->delete();
            request()->session()->flash('message', 'Xóa thành công !!!');
            return redirect()->route('admin.services.index');
        }
        request()->session()->flash('error', 'Xóa thất bại !!!');
        return redirect()->route('admin.services.index');
    }

    /**
     * Update phone number
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function edit($id)
    {
        if (isset($id)) {
            $services = Service::where('id', $id)->first();
            return view('admin.services.create', [
                'services' => $services
            ]);
        }
        request()->session()->flash('error', 'ID không tồn tại hoặc Null !!!');
        return redirect()->route('admin.services.index');
    }

    public function destroy(Request $request)
    {
//        dd($request);
        if (isset($request->id)) {
            $services = Service::where('id', $request->id)->first();
            $services->name = $request->name;;
            $services->descriptions = $request->description;
            $services->updated_at = Carbon::now();
            $services->save();
            request()->session()->flash('message', 'Thêm thành công !!!');
            return redirect()->route('admin.services.index');
        }
        request()->session()->flash('error', 'Lỗi ! Không thêm được !!!');
        return redirect()->route('admin.services.index');
    }
}
