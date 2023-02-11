<?php

namespace Controllers\Api\State;

use Config\Response;
use Models\Api\State;

class Index
{
    public function index(){
        $states = new State;
        return Response::json($states->get());
    }
}
