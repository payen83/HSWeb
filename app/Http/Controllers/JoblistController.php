<?php

namespace App\Http\Controllers;

use App\Joblist;
use App\Orders;
use App\Jobstatus;
use App\AgentOrder;
use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use App\Wallet;
use App\Transaction;
use App\User;
use App\Mail\Wallet_Credit;
use App\Mail\Reject_Delivery;
use Mail;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JoblistController extends Controller
{
    	public function viewJoblist()
    {

        $joblists = DB:: table('joblists')
                  -> join ('users', 'users.id', '=', 'joblists.user_id')
                  -> select ('joblists.JobID', 'users.name', 'joblists.OrderID', 'joblists.status_job' , 'joblists.update_at')
                  -> where('joblists.orderfrom','C')
                  -> orderBy('joblists.JobID','DESC')
                  -> get();
        return view('joblist.index', compact('joblists'));
    }

      public function viewPendingJoblist()
    {

        $joblists = DB:: table('joblists')
                  -> select ('joblists.JobID', 'joblists.OrderID', 'joblists.status_job' , 'joblists.update_at')
                  -> where('joblists.orderfrom','C')
                  -> where('joblists.status_job','Pending')
                  -> orderBy('joblists.JobID','DESC')
                  -> get();
        return view('joblist.pendingjob', compact('joblists'));
    }

    public function viewAgentOrder()
    {

        $agentorder = DB:: table('joblists')
                  -> join ('orders', 'orders.OrderID', '=', 'joblists.OrderID')
                   -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select ('joblists.JobID', 'users.name', 'users.role', 'joblists.OrderID', 'joblists.status_job' , 'joblists.created_at')
                  ->where(function($q) {
                                    $q->where('joblists.orderfrom', '=', 'A')->where('joblists.status_job', 'Pending')
                                      ->orWhere('joblists.status_job', 'HQ Delivery')->where('joblists.orderfrom', '=', 'C');
                                    })
                  -> orderBy('joblists.JobID','DESC')
                  -> get();
        return view('joblist.viewagentorder', compact('agentorder'));
    }

     public function viewJobDetails($JobID)
    {
        
        $job = DB:: table('joblists')
                  -> join ('jobstatuses' , 'jobstatuses.JobID', '=', 'joblists.JobID')
                  -> select ('jobstatuses.JobID','jobstatuses.job_status' , 'jobstatuses.created_at' , 'joblists.OrderID')
                  -> where ('jobstatuses.JobID', $JobID)
                  -> get();
        return view('joblist.viewjob', compact('job'));
        
        
    }


    public function viewEditAgentOrder($JobID)
    {
        
        $data  = DB:: table('joblists')
                  -> join ('orders', 'orders.OrderID', '=', 'joblists.OrderID')
                   -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select ('joblists.JobID', 'users.name', 'joblists.OrderID', 'joblists.status_job' , 'joblists.update_at', 'joblists.tracking_number')
                  -> where('joblists.orderfrom','A')
                  -> where ('joblists.JobID', $JobID)
                  -> first();
        return view('joblist.edit', compact('data'));
        
        
    }

    public function editAgentOrder(Request $request, $JobID) {

        $joblists = Joblist::find($JobID);
        $joblists->status_job= Input::get('status_job');
        $joblists->tracking_number = Input::get('tracking_number');
        $joblists->save();

        $jobstatuses = new Jobstatus;
        $jobstatuses->JobID= $JobID;
        $jobstatuses->job_status= Input::get('status_job');
        $jobstatuses->save();
        return redirect()->route('viewAgentOrder');
    }

    public function listpendingjob()
    {
          $user_id = Auth::user()->id;
          $result = DB:: table('joblists')
                  -> join ('orders', 'orders.OrderID', '=', 'joblists.OrderID')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select ('joblists.JobID','joblists.status_job', 'users.name', 'joblists.location_address', 'joblists.Lat', 'joblists.Lng', 'joblists.special_notes', 'orders.total_price','joblists.OrderID','store_orders.ProductID','products.Name', 'joblists.created_at', 'store_orders.ProductQuantity', DB::raw('sum(store_orders.ProductQuantity*products.Price) as sumprice'))
                  -> where('joblists.status_job','Pending')
                  -> where('products.tagto','MCN')
                  -> where('products.user_id', $user_id)
                  ->groupby('joblists.OrderID')
                  ->get();

           
                     return view('joblist.mcviewjob', [
                                  'result' => $result
                                  
                                ]);
    }


    public function MerchantOrderDetails($OrderID)
      {

         $orders = DB:: table('orders')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select ('users.name','users.u_address','users.u_phone','users.email','orders.OrderID', 'store_orders.ProductID', 'products.Name' ,'store_orders.ProductQuantity', 'products.Price', DB::raw('orders.*,(store_orders.ProductQuantity*products.Price) as Total_Amount'))
                  -> where ('orders.OrderID', $OrderID)
                  -> get();

         $orders1 = DB:: table('orders')
                  -> join ('store_orders', 'store_orders.OrderID', '=', 'orders.OrderID')
                  -> join ('joblists', 'joblists.OrderID', '=', 'orders.OrderID')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select ('users.name','joblists.location_address','joblists.Lat','joblists.Lng', 'joblists.special_notes', 'users.u_phone','users.email','orders.OrderID', 'store_orders.ProductID', 'products.Name' ,'store_orders.ProductQuantity', 'products.Price', DB::raw('orders.*,(store_orders.ProductQuantity*products.Price) as Total_Amount'))
                  -> where ('orders.OrderID', $OrderID)
                  ->groupby('orders.OrderID')
                  -> get();
          

        return view('joblist.vmc_orders', [
                    'orders' => $orders,
                    'orders1' => $orders1
                  ]);
    }


    public function viewEditStatusJob($JobID)
    {
        
        $data  = DB:: table('joblists')
                  -> join ('orders', 'orders.OrderID', '=', 'joblists.OrderID')
                   -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select ('joblists.JobID', 'users.name', 'joblists.OrderID', 'joblists.status_job' , 'joblists.update_at', 'joblists.tracking_number')
                  -> where ('joblists.JobID', $JobID)
                  -> first();
        return view('joblist.mcedit', compact('data'));
        
        
    }

    public function editStatusOrder(Request $request, $JobID) {

        if ($request->delivery_method == 'POS'){
        $orderid = DB::table('joblists')->where('JobID', '=', $JobID)->value('OrderID'); 
        $jobstatus = DB::table('joblists')->where('JobID', '=', $JobID)->value('status_job');
        $userid = Auth::user()->id;
        if($jobstatus == 'Pending')
        {
            $jobstatuses = new Jobstatus;
            $jobstatuses->JobID = $JobID;
            $jobstatuses->job_status = 'Completed';
            $jobstatuses->save();

            $joblists = Joblist::find($JobID);
            $joblists->user_id = $userid;
            $joblists->status_job=Input::get('status_job');
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
            
             return redirect()->route('listpendingjob');

          }
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
                  $joblists->status_job=Input::get('status_job');
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
                  
                   return redirect()->route('listpendingjob');

                }
                else
                  return response()->json(['message' => 'Fail to proceed a process', 'status' => false], 401);
        }//end else if
        
      
    }

    


}
