<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function register(Request $request){
        $registrationData = $request->all();  
        $validate = Validator::make($registrationData, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',            
                'regex:/[a-z]/',     
                'regex:/[A-Z]/',     
                'regex:/[0-9]/',     
                'regex:/[@$!%*#?&]/' 
            ],
         ]);

         if($validate->fails())    
            return response()->json($validate->errors(), 400);  

        $registrationData['password'] = bcrypt($request->password); 

        $user = User::create($registrationData); 

        return response()->json([
            'success' => true,
            'message' => 'Register Success',
            'user' => $user
        ]);
    }

    public function login (Request $request){
        $loginData = $request->all();

        $validate = Validator::make($loginData, [
            'email' => 'required|email:rfc,dns',
            'password' =>'required'
        ]);

        if($validate->fails())    
            return response()->json($validate->errors(), 400);   
 
        if(!Auth::attempt($loginData))    
            return response(['invalid' => true,'message'=>'Invalid Credentials'], 401);  

        $user = Auth::user();
        $token = $user->createToken('Authentication Token')->accessToken; 

        return response()->json([
            'success' => true,
            'message' => 'Authenticated',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]); 

    }

    public function logout(Request $request) {
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json([
            'success' => true,
            'message' => 'Logout Success',
        ]);
    }
}
