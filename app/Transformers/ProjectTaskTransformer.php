<?php
/**
 * Created by PhpStorm.
 * User: Felipe
 * Date: 06/10/2016
 * Time: 10:27
 */

namespace ControleProjetos\Transformers;

use ControleProjetos\Entities\ProjectTask;
use League\Fractal\TransformerAbstract;

class ProjectTaskTransformer extends TransformerAbstract
{

    public function transform(ProjectTask $projectTask)
    {
        return [
            'id' => $projectTask->id,
            'name' => $projectTask->name,
            'start_date' => $projectTask->start_date,
            'due_date' => $projectTask->due_date,
            'status' => $projectTask->status,
        ];
    }

}