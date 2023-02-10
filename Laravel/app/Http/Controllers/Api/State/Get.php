<?php

namespace App\Http\Controllers\Api\State;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class Get extends Controller
{
    public function get($state_id){
        $states = State::where('id', $state_id)->first();
        if(!$states){
            return response()->json(['error' => 'State not found'], 404);
        }
        return response()->json($states);
    }
}
