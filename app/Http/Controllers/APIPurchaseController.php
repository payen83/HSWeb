<?php

namespace App\Http\Controllers;


use App\Orders;
use App\StoreOrders;
use App\Payment;
use App\Joblist;
use App\Jobstatus;
use App\User;
use App\Mail\Invoice;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class APIPurchaseController extends Controller
{
    public function orders(Request $request) {


    //create orders number 
        $order_no = Orders::getNextOrderNumber();
        $id = $request->user_id;

    	if($request->role =="Customer"){
           $joblist = new Joblist;
           $joblist->status_job = 0;
           $joblist->OrderID = $order_no;
           $joblist->save();
           Jobstatus::CreateStatusJob();
    	}

    	else if ($request->role =="Agent"){
           echo "Agent buy";
    	}
   
        $orders = new Orders;
        $orders->OrderID = $order_no;
        $orders->user_id = Input::get('user_id');
        $orders->total_price = Input::get('total_price');
        $orders->save();
       
        // validated input request
            $this->validate($request, [
                            'ProductID' => 'required',
                            ]);

        // create new task
            $rows = $request->input('rows');
            foreach ($rows as $row)
                    {
                    $store_orders[] = [
                    'OrderID'=>$row[$order_no],
                    'ProductID'=>$row['ProductID'],
                    'ProductQuantity'=>$row['ProductQuantity'],
                    'Discount'=>$row['Discount'/100],

                      ];
           }
            StoreOrders::insert($store_orders);

        $payment = new Payment;
        $payment ->OrderID = $order_no;
        $payment ->payment_method = Input::get('payment_method');
        $payment ->user_id = Input::get('user_id');
        $payment ->amount = Input::get('amount');
        $payment ->currency = Input::get('currency');
        $payment->save();
        
        $email=User::where('users.id', '=', $id)->pluck('email','id');
        Mail::to($email)->send(new Invoice($email));
        return response()->json(['OrderID'=> $order_no,'message' => 'Successful Order', 'status' => true], 201);

    }
}
