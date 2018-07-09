<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use DB;

class DashboardController extends Controller
{
    public function viewDashboard()
    {

    	$latestorder = DB:: table('orders')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> join ('joblists', 'joblists.OrderID', '=', 'orders.OrderID')
                  -> join ('payments', 'payments.OrderID', '=', 'orders.OrderID')
                  -> select ('orders.OrderID','users.name', 'joblists.status_job', 'payments.amount')
                  ->orderBy('orders.created_at', 'desc')
                  ->limit(8)
                  -> get();


    	$topproduct = DB:: table('products')
                  -> select ('sku_number','Name')
                  ->limit(5)
                  -> get();

        $latestuser= DB:: table('users')
                  -> select ('created_at','name', 'role', 'email')
                  ->orderBy('created_at', 'desc')
                  ->limit(5)
                  -> get();


        return view('dashboard', [
        	'latestorder' => $latestorder,
        	'topproduct' => $topproduct,
        	'latestuser' => $latestuser

        ]);
    }
}
