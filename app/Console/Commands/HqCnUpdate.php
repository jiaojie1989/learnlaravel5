<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use HRTime\StopWatch;
use HRTime\Unit;

class HqCnUpdate extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hq:update:cn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Cn HQ Infomation';
    protected $client;
    protected $watch;

    /**
     * Time Setting
     */
    const START_TIME = "09:30:00";
    const END_TIME = "16:00:00";
    const TIME_DIVER = 5399;
    const TIME_HIGHER_THAN = 7200;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $client, StopWatch $watch) {
        parent::__construct();
        $this->client = $client;
        $this->watch = $watch;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        var_dump($this->getSecondsOrderSerial("1970-01-01 13:00:00"));
        exit;

        $client = $this->client;
        $func = function() use ($client) {
            $response = $client->request("GET", "http://i.hq.sinajs.cn/list=sh000001,sh000002,sh000003,sh000004,sh600868,sh600172");
            $response = $response->getBody();
            return trim(strval($response));
        };
        $filter = function($text) {
            $match = null;
//            var_dump($text);
            preg_match_all('#var\ hq_str_(?P<symbol>\w+)\=\"(?P<name>((?!\,).)+)\,(?P<open>((?!\,).)+)\,(?P<close>((?!\,).)+)\,(?P<now>((?!\,).)+)\,(?P<now_high>((?!\,).)+)\,(?P<now_low>((?!\,).)+)\,(?P<buy>((?!\,).)+)\,(?P<sell>((?!\,).)+)\,(?P<succ_amount>((?!\,).)+)\,(?P<succ_total>((?!\,).)+)\,(?P<buy1>((?!\,).)+)\,(?P<buy1_p>((?!\,).)+)\,(?P<buy2>((?!\,).)+)\,(?P<buy2_p>((?!\,).)+)\,(?P<buy3>((?!\,).)+)\,(?P<buy3_p>((?!\,).)+)\,(?P<buy4>((?!\,).)+)\,(?P<buy4_p>((?!\,).)+)\,(?P<buy5>((?!\,).)+)\,(?P<buy5_p>((?!\,).)+)\,(?P<sell1>((?!\,).)+)\,(?P<sell1_p>((?!\,).)+)\,(?P<sell2>((?!\,).)+)\,(?P<sell2_p>((?!\,).)+)\,(?P<sell3>((?!\,).)+)\,(?P<sell3_p>((?!\,).)+)\,(?P<sell4>((?!\,).)+)\,(?P<sell4_p>((?!\,).)+)\,(?P<sell5>((?!\,).)+)\,(?P<sell5_p>((?!\,).)+)\,(?P<date>((?!\,).)+)\,(?P<time>((?!\,).)+)\,(?P<status>((?!\,).)+)\"#', $text, $match);
            foreach ($match as $k => $v) {
                if (is_int($k)) {
                    unset($match[$k]);
                }
            }
//            var_dump($match);
//            exit;
            return $match;
        };
        while (true) {
            $this->watch->start();
            $text = iconv("gbk", "utf-8", $func());
            $text = $filter($text);
            $this->watch->stop();
            var_dump($this->watch->getLastElapsedTime(Unit::MILLISECOND));
        }
    }

    private function getSecondsOrderSerial($time) {
        $startSec = strtotime(self::START_TIME);
        $endSec = strtotime(self::END_TIME);
        $nowSec = strtotime($time);
        if ($nowSec < $startSec || $nowSec > $endSec) {
            return false;
        }
        $differ = $nowSec - $startSec;
        if ($differ > self::TIME_HIGHER_THAN) {
            return $differ - self::TIME_DIVER;
        } else {
            return $differ;
        }
    }

}
