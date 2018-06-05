<?php

namespace App\Http\Controllers;

use App\Jobstatus;
use App\Joblist;
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

   		
}
