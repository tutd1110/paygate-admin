<?php

namespace App\Console\Commands;

use App\Helper\Mycurl;
use Carbon\Carbon;
use Illuminate\Console\Command;

class testRunWheels extends Command
{
    const STATUS_VERIFIED = 'verified';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testRunWheels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        set_time_limit(20000);
        $this->url_get_ticket = env('HOCMAI_API_V2') . '/api/v1/wheels/ticket';
        $this->url_run_wheels = env('HOCMAI_API_V2') . '/api/v1/wheels/run-wheel-fahasa';
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $number = $this->ask('Nhập số lần muốn quay?');
        if (!$number) {
            $this->error('Bạn chưa nhập số lần quay');
            return;
        }
        $this->info('[' . Carbon::now()->format('Y-m-d H:i:s') . '] Start Run: ' . self::class . '');
        $result = $this->runWheels($number);
        $this->info('Kết quả sau khi quay là');
        $this->info('--------------------------------');
        $this->info('Tổng số lần quay thành công : '. (intval($number) - intval($result['connectFail'])));
        $this->info('Tổng số lần quay thất bại : '.$result['connectFail']);
        foreach ($result['arrayGift'] as $key => $value) {
            $actualRate = $value / (intval($number) - intval($result['connectFail'])) * 100;
            $this->info('Có ' . $value . ' kết quả ' . $key . ' với tỉ lệ ra quà : '.$result['arrayRateGift'][$key] .'/ Tỉ lệ thực tế: '. number_format($actualRate,2));
        }
        $this->info('[' . Carbon::now()->format('Y-m-d H:i:s') . '] End Run: ' . self::class . '');
        return true;
    }

    public function runWheels($number)
    {
        $param['limit'] = intval($number);
        $param['status'] = self::STATUS_VERIFIED;
        $ticket = Mycurl::getCurl($this->url_get_ticket, $param);

        $arrayRateGift = [];
        $arrayGift = [];
        $connectFail = 0;

        if (!empty($ticket['ticket'])) {
            foreach ($ticket['ticket']['data'] as $k => $value) {
                $param1['landing_page_id'] = $value['landing_page_id'];
                $param1['contact_id'] = $value['contact_lead_process_id'];
                $param1['bill_code'] = $value['bill_code'];
                $param1['bill_value'] = $value['bill_value'];
                $param1['test'] = true;
                $getDataOrders = Mycurl::getCurl($this->url_run_wheels, $param1);
                if (empty($getDataOrders['finalGift'])) {
                    $connectFail++;
                } else {
                    array_push($arrayGift, $getDataOrders['finalGift']['id']);
                    if (!in_array($getDataOrders['finalGift']['id'], $arrayRateGift)) {
                        $arrayRateGift[$getDataOrders['finalGift']['id']] = $getDataOrders['finalGift']['rate'];
                    }
                }
            }
        }
        return [
            'arrayGift' =>array_count_values($arrayGift),
            'arrayRateGift' =>$arrayRateGift,
            'connectFail' => $connectFail ?? 0
        ];
    }
}
