<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only(['username', 'password']);
  
        if (!$token = JWTAuth::attempt($credentials)) {
           return 'Invalid login details';
        }
  
        return $token;
     }

     public function logout(Request $request) 
    {
        $token = $request->header("Authorization");
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                "status" => "success", 
                "message"=> "User successfully logged out."
            ]);
        } catch (JWTException $e) {
            return response()->json([
            "status" => "error", 
            "message" => "Failed to logout, please try again."
            ], 500);
        }
    }
}
