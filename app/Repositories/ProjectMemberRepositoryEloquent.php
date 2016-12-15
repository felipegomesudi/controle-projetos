<?php

namespace ControleProjetos\Repositories;

use ControleProjetos\Entities\ProjectMember;
use ControleProjetos\Presenters\ProjectMemberPresenter;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ProjectRepositoryEloquent
 * @package namespace ControleProjetos\Repositories;
 */
class ProjectMemberRepositoryEloquent extends BaseRepository implements ProjectMemberRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectMember::class;
    }

    public function presenter()
    {
        return ProjectMemberPresenter::class;
    }

    public function boot(){
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }

}
