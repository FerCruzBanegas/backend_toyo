<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StoreListCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->transform(function($store){
            return [
                'id' => $store->id,
                'name' => $store->name,
                'address' => $store->address,
                'city' => $store->city->name,
            ];
        });
    }
}
