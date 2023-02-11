<?php

namespace Controllers\Api\User;

use Core\Response;
use Models\Api\User;

class Index 
{

    public function index(){
       $users = new User();
       return Response::json($users->get());
    }
}
