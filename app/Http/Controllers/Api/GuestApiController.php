<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Product;
use App\Cart;
use App\User;
class GuestApiController extends Controller
{


    public function products(){
        $proudcts = Product::where('status',1)->get();
        return $proudcts;
    }

    public function cart(){
        $carts = Cart::with(['product'])->where(['session_id' => session()->getId()])
                     ->get();
        $total = 0;
        foreach ($carts as $cart) {
            $cart->total = $cart->product->price * $cart->quantity;
            $total+= $cart->product->price * $cart->quantity;
        }

        return [ 'carts' => $carts, 'total' => $total];
    }

    public function users(){
        $users = User::where('status',1)->get();
        return $users;
    }
}
