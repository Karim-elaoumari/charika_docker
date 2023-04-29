<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'stars',
        'status',
        'company_id',
        'user_id',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
