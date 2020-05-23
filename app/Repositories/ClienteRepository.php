<?php

namespace App\Repositories;

use App\Models\Cliente;
use App\Enums\Mensagem;
use App\Enums\StatusCode;
use App\Traits\FileSystemLogic;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;

class ClienteRepository extends ApiController
{

    use FileSystemLogic;

    /**
     * ClienteRepository constructor.
     * @param Cliente $cliente
     */
    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * Exibe uma listagem do recurso.
     * @return \Illuminate\Http\JsonResponse
     */
    public function listar()
    {
        if (!$data = $this->cliente->orderBy('id', 'desc')->get()) {
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);
        }

        return $this->successResponse($data, Mensagem::MSG010, StatusCode::OK);
    }

    /**
     * Armazena um recurso na base.
     * @param null $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function salvar($request)
    {
        $data = $request->all();

        $validator = Validator::make($data, $this->cliente->rules(), $this->cliente->messages());

        if ($validator->fails())
            return $this->errorResponse([], $validator->errors(), StatusCode::BAD_REQUEST);

        if (!$path = $this->storeImage($request))
            return $this->errorResponse([], Mensagem::MSG008, StatusCode::INTERNAL_SERVER_ERROR);

        $data['image'] = $path;

        if (!$response = $this->cliente->create($data))
            return $this->errorResponse([], Mensagem::MSG002, StatusCode::UNPROCESSABLE_ENTITY);

        return $this->successResponse($response, Mensagem::MSG007, StatusCode::CREATED);
    }


    /**
     * Buscar o recurso especificado por Id.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function BuscarClientePorId($id)
    {

        if (!checkId($id))
            return $this->errorResponse([], Mensagem::MSG003, StatusCode::BAD_REQUEST);

        if (!$data = $this->cliente->find($id))
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);

        return $this->successResponse($data, Mensagem::MSG010, StatusCode::OK);
    }

    /**
     * Atualiza o recurso especificado por Id.
     * @param $id
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function atualizar($id, $request)
    {
        $data = $request->except('_method');

        $validator = Validator::make($data, $this->cliente->rules($id), $this->cliente->messages());

        if ($validator->fails())
            return $this->errorResponse([], $validator->errors(), StatusCode::BAD_REQUEST);

        if (!checkId($id))
            return $this->errorResponse([], Mensagem::MSG003, StatusCode::BAD_REQUEST);

        if (!$cliente = $this->cliente->find($id))
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);

        if (isset($data['image'])) {
            if (!$path = $this->storeImage($request, $cliente))
                return $this->errorResponse([], Mensagem::MSG008, StatusCode::INTERNAL_SERVER_ERROR);

            $data['image'] = $path;
        }

        if (!$response =  $cliente->update($data))
            return $this->errorResponse([], Mensagem::MSG002, StatusCode::UNPROCESSABLE_ENTITY);

        return $this->successResponse($response, Mensagem::MSG006, StatusCode::OK);
    }

    /**
     * Remove o recurso especificado por Id.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletar($id)
    {
        if (!checkId($id))
            return $this->errorResponse([], Mensagem::MSG003, StatusCode::BAD_REQUEST);

        if (!$cliente = $this->cliente->find($id))
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);

        if ($cliente->image)
            Storage::disk('public')->delete("/clientes/$cliente->image");

        if (!$cliente->delete())
            return $this->errorResponse([], Mensagem::MSG002, StatusCode::UNPROCESSABLE_ENTITY);

        return $this->successResponse([], Mensagem::MSG004, StatusCode::OK);
    }
}
