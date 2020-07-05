<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use App\Product;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.products.index");
    }

    public function listProducts()
    {
        $products = Product::with(['user'])->where('status',1)->get();
        return $products;
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name'        => 'required',
            'description' => 'required',
            'price'       => 'required',
            'slug'        => 'required'

        ]);

        if ($validate->fails()) {
            return response()->json(array('error' => true, 'message' => $validate->errors()->all()));
        }

        $commit = true;
        $message = "Error 500";
        DB::beginTransaction();
        try{

            if($commit){
                $thumbnail = '';
                if($request->hasFile('cover')){
                    $file       = $request->cover;
                    $mime       = $file->extension();
                    $fullname   = $file->getClientOriginalName();
                    $thumbnail  = md5(date("H:i:s").'-'.$fullname).'.'.$mime;
                }
                $storeProduct = new Product();
                    $storeProduct->name        = $request->name;
                    $storeProduct->description = $request->description;
                    $storeProduct->price       = $request->price;
                    $storeProduct->slug        = $request->slug;
                    $storeProduct->status      = 1;
                    $storeProduct->user_id     = Auth::user()->id;
                    if($thumbnail){
                        $storeProduct->cover       = $thumbnail;
                    }
                    if($storeProduct->save()){
                        if($thumbnail){
                            $file->move(public_path('/products/'), $thumbnail);
                        }
                    }
            }
        } catch (\Exception $e) {
            $commit  = false;
            $message = $e->getMessage();
        }

        if ($commit) {
            DB::commit();
            return response()->json(array('error' => false, 'message' => 'Product was Added!!'));
        } else {
            DB::rollback();
            return response()->json(array('error' => true, 'message' => $message));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $product = Product::where('id',$request->id)->first();
        if($product){
            $product->url = asset("products/".$product->cover);
            return response()->Json(['error' => false, 'data' => $product]);
        }
    }

    public function update(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name'        => 'required',
            'description' => 'required',
            'price'       => 'required',
            'id'          => 'required'

        ]);

        if ($validate->fails()) {
            return response()->json(array('error' => true, 'message' => $validate->errors()->all()));
        }

        $commit = true;
        $message = "Error 500";
        DB::beginTransaction();
        try{

            if($commit){
                $thumbnail = '';
                if($request->hasFile('cover')){
                    $file       = $request->cover;
                    $mime       = $file->extension();
                    $fullname   = $file->getClientOriginalName();
                    $thumbnail  = md5(date("H:i:s").'-'.$fullname).'.'.$mime;
                }

                $storeProduct = Product::find($request->id);
                    $storeProduct->name        = $request->name;
                    $storeProduct->description = $request->description;
                    $storeProduct->price       = $request->price;
                    if($thumbnail){
                        $storeProduct->cover   = $thumbnail;
                    }
                    if($storeProduct->save()){
                        if($thumbnail){
                            $file->move(public_path('/products/'), $thumbnail);
                        }
                    }
            }
        } catch (\Exception $e) {
            $commit  = false;
            $message = $e->getMessage();
        }

        if ($commit) {
            DB::commit();
            return response()->json(array('error' => false, 'message' => 'Product was Added!!'));
        } else {
            DB::rollback();
            return response()->json(array('error' => true, 'message' => $message));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $destroyProduct = Product::where(['id' => $request->id])->update(['status' => 0]);
         if($destroyProduct){
            return response()->Json(['error' => false, 'message' => 'Product Was Destroy!']);
         }else{
            return response()->Json(['error' => true, 'message' => 'Product Was not Found!']);
         }
    }
}
