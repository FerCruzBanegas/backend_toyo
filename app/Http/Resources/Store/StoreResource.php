<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class StoreResource extends JsonResource
{
    public function toArray($request)
    {
        $collection = collect($this->owners);

        $total = $collection->reduce(function ($carry, $item) {
            return $carry + $item->tickets->count();
        });


        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'code' => $this->code,
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'city' => ['name' => $this->city->name],
            'city_id' => $this->city->id, 
            'tickets' => is_null($total) ? 0 : $total,
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y'),
        ];
    }
}
