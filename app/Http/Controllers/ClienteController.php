<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Controller para gerenciamento de clientes
 *
 * @package App\Http\Controllers
 */
class ClienteController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //
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
     * Display the specified resource.
     *
     * @param \App\Models\Cliente $cliente
     *
     * @return Response
     */
    public function show( Cliente $cliente ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request             $request
     * @param \App\Models\Cliente $cliente
     *
     * @return Response
     */
    public function update( Request $request, Cliente $cliente ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Cliente $cliente
     *
     * @return Response
     */
    public function destroy( Cliente $cliente ) {
        //
    }
}
