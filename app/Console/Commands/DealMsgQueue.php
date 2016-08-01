<?php

/*
 * Copyright (C) 2016 SINA Corporation
 *  
 *  
 * 
 * This script is firstly created at 2016-08-01.
 * 
 * To see more infomation,
 *    visit our official website http://jiaoyi.sina.com.cn/.
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Redis\Client;
use HRTime\StopWatch;
use HRTime\Unit;
use Predis\Client as OClient;

/**
 * Description of DealMsgQueue
 *
 * @encoding UTF-8 
 * @author jiaojie <jiaojie@staff.sina.com.cn> 
 * @since 2016-08-01 16:34 (CST) 
 * @version 0.1
 * @description 
 */
class DealMsgQueue extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hq:msg:distri';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Distribute Queued Message';

    /**
     *
     * @var \App\Redis\Client 
     */
    protected $redis;

    /**
     *
     * @var array 
     */
    protected $appList;

    const NOTIFY_LIST_KEY = "list:notify:all";
    const APP_SETTINGS = "app:setting:%s";
    const O_CLIENT_MAX_IDLE_TIME = 10;
    const MSG_PUSH_LIST_KEY = "list:push";

    public function __construct() {
        parent::__construct();
        $this->redis = Client::getInstance();
    }

    public function handle() {
        for (;;) {
            $data = $this->redis->rPop(self::NOTIFY_LIST_KEY);
            if (empty($data)) {
                continue;
            }
            $data = json_decode($data, true);
            list($appid, $sid) = explode(":", $data["subinfo"]);
            $data["sid"] = $sid;
            dump($appid, $sid);
            $this->pushMessageQueue($appid, $data);
            dump($data);
            exit;
        }
    }

    protected function pushMessageQueue($appid, $data) {
        $conn = $this->getAppDistributeConn($appid);
        return $conn->lPush(self::MSG_PUSH_LIST_KEY, json_encode($data));
    }

    protected function getAppDistributeConn($appid) {
        if (array_key_exists($appid, $this->appList) && (time() - $this->appList["ltime"] < self::O_CLIENT_MAX_IDLE_TIME)) {
            
        } else {
            $this->appList[$appid]["conn"] = $this->connectedRedis($appid);
        }
        $this->appList[$appid]["ltime"] = time();
        return $this->appList[$appid]["conn"];
    }

    protected function connectedRedis($appid) {
        $setting = $this->redis->hGetAll(sprintf(self::APP_SETTINGS, $appid));
        if (is_array($setting)) {
            return new OClient([
                "host" => $setting["host"],
                "port" => $setting["port"],
            ]);
        } else {
            return new OClient([
                "host" => "127.0.0.1",
                "port" => 6379,
            ]);
        }
    }

}
