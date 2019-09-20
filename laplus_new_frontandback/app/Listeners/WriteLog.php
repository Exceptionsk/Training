<?php

namespace App\Listeners;

use App\Events\UserAction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Core\Log\LogRepositoryInterface;
use App\Core\Log\Log;

class WriteLog
{
    private $logRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(LogRepositoryInterface $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    /**
     * Handle the event.
     *
     * @param  UserAction  $event
     * @return void
     */
    public function handle(UserAction $event)
    {
        $log = new Log();
        $log->activity = $event->activity;
        $log->user_id = $event->user_id;
        $log->descriptions = $event->descriptions;
        $log->action_time = $event->action_time;
        $this->logRepository->create($log);
    }
}
