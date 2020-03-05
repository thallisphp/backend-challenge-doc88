<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePedidoRequest;
use App\Models\Cliente;
use App\Models\Pastel;
use App\Models\Pedido;
use App\Notifications\PedidoRealizado;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PedidoController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator
     */
    public function index() : LengthAwarePaginator {
        return Pedido
            ::query()
            ->with(['cliente' => function ( BelongsTo $query ) : void {
                $query->select([
                    'id',
                    'nome',
                ]);
            }])
            ->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePedidoRequest $request
     *
     * @return Pedido
     */
    public function store( CreatePedidoRequest $request ) : Pedido {
        $pedido = new Pedido;

        /** @var Cliente $cliente */
        $cliente = Cliente
            ::query()
            ->findOrFail($request->input('cliente_id'));

        $pedido->cliente()->associate($cliente);
        $pedido->save();

        $pasteisPedido = collect($request->input('pasteis'))->pluck('quantidade', 'pastel_id');

        Pastel
            ::query()
            ->whereIn('id', $pasteisPedido->keys())
            ->get()
            ->keyBy('id')
            ->each(function ( Pastel $pastel ) use ( $pedido, $pasteisPedido ) : void {
                $pedido->pasteis()->save($pastel, [
                    'quantidade' => $pasteisPedido->get($pastel->id),
                ]);
            });

        $cliente->notifyNow(new PedidoRealizado($pedido));

        return $pedido;
    }

    /**
     * Display the specified resource.
     *
     * @param Pedido $pedido
     *
     * @return Pedido
     */
    public function show( Pedido $pedido ) : Pedido {
        return $pedido->load('cliente', 'pasteis');
    }
}
