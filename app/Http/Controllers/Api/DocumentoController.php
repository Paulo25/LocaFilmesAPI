<?php

namespace App\Http\Controllers\Api;

use App\Enums\Mensagem;
use App\Enums\StatusCode;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Documento;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DocumentoController extends ApiController
{

    public function __construct(Documento $documento)
    {
        $this->documento = $documento;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!$data = $this->documento->orderBy('id', 'asc')->get()) {
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);
        }

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

        $validator = Validator::make($data, $this->documento->rules(), $this->documento->messages());

        if ($validator->fails())
            return $this->errorResponse($validator->errors(), Mensagem::MSG009, StatusCode::BAD_REQUEST);

        if (!$response = $this->documento->create($data))
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

        if (!$data = $this->documento->find($id))
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);

        return $this->successResponse($data, Mensagem::MSG010, StatusCode::OK);
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

        $validator = Validator::make($data, $this->documento->rules($data['cliente_id']), $this->documento->messages());

        if ($validator->fails())
            return $this->errorResponse($validator->errors(), Mensagem::MSG009, StatusCode::BAD_REQUEST);

        if (!checkId($id))
            return $this->errorResponse([], Mensagem::MSG003, StatusCode::BAD_REQUEST);

        if (!$documento = $this->documento->find($id))
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);

        if (!$response =  $documento->update($data))
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

        if (!$documento = $this->documento->find($id))
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);

        if (!$documento->delete())
            return $this->errorResponse([], Mensagem::MSG002, StatusCode::UNPROCESSABLE_ENTITY);

        return $this->successResponse([], Mensagem::MSG004, StatusCode::OK);
    }

    /**
     * recuperar documento do cliente por Id.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function cliente($id)
    {
        if (!$data = $this->documento->with('cliente')->find($id))
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);

        return $this->successResponse($data, Mensagem::MSG010, StatusCode::OK);
    }
}
