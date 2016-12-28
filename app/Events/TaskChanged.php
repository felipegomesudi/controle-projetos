<?php

namespace ControleProjetos\Events;

use ControleProjetos\Entities\ProjectTask;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TaskChanged extends Event implements ShouldBroadcast {

    use SerializesModels;

    public $task;

    public function __construct(ProjectTask $task){
        $this->task = $task;
    }

    public function broadcastOn()
    {
        return ['user.'. \Authorizer::getResourceOwnerId()];
    }

}