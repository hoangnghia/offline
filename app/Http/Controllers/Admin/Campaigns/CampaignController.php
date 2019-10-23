<?php

namespace App\Http\Controllers\Admin\Campaigns;

use App\Http\Controllers\Controller;
use App\Shop\Agency\Agency;
use App\Shop\Branchs\Branch;
use App\Shop\Campaigns\Campaign;
use App\Shop\Employees\Employee;
use App\Shop\Local\Local;
use App\Shop\Local\LocalUser;
use App\Shop\LocalCampaign\LocalCampaign;
use App\Shop\Service\LocalServices;
use App\Shop\Service\Service;
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
        $campaign = DB::table('campaign as c')
            ->select('c.*', 'b.name as branch_name')
            ->join('branchs as b', 'b.id', '=', 'c.address')
            ->orderBy('c.created_at', 'desc');
        $datatables = DataTables::of($campaign);
        $datatables->addColumn('status-type', function ($model) {
            $a = Carbon::now()->toDateString();
            if ($a >= $model->time_start && $a <= $model->time_end) {
                $status = 1;
            } elseif ($model->time_start < $a) {
                $status = 2;
            } else {
                $status = 3;
            }
            return $status;
        });
        return $datatables->make(true);
    }

    /*
     * Add Campaign
     */
    public function getAddCampaign()
    {
        $branch = Branch::all();
        $local = Local::all();
        $agency = Agency::all();
        return view('admin.campaign.create', [
            'branch' => $branch,
            'local' => $local,
            'agency' => $agency
        ]);
    }

    public function postAddCampaign(Request $request)
    {
        if (isset($request)) {
            if (!isset($request['agency'])) {
                request()->session()->flash('error', 'Oh ! Có vẻ bạn chưa chọn đối tác !!!');
                return redirect()->route('admin.campaign.create');
            }
            if (!isset($request['customer-reason'])) {
                request()->session()->flash('error', 'Oh ! Có vẻ bạn chưa chọn địa chỉ, Hãy chọn địa chỉ bạn nhé !!!');
                return redirect()->route('admin.campaign.create');
            }
            if (!isset($request['local-reason'])) {
                request()->session()->flash('error', 'Oh ! Có vẻ bạn chưa chọn siêu thị hoặc chợ !!!');
                return redirect()->route('admin.campaign.create');
            }
            $campaign = new Campaign();
            $campaign->name = $request['name'];
            $campaign->note = $request['description'];
            $campaign->address = $request['customer-reason'];
            $campaign->taget = $request['taget'];
            $campaign->age = $request['age'];
            $campaign->agency_id = $request['agency'];
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
            return redirect('admin/campaign/user/' . $campaign->id);
        }
        request()->session()->flash('error', 'Thêm thất bại !!!');
        return redirect()->route('admin.campaigns.index');
    }

    public function postEditCampaign(Request $request)
    {
        if (isset($request)) {

            $campaign = Campaign::where('id', $request->campaign_id)->first();
            $campaign->name = $request->name;
            $campaign->note = $request->description;
            $campaign->taget = $request->taget;
            $campaign->age = $request->age;
//            $campaign->agency_id = $request->agency;
            $campaign->time_start = date('Y-m-d H:i:s', strtotime($request->set_start_date));
            $campaign->time_end = date('Y-m-d H:i:s', strtotime($request->set_end_date));
            $campaign->created_at = Carbon::now();
            $campaign->updated_at = Carbon::now();
            $campaign->save();
            foreach ($request->local_reason as $item) {
                $check = LocalCampaign::where('local_id', $item)->where('campaign_id', $request->campaign_id)->first();
                if (!isset($check)) {
                    $local_campaing = new  LocalCampaign();
                    $local_campaing->local_id = $item;
                    $local_campaing->campaign_id = $request->campaign_id;
                    $local_campaing->created_at = Carbon::now();
                    $local_campaing->updated_at = Carbon::now();
                    $local_campaing->save();
                }
            }
            request()->session()->flash('message', 'Thêm thành công !!!');
            return redirect('admin/campaign/user/' . $campaign->id);
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
//            $check = LocalUser::where('campaign_id',$id)->first();
            $check = DB::table('local_user as l')
                ->select('c.*')
                ->join('customer as c', 'c.local_user_id', '=', 'l.id')
                ->where('campaign_id', $id)
                ->first();
//            dd($check);
            if (!isset($check)) {
                Campaign::where('id', $id)->delete();
                LocalCampaign::where('campaign_id', $id)->delete();
                request()->session()->flash('message', 'Xóa thành công !!!');
                return redirect()->route('admin.campaigns.index');
            }
            request()->session()->flash('error', 'Chiến dịch có khách hàng, không được xóa !!!');
            return redirect()->route('admin.campaigns.index');
        }
        request()->session()->flash('error', 'Xóa thất bại !!!');
        return redirect()->route('admin.campaigns.index');
    }

    public function edit($id)
    {
        if (isset($id)) {
            $campaign = Campaign::where('id', $id)->first();

            $branch = Branch::all();
            $branchList = DB::table('branchs as b')
                ->select('b.*', 'l.name as local_name', 'l.id as local_id')
                ->join('local as l', 'l.branch_id', '=', 'b.id')
                ->where('b.id', $campaign->address)
                ->orderBy('l.created_at', 'desc')
                ->get();
            $local = DB::table('local_campaign as l')
                ->select('l.*', 'w.branch_id', 'w.name', 'w.address')
                ->join('local as w', 'w.id', '=', 'l.local_id')
                ->where('l.campaign_id', $id)
                ->orderBy('l.created_at', 'desc')
                ->get();
//            dd($local);

//            $user = DB::table('employees as e')
//                ->select('e.*', 'r.role_id', 'r.user_id')
//                ->join('role_user as r', 'r.user_id', '=', 'e.id')
//                ->where('r.role_id', 3)
//                ->orderBy('e.created_at', 'desc')
//                ->get();
            return view('admin.campaign.edit', [
                'campaign' => $campaign,
                'branch' => $branch,
                'local' => $local,
                'branchList' => $branchList
//                'user' => $user
            ]);
        }
        request()->session()->flash('message', 'ID không tồn tại hoặc Null !!!');
        return redirect()->route('admin.campaign.index');

    }

    public function user($id)
    {
        if (isset($id)) {
//            $campaignUser = LocalUser::where('campaign_id',$id)->get();
            $campaign = DB::table('campaign as c')
                ->select('c.*', 'b.name as name_branchs', 'c.name as agency_name')
                ->join('branchs as b', 'b.id', '=', 'c.address')
                ->join('agency as a', 'a.id', '=', 'c.agency_id')
                ->where('c.id', $id)
                ->first();
            $local = DB::table('local_campaign as l')
                ->select('l.*', 'w.branch_id', 'w.name', 'w.address')
                ->join('local as w', 'w.id', '=', 'l.local_id')
                ->where('l.campaign_id', $id)
                ->orderBy('l.created_at', 'desc')
                ->get();
            $user = DB::table('employees as e')
                ->select('e.*', 'ea.agency_id')
                ->join('employees_agency as ea', 'ea.employees_id', '=', 'e.id')
                ->where('ea.agency_id', $campaign->agency_id)
                ->orderBy('e.created_at', 'desc')
                ->get();
            $service = Service::where('status', true)->get();
            $localUser = LocalUser::where('campaign_id', $campaign->id)->get();
            $localServices = LocalServices::where('campaign_id', $campaign->id)->get();
//        dd($local);

            return view('admin.campaign.user', [
                'local' => $local,
                'idcampaign' => $id,
                'campaign' => $campaign,
                'service' => $service,
                'localServices' => $localServices,
                'localUser' => $localUser,
                'user' => $user
            ]);
        }
        request()->session()->flash('message', 'ID không tồn tại hoặc Null !!!');
        return redirect()->route('admin.campaign.index');
    }


    public function postUserCampaign(Request $request)
    {
        $local = LocalCampaign::where('campaign_id', $request->idcampaign)->get();
        foreach ($local as $item) {
            $user = 'local' . $item->id . '_local_user';
            if (isset($request->$user)) {
                $taget_post = 'taget_local_' . $item->id;
                $tagetUser = $request->$taget_post / count($request->$user);
                foreach ($request->$user as $itemUser) {
                    $check = LocalUser::where('user_id', $itemUser)->where('local_id', $item->local_id)->where('campaign_id', $request->idcampaign)->first();
//                    LocalUser::where('local_id', $item->local_id)->where('campaign_id', $request->idcampaign)->where('user_id', $itemUser)->delete();
                    if (!isset($check)) {
                        $campaign = new LocalUser();
                        $campaign->user_id = $itemUser;
                        $campaign->local_id = $item->local_id;
                        $campaign->local_campaign_id = $item->id;
                        $campaign->taget = round($tagetUser);
                        $campaign->campaign_id = $request->idcampaign;
                        $campaign->created_at = Carbon::now();
                        $campaign->updated_at = Carbon::now();
                        $campaign->save();
                    }
                }
                $taget = LocalCampaign::where('local_id', $item->local_id)->first();
                $taget->taget = $request->$taget_post;
                $taget->save();
                $service = 'services-' . $item->id;
                foreach ($request->$service as $itemService) {
                    $check = LocalServices::where('service_id', $itemService)->where('local_id', $item->local_id)->where('campaign_id', $request->idcampaign)->first();
                    if (!isset($check)) {
                        $serviceLocal = new LocalServices();
                        $serviceLocal->service_id = $itemService;
                        $serviceLocal->local_id = $item->local_id;
                        $serviceLocal->campaign_id = $request->idcampaign;
                        $serviceLocal->created_at = Carbon::now();
                        $serviceLocal->updated_at = Carbon::now();
                        $serviceLocal->save();
                    }
                }
            } else {
                request()->session()->flash('error', 'Bạn chưa chọn nhân viên !!!');
                return redirect('admin/campaign/user/' . $request->idcampaign);
            }
        }
        request()->session()->flash('message', 'Thêm thành công !!!');
        return redirect()->route('admin.campaigns.index');
    }
}
