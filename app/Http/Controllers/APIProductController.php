<?php

namespace App\Http\Controllers;

use App\Product;
use App\Inventory;
use App\User;
use DB;
use JWTAuth;
use JWTAuthException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class APIProductController extends Controller
{

        public function ProductCustomer(Request $request)
    	{
        	$products = DB:: table('products')
                  -> select ('products.id','products.Name', 'products.Price','products.ImageURL', 'products.Description')
                  -> where('products.status',1)
                  -> get();
        	return response() -> json(['products' => $products],  200);
        
   		}

   		public function ProductAgent()
    	{
          
        	$products = DB:: table('products')
                  -> select ('products.id','products.Name', 'products.Price','products.ImageURL', 'products.Description', 'products.QuantityPerPackage' , 'products.Discount')
                  -> where('products.status',1)
                  -> get();
        	return response() -> json(['products' => $products], 200);
        
   		}

   		public function ProductInventory($user_id)
    	{

        
        	$inventories = DB:: table('inventories')
                  -> join ('products', 'products.id', '=', 'inventories.product_id')
                  -> join ('users', 'users.id', '=', 'inventories.user_id')
                  -> select ('products.id','products.Name', 'products.ImageURL', 'users.name', 'users.email', 'inventories.quantity')
                  ->where('inventories.user_id', $user_id)
                  -> get();

        $array = [];
        foreach($inventories as $data){       
                    $array[] = [
                                  'product_id'=> $data->id,
                                  'product_name'=> $data->Name,
                                  'ImageURL' => $data->ImageURL,
                                  'agent_name' => $data->name,
                                  'agent_email' => $data->email,
                                  'quantity' => $data->quantity,
                                
                                ];
                    
                    }
        	return response() -> json($array);
        
   		}

       public function DeductStock ($user_id){

        $inventories = DB:: table('inventories')
                  -> select ('id','product_id','quantity')
                  ->where('inventories.user_id', $user_id)
                  -> get();

        $input = json_decode(Input::get('input'), true);
        
        foreach($inventories as $data){
          $id = $data->id;
          $productid = $data->product_id;
          $currentquantity = $data->quantity;
          
          foreach($input as $row){
            $ProductID = $row['ProductID'];
            $requestquantity = $row['ProductQuantity'];
            
            if($productid  == $ProductID){
              if($currentquantity < $requestquantity){
 
                  $inventories = Inventory::find($id);
                  $inventories->quantity = 0;
                  $inventories->save();

                  Inventory::destroy($id);

              } //end if2

              else{

                  $inventories = Inventory::find($id);
                  $inventories->quantity = $currentquantity - $requestquantity;
                  $inventories->save();

                  
              } //end else
            } // end if1
            
          }//end foreach2

        } // end foreach1
        return response()->json(['message' => 'Stock has been deduct in inventories', 'status' => true], 201); 
      }//end public


}//end class
      

