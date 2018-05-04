<?php

namespace App\Http\Controllers;

use App\Joblist;
use App\Orders;
use App\Jobstatus;
use Illuminate\Http\Request;
use DB;

class JoblistController extends Controller
{
    	public function viewJoblist()
    {

        $joblists = DB:: table('joblists')
                  -> join ('orders', 'joblists.OrderID', '=', 'orders.OrderID')
                  -> join ('jobstatus', 'joblists.JobID', '=', 'jobstatus.JobID')
                  -> select ('joblists.JobID', 'joblists.agent_email', 'orders.OrderID', 'joblists.total_price', 'jobstatus.job_status' , 'jobstatus.created_at')
                  -> get();
        return view('joblist.index', compact('joblists'));
    }


    public function viewEditJoblist($JobID)
    {
        
        $joblists = DB:: table('joblists')
                  -> join ('orders', 'joblists.OrderID', '=', 'orders.OrderID')
                  -> join ('jobstatus', 'joblists.JobID', '=', 'jobstatus.JobID')
                  -> select ('joblists.JobID', 'joblists.agent_email', 'orders.OrderID', 'joblists.total_price', 'jobstatus.job_status' , 'jobstatus.created_at')
                  -> where ('joblists.JobID', $JobID)
                  -> first();
        return view('joblist.edit', compact('joblists'));
        
        
    }

    public function editJoblist(Request $request, $JobStatusID) {

        $joblists = Jobstatus::find($JobStatusID);
        $joblists->role = Input::get('job_status');
        $joblists->save();
        return redirect()->route('viewEditJoblist');
    }

    


}
