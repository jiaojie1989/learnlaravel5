<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DebugEvent extends Event {

    use SerializesModels;

    protected $instance;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($instance) {
        $this->instance = $instance;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn() {
        return [];
    }

    public function getSaved() {
        return $this->instance;
    }

}
