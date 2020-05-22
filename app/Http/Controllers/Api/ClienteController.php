<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ClienteRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ClienteRepository;

class ClienteController extends Controller
{

    /**
     * ClienteController constructor.
     * @param ClienteRepository $clienteRepository
     * @param Request $request
     */
    public function __construct(ClienteRepository $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    /**
     * Retorna uma listagem do recurso.
     */
    public function index()
    {
        return $this->clienteRepository->listar();
    }

    /**
     * Armazena um recurso recém-criado no armazenamento.
     */
    public function store(Request $request)
    {
        return $this->clienteRepository->salvar($request);
    }

    /**
     * Exibe o recurso especificado por Id.
     */
    public function show($id)
    {
        return $this->clienteRepository->BuscarClientePorId($id);
    }

    /**
     * Atualiza o recurso especificado por Id.
     */
    public function update($id, Request $request)
    {
        return $this->clienteRepository->atualizar($id, $request);
    }

    /**
     * Remove o recurso especificado por Id.
     */
    public function destroy($id)
    {
        return $this->clienteRepository->deletar($id);
    }
}
