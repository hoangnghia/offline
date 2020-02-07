<?php

namespace App\Console\Commands;

use App\Shop\Customer\Customer;
use App\Shop\Customer\CustomerIntroduce;
use App\Shop\Customer\CustomerStatus;
use App\Shop\Log\CronJobLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;

class CheckCustomerCRM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkData:customerOfflineCRM';

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
        set_time_limit(0);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today = Carbon::now()->toDateString();
        $timecover = strtotime(Carbon::now());
        $tokenList = "CRM2019" . $timecover;
        $token = hash('sha256', $tokenList);
        $time = date('Y-m-d', strtotime("-5 days"));
        $list = DB::table('customer_introduce as c')
            ->select('c.ticket_crm_id')
            ->whereDate('c.created_at', '>=', $time)
            ->whereNotNull('c.ticket_crm_id')
            ->get();
        $ticket = '';
        foreach ($list as $item) {
            $ticket .= $item->ticket_crm_id . ',';
        }
        $timeunix = $timecover;
        $urlSend = "https://apicrm.ngocdunggroup.com/api/v1/SC/Social/CheckStatusLead";
        $str_data = '{ "TimeUnix": "' . $timeunix . '","token":"' . $token . '","ResultAction": { "objSent":[' . $ticket . '],"TeamOf":""}}';
        $result = $this->sendPostDataCRM($urlSend, $str_data);
        $result = json_decode($result, true);
        $resultt = json_decode($result['Result'], true);
        foreach ($resultt as $item) {
            if (isset($item['work_status']) && $item['work_status'] != "") {
                $status = CustomerStatus::where('title', $item['work_status'])->first();
                if (isset($status->id) && $status->id != '') {
                    $updata = CustomerIntroduce::where('ticket_crm_id', $item['TicketId'])->first();
                    if (isset($updata)) {
                        $updata->status_care = $status->id;
                        $updata->updated_at = Carbon::now();
                        $updata->save();
                        $this->info('Khac -- Luu thành công khách hàng ' . $item['FullName']);
                    }
                }
            }
        }
        $log = new CronJobLog();
        $log->name = "Check status CRM ";
        $log->note = "Check trạng thái khách hàng " . $today;
        $log->created_at = Carbon::now();
        $log->updated_at = Carbon::now();
        $log->save();
    }

    protected
    function sendPostDataCRM($urlSend, $str_data)
    {
        $timeout = 300;
        $connectTimeout = 300;
        $sslVerifyPeer = false;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json-patch+json",));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $sslVerifyPeer);
        curl_setopt($ch, CURLOPT_URL, $urlSend);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $str_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
