<?php

namespace App\Http\Controllers\Admin\Branchs;

use App\Http\Controllers\Controller;
use App\Shop\Branchs\Branch;
use App\Shop\Campaigns\Campaign;
use App\Shop\Local\Local;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.branch.list');
    }

    public function getListData()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $customers = DB::table('branchs as b')
            ->select('b.*')
            ->orderBy('b.created_at', 'desc')->get();
//        dd($customers);
        $datatables = DataTables::of($customers);
        $datatables->addColumn('address_local', function ($model) {
            $local = Local::where('branch_id', $model->id)->get();
            $options = '';
            foreach ($local as $item) {
//                $options .= '<b>' . $item->name . '</b>';
                $options .= $item->name . ', ';
            }
            return $options;
        });
        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAddBranch()
    {
        return view('admin.branch.create');
    }

    public function postAddBranch(Request $request)
    {
        if ($request['name'] != null) {
            $local = '';
            if (isset($request['local'])) {
                $local = serialize($request['local']);
            }
            $branch = new Branch();
            $branch->name = $request['name'];
//            $branch->type = $request['type'];
            $branch->description = $request['description'];
            $branch->local = $local;
            $branch->created_at = Carbon::now();
            $branch->updated_at = Carbon::now();
            $branch->save();
            foreach ($request['local'] as $item) {
                $local = new Local();
                $local->branch_id = $branch->id;
                $local->name = $item['addmore'];
                $local->address = $item['addmore-address'];
                $local->type = $item['type'];
                $local->created_at = Carbon::now();
                $local->updated_at = Carbon::now();
                $local->save();
            }
            return json_encode([
                'result' => true,
            ]);
        }
        return json_encode([
            'result' => false,
        ]);
    }

    /**
     * Update phone number
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function status($id)
    {
        $branch = Branch::where('id', $id)->first();
        if (!is_null($branch)) {
            $branch->status = !$branch->status;
            $branch->save();
            request()->session()->flash('message', 'Cập nhật thành công !!!');
            return redirect()->route('admin.branch.index');
        }
        request()->session()->flash('message', 'Cập nhật thất bại !!!');
        return redirect()->route('admin.branch.index');

    }

    /**
     * Update phone number
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (isset($id)) {
            $check = Campaign::where('address', $id)->first();
            if (!isset($check)) {
                $branch = Branch::where('id', $id)->delete();
                $local = Local::where('branch_id', $id)->delete();
                request()->session()->flash('message', 'Xóa thành công !!!');
                return redirect()->route('admin.branch.index');
            }
            request()->session()->flash('error', 'Có liên kết, không thể xóa !!!');
            return redirect()->route('admin.branch.index');
        }
        request()->session()->flash('error', 'Xóa thất bại !!!');
        return redirect()->route('admin.branch.index');
    }

    /**
     * Update phone number
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function edit($id)
    {
        if (isset($id)) {
            $branch = Branch::where('id', $id)->first();
            $local = Local::where('branch_id', $id)->get();
            return view('admin.branch.edit', [
                'branch' => $branch,
                'local' => $local
            ]);
        }
        request()->session()->flash('message', 'ID không tồn tại hoặc Null !!!');
        return redirect()->route('admin.branch.index');
    }

    public function updateEditBranch(Request $request)
    {
        if ($request['name'] != null) {
            $local = '';
            if (isset($request['local'])) {
                $local = serialize($request['local']);
            }
            $branch = Branch::where('id', $request['id'])->first();
            $branch->name = $request['name'];
            $branch->description = $request['description'];
            $branch->local = $local;
            $branch->updated_at = Carbon::now();
            $branch->save();
            Local::where('branch_id', $request['id'])->delete();
            foreach ($request['local'] as $item) {
                $local = new Local();
                $local->branch_id = $branch->id;
                $local->name = $item['addmore'];
                $local->address = $item['addmore-address'];
                $local->type = $item['type'];
                $local->created_at = Carbon::now();
                $local->updated_at = Carbon::now();
                $local->save();
            }
            return json_encode([
                'result' => true,
            ]);
        }
        return json_encode([
            'result' => false,
        ]);
    }
}
