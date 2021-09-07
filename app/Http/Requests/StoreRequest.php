<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|min:2|max:60',
            'address' => 'nullable|min:3|max:128',
            'phone' => 'nullable|max:32',
            'city_id' => 'required|integer',
        ];

        return $rules;
    }
}
