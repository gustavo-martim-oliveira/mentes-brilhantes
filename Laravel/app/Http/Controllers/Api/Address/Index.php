<?php

namespace App\Http\Controllers\Api\Address;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Index extends Controller
{
    public function index(){
        $addresses = Address::paginate(25);
        return response()->json($addresses);
    }
}
