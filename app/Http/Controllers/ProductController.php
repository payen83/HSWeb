<?php

namespace App\Http\Controllers;

use App\Product;
use App\Inventory;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

         $validator = Validator::make(Input::all(), [
                'Discount' => 'min:0|max:100'
                
            ]);
            if ($validator->fails()) {
                return array(
                    'fail' => true,
                    'errors' => ["Discount" => "Discount must be less than 100%. Please try again!"]
                );
            }


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
         $product->Discount = Input::get('Discount')/100;
         $product->save();
         Session::put('msg_status', true);
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

        else{
            $filename=$product->ImageURL;
        }
        
        $product->id = Input::get('id');
        $product->Name = Input::get('Name');
        $product->Description = Input::get('Description');
        $product->Price = Input::get('Price');
        $product->ImageURL = $filename;
        $product->QuantityPerPackage = Input::get('QuantityPerPackage');
        $product->Discount = Input::get('Discount')/100;
        $product->save();
         //$product->save($request->all());
         return redirect()->route('viewProduct');
    }

      public function delete($id)
    {
        Product::destroy($id);
        return redirect('product');
    }

     public function viewAssignProduct($id)
    {
        
        $data = Product::getSingleData($id);
        $select_email_user = User::getListSelect2();
        return view('product.assign', compact('data', 'select_email_user'));
        
        
    }

   public function assignProduct(Request $request)
 
   {
         $input = $request->all();
         $inventories = Inventory::create($input);
         return redirect()->route('viewInventory');
    }

  public function viewInventory()
    {
        $inventories = DB:: table('inventories')
                  -> join ('products', 'products.id', '=', 'inventories.product_id')
                  -> join ('users', 'users.email', '=', 'inventories.agent_email')
                  -> select ('inventories.id','products.Name', 'products.ImageURL', 'users.name', 'inventories.agent_email', 'inventories.quantity')
                  -> get();
        return view('product.inventory', compact('inventories'));
    }

     public function viewEditInvProduct($id)
    {
        
        $data = DB:: table('inventories')
                  -> join ('products', 'products.id', '=', 'inventories.product_id')
                  -> select ('inventories.id','products.Name', 'products.ImageURL', 'inventories.agent_email', 'inventories.quantity')
                  -> where ('inventories.id', $id)
                  -> first();
        return view('product.ed-inventory', compact('data'));
        
        
    }

   public function editInventoryProduct(Request $request, $id) {

        if ($request->isMethod('get'))
        return view('product.ed-inventory', ['inventories' => Inventory::find($id)]);
       
        $inventories = Inventory::find($id);
        $inventories->agent_email = Input::get('agent_email');
        $inventories->quantity = Input::get('quantity');
        $inventories->save();
        return redirect()->route('viewInventory');
    }

      public function deleteInventory($id)
    {
        Inventory::destroy($id);
        return redirect('Inventory');
    }

  
}