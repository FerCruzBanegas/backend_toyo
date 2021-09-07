<?php

namespace App\Transformers;
use Carbon\Carbon;

class CustomerTransformer extends Transformer
{
    protected $resourceName = 'customer';

    public function transform($data)
    {
        return [
            'names' => $data['names'],
            'surnames' => $data['surnames'],
            'phone'    => $data['phone'],
            'ci' => $data['ci'],
            'tickets' => $data['tickets']->count(),
            'created' => Carbon::parse($data['created_at'])->format('d/m/Y'),
        ];
    }
}