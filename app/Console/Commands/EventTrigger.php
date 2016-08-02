<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Redis\Client as RedisClient;
use App\Redis\FrontClient as FrontRedisClient;

class EventTrigger extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hq:front:event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume Front Setting Event.';

    const FRONT_EVENT_KEY = "queue:settings";
    const SETTING_KEY = "set:%s:%s";

    /**
     * Backend Redis Client - Setting Detail
     * 
     * @var \App\Redis\Client 
     */
    protected $redisClient;

    /**
     * Front Redis Client - Event Queue
     * 
     * @var App\Redis\FrontClient 
     */
    protected $frontRedisClient;
    protected static $typeArr = array(
        "high", "low", "rate", "5min",
    );

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->frontRedisClient = FrontRedisClient::getInstance();
        $this->redisClient = RedisClient::getInstance();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        for (;;) {
            $eventStr = $this->frontRedisClient->rPop(self::FRONT_EVENT_KEY);
            if (empty($eventStr)) {
                $this->redisClient->ping();
                continue;
            }
            $data = json_decode($eventStr, true);
            if (in_array($data["type"], self::$typeArr)) {
                $key = sprintf(self::SETTING_KEY, $data["type"], $data["symbol"]);
                $val = $data["appid"] . ":" . $data["sid"];
                $score = $data["target"];
                $this->redisClient->zAdd($key, $score, $val);
            } else {
                $this->redisClient->ping();
            }
        }
    }

}
