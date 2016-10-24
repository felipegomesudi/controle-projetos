<?php
/**
 * Created by PhpStorm.
 * User: Felipe
 * Date: 29/09/2016
 * Time: 10:02
 */

namespace ControleProjetos\Repositories;

use ControleProjetos\Entities\User;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepositoryEloquent extends BaseRepository implements UserRepository {

    public function model(){
        return User::class;
    }

}