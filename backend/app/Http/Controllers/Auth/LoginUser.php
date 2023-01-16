<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginUser extends Controller
{
    public function LoginUser(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user=Auth::user();
            $token=$user->createToken('api_token')->plainTextToken;
            $respnose=[
                'token'=>$token,
                'user'=>$user,
                'isAdmin'=>$user->Isadmin
            ];
            return response()->json(['data'=>$respnose],200);
        }else{
            return response()->json(['data'=>"User Not Found"],401);
        }
    }
}
