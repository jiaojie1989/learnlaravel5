<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Redis\Client as RedisClient;
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

    /*
     * Clients
     */
    protected $client;
    protected $watch;
    protected $redis;

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
    public function __construct(/* Client $client, StopWatch $watch */) {
        parent::__construct();
//        $this->client = $client;
//        $this->watch = $watch;
    }

    protected function setAdditionalClients() {
        $this->redis = RedisClient::getInstance();
        $this->client = new Client();
        $this->watch = new StopWatch();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
//        var_dump($this->getSecondsOrderSerial("1970-01-01 13:00:00"));
//        exit;
        $symbolList = file_get_contents("http://stock.finance.sina.com.cn/stock/api/srv.php/StockService.getAllStockData?type=cn");
        $symbolList = unserialize($symbolList);
        $symbols = [];
        foreach ($symbolList as $symbol) {
            array_push($symbols, $symbol["symbol"]);
        }
        $arrs = array_chunk($symbols, 200);
        foreach ($arrs as $arr) {
            if (pcntl_fork() > 0) {
                continue;
            }
            $list = implode(",", $arr);
            $this->setAdditionalClients();
            $client = $this->client;
            $func = function($list) use ($client) {
                $response = $client->request("GET", "http://i.hq.sinajs.cn/list={$list}");
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
                $text = iconv("gbk", "utf-8", $func($list));
                $text = $filter($text);
//            var_dump($text);
//            exit;
                $this->watch->start();
                foreach ($text["symbol"] as $k => $symbol) {
                    if (0 == $text["close"][$k]) {
                        continue;
                    }
                    try {
                        $rate = bcdiv(bcsub($text["now"][$k], $text["close"][$k], 6), $text["close"][$k], 4);
                    } catch (\Exception $e) {
                        var_dump($symbol);
                        throw $e;
                    }
                    $this->redis->setQueue($symbol, strtotime($text["date"][$k] . " " . $text["time"][$k]), $text["now"][$k], $rate, $rate > 0 ? 1 : 0);
                }
                $this->watch->stop();
                var_dump($this->watch->getLastElapsedTime(Unit::MILLISECOND));
            }
        }
        $status = null;
        pcntl_wait($status);
        var_dump("stop the master");
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
