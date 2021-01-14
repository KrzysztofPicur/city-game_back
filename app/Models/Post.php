<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'post_author',
        'image',
        'place',
        'image_url'
    ];
    use HasFactory;

    protected $hidden = ['image'];


    public function user () {
        return $this->belongsTo(User::class);
    }

    public function comments () {
        return $this->hasMany('App\Models\Comment');
    }

}
