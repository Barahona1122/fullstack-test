<?php

namespace App\Http\Controllers;
use Validator;
use DB;

use Illuminate\Http\Request;
use App\Product;
use App\Cart;
class GuestController extends Controller
{

    public function index()
    {
        // dd(\Hash::make('1234'));
        return view("guest.home.index");
    }

    public function products()
    {
        $products = Product::where('status',1)->get();
        foreach ($products as $product) {
            if($product->cover){
                $product->url = asset('products/'.$product->cover);
            }else{
                $product->url = asset('img/default.png');
            }
        }
        return $products;
    }

    public function details($slug)
    {
        return view("guest.home.details",['slug' => $slug]);
    }

    public function detail(Request $request)
    {
        $product = Product::where('slug',$request->slug)->first();
        if($product->cover){
            $product->url = asset('products/'.$product->cover);
        }else{
            $product->url = asset('img/default.png');
        }

        return $product;
    }

    //CART
    public function cart()
    {
        return view("guest.cart.cart");
    }


    public function listCart()
    {
        $carts = Cart::with(['product'])->where(['session_id' => session()->getId()])
                     ->get();
        $total = 0;
        foreach ($carts as $cart) {
            $cart->total = $cart->product->price * $cart->quantity;
            $total+= $cart->product->price * $cart->quantity;
        }

        return [ 'carts' => $carts, 'total' => $total];
    }

    public function addCart(Request $request)
    {

        $commit = true;
        $message = "Error 500";
        DB::beginTransaction();
        try{
            if($commit){
                $validateProduct = Cart::where(['product_id' => $request->product_id
                                                , 'session_id' => session()->getId()])
                                        ->first();
                $quantity = 0;
                if(!$validateProduct){
                    $quantity = $request->quantity;
                    $cart = new Cart();
                        $cart->product_id = $request->product_id;
                        $cart->session_id = session()->getId();
                        $cart->quantity   = $quantity;
                        $cart->save();
                }else{
                    $quantity = $request->quantity + $validateProduct->quantity;
                    Cart::where(['product_id' => $request->product_id
                                , 'session_id' => session()->getId()])
                        ->update(['quantity' => $quantity]);
                }
            }
        } catch (\Exception $e) {
            $commit  = false;
            $message = $e->getMessage();
        }

        if ($commit) {
            DB::commit();
            return response()->json(array('error' => false, 'message' => 'Product was Added to Cart!!'));
        } else {
            DB::rollback();
            return response()->json(array('error' => true, 'message' => $message));
        }
    }

    public function changeQuantity(Request $request)
    {

        $commit = true;
        $message = "Error 500";
        DB::beginTransaction();
        try{
            if($commit){
                $cart = Cart::find($request->product_id);
                $cart->quantity = $request->quantity;
                $cart->save();
            }
        } catch (\Exception $e) {
            $commit  = false;
            $message = $e->getMessage();
        }

        if ($commit) {
            DB::commit();
            return response()->json(array('error' => false, 'message' => 'Quantity was Update!!'));
        } else {
            DB::rollback();
            return response()->json(array('error' => true, 'message' => $message));
        }
    }

    public function DestroyCart(Request $request)
    {
        $cart = Cart::where('id',$request->product_id)->delete();
        if($cart){
            return response()->json(array('error' => false, 'message' => 'Product was Destory!!'));
        }
    }

    //CHECKOUT
    public function checkout()
    {
        return view("guest.checkout.checkout");
    }

}
