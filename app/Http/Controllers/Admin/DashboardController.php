<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Shop\Campaigns\Campaign;
use App\Shop\Customer\Customer;
use App\Shop\Local\Local;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DashboardController
{
    public function index()
    {
//        $breadcumb = [
//            ["name" => "Dashboard", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
//            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
//        ];
//        populate_breadcumb($breadcumb);
//       $campaign = Campaign::where('status',1)->get();
        $today = Carbon::now()->toDateString();

        $totalCampaign = Campaign::all()->count();
        $todayCampaign = Campaign::where('time_start', '>=', $today)->where('time_end', '<=', $today)->where('status', true)->get()->count();
        // khach hang
        $totalCustomer = Customer::all()->count();
        $todayCustomer = Customer::where('created_at', Carbon::today())->get()->count();
        // Tin nhan
        $totalSms = Customer::where('sms_log_id', '!=', null)->get()->count();
        $todaySms = Customer::where('updated_at', Carbon::today())->where('sms_log_id', '!=', null)->get()->count();
        //CareSoft
        $totalCS = Customer::where('care_soft_log_id', '!=', null)->count();
        $todayCS = Customer::where('updated_at', Carbon::today())->where('care_soft_log_id', '!=', null)->get()->count();


        return view('admin.dashboard', ['totalCampaign' => $totalCampaign,
            'todayCampaign' => $todayCampaign,
            'totalCustomer' => $totalCustomer,
            'todayCustomer' => $todayCustomer,
            'totalSms' => $totalSms,
            'todaySms' => $todaySms,
            'totalCS' => $totalCS,
            'todayCS' => $todayCS,
        ]);
    }

    public function getListDatCampaign()
    {
//       $a= DB::table('campaign as c')
//            ->join('local_user as ul', 'c.id', '=', 'ul.campaign_id')
//            ->leftJoin('customer as cu', 'ul.id', '=', 'cu.local_user_id')
//            ->select( DB::raw("count(cu.id) as count"),'c.name','c.taget')
//           ->where('')
//            ->groupBy('c.id','c.name','c.taget')
//            ->get();

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $campaign = DB::table('campaign as c')
            ->select('c.*')
            ->where('c.status', true)
        ->get();
//        dd($campaign);
        $datatables = DataTables::of($campaign);
        $datatables->addColumn('count', function ($model) {
            $user = DB::table('local_user as lu')
                ->select('lu.*')
                ->join('customer as c', 'c.local_user_id', '=', 'lu.id')
                ->where('lu.campaign_id', $model->id)
                ->count();
            return $user;
        });
        return $datatables->make(true);
    }
    public function getListDataUser()
    {

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $employees = DB::table('employees as e')
            ->select('e.*','l.campaign_id','l.id as local_id','l.local_id as local_idd','l.taget','ca.name as campaign_name')
            ->join('role_user as r', 'r.user_id', '=', 'e.id')
            ->join('local_user as l', 'l.user_id', '=', 'e.id')
            ->leftJoin('campaign as ca', 'ca.id', '=', 'l.campaign_id')
            ->where('r.role_id', 3)
            ->where('e.status', true)
            ->orderBy('e.created_at', 'desc')
            ->get();
        $datatables = DataTables::of($employees);
        $datatables->addColumn('count', function ($model) {
            $customer = DB::table('customer as c')
                ->select('c.*')
                ->where('c.local_user_id', $model->local_id)
                ->count();
            return $customer;
        });
        $datatables->addColumn('local_name', function ($model) {
            $customer = Local::where('id',$model->local_idd)->first();
            if (is_null($customer)){
                $customer= "Not name";
                return $customer;
            }else{
                return $customer->name;
            }
        });
        return $datatables->make(true);
    }
}
