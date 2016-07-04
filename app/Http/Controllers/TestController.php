<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Stp\PayOrder;

class TestController extends Controller {

    public function test() {
//        return view("welcome");
        $grid = \DataGrid::source(new PayOrder());
        $grid->add('id', 'id', true)->style("width:100px"); //relation.fieldname 
        $grid->add('order_id','Body');;
        $grid->paginate(10);
        return view('test', compact('grid'));
    }

}
