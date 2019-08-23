<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Shop\Campaigns\Campaign;
use App\Shop\Customer\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $todaySms = Customer::where('created_at', Carbon::today())->where('sms_log_id', '!=', null)->get()->count();
        //CareSoft
        $totalCS = Customer::where('care_soft_log_id', '!=', null)->count();
        $todayCS = Customer::where('created_at', Carbon::today())->where('care_soft_log_id', '!=', null)->get()->count();

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
}
