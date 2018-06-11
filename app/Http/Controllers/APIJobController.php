<?php

namespace App\Http\Controllers;

use App\Jobstatus;
use App\Joblist;
use App\Wallet;
use App\Payment;
use App\Mail\WCredit;
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
          
        	$joblists = DB:: table('joblists')
        	      ->join('jobstatuses', 'jobstatuses.JobID', '=', 'joblists.JobID')
                  -> select ('joblists.JobID', 'jobstatuses.job_status')
                  -> where('jobstatuses.job_status','Pending')
                  -> get();
        	return response() -> json(['joblists' => $joblists],  200);
        
   		}

        public function ActiveJob()
      {
          
          $joblists = DB:: table('joblists')
                ->join('jobstatuses', 'jobstatuses.JobID', '=', 'joblists.JobID')
                  -> select ('joblists.JobID', 'jobstatuses.job_status')
                  -> where('jobstatuses.job_status','Active')
                  -> get();
          return response() -> json(['joblists' => $joblists],  200);
        
      }

      public function AcceptJob(Request $request, $JobID){

        if($request->job_status == 'Pending'){
          $jobstatuses = new Jobstatus;
          $jobstatuses->JobID= $JobID;
          $jobstatuses->job_status= 'Active';
          $jobstatuses->save();
          $joblists = Joblist::find($JobID);
          $joblists->user_id = Input::get('user_id');
          $joblists->status_job=1;
          $joblists->save();

          return response()->json(['JobID'=> $JobID,'message' => 'Successful Accept Job', 'status' => true], 201);
          

        }

        else if($request->job_status == 'Active'){
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
              $joblists->status_job=0;
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
          $joblists->status_job=0;
          $joblists->cancelcount = $cancelcount+1;
          $joblists->save();

          $ordernumber=Joblist::where('JobID', '=', $JobID)->pluck('OrderID');
          $joblist = new Joblist;
          $joblist->status_job = 0;
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
          $joblists->status_job=0;
          $joblists->save();
          

          $ordernumber = DB::table('joblists')->where('JobID', '=', $JobID)->value('OrderID');
          $userid = DB::table('joblists')->where('JobID', '=', $JobID)->value('user_id');
          $amount=DB::table('payments')->where('OrderID', '=', $ordernumber)->value('amount');
         
          $wallet = new Wallet;
          $wallet->user_id = $userid;
          $wallet->amount = $amount;
          $wallet->save();

          $email=DB::table('users')->where('users.id', '=', $userid)->value('email');
          Mail::to($email)->send(new WCredit($email));
          
           return response()->json(['JobID'=> $JobID,'message' => 'Job has Accepted and Amount has been creadit in your wallet, Check email for more details', 'status' => true], 201);

        }
      }

   		
}
