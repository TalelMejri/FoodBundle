<?php

namespace App\Http\Controllers\Auth\ResetPassword;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResPassword;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgotPassword extends Controller
{
    public function forgot_password(StoreResPassword $request)
    {
            $token= mt_rand(100000, 999999);
            $user_forgot_password=User::where('email','=',$request->email)->firstOrFail();
            $user_forgot_password->password_token=$token;
            $user_forgot_password->password_token_send_at=now();
            $user_forgot_password->save();
            Mail::to($request->email)->send(new ResetPassword($token));
            return response()->json(['message'=>"Code Envoyer A votre email avec success"],200);
    }
}
