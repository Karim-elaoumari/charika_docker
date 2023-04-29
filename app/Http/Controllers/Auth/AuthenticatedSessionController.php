<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
    { 
         $user = User::where('email', $request->email)->first();
        if($user->email_verified_at == null){
            return response()->json([
                'message' => 'Please verify your email address',
            ], 403);
        }
        $request->authenticate();
        $request->session()->regenerate();
        return response()->json([
            'token' => $request->user()->createToken('auth_token')->plainTextToken,
            'message' => 'Successfully logged in',
            'user' => new UserResource($request->user()),
        ],200);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
