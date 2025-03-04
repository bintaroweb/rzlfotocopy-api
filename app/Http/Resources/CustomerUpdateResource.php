<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerUpdateResource extends JsonResource
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
            "uuid" => $this->uuid,
            'name' => $this->customer_name,
            'company' => $this->customer_company ?? '',
            'phone' => $this->customer_phone,
            'email' => $this->customer_email ?? '',
            'address' => $this->customer_address,
            'city' => $this->city->id,
            'status' => $this->status !== null ? $this->status->id : '',
            'note' => $this->customer_note ?? '',
        ];
    }
}
