<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
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

        $answer  = null;
        $correct = null;

        $place  = Post::find($id)->get('place');
        $arr    = (json_decode($place, true));
        $street = $arr[0]['place'];


        $owner = $user->name;

        $comment = new Comment;
        $comment->body = $request->body;
        $comment->comment_owner = $owner;
        $comment->post_id = $id;

        $this->answer = $comment->body;

        if(strcmp($street, $this->answer) == 0) {
            $correct = true;
            User::find($user_id)->increment('total_scores');
        }else {
            $correct = false;
            User::find($user_id)->increment('missed_answers');
        }

        $comment->save();

        $total = $user->total_scores;
        $missing = $user->missed_answers;

        if($missing != 0) {
            $rating = fdiv($total,$missing);
        }else {
            $rating = 0;
        }



        $user->update(array('rating' => $rating));


        return response()->json(['user_id' => $user_id, 'comment' => $comment, 'Correct?' => $correct , 'total' => $total, 'missing' => $missing, 'rating' => $rating ]);

    } 
}
