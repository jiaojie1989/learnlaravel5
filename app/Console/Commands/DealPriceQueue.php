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
        for(;;) {
            $data = $this->redis->rpop("queue:hq:common");
            if (empty($data)) {
                exit("HQ Queue Empty");
            }
            $data = json_decode($data, true);
            if ("sh600097" != $data["symbol"]) {
                continue;
            }
            $this->watch->start();
            dump($this->redis->consumePriceCompareQueue($data["symbol"], $data["time"], $data["price"], $data["rate"], $data["negative"]));
            $this->watch->stop();
            var_dump($this->watch->getLastElapsedTime(Unit::MILLISECOND));
            var_dump($data);exit;
        }
    }

}
