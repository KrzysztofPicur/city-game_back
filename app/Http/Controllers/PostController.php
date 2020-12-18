<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    protected $post;
    
    public function __construct() {
        $this->post = new Post(); 
    }
    

    public function getPost($userID)
    {
        return $this->post->getPost($userID);
    }

    
}
