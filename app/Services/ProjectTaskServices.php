<?php
/**
 * Created by PhpStorm.
 * User: Felipe
 * Date: 29/09/2016
 * Time: 17:20
 */

namespace ControleProjetos\Services;

use ControleProjetos\Repositories\ProjectRepository;
use ControleProjetos\Repositories\ProjectTaskRepository;
use ControleProjetos\Validators\ProjectTaskValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectTaskServices
{

    /**
     * @var ProjectTaskRepository
     */
    protected $repository;
    /**
     * @var ProjectRepository
     */
    protected $projectRepository;
    /**
     * @var ProjectTaskValidator
     */
    protected $validator;


    public function __construct(ProjectTaskRepository $repository, ProjectRepository $projectRepository, ProjectTaskValidator $validator)
    {
        $this->repository = $repository;
        $this->projectRepository = $projectRepository;
        $this->validator = $validator;
    }

    public function create(array $data){

        try{
            $this->validator->with($data)->passesOrFail();

            $project = $this->projectRepository->skipPresenter()->find($data['project_id']);
            $projectTask = $project->tasks()->create($data);

            return $projectTask;

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