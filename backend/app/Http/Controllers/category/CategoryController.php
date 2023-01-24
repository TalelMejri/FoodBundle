<?php

namespace App\Http\Controllers\category;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaregory;
use App\Models\Category;
use App\Models\Option;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
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
                   $option->category_id=$categoery->id;
                   $option->save();
              }
          }

          return response()->json(['data'=>$option],200);
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


}
