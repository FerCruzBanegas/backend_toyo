<?php

namespace App\Transformers;
use Carbon\Carbon;

class ExchangeTransformer extends Transformer
{
    protected $resourceName = 'exchange';

    public function transform($data)
    {
        return [
            'uuid' => substr($data['uuid'], 0, 8),
            'quantity' => $data['quantity'],
            'owner' => $data['owner']['fullname'],
            'created' => Carbon::parse($data['created_at'])->format('d/m/Y'),
        ];
    }

    public function reject($data)
    {
        return [
            'uuid' => substr($data['uuid'], 0, 8),
            'quantity' => $data['quantity'],
            'owner' => $data['owner']['fullname'],
            'reject' => Carbon::parse($data['reject'])->format('d/m/Y'),
            'created' => Carbon::parse($data['created_at'])->format('d/m/Y'),
        ];
    }

    public function approved($data)
    {
        return [
            'uuid' => substr($data['uuid'], 0, 8),
            'quantity' => $data['quantity'],
            'owner' => $data['owner']['fullname'],
            'delivered' => is_null($data['delivered']) ? '---' : Carbon::parse($data['delivered'])->format('d/m/Y'),
            'created' => Carbon::parse($data['created_at'])->format('d/m/Y'),
        ];
    }
}