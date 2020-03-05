<?php

namespace App\Http\Requests;

class UpdatePastelRequest extends CreatePastelRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array {
        return [
            'nome'  => [
                'string',
                'min:5',
                'max:250',
            ],
            'preco' => [
                'numeric',
                'min:0.01',
                'max:100000',
            ],
        ];
    }
}
