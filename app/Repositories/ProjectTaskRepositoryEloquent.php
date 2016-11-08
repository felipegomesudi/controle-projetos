<?php

namespace ControleProjetos\Repositories;

use ControleProjetos\Entities\ProjectTask;
use ControleProjetos\Presenters\ProjectTaskPresenter;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ProjectRepositoryEloquent
 * @package namespace ControleProjetos\Repositories;
 */
class ProjectTaskRepositoryEloquent extends BaseRepository implements ProjectTaskRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectTask::class;
    }

    public function presenter()
    {
        return ProjectTaskPresenter::class;
    }

}
