<?php

namespace Controllers\Api\Address;

use Core\Response;
use Models\Api\Address;

class Index
{
    public function index(){
        $addresses = new Address();
        return Response::json($addresses->get());
    }
}
