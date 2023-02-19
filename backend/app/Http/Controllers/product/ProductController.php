<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Models\OptionSpecifique;
use App\Models\Product;
use App\Models\Rate;
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

    public function getProductByIdCategory(int $id){
        $products=Product::where('id_category',$id)->get();
        return response()->json($products,200);
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

      public function getALLproduct(){
         $product=Product::all();
         return response()->json($product,200);
      }


    public function GetProudctOptionSpecifiqueCategory(Request $request){
         if(!isset($request->search) && !isset($request->typeordered)){
            $product=Product::with('optionspecifiques')->Where('id_category','=',$request->id)
                                                       ->where('PrixProduct','>=',$request->prix)->paginate(5);
         }else if(isset($request->search) &&  !isset($request->typeordered)){
            $product=Product::with('optionspecifiques')->Where('id_category','=',$request->id)
                                                       ->where('PrixProduct','>=',$request->prix)
                                                       ->where('nameProduct','like','%'.$request->search.'%')->paginate(5);
            }else if(!isset($request->search) &&  isset($request->typeordered)){
                $product=Product::with('optionspecifiques')->Where('id_category','=',$request->id)
                                                           ->where('PrixProduct','>=',$request->prix)->orderby($request->typeordered)
                                                          ->paginate(5);
            }else if(isset($request->search) &&  isset($request->typeordered)){
                $product=Product::with('optionspecifiques')->Where('id_category','=',$request->id)
                                                           ->where('nameProduct','like','%'.$request->search.'%')
                                                           ->where('PrixProduct','>=',$request->prix)
                                                           ->orderby($request->typeordered)->paginate(5);
            }
            return response()->json(['data'=>$product],200);
    }


     public function addrate(Request $request){
        $rate=new Rate();
        $rate->user_id=$request->iduser;
        $rate->product_id=$request->id;
        $rate->rate=$request->nbr;
        $rate->save();
        return response()->json($rate,200);
     }

     public function Avgrate(int $id){
        $rate_avg=Rate::where('product_id','=',$id)->avg('rate');
        return response()->json(['data'=>$rate_avg],200);
     }

    public function getrate(){
        $rate=Rate::all();
        return response()->json($rate,200);
    }

}
