<?php

namespace ControleProjetos\Http\Controllers;

use ControleProjetos\Repositories\ProjectFileRepository;
use ControleProjetos\Services\ProjectFileServices;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectFileController extends Controller
{

    /**
     * @var ProjectFileRepository
     */
    private $repository;
    /**
     * @var ProjectFileServices
     */
    private $service;

    public function __construct(ProjectFileRepository $repository, ProjectFileServices $service)
    {
        $this->repository = $repository;
        $this->service    = $service;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return $this->repository->findWhere(['project_id' => $id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        $data['file'] = $file;
        $data['extension'] = $extension;
        $data['name'] = $request->name;
        $data['project_id'] = $request->project_id;
        $data['description'] = $request->description;

        //$this->service->createFile($data);
        return $this->service->create($data);

    }

    public function showFile($id)
    {
        if($this->service->checkProjectPermissions($id) == false){
            return ['error'=>'Access Forbidden'];
        }
        try {
            return response()->download($this->service->getFilePath($id));
        } catch (ModelNotFoundException $e) {
            return ['error'=>true, 'Arquivo nao encontrado.'];
        } catch (\Exception $e) {
            return ['error'=>true, 'Ocorreu algum erro ao encontrar o arquivo.'];
        }
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
            return ['error'=>true, 'Arquivo nao encontrado.'];
        } catch (\Exception $e) {
            return ['error'=>true, 'Ocorreu algum erro ao encontrar o arquivo.'];
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
            return ['success'=>true, 'Arquivo atualizado com sucesso!'];
        } catch (ModelNotFoundException $e) {
            return ['error'=>true, 'Arquivo nao encontrado.'];
        } catch (\Exception $e) {
            return ['error'=>true, 'Ocorreu algum erro ao atualizar o arquivo.'];
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
            $this->service->delete($id);
            return ['success'=>true, 'Arquivo removido com sucesso!'];
        } catch (QueryException $e) {
            return ['error'=>true, 'Arquivo nao pode ser removido.'];
        } catch (ModelNotFoundException $e) {
            return ['error'=>true, 'Arquivo nao encontrado.'];
        } catch (\Exception $e) {
            return ['error'=>true, 'Ocorreu algum erro ao excluir o arquivo.'];
        }
    }

}
