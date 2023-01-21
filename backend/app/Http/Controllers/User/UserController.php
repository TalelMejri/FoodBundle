<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
       /* if(isset($request->search)){
            $user=User::where("name",'like','%'.$request->search.'%')->where('Isadmin',0)->paginate(5);
        }else{
             $user=User::where('Isadmin',0)->get();
        }
        return response()->json(['data'=>$user],200);*/
        $user=User::where('Isadmin',0)->get();
        return response()->json(['data'=>$user],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

            $user=User::find($id);
            if($user){
            if($request->avatarupload==1){
                $image=Storage::disk('public')->put('users',$request->file('photo'));
                $user->update(
                    [
                        'name'=>$request->name,
                        'lastname'=>$request->lastname,
                        'email'=>$request->email,
                        'Photo'=>'/storage/'.$image
                    ]
                );
            }else{

                $user->update(
                    [
                        'name'=>$request->name,
                        'lastname'=>$request->lastname,
                        'email'=>$request->email,
                    ]
                );
            }
                return response()->json(['data'=>$user],200);
            }else{
                return response()->json(['data'=>"Not Found"],200);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $user=User::find($id);
        if($user){
            $user->delete();
            return response()->json(['message'=>'delete completed'],200);
        }
        return response()->json(['message'=>'NOt Found'],404);
    }

    public function coutUser(){
        $count=User::where('Isadmin',0)->count();
        return  response()->json(['data'=>$count],200);
    }

}
