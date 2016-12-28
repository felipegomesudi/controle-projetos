<?php
/**
 * Created by PhpStorm.
 * User: Felipe
 * Date: 29/09/2016
 * Time: 17:20
 */

namespace ControleProjetos\Services;


use ControleProjetos\Repositories\ClientRepository;
use ControleProjetos\Validators\ClientValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ClientServices
{

    /**
     * @var ClientRepository
     */
    protected $repository;
    /**
     * @var ClientValidator
     */
    protected $validator;


    public function __construct(ClientRepository $repository, ClientValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(array $data){

        $this->validator->with($data)->passesOrFail();
        return $this->repository->create($data);

    }

    public function update(array $data, $id){

        $this->validator->with($data)->passesOrFail();
        return $this->repository->update($data, $id);

    }

}