<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'cogs' => $this->cogs,
            'price' => $this->price,
            'description' => $this->description,
        ];
    }
}
