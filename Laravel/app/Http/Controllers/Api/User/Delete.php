<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Log;

class Delete extends Controller
{
    public function delete(int $user_id){
        $user = User::where('id', $user_id)->first();

        if(!$user){
            return response()->json(['error' => 'User not found!'], 404);
        }

        try{
            $user->delete();
            return response()->json(['User deleted!']);
        }catch(Exception $e){
            Log::error('Failed to delete a user: ' . $e);
            return response()->json(['error' => 'Internal server error!'], 500);
        }

    }
}
