<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExchangeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'exchange.quantity' => 'required|integer',
            'exchange.owner_id' => 'required|integer',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'exchange.quantity' => 'cantidad',
        ];
    }

    public function messages()
    {
        return [
            'exchange.quantity.required' => 'Por favor eliga una de las opciones disponibles.',
        ];
    }
}
