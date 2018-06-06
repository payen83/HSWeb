<?php

namespace App\Http\Controllers;

use App\Orders;
use App\StoreOrders;
use App\Joblist;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
	public function viewSales(){
		 $orders = DB:: table('orders')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> select ('store_orders.ProductID' ,'products.Name' , 'store_orders.ProductQuantity', 'products.Price', DB::raw('orders.*,(store_orders.ProductQuantity*products.Price) as Total_Amount'))
                  ->whereBetween(DB::raw("date(orders.created_at)"), ['2018-06-01' , '2018-06-05'])
                  -> get();
        return view('sales.index', compact('orders'));

	}
    
       
}
