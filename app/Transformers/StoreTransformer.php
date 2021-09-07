<?php

namespace App\Transformers;
use Carbon\Carbon;

class StoreTransformer extends Transformer
{
    protected $resourceName = 'store';

    public function transform($data)
    {
        $collection = collect($data['owners']);

        $total = $collection->reduce(function ($carry, $item) {
            return $carry + $item->tickets->count();
        });

        return [
            'name' => $data['name'],
            'city' => $data['city']['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'tickets' => is_null($total) ? '0' : $total,
            'created' => Carbon::parse($data['created_at'])->format('d/m/Y'),
        ];
    }
}