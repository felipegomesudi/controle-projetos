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

        try{
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        }catch (ValidatorException $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }

        // enviar um email
        // disparar notificacao
        // postar um tweet

    }

    public function update(array $data, $id){

        try{
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        }catch (ValidatorException $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }

    }

}