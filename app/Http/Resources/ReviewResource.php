<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       
        return [
                'id' => $this->id,
                'content' => $this->content,
                'stars' => $this->stars,
                'status' => $this->status,
                'reviewer' => new UserResource($this->user),
                'date' => $this->created_at->format('d/m/Y'),
                'time' => $this->created_at->format('H:i'),
            ];
    }
}
