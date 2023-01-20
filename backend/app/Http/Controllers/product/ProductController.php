<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaregory;
use App\Http\Requests\StoreOption;
use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Option;
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

        if(count($request->options)!=0) {
            for($i=0;$i<count($request->options);$i++){
                 $option=new OptionSpecifique();
                 $option->nameOptionSpecifique=$request->options[$i]['name'];
                 $option->prixOptionSpecifique=$request->options[$i]['prix'];
                 $option->Id_Product=$Product->id;
                 $option->save();
            }
        }
        return response()->json(['dataProduct'=>$Product,'dataProduct'=>$option],200);
    }

    public function addCategory(StoreCaregory $request){
      /*
            $file_name = time().'_'.$request->file->getClientOriginalName();
            $file_path = $request->file('file')->storeAs('Category', $file_name, 'public');
       */
        $categoery=new Category();
        $categoery->name=$request->name;
        $categoery->PhtotoCatg=$request->file;
        $categoery->save();

       if(count($request->option)!=0) {
            for($i=0;$i<count($request->option);$i++){
                 $option=new Option();
                 $option->nameOption=$request->option[$i]['name'];
                 $option->prixOption=$request->option[$i]['prix'];
                 $option->category_id=$categoery->id;
                 $option->save();
            }
        }

        return response()->json(['data'=>$option],200);
    }

    public function addOption(StoreOption $request){
        $option=new Option();
        $option->nameOption=$request->nameOption;
        $option->prixOption=$request->prixOption;
        $option->category_id=$request->id;
        $option->save();
        return response()->json($option,200);
    }

    public function AllTypeCategorie(){
        $category=Category::all('name','id');
        return response()->json($category,200);
    }

    public function CountCategory(){
        $count=Category::count();
        return response()->json($count,200);
    }

    public function getAllCategorie(){
        $category=Category::All();
        return response()->json([$category],200);
    }

    public function GetOptionForCategorie(Request $request){
        if(isset($request->search)){
            $category=Category::with("options")->where('name','like','%'.$request->search.'%')->paginate(2);
        }else{
            $category=Category::with("options")->paginate(2);
        }
       // $options=Option::with("categories")->orderBy('id')->get();
        return response()->json([$category],200);
    }

    public function deleteCategory($id){
        $category=Category::find($id);
        if($category){
            $category->delete();
            return response()->json(['message'=>"delete success"],200);
        }else{
            return response()->json(['message'=>"Not Found"],404);
        }
    }


    public function findCategoryByIid(int $id){
        $category=Category::find($id);
        if($category){
            return response()->json(["data"=>$category],200);
        }
        return response()->json(['message'=>'Category Not Found'],404);
      }

      public function findOptionByIid(int $id){
        $option=Category::find($id);
        if($option){
            return response()->json(["data"=>$option],200);
        }
        return response()->json(['message'=>'option Not Found'],404);
      }

  public function UpdateCategory(int $id,Request $request){
    $category=Category::find($id);
     if($category){
            $category->update(
                [
                  "name"=>$request->name,
                  "PhtotoCatg"=>$request->file
                ],
          );
            return response()->json(["data"=>$request->file],200);
    }else{
            return response()->json(['message'=>'Category Not Found'],404);
    }
  }

    public function getOptionByIdCategory( $id){
      //$category=Category::with("options")->where('name','like','%'.$request->search.'%')->get();
        $categoery=Category::with("options")->where('id',$id)->get();
        return response()->json(["data"=>$categoery[0]['options']],200);
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

    public function UpdateOption(Request $request,int $id){
        $option=Option::find($id);
         if($option){
                 $option->update(
                         [
                           "nameOption"=>$request->name,
                           "prixOption"=>$request->prix
                         ],
                   );
                return response()->json(["data"=>$option],200);
        }else{
                return response()->json(['message'=>'Oprion Not Found'],404);
        }
      }

}
