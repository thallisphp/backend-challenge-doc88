<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePastelRequest extends FormRequest {
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
        return [
            'nome'  => [
                'required',
                'string',
                'min:5',
                'max:250',
            ],
            'preco' => [
                'required',
                'numeric',
                'min:0.01',
                'max:100000',
            ],
        ];
    }
}
