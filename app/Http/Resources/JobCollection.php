<?php

namespace App\Http\Resources;

use App\Http\Resources\JobResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class JobCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public $collects = JobResource::class;

    public function toArray($request)
    {
        return [
            $this->collection,
        ];
    } 
}
