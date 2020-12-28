<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;

class GoogleController extends Controller
{
    public function redirectToGoogle() {
        return Socialite::driver('google')->stateless()->redirect();

    }

    public function handleGoogleCallback() {

        $user =  Socialite::driver('google')->stateless()->user();

        $hashed_random_password = Hash::make(str_random(8));

        $google_user_id = $user->getId();
        $name           = $user->getName();
        $avatar         = $user->getAvatar();
        $email          = $user->getEmail();


        $user = User::where([
            'name'           => $name,
            'email'          => $email,
            'password'       => $hashed_random_password,
            'google_user_id' => $google_user_id,
            'avatar'         => $avatar,
        ])->first();


        $user = User::firstOrCreate([
            'name'           => $name,
            'email'          => $email,
            'password'       => $hashed_random_password,
            'google_user_id' => $google_user_id,
            'avatar'         => $avatar,
        ]);

            $token = JWTAuth::fromUser($user);

        return response()->json([
            'access_token'   => $token,
            'name'           => $name,
            'email'          => $email,
            'avatar'         => $avatar,
            'google_user_id' => $google_user_id,
        ]);
    }
}

