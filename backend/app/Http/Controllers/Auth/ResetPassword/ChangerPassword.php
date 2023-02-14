<?php

namespace App\Http\Controllers\Auth\ResetPassword;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChangerPassword;
use App\Models\User;


class ChangerPassword extends Controller
{
    public function changer_password(StoreChangerPassword $request){

        $checkCode=User::where('password_token',$request->password_token)->where('email',$request->email)->first();
        if(!$checkCode){
            return response(['message' => 'E-mail ou code incorrect'], 404);
        }
        if($checkCode->password_token_send_at > now()->addHour()){
             $checkCode->password_token=Null;
             $checkCode->password_token_send_at=Null;
             $checkCode->save();
             return response(['message' => 'le code des mots de passe a expiré'], 422);
        }

        $checkCode->password=bcrypt($request->password);
        $checkCode->password_token=Null;
        $checkCode->password_token_send_at=Null;
        $checkCode->save();
        return response(['message' =>'votre mot de passe a été changé'], 200);
    }

    public function exist_code($code){
        $user=User::where('password_token',$code)->first();
        if($user){
            return response()->json([
                'success'   => false,
                'message'   => 'code  exists',
                'data'      => []
            ], 201);
        } else {
            return response()->json([
                'success'   => true,
                'message'   => 'code not exists',
                'data'      => []
            ]);
        }
    }
}
