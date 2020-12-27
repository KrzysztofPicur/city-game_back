<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use JWTAuth;

class CommentController extends Controller
{


    public function index () {
        return Comment::all();

    }

    public function store ($id, Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user_id = $user->id;

        

        $owner = $user->name;

        $comment = new Comment;
        $comment->body = $request->body;
        $comment->comment_owner = $owner;
        $comment->post_id = $id;

        $comment->save();

        return response()->json(['user_id' => $user_id, 'comment' => $comment]);

    } 
}

