<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
Use Validator;
use Illuminate\Support\Facades\Hash;





class UserController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"register"},
     *     summary="User Registeration",
     *     description="Multiple status values can be provided with comma separated string",
     *     operationId="register",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="name",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="password_confirmation",
     *                      type="string"
     *                  ),
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     * )
     */


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


    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"login"},
     *     summary="User Login",
     *     description="Multiple status values can be provided with comma separated string",
     *     operationId="login",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  
     *                  @OA\Property(
     *                      property="email",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="string"
     *                  ),
     *     
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     * )
     */
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

    /**
     * Get User Logout
     * @OA\Post (
     *     path="/api/logout",
     *     tags={"logout"},
     *     security={{"bearer_token":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="status", type="number", example=200),
     *              @OA\Property(property="message", type="string", example="User logged out successfully"),
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Invalid or no access token passed ",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message", 
     *                  type="string",
     *                  example="Unauthorized"
     *              ),
     *          )
     *      )
     * )
     */

    public function logout(){
        $user=auth()->user();
        $user->update(['password'=>'123456']);
        $user->update(['token'=>null]);
        auth()->logout();
        return response()->json(['status'=>200, 'msg'=>'User logged out successfully']);
    }


    /**
     * Get User details
     * @OA\Get (
     *     path="/api/profile",
     *     tags={"profile"},
     *     security={{"bearer_token":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="title", type="string", example="title"),
     *              @OA\Property(property="content", type="string", example="content"),
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Credentials are incorrect",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status", 
     *                  type="number", 
     *                  example=401
     *              ),
     *              @OA\Property(
     *                  property="message", 
     *                  type="string",
     *                  example="Unauthorized"
     *              ),
     *          )
     *      )
     * )
     */
    public function profile(Request $request){
        
        $user=auth()->user();
        try{
            return response()->json(['status'=>200, 'user'=>$user]);
        }catch(\Exception $e){
            return response()->json(['status'=>401, 'msg'=>$e->getMessage()]);
        }
    }
}
