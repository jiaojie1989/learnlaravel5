<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReminderEmail extends Job implements ShouldQueue {

    use InteractsWithQueue,
        SerializesModels;

    protected $instance;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($instance) {
        $this->instance = $instance;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
//        throw new \Exception("1");
        error_log("s {$this->instance} - e " . date("Y-m-d H:i:s") . "\n", 3, "/tmp/error.ee");
    }

}
