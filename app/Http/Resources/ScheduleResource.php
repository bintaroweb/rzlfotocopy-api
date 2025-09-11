<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
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
            'uuid' => $this->uuid,
            'customer' => $this->customer->customer_name ?? '',
            'date' => $this->date,
            'contact' => $this->contact,
            'address' => $this->address,
            'problem' => $this->problem,
            'technician' => $this->technician->name ?? '',
            'parent_schedule_id' => $this->parent_schedule_id,
            'parent_schedule' => $this->parentSchedule ? [
                'id' => $this->parentSchedule->id,
                'date' => $this->parentSchedule->date,
                'customer' => $this->parentSchedule->customer->customer_name ?? '',
                'contact' => $this->parentSchedule->contact,
                'address' => $this->parentSchedule->address,
                'technician' => $this->parentSchedule->technician->name ?? '',
                'problem' => $this->parentSchedule->problem,
            ] : null,
        ];
    }
}
