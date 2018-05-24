<?php

namespace App\Http\Controllers;

use App\Orders;
use App\StoreOrders;
use App\Joblist;
use DB;
use Illuminate\Http\Request;

class SalesController extends Controller
{
	public function viewSales(){

		 $orders = DB:: table('orders')
		          -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('joblists', 'joblists.OrderID', '=', 'orders.OrderID')
                  -> select ('orders.OrderID', 'users.email', 'store_orders.ProductID','store_orders.ProductQuantity' ,'joblists.total_price')
                  -> get();
        return view('sales.index', compact('orders'));

	}
    
       
}
