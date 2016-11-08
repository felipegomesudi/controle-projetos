<?php
/**
 * Created by PhpStorm.
 * User: Felipe
 * Date: 29/09/2016
 * Time: 10:02
 */

namespace ControleProjetos\Repositories;


use ControleProjetos\Entities\Client;
use ControleProjetos\Presenters\ClientPresenter;
use Prettus\Repository\Eloquent\BaseRepository;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository {

    protected $fieldSearchable = [
        'name'
    ];

    public function model(){
        return Client::class;
    }
//
//    public function presenter()
//    {
//        return ClientPresenter::class;
//    }

    public function boot(){
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }

}