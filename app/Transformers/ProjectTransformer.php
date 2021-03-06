<?php
/**
 * Created by PhpStorm.
 * User: Felipe
 * Date: 06/10/2016
 * Time: 10:27
 */

namespace ControleProjetos\Transformers;

use ControleProjetos\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['members', 'notes', 'tasks', 'files', 'client'];
//    protected $availableIncludes = [];

    public function transform(Project $project)
    {
        return [
            'project_id' => $project->id,
            'client_id' => $project->client_id,
            'owner_id' => $project->owner_id,
            'name' => $project->name,
            'description' => $project->description,
            'progress' => (int) $project->progress,
            'status' => $project->status,
            'due_date' => $project->due_date,
            'is_member' => $project->owner_id != \Authorizer::getResourceOwnerId(),
            'tasks_count' => $project->tasks->count(),
            'tasks_opened' => $this->countTasksOpened($project)
        ];
    }

    public function includeMembers(Project $project){
        return $this->collection($project->members, new MemberTransformer());
    }

    public function includeNotes(Project $project){
        return $this->collection($project->notes, new ProjectNoteTransformer());
    }

    public function includeTasks(Project $project){
        return $this->collection($project->tasks, new ProjectTaskTransformer());
    }

    public function includeFiles(Project $project){
        return $this->collection($project->files, new ProjectFileTransformer());
    }

    public function includeClient(Project $project){
//        if($project->client){
//            return $this->item($project->client, new ClientTransformer());
//        }
//        return null;
        return $this->item($project->client, new ClientTransformer());
    }

    public function countTasksOpened(Project $project){
        $count = 0;
        foreach ($project->tasks as $o){
            if($o->status == 1){
                $count++;
            }
        }
        return $count;
    }

}