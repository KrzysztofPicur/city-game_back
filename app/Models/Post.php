<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    protected $name;
    protected $image;
    protected $descriptions;
    protected $city;
    protected $street;


    public function getAll()
    {
        return Post::join('users', 'users.id', '=', 'Posts.id_user')->get(['users.name','Posts.image','Posts.descriptions','Posts.city','Posts.street']);
    }

    public function getPost($id)
    {
        return Post::join('users', 'users.id', '=', 'Posts.id_user')->where('users.id',$id)->get(['users.name','Posts.image','Posts.descriptions','Posts.city','Posts.street']);
    }
}
