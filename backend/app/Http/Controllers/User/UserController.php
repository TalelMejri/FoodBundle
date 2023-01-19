<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
        //
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
