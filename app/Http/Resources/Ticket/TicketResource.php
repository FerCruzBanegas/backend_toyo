<?php

namespace App\Http\Resources\Ticket;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TicketResource extends JsonResource
{
    public function toArray($request)
    {
        switch ($this->status) {
            case 0:
              $status = "Canjeado";
              break;
            case 1:
              $status = "Pendiente";
              break;
            case 2:
              $status = "Anulado";
              break;
            default:
              $status = "Anulado";
        };

        return [
            'id' => $this->id,
            'uuid' => substr($this->uuid, 0, 8),
            'battery_code' => $this->battery_code,
            'status' => $status,
            'customer' => ['id' => $this->customer->id, 'fullname' => $this->customer->names.' '.$this->customer->surnames],
            'owner' => ['id' => $this->owner->id, 'fullname' => $this->owner->names.' '.$this->owner->surnames],
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y'),
            'updated' => Carbon::parse($this->updated_at)->format('d/m/Y'),
        ];
    }
}
