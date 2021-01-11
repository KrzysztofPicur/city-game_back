<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Avatar;
use Webpatser\Uuid\Uuid;
use Intervention\Image\ImageManager;
use Image;

class AuthController extends Controller
{
    //
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));


        //custom user avatar

        if($request->file('avatar')) {

            $user->avatar = $request->file('avatar');
            $manager = new ImageManager(array('driver' => 'imagick'));

            $uploadFolder        = 'users_avatars';
            $image_uploaded_path = $user->avatar->store($uploadFolder, 'public');
            $image_name = basename($image_uploaded_path);
            $image_url  = Storage::disk('public')->url($image_uploaded_path);

            $image = $manager->make('storage/users_avatars/'.$image_name)->resize(150, 150);
            $image->save('storage/users_avatars/'.$image_name);
            $user->avatar = $image_url;
        }else {

            //avatar base on user email

            $image_name = Uuid::generate()->string;
            $avatar = new Avatar;
            $avatar->create($user->email)
                   ->setShape('square')
                   ->setDimension(150)
                   ->setFontSize(82)
                   ->setBackground('#0080ff')
                   ->setForeground('#ffffff')
                   ->save('storage/users_avatars/'.$image_name.'.png');
            $image_url = Storage::disk('public')->url('users_avatars/'.$image_name.'.png');
            $user->avatar = $image_url;

        }

        $user->save();

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    /**
     * Get a JWT token via given credentials.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = $this->guard()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }
}
