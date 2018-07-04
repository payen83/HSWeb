<?php

namespace App\Http\Controllers;


use App\Orders;
use App\StoreOrders;
use App\Payment;
use App\Joblist;
use App\Jobstatus;
use App\User;
use App\Transaction;
use App\Wallet;
use App\Mail\Invoice;
use Mail;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class APIPurchaseController extends Controller
{
    public function orders(Request $request, $user_id) {
      
      $id= DB::table('orders')->where('user_id', '=', $user_id)->value('user_id');
      $role= DB::table('users')->where('id', '=', $id)->value('role');
    	if($role =="Customer"){
            // create order no
           $order_no = Orders::getNextOrderNumber();
           $orders = new Orders;
           $orders->OrderID = $order_no;
           $orders->user_id = $user_id;
           $orders->total_price = Input::get('total_price');
           $orders->save();
       

           // store product
            
            $data = json_decode(Input::get('data'), true);
            //dd($data);
            foreach ($data as $row)
                    {  
                     //dd($row);
                     $store_orders[] = [
                    'OrderID' => $order_no,
                    'ProductID'=>$row['ProductID'],
                    'ProductQuantity'=>$row['ProductQuantity'],
                    'Discount'=>$row['Discount']/100,
                    ];

           }
            StoreOrders::insert($store_orders);

           $joblist = new Joblist;
           $joblist->status_job = 'Pending';
           $joblist->OrderID = $order_no;
           $joblist->location_address = Input::get('location_address');
           $joblist->special_notes = Input::get('special_notes');
           $joblist->Lat = Input::get('Lat');
           $joblist->Lng = Input::get('Lng');
           $joblist->save();
           Jobstatus::CreateStatusJob();

           $payment = new Payment;
           $payment ->OrderID = $order_no;
           $payment ->payment_method = Input::get('payment_method');
           $payment ->user_id = $user_id;
           $payment ->amount = Input::get('amount');
           $payment ->currency = Input::get('currency');
           $payment ->payment_date = Input::get('payment_date');
           $payment ->transaction_id = Input::get('transaction_id');
           $payment->save();
        
           $email=User::where('users.id', '=', $user_id)->pluck('email','id');
           Mail::to($email)->send(new Invoice($email));
           return response()->json(['OrderID'=> $order_no,'message' => 'Successful Order', 'status' => true], 201);
    	}

    	else if ($role =="Agent"){
        // create order number
           $order_no = Orders::getNextOrderNumber();
           $orders = new Orders;
           $orders->OrderID = $order_no;
           $orders->user_id = $user_id;
           $orders->total_price = Input::get('total_price');
           $orders->save();
       

         // store product
            
            $data = json_decode(Input::get('data'), true);
            //dd($data);
            foreach ($data as $row)
                    {  
                     //dd($row);
                     $store_orders[] = [
                    'OrderID' => $order_no,
                    'ProductID'=>$row['ProductID'],
                    'ProductQuantity'=>$row['ProductQuantity'],
                    'Discount'=>$row['Discount']/100,
                    ];

           }
            StoreOrders::insert($store_orders);

              $payment = new Payment;
              $payment ->OrderID = $order_no;
              $payment ->payment_method = Input::get('payment_method');
              $payment ->user_id = $user_id;
              $payment ->amount = Input::get('amount');
              $payment ->currency = Input::get('currency');
              $payment ->payment_date = Input::get('payment_date');
              $payment ->transaction_id = Input::get('transaction_id');
              $payment->save();
        
            $walletID= DB::table('wallets')->where('user_id', '=', $user_id)->value('walletID');
            $wallet_amount = DB::table('wallets')->where('walletID', '=', $walletID)->value('amount');
            $amount=$request->amount;
            
            if($wallet_amount >= $amount){
                    $wallet = Wallet::find($walletID);
                    $wallet->amount = $wallet_amount - $amount;
                    $wallet->save();

                    $transaction = new Transaction;
                    $transaction->walletID = $walletID;
                    $transaction->user_id = $user_id;
                    $transaction->status = 'Debit';
                    $transaction->message = 'Restock Product';
                    $transaction->amount = $amount;
                    $transaction->save();

                    $email=User::where('users.id', '=', $user_id)->pluck('email','id');
                    Mail::to($email)->send(new Invoice($email));
                   return response()->json(['OrderID'=> $order_no,'message' => 'Successful Order', 'status' => true], 201);
              
            }
            else
              return response()->json(['message' => 'Not enough wallet amount to make order', 'status' => false], 401);  

    	}
      else
        return response()->json(['message' => 'You are not allowed to make order', 'status' => false], 401);
        

    }
}
