<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $idUser;
    protected $idFriend;


    public function getAll()
    {
        return Friend::all();
    }

    public function getUserFriend($id)
    {
        return Friend::join('users', 'users.id', '=', 'Friends.id_friend')->where('Friends.id_user',$id)->get('users.name');
    }
}
