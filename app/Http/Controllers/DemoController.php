<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Event;
use App\Events\DebugEvent;

class DemoController extends Controller {

    public function getNudecomponent() {
        
    }

    public function putNudecomponent() {
        
    }

    public function getIndex() {
        
    }

    public function test() {
        
    }

    public function anyTest() {
        $time = date("Y-m-d H:i:s");
        Event::fire(new DebugEvent($time));
        $i = 0;
        while ($i++ < 300) {
//            $job = (new \App\Jobs\SendReminderEmail(date("Y-m-d H:i:s")))->delay(10);
            $job = (new \App\Jobs\SendReminderEmail(date("Y-m-d H:i:s")));
            $this->dispatch($job);
        }
        return $time;
    }

}
