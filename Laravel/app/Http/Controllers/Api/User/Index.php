<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class Index extends Controller
{
    /**
     * Retrieve all users
     * paginating at 25 items
     * per page
     *
     * @return void
     */
    public function index(){
        $users = User::paginate(25);
        return response()->json($users);
    }
}
