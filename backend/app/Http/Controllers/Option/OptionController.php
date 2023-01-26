<?php

namespace App\Http\Controllers\Option;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOption;
use App\Models\Category;
use App\Models\ligneCommandeOption;
use App\Models\Option;
use App\Models\OptionSpecifique;
use Illuminate\Http\Request;

class OptionController extends Controller
{

    public function addOption(StoreOption $request){
        $option=new Option();
        $option->nameOption=$request->nameOption;
        $option->category_id=$request->id;
        $option->save();
        return response()->json($option,200);
    }

    public function addOptionSpecifique(Request $request){
        $option=new OptionSpecifique();
        $option->nameOptionSpecifique=$request->name;
        $option->prixOptionSpecifique=$request->prix;
        $option->product_id=$request->id;
        $option->save();
        return response()->json($option,200);
    }

    public function getOptionSpecifique(Request $request){
        if($request->id==-1 && isset($request->search)){
            $option=OptionSpecifique::where('nameOptionSpecifique','like','%'.$request->search.'%')->paginate(3);
        }else if($request->id!=-1 && !isset($request->search)){
            $option=OptionSpecifique::where('product_id','=',$request->id)->paginate(3);
        }else if($request->id==-1 && !isset($request->search)){
            $option=OptionSpecifique::paginate(3);
        }else if($request->id!=-1 && isset($request->search)){
            $option=OptionSpecifique::where('nameOptionSpecifique','like','%'.$request->search.'%')->
                      where('product_id','=',$request->id)->paginate(3);
        }
        return response()->json($option,200);
    }

    public function getOptionGlobal(Request $request){
        if($request->id==-1 && isset($request->search)){
            $option=Option::where('nameOption','like','%'.$request->search.'%')->paginate(3);
        }else if($request->id!=-1 && !isset($request->search)){
            $option=Option::where('category_id','=',$request->id)->paginate(3);
        }else if($request->id==-1 && !isset($request->search)){
            $option=Option::paginate(3);
        }else if($request->id!=-1 && isset($request->search)){
            $option=Option::where('nameOption','like','%'.$request->search.'%')->
                      where('category_id','=',$request->id)->paginate(3);
        }
        return response()->json($option,200);
    }

    public function findOptionByIid(int $id){
        $option=Category::find($id);
        if($option){
            return response()->json(["data"=>$option],200);
        }
        return response()->json(['message'=>'option Not Found'],404);
      }

    public function getOptionByIdCategory($id){
        //$category=Category::with("options")->where('name','like','%'.$request->search.'%')->get();
          $category=Category::with("options")->where('id',$id)->get();
          if($category){
            return response()->json(["data"=>$category[0]['options']],200);
          }else{
            return response()->json(["data"=>"Not Found"],404);
          }

      }

      public function deleteOption($id){
        $option=Option::find($id);
        if($option){
            $option->delete();
            return response()->json(['message'=>"delete success"],200);
        }else{
            return response()->json(['message'=>"Not Found"],404);
        }
    }

    public function deleteOptionSpecifique($id){
        $option=OptionSpecifique::find($id);
        if($option){
            $option->delete();
            return response()->json(['message'=>"delete success"],200);
        }else{
            return response()->json(['message'=>"Not Found"],404);
        }
    }

    public function UpdateOption(Request $request,int $id){
        $option=Option::find($id);
         if($option){
                 $option->update(
                         [
                           "nameOption"=>$request->name,
                        ],
                   );
                return response()->json(["data"=>$option],200);
        }else{
                return response()->json(['message'=>'Option Not Found'],404);
        }
      }

      public function UpdateOptionSpecifique(Request $request,int $id){
        $option=OptionSpecifique::find($id);
         if($option){
                 $option->update(
                         [
                           "nameOptionSpecifique"=>$request->name,
                           "prixOptionSpecifique"=>$request->prix
                         ],
                   );
                return response()->json(["data"=>$option],200);
        }else{
                return response()->json(['message'=>'Option Not Found'],404);
        }
      }

      public function CountOption(){
        $Option=Option::count();
        return response()->json(['data'=>$Option],200);
     }

     public function CountOptionSpecifique(){
        $Option=OptionSpecifique::count();
        return response()->json(['data'=>$Option],200);
     }

     public function getAlloption(){
        $option=ligneCommandeOption::all();
        return response()->json($option,200);
     }


}
