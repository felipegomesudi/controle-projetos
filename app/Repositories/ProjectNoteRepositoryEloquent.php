<?php

namespace ControleProjetos\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ControleProjetos\Repositories\ProjectNoteRepository;
use ControleProjetos\Entities\ProjectNote;
use ControleProjetos\Validators\ProjectNoteValidator;

/**
 * Class ProjectNoteRepositoryEloquent
 * @package namespace ControleProjetos\Repositories;
 */
class ProjectNoteRepositoryEloquent extends BaseRepository implements ProjectNoteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectNote::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
