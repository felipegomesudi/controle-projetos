<?php

namespace ControleProjetos\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ControleProjetos\Repositories\ProjectRepository;
use ControleProjetos\Entities\Project;
use ControleProjetos\Validators\ProjectValidator;

/**
 * Class ProjectRepositoryEloquent
 * @package namespace ControleProjetos\Repositories;
 */
class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Project::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
