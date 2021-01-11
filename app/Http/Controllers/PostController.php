<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use App\Models\Post;
use App\Classes\Coordinates;
use App\Classes\Retriving_street;
use JWTAuth;
use Image;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       $answer = null; 

        //return all posts with comments
        $posts_with_comments =  Post::with('comments')->get();

        //Return all fields place from all posts
        //$place =  Post::all('place');

        //Return field place from Post id=1;
       //return $place = Post::find(1)->get('place');
       //$place = Post::find(1)->get('place');
       //return $place;
       //$arr = (json_decode($place, true));
       //$street = $arr[0]['place'];

       //return $street;
       //return print_r($arr);

        //access to comment property from posts
        //return all comments from Post when post_id id=1;
        //$comments = Post::find(1)->comments;

       //foreach ( $comments as $comment ) {
           //$this->answer = $comment->body;
            ////return response()->json(['Answers' => $comment->body ]);
       //}

       //return $this->answer;
       //return $place;

       //if(strcmp($street, $this->answer) == 0) {
           //return response()->json(['Result' => "Correct"]);
       //}else {
           //return response()->json(['Result' => "Uncorrect"]);

       //}

            //return response()->json(['Question' => $place, 'Answers' => $this->answer ]);
        return response()->json(['Posts with comments' => $posts_with_comments ]);
    }


    public function store(Request $request)
    {

        $user  = JWTAuth::parseToken()->authenticate();

        $id    = $user->id;
        $owner = $user->name;

        $validator = Validator::make($request->all(), [
        'image' => 'required|image:jpeg,png,jpg,gif,svg|max:10000'
        ]);

        $post = new Post;
        

        if($validator->fails()) {
            return response()->json(['message' => 'please insert image property']);
        }

        $coordinates = new Coordinates;

        $coordinates->getGPS($post->image);
        $latitude  = $coordinates->getLatitiude();
        $longitude = $coordinates->getLongitude();


        $street = new Retriving_street();
        $street->setLocal($latitude, $longitude);
        $palce = $street->getStreet();


        $post->title       = $request->title;
        $post->body        = $request->body;
        $post->user_id     = $id;
        $post->post_author = $owner;
        $post->place       = $palce;


        $uploadFolder        = 'post_images';
        $image_uploaded_path = $post->image->store($uploadFolder, 'public');


        $image_name = basename($image_uploaded_path);
        $image_url  = Storage::disk('public')->url($image_uploaded_path);


        $post->save();


        return response()->json(['id usera' => $id, 'post' => $post, 'image_name' => $image_name, 'image_url' => $image_url, 'latitude' => $latitude, 'longitude' => $longitude, 'steet_name' => $street ]);

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function getAllUserPosts() {

        $user = JWTAuth::parseToken()->authenticate();
        $id = $user->id;
        $all_posts = Post::with('user')->get();
        $all_posts = $user->posts()->get();

        return response()->json(['my all posts' => $all_posts ]);

    }

}
