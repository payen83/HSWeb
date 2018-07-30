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

class ProductMerchantController extends Controller
{
    public function viewProductMerchant()
    {
        $id = Auth::user()->id;
        $products= DB:: table('products')
                  -> select ('id','ImageURL','Name', 'Price','QuantityPerPackage','Discount')
                  -> where('user_id', $id)
                  -> get();
        return view('product.vw_mcproduct', compact('products'));
        
        
    }

    public function viewAddMerchantProduct()
    { 
        return view('product.add-merchant');
    }

    public function addProductMerchant(Request $request)
    {
    	$id = Auth::user()->id;
        
         //upload new images
        if ($request->hasFile('ImageURL'))
        {
        $file = $request->file('ImageURL');
        $filename = $file->getClientOriginalName();
        $path = 'upload/images';
        $file->move($path, $filename);
        }

        else{
            $filename="NULL";
        }

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
         $product->ImageURL = $filename;
         $product->QuantityPerPackage = Input::get('QuantityPerPackage');
         $product->Discount = Input::get('Discount')/100;
         $product->tagto = 'MCN';
         $product->user_id = $id;
         $product->save();
         Session::put('msg_status', true);
         return redirect()->route('viewProductMerchant')->with('status', 'Product Uploaded');
      
    }

    public function viewEditProductMerchant($id)
    {
        
        $data = Product::getSingleData($id);
        return view('product.edit-promerchant', compact('data'));
        
        
    }

    public function editProductMerchant(Request $request, $id) {

        if ($request->isMethod('get'))
        return view('product.edit', ['product' => Product::find($id)]);
       
        $product = Product::find($id);
        
        //upload new images
        if ($request->hasFile('ImageURL'))
        {
        $file = $request->file('ImageURL');
        $filename = $file->getClientOriginalName();
        $path = 'upload/images';
        $file->move($path, $filename);
        $oldFilename = $product->ImageURL;

        //delete oldpicture
        Storage::disk('public')->delete("upload/images/$oldFilename.jpg");
        }

        else{
            $filename=$product->ImageURL;
        }
        
        $product->id = Input::get('id');
        $product->Name = Input::get('Name');
        $product->Description = Input::get('Description');
        $product->Price = Input::get('Price');
        $product->sku_number = Input::get('sku_number');
        $product->ImageURL = $filename;
        $product->QuantityPerPackage = Input::get('QuantityPerPackage');
        $product->Discount = Input::get('Discount')/100;
        $product->save();
         //$product->save($request->all());
         return redirect()->route('viewProductMerchant');
    }

     public function deleteproductmerchant($id)
    {
        Product::destroy($id);
        return redirect('/product-merchant');
    }

        
        
    
}
