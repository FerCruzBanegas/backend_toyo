<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\UsesCustomErrorMessage;

class ResetPasswordRequest extends FormRequest
{
    use UsesCustomErrorMessage;
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'email' => 'required|email',
        ];

        if ($this->path() == 'api/v1/password/reset') {
            $rules['token'] = 'required';
            $rules['password'] = 'required|min:6|max:64';
            $rules['password_confirmation'] = 'required|min:6|max:64|same:password';
        }

        return $rules;
    }

    public function message()
    {
        return 'Por favor verifique los errores a continuación.';
    }
}
