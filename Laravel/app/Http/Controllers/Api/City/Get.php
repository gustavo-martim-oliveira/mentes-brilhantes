<?php

namespace App\Http\Controllers\Api\City;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class Get extends Controller
{
    public function get($city_id){
        $cities = City::where('id', $city_id)->first();
        if(!$cities){
            return response()->json(['error' => 'City not found'], 404);
        }
        return response()->json($cities);
    }
}
