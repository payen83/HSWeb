<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function viewDashboard()
    {

    	$latestorder = DB:: table('orders')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> join ('joblists', 'joblists.OrderID', '=', 'orders.OrderID')
                  -> select ('orders.OrderID','users.name', 'joblists.status_job', 'orders.total_price')
                  ->orderBy('orders.created_at', 'desc')
                  ->limit(8)
                  -> get();


    	$topproduct = DB:: table('store_orders')
                  -> join('products', 'products.id', '=' , 'store_orders.ProductID')
                  -> select ('products.sku_number','products.Name', 'store_orders.ProductID', DB::raw('sum(store_orders.ProductQuantity) as TotalQuantity'))
                  ->groupby('store_orders.ProductID')
                  ->orderBy('TotalQuantity', 'desc')
                  ->limit(5)
                  -> get();

        $latestuser= DB:: table('users')
                  -> select ('created_at','name', 'role', 'email')
                  ->orderBy('created_at', 'desc')
                  ->limit(5)
                  -> get();

      $pendingorder = DB:: table('joblists')
                  -> select (DB::raw('count(JobID) as pendingorders'))
                  -> where('status_job', '=', 'Pending')
                  -> get();

      $completedorder = DB:: table('joblists')
                  -> select (DB::raw('count(JobID) as completedorders'))
                  -> where('status_job', '=', 'Completed')
                  -> get();

      $carbon = Carbon::today();
      $ordertoday = DB:: table('orders')
                  -> select (DB::raw('count(OrderID) as numberoforder'))
                  -> where(DB::raw("date(created_at)"), '=', $carbon->format('Y-m-d'))
                  -> get();

      $carbon = Carbon::today();
      $earntoday = DB:: table('payments')
                  -> select ('amount')
                  -> where(DB::raw("date(created_at)"), '=', $carbon->format('Y-m-d'))
                  -> get();


        return view('dashboard', [
        	'latestorder' => $latestorder,
        	'topproduct' => $topproduct,
        	'latestuser' => $latestuser,
          'pendingorder' => $pendingorder,
          'completedorder' => $completedorder,
          'ordertoday' => $ordertoday,
          'earntoday' => $earntoday

        ]);
    }
}
