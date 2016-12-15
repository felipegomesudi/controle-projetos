<?php

namespace ControleProjetos\Http\Controllers;

use ControleProjetos\Repositories\ProjectTaskRepository;
use ControleProjetos\Services\ProjectTaskServices;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{

    /**
     * @var ProjectTaskRepository
     */
    private $repository;
    /**
     * @var ProjectTaskServices
     */
    private $service;

    public function __construct(ProjectTaskRepository $repository, ProjectTaskServices $service)
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $data = $request->all();
        $data['project_id'] = $id;
        return $this->service->create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $taskId)
    {
//        $result = $this->repository->findWhere(['project_id' => $id, 'id' => $taskId]);
//        return $result;
        return $this->repository->find($taskId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $taskId)
    {
        try{
            $data = $request->all();
            $data['project_id'] = $id;
            $this->service->update($data, $taskId);
            return "Update concluido";
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $taskId)
    {
        $this->repository->skipPresenter()->find($taskId)->delete();
    }

}
