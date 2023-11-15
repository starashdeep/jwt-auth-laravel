<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
Use Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required|confirmed'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        return view('/login2')->with('success', "User registered successfully!");
    }

    public function login(Request $request){
        $validator=Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()); 
        }
        if(!$token=auth()->attempt($validator->validated())){//auth checks if the user is present in the database or not
            return response()->json(['success'=>false, 'msg'=>'Username or Password incorrect']);
        }
        $user=auth()->user();
        $user->token=$token;
        $user->save();
        return response()->json([
            'success'=>true,
            'access_token'=>$token,
            'token_type'=>'Bearer',
            'expires_in'=>auth()->factory()->getTTL()*60, 
            'status'=>200, 
        ], 200);
    } 

    public function logout(){
        $user=auth()->user();
        $user->update(['password'=>'123456']);
        $user->update(['token'=>null]);
        auth()->logout();
        return response()->json(['status'=>200, 'msg'=>'User logged out successfully']);
    }

    public function profile(Request $request){
        
        $user=auth()->user();
        try{
            return response()->json(['status'=>200, 'user'=>$user]);
        }catch(\Exception $e){
            return response()->json(['status'=>401, 'msg'=>$e->getMessage()]);
        }
    }
}
