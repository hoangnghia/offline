<?php

namespace App\Console\Commands;

use App\Shop\Customer\Customer;
use App\Shop\Log\CronJobLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CheckCustomerInCareSoft extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkData:customerOffline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tools check phone customer in Care Soft !';

    /**
     * Filesystem instance
     *
     * @var string
     */
    protected $filesystem;

    /**
     * Default laracom folder
     *
     * @var string
     */
    protected $folder;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $today = Carbon::now()->toDateString();
        $customer = Customer::whereNull('care_soft_log_id')->where('check_care_soft', 0)->where('created_at', '>=', $today)->get();

        foreach ($customer as $item) {
            $phone = $item->phone;
            $phone = $this->convertPhone($phone);
            $urlGet = "https://api.caresoft.vn/tmvngocdung/api/v1/contacts?phone=" . $phone;
            $resultGet = $this->httpCareSoft($urlGet);
            $careSoft = json_decode($resultGet['data'], true);
            if (is_null($careSoft['contacts']) || empty($careSoft['contacts'])) {
                $phone = $item->phone;
                if (substr($phone, 0, 2) == '84') {
                    $phone = substr($phone, 2);
                }
                if (substr($phone, 0, 1) != 0) {
                    $phone = '0' . $phone;
                }
                $urlGet = "https://api.caresoft.vn/tmvngocdung/api/v1/contacts?phone=" . $phone;
                $resultGet = $this->httpCareSoft($urlGet);
                $careSoft = json_decode($resultGet['data'], true);
            }
            $customerUpdata = Customer::where('id', $item->id)->first();
            if (is_null($careSoft['contacts']) || empty($careSoft['contacts'])) {
                $customerUpdata->check_care_soft = 1;
            } else {
                $customerUpdata->check_care_soft = $careSoft['contacts'][0]['id'];
            }
            $customerUpdata->save();
            $this->info('---- Check thành công khách hàng ' . $item->phone . '----');
        }
        $log = new CronJobLog();
        $log->name = "Check Care Soft";
        $log->note ="Check khách hàng có trên CS ngày ".$today;
        $log->created_at = Carbon::now();
        $log->updated_at = Carbon::now();
        $log->save();

    }

    /**
     * @param $source
     * @return mixed|string
     * Convert số điện thoại
     */
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

    /**
     * @param $url
     * @return array
     */
    public function httpCareSoft($url)
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
            "Content-Type: application/json",
            "Authorization: Bearer 8IQwZ6_shBeMuh0"));
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $sslVerifyPeer);
        curl_setopt($ci, CURLOPT_URL, $url);

        $response['http_code'] = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        $response['api_call'] = $url;
        $response['data'] = curl_exec($ci);

        curl_close($ci);

        return $response;
    }

}
