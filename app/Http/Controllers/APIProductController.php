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
        public function Products()
    	{
       
        	$products = Product::all();
        	return response() -> json(['products' => $products], 200);
        
   		}
}
