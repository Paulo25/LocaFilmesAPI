<?php

namespace App\Repositories;

use App\Models\Cliente;
use App\Enums\Mensagem;
use App\Enums\StatusCode;
use App\Traits\FileSystemLogic;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ClienteRepository
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
            return response()->json(['error' => Mensagem::MSG001], StatusCode::NOT_FOUND);
        }

        return response()->json($data, StatusCode::OK);
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
            return response()->json($validator->messages(), StatusCode::BAD_REQUEST);

        if (!$path = $this->storeImage($request))
            return response()->json(['error' => Mensagem::MSG008], StatusCode::INTERNAL_SERVER_ERROR);

        $data['image'] = $path;

        if (!$response = $this->cliente->create($data))
            return response()->json(['success' => Mensagem::MSG002], StatusCode::UNPROCESSABLE_ENTITY);

        return response()->json(['success' => Mensagem::MSG007, $response], StatusCode::CREATED);
    }


    /**
     * Buscar o recurso especificado por Id.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function BuscarClientePorId($id)
    {

        if (!checkId($id))
            return response()->json(['error' => Mensagem::MSG003], StatusCode::BAD_REQUEST);

        if (!$data = $this->cliente->find($id))
            return response()->json(['error' => Mensagem::MSG001], StatusCode::NOT_FOUND);

        return response()->json($data, StatusCode::OK);
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
            return response()->json($validator->messages(), StatusCode::BAD_REQUEST);

        if (!checkId($id))
            return response()->json(['error' => Mensagem::MSG003], StatusCode::BAD_REQUEST);

        if (!$cliente = $this->cliente->find($id))
            return response()->json(['error' => Mensagem::MSG001], StatusCode::NOT_FOUND);

        if (isset($data['image'])) {
            if (!$path = $this->storeImage($request, $cliente))
                return response()->json(['error' => Mensagem::MSG008], StatusCode::INTERNAL_SERVER_ERROR);

            $data['image'] = $path;
        }

        if (!$response =  $cliente->update($data))
            return response()->json(['success' => Mensagem::MSG002], StatusCode::UNPROCESSABLE_ENTITY);

        return response()->json(['success' => Mensagem::MSG006, 'id' => $id, $data], StatusCode::OK);
    }

    /**
     * Remove o recurso especificado por Id.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletar($id)
    {
        if (!checkId($id))
            return response()->json(['error' => Mensagem::MSG003], StatusCode::BAD_REQUEST);

        if (!$data = $this->cliente->find($id))
            return response()->json(['error' => Mensagem::MSG001], StatusCode::NOT_FOUND);

        if ($data->image)
            Storage::disk('public')->delete("/clientes/$data->image");

        if (!$data->delete())
            return response()->json(['error' => Mensagem::MSG002], StatusCode::UNPROCESSABLE_ENTITY);

        return response()->json(['success' => Mensagem::MSG004], StatusCode::OK);
    }
}
