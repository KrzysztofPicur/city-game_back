<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stats;

class StatsController extends Controller
{
    protected $stats;
    
    public function __construct() {
        $this->stats = new Stats(); 
    }

    public function getAll()
    {
        return $this->stats->getAll();
    }

    public function getStat($id)
    { 
        return $this->stats->getStat($id);
    }
    public function getOrderby($what,$how)
    {
        return $this->stats->getOrderby($what,$how);
    }
}
