<?php

namespace ControleProjetos\Repositories;

use ControleProjetos\Entities\ProjectFile;
use ControleProjetos\Presenters\ProjectFilePresenter;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ProjectRepositoryEloquent
 * @package namespace ControleProjetos\Repositories;
 */
class ProjectFileRepositoryEloquent extends BaseRepository implements ProjectFileRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectFile::class;
    }

    public function presenter()
    {
        return ProjectFilePresenter::class;
    }

}
