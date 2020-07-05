<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;

use App\User;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.users.index");
    }

    public function listUsers(){
        $users = User::where('status',1)->get();
        return $users;
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required',
            'password' => 'required'

        ]);

        if ($validate->fails()) {
            return response()->json(array('error' => true, 'message' => $validate->errors()->all()));
        }

        $commit = true;
        $message = "Error 500";
        DB::beginTransaction();
        try{

            if($commit){
                $searchMail = User::where('email',$request->email)
                                ->first();
                if(!$searchMail){
                    $storeUser = new User();
                        $storeUser->name     = $request->name;
                        $storeUser->email    = $request->email;
                        $storeUser->password = \Hash::make($request->password);
                        $storeUser->save();
                }else{
                    $commit  = false;
                    $message = ['Email already Taken!'];
                }
            }
        } catch (\Exception $e) {
            $commit  = false;
            $message = $e->getMessage();
        }

        if ($commit) {
            DB::commit();
            return response()->json(array('error' => false, 'message' => 'User was Added!!'));
        } else {
            DB::rollback();
            return response()->json(array('error' => true, 'message' => $message));
        }
    }


    public function edit(Request $request)
    {
        $user = User::where('id',$request->id)->first();
        return $user;
    }

    public function update(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required',
            'id'       => 'required'

        ]);

        if ($validate->fails()) {
            return response()->json(array('error' => true, 'message' => $validate->errors()->all()));
        }

        $commit = true;
        $message = "Error 500";
        DB::beginTransaction();
        try{

            if($commit){

                $storeUser = User::find($request->id);
                    $storeUser->name     = $request->name;
                    $storeUser->email    = $request->email;
                    if($request->password != ''){
                        $storeUser->password = \Hash::make($request->password);
                    }

                    $storeUser->save();
            }
        } catch (\Exception $e) {
            $commit  = false;
            $message = $e->getMessage();
        }

        if ($commit) {
            DB::commit();
            return response()->json(array('error' => false, 'message' => 'User was Updated!!'));
        } else {
            DB::rollback();
            return response()->json(array('error' => true, 'message' => $message));
        }
    }

    public function destroy(Request $request)
    {
        $destroy = User::where('id',$request->id)->update(['status' => 0]);
        if($destroy){
            return response()->Json(['error' => false, 'message' => 'User was Destroy!']);
        }
    }
}
