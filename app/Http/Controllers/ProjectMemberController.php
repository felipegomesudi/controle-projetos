<?php

namespace ControleProjetos\Http\Controllers;

use ControleProjetos\Repositories\ProjectMemberRepository;
use ControleProjetos\Services\ProjectMemberServices;
use Illuminate\Http\Request;

class ProjectMemberController extends Controller
{

    /**
     * @var ProjectMemberRepository
     */
    private $repository;
    /**
     * @var ProjectMemberServices
     */
    private $service;

    public function __construct(ProjectMemberRepository $repository, ProjectMemberServices $service)
    {
        $this->repository = $repository;
        $this->service    = $service;
        $this->middleware('check.project.owner', ['except'=> ['index', 'show']]);
        $this->middleware('check.project.permission', ['except'=> ['store', 'destroy']]);
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
    public function show($id, $idProjectMember)
    {
        return $this->repository->find($idProjectMember);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $idProjectMember)
    {
        $this->service->delete($idProjectMember);
    }

}
