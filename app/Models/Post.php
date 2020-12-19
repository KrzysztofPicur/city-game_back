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


    public function getPost($userID)
    {
        return Post::whereNotIn('id',Answer::where('user_id',$userID)->get('post_id'))->get(['id', 'image','descriptions']);
    }
}