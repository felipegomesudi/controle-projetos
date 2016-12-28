<?php

namespace ControleProjetos\Http\Controllers;

use ControleProjetos\Repositories\ClientRepository;
use ControleProjetos\Services\ClientServices;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Exceptions\ValidatorException;

class ClientController extends Controller
{

    /**
     * @var ClientRepository
     */
    private $repository;
    /**
     * @var ClientServices
     */
    private $service;

    public function __construct(ClientRepository $repository, ClientServices $service)
    {
        $this->repository = $repository;
        $this->service    = $service;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->query->get('limit', 15);
        return $this->repository->paginate($limit);
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
        try {
            return $this->service->create($request->all());
        } catch (ValidatorException $e) {
            return Response::json([
                'error' => true,
                'message' => $e->getMessageBag()
            ], 400);
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
        try {
            return $this->repository->find($id);
        } catch (ModelNotFoundException $e) {
            return ['error'=>true, 'Cliente nao encontrado.'];
        } catch (\Exception $e) {
            return ['error'=>true, 'Ocorreu algum erro ao encontrar o cliente.'];
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
        try{
            return $this->service->update($request->all(), $id);
        } catch (QueryException $e) {
            return $this->erroMsgm('Cliente nao pode ser atualizado.');
        } catch (ModelNotFoundException $e) {
            return $this->erroMsgm('Cliente não encontrado.');
        } catch (ValidatorException $e) {
            return Response::json([
                'error' => true,
                'message' => $e->getMessageBag()
            ], 400);
        } catch (\Exception $e) {
            return $this->erroMsgm('Ocorreu um erro ao atualizar o cliente.');
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
        try {
            $this->repository->find($id)->delete();
            return [
                'success' => true,
                'message' => "Cliente deletado com sucesso!"
            ];
        } catch (QueryException $e) {
            return $this->erroMsgm('Cliente não pode ser apagado pois existe um ou mais projetos vinculados a ele.');
        } catch (ModelNotFoundException $e) {
            return $this->erroMsgm('Cliente não encontrado.');
        } catch (\Exception $e) {
            return $this->erroMsgm('Ocorreu um erro ao excluir o cliente.');
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
