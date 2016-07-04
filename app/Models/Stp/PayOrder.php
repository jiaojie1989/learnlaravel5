<?php

namespace App\Models\Stp;

use Illuminate\Database\Eloquent\Model;

class PayOrder extends Model {

    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
        $this->table = "pay_order";
    }

}
