<?php

namespace App\Http\Requests;

use App\Models\Cliente;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends CreateClienteRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array {
        /** @var Cliente $cliente */

        $table   = (new Cliente)->getTable();
        $cliente = Route::current()->parameter('cliente');

        return [
            'nome'               => [
                'string',
                'min:5',
                'max:250',
            ],
            'email'              => [
                'string',
                'email',
                'max:100',
                Rule::unique($table, 'email')
                    ->whereNull('deleted_at')
                    ->where('id', '!=', $cliente->id),
            ],
            'telefone'           => [
                'string',
                'min:10',
                'max:20',
            ],
            'data_de_nascimento' => [
                'string',
                'date',
                'before:' . (Carbon::now()->subYears(14)->format('d/m/Y')),
            ],
            'endereco'           => [
                'string',
                'min:5',
                'max:250',
            ],
            'complemento'        => [
                'nullable',
                'string',
                'max:250',
            ],
            'bairro'             => [
                'string',
                'min:5',
                'max:250',
            ],
            'cep'                => [
                'string',
                'min:8',
                'max:9',
            ],
        ];
    }
}
