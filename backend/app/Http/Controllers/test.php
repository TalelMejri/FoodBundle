<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResPassword;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class test extends Controller
{
    //test send mail

    public function send(StoreResPassword $request)
    {
            $data['code'] = mt_rand(100000, 999999);
            Mail::to($request->email)->send(new ResetPassword($data['code']));
            return response()->json(['message'=>"Code Envoyer A votre email avec success"],200);
    }

}
