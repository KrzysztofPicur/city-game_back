<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'body',
        'comment_owner',
        'post_id'
    ];

    use HasFactory;

    public function posts () {
        return $this->belongsTo(Post::class);
    }
}
