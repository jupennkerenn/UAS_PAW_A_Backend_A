<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validator\Rule;
use Validator;
use App\Models\User;

class UserController extends Controller
{
    public function show($id){
        $user = User::find($id);
        if(!is_null($user)){
            return response([
                'message' => 'User ada',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 400);
    }

    public function update(Request $request, $id){

        $user = User::find($id);

        if(is_null($user)){
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users',
        ]);

        if($validate->fails())
            return response()->json($validate->errors(), 400);
        
            $updateData['password'] = bcrypt($request->password);
            $user->name = $updateData['name'];
            $user->email = $updateData['email'];   
            
        
        if($user->save()){
            return response()->json([
                'message' => 'Update User Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Update User Failed',
            'data' => null
        ], 400);
    }
}
