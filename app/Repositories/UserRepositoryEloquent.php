<?php
/**
 * Created by PhpStorm.
 * User: Felipe
 * Date: 29/09/2016
 * Time: 10:02
 */

namespace ControleProjetos\Repositories;

use ControleProjetos\Entities\User;
use ControleProjetos\Presenters\UserPresenter;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepositoryEloquent extends BaseRepository implements UserRepository {

    protected $fieldSearchable = [
        'name'
    ];

    public function model(){
        return User::class;
    }

    public function presenter()
    {
        return UserPresenter::class;
    }

    public function boot(){
        $this->pushCriteria(app(RequestCriteria::class));
    }

}