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
    
    public function getAll()
    {
        return $this->post->getAll();
    }

    public function getPost($id)
    {
        return $this->post->getPost($id);
    }
}
