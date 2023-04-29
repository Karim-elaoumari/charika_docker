<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['logout']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials, ['ttl' => (60*60)*24]);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email or passsword incorrect',
            ], 401);
        }
        $user = JWTAuth::user();
        if($this->checkIfEmailVerified($user)){
            return  response()->json([
                 'message' => 'Go verify your email first We emailed you with confirmation Code'
             ], 403);
         }
        return response()->json([
                'status' => 'success',
                'user' =>new UserResource($user),
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }

    public function register(Request $request){
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'confirm_password' =>'required|same:password',
            'speciality' => 'required|string',
            'job_id' => 'required|integer',
        ]);
        $user = new User([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'speciality' => $request->speciality,
            'job_id' => $request->job_id,
            'role_id' => 1,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
        ]);
        $user->save();
        // $user->assignRole('user');
        $user->sendConfirmationEmail('Verify Email');
        return response()->json([
            'message' => 'User registered successfully. Please check your email for confirmation.'
        ], 201);  
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'message' => 'User logged out successfully.'
        ], 200);
    }
    public function forgot(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users'
        ]);
        $user = User::where('email', $request->email)->first();
        if($this->checkIfEmailVerified($user)){
            return  response()->json([
                'message' => 'Go verify your email first, we emailed you with confirmation link'
            ],403);
        }
        $user->sendConfirmationEmail('Reset Password');
        return response()->json([
            'message' => 'we have emailed you with reset password link'
        ]);
    }
    public function reset( Request $request){
        $request->validate([
            'email' => 'required|email',
            'code' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password'
        ]);

        $validateToken = DB::table('password_resets')->where([
            'token' => $request->code,
            'email' => $request->email,
        ])->first();

        if(!$validateToken){
            return response()->json([
                'message' => 'Invalid code verification of reset re reset your password'
            ],401);
        }
        $created_at = Carbon::parse($validateToken->created_at);
        $now = Carbon::now();  
        if($created_at->diffInMinutes($now)> 10){
            DB::table('password_resets')->where(['email'=> $request->email])->delete();
            return response()->json([
                'message' => 'code verification  expired re reset your password'
            ],403);
        }
       
         $user = User::where('email', $request->email)
        ->update(['password' => Hash::make($request->password)]);
        if($user){
            DB::table('password_resets')->where(['email'=> $request->email])->delete();
            return response()->json([
                'message' => 'password updated successfully'
            ],201);
        }
    }
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required',
        ]);
        $table =  DB::table('password_resets')->where(['email'=> $request->email,'token'=>$request->code])->first();
        if(!$table){
            return response()->json([
                'message' => 'Invalid code verification'
            ],401);
        }
        $created_at = Carbon::parse($table->created_at);
        $now = Carbon::now();
        $user = User::where('email', $request->email)->first();
        if($created_at->diffInMinutes($now)> 10){
            DB::table('password_resets')->where(['email'=> $request->email])->delete();
            $user->sendConfirmationEmail('Verify Email');
            return response()->json([
                'Error' => 'Code Has Expired  We emailed you with new validation Code'
            ],403);
        }
        DB::table('password_resets')->where(['email'=> $request->email])->delete();
        if ($user->email_verified_at){
            return Response()->json([
                'message'=> 'Email confirmed successfully'
             ]) ;
        }
        $user->email_verified_at = Carbon::now();
        $user->save();
        return Response()->json([
            'message'=> 'Email confirmed successfully'
         ]) ;
        

    }
    public function refresh()
    {   
        return response()->json([
            'status' => 'success',
            'user' => JWTAuth::user(),
            'authorisation' => [
                'token' => JWTAuth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
    protected function checkIfEmailVerified($user){
        if($user->email_verified_at == NULL){
            $user->sendConfirmationEmail('Verify Email');
            return true;
        }
    }


}