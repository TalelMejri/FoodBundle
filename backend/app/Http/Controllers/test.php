<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class test extends Controller
{

    public function send(Request $request)
    {

        $data = [
            'email' => $request->email,
            'subject' => $request->subject,
            'bodyMessage' => $request->message
        ];

        Mail::send('welcome', $data, function($message) use ($data) {
            $message->to($data['email']);
            $message->subject($data['subject']);
        });

        return response()->json(['data'=>"success"],200);

    }

}
