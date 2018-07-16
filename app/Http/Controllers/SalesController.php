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
		Session::put('from_date', Input::has('from_date') ? Input::get('from_date') : (Session::has('from_date') ? Session::get('from_date') : date("Y-m-d")));
    Session::put('to_date', Input::has('to_date') ? Input::get('to_date') : (Session::has('to_date') ? Session::get('to_date') : date("Y-m-d")));
		 $orders = DB:: table('orders')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> select ('store_orders.ProductID' ,'products.Name' , 'store_orders.ProductQuantity', 'products.Price', DB::raw('orders.*,(store_orders.ProductQuantity*products.Price) as Total_Amount'))
                  ->whereBetween(DB::raw("date(orders.created_at)"), [date('Y-m-d', strtotime(Session::get('from_date'))), date('Y-m-d', strtotime(Session::get('to_date')))])
                  -> get();
        return view('sales.index', compact('orders'));

	}
    
       
}
