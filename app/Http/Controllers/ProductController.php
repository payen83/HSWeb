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
//use App\Notifications\AgendamentoPendente;

class ProductController extends Controller
{
    	public function viewProduct()
    {
       
        $products = Product::all();
        return view('product.index', compact('products'));
        
        
    }

    public function viewProductApproval()
    {

        $products= DB:: table('products')
                  -> select ('id','ImageURL','Name', 'Price','status')
                  -> where('tagto', 'MCN')
                  -> get();
        return view('product.vw_approveproduct', compact('products'));
        
        
    }

     public function updateApproval($id) {

       
        $product = Product::find($id);
        $product->status = 'Approved';
        $product->save();

        $userid = DB::table('products')->where('id', '=', $id)->value('user_id');
        $playerid = DB::table('users')->where('id', '=', $userid)->value('playerId');

            $content = array(
                    "en" => 'Your Product has been approved by Admin'
                    );
            
            $fields = array(
              'app_id' => "1d01174b-ba24-429a-87a0-2f1169f1bc84",
              'include_player_ids' => array($playerid),
              'data' => array("id" => $id),
              'contents' => $content
            );
            
            $fields = json_encode($fields);
              // print("\nJSON sent:\n");
              // print($fields);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                       'Authorization: Basic NmU4MWZjZDEtNDc5YS00NWMzLTkxMTAtNDNjMjl5ODl3YzBi'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            $response = curl_exec($ch);
            curl_close($ch);
            
            // return $response;
          
          
         
          $return["allresponses"] = $response;
          $return = json_encode( $return);
          
          // print("\n\nJSON received:\n");
          // print($return);
          // print("\n");

          return redirect()->route('viewProductApproval');
    }


      public function viewAddProduct()
    {
        
        return view('product.add');
    }

    public function addProduct(Request $request)
    {
        
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
         $product->tagto = 'HQ';
         $product->save();
         Session::put('msg_status', true);
         return redirect()->route('viewProduct')->with('status', 'Product Uploaded');


    
      
    }

     public function viewEditProduct($id)
    {
        
        $data = Product::getSingleData($id);
        return view('product.edit', compact('data'));
        
        
    }

     public function viewDeatilProduct($id)
    {
        
        $data = Product::getSingleData($id);
        return view('product.vw_detailmc', compact('data'));
        
        
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
        $product->sku_number = Input::get('sku_number');
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
         $userid = $request->user_id;
         $productid = DB::table('inventories')->where('user_id', '=', $userid)->value('product_id');
         $id = DB::table('inventories')->where('product_id', '=', $productid)->value('id');
         $currentquantity = DB::table('inventories')->where('id', '=', $id)->value('quantity');

         if($productid != $request->product_id)
           {
            $inventories = new Inventory;
            $inventories->product_id = Input::get('product_id');
            $inventories->quantity = Input::get('quantity');
            $inventories ->user_id = $userid;
            $inventories->save();
           }

         else
         {
            $inventories = Inventory::find($id);
            $inventories->quantity = Input::get('quantity')+$currentquantity;
            $inventories->save();
         }
       
         return redirect()->route('viewInventory');
    }

  public function viewInventory()
    {
        $inventories = DB:: table('inventories')
                  -> join ('products', 'products.id', '=', 'inventories.product_id')
                  -> join ('users', 'users.id', '=', 'inventories.user_id')
                  -> select ('users.name','inventories.user_id', 'inventories.id','products.Name','users.email', 'inventories.quantity', DB::raw('count(inventories.product_id) as NumberOfProducts'))
                  -> orderby('users.name')
                  -> groupby('users.name')
                  -> get();
        return view('product.inventory', compact('inventories'));
    }

    public function viewInventoryDetails($user_id)
    {
        $inventories = DB:: table('inventories')
                  -> join ('products', 'products.id', '=', 'inventories.product_id')
                  -> join ('users', 'users.id', '=', 'inventories.user_id')
                  -> select ('users.name', 'inventories.id','products.Name','inventories.quantity')
                  ->where('inventories.user_id', $user_id)
                  -> get();
        
        $inventories1 = DB:: table('inventories')
                  -> join ('products', 'products.id', '=', 'inventories.product_id')
                  -> join ('users', 'users.id', '=', 'inventories.user_id')
                  -> select ('users.name', 'users.email', 'inventories.id','products.Name','inventories.quantity')
                  ->where('inventories.user_id', $user_id)
                  -> groupby('users.name')
                  -> get();
        

        return view('product.inv_list', [
                    'inventories' => $inventories,
                    'inventories1' => $inventories1
                  ]);
    }

     public function viewEditInvProduct($id)
    {
        
        $data = DB:: table('inventories')
                  -> join ('products', 'products.id', '=', 'inventories.product_id')
                  -> join ('users', 'users.id', '=', 'inventories.user_id')
                  -> select ('inventories.id','products.Name', 'products.ImageURL', 'users.email', 'users.name','inventories.user_id','inventories.quantity')
                  -> where ('inventories.id', $id)
                  -> first();
        $select_email_user = User::getListSelect2();
        return view('product.ed-inventory', compact('data', 'select_email_user'));
        
        
    }

   public function editInventoryProduct(Request $request, $id) {

        if ($request->isMethod('get'))
        return view('product.ed-inventory', ['inventories' => Inventory::find($id)]);
       
        $inventories = Inventory::find($id);
        $inventories->quantity = Input::get('quantity');
        $inventories->save();
        return redirect()->route('viewInventory');
    }

      public function deleteInventory($id)
    {
        Inventory::destroy($id);
        return redirect('Inventory');
    }

        public function OrderProduct()
    {
       
        $products = Product::all();
        return view('joblist.viewproductorders', compact('products'));
        
        
    }

  
}
