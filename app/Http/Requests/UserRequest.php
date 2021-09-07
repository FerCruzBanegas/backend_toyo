<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|min:3|max:64|unique:users,name',
            'email' => 'required|email|max:64|unique:users,email',
        ];

        if($this->method() == 'PATCH' || $this->method() == 'PUT') {
            $rules['name'] .= ',' . $this->id;
            $rules['email'] .= ',' . $this->id;
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'usuario',
            'email' => 'correo',
        ];
    }
}
