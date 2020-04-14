<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Product; 
use App\Employee;
use Illuminate\Support\Facades\Auth; 
use Validator;
use DB;
class ProductController extends Controller
{
    public function productshow( Request $request){
        $id=$request->id;

        echo $id;
        $user = Product::find($id);
        return response()->json($user);
    }

    public function productinsert(Request $request){
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'about' => 'required',
            'price' => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $product = new Product();
        $product->name = $request->input('name');
        $product->about = $request->input('about');
        $product->price = $request->input('price');
        $product->save();
        return response()->json($product);
    }
    public function productupdate(Request $request){
        

        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'about' => 'required',
            'price' => 'required',
            'id'=>'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $id= $request->id;
       
        $id = $request->input('id');
        $name = $request->input('name');
        $about = $request->input('about');
        $price = $request->input('price');
        $user=DB::table('products')->where('id',$id)->update(['name' =>$name,'about' =>$about,'price'=>$price]);

        return response()->json($user);
    }
    
    
    public function productdelete(Request $request){
        $id=$request->id;
 
         $user=DB::table('products')->where('id',$id)->delete();
         
         return response()->json($user);
 
     }
}
