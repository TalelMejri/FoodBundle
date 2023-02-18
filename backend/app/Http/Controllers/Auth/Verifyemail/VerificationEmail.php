<?php

namespace App\Http\Controllers\auth\Verifyemail;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationEmail extends Controller
{

    public function verify_email($email)
    {
        $user = User::where('email',$email)->First();
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
               return response()->json(['data'=>"Email verifé avec succès"],200);
        } else {
                return response()->json(['data'=>"Email est déja verifé"],200);
        }
    }

    public function renvoyer($email)
    {
        $user = User::where('email', $email)->first();
        if ($user->hasVerifiedEmail()) {
            return response()->json(["data" => "email est déja vérifé"], 400);
        }
        $user->sendEmailVerify();
        return response()->json(["data" => "lien de vérification envoé avec succès"], 200);
    }

    public function sendmailChanger( $email){
        $user = User::where('email', $email)->first();
        $user->sendEmailChangerEmail();
    }

    public function updated(request $request){
        $user = User::where('email', $request->email)->first();
        if($user){
            $user->update([
                'email'=>$request->email_new,
                'email_verified_at'=>Null
            ]);
           $user->sendEmailVerify();
           return response()->json(["data" =>$user], 200);
        }else{
            return response()->json(["data" => "User Not Found"], 404);
        }
    }

}
