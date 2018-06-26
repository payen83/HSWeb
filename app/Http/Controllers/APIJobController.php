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
          $data = DB:: table('joblists')
                  -> join ('orders', 'orders.OrderID', '=', 'joblists.OrderID')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> join ('store_orders', 'store_orders.OrderID','=','orders.OrderID' )
                  -> join ('products', 'products.id','=','store_orders.ProductID' )
                  -> select ('orders.OrderID', 'users.name', 'users.u_address', 'products.Name','store_orders.ProductID','store_orders.ProductQuantity')
                  -> where('joblists.status_job','Pending')
                  ->orderby('joblists.OrderID')
                  //->groupBy('joblists.JobID')
                  -> get(); 
        	return response() -> json(['data' => $data],  200);
        
   		}

        public function ActiveJob()
      {
          
          $joblists = DB:: table('joblists')
                  -> select ('JobID', 'status_job')
                  -> where('status_job','Active')
                  -> get();
          return response() -> json(['joblists' => $joblists],  200);
        
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
           if($request->job_status == 'Completed'){
              $jobstatuses = new Jobstatus;
              $jobstatuses->JobID= $JobID;
              $jobstatuses->job_status= 'Completed';
              $jobstatuses->save();
              $joblists = Joblist::find($JobID);
              $joblists->status_job='Completed';
              $joblists->save();

              return response()->json(['JobID'=> $JobID,'message' => 'Job has been Completed', 'status' => true], 201);

              }
        }

      

      public function ViewOrderStatus($user_id){
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
        if($request->job_status=='Cancel'){
          $jobstatuses = new Jobstatus;
          $jobstatuses->JobID = $JobID;
          $jobstatuses->job_status = 'Cancel';
          $jobstatuses->message = Input::get('message');
          $jobstatuses->save();
          
          $cancelcount=0;
          $joblists = Joblist::find($JobID);
          $joblists->status_job='Cancel';
          $joblists->cancelcount = $cancelcount+1;
          $joblists->save();

          $ordernumber=Joblist::where('JobID', '=', $JobID)->value('OrderID');
          $joblist = new Joblist;
          $joblist->status_job = 'Cancel';
          $joblist->OrderID = $ordernumber;
          $joblist->save();
          Jobstatus::CreateStatusJobHQ();

          return response()->json(['JobID'=> $JobID,'message' => 'Job has been Cancel and deliverd to HQ', 'status' => true], 201);
        }
      }

      public function AcceptDelivery (Request $request, $JobID){
        if($request->job_status=='Completed' or $request->job_status=='completed')
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
          
           return response()->json(['JobID'=> $JobID,'message' => 'Job has Accepted and Amount has been credited in your wallet, Check email for more details', 'status' => true], 201);

        }
      }

      public function RejectDelivery (Request $request, $JobID){
        if($request->job_status=='Reject' or $request->job_status=='reject')
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
      }

   		
}
