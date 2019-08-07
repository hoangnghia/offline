<?php

namespace App\Http\Controllers\Admin\Campaigns;

use App\Http\Controllers\Controller;
use App\Shop\Branchs\Branch;
use App\Shop\Campaigns\Campaign;
use App\Shop\Employees\Employee;
use App\Shop\Local\Local;
use App\Shop\Local\LocalUser;
use App\Shop\LocalCampaign\LocalCampaign;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = '';
        return view('admin.campaign.list', [
            'campaigns' => $list
        ]);
    }

    /*
     * Get list data Campaign
     * use : Datatable
     */
    public function getListData()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $campaign = DB::table('campaign as b')
            ->select('b.*')
            ->orderBy('b.created_at', 'desc');
        $datatables = DataTables::of($campaign);
        return $datatables->make(true);
    }

    /*
     * Add Campaign
     */
    public function getAddCampaign()
    {
        $branch = Branch::all();
        $local = Local::all();
        $agency = DB::table('employees as e')
            ->select('e.*')
            ->join('role_user as r', 'r.user_id', '=', 'e.id')
            ->where('r.role_id', 3)
            ->orderBy('e.created_at', 'desc')
            ->get();
        return view('admin.campaign.create', [
            'branch' => $branch,
            'local' => $local,
            'agency' => $agency
        ]);
    }

    public function postAddCampaign(Request $request)
    {
        if (isset($request)) {
            $campaign = new Campaign();
            $campaign->name = $request['name'];
            $campaign->note = $request['description'];
            $campaign->address = $request['customer-reason'];
            $campaign->taget = $request['taget'];
            $campaign->cost = $request['cost'];
            $campaign->agency_id = json_encode($request['agency-list']);
            $campaign->time_start = date('Y-m-d H:i:s', strtotime($request['set-start-date']));
            $campaign->time_end = date('Y-m-d H:i:s', strtotime($request['set-end-date']));
            $campaign->created_at = Carbon::now();
            $campaign->updated_at = Carbon::now();
            $campaign->save();
            foreach ($request['local-reason'] as $item) {
                $local_campaing = new  LocalCampaign();
                $local_campaing->local_id = $item;
                $local_campaing->campaign_id = $campaign['id'];
                $local_campaing->created_at = Carbon::now();
                $local_campaing->updated_at = Carbon::now();
                $local_campaing->save();
            }
            request()->session()->flash('message', 'Thêm thành công !!!');
            return redirect()->route('admin.campaigns.index');
        }
        request()->session()->flash('message', 'Thêm thất bại !!!');
        return redirect()->route('admin.campaigns.index');
    }

    public function status($id)
    {
        $branch = Campaign::where('id', $id)->first();
        if (!is_null($branch)) {
            $branch->status = !$branch->status;
            $branch->save();
            request()->session()->flash('message', 'Cập nhật thành công !!!');
            return redirect()->route('admin.campaigns.index');
        }
        request()->session()->flash('message', 'Cập nhật thất bại !!!');
        return redirect()->route('admin.campaigns.index');

    }

    public function delete($id)
    {
        if (isset($id)) {
            Campaign::where('id', $id)->delete();
            LocalCampaign::where('campaign_id', $id)->delete();
            request()->session()->flash('message', 'Xóa thành công !!!');
            return redirect()->route('admin.campaigns.index');
        }
        request()->session()->flash('message', 'Xóa thất bại !!!');
        return redirect()->route('admin.campaigns.index');

    }

    public function edit($id)
    {
        if (isset($id)) {
            $campaign = Campaign::where('id', $id)->first();
            $branch = Branch::all();
            $local = DB::table('local_campaign as l')
                ->select('l.*', 'w.branch_id','w.name','w.address')
                ->join('local as w', 'w.id', '=', 'l.local_id')
                ->where('l.campaign_id', $id)
                ->orderBy('l.created_at', 'desc')
                ->get();
            $user = DB::table('employees as e')
                ->select('e.*', 'r.role_id','r.user_id')
                ->join('role_user as r', 'r.user_id', '=', 'e.id')
                ->where('r.role_id', 3)
                ->orderBy('e.created_at', 'desc')
                ->get();
            return view('admin.campaign.edit', [
                'campaign' => $campaign,
                'branch' => $branch,
                'local' => $local,
                'user' => $user
            ]);
        }
        request()->session()->flash('message', 'ID không tồn tại hoặc Null !!!');
        return redirect()->route('admin.campaign.index');

    }
    public function user($id)
    {
        if (isset($id)) {
            $local = DB::table('local_campaign as l')
                ->select('l.*', 'w.branch_id','w.name','w.address')
                ->join('local as w', 'w.id', '=', 'l.local_id')
                ->where('l.campaign_id', $id)
                ->orderBy('l.created_at', 'desc')
                ->get();
            $user = DB::table('employees as e')
                ->select('e.*', 'r.role_id','r.user_id')
                ->join('role_user as r', 'r.user_id', '=', 'e.id')
                ->where('r.role_id', 3)
                ->orderBy('e.created_at', 'desc')
                ->get();
            return view('admin.campaign.user', [
                'local' => $local,
                'idcampaign' => $id,
                'user' => $user
            ]);
        }
        request()->session()->flash('message', 'ID không tồn tại hoặc Null !!!');
        return redirect()->route('admin.campaign.index');

    }
    public function postUserCampaign(Request $request)
    {

        $local = LocalCampaign::where('campaign_id',$request->idcampaign)->get();

        foreach ($local as $item)
        {
//            dd($request);
            $user = 'local'.$item->id.'_local_user';
            foreach ($request->$user as $itemUser)
            {
                $campaign = new LocalUser();
                $campaign->user_id = $itemUser;
                $campaign->local_id = $item->local_id;
                $campaign->campaign_id = $request->idcampaign;
                $campaign->created_at = Carbon::now();
                $campaign->updated_at = Carbon::now();
                $campaign->save();
            }
            $taget_post ='taget_local_'.$item->id;
            $taget = LocalCampaign::where('local_id',$item->local_id)->first();
            $taget->taget =  $request->$taget_post;
            $taget->save();
        }


        request()->session()->flash('message', 'Thêm thành công !!!');
        return redirect()->route('admin.campaigns.index');
    }
}
