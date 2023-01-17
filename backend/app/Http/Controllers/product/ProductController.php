<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function addproduct(StoreProductRequest $request){
        /*$image=Storage::disk('public')->put('Product',$request->file('ProductPhoto'));
        $Product=Product::create([
             'nameProduct'=>$request->name,
             'TypeProduct'=>$request->type,
             'PrixProduct'=>$request->prix,
             'PhotoProduct'=>'/storage/'.$image
        ]);
        if($request->option){
            foreach($value as $request->option){
                $option=new Option();
                $option->prixOption=$request->option['prix'];
                $option->nameOption=$request->option['name'];
                $option->id_Food=$Product->id;
            }
        }
        return response()->json(['dataProduct'=>$Product,'dataProduct'=>$option],200);*/
    }

    public function addCategory(Request $request){

        $image=Storage::disk('public')->put('Category',$request->file('file'));
        $categoery=new Category();
        $categoery->name=$request->name;
        $categoery->PhtotoCatg='/storage/'.$image;
        $categoery->save();
        //$option=new Option();
        /*for($i=0;$i<count((array)$request->option);$i++){
            $option->nameOption=$request->option->name[$i];
            $option->prixOption=$request->option[$i]->prix;
            $option->id_category=$categoery->id;
        }
        $option->save();*/
        return response()->json([$request->option],200);
       /* if(!$request->option){
            //foreach($value as $request->option):
                $option->nameOption=$request->option->name;
                $option->prixOption=$request->option->prix;
                $option->id_category=$categoery->id;
           // endforeach;
        }
      */
    }
}
