<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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

    public function addPost(Request $request)
    {
        $data = array(
            'user_id' => $request->input('user_id'), 
            'image' => $request->input('image'),
            'descriptions'=>$request->input('descriptions'),
            'city'=>$request->input('city'),
            'street'=>$request->input('street')
        );
        Post::insert($data);
    }

    public function check(Request $request)
    {
        $user_id    =  $request->input('user_id'); 
        $city       =  $request->input('city'); 
        $street     =  $request->input('street'); 

        $post = Post::where('user_id','=',$user_id)->where('city','=',$city)->where('street','=',$street)->get();
        echo $post;
    }
}