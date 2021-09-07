<?php

namespace App\Http\Resources\City;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\City\CityResource;

class CityCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($city){
                return new CityResource($city);
            }),
        ];
    }
}
