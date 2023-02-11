<?php

namespace Controllers\Api\City;


use Config\Response;
use Models\Api\City;

class Get
{
    public function get($city_id){
        $city = new City;
        $city = $city->where('id', '=', $city_id)->get();
        if(count($city) <= 0){
            return Response::json(['error' => 'City not found'], 404);
        }
        return Response::json($city[0]);
    }
}
