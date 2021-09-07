<?php

namespace App\Http\Resources\Owner;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Owner\OwnerResource;

class OwnerCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($owner){
                return new OwnerResource($owner);
            }),
        ];
    }
}
