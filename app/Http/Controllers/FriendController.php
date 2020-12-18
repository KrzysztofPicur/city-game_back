<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friend;

class FriendController extends Controller
{
    protected $friend;
    
    public function __construct() {
        $this->friend = new Friend(); 
    }
    
    public function getAll()
    {
        return $this->friend->getAll();
    }

    public function getUserFriend($id)
    {
        return $this->friend->getUserFriend($id);
    }
}