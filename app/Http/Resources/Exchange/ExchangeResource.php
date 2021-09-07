<?php

namespace App\Http\Resources\Exchange;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ExchangeResource extends JsonResource
{
    public function toArray($request)
    {
        switch ($this->state) {
            case 0:
              $state = "Aprobado";
              break;
            case 1:
              $state = "Pendiente";
              break;
            case 2:
              $state = "Rechazado";
              break;
            default:
              $state = "Rechazado";
        };

        return [
            'id' => $this->id,
            'uuid' => substr($this->uuid, 0, 8),
            'state' => $state,
            'quantity' => $this->quantity,
            'delivered' => is_null($this->delivered) ? '---' : Carbon::parse($this->delivered)->format('d/m/Y'),
            'reject' => Carbon::parse($this->reject)->format('d/m/Y'),
            'tickets' => collect($this->tickets)->transform(function($ticket){
                return [
                    'id' => $ticket->id,
                    'battery_code' => $ticket->battery_code,
                    'created_at' => $ticket->created_at,
                    'customer' => $ticket->customer->fullname,
                    'status' => $ticket->status,
                ];
            }),
            'owner' => ['id' => $this->owner->id, 'fullname' => $this->owner->names.' '.$this->owner->surnames],
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d/m/Y'),
        ];
    }
}
