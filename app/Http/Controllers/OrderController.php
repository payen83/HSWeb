<?php

namespace App\Http\Controllers;

use App\Orders;
use App\Joblist;
use App\Product;
use App\StoreOrders;
use Illuminate\Http\Request;
use DB;

class OrderController extends Controller
{
    public function viewOrderList()
    {
  
        $orders = DB:: table('orders')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select ('orders.OrderID', 'users.email', 'orders.created_at')
                  -> get();
        return view('joblist.orderlist', compact('orders'));
    }

     public function ViewOrderDetails($OrderID)
    {
        
        $orders = DB:: table('orders')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('joblists', 'joblists.OrderID', '=', 'orders.OrderID')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> select ('orders.OrderID', 'store_orders.ProductID', 'products.Name' ,'store_orders.ProductQuantity', 'products.Price', DB::raw('orders.*,(store_orders.ProductQuantity*products.Price) as Total_Amount'), 'joblists.total_price')
                  -> where ('orders.OrderID', $OrderID)
                  -> get();
        return view('joblist.orderdetails', compact('orders'));
        
        
    }

}
