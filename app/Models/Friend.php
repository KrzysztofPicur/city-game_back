<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Friend extends Model 
{
    use HasFactory;

    protected $idUser;
    protected $idFriend;


    public function getUserFriend($id)
    {
        return Friend::join('users', 'users.id', '=', 'Friends.friend_id')->where('Friends.user_id',$id)->get('users.name');
    }
    public function addFriend(Request $request)
    {
        $data = array('user_id' => $request->input('user_id'), 'friend_id' => $request->input('friend_id'));
        Friend::insert($data);
    }
}
