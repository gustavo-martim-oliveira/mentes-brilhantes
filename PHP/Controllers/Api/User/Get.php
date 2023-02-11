<?php

namespace Controllers\Api\User;

use Core\Response;
use Models\Api\User as ApiUser;

class Get 
{
    public function user(int $user_id){

        $user = new ApiUser;
        $user = $user->where('id', '=', $user_id)->get();
        if(count($user) <= 0){
            return Response::json(['error' => 'User not found!'], 404);
        }

        return Response::json($user[0]);
    }
}
