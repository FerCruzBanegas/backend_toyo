<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'owner.names' => 'required|min:3|max:64',
            'owner.surnames' => 'required|min:3|max:64',
            'owner.phone' => 'required|max:32',
            'owner.ci' => 'required|max:32',
            'owner.store_id' => 'required|integer',
            'user.email' => 'required|email|max:64|unique:users,email',
            'user.password' => 'required|min:6|max:64',
            'user.password_confirmation' => 'required|min:6|max:64|same:user.password',
            // 'store.address' => 'required|max:128',
            // 'store.city_id' => 'required|integer'
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'owner.names' => 'nombre(s)',
            'owner.surnames' => 'apellido(s)',
            'owner.phone' => 'teléfono',
            'owner.ci' => 'ci',
            'user.email' => 'correo electrónico',
            'user.password' => 'contraseña',
            'user.password_confirmation' => 'confirmación',
            // 'store.address' => 'dirección',
            // 'store.city_id' => 'ciudad'
        ];
    }
}
