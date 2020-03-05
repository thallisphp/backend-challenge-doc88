<?php

namespace App\Http\Requests;

use App\Models\Cliente;
use App\Models\Pastel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePedidoRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array {
        $pasteis  = (new Pastel)->getTable();
        $clientes = (new Cliente)->getTable();

        return [
            'cliente_id'           => [
                'required',
                'integer',
                Rule::exists($clientes, 'id')->whereNull('deleted_at'),
            ],
            'pasteis'              => [
                'required',
                'array',
                'min:1',
            ],
            'pasteis.*.pastel_id'  => [
                'required',
                'integer',
                Rule::exists($pasteis, 'id')->whereNull('deleted_at'),
            ],
            'pasteis.*.quantidade' => [
                'required',
                'integer',
                'min:1',
                'max:10000',
            ],
        ];
    }
}
