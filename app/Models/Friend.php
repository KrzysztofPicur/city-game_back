<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $idUser;
    protected $idFriend;


    public function getUserFriend($id)
    {
        return Friend::join('users', 'users.id', '=', 'Friends.friend_id')->where('Friends.user_id',$id)->get('users.name');
    }
}
