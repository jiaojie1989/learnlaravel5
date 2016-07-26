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

namespace App\Redis;

use Predis\Client as RedisClient;

/**
 * Description of Client
 *
 * @encoding UTF-8 
 * @author jiaojie <jiaojie@staff.sina.com.cn> 
 * @since 2016-07-26 09:32 (CST) 
 * @version 0.1
 * @description 
 */
class Client {

    protected static $instance;
    protected $redis;

    protected function __construct() {
        $this->redis = new RedisClient(['host' => '172.16.7.27', 'port' => 6379], ['profile' => function ($options) {
                $profile = $options->getDefault('profile');
                $profile->defineCommand('setQueue', '\\App\\Redis\\Commands\\DistriHqMsg');
//                $profile->defineCommand("consumePriceCompareQueue", "");
//                $profile->defineCommand("consume5MinQueue", "");
//                $profile->defineCommand("distributeNotify", "");
                return $profile;
            }]
        );
    }

    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __call($name, $arguments) {
        return call_user_func_array([$this->redis, $name], $arguments);
    }

}
