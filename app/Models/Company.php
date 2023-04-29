<?php

namespace App\Models;

use App\Models\Job;
use App\Models\User;
use App\Models\Review;
use App\Models\Comment;
use App\Models\Industry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'logo',
        'website',
        'founded',
        'industry_id',
        'user_id',
        'employees',
        'revenue',
        'description',
        'city',
        'country_code',
        'address',
        'mission'
    ];
    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    
    
}
