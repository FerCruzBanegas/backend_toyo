<?php

namespace App\Http\Resources\Ticket;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Ticket\TicketResource;

class TicketCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($ticket){
                return new TicketResource($ticket);
            }),
        ];
    }
}
