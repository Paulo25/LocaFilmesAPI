<?php

namespace App\Http\Controllers\Api;

use App\Enums\Mensagem;
use App\Enums\StatusCode;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Telefone;
use Illuminate\Support\Facades\Validator;

class TelefoneController extends ApiController
{

    /**
     * Contrução de instancias inicializa incialmente
     */
    public function __construct(Telefone $telefone)
    {
        $this->telefone = $telefone;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!$data = $this->telefone->orderBy('id', 'asc')->paginate($this->totalPages))
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);

        return $this->successResponse($data, Mensagem::MSG010, StatusCode::OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validate = Validator::make($data, $this->telefone->rules(), $this->telefone->messages());

        if ($validate->fails())
            return $this->errorResponse($validate->errors(), Mensagem::MSG009, StatusCode::BAD_REQUEST);

        if (!$response = $this->telefone->create($data))
            return $this->errorResponse([], Mensagem::MSG002, StatusCode::UNPROCESSABLE_ENTITY);

        return $this->successResponse($response, Mensagem::MSG007, StatusCode::CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!checkId($id))
            return $this->errorResponse([], Mensagem::MSG003, StatusCode::BAD_REQUEST);

        if (!$response = $this->telefone->find($id))
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);

        return $this->successResponse($response, Mensagem::MSG010, StatusCode::OK);
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
        $data = $request->except('_method');

        $validator = Validator::make($data, $this->telefone->rules($id), $this->telefone->messages());

        if ($validator->fails())
            return $this->errorResponse($validator->errors(), Mensagem::MSG009, StatusCode::BAD_REQUEST);

        if (!checkId($id))
            return $this->errorResponse([], Mensagem::MSG003, StatusCode::BAD_REQUEST);

        if (!$telefone = $this->telefone->find($id))
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);

        if (!$response =  $telefone->update($data))
            return $this->errorResponse([], Mensagem::MSG002, StatusCode::UNPROCESSABLE_ENTITY);

        return $this->successResponse($response, Mensagem::MSG006, StatusCode::OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!checkId($id))
            return $this->errorResponse([], Mensagem::MSG003, StatusCode::BAD_REQUEST);

        if (!$telefone =  $this->telefone->find($id))
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);

        if (!$telefone->delete())
            return $this->errorResponse([], Mensagem::MSG002, StatusCode::UNPROCESSABLE_ENTITY);

        return $this->successResponse([], Mensagem::MSG004, StatusCode::OK);
    }

    /**
     * recuperar cliente do telefone por Id.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function cliente($id)
    {
        if (!checkId($id))
            return $this->errorResponse([], Mensagem::MSG003, StatusCode::BAD_REQUEST);

        if (!$data = $this->telefone->with('cliente')->find($id))
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);

        return $this->successResponse($data, Mensagem::MSG010, StatusCode::OK);
    }
}
