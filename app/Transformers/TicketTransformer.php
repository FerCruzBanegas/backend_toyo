<?php

namespace App\Transformers;
use Carbon\Carbon;

class TicketTransformer extends Transformer
{
    protected $resourceName = 'ticket';

    public function transform($data)
    {
        return [
            'battery_code' => $data['battery_code'],
            'status' => $data['status'] === 1 ? 'Pendiente' : 'Canjeado',
            'customer'    => $data['customer']['fullname'],
            'owner' => $data['owner']['fullname'],
            'created' => Carbon::parse($data['created_at'])->format('d/m/Y'),
        ];
    }
}