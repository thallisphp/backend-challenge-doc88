<?php

namespace App\Http\Requests;

use App\Models\Cliente;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateClienteRequest extends FormRequest {
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
        $table = (new Cliente)->getTable();

        return [
            'nome'               => [
                'required',
                'string',
                'min:5',
                'max:250',
            ],
            'email'              => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique($table, 'email')
                    ->whereNull('deleted_at'),
            ],
            'telefone'           => [
                'required',
                'string',
                'min:10',
                'max:20',
            ],
            'data_de_nascimento' => [
                'required',
                'string',
                'date',
                'before:' . (Carbon::now()->subYears(14)->format('d/m/Y')),
            ],
            'endereco'           => [
                'required',
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
                'required',
                'string',
                'min:5',
                'max:250',
            ],
            'cep'                => [
                'required',
                'string',
                'min:8',
                'max:9',
            ],
        ];
    }
}
