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
        
        return Post::get();
        //SELECT id, image,descriptions FROM `Posts` WHERE id NOT IN ( SELECT post_id FROM `answer` WHERE user_id = 1 )
    }
}
