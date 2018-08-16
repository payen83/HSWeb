<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use DB;

class HomeController extends Controller
{
    public function viewHome() {
      $user_id = Auth::user()->id;
      $carbon = Carbon::today();
      $currentMonth = $carbon->format('m');

      $order_today = DB:: table('joblists')
                  -> join ('orders', 'orders.OrderID', '=', 'joblists.OrderID')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select (DB::raw('count(JobID) as numberoforder'))
                  ->where('products.tagto', '=', 'MCN')
                  ->where('products.user_id', $user_id)
                  -> where(DB::raw("date(joblists.created_at)"), '=', $carbon->format('Y-m-d'))
                  -> get();

        $order_month = DB:: table('joblists')
                  -> join ('orders', 'orders.OrderID', '=', 'joblists.OrderID')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select (DB::raw('count(JobID) as numberofordermonth'))
                  ->where('products.tagto', '=', 'MCN')
                  ->where('products.user_id', $user_id)
                  -> where(DB::raw("month(joblists.created_at)"), '=', $carbon->format('m'))
                  -> get();

        $totalsales = DB:: table('transactions')
                  -> select (DB::raw('sum(amount) as totalsale'))
                  -> where(DB::raw("month(created_at)"), '=', $currentMonth )
                  ->where('status','=','Credit')
                  ->where('user_id', '=', $user_id)
                  -> get();

        $product_available = DB:: table('products')
                  -> select (DB::raw('count(id) as numberofproduct'))
                  ->where('tagto','=','MCN')
                  ->where('user_id', '=', $user_id)
                  ->where('status', '=', 'Approved')
                  -> get();

         $product = DB:: table('products')
                  -> select ('Name', 'sku_number', 'status', 'Price')
                  ->where('tagto','=','MCN')
                  ->where('user_id', '=', $user_id)
                  ->where('status', '=', 'Approved')
                  -> get();


        //list pending job
          $result = DB:: table('joblists')
                  -> join ('orders', 'orders.OrderID', '=', 'joblists.OrderID')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select ('joblists.JobID','joblists.OrderID','joblists.status_job', 'users.name', 'joblists.location_address', 'joblists.Lat', 'joblists.Lng', 'joblists.special_notes', 'orders.total_price','joblists.OrderID','store_orders.ProductID','products.Name', 'store_orders.ProductQuantity', DB::raw('sum(store_orders.ProductQuantity*products.Price) as sumprice'))
                  -> where('joblists.status_job','Pending')
                  -> where('products.tagto','MCN')
                  -> where('products.user_id', $user_id)
                  ->orderBy('orders.created_at', 'desc')
                  ->limit(5)
                  ->groupby('joblists.OrderID')
                  ->get();

       


      return view('home',[
          'status' => true,
          'order_today' => $order_today,
          'order_month' => $order_month,
          'totalsales' => $totalsales,
          'product_available' => $product_available,
          'result' => $result,
          'product' => $product,

        ]);

  }

}
