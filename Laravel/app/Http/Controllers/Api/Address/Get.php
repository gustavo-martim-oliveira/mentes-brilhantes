<?php

namespace App\Http\Controllers\Api\Address;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Get extends Controller
{
    public function get($address_id){
        $addresses = Address::where('id', $address_id)->first();
        if(!$addresses){
            return response()->json(['error' => 'Address not found'], 404);
        }
        return response()->json($addresses);
    }
}
