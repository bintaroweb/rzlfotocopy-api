<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $name = $this->customer_name;
        $company = $this->customer_company;

        if ($company) {
            $name .= ' (' . $company . ')';
        }

        return [
            'id' => $this->id,
            'name' => $name,
        ];
    }
}
