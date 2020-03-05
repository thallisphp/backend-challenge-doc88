<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PastelController;
use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route
    ::middleware('auth.basic')
    ->name('api.')
    ->group(function () : void {
        Route::apiResource('cliente', ClienteController::class);
        Route::apiResource('pastel', PastelController::class);
        Route::apiResource('pedido', PedidoController::class)->only([
            'index',
            'show',
            'store',
        ]);
    });

Route::get('mail', function () {
    /** @var \App\Models\Pedido $pedido */
    $pedido = \App\Models\Pedido::query()->find(1);

    return (new \App\Notifications\PedidoRealizado($pedido))
        ->toMail($pedido->cliente);
});
