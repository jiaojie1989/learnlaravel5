<?php

/*
 * Copyright (C) 2016 SINA Corporation
 *  
 *  
 * 
 * This script is firstly created at 2016-07-25.
 * 
 * To see more infomation,
 *    visit our official website http://jiaoyi.sina.com.cn/.
 */

namespace App\Redis\Commands;

use Predis\Command\ScriptCommand;

/**
 * Description of DistriHqMsg
 *
 * @encoding UTF-8 
 * @author jiaojie <jiaojie@staff.sina.com.cn> 
 * @since 2016-07-25 17:51 (CST) 
 * @version 0.1
 * @description 
 */
class DistriHqMsg extends ScriptCommand {

    public function getKeysCount() {
        return 1;
    }

    public function getScript() {
        return <<<LUA
local symbol = KEYS[1];
local price_time = ARGV[1];
local price = ARGV[2];
local rate = ARGV[3];
local negative = ARGV[4];

local hq_queue = "queue:hq:common";
local hq_5min_queue = "queue:hq:5min";
local key_symbol = "hash:symbol:price:"..symbol;

--redis.call("SELECT", 4);

if (negative == nil or negative == "0") then
    negative = 0;
else
    negative = 1;
end

if(0 == redis.call("HSETNX", key_symbol, price_time, price)) then
    return false;
else
    local tmp = {};
    tmp.symbol = symbol;
    tmp.time = price_time;
    tmp.rate = rate;
    tmp.price = price;
    tmp.negative = negative;
    tmp = cjson.encode(tmp);
    redis.call("LPUSH", hq_queue, tmp);
    redis.call("LPUSH", hq_5min_queue, tmp);
    return true;
end
LUA;
    }

}
