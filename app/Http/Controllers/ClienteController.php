<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Controller para gerenciamento de clientes
 *
 * @package App\Http\Controllers
 */
class ClienteController extends Controller {
    /**
     * Retorna uma lista paginada de clientes
     *
     * @return LengthAwarePaginator
     */
    public function index() : LengthAwarePaginator {
        return Cliente::query()->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateClienteRequest $request
     *
     * @return Cliente
     */
    public function store( CreateClienteRequest $request ) : Cliente {
        return Cliente::query()->create($request->validated());
    }

    /**
     * Retorna os dados de um cliente
     *
     * @param Cliente $cliente
     *
     * @return Cliente
     */
    public function show( Cliente $cliente ) : Cliente {
        return $cliente;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateClienteRequest $request
     * @param Cliente              $cliente
     *
     * @return Cliente
     */
    public function update( UpdateClienteRequest $request, Cliente $cliente ) : Cliente {
        $cliente->update($request->validated());

        return $cliente;
    }

    /**
     * Remove um cliente
     *
     * @param Cliente $cliente
     *
     * @throws Exception
     */
    public function destroy( Cliente $cliente ) : void {
        $cliente->delete();
    }
}
