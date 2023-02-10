<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class Get extends Controller
{
    public function user(int $user_id){

        $user = User::where('id', $user_id)->first();

        if(!$user){
            return response()->json(['error' => 'User not found!'], 404);
        }

        return response()->json($user);
    }
}
