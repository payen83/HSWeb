<?php

namespace App\Http\Controllers;

use App\Joblist;
use App\Orders;
use App\jobstatus;
use Illuminate\Http\Request;
use DB;

class JoblistController extends Controller
{
    	public function viewJoblist()
    {
       
        //$joblists = Joblist::all();
        //return view('joblist.index', compact('joblists'));

        $joblists = DB:: table('joblists')
                  -> join ('orders', 'joblists.OrderID', '=', 'orders.OrderID')
                  -> join ('jobstatus', 'joblists.JobID', '=', 'jobstatus.JobID')
                  -> select ('joblists.JobID', 'joblists.agent_email', 'orders.OrderID', 'orders.total_price', 'jobstatus.job_status' , 'jobstatus.created_at')
                  -> get();
        return view('joblist.index', compact('joblists'));
    }


}
