<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;

class APIDashboardController extends Controller
{

    public function viewdashboard($user_id) {
    	$carbon = Carbon::today();
      $currentMonth = $carbon->format('m');

    	$completed_job = DB:: table('joblists')
                  -> select (DB::raw('count(JobID) as numberofcompletedjob'))
                  -> where(DB::raw("month(created_at)"), '=', $currentMonth )
                  ->where('status_job','=','Completed')
                  ->where('user_id', '=', $user_id)
                  -> get();

        $activetask = DB:: table('joblists')
                  -> select (DB::raw('count(JobID) as numberofactivetask'))
                  -> where(DB::raw("month(created_at)"), '=', $currentMonth )
                  ->where('status_job','=','Active')
                  ->where('user_id', '=', $user_id)
                  -> get();

        $totalsales = DB:: table('transactions')
                  -> select (DB::raw('sum(amount) as totalsale'))
                  -> where(DB::raw("month(created_at)"), '=', $currentMonth )
                  ->where('status','=','Credit')
                  ->where('user_id', '=', $user_id)
                  -> get();

         foreach($completed_job as $data){
             $job = $data->numberofcompletedjob;
         }

         foreach( $activetask as $data){
             $task = $data->numberofactivetask;
         }

         foreach($totalsales as $data){
             $sale = $data->totalsale;
         }


    	return response()->json([
    		'status' => true,
        	'completed_job' => $job,
        	'activetask' => $task,
        	'totalsales' => $sale

        ]);

	}

  public function merchantviewdashboard($user_id) {
      $carbon = Carbon::today();
      $currentMonth = $carbon->format('m');

      $ordertoday = DB:: table('joblists')
                  -> join ('orders', 'orders.OrderID', '=', 'joblists.OrderID')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select (DB::raw('count(JobID) as numberoforder'))
                  ->where('products.tagto', '=', 'MCN')
                  ->where('products.user_id', $user_id)
                  -> where(DB::raw("date(joblists.created_at)"), '=', $carbon->format('Y-m-d'))
                  -> get();

        $ordermonth = DB:: table('joblists')
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

        $productavailable = DB:: table('products')
                  -> select (DB::raw('count(id) as numberofproduct'))
                  ->where('tagto','=','MCN')
                  ->where('user_id', '=', $user_id)
                  ->where('status', '=', 'Approved')
                  -> get();

         foreach($ordertoday as $data){
             $order_today = $data->numberoforder;
         }

         foreach( $ordermonth as $data){
             $order_month = $data->numberofordermonth;
         }

         foreach($totalsales as $data){
             $sale = $data->totalsale;
         }

         foreach($productavailable as $data){
             $product_available = $data->numberofproduct;
         }


      return response()->json([
          'status' => true,
          'order_today' => $order_today,
          'order_month' => $order_month,
          'totalsales' => $sale,
          'product_available' => $product_available

        ]);

  }

   public function LatestOrder($user_id)
      {
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

           
   
          $array = [];
                    foreach($result as $data){
                    $x = $data->JobID;
                    if($data->JobID == $x){
                           $result1 = DB:: table('store_orders')
                            -> join ('joblists', 'joblists.OrderID', '=', 'store_orders.OrderID')
                            -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                            -> select ('store_orders.ProductID','products.Name', 'store_orders.ProductQuantity', DB::raw('(store_orders.ProductQuantity*products.Price) as price'))
                            -> where('joblists.JobID', '=', $x)
                            -> where('products.user_id', $user_id)
                            ->where(function($q) {
                                $q->where('joblists.status_job','Pending');

                              })
                            ->get();
                    }
                    
                   
                    $array[] = [
                                  'OrderID'=> $data->OrderID,
                                  'c_name' => $data->name,
                                  'c_address' => $data->location_address,
                                  'latitude' => $data->Lat,
                                  'longitude' => $data->Lng,
                                  'note' => $data->special_notes,
                                  'total_price'=> $data->sumprice,
                                  'orders' => $result1
                                  

                                ];
                    
                    }

                    return response()->json($array);


    }
}
