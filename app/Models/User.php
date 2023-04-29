<?php
namespace App\Models;
use App\Models\Role;
use App\Models\Review;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = "users";
    protected $primaryKey = "id";
    
    protected $fillable=[
        'first_name',
        'last_name',
        'speciality',
        'job_id',
        'role_id',
        'email',
        'password',
        'photo',
    ];
    public function job(){
        return $this->belongsTo(Job::class);
    }
    public function companies()
    {
        return $this->hasMany(Company::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function sendConfirmationEmail($type)
    {
        $code = Str::random(8);
        DB::table('password_resets')->where(['email'=> $this->email])->delete();
        $insert = DB::table('password_resets')->insert([
            'email' => $this->email,
            'token' => $code,
            'created_at' => Carbon::now()
        ]);
        if($type=='Reset Password'){
            $url = "http://localhost:3000/reset";

        }else{
            $url = "http://localhost:3000/verify-email";
        }
         if($insert){
            Mail::send('verify', ['code'=> $code,'url'=>$url,'type'=>$type], function($message){
                $message->from('karimdet315@gmail.com');
                $message->to($this->email);
                $message->subject('verify your Email and join us');
            });
            return response()->json([
                'success' => 'we have emailed you with a code verification'
            ]);
         }
        
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}