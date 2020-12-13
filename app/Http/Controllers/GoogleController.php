<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function redirectToGoogle() {
        return Socialite::driver('google')->stateless()->redirect();

    }

    public function handleGoogleCallback() {

        $user =  Socialite::driver('google')->stateless()->user();

        $google_user_id = $user->getId();
        $name           = $user->getName();
        $avatar         = $user->getAvatar();
        $email          = $user->getEmail();
        $token          = $user->token;


        $user = User::where([
            'name'           => $name,
            'email'          => $email,
            'google_user_id' => $google_user_id,
        ])->first();


        $user = User::firstOrCreate([
            'name'           => $name,
            'email'          => $email,
            'google_user_id' => $google_user_id,
        ]);



        return response()->json([
            'access_token'   => $token,
            'name'           => $name,
            'email'          => $email,
            'avatar'         => $avatar,
            'google_user_id' => $google_user_id,
        ]);
    }
}
