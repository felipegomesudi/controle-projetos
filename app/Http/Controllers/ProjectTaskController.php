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
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $taskId)
    {
        $result = $this->repository->findWhere(['project_id' => $id, 'id' => $taskId]);
//        if(isset($result) && count($result) == 1){
//            $result = $result[0];
//        }
        return $result;
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
    public function update(Request $request, $id, $taskId)
    {
        try{
            $this->service->update($request->all(), $taskId);
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
