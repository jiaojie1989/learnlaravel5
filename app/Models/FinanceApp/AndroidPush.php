<?php

/*
 * Copyright (C) 2016 SINA Corporation
 *  
 *  
 * 
 * This script is firstly created at 2016-07-15.
 * 
 * To see more infomation,
 *    visit our official website http://jiaoyi.sina.com.cn/.
 */

namespace App\Models\FinanceApp;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of AndroidPush
 *
 * @encoding UTF-8 
 * @author jiaojie <jiaojie@staff.sina.com.cn> 
 * @since 2016-07-15 17:51 (CST) 
 * @version 0.1
 * @description 
 */
class AndroidPush extends Model {

    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
        $this->table = "android_push_datas";
    }

}
