<?php

namespace App\Http\Controllers;

use App\Joblist;
use App\Orders;
use App\Jobstatus;
use App\AgentOrder;
use Illuminate\Http\Request;
use DB;
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

    public function viewAgentOrder()
    {

        $agentorder = DB:: table('joblists')
                  -> join ('orders', 'orders.OrderID', '=', 'joblists.OrderID')
                   -> join ('users', 'users.id', '=', 'orders.user_id')
                  -> select ('joblists.JobID', 'users.name', 'joblists.OrderID', 'joblists.status_job' , 'joblists.update_at')
                  -> where('joblists.orderfrom','A')
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
        $joblist->save();

        $jobstatuses = new Jobstatus;
        $jobstatuses->JobID= $JobID;
        $jobstatuses->job_status= Input::get('status_job');
        $jobstatuses->save();
        return redirect()->route('viewAgentOrder');
    }

    


}
