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
      /*$file_name = time().'_'.$request->file->getClientOriginalName();
        $file_path = $request->file('file')->storeAs('Category', $file_name, 'public');
       */
        $categoery=new Category();
        $categoery->name=$request->name;
        $categoery->PhtotoCatg=$request->file;
        $categoery->save();
        return response()->json(['data'=>$request->option],200);
       $option=new Option();
      if(count($request->option)!=0) {
            for($i=0;$i<count($request->option);$i++){
                 $option->nameOption=$request->option[$i]['name'];
                 $option->prixOption=$request->option[$i]['prix'];
                 $option->category_id=$categoery->id;
                 $option->save();
            }
        }
        return response()->json(['data'=>$option],200);
    }

    public function AllTypeCategorie(){
        $category=Category::all('name');
        return response()->json($category,200);
    }

    public function getAllCategorie(){
        $category=Category::All();
        return response()->json([$category],200);
    }

    public function GetOptionForCategorie(){
        $category=Category::with("options")->get();
       // $options=Option::with("categories")->orderBy('id')->get();
        return response()->json([$category],200);
    }

}
