<?php

namespace ControleProjetos\Http\Controllers;

use ControleProjetos\Repositories\ProjectRepository;
use ControleProjetos\Services\ProjectServices;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    /**
     * @var ProjectRepository
     */
    private $repository;
    /**
     * @var ProjectServices
     */
    private $service;

    public function __construct(ProjectRepository $repository, ProjectServices $service)
    {
        $this->repository = $repository;
        $this->service    = $service;
        $this->middleware('check.project.owner', ['except'=> ['index', 'store', 'show']]);
        $this->middleware('check.project.permission', ['except'=> ['index', 'store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        return $this->repository->findWithOwnerAndMember(\Authorizer::getResourceOwnerId());
        return $this->repository->findOwner(\Authorizer::getResourceOwnerId(), $request->query->get('limit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($this->service->checkProjectPermissions($id) == false){
            return ['error'=>'Access Forbidden'];
        }
        try {
            return $this->repository->find($id);
        } catch (ModelNotFoundException $e) {
            return ['error'=>true, 'Projeto nao encontrado.'];
        } catch (\Exception $e) {
            return ['error'=>true, 'Ocorreu algum erro ao encontrar o projeto.'];
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($this->service->checkProjectPermissions($id) == false){
            return ['error'=>'Access Forbidden'];
        }
        try {
            $this->service->update($request->all(), $id);
            return ['success'=>true, 'Projeto atualizado com sucesso!'];
        } catch (ModelNotFoundException $e) {
            return ['error'=>true, 'Projeto nao encontrado.'];
        } catch (\Exception $e) {
            return ['error'=>true, 'Ocorreu algum erro ao atualizar o projeto.'];
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->service->checkProjectPermissions($id) == false){
            return ['error'=>'Access Forbidden'];
        }
        try {
            $this->repository->skipPresenter()->find($id)->delete();
            return ['success'=>true, 'Projeto removido com sucesso!'];
        } catch (QueryException $e) {
            return ['error'=>true, 'Projeto nao pode ser removido pois existe um ou mais clientes vinculados a ele.'];
        } catch (ModelNotFoundException $e) {
            return ['error'=>true, 'Projeto nao encontrado.'];
        } catch (\Exception $e) {
            return ['error'=>true, 'Ocorreu algum erro ao excluir o projeto.'];
        }
    }


    public function members($id)
    {
        try {
            $members = $this->repository->skipPresenter()->find($id)->members()->get();
            if (count($members)) {
                return $members;
            }
            return $this->erroMsgm('Esse projeto ainda não tem membros.');
        } catch (ModelNotFoundException $e) {
            return $this->erroMsgm('Projeto não encontrado.');
        } catch (QueryException $e) {
            return $this->erroMsgm('Cliente não encontrado.');
        } catch (\Exception $e) {
            return $this->erroMsgm('Ocorreu um erro ao exibir os membros do projeto.');
        }
    }
    public function addMember($project_id, $member_id)
    {
        try {
            return $this->service->addMember($project_id, $member_id);
        } catch (ModelNotFoundException $e) {
            return $this->erroMsgm('Projeto não encontrado.');
        } catch (QueryException $e) {
            return $this->erroMsgm('Cliente não encontrado.');
        } catch (\Exception $e) {
            return $this->erroMsgm('Ocorreu um erro ao inserir o membro.');
        }
    }
    public function removeMember($project_id, $member_id)
    {
        try {
            return $this->service->removeMember($project_id, $member_id);
        } catch (ModelNotFoundException $e) {
            return $this->erroMsgm('Projeto não encontrado.');
        } catch (QueryException $e) {
            return $this->erroMsgm('Cliente não encontrado.');
        } catch (\Exception $e) {
            return $this->erroMsgm('Ocorreu um erro ao remover o membro.');
        }
    }
    private function erroMsgm($mensagem)
    {
        return [
            'error' => true,
            'message' => $mensagem,
        ];
    }




}
