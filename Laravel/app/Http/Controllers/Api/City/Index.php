<?php

namespace App\Http\Controllers\Api\City;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class Index extends Controller
{
    public function index(){
        $cities = City::paginate(25);
        return response()->json($cities);
    }
}
