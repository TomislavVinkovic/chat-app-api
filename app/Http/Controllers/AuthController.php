<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserSignupRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(UserLoginRequest $request) {
 
        if (Auth::attempt($request->all())) {
            $request->session()->regenerate();
            return new UserResource(Auth::user());
        }
        return response()->json([
            'email' => 'The provided credentials do not match our records'
        ], 401);
    }

    public function logout() {
        $user = Auth::user();
        Auth::logout();
        Session::flush();

        return new UserResource($user);
    }

    public function signup(UserSignupRequest $request) {
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->save();
        

        // to be changed
        Auth::login($user);
        return new UserResource($user);
    }
}
