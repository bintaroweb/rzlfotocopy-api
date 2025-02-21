<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class WorksheetCollection extends ResourceCollection
{
    private $date;

    public function __construct($resource, $date)
    {
        parent::__construct($resource);
        $this->date = $date;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => WorksheetResource::collection($this->collection),
        ];
    }
}
