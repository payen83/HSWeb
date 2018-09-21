<?php

namespace App\Http\Controllers;

use App\Jobstatus;
use App\Joblist;
use App\Wallet;
use App\Payment;
use App\Transaction;
use App\User;
use App\Orders;
use App\Mail\Wallet_Credit;
use App\Mail\Reject_Delivery;
use Mail;
use DB;
use Carbon\Carbon;
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
                  -> where('joblists.orderfrom','C')
                  -> where('products.tagto','HQ')
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
                            -> where('products.tagto','HQ')
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

     public function PendingJobMerchant($user_id)
      {
         //list pending job
          $result = DB:: table('joblists')
                  -> join ('orders', 'orders.OrderID', '=', 'joblists.OrderID')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select ('joblists.JobID','joblists.status_job', 'users.name', 'joblists.location_address', 'joblists.Lat', 'joblists.Lng', 'joblists.special_notes', 'orders.total_price','joblists.OrderID','store_orders.ProductID','products.Name', 'store_orders.ProductQuantity', DB::raw('sum(store_orders.ProductQuantity*products.Price) as sumprice'))
                  ->where(function($q) {
                                $q->where('joblists.status_job','Pending')
                                  ->orWhere('joblists.status_job','Completed');

                              })
                  -> where('products.tagto','MCN')
                  -> where('products.user_id', $user_id)
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
                                $q->where('joblists.status_job','Pending')
                                  ->orWhere('joblists.status_job','Completed');

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
                                  'total_price'=> $data->sumprice,
                                  'orders' => $result1
                                  

                                ];
                     
                    }

                    return response()->json($array);


    }

     public function PickMethod(Request $request, $JobID){

        if ($request->delivery_method == 'POS'){
            $jobstatus = DB::table('joblists')->where('JobID', '=', $JobID)->value('status_job');
            if($jobstatus == 'Pending'){
              $jobstatuses = new Jobstatus;
              $jobstatuses->JobID= $JobID;
              $jobstatuses->job_status= 'Active';
              $jobstatuses->save();

              $joblists = Joblist::find($JobID);
              $joblists->user_id = Input::get('user_id');
              $joblists->status_job='Active';
              $joblists->tracking_number = Input::get('tracking_number');
              $joblists->update_at =Carbon::now('Asia/Kuala_Lumpur');
              $joblists->save();

              return response()->json(['JobID'=> $JobID,'message' => 'You delivery method has been saved', 'status' => true], 201);
            }

            else{
              return response()->json(['message' => 'Fail to proceed a process', 'status' => false], 401);
           }
        } // end if

        else if ($request->delivery_method == 'COD'){
          $jobstatus = DB::table('joblists')->where('JobID', '=', $JobID)->value('status_job');
            if($jobstatus == 'Pending'){
              $jobstatuses = new Jobstatus;
              $jobstatuses->JobID= $JobID;
              $jobstatuses->job_status= 'Active';
              $jobstatuses->save();

              $joblists = Joblist::find($JobID);
              $joblists->user_id = Input::get('user_id');
              $joblists->status_job='Active';
              $joblists->update_at =Carbon::now('Asia/Kuala_Lumpur');
              $joblists->save();

              return response()->json(['JobID'=> $JobID,'message' => 'You delivery method has been saved', 'status' => true], 201);
            }

            else{
              return response()->json(['message' => 'Fail to proceed a process', 'status' => false], 401);
           }

        }
        
        
      }

    public function MerchantCompleteJob (Request $request, $JobID){
        
        if ($request->delivery_method == 'POS'){
        $orderid = DB::table('joblists')->where('JobID', '=', $JobID)->value('OrderID'); 
        $jobstatus = DB::table('joblists')->where('JobID', '=', $JobID)->value('status_job');
        $userid = $request->user_id;
        if($jobstatus == 'Pending')
        {
            $jobstatuses = new Jobstatus;
            $jobstatuses->JobID = $JobID;
            $jobstatuses->job_status = 'Completed';
            $jobstatuses->save();

            $joblists = Joblist::find($JobID);
            $joblists->user_id = $userid;
            $joblists->status_job='Completed';
            $joblists->tracking_number = Input::get('tracking_number');
            $joblists->update_at =Carbon::now('Asia/Kuala_Lumpur');
            $joblists->save();
            

            $ordernumber = DB::table('joblists')->where('JobID', '=', $JobID)->value('OrderID');
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
               $transaction->status = 'Credit';
               $transaction->message = 'Order Completed';
               $transaction->amount = $amount;
               $transaction->save();
                
            }


           $email=User::where('users.id', '=', $userid)->value('email');
           $name=User::where('users.id', '=', $userid)->value('name');
           $amount_wallet = $wallet_amount+$amount;
              
               $data1 = [
                   'email'          => $email,
                   'name'           => $name,
                   'amount_credit'  => $amount,
                   'amount_wallet'  => $amount_wallet,
                ];

                Mail::send('emails.wallet', $data1, function($m) use ($data1){
                   $m->to($data1['email'], '')->subject('Wallet Credit');
                });
            
             return response()->json(['message' => 'You have completed the delivery method. Thank you.', 'status' => true], 201);

          }
           else
              return response()->json(['message' => 'Fail to proceed a process', 'status' => false], 401);
        }// end if

        else if ($request->delivery_method == 'COD'){
              $orderid = DB::table('joblists')->where('JobID', '=', $JobID)->value('OrderID'); 
              $jobstatus = DB::table('joblists')->where('JobID', '=', $JobID)->value('status_job');
              $userid = $request->user_id;
              if($jobstatus == 'Pending')
              {
                  $jobstatuses = new Jobstatus;
                  $jobstatuses->JobID = $JobID;
                  $jobstatuses->job_status = 'Completed';
                  $jobstatuses->save();

                  $joblists = Joblist::find($JobID);
                  $joblists->user_id = $userid;
                  $joblists->status_job='Completed';
                  $joblists->update_at =Carbon::now('Asia/Kuala_Lumpur');
                  $joblists->save();
                  

                  $ordernumber = DB::table('joblists')->where('JobID', '=', $JobID)->value('OrderID');
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
                     $transaction->status = 'Credit';
                     $transaction->message = 'Order Completed';
                     $transaction->amount = $amount;
                     $transaction->save();
                      
                  }


                 $email=User::where('users.id', '=', $userid)->value('email');
                 $name=User::where('users.id', '=', $userid)->value('name');
                 $amount_wallet = $wallet_amount+$amount;
                    
                     $data1 = [
                         'email'          => $email,
                         'name'           => $name,
                         'amount_credit'  => $amount,
                         'amount_wallet'  => $amount_wallet,
                      ];

                      Mail::send('emails.wallet', $data1, function($m) use ($data1){
                         $m->to($data1['email'], '')->subject('Wallet Credit');
                      });
                  
                   return response()->json(['message' => 'You have completed the delivery method. Thank you.', 'status' => true], 201);

                }
                else
                  return response()->json(['message' => 'Fail to proceed a process', 'status' => false], 401);
        }//end else if
        
        


        }//end public

        public function StatusJob($user_id)
      {

          $result =DB:: table('joblists')
                  -> join ('orders', 'orders.OrderID', '=', 'joblists.OrderID')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select ('joblists.JobID','joblists.status_job', 'users.name', 'users.u_phone', 'users.url_image', 'joblists.location_address', 'joblists.Lat', 'joblists.Lng', 'joblists.special_notes', 'joblists.job_rating','joblists.feedback','orders.total_price','joblists.OrderID','store_orders.ProductID','products.Name', 'store_orders.ProductQuantity', DB::raw('(store_orders.ProductQuantity*products.Price) as price'))
                   -> where('joblists.user_id', '=', $user_id)
                   ->where(function($q) {
                                $q->where('joblists.status_job','Active')
                                   ->orWhere('joblists.status_job', 'Completed')
                                   ->orWhere('joblists.status_job', 'Pending Completion');
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
                            -> select ('store_orders.ProductID','products.Name', 'products.ImageURL','store_orders.ProductQuantity', DB::raw('(store_orders.ProductQuantity*products.Price) as price'))
                            -> where('joblists.JobID', '=', $x)
                            ->where(function($z) {
                                $z->where('joblists.status_job','Active')
                                   ->orWhere('joblists.status_job', 'Completed')
                                   ->orWhere('joblists.status_job', 'Pending Completion');
                              })
                            ->get();
                    }
              
                   
                    $array[] = [
                                  'JobID'=> $data->JobID,
                                  'current_status'=> $data->status_job,
                                  'job_rating' => $data->job_rating,
                                  'job_feedback' => $data->feedback,
                                  'c_name' => $data->name,
                                  'c_address' => $data->location_address,
                                  'u_phone' => $data->u_phone,
                                  'url_image' => $data->url_image,
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
        $orderid = DB::table('joblists')->where('JobID', '=', $JobID)->value('OrderID');
        $customerid = DB::table('orders')->where('OrderID', '=', $orderid)->value('user_id');
        $playerid = DB::table('users')->where('id', '=', $customerid)->value('playerId');

        if($jobstatus == 'Pending'){
          $jobstatuses = new Jobstatus;
          $jobstatuses->JobID= $JobID;
          $jobstatuses->job_status= 'Active';
          $jobstatuses->save();
          $joblists = Joblist::find($JobID);
          $joblists->user_id = Input::get('user_id');
          $joblists->status_job='Active';
          $joblists->update_at =Carbon::now('Asia/Kuala_Lumpur');
          $joblists->save();

          $content = array(
                  "en" => 'Your Order: '.$orderid.' has been accepted by agent for delivery'
                  );
                
                $fields = array(
                  'app_id' => "1d01174b-ba24-429a-87a0-2f1169f1bc84",
                  'include_player_ids' => array($playerid),
                  'data' => array("OrderID" => $orderid),
                  'contents' => $content
                );
                
                $fields = json_encode($fields);
                  print("\nJSON sent:\n");
                  print($fields);
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                       'Authorization: Basic NmU4MWZjZDEtNDc5YS00NWMzLTkxMTAtNDNjMjl5ODl3YzBi'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

                $response = curl_exec($ch);
                curl_close($ch);
                
                return $response;
            
              $return["allresponses"] = $response;
              $return = json_encode( $return);
              
              print("\n\nJSON received:\n");
              print($return);
              print("\n");

          return response()->json(['JobID'=> $JobID,'message' => 'Successful Accept Job', 'status' => true], 201);
          
        }

        else{
           return response()->json(['message' => 'Job has been accepted by other agent', 'status' => false], 401);
        }
      }

        public function UpdateJob (Request $request, $JobID){
          $jobstatus = DB::table('joblists')->where('JobID', '=', $JobID)->value('status_job');
          $userid = DB::table('joblists')->where('JobID', '=', $JobID)->value('user_id');
          $orderid = DB::table('joblists')->where('JobID', '=', $JobID)->value('OrderID');
          $customerid = DB::table('orders')->where('OrderID', '=', $orderid)->value('user_id');
          $playerid = DB::table('users')->where('id', '=', $customerid)->value('playerId');

           if($jobstatus == 'Active' && $userid == $request->user_id ){
              $jobstatuses = new Jobstatus;
              $jobstatuses->JobID= $JobID;
              $jobstatuses->job_status= 'Pending Completion';
              $jobstatuses->save();
              $joblists = Joblist::find($JobID);
              $joblists->status_job='Pending Completion';
              $joblists->update_at =Carbon::now('Asia/Kuala_Lumpur');
              $joblists->save();

              
                $content = array(
                  "en" => 'Job Completed: Your order has been marked as completed by agent'
                  );
                
                $fields = array(
                  'app_id' => "1d01174b-ba24-429a-87a0-2f1169f1bc84",
                  'include_player_ids' => array($playerid),
                  'data' => array("JobID" => $JobID),
                  'contents' => $content
                );
                
                $fields = json_encode($fields);
                  print("\nJSON sent:\n");
                  print($fields);
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                       'Authorization: Basic NmU4MWZjZDEtNDc5YS00NWMzLTkxMTAtNDNjMjl5ODl3YzBi'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

                $response = curl_exec($ch);
                curl_close($ch);
                
                return $response;
            
              $return["allresponses"] = $response;
              $return = json_encode( $return);
              
              print("\n\nJSON received:\n");
              print($return);
              print("\n");

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
                  -> select ('joblists.JobID','joblists.status_job', 'users.name', 'joblists.location_address', 'joblists.Lat', 'joblists.Lng', 'joblists.special_notes', 'joblists.job_rating', 'joblists.feedback', 'orders.total_price','joblists.OrderID','store_orders.ProductID','products.Name', 'store_orders.ProductQuantity', DB::raw('(store_orders.ProductQuantity*products.Price) as price'))
                   -> where('orders.user_id', '=', $user_id)
                  ->where(function($q) {
                                    $q->where('joblists.status_job','Active')
                                      ->orWhere('joblists.status_job', 'Pending')
                                      ->orWhere('joblists.status_job', 'Pending Completion')
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
                            -> select ('store_orders.ProductID','products.Name', 'store_orders.ProductQuantity', DB::raw('(store_orders.ProductQuantity*products.Price) as price'), 'products.ImageURL', 'products.tagto')
                            -> where('joblists.JobID', '=', $x)
                            ->where(function($q) {
                                    $q->where('joblists.status_job','Active')
                                      ->orWhere('joblists.status_job', 'Pending')
                                      ->orWhere('joblists.status_job', 'Pending Completion')
                                      ->orWhere('joblists.status_job', 'Completed');
                                    })
                            ->get();

                            $result2 = DB:: table('joblists')
                            -> join ('users', 'users.id', '=', 'joblists.user_id')
                            -> select ('users.id','users.name','users.url_image', 'users.u_phone', 'users.u_rating')
                            -> where('joblists.JobID', '=', $x)
                            ->where(function($q) {
                                    $q->where('joblists.status_job','Active')
                                      ->orWhere('joblists.status_job', 'Pending')
                                      ->orWhere('joblists.status_job', 'Pending Completion')
                                      ->orWhere('joblists.status_job', 'Completed');
                                    })
                            ->get();
                    }
              
                   
                    $array[] = [
                                  'JobID'=> $data->JobID,
                                  'current_status'=> $data->status_job,
                                  'job_rating' => $data->job_rating,
                                  'feedback' => $data->feedback,
                                  'c_name' => $data->name,
                                  'c_address' => $data->location_address,
                                  'latitude' => $data->Lat,
                                  'longitude' => $data->Lng,
                                  'note' => $data->special_notes,
                                  'total_price'=> $data->total_price,
                                  'orders' => $result1,
                                  'agent' => $result2
                                  

                                ];
                    
                    }
          return response() -> json($array);
       
      }

      public function CancelJob (Request $request, $JobID){
        $jobstatus = DB::table('joblists')->where('JobID', '=', $JobID)->value('status_job');
        $agentid = DB::table('joblists')->where('JobID', '=', $JobID)->value('user_id');
        $orderid = DB::table('joblists')->where('JobID', '=', $JobID)->value('OrderID');
        $userid = DB::table('orders')->where('OrderID', '=', $orderid)->value('user_id');
        
        if($jobstatus =='Active' && $request->customer_id == $userid){
          $jobstatuses = new Jobstatus;
          $jobstatuses->JobID = $JobID;
          $jobstatuses->job_status = 'Cancel';
          $jobstatuses->message = Input::get('message');
          $jobstatuses->save();
          
          $cancel = DB::table('joblists')->where('JobID', '=', $JobID)->value('cancelcount');
          $joblists = Joblist::find($JobID);
          $joblists->status_job='Cancel';
          $joblists->cancelcount = $cancel + 1;
          $joblists->update_at =Carbon::now('Asia/Kuala_Lumpur');
          $joblists->save();

          $ordernumber=Joblist::where('JobID', '=', $JobID)->value('OrderID');
          $locationadd=Joblist::where('JobID', '=', $JobID)->value('location_address');
          $city=Joblist::where('JobID', '=', $JobID)->value('city');
          $postcode=Joblist::where('JobID', '=', $JobID)->value('postcode');
          $state=Joblist::where('JobID', '=', $JobID)->value('state');
          $cus_id = Orders::where('OrderID', '=', $ordernumber)->value('user_id');
          if($locationadd == '' && $city == '' && $postcode == '' && $state == ''){

            $address =User::where('id', '=', $cus_id)->value('u_address');
            $u_city =User::where('id', '=', $cus_id)->value('u_city');
            $u_postcode =User::where('id', '=', $cus_id)->value('u_postcode');
            $u_state =User::where('id', '=', $cus_id)->value('u_state');

            $joblist = new Joblist;
            $joblist->status_job = 'HQ Delivery';
            $joblist->OrderID = $ordernumber;
            $joblists->location_address = $address;
            $joblists->city = $u_city;
            $joblists->postcode = $u_postcode;
            $joblists->state = $u_state;
            $joblists->orderfrom = 'C';
            $joblist->save();
          }

          else{
              $joblist = new Joblist;
              $joblist->status_job = 'HQ Delivery';
              $joblist->OrderID = $ordernumber;
              $joblists->location_address = $locationadd;
              $joblists->city = $city;
              $joblists->postcode = $postcode;
              $joblists->state = $state;
              $joblists->orderfrom = 'C';
              $joblist->save();
          }
         
          

         $agentemail = DB::table('users')->where('id', '=', $agentid)->value('email');
         $name=User::where('users.id', '=', $agentid)->value('name');
         $payment_date = DB::table('payments')->where('OrderID', '=', $ordernumber)->value('payment_date');
         $paymentmethod = DB::table('payments')->where('OrderID', '=', $ordernumber)->value('payment_method');
         $address = DB::table('joblists')->where('JobID', '=', $JobID)->value('location_address');
         $city = DB::table('joblists')->where('JobID', '=', $JobID)->value('city');
         $state = DB::table('joblists')->where('JobID', '=', $JobID)->value('state');
         $postcode = DB::table('joblists')->where('JobID', '=', $JobID)->value('postcode');
         $order = DB:: table('store_orders')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> select ('products.Name', 'store_orders.ProductQuantity', DB::raw('(store_orders.ProductQuantity*products.Price) as Total_Amount'))
                  ->where('store_orders.OrderID', $ordernumber)
                  ->where('products.tagto', '=', 'HQ')
                  -> get();
         
             $data1 = [
                 'email'          => $agentemail,
                 'name'           => $name,
                 'OrderID'        => $ordernumber,
                 'payment_date'   => $payment_date,
                 'payment_method' => $paymentmethod,
                 'location_address' => $address,
                 'city'             => $city,
                 'state'            => $state,
                 'postcode'         => $postcode,
                 'order'            => $order,
              ];

           $adminemail = DB::table('users')->select('email')->where('role', '=', 'Admin')->get();

               $data2 = [
                 'email'          => $adminemail->pluck('email')->toArray(),
                 'OrderID'        => $ordernumber,
                 'payment_date'   => $payment_date,
                 'payment_method' => $paymentmethod,
                 'location_address' => $address,
                 'city'             => $city,
                 'state'            => $state,
                 'postcode'         => $postcode,
                 'order'            => $order,
              ];

              $superadminemail = DB::table('users')->select('email')->where('role', '=', 'SuperAdmin')->get();

               $data3 = [
                 'email'          => $superadminemail->pluck('email')->toArray(),
                 'OrderID'        => $ordernumber,
                 'payment_date'   => $payment_date,
                 'payment_method' => $paymentmethod,
                 'location_address' => $address,
                 'city'             => $city,
                 'state'            => $state,
                 'postcode'         => $postcode,
                 'order'            => $order,
              ];

              Mail::send('emails.cancel', $data1, function($m) use ($data1){
                 $m->to($data1['email'], '')->subject('Alert Notifications');
              });

              Mail::send('emails.notifyorder', $data2, function($m) use ($data2){
                 $m->to($data2['email'], '')->subject('Notifications Order');
              });

              Mail::send('emails.notifyorder', $data3, function($m) use ($data3){
                 $m->to($data3['email'], '')->subject('Notifications Order');
              });

                $playerid = DB::table('users')->where('id', '=', $agentid)->value('playerId');

                $content = array(
                    "en" => 'JobID: '.$JobID.' has been Cancel by customer and deliverd to HQ'
                    );
                
                $fields = array(
                  'app_id' => "1d01174b-ba24-429a-87a0-2f1169f1bc84",
                  'include_player_ids' => array($playerid),
                  'data' => array("JobID" => $JobID),
                  'contents' => $content
                );
                
                $fields = json_encode($fields);
                  print("\nJSON sent:\n");
                  print($fields);
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                       'Authorization: Basic NmU4MWZjZDEtNDc5YS00NWMzLTkxMTAtNDNjMjl5ODl3YzBi'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

                $response = curl_exec($ch);
                curl_close($ch);
                
                return $response;
            
              $return["allresponses"] = $response;
              $return = json_encode( $return);
              
              print("\n\nJSON received:\n");
              print($return);
              print("\n");
          

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
        $agentid = DB::table('joblists')->where('JobID', '=', $JobID)->value('user_id');

        if($jobstatus == 'Pending Completion' && $customer_id == $custid_db)
        {
          $jobstatuses = new Jobstatus;
          $jobstatuses->JobID = $JobID;
          $jobstatuses->job_status = 'Completed';
          $jobstatuses->save();

          $joblists = Joblist::find($JobID);
          $joblists->status_job='Completed';
          $joblists->update_at =Carbon::now('Asia/Kuala_Lumpur');
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
             $transaction->status = 'Credit';
             $transaction->message = 'Order Completed';
             $transaction->amount = $amount;
             $transaction->save();
              
          }


         $email=User::where('users.id', '=', $userid)->value('email');
         $name=User::where('users.id', '=', $userid)->value('name');
         $amount_wallet = $wallet_amount+$amount;
            
             $data1 = [
                 'email'          => $email,
                 'name'           => $name,
                 'amount_credit'  => $amount,
                 'amount_wallet'  => $amount_wallet,
              ];

              Mail::send('emails.wallet', $data1, function($m) use ($data1){
                 $m->to($data1['email'], '')->subject('Wallet Credit');
              });

               $playerid = DB::table('users')->where('id', '=', $agentid)->value('playerId');

                $content = array(
                    "en" => 'JobID: '.$JobID.' Customer has accept your delivery'
                    );
                
                $fields = array(
                  'app_id' => "1d01174b-ba24-429a-87a0-2f1169f1bc84",
                  'include_player_ids' => array($playerid),
                  'data' => array("JobID" => $JobID),
                  'contents' => $content
                );
                
                $fields = json_encode($fields);
                  print("\nJSON sent:\n");
                  print($fields);
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                       'Authorization: Basic NmU4MWZjZDEtNDc5YS00NWMzLTkxMTAtNDNjMjl5ODl3YzBi'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

                $response = curl_exec($ch);
                curl_close($ch);
                
                return $response;
            
              $return["allresponses"] = $response;
              $return = json_encode( $return);
              
              print("\n\nJSON received:\n");
              print($return);
              print("\n");
          
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
          $joblists->update_at =Carbon::now('Asia/Kuala_Lumpur');
          $joblists->save();
          
          $userid = DB::table('joblists')->where('JobID', '=', $JobID)->value('user_id');
         

          $email=User::where('users.id', '=', $userid)->value('email');
          $name=User::where('users.id', '=', $custid_db)->value('name');
          $pesanan = Input::get('message');
            
             $data1 = [
                 'email'          => $email,
                 'orderid'        => $orderid,
                 'name'           => $name,
                 'pesanan'        => $pesanan,
              ];

              Mail::send('emails.rejectdelivery', $data1, function($m) use ($data1){
                 $m->to($data1['email'], '')->subject('Notis Rejection');
              });
          
           return response()->json(['JobID'=> $JobID,'message' => 'Delivery has been rejected by customer', 'status' => true], 201);

        }
        else
           return response()->json(['message' => 'Fail to proceed a process', 'status' => false], 401);
      }

      public function OrderTrack ($JobID){
          $ordertrack = DB:: table('jobstatuses')
                  ->select ('job_status','created_at')
                  ->where('JobID', $JobID) 
                  -> get();
          return response() -> json(['order_track' => $ordertrack],  200);
      }

}
