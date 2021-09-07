<?php

namespace App\Http\Resources\Exchange;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Exchange\ExchangeResource;

class ExchangeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($exchange){
                return new ExchangeResource($exchange);
            }),
        ];
    }
}
