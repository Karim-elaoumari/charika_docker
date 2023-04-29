<?php

namespace App\Http\Resources;

use App\Http\Resources\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewCommentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'id' => $this->id,
            'content' => $this->content,
            'stars' => $this->stars,
            'status' => $this->status,
            'reviewer' => new UserResource($this->user),
            'date' => $this->created_at->format('d/m/Y'),
            'time' => $this->created_at->format('H:i'),
            'comments' => CommentResource::collection($this->comments->where('status',1)),
            'company_id' => $this->company->id,
            'company_name' => $this->company->name,
            'company_logo' => $this->company->logo
           
        ];
    }
}
