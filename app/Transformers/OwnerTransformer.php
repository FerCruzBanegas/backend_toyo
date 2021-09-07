<?php

namespace App\Transformers;
use Carbon\Carbon;

class OwnerTransformer extends Transformer
{
    protected $resourceName = 'owner';

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