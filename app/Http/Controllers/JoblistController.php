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
                  -> orderBy('joblists.JobID','DESC')
                  -> get();
        return view('joblist.index', compact('joblists'));
    }

    public function viewAgentOrder()
    {

        $agentorder = DB:: table('agent_orders')
                  -> join ('users', 'users.id', '=', 'agent_orders.user_id')
                  -> select ('agent_orders.id', 'users.name', 'agent_orders.order_id', 'agent_orders.status_order' , 'agent_orders.created_at')
                  -> orderBy('agent_orders.id','DESC')
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


    public function viewEditAgentOrder($id)
    {
        
        $data  = DB:: table('agent_orders')
                  -> join ('users', 'users.id', '=', 'agent_orders.user_id')
                  -> select ('agent_orders.id', 'users.name', 'agent_orders.order_id', 'agent_orders.status_order' , 'agent_orders.created_at', 'agent_orders.tracking_number')
                  -> where ('agent_orders.id', $id)
                  -> first();
        return view('joblist.edit', compact('data'));
        
        
    }

    public function editAgentOrder(Request $request) {

        $agentorder = new AgentOrder;
        $agentorder->status_order = Input::get('status_order');
        $agentorder->tracking_number = Input::get('tracking_number');
        $agentorder->save();
        return redirect()->route('viewAgentOrder');
    }

    


}
