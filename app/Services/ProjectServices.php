<?php
/**
 * Created by PhpStorm.
 * User: Felipe
 * Date: 29/09/2016
 * Time: 17:20
 */

namespace ControleProjetos\Services;

use ControleProjetos\Repositories\ProjectRepository;
use ControleProjetos\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectServices
{

    /**
     * @var ProjectRepository
     */
    protected $repository;
    /**
     * @var ProjectValidator
     */
    protected $validator;


    public function __construct(ProjectRepository $repository, ProjectValidator $validator)
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

    public function checkProjectOwner($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();
        return $this->repository->isOwner($projectId, $userId);
    }

    public function checkProjectMember($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();
        return $this->repository->hasMember($projectId, $userId);
    }

    public function checkProjectPermissions($projectId)
    {
        if($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId))
        {
            return true;
        }
        return false;
    }

    public function addMember($project_id, $member_id)
    {
        $project = $this->repository->find($project_id);
        if(!$this->isMember($project_id, $member_id))
        {
            $project->members()->attach($member_id);
        }

        return $project->members()->get();
    }
    public function removeMember($project_id, $member_id)
    {
        $project = $this->repository->find($project_id);
        $project->members()->detach($member_id);

        return $project->members()->get();

    }
    public function isMember($project_id, $member_id)
    {
        $project = $this->repository->find($project_id)->members()->find(['member_id' => $member_id]);
        if(count($project)){
            return true;
        }

        return false;
    }

}