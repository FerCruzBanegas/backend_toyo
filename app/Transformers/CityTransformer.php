<?php

namespace App\Transformers;
use Carbon\Carbon;

class CityTransformer extends Transformer
{
    protected $resourceName = 'city';

    public function transform($data)
    {
        return [
            'name' => $data['name'],
            'quantity' => $data['quantity'],
            'created' => Carbon::parse($data['created_at'])->format('d/m/Y'),
            'updated' => Carbon::parse($data['updated_at'])->format('d/m/Y'),
        ];
    }
}