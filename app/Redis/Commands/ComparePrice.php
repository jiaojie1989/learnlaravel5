<?php

/*
 * Copyright (C) 2016 SINA Corporation
 *  
 *  
 * 
 * This script is firstly created at 2016-07-26.
 * 
 * To see more infomation,
 *    visit our official website http://jiaoyi.sina.com.cn/.
 */

namespace App\Redis\Commands;

use Predis\Command\ScriptCommand;

/**
 * Description of CalPrice
 *
 * @encoding UTF-8 
 * @author jiaojie <jiaojie@staff.sina.com.cn> 
 * @since 2016-07-26 15:05 (CST) 
 * @version 0.1
 * @description 
 */
class ComparePrice extends ScriptCommand {

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

local high_set = "set:high:price:"..symbol;
local low_set = "set:low:price:"..symbol;
local rate_set = "set:common:rate:"..symbol;
local notify_list = "list:notify:all";
local message = 0;

--redis.call("select", 4);

if (negative == nil or negative == "0") then
    negative = 0;
else
    negative = 1;
end

local push_high = redis.call("zrangebyscore", high_set, "(0", price, "withscores", "limit", 0, 10000);
local push_low = redis.call("zrangebyscore", low_set, price, "+inf", "withscores", "limit", 0, 10000);
local push_rate = {};

if (negative == 1) then 
    push_rate = redis.call("zrangebyscore", rate_set, "(0", rate, "withscores", "limit", 0, 10000);
else
    push_rate = redis.call("zrangebyscore", rate_set, rate, "(0", "withscores", "limit", 0, 10000);
end

for i = 1, #(push_high) do
    if i % 2 == 1 then
        local tmp = {};
        tmp.type = "push_high";
        tmp.origin = push_high[i+1];
        tmp.rate = rate;
        tmp.price = price;
        tmp.time = price_time;
        tmp.symbol = symbol;
        tmp.subinfo = push_high[i];
        redis.call("lpush", notify_list, cjson.encode(tmp));
        redis.call("zrem", high_set, push_high[i]);
        message = message + 1;
    end
end

for i = 1, #(push_low) do
    if i % 2 == 1 then
        local tmp = {};
        tmp.type = "push_low";
        tmp.origin = push_low[i+1];
        tmp.rate = rate;
        tmp.price = price;
        tmp.time = price_time;
        tmp.symbol = symbol;
        tmp.subinfo = push_low[i];
        redis.call("lpush", notify_list, cjson.encode(tmp));
        redis.call("zrem", high_set, push_low[i]);
        message = message + 1;
    end
end

for i = 1, #(push_rate) do
    if i % 2 == 1 then
        local tmp = {};
        tmp.type = "push_rate";
        tmp.origin = push_rate[i+1];
        tmp.rate = rate;
        tmp.price = price;
        tmp.time = price_time;
        tmp.symbol = symbol;
        tmp.subinfo = push_rate[i];
        redis.call("lpush", notify_list, cjson.encode(tmp));
        redis.call("zrem", high_set, push_rate[i]);
        message = message + 1;
    end
end

return message;
LUA;
    }

}
