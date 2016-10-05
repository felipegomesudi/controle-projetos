<?php
/**
 * Created by PhpStorm.
 * User: Felipe
 * Date: 29/09/2016
 * Time: 10:02
 */

namespace ControleProjetos\Repositories;


use ControleProjetos\Entities\Client;
use Prettus\Repository\Eloquent\BaseRepository;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository {

    public function model(){
        return Client::class;
    }

}