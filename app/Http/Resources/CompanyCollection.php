<?php

namespace App\Http\Resources;

use App\Http\Resources\CompanyResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public $collects = CompanyResource::class;

    public function toArray($request)
    {
        return [
             $this->collection,
        ];
    } 
}
