<?php

namespace App\Http\Resources;

use App\Http\Resources\ReviewResource;
use App\Http\Resources\IndustryResource;
use App\Http\Resources\ReviewCommentsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyReviewsCommentsResource extends JsonResource
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
            'name' => $this->name,
            'website' => $this->website,
            'logo' => $this->logo,
            'founded' => $this->founded,
            'industry' => new IndustryResource($this->industry),
            'manager' => new UserResource($this->user),
            'employees' => $this->employees,
            'description' => $this->description,
            'revenue' => $this->revenue,
            'city' => $this->city,
            'country_code' => $this->country_code,
            'address' => $this->address,
            'mission' => $this->mission,
            'stars' => $this->getStars($this->reviews->where('status',1)),
            'reviews_count' => $this->reviews->where('status',1)->count(),
            'reviews'=> ReviewCommentsResource::collection($this->reviews->where('status',1)),
        ];
    }
    protected function getStars($reviews)
    {
        $stars = 0;
        foreach ($reviews as $review) {
            $stars += $review->stars;
        }
        if($reviews->count() == 0) {
            return 0;
        }
        return $stars/$reviews->count();
    }
}
