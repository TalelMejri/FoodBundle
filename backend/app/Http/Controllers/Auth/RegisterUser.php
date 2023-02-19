<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RegisterUser extends Controller
{
    public function RegisterUser(StoreUserRequest $request){
        $file_name = time() . '_' . $request->Photo->getClientOriginalName();
        $image = $request->file('Photo')->storeAs('users', $file_name, 'public');
        //$image=Storage::disk('public')->put('users',$request->file('Photo'));

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'lastname'=>$request->lastname,
            'numero_tlf'=>$request->numero_tlf,
            'Photo'=>'/storage/' . $image,
            'Isadmin'=>true,
            ]
        );
        $user->sendEmailVerify();
        return response()->json(['data'=>$user], 200);
    }
}

    // public function getuser(){
    //     $user=User::all();
    //     return $user;
    // }

