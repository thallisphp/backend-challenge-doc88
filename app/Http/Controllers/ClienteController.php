<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @param Request $request
     *
     * @return Response
     */
    public function store( Request $request ) {
        //
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
     * @param Request $request
     * @param Cliente $cliente
     *
     * @return Response
     */
    public function update( Request $request, Cliente $cliente ) {
        //
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
