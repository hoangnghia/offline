<?php

namespace App\Http\Controllers\Admin\Customers;

use App\Http\Controllers\Admin\Api\SmsApiController;
use App\Shop\Branchs\Branch;
use App\Shop\Campaigns\Campaign;
use App\Shop\CareSoft\TicketCareSoftLog;
use App\Shop\Customer\Customer;
use App\Shop\Customers\Transformations\CustomerTransformable;
use App\Http\Controllers\Controller;
use App\Shop\Employees\Employee;
use App\Shop\Sms\SmsLog;
use Carbon\Carbon;
use Faker\Provider\ka_GE\DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Exports\CustomerExport;

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

//            ->left('employees as e', 'e.id', '=', 'lu.user_id');
//            ->orderBy('c.created_at', 'desc')
//            ->get();
//            dd($customer);
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
                $name = "Null";
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
            $customer->birthday = $request['date-customer'];
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

    public function export(Request $request)
    {
        $list = explode(",", $request['list']);

        $data = DB::table('customer as c')
            ->select('c.name', 'c.phone', 's.name as service_name')
            ->join('services as s', 's.id', '=', 'c.service')
            ->where(function ($query) use ($list) {
                if (!is_null($list)) {
                    $query->whereIn('c.id', $list);
                }
            })
            ->get()
            ->toArray();

        $excel = new \PHPExcel();
        $excel->setActiveSheetIndex(0);
        $excel->getActiveSheet()->setTitle('demo ghi dữ liệu');
        //Xét chiều rộng cho từng, nếu muốn set height thì dùng setRowHeight()
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
//Xét in đậm cho khoảng cột
        $excel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
//Tạo tiêu đề cho từng cột
//Vị trí có dạng như sau:
        $excel->getActiveSheet()->setCellValue('A1', 'Tên');
        $excel->getActiveSheet()->setCellValue('B1', 'Số điện thoại');
        $excel->getActiveSheet()->setCellValue('C1', 'Dịch vụ');
// thực hiện thêm dữ liệu vào từng ô bằng vòng lặp
// dòng bắt đầu = 2
        $numRow = 2;
        foreach ($data as $row) {
            $excel->getActiveSheet()->setCellValue('A' . $numRow, $row->name);
            $excel->getActiveSheet()->setCellValue('B' . $numRow, $row->phone);
            $excel->getActiveSheet()->setCellValue('C' . $numRow, $row->service_name);
            $numRow++;
        }
// Khởi tạo đối tượng PHPExcel_IOFactory để thực hiện ghi file
// ở đây mình lưu file dưới dạng excel2007
        $fileName = 'Export_DSKH_Offline_' . date('m-d-Y');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $fileName . '.xls"');
        \PHPExcel_IOFactory::createWriter($excel, 'Excel5')->save('php://output');
        return redirect()->back();
    }

    public function smsCreate(Request $request)
    {
        $list = explode(",", $request['list']);

        $data = DB::table('customer as c')
            ->select('c.name', 'c.phone', 'c.id', 's.name as service_name')
            ->join('services as s', 's.id', '=', 'c.service')
            ->where(function ($query) use ($list) {
                if (!is_null($list)) {
                    $query->whereIn('c.id', $list);
                }
            })
            ->get();
        return view('admin.smsbrand.add', (['data' => $data]));
    }

    public function smsSent(Request $request)
    {

        if (isset($request->date_sent)){
            $date = date('Y/m/d H:i:s', strtotime($request->date_sent));
        }


        $user_id = Auth::guard('employee')->user();
//        dd($user_id->id);
        $list = $request->customer_id;
        $customer = DB::table('customer as c')
            ->select('c.name', 'c.phone', 'c.id', 's.name as service_name')
            ->join('services as s', 's.id', '=', 'c.service')
            ->where(function ($query) use ($list) {
                if (!is_null($list)) {
                    $query->whereIn('c.id', $list);
                }
            })
            ->get();
        if (count($customer) > 0) {
            foreach ($customer as $item) {
                $name = $this->changeTitle($item->name);
                $phone = trim($item->phone);
                $type = $request['type-sms'];
                $dichvu = $this->changeTitle($item->service_name);
                $healthy = ["{ten_dich_vu}", "{ten_khach_hang}"];
                $yummy = [$dichvu, $name];
                $templateContent = str_replace($healthy, $yummy, $request->content_sms);
                $SendContent = urlencode($templateContent);
                if (isset($date)){
                    $apiUrl = "http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get?Phone=$phone&ApiKey=C946C4979CC87A9BFAAFDBBB6945A1&SecretKey=FD28DDE9060254C6B72B5E37066DFD&Content=$SendContent&SmsType=$type&SendDate=".urlencode($date)."&Brandname=TMVNgocDung";

                }else{
                    $apiUrl = "http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get?Phone=$phone&ApiKey=C946C4979CC87A9BFAAFDBBB6945A1&SecretKey=FD28DDE9060254C6B72B5E37066DFD&Content=$SendContent&SmsType=$type&Brandname=TMVNgocDung";
                }
                $customerSent = $this->http($apiUrl);
                $response = json_decode($customerSent['data'], true);
                $smsLog = new SmsLog();
                $smsLog->code_result = isset($response['CodeResult']) ? $response['CodeResult'] : null;
                $smsLog->smsid = isset($response['SMSID']) ? $response['SMSID'] : null;
                $smsLog->content = $templateContent;
                $smsLog->phone = $phone;
                $smsLog->created_at = Carbon::now();
                $smsLog->updated_at = Carbon::now();
                $smsLog->customer_log_id = $item->id;
                $smsLog->message = isset($response['ErrorMessage']) ? $response['ErrorMessage'] : null;
                $smsLog->user_id = $user_id->id;
                $smsLog->time_sent = $date;
                $smsLog->save();
                if ($smsLog instanceof SmsLog) {
                    $updata = Customer::where('id', $item->id)->first();
                    $updata->sms_log_id = $smsLog->id;
                    $updata->save();
                }
            }
            request()->session()->flash('message', 'Gửi tin nhắn thành công !!!');
            return redirect('admin/customer/history/');
        } else {
            request()->session()->flash('error', 'Gửi tin nhắn thất bại !!!');
            return redirect('admin/customer/index/');
        }
    }

    public function changeTitle($str)
    {
        if (!$str) return false;
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ',
            'D' => 'Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            '' => '?|(|)|[|]|{|}|#|%|-|–|<|>|,|:|;|.|&|"|“|”|/',
//            '-'=>' '
        );
        foreach ($unicode as $khongdau => $codau) {
            $arr = explode("|", $codau);
            $str = str_replace($arr, $khongdau, $str);
        }
        return $str;
    }

    public function history()
    {
        return view('admin/smsbrand/history');
    }

    public function getHistory()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $history = DB::table('sms_log as sl')
            ->select('sl.*', 'e.name as user_name', 'c.name as customer_name', 'c.phone as customer_phone')
            ->join('employees as e', 'e.id', '=', 'sl.user_id')
            ->join('customer as c', 'c.id', '=', 'sl.customer_log_id')
            ->orderBy('sl.created_at', 'desc')
            ->get();
        $datatables = DataTables::of($history);
        return $datatables->make(true);
    }

    public function careSoft(Request $request)
    {
        $list = explode(",", $request['list']);
        $branch = Branch::all();

        $data = DB::table('customer as c')
            ->select('c.name', 'c.phone', 'c.id', 's.name as service_name')
            ->join('services as s', 's.id', '=', 'c.service')
            ->where(function ($query) use ($list) {
                if (!is_null($list)) {
                    $query->whereIn('c.id', $list);
                }
            })
            ->get();
        return view('admin.caresoft.add', (['data' => $data, 'branch' => $branch]));
    }

    public function careSoftSent(Request $request)
    {
//dd($request);
        $loaiPhieu = $request->loai_phieu;
        $nguonPhieu = 41902;
        $chiTietNguonPhieu = $request->chi_tiet_nguon_phieu;
        $chiNhanh = $request->chi_nhanh;
        $tieuDe = $request->title_phieu;

        $id = $request->chuyen_vien;
        $list = $request->customer_id;
        $data = DB::table('customer as c')
            ->select('c.name', 'c.phone', 'c.id', 's.name as service_name', 'c.note')
            ->join('services as s', 's.id', '=', 'c.service')
            ->where(function ($query) use ($list) {
                if (!is_null($list)) {
                    $query->whereIn('c.id', $list);
                }
            })
            ->get();
        $i = 0;
        foreach ($data as $item) {
            $title = "[Offline] - " . $item->name . " - " . $chiNhanh . " - " . $tieuDe . " - " . $item->service_name;
            $soDienThoai = $item->phone;
            $comment = $item->note;
            $customField = '{"id": "3406", "value": ' . $loaiPhieu . '}';
            if (!is_null($nguonPhieu)) {
                $customField .= ',{"id": "1448", "value": ' . $nguonPhieu . '}';
            }
            if (!is_null($chiTietNguonPhieu)) {
                $customField .= ',{"id": "1700", "value": ' . $chiTietNguonPhieu . '}';
            }
            if (!is_null($request->vung_mien)) {
                $customField .= ',{"id": "1416", "value": ' . $request->vung_mien . '}';
            }
            $str_data = '{"ticket": {"ticket_subject": "' . $title . '","ticket_comment":  "' . $comment . '","phone": "' . $soDienThoai . '","username": "' . $item->name . '","ticket_priority": "Normal", "group_id" : "7730","assignee_id": "' . $id . '","custom_fields": [' . $customField . ']}}';
            $urlSend = "https://api.caresoft.vn/tmvngocdung/api/v1/tickets";
            $result = $this->sendPostData($urlSend, $str_data);
            $result = json_decode($result, true);
            $ticketLog = new TicketCareSoftLog();
            $ticketLog->ticket_subject = $result['ticket']['ticket_subject'];
            $ticketLog->ticket_no = $result['ticket']['ticket_no'];
            $ticketLog->ticket_id = $result['ticket']['ticket_id'];
            if ($result['code'] == 'ok') {
                $ticketLog->status = true;
                $i++;
            } else {
                $ticketLog->status = false;
            }
            $ticketLog->created_at = Carbon::now();
            $ticketLog->updated_at = Carbon::now();
            $ticketLog->save();
            if ($ticketLog instanceof TicketCareSoftLog) {
                $updata = Customer::where('id', $item->id)->first();
                $updata->ticket_id = $result['ticket']['ticket_id'];
                $updata->care_soft_log_id = $ticketLog->id;
                $updata->save();
            }
        }
        request()->session()->flash('message', 'Thêm thành công ' . $i . ' phiếu ghi !!!');
        return redirect('admin/customer/index/');
    }

    /**
     * @param $url
     * @param $post
     * @return mixed
     */
    function sendPostData($url, $post)
    {
        $timeout = 30;
        $connectTimeout = 30;
        $sslVerifyPeer = false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer 8IQwZ6_shBeMuh0"
        ));
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

    /**
     * Dung cho SMS
     * @param $url
     * @return array
     */
    protected function http($url)
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
}
