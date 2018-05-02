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
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('joblists', 'joblists.OrderID', '=', 'orders.OrderID')
                  -> select ('orders.OrderID', 'orders.customer_email', 'store_orders.ProductID','store_orders.ProductQuantity' ,'joblists.total_price')
                  -> get();
        return view('sales.index', compact('orders'));

	}
    
       
}
