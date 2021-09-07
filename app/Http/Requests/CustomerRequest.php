<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'names' => 'required|min:3|max:64',
            'surnames' => 'required|min:3|max:64',
            'phone' => 'required|max:32',
            'ci' => 'required|max:32|unique:customers,ci',
            'address' => 'nullable|max:128',
        ];

        if($this->method() == 'PATCH' || $this->method() == 'PUT') {
            $rules['ci'] .= ',' . $this->id;
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'names' => 'nombre(s)',
            'surnames' => 'apellido(s)',
            'phone' => 'teléfono',
            'ci' => 'ci',
            'address' => 'dirección',
        ];
    }
}
