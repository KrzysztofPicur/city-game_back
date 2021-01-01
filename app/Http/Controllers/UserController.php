<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function leaderBoard () {
       return  User::select('name', 'avatar', 'total_scores')->orderByDesc('total_scores')->get();
    }

    public function topIncorect () {
       return  User::select('name', 'avatar', 'missed_answers')->orderByDesc('missed_answers')->get();


    }
}
