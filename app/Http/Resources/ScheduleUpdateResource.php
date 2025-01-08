<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleUpdateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer' => $this->customer->id,
            'date' => $this->date,
            'address' => $this->address,
            'contact' => $this->contact,
            'problem' => $this->problem,
            'technician' => $this->technician->id ?? '',

        ];
    }
}
