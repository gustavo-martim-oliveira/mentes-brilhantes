<?php

namespace Controllers\Api\Address;

use Core\Response;
use Models\Api\Address;

class Get 
{
    public function get($address_id){
        $address = new Address;
        $address = $address->where('id', '=', $address_id)->get();
        if(count($address) <= 0){
            return Response::json(['error' => 'Address not found'], 404);
        }
        return Response::json($address[0]);
    }
}
