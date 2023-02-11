<?php

namespace Controllers\Api\State;

use Config\Response;
use Models\Api\State;



class Get
{
    public function get($state_id){
        $state = new State;
        $state = $state->where('id', '=', $state_id)->get();
        if(count($state) <= 0){
            return Response::json(['error' => 'State not found'], 404);
        }
        return Response::json($state[0]);
    }
}
