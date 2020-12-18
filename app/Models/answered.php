<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class answered extends Model
{
    use HasFactory;

    protected $id_user;
    protected $id_post;
}
