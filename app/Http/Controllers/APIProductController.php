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

class APIProductController extends Controller
{
        public function ProductCustomer()
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

   		public function ProductInventory()
    	{
       
        	$inventories = DB:: table('inventories')
                  -> join ('products', 'products.id', '=', 'inventories.product_id')
                  -> join ('users', 'users.id', '=', 'inventories.user_id')
                  -> select ('inventories.id','products.Name', 'products.ImageURL', 'users.name', 'users.email', 'inventories.quantity')
                  -> get();
        	return response() -> json(['inventories' => $inventories], 200);
        
   		}
}
