<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stats extends Model
{
    use HasFactory;

    protected $id;
    protected $winCount;
    protected $postCount;

    public function getAll()
    {
        return Stats::join('users', 'users.id', '=', 'Stats.user_id')->get(['users.name','Stats.winCount','Stats.postCount']);
    }

    public function getStat($id)
    {
        return Stats::join('users', 'users.id', '=', 'Stats.user_id')->where('users.id',$id)->get(['users.name','Stats.winCount','Stats.postCount']);
    }
    public function getOrderby($what,$how)
    {
        if($how=='desc' || $how=='DESC')
        {
            return Stats::join('users', 'users.id', '=', 'Stats.user_id')->get(['users.name','Stats.winCount','Stats.postCount'])->sortByDesc($what);
        }
        if($how=='asc' || $how=='ASC')
        {
            return Stats::join('users', 'users.id', '=', 'Stats.user_id')->get(['users.name','Stats.winCount','Stats.postCount'])->sortBy($what);
        }
    }

    public function set()
    {
        
    }
    
}
