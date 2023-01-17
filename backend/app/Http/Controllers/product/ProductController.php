<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Cast\Object_;

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
        $Options=json_decode($request->option);

        $option=new Option();
        if(count($Options)){
            for($i=0;$i<count($Options);$i++){
                 $option->nameOption=$Options[$i]->name;
                 $option->prixOption=$Options[$i]->prix;
                 $option->id_category=$categoery->id;
                 $option->save();
            }
        }

       return response()->json(['data'=>count($Options)],200);
    }

}
