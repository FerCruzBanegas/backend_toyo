<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CustomerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'names' => $this->names,
            'surnames' => $this->surnames,
            'phone' => $this->phone,
            'ci' => $this->ci,
            'address' => $this->address,
            'tickets' => $this->tickets->count(),
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y'),
            'updated' => Carbon::parse($this->updated_at)->format('d/m/Y'),
        ];
    }
}
