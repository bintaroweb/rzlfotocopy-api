<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'today' => [
                'total_schedule' => $this['today'],
                'total_technician' => $this['technician'],
            ],
            'tomorrow' => [
                'total_schedule' => $this['tommorow'],
            ],
        ];
    }
}
