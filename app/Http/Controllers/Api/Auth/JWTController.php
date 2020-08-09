<?php

namespace App\Http\Controllers\Api\Auth;
//use Tymon\JWTAuth\Contracts\Providers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Api\ApiMessages;
use Illuminate\Support\Facades\Validator;


class JWTController extends Controller
{
    //
    
    public function login(Request $request)
    {
        $credentials = $request->all(['email', 'password']);

        Validator::make($credentials, [
            'email' => 'required|string',
            'password' => 'required|string',
        ])->validate();
        
        if (!$token = auth('api')->attempt($credentials)) {
            $message = new ApiMessages('Credenciais invávlidas.');
            return response()->json($message->getMessage(), 401);
        }

        return response()->json(['token'=> $token]);
    }

    public function logout(){
        auth('api')->logout();

        return response()->json(['message'=>'Logout Successfully!',200]);
    }

    public function refresh(){
        $token = auth('api')->refresh();

        return response()->json(['token'=> $token]);
    }
}
