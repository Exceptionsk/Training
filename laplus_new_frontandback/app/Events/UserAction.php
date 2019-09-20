<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserAction extends Event
{
    use SerializesModels;
    public $action;
    public $descriptions;
    public $user_id;
    public $action_time;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($action, $descriptions, $user_id, $action_time )
    {
        $this->activity = $action;
        $this->descriptions = $descriptions;
        $this->user_id = $user_id;
        $this->action_time = $action_time;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
