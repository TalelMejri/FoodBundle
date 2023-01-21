<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Models\OptionSpecifique;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function Add_Product(Request $request){

        $Product=Product::create([
             'nameProduct'=>$request->name_product,
             'id_category'=>$request->idCategory,
             'PrixProduct'=>$request->prixFood,
             'PhotoProduct'=>$request->file
        ]);

        if(count($request->options)>0) {
            for($i=0;$i<count($request->options);$i++){
                 $option=new OptionSpecifique();
                 $option->nameOptionSpecifique=$request->options[$i]['name'];
                 $option->prixOptionSpecifique=$request->options[$i]['prix'];
                 $option->product_id=$Product->id;
                 $option->save();
            }
        }
        return response()->json(['dataProduct'=>$Product,'dataProduct'=>$request->options],200);
    }

    public function GetProductCategoryOption(Request $request){
        if($request->idcategory!=-1 && !isset($request->search)){
            $products=Product::with('optionspecifiques')->where('id_category',$request->idcategory)->paginate(3);
        }else if($request->idcategory==-1 &&  isset($request->search)){
            $products=Product::with('optionspecifiques')->where('nameProduct','like','%'.$request->search.'%')->paginate(3);
        }else if($request->idcategory!=-1 && isset($request->search)){
            $products=Product::with('optionspecifiques')->where('nameProduct','like','%'.$request->search.'%')->where('id_category',$request->idcategory)->paginate(3);
        }else if($request->idcategory==-1 && !isset($request->search)){
            $products=Product::with('optionspecifiques')->paginate(3);
        }
        return response()->json(['data'=>$products],200);
    }


    public function findProductByIid(int $id){
        $Product=Product::find($id);
        if($Product){
            return response()->json(["data"=>$Product],200);
        }
        return response()->json(['message'=>'Product Not Found'],404);
      }


    public function deleteProduct($id){
        $Product=Product::find($id);
        if($Product){
            $Product->delete();
            return response()->json(['message'=>"delete success"],200);
        }else{
            return response()->json(['message'=>"Not Found"],404);
        }
    }

      public function UpdateProduct(int $id,Request $request ){
        $Product=Product::find($id);
        if($Product){
               $Product->update(
                   [
                    "nameProduct"=>$request->name,
                    "PrixProduct"=>$request->prix,
                    "PhotoProduct"=>$request->file,
                    "id_category"=>$request->id
                   ],
             );
               return response()->json(["data"=>$Product],200);
       }else{
               return response()->json(['message'=>'Product Not Found'],404);
       }
      }

      public function countProduct(){
         $product=Product::count();
         return response()->json(['data'=>$product],200);
      }

      public function AllProduct(){
        $product=Product::all('nameProduct','id');
        return response()->json($product,200);
    }

}
