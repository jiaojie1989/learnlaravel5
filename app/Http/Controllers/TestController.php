<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Stp\PayOrder;
use App\Models\FinanceApp\AndroidPush;

class TestController extends Controller {

    public function chartDemo() {
        $datas = AndroidPush::all(["date", "push", "average_rate", "registers"]);
        $datas = $datas->toArray();
        $datas = array_reverse($datas);
        $datas = array_slice($datas, 0, 50);
        $datas = array_reverse($datas);
        return $datas;
        var_dump($datas);
        exit;
        return view("chart", ["data" => $data]);
    }

    public function chart() {
        return view("chart");
    }

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
        $grid->edit('/rapyd-demo/edit', 'Edit', 'show|modify|delete');
        $grid->link('/rapyd-demo/edit', "New Article", "TR");
//        \Kint::dump($grid);
//        return compact('grid', 'filter');
        if (isset($_GET["filter"])) {
            return $filter;
        }
        return strval($filter) . strval($grid);
//        return $grid;
//        return $grid;
//        return view('test', compact('grid', 'filter'));
    }

    public function test2() {
        //embed some widgets and isolate the dom using riot & pjax
        $embed1 = \DataEmbed::source('/test', 'embed1')->build();

        //if you prefer you can simply use an html tag
//        $embed2 = '<dataembed id="embed2" remote="/rapyd-demo/nudeedit?modify=1"></dataembed>';
//        $embed2 = '<dataembed id="embed2" remote="/test?filter=1"></dataembed>';
        return view('test', compact('embed1'));
//        return view('test2', compact('embed1', 'embed2'));
    }

}
