<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Redis\Client;
use HRTime\StopWatch;
use HRTime\Unit;

class DealPriceQueue extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hq:queue:price:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle queue for price comparing.';

    /**
     *
     * @var \App\Redis\Client 
     */
    protected $redis;

    /**
     *
     * @var \HRTime\StopWatch 
     */
    protected $watch;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(StopWatch $watch) {
        parent::__construct();
        $this->watch = $watch;
        $this->redis = Client::getInstance();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        for (;;) {
            $dataStr = $this->redis->rpop("queue:hq:common");
            if (empty($dataStr)) {
                dump("[Warn] [" . date("Y-m-d H:i:s") . "] HQ Queue Empty");
                sleep(1);
                continue;
            }
            $data = json_decode($dataStr, true);
//            if ("sz002304" != $data["symbol"]) {
//                continue;
//            }
            $this->watch->start();
            $num = $this->redis->consumePriceCompareQueue($data["symbol"], $data["time"], $data["price"], $data["rate"], $data["negative"]);
//            dump($num);
            if (intval($num) > 9999) {
                dump($this->redis->rpush("queue:hq:common", $dataStr));
            }
            
            $this->watch->stop();
//            var_dump($this->watch->getLastElapsedTime(Unit::MILLISECOND));
            if (!empty($num)) {
                var_dump($num . " $ {$data["symbol"]} $" . date("Y-m-d H:i:s", $data["time"]) . "----" . date("Y-m-d H:i:s"));
            }
//            var_dump($data);
//            exit;
        }
    }

}
