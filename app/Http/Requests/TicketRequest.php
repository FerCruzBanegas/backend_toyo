<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'ticket.battery_code' => 'required|min:10|max:13|unique:tickets,battery_code',
            // 'ticket.store_id' => 'required|integer',
            //'customer_id' => 'required|integer'
            'customer.names' => 'required|min:3|max:64',
            'customer.surnames' => 'required|min:3|max:64',
            'customer.phone' => 'required|max:32',
            
            'customer.address' => 'nullable|max:128',
        ];

        if(!request()->filled('customer.id')) {
            $rules['customer.ci'] = 'required|max:32|unique:customers,ci';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'ticket.battery_code' => 'código batería',
            'customer.names' => 'nombre(s)',
            'customer.surnames' => 'apellido(s)',
            'customer.phone' => 'teléfono',
            'customer.ci' => 'ci',
            'customer.address' => 'dirección',
        ];
    }
}
