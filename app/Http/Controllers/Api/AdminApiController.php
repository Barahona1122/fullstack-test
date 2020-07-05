<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Product;
use App\User;
class AdminApiController extends Controller
{


    public function products(){
        $proudcts = Product::wihth(['user'])->where('status',1)->get();
        return $proudcts;
    }

    public function users(){
        $users = User::where('status',1)->get();
        return $users;
    }
}
