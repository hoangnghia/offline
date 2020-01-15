<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Shop\Branchs\Branch;
use App\Shop\Campaigns\Campaign;
use App\Shop\Customer\Customer;
use App\Shop\Customer\CustomerIntroduce;
use App\Shop\Employees\Employee;
use App\Shop\Local\Local;
use App\User;
use Carbon\Carbon;
//use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

use App\Exports\CustomerExport;

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
        $todayCustomer = Customer::where('created_at', '>=', $today)->get()->count();
        // Tin nhan
        $totalSms = Customer::where('sms_log_id', '!=', null)->get()->count();
        $todaySms = Customer::where('updated_at', '>=', $today)->where('sms_log_id', '!=', null)->get()->count();
        //CareSoft
        $totalCS = Customer::where('care_soft_log_id', '!=', null)->count();
        $todayCS = Customer::where('updated_at', '>=', $today)->where('care_soft_log_id', '!=', null)->get()->count();

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
//            ->where('c.status', true)
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
        $datatables->addColumn('caresoft', function ($model) {
            $user = DB::table('local_user as lu')
                ->select('lu.*')
                ->join('customer as c', 'c.local_user_id', '=', 'lu.id')
                ->where('lu.campaign_id', $model->id)
                ->whereNotNull('c.ticket_id')
                ->count();
            return $user;
        });
        $datatables->addColumn('sms', function ($model) {
            $user = DB::table('local_user as lu')
                ->select('lu.*')
                ->join('customer as c', 'c.local_user_id', '=', 'lu.id')
                ->where('lu.campaign_id', $model->id)
                ->whereNotNull('c.sms_log_id')
                ->count();
            return $user;
        });
        return $datatables->make(true);
    }

    public function getListDataUser()
    {

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $employees = DB::table('employees as e')
            ->select('e.*', 'l.campaign_id', 'l.id as local_id', 'l.local_id as local_idd', 'l.taget', 'ca.name as campaign_name')
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
            $customer = Local::where('id', $model->local_idd)->first();
            if (is_null($customer)) {
                $customer = "Not name";
                return $customer;
            } else {
                return $customer->name;
            }
        });
        return $datatables->make(true);
    }

    public function indexCCS()
    {
        $campaign = Campaign::all();
        $employees = DB::table('employees as e')
            ->select('e.*')
            ->join('role_user as ru', 'ru.user_id', '=', 'e.id')
            ->where('ru.role_id', 3)
            ->orderBy('e.created_at', 'desc')
            ->get();
        return view('admin.ccs', [
            'campaign' => $campaign,
            'employees' => $employees
        ]);
    }

    public function getListDataIntroduce()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $toDate = (new \DateTime(now()))->format('Y-m-d');
        $customer = DB::table('customer_introduce as c')
            ->select('c.*')
            ->orderBy('c.created_at', 'desc');
        $datatables = DataTables::of($customer);
        if (!is_null($datatables->request->get('name'))) {
            $customer->where('c.name', 'LIKE', '%' . $datatables->request->get('name') . '%');
        }
        if (!is_null($datatables->request->get('phone'))) {
            $customer->where('c.phone', 'LIKE', '%' . $datatables->request->get('phone') . '%');
        }
        if (!is_null($datatables->request->get('phone_introduce'))) {
            $customer->where('c.phone_introduce', 'LIKE', '%' . $datatables->request->get('phone_introduce') . '%');
        }
        if (!is_null($datatables->request->get('status_moon'))) {
            if (is_array($datatables->request->get('status_moon')))
                $customer->whereIn('c.status_moon', $datatables->request->get('status_moon'));
            else
                $customer->where('c.status_moon', $datatables->request->get('status_moon'));
        }
        if (!is_null($datatables->request->get('created_at'))) {
            $dateTimeArr = explode('-', $datatables->request->get('created_at'));
            $fromDate = trim($dateTimeArr[0]);
            $toDate = trim($dateTimeArr[1]);
            $fromDate = (new \DateTime($fromDate))->format('Y-m-d');
            $toDate = (new \DateTime($toDate))->format('Y-m-d');
            $customer->whereDate('c.created_at', '>=', $fromDate);
            $customer->whereDate('c.created_at', '<=', $toDate);
        }
        $datatables->addColumn('cskh_name', function ($model) {
            if (!is_null($model->care_ccs)) {
                $user = Employee::where('id', $model->care_ccs)->first();
                return $user->name;
            }
            return '(Not set)';
        });
        $datatables->addColumn('offline_name', function ($model) {
            if (!is_null($model->care_offline)) {
                $user = Employee::where('id', $model->care_offline)->first();
                return $user->name;
            }
            return '(Not set)';
        });
        $datatables->addColumn('branch_name', function ($model) {
            if (!is_null($model->branch)) {
                $chinhanh = '';
                switch ($model->branch) {
                    case '43':
                        $chinhanh = 'Biên Hòa';
                        break;
                    case '40':
                        $chinhanh = 'Vũng Tàu';
                        break;
                    case '38':
                        $chinhanh = 'Cần Thơ';
                        break;
                    case '41':
                        $chinhanh = 'Nha Trang';
                        break;
                    case '42':
                        $chinhanh = 'Đà Nẵng';
                        break;
                    case '36':
                        $chinhanh = 'Hà Nội';
                        break;
                    case '37':
                        $chinhanh = 'Hải Phòng';
                        break;
                    case '35':
                        $chinhanh = 'Buôn Ma Thuột';
                        break;
                    case '39':
                        $chinhanh = 'Bình Dương';
                        break;
                    case '44':
                        $chinhanh = 'Phan Thiết';
                        break;
                    case '45':
                        $chinhanh = 'Quảng Ninh';
                        break;
                    case '46':
                        $chinhanh = 'Vinh';
                        break;
                    case '1':
                        $chinhanh = 'Hồ Chí Minh 3/2';
                        break;
                    case '51':
                        $chinhanh = 'Trần Hưng Đạo';
                        break;
                    case '52':
                        $chinhanh = 'Đinh Tiên Hoàng';
                        break;
                    case '54':
                        $chinhanh = 'Nguyễn Thị Minh Khai';
                        break;
                    case '55':
                        $chinhanh = 'Nguyễn Thị Thập';
                        break;
                    case '53':
                        $chinhanh = 'Hà Nội Trần Duy Hưng';
                        break;
                }
                return $chinhanh;
            }
            return '(Not set)';
        });
        return $datatables->make(true);
    }

    public function indexOffline()
    {
        $campaign = Campaign::all();
        $employees = DB::table('employees as e')
            ->select('e.*')
            ->join('role_user as ru', 'ru.user_id', '=', 'e.id')
            ->where('ru.role_id', 3)
            ->orderBy('e.created_at', 'desc')
            ->get();
        return view('admin.offline', [
            'campaign' => $campaign,
            'employees' => $employees
        ]);
    }

    public function getListDataIntroduceOffline()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $toDate = (new \DateTime(now()))->format('Y-m-d');
        $customer = DB::table('customer_introduce as c')
            ->select('c.*')
            ->orderBy('c.created_at', 'desc');
        $datatables = DataTables::of($customer);
        if (!is_null($datatables->request->get('name'))) {
            $customer->where('c.name', 'LIKE', '%' . $datatables->request->get('name') . '%');
        }
        if (!is_null($datatables->request->get('phone'))) {
            $customer->where('c.phone', 'LIKE', '%' . $datatables->request->get('phone') . '%');
        }
        if (!is_null($datatables->request->get('phone_introduce'))) {
            $customer->where('c.phone_introduce', 'LIKE', '%' . $datatables->request->get('phone_introduce') . '%');
        }
        if (!is_null($datatables->request->get('status_moon'))) {
            if (is_array($datatables->request->get('status_moon')))
                $customer->whereIn('c.status_moon', $datatables->request->get('status_moon'));
            else
                $customer->where('c.status_moon', $datatables->request->get('status_moon'));
        }
        if (!is_null($datatables->request->get('created_at'))) {
            $dateTimeArr = explode('-', $datatables->request->get('created_at'));
            $fromDate = trim($dateTimeArr[0]);
            $toDate = trim($dateTimeArr[1]);
            $fromDate = (new \DateTime($fromDate))->format('Y-m-d');
            $toDate = (new \DateTime($toDate))->format('Y-m-d');
            $customer->whereDate('c.created_at', '>=', $fromDate);
            $customer->whereDate('c.created_at', '<=', $toDate);
        }
        $datatables->addColumn('cskh_name', function ($model) {
            if (!is_null($model->care_ccs)) {
                $user = Employee::where('id', $model->care_ccs)->first();
                return $user->name;
            }
            return '(Not set)';
        });
        $datatables->addColumn('offline_name', function ($model) {
            if (!is_null($model->care_offline)) {
                $user = Employee::where('id', $model->care_offline)->first();
                return $user->name;
            }
            return '(Not set)';
        });
        $datatables->addColumn('branch_name', function ($model) {
            if (!is_null($model->branch)) {
                $chinhanh = '';
                switch ($model->branch) {
                    case '43':
                        $chinhanh = 'Biên Hòa';
                        break;
                    case '40':
                        $chinhanh = 'Vũng Tàu';
                        break;
                    case '38':
                        $chinhanh = 'Cần Thơ';
                        break;
                    case '41':
                        $chinhanh = 'Nha Trang';
                        break;
                    case '42':
                        $chinhanh = 'Đà Nẵng';
                        break;
                    case '36':
                        $chinhanh = 'Hà Nội';
                        break;
                    case '37':
                        $chinhanh = 'Hải Phòng';
                        break;
                    case '35':
                        $chinhanh = 'Buôn Ma Thuột';
                        break;
                    case '39':
                        $chinhanh = 'Bình Dương';
                        break;
                    case '44':
                        $chinhanh = 'Phan Thiết';
                        break;
                    case '45':
                        $chinhanh = 'Quảng Ninh';
                        break;
                    case '46':
                        $chinhanh = 'Vinh';
                        break;
                    case '1':
                        $chinhanh = 'Hồ Chí Minh 3/2';
                        break;
                    case '51':
                        $chinhanh = 'Trần Hưng Đạo';
                        break;
                    case '52':
                        $chinhanh = 'Đinh Tiên Hoàng';
                        break;
                    case '54':
                        $chinhanh = 'Nguyễn Thị Minh Khai';
                        break;
                    case '55':
                        $chinhanh = 'Nguyễn Thị Thập';
                        break;
                    case '53':
                        $chinhanh = 'Hà Nội Trần Duy Hưng';
                        break;
                }

                return $chinhanh;
            }
            return '(Not set)';
        });
        return $datatables->make(true);
    }

    public function postListIntroduce(Request $request)
    {
        if (isset($request->phone) && isset($request->name)) {
            $chinhanh = '';
            if (isset($request->branch)) {
                switch ($request->branch) {
                    case 'Nha Trang':
                        $chinhanh = '41';
                        break;
                    case 'Đà Nẵng':
                        $chinhanh = '42';
                        break;
                    case 'Buôn Ma Thuột':
                        $chinhanh = '35';
                        break;
                    case 'Phan Thiết':
                        $chinhanh = '44';
                        break;
                    case 'Vinh':
                        $chinhanh = '46';
                        break;
                    case 'Quảng Ninh':
                        $chinhanh = '45';
                        break;
                    case 'Hải Phòng':
                        $chinhanh = '37';
                        break;
                    case 'Hà Nội':
                        $chinhanh = '36';
                        break;
                    case 'Hà Nội Trần Duy Hưng':
                        $chinhanh = '53';
                        break;
                    case 'Biên Hòa':
                        $chinhanh = '43';
                        break;
                    case 'Vũng Tàu':
                        $chinhanh = '40';
                        break;
                    case 'Cần Thơ':
                        $chinhanh = '38';
                        break;
                    case 'Bình Dương':
                        $chinhanh = '39';
                        break;
                    case 'Hồ Chí Minh 3/2':
                        $chinhanh = '1';
                        break;
                    case 'Trần Hưng Đạo':
                        $chinhanh = '51';
                        break;
                    case 'Đinh Tiên Hoàng':
                        $chinhanh = '52';
                        break;
                    case 'Nguyễn Thị Minh Khai':
                        $chinhanh = '54';
                        break;
                    case 'Nguyễn Thị Thập':
                        $chinhanh = '55';
                        break;
                }
            }
            $phone = $request->phone;
            if (substr($phone, 0, 2) == '84') {
                $phone = substr($phone, 2);
            }
            if (substr($phone, 0, 1) != 0) {
                $phone = '0' . $phone;
            }
            $user_id = Auth::guard('employee')->user();
            $phone = $this->convertPhone($phone);
            $url = 'http://api.ngocdunggroup.com/api/v1/Customers/checkphone?apiKey=M6d6RjYyhrBnUzg6HXnw3VJ&phone=' . $phone . '';
            $checkMoon = $this->httpFB(strip_tags($url));
            $moon = json_decode($checkMoon['data'], true);

            $add = new CustomerIntroduce();
            $add->name = $request->name;
            $add->phone = $request->phone;
            $add->birthday = $request->birthday;
            $add->branch = $chinhanh;
            $add->name_introduce = $request->name_introduce;
            $add->phone_introduce = $request->phone_introduce;
            $add->care_ccs = $user_id->id;
            if (isset($moon['Total']) && $moon['Total'] != 0) {
                $add->status_moon = 2;
            } else {
                $add->status_moon = 1;
            }

            $add->note = $request->note;
            $add->created_at = Carbon::now();
            $add->updated_at = Carbon::now();
            $add->status = 999;
            $add->save();
            request()->session()->flash('message', 'Thêm thành công phiếu ghi !!!');
            return redirect('admin/cskh');
        }
        request()->session()->flash('error', 'Thêm phiếu ghi thất bại !!!');
        return redirect('admin/cskh');
    }

    public function convertPhone($source)
    {
        $source = str_replace("+", "", $source);
        $result = $source;
        if (strlen($source) > 11) {
            if (substr($source, 0, 2) == "84") {
                $source = substr($source, 1) != "0" ? str_replace("84", "0", $source) : str_replace("84", "", $source);
                $result = $source;
            }
        }
        if (strlen($source) == 10) {
            return $source;
        } else if (strlen($source) == 11) {

            $prefix = substr($source, 0, 4);
            $suffix = substr($source, 4, strlen($source) - 4);

            switch (substr($source, 1, 3)) {
                /// Mobifone
                case "120":
                    $result = str_replace("0120", "070", $prefix) . $suffix;
                    break;
                case "121":
                    $result = str_replace("0121", "079", $prefix) . $suffix;
                    break;
                case "122":
                    $result = str_replace("0122", "077", $prefix) . $suffix;
                    break;
                case "126":
                    $result = str_replace("0120", "076", $prefix) . $suffix;
                    break;
                case "128":
                    $result = str_replace("0128", "078", $prefix) . $suffix;
                    break;
                /// Vinaphone
                case "123":
                    $result = str_replace("0123", "083", $prefix) . $suffix;
                    break;
                case "124":
                    $result = str_replace("0124", "084", $prefix) . $suffix;
                    break;
                case "125":
                    $result = str_replace("0125", "085", $prefix) . $suffix;
                    break;
                case "127":
                    $result = str_replace("0127", "081", $prefix) . $suffix;
                    break;
                case "129":
                    $result = str_replace("0129", "082", $prefix) . $suffix;
                    break;
                /// Viettel
                case "162":
                    $result = str_replace("0162", "032", $prefix) . $suffix;
                    break;
                case "163":
                    $result = str_replace("0163", "033", $prefix) . $suffix;
                    break;
                case "164":
                    $result = str_replace("0164", "034", $prefix) . $suffix;
                    break;
                case "165":
//                    dd($prefix);
                    $result = str_replace("0165", "035", $prefix) . $suffix;
                    break;
                case "166":
                    $result = str_replace("0166", "036", $prefix) . $suffix;
                    break;
                case "167":
                    $result = str_replace("0167", "037", $prefix) . $suffix;
                    break;
                case "168":
                    $result = str_replace("0168", "038", $prefix) . $suffix;
                    break;
                case "169":
                    $result = str_replace("0169", "039", $prefix) . $suffix;
                    break;
                /// Vietnamemobile
                case "186":
                    $result = str_replace("0186", "056", $prefix) . $suffix;
                    break;
                case "188":
                    $result = str_replace("0188", "058", $prefix) . $suffix;
                    break;
                /// Gtel
                case "199":
                    $result = str_replace("0199", "059", $prefix) . $suffix;
                    break;
            }
        }
        return $result;
    }

    public function httpFB($url)
    {

        $timeout = 30;
        $connectTimeout = 30;
        $sslVerifyPeer = false;

        $response = array();
        $ci = curl_init();

        /* Curl settings */
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
        curl_setopt($ci, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ci, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json"));
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $sslVerifyPeer);
        curl_setopt($ci, CURLOPT_URL, $url);

        $response['http_code'] = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        $response['api_call'] = $url;
        $response['data'] = curl_exec($ci);

        curl_close($ci);

        return $response;
    }

    public function crm(Request $request)
    {
        $list = explode(",", $request['list']);
        $branch = Branch::all();

        $data = DB::table('customer_introduce as c')
            ->select('c.name', 'c.phone', 'c.id', 'c.note')
            ->where(function ($query) use ($list) {
                if (!is_null($list)) {
                    $query->whereIn('c.id', $list);
                }
            })
            ->get();
        return view('admin.crm', (['data' => $data, 'branch' => $branch]));
    }

    public function crmSent(Request $request)
    {
        $list = $request->customer_id;
        $data = DB::table('customer_introduce as c')
            ->select('c.name', 'c.phone', 'c.id', 'c.note', 'c.branch')
            ->where(function ($query) use ($list) {
                if (!is_null($list)) {
                    $query->whereIn('c.id', $list);
                }
            })
            ->get();
        $i = 0;
        foreach ($data as $item) {

            $FullName = $item->name;
            if (isset($item->phone)) {
                $phone = $item->phone;
            } else {
                request()->session()->flash('message', 'Thêm thành công ' . $i . ' phiếu ghi !!!');
                return redirect('admin/customer/index/');
            }
            $FK_CampaignID = 0;
            $time = strtotime(Carbon::now());
            $address = "";
            $areaID = 0;
            if (isset($request->chi_nhanh)) {
                $branchID = $request->chi_nhanh;
            } else {
                $branchID = 0;
            }
            $chinhanh = $item->branch;
            $service_text = "Dịch vụ :" . $item->note . " - Chi nhánh :" . $chinhanh . "- Nội Dung: " . $item->note;
            $jobcode = "LEAD_CCS_OFFLINE";
            $platform = "offline";
            $tokenList = "CRM2019" . $FullName . $phone . $FK_CampaignID . $time;
            $token = hash('sha256', $tokenList);
            $urlSend = "https://apicrm.ngocdunggroup.com/api/v1/SC/Social/AddLead";
            $str_data = '{ "FK_CampaignID": "' . $FK_CampaignID . '", "Phone": "' . $phone . '", "FullName": "' . $FullName . '", "Address": "' . $address . '", "timestamp": "' . $time . '", "token": "' . $token . '","AreaID":"' . $areaID . '","BranchID":"' . $branchID . '","Service_text":"' . $service_text . '","JobCode":"' . $jobcode . '","platform":"' . $platform . '"}';
//            dd($str_data);
            $result = $this->sendPostDataCRM($urlSend, $str_data);
            $result = json_decode($result, true);
            if ($result['status'] == 200) {
                $result_api = json_decode($result['Result'], true);

                $updata = CustomerIntroduce::where('id', $item->id)->first();
                $updata->ticket_crm_id = $result_api['TicketId'];
                $updata->lead_id = $result_api['LeadId'];
                $updata->is_exist_ticket = $result_api['isExistTicket'];
                $updata->is_exist_lead = $result_api['isExistLead'];
                $updata->updated_at = Carbon::now();
                if ($result_api['isExistTicket'] == true) {
                    $updata->status = 15;
                } else {
                    $updata->status = 888;
                }
                $updata->save();
                $i++;
            }
        }
        request()->session()->flash('message', 'Thêm thành công ' . $i . ' phiếu ghi !!!');
        return redirect('admin/offline/');
    }

    protected function sendPostDataCRM($url, $post)
    {
        $timeout = 300;
        $connectTimeout = 300;
        $sslVerifyPeer = false;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $sslVerifyPeer);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function delete($id)
    {
        if (isset($id)) {
            $paren = CustomerIntroduce::where('id', $id)->first();

            if (isset($paren)) {
                CustomerIntroduce::where('id', $id)->delete();
                request()->session()->flash('message', 'Xóa thành công !!!');

                return redirect('admin/cskh');
            }
        }
        request()->session()->flash('error', 'Xóa thất bại !!!');
        return redirect('admin/cskh');
    }

    public function crmCheck(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        if (isset($request->phone)) {
            $phone = $this->convertPhone($request->phone);
            $url = 'http://api.ngocdunggroup.com/api/v1/Customers/checkphone?apiKey=M6d6RjYyhrBnUzg6HXnw3VJ&phone=' . $phone . '';
            $checkMoon = $this->httpFB(strip_tags($url));
            $moon = json_decode($checkMoon['data'], true);
//            dd($moon['Data'][0]['CustomerName']);
//            $msg = "Khách hàng : " . $moon['Data'][0]['CustomerName'] . "Note : " . $moon['Data'][0]['Notes'];
            if (isset($moon['Data'][0]['CustomerName'])){
                $msg = "Khách hàng : " . $moon['Data'][0]['CustomerName'] . ". Đã tồn tại trên Moon";
            }else{
                $msg = "Chưa có trên Moon";
            }
            return json_encode([
                'result' => true,
                'message' => 'Cập nhật thành công',
                'msg' => $msg,
            ]);
        }
        $msg = "Khách hàng không tồn tại trên Moon";
        return json_encode([
            'result' => true,
            'message' => 'Cập nhật thành công',
            'msg' => $msg,
        ]);


    }
}
