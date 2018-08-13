<?php

namespace App\Http\Controllers;

use App\Product;
use App\Inventory;
use App\User;
use DB;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class APIProductMerchantController extends Controller
{
	public function viewProductMerchant($user_id)
    {
        $role = DB::table('users')->where('id', '=', $user_id)->value('role');

        if( $role == 'Merchant'){
        	$products= DB:: table('products')
                  -> select ('id','ImageURL','Name', 'Price','status')
                  -> where('user_id', $user_id)
                  -> get();
        return response() -> json(['products' => $products],  200);
        }
        
        else
          return response()->json(['message' => 'You are not authorized', 'status' => false], 401);	
        
        
    }

    public function addProductMerchant(Request $request, $user_id)
    {
    	$role = DB::table('users')->where('id', '=', $user_id)->value('role');

    	if ($role == 'Merchant'){

	    		 if($request->sku_number ==''){
	            	$sku_number = Product::getNextSKUNumber();
		        }
		        else{
		            $sku_number = Input::get('sku_number');
		        }

		         $product = new Product;
		         $product->Name = Input::get('Name');
		         $product->sku_number = $sku_number;
		         $product->Price = Input::get('Price');
		         $product->Description = Input::get('Description');
		         $product->QuantityPerPackage = Input::get('QuantityPerPackage');
		         $product->Discount = Input::get('Discount')/100;
		         $product->tagto = 'MCN';
		         $product->user_id = $user_id;
		         $product->status = 'Unapproved';
		         $product->save();
		         return response()->json(['message' => 'Details Product has been update', 'status' => true], 201);

    	}

    	else
          return response()->json(['message' => 'You are not authorized', 'status' => false], 401);	
       
      
    }

    public function insertimage (Request $request, $product_id)
    {
      if($request != ''){
        $product = Product::find($product_id);
        //upload new images
        if ($request->hasFile('ImageURL'))
        {
        $file = $request->file('ImageURL');
        $filename = time() . str_random(5) . '_' . $product_id . '.' . $file->getClientOriginalExtension();
        $path = 'upload/images';
        $file->move($path, $filename);
        $oldFilename = $product->ImageURL;

        //delete oldpicture
        Storage::disk('public')->delete("upload/images/$oldFilename");
        }

        else{
            $filename=$product->ImageURL;
        }

        $product->ImageURL = $filename;
        $product->save();
        return response()->json(['message' => 'Image product has been update', 'status' => true], 201);
        }

        else
          return response()->json(['message' => 'Failed to update Image product', 'status' => false], 401);

    }

    public function MerchantEditProduct(Request $request, $product_id) {
       
        $userid = DB::table('products')->where('id', '=', $product_id)->value('user_id');
        $merchantid = Input::get('user_id');
        if($merchantid == $userid)
        {
            $product = Product::find($product_id);
            $product->Name = Input::get('Name');
            $product->Description = Input::get('Description');
            $product->Price = Input::get('Price');
            $product->sku_number = Input::get('sku_number');
            $product->QuantityPerPackage = Input::get('QuantityPerPackage');
            $product->Discount = Input::get('Discount')/100;
            $product->save();
            return response()->json(['message' => 'Details Product has been update', 'status' => true], 201);
        }

        else
            return response()->json(['message' => 'Failed to proceed a process', 'status' => false], 401); 
        
  
    }

    public function MerchantDeleteProduct($product_id)
    {
        $userid = DB::table('products')->where('id', '=', $product_id)->value('user_id');
        $merchantid = Input::get('user_id');
        if($merchantid == $userid){
            Product::destroy($product_id);
            return response()->json(['message' => 'Product has been delete in database', 'status' => true], 201);
        }
        
        else
           return response()->json(['message' => 'Failed to proceed a process', 'status' => false], 401); 

    }
    
}
