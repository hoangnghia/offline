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


class CheckCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     **/
    public function index()
    {
        return view('admin.check.index');
    }
}
