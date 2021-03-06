<?php

namespace App\Http\Controllers;

use App\Orders;
use App\Joblist;
use App\Product;
use App\StoreOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
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

    //List order for agent
     public function ViewOrderDetails($OrderID)
    {
        
        $orders = DB:: table('orders')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select ('users.name','users.u_address','users.u_phone','users.email','orders.OrderID', 'store_orders.ProductID', 'products.tagto', 'products.Name' ,'store_orders.ProductQuantity', 'products.Price', DB::raw('orders.*,(store_orders.ProductQuantity*products.Price) as Total_Amount'))
                  -> where ('orders.OrderID', $OrderID)
                  -> get();

         $orders1 = DB:: table('orders')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('joblists', 'joblists.OrderID', '=', 'orders.OrderID')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select ('users.name','joblists.location_address','joblists.Lat','joblists.Lng', 'joblists.special_notes', 'joblists.job_rating', 'joblists.feedback','users.u_phone','users.email','orders.OrderID', 'store_orders.ProductID', 'products.Name' ,'store_orders.ProductQuantity', 'products.Price', DB::raw('orders.*,(store_orders.ProductQuantity*products.Price) as Total_Amount'))
                  -> where ('orders.OrderID', $OrderID)
                  ->groupby('orders.OrderID')
                  -> get();
          

        return view('joblist.orderdetails', [
                    'orders' => $orders,
                    'orders1' => $orders1
                  ]);
        
        
    }

    public function ViewAgentOrderDetails($OrderID)
    {
        
        $orders = DB:: table('orders')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select ('users.name','users.u_address','users.u_phone','users.email','orders.OrderID', 'store_orders.ProductID', 'products.tagto', 'products.Name' ,'store_orders.ProductQuantity', 'products.Price', DB::raw('(store_orders.ProductQuantity*products.Price) as Total_Amount'))
                  -> where ('orders.OrderID', $OrderID)
                  -> where('products.tagto','HQ')
                  -> get();

         $orders1 = DB:: table('orders')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('joblists', 'joblists.OrderID', '=', 'orders.OrderID')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select ('users.name','joblists.location_address','joblists.Lat','joblists.Lng', 'joblists.special_notes', 'joblists.job_rating', 'joblists.feedback','users.u_phone','users.email','orders.OrderID', 'store_orders.ProductID', 'products.Name' ,'store_orders.ProductQuantity', 'products.Price', DB::raw('orders.*,(store_orders.ProductQuantity*products.Price) as Total_Amount'))
                  -> where ('orders.OrderID', $OrderID)
                  ->groupby('orders.OrderID')
                  -> where('products.tagto','HQ')
                  -> get();

          

        return view('joblist.orderdetails', [
                    'orders' => $orders,
                    'orders1' => $orders1
                  ]);
        
        
    }

}
