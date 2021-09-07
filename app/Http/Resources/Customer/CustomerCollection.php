<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Customer\CustomerResource;

class CustomerCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($customer){
                return new CustomerResource($customer);
            }),
        ];
    }
}
