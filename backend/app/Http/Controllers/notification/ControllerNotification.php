<?php

namespace App\Http\Controllers\notification;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class ControllerNotification extends Controller
{

    public function getNotification($id){
        $notification=Notification::where('user_id',$id)->where('etat',0)->get();
        return response()->json($notification,200);
     }

    public function getNotif(Request $request){
        // $notification=Notification::where('user_id',$request->user()->id)->where('etat',0)->get();
        $notification = $request->user()->notifications()->where("etat",0)->get();
        return response()->json($notification,200);
     }

   public function getAllNotification($id){
    $notification=Notification::where('user_id',$id)->orderBy('etat')->get();
    return response()->json($notification,200);
 }

 public function changeretat($id){
    $notification=Notification::find($id);
   if($notification){
        $notification->update([
            'etat'=>1
        ]);
   }else{
     return response()->json(['message'=>"Notification Not found"],404);
   }
 }



   public function deleteNotification($id){
    $notification=Notification::find($id);
    if($notification){
        $notification->delete();
        return response()->json(['message'=>"delete with success"],200);
    }else{
        return response()->json(['message'=>"Notification Not found"],404);
    }
   }
}
