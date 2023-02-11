<?php

namespace Controllers\Api\City;

use Config\Response;
use Models\Api\City;

class Index
{
    public function index(){
        $cities = new City;
        return Response::json($cities->get());
    }
}
