<?php

namespace App\Http\Controllers\Api;

use App\Enums\Mensagem;
use App\Enums\StatusCode;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Filme;
use App\Traits\FileSystemLogic;
use Illuminate\Support\Facades\Validator;

class FilmeController extends ApiController
{

    use FileSystemLogic;

    /**
     * Construtor de varáveis inicias
     */
    public function __construct(Filme $filme)
    {
        $this->filme = $filme;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!$data = $this->filme->orderBy('id', 'asc')->paginate($this->totalPages)) {
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

        $validator = Validator::make($data, $this->filme->rules(), $this->filme->messages());

        if ($validator->fails())
            return $this->errorResponse($validator->errors(), Mensagem::MSG009, StatusCode::BAD_REQUEST);

        if (isset($data['capa'])) {
            if (!$path = $this->storeCapaFilme($request))
                return $this->errorResponse([], Mensagem::MSG008, StatusCode::INTERNAL_SERVER_ERROR);

            $data['capa'] = $path;
        }

        if (!$response = $this->filme->create($data))
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

        if (!$data = $this->filme->find($id))
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

        $validator = Validator::make($data, $this->filme->rules($id), $this->filme->messages());

        if ($validator->fails())
            return $this->errorResponse($validator->errors(), Mensagem::MSG009, StatusCode::BAD_REQUEST);

        if (!checkId($id))
            return $this->errorResponse([], Mensagem::MSG003, StatusCode::BAD_REQUEST);

        if (!$filme = $this->filme->find($id))
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);

        if (isset($data['capa'])) {
            if (!$path = $this->storeCapaFilme($request, $filme))
                return $this->errorResponse([], Mensagem::MSG008, StatusCode::INTERNAL_SERVER_ERROR);

            $data['capa'] = $path;
        }

        if (!$response =  $filme->update($data))
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

        if (!$filme = $this->filme->find($id))
            return $this->errorResponse([], Mensagem::MSG001, StatusCode::NOT_FOUND);

        if (!$filme->delete())
            return $this->errorResponse([], Mensagem::MSG002, StatusCode::UNPROCESSABLE_ENTITY);

        return $this->successResponse([], Mensagem::MSG004, StatusCode::OK);
    }

}
