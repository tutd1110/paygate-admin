<?php

namespace App\Jobs;

use App\Models\Farmer;
use App\Models\ProfitLog;
use App\Models\ProfitUserLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProgressProfit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ProfitLog
     */
    private $profit;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ProfitLog $profit)
    {
        $this->profit = $profit;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->profit->status = ProfitLog::STATUS_RUNNING;
        $this->profit->save();

        \DB::disableQueryLog();

        $currentProfit = $this->profit;


        /***
         * lặp cho đến hết dùng i để tính limit
         */

        try {
            DB::transaction(function () use ($currentProfit) {
                $allFarmers = null;
                $i = 0;
                do {
                    unset($allFarmers);
                    $ratioPoint = $currentProfit->total_money / $currentProfit->total_coin;
                    /***
                     * @var $allFarmers Collection
                     */
                    $allFarmers = Farmer::select('launcher_id', 'points')->where('points', '>', 0)
                        ->offset($i * 10000)
                        ->limit(10000)
                        ->get();
                    $i++;

                    foreach ($allFarmers->chunk(1000) as $allFarmer) {

                        $data = $allFarmer->map(function ($item) use ($currentProfit, $ratioPoint) {
                            return [
                                'launcher_id' => $item->launcher_id,
                                'profit_log_id' => $currentProfit->id,
                                'currency_unit' => $currentProfit->currency_unit,
                                'coin_number' => $item->points,
                                'coin_price' => $ratioPoint,
                            ];
                        });

                        ProfitUserLog::upsert($data->toArray(), ['launcher_id', 'profit_log_id'],
                            ['launcher_id', 'profit_log_id', 'coin_number', 'coin_price']);
                    }


                } while ($allFarmers->count());
            });
            Farmer::where('points', '>', 0)->update([
                'points' => 0,
            ]);
            $currentProfit->status = ProfitLog::STATUS_DONE;
            $currentProfit->save();
        } catch (\Exception $exception) {
            throw  $exception;
        }


        return true;
    }
}
