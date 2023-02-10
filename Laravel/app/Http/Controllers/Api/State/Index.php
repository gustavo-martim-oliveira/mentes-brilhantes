<?php

namespace App\Http\Controllers\Api\State;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class Index extends Controller
{
    public function index(){
        $states = State::paginate(25);
        return response()->json($states);
    }
}
