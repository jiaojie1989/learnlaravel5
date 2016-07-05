<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Stp\PayOrder;

class TestController extends Controller {

    public function test() {
//        return view("welcome");
        $filter = \DataFilter::source(new PayOrder());
        $filter->add('order_id', 'Order Id', 'text');
        $filter->add('pay_id', 'Pay Id', 'text');
        $filter->submit('search');
        $filter->reset('reset');
        $filter->build();

        $grid = \DataGrid::source($filter);
        $grid->add('id', '#', true); //relation.fieldname 
        $grid->add('order_id', 'Order Id');
        $grid->add('sid', 'Sid');
        $grid->add('total_payments', 'Payment');
        $grid->add('pay_id', "Pay Id");
        $grid->paginate(20);
        $grid->attributes(["class" => "table table-bordered table-striped dataTable"]);
        $grid->edit('/rapyd-demo/edit', 'Edit', 'show|modify');
        $grid->link('/rapyd-demo/edit', "New Article", "TR");
        \Kint::dump($grid);
        return view('test', compact('grid', 'filter'));
    }

}
