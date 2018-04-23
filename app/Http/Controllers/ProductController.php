<?php

namespace App\Http\Controllers;

use App\Product;
use App\Inventory;
//use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    	public function viewProduct()
    {
       
        $products = Product::all();
        return view('product.index', compact('products'));
    }

      public function viewAddProduct()
    {
        
        return view('product.add');
    }

    public function addProduct(Request $request)
    {
         
         $file = $request->file('ImageURL');
         $filename = $file->getClientOriginalName();

         $path = 'upload/images';
         $file->move($path, $filename);
         $product = new Product;
         $product->Name = Input::get('Name');
         $product->Price = Input::get('Price');
         $product->Description = Input::get('Description');
         $product->ImageURL = $filename;
         $product->QuantityPerPackage = Input::get('QuantityPerPackage');
         $product->Discount = Input::get('Discount');
         $product->save();
         return redirect()->route('viewProduct')->with('status', 'Product Uploaded');

    
      
    }

     public function viewEditProduct($id)
    {
        
        $data = Product::getSingleData($id);
        return view('product.edit', compact('data'));
        
        
    }

   public function editProduct(Request $request, $id) {

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
        
        $product->id = Input::get('id');
        $product->Name = Input::get('Name');
        $product->Description = Input::get('Description');
        $product->Price = Input::get('Price');
        $product->ImageURL = $filename;
        $product->save();
         //$product->save($request->all());
         return redirect()->route('viewProduct');
    }

     public function viewAssignProduct($id)
    {
        
        $data = Product::getSingleData($id);
        return view('product.assign', compact('data'));
        
        
    }

   public function assignProduct(Request $request)
 //   {

    //    $inventories = new Inventory;
  //      $inventories->prouduct_id = Input::get('product_id');
    //    $inventories->agent_email = Input::get('agent_email');
    //    $inventories->quantity = Input::get('quantity');
    //    $inventories->save();
    //    return redirect()->route('viewProduct');
   // }
   {
         $input = $request->all();
         $inventories = Inventory::create($input);
         return redirect()->route('viewInventory');
    }

  public function viewInventory()
    {
       
        $inventories = Inventory::all();
        return view('product.inventory', compact('inventories'));
    }

     public function viewEditInvProduct($id)
    {
        
        $data = Inventory::getSingleData($id);
        return view('product.ed-inventory', compact('data'));
        
        
    }

   public function editInventoryProduct(Request $request, $id) {

        if ($request->isMethod('get'))
        return view('product.ed-inventory', ['inventories' => Inventory::find($id)]);
       
        $inventories = Inventory::find($id);
        
        $inventories->agent_email = Input::get('agent_email');
        $inventories->quantity = Input::get('quantity');
        $inventories->save();

        //$input = $request->all();
        //$update = Inventory::find($id);
        //$update->update($input);
        return redirect()->route('viewInventory');
    }

  
}
