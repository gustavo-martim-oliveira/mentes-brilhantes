<?php

namespace Controllers\Api\User;

use Exception;
use Core\Response;
use Models\Api\Address;
use Models\Api\User;

class Delete
{
    public function delete(int $user_id){
        $user = new User;
        $user = $user->where('id', '=', $user_id);

        if(count($user->get()) <= 0){
            return Response::json(['error' => 'User not found!'], 404);
        }

        try{
            $address = new Address;
            $address->where('id', '=', $user->get()[0]->address_id)->delete();
            $user->delete();
            return Response::json(['User deleted!']);
        }catch(Exception $e){
            return Response::json(['error' => 'Internal server error!' . $e->getMessage()], 500);
        }

    }
}
