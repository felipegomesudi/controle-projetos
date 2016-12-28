<?php

namespace ControleProjetos\Http\Controllers;

use ControleProjetos\Repositories\ProjectFileRepository;
use ControleProjetos\Services\ProjectFileServices;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

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

    /**
     * @var \Illuminate\Contracts\Filesystem\Factory
     */
    private $storage;

    public function __construct(ProjectFileRepository $repository, ProjectFileServices $service, Factory $storage)
    {
        $this->repository = $repository;
        $this->service    = $service;
        $this->storage    = $storage;
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
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        $data['file'] = $file;
        $data['extension'] = $extension;
        $data['name'] = $request->name;
        $data['project_id'] = $request->project_id;
        $data['description'] = $request->description;
        $data['project_id'] = $id;

        return $this->service->create($data);

    }

    public function showFile($idProject, $id)
    {
        try {
            $model = $this->repository->skipPresenter()->find($id);
            $filePath    = $this->service->getFilePath($id);
            $fileContent = file_get_contents($filePath);
            $file64      = base64_encode($fileContent);
            return [
                'file' => $file64,
                'size' => filesize($filePath),
                'name' => $this->service->getFileName($id),
                'mime_type' => $this->storage->mimeType($model->getFileName())
            ];
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
    public function show($projectId, $id)
    {
//        if($this->service->checkProjectPermissions($id) == false){
//            return ['error'=>'Access Forbidden'];
//        }
        try {
            return $this->repository->find($id);
        } catch (ModelNotFoundException $e) {
            return ['error'=>true, 'Arquivo nao encontrado.'];
        } catch (\Exception $e) {
            return ['error'=>true, 'Ocorreu algum erro ao encontrar o arquivo.'];
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $fileId)
    {
        try {
            $data = $request->all();
            $data['project_id'] = $id;
            $this->service->update($data, $fileId);
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
    public function destroy($projectId, $id)
    {
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
