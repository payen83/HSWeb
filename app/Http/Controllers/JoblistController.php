<?php

namespace App\Http\Controllers;

use App\Joblist;
use App\Orders;
use App\Jobstatus;
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
                  -> get();
        return view('joblist.index', compact('joblists'));
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


    public function viewEditJoblist($JobID)
    {
        
        $data = DB:: table('joblists')
                  -> join ('orders', 'joblists.OrderID', '=', 'orders.OrderID')
                  -> join ('jobstatuses', 'joblists.JobID', '=', 'jobstatuses.JobID')
                  -> join ('users', 'users.id', '=', 'joblists.user_id')
                  -> select ('joblists.JobID', 'users.email', 'orders.OrderID', 'joblists.total_price', 'jobstatuses.job_status' , 'jobstatuses.created_at')
                  -> where ('joblists.JobID', $JobID)
                  -> first();
        return view('joblist.edit', compact('data'));
        
        
    }

    public function editJoblist(Request $request) {

        $jobstatus = new Jobstatus;
        $jobstatus->JobID = Input::get('JobID');
        $jobstatus->job_status = Input::get('job_status');
        $jobstatus->save();
        return redirect()->route('viewJoblist');
    }

    


}
