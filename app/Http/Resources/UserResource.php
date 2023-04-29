<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'         => $this->id,
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'photo'      => $this->photo!=null ? 'http://localhost:8000/images/'.$this->photo : 'https://www.citypng.com/public/uploads/small/11639786938ezifytzfr8tbs8nzjsjdc1z0aqtrhyhq1zkujoyerqksff9tsl1f7vg9k1ujbojemibzdoayolcjrzbhp4euwhqjtyfa00tk9okr.png',
            'email'      => $this->email,
            'speciality' =>$this->speciality,
            'job'        => $this->job->name,
            'job_id'     => $this->job_id,
            'role'       => $this->role->name,
            'companies_count' => $this->companies!=null ? $this->companies->count() : 0,
         ];
    }
}
