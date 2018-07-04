<?php

namespace App\Http\Controllers;

use App\Jobstatus;
use App\Joblist;
use App\Wallet;
use App\Payment;
use App\Transaction;
use App\Mail\Wallet_Credit;
use App\Mail\Reject_Delivery;
use Mail;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class APIJobController extends Controller
{
        public function PendingJob()
    	{
         //list pending job
          $result = DB:: table('joblists')
                  -> join ('orders', 'orders.OrderID', '=', 'joblists.OrderID')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select ('joblists.JobID','joblists.status_job', 'users.name', 'joblists.location_address', 'joblists.Lat', 'joblists.Lng', 'joblists.special_notes', 'orders.total_price','joblists.OrderID','store_orders.ProductID','products.Name', 'store_orders.ProductQuantity', DB::raw('(store_orders.ProductQuantity*products.Price) as price'))
                  -> where('joblists.status_job','Pending')
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
                            ->where(function($q) {
                                $q->where('joblists.status_job','Pending');
                              })
                            ->get();
                    }
              
                   
                    $array[] = [
                                  'JobID'=> $data->JobID,
                                  'current_status'=> $data->status_job,
                                  'c_name' => $data->name,
                                  'c_address' => $data->location_address,
                                  'latitude' => $data->Lat,
                                  'longitude' => $data->Lng,
                                  'note' => $data->special_notes,
                                  'total_price'=> $data->total_price,
                                  'orders' => $result1
                                  

                                ];
                    
                    }

                    return response()->json($array);


    }

        public function ActiveJob($user_id)
      {
          
          $result =DB:: table('joblists')
                  -> join ('orders', 'orders.OrderID', '=', 'joblists.OrderID')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select ('joblists.JobID','joblists.status_job', 'users.name', 'joblists.location_address', 'joblists.Lat', 'joblists.Lng', 'joblists.special_notes', 'orders.total_price','joblists.OrderID','store_orders.ProductID','products.Name', 'store_orders.ProductQuantity', DB::raw('(store_orders.ProductQuantity*products.Price) as price'))
                   -> where('joblists.user_id', '=', $user_id)
                  ->where(function($q) {
                                $q->where('joblists.status_job','Active');
                              })
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
                            ->where(function($z) {
                                $z->where('joblists.status_job','Active');
                              })
                            ->get();
                    }
              
                   
                    $array[] = [
                                  'JobID'=> $data->JobID,
                                  'current_status'=> $data->status_job,
                                  'c_name' => $data->name,
                                  'c_address' => $data->location_address,
                                  'latitude' => $data->Lat,
                                  'longitude' => $data->Lng,
                                  'note' => $data->special_notes,
                                  'total_price'=> $data->total_price,
                                  'orders' => $result1
                                  

                                ];
                    
                    }
          return response() -> json($array);
        
      }

      public function AcceptJob(Request $request, $JobID){
        $jobstatus = DB::table('joblists')->where('JobID', '=', $JobID)->value('status_job');
        if($jobstatus == 'Pending'){
          $jobstatuses = new Jobstatus;
          $jobstatuses->JobID= $JobID;
          $jobstatuses->job_status= 'Active';
          $jobstatuses->save();
          $joblists = Joblist::find($JobID);
          $joblists->user_id = Input::get('user_id');
          $joblists->status_job='Active';
          $joblists->save();

          return response()->json(['JobID'=> $JobID,'message' => 'Successful Accept Job', 'status' => true], 201);
          
        }

        else{
           return response()->json(['message' => 'Job has been accepted by other agent', 'status' => false], 401);
        }
      }

        public function UpdateJob (Request $request, $JobID){
          $jobstatus = DB::table('joblists')->where('JobID', '=', $JobID)->value('status_job');
           if($jobstatus == 'Active'){
              $jobstatuses = new Jobstatus;
              $jobstatuses->JobID= $JobID;
              $jobstatuses->job_status= 'Pending Completion';
              $jobstatuses->save();
              $joblists = Joblist::find($JobID);
              $joblists->status_job='Pending Completion';
              $joblists->save();

              return response()->json(['JobID'=> $JobID,'message' => 'Job has been mark as completed', 'status' => true], 201);

              }
           else 
              return response()->json(['message' => 'Fail to proceed a process', 'status' => false], 401);
        }

      

      public function ViewOrderStatus($user_id){
        $result =DB:: table('joblists')
                  -> join ('orders', 'orders.OrderID', '=', 'joblists.OrderID')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select ('joblists.JobID','joblists.status_job', 'users.name', 'joblists.location_address', 'joblists.Lat', 'joblists.Lng', 'joblists.special_notes', 'orders.total_price','joblists.OrderID','store_orders.ProductID','products.Name', 'store_orders.ProductQuantity', DB::raw('(store_orders.ProductQuantity*products.Price) as price'))
                   -> where('orders.user_id', '=', $user_id)
                  ->where(function($q) {
                                    $q->where('joblists.status_job','Active')
                                      ->orWhere('joblists.status_job', 'Completed');
                                    })
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
                            ->where(function($q) {
                                    $q->where('joblists.status_job','Active')
                                      ->orWhere('joblists.status_job', 'Completed');
                                    })
                            ->get();
                    }
              
                   
                    $array[] = [
                                  'JobID'=> $data->JobID,
                                  'current_status'=> $data->status_job,
                                  'c_name' => $data->name,
                                  'c_address' => $data->location_address,
                                  'latitude' => $data->Lat,
                                  'longitude' => $data->Lng,
                                  'note' => $data->special_notes,
                                  'total_price'=> $data->total_price,
                                  'orders' => $result1
                                  

                                ];
                    
                    }
          return response() -> json($array);
         $orders = DB:: table('orders')
                  ->join('users', 'users.id', '=', 'orders.user_id')
                  ->join('joblists', 'joblists.OrderID', '=', 'orders.OrderID')
                  ->join('jobstatuses', 'jobstatuses.JobID', '=', 'joblists.JobID')
                  ->select ('users.name','orders.OrderID','joblists.JobID','jobstatuses.job_status')
                  ->where('orders.user_id', $user_id) 
                   ->where(function($q) {
                            $q->where('jobstatuses.job_status','Active')
                            ->orWhere('jobstatuses.job_status', 'Completed');
                          }) 
                  -> get();
          return response() -> json(['orders' => $orders],  200);
      }

      public function CancelJob (Request $request, $JobID){
        $jobstatus = DB::table('joblists')->where('JobID', '=', $JobID)->value('status_job');
        if($jobstatus =='Active'){
          $jobstatuses = new Jobstatus;
          $jobstatuses->JobID = $JobID;
          $jobstatuses->job_status = 'Cancel';
          $jobstatuses->message = Input::get('message');
          $jobstatuses->save();
          
          $cancel = DB::table('joblists')->where('JobID', '=', $JobID)->value('cancelcount');
          $joblists = Joblist::find($JobID);
          $joblists->status_job='Cancel';
          $joblists->cancelcount = $cancel + 1;
          $joblists->save();

          $ordernumber=Joblist::where('JobID', '=', $JobID)->value('OrderID');

          $joblist = new Joblist;
          $joblist->status_job = 'Cancel';
          $joblist->OrderID = $ordernumber;
          $joblist->save();
          Jobstatus::CreateStatusJobHQ();

          return response()->json(['JobID'=> $JobID,'message' => 'Job has been Cancel and deliverd to HQ', 'status' => true], 201);
        }

        else
          return response()->json(['message' => 'Fail to proceed a process', 'status' => false], 401);

      }

      public function AcceptDelivery (Request $request, $JobID){
        $customer_id = $request->user_id;
        $orderid = DB::table('joblists')->where('JobID', '=', $JobID)->value('OrderID'); 
        $jobstatus = DB::table('joblists')->where('JobID', '=', $JobID)->value('status_job');
        $custid_db = DB::table('orders')->where('OrderID', '=', $orderid)->value('user_id');
        if($jobstatus == 'Pending Completion' && $customer_id == $custid_db)
        {
          $jobstatuses = new Jobstatus;
          $jobstatuses->JobID = $JobID;
          $jobstatuses->job_status = 'Completed';
          $jobstatuses->save();

          $joblists = Joblist::find($JobID);
          $joblists->status_job='Completed';
          $joblists->save();
          

          $ordernumber = DB::table('joblists')->where('JobID', '=', $JobID)->value('OrderID');
          $userid = DB::table('joblists')->where('JobID', '=', $JobID)->value('user_id');
          $walletID= DB::table('wallets')->where('user_id', '=', $userid)->value('walletID');
          $wallet_amount = DB::table('wallets')->where('walletID', '=', $walletID)->value('amount');
          $amount=DB::table('payments')->where('OrderID', '=', $ordernumber)->value('amount');

           if(!$walletID == null){
              $wallet = Wallet::find($walletID);
              $wallet->amount = $wallet_amount+$amount;
              $wallet->save();

              $transaction = new Transaction;
              $transaction->walletID = $walletID;
              $transaction->user_id = $userid;
              $transaction->status = 'Credit';
              $transaction->message = 'Order Completed';
              $transaction->amount = $amount;
              $transaction->save();
              
          }

          else{
             $wallet = new Wallet;
             $wallet->user_id = $userid;
             $wallet->amount = $amount;
             $wallet->save();
             $lastwalletID = Wallet::orderBy('created_at', 'desc')->value('walletID');

             $transaction = new Transaction;
             $transaction->walletID = $lastwalletID;
             $transaction->user_id = $userid;
             $transaction->amount = $amount;
             $transaction->save();
              
          }


          $email=DB::table('users')->where('users.id', '=', $userid)->value('email');
          Mail::to($email)->send(new Wallet_Credit($email));
          
           return response()->json(['message' => 'You have accepted the delivery. Thank you.', 'status' => true], 201);

        }
        else
           return response()->json(['message' => 'Fail to proceed a process', 'status' => false], 401);
      }

      public function RejectDelivery (Request $request, $JobID){
        $customer_id = $request->user_id;
        $orderid = DB::table('joblists')->where('JobID', '=', $JobID)->value('OrderID'); 
        $jobstatus = DB::table('joblists')->where('JobID', '=', $JobID)->value('status_job');
        $custid_db = DB::table('orders')->where('OrderID', '=', $orderid)->value('user_id');
        if($jobstatus =='Active' && $customer_id == $custid_db)
        {
          $jobstatuses = new Jobstatus;
          $jobstatuses->JobID = $JobID;
          $jobstatuses->job_status = 'Reject';
          $jobstatuses->message = Input::get('message');
          $jobstatuses->save();

          $joblists = Joblist::find($JobID);
          $joblists->status_job='Reject';
          $joblists->save();
          
          $userid = DB::table('joblists')->where('JobID', '=', $JobID)->value('user_id');
         

          $email=DB::table('users')->where('users.id', '=', $userid)->value('email');
          Mail::to($email)->send(new Reject_Delivery($email));
          
           return response()->json(['JobID'=> $JobID,'message' => 'Delivery has been rejected by customer', 'status' => true], 201);

        }
        else
           return response()->json(['message' => 'Fail to proceed a process', 'status' => false], 401);
      }

   		
}
