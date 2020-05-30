<?php

namespace App\Http\Controllers\Api;

use App\Enums\Mensagem;
use App\Enums\StatusCode;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Traits\FileSystemLogic;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ClienteController extends ApiController
{
    use FileSystemLogic;

    /**
     * ClienteController constructor.
     * @param Cliente $cliente
     * @param Request $request
     */
    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * Exibe uma listagem do recurso.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (!$data = $this->cliente->orderBy('id', 'asc')->paginate($this->totalPages)) {
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);
        }

        return $this->successResponse($data, Mensagem::MSG010, StatusCode::OK);
    }

    /**
     * Armazena um recurso na base.
     * @param null $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, $this->cliente->rules(), $this->cliente->messages());

        if ($validator->fails())
            return $this->errorResponse($validator->errors(), Mensagem::MSG009, StatusCode::BAD_REQUEST);

        if (isset($data['image'])) {
            if (!$path = $this->storeImage($request))
                return $this->errorResponse([], Mensagem::MSG008, StatusCode::INTERNAL_SERVER_ERROR);

            $data['image'] = $path;
        }

        if (!$response = $this->cliente->create($data))
            return $this->errorResponse([], Mensagem::MSG002, StatusCode::UNPROCESSABLE_ENTITY);

        return $this->successResponse($response, Mensagem::MSG007, StatusCode::CREATED);
    }

    /**
     * Buscar o recurso especificado por Id.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
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
    public function update($id, Request $request)
    {
        $data = $request->except('_method');

        $validator = Validator::make($data, $this->cliente->rules($id), $this->cliente->messages());

        if ($validator->fails())
            return $this->errorResponse($validator->errors(), Mensagem::MSG009, StatusCode::BAD_REQUEST);

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
    public function destroy($id)
    {
        if (!checkId($id))
            return $this->errorResponse([], Mensagem::MSG003, StatusCode::BAD_REQUEST);

        if (!$cliente = $this->cliente->find($id))
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);

        if ($cliente->image)
            Storage::disk('public')->delete("/{$cliente->image}");

        if (!$cliente->delete())
            return $this->errorResponse([], Mensagem::MSG002, StatusCode::UNPROCESSABLE_ENTITY);

        return $this->successResponse([], Mensagem::MSG004, StatusCode::OK);
    }

    /**
     * recuperar documento do cliente por Id.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function documento($id)
    {
        if (!$data = $this->cliente->with('documento')->find($id))
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);

        return $this->successResponse($data, Mensagem::MSG010, StatusCode::OK);
    }


    /**
     * recuperar documento do cliente por Id.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function telefone($id)
    {
        if (!checkId($id))
            return $this->errorResponse([], Mensagem::MSG003, StatusCode::BAD_REQUEST);

        if (!$data = $this->cliente->with('telefone')->find($id))
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);

        return $this->successResponse($data, Mensagem::MSG010, StatusCode::OK);
    }

    /**
     * recuperar filmes alugados do cliente por Id.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function filmeAlugado($id)
    {
        if (!checkId($id))
            return $this->errorResponse([], Mensagem::MSG003, StatusCode::BAD_REQUEST);

        if (!$data = $this->cliente->with('filmesAlugados')->find($id))
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);

        return $this->successResponse($data, Mensagem::MSG010, StatusCode::OK);
    }

    /**
     * retorna um cliente completo (documento, telefone e filmes alugados)
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function clienteCompleto($id)
    {
        if (!checkId($id))
            return $this->errorResponse([], Mensagem::MSG003, StatusCode::BAD_REQUEST);

        if (!$cliente = $this->cliente->find($id))
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);

        $cliente->telefone;
        $cliente->documento;
        $cliente->filmesAlugados;

        return $this->successResponse($cliente, Mensagem::MSG010, StatusCode::OK);
    }
}
