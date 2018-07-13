<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;

class APIDashboardController extends Controller
{

    public function viewdashboard($user_id) {
    	$carbon = Carbon::today();
        $currentMonth = $carbon->format('m');

    	$completed_job = DB:: table('joblists')
                  -> select (DB::raw('count(JobID) as numberofcompletedjob'))
                  -> where(DB::raw("month(created_at)"), '=', $currentMonth )
                  ->where('status_job','=','Completed')
                  ->where('user_id', '=', $user_id)
                  -> get();

        $activetask = DB:: table('joblists')
                  -> select (DB::raw('count(JobID) as numberofactivetask'))
                  -> where(DB::raw("month(created_at)"), '=', $currentMonth )
                  ->where('status_job','=','Active')
                  ->where('user_id', '=', $user_id)
                  -> get();

        $totalsales = DB:: table('transactions')
                  -> select (DB::raw('sum(amount) as totalsale'))
                  -> where(DB::raw("month(created_at)"), '=', $currentMonth )
                  ->where('status','=','Credit')
                  ->where('user_id', '=', $user_id)
                  -> get();

         foreach($completed_job as $data){
             $job = $data->numberofcompletedjob;
         }

         foreach( $activetask as $data){
             $task = $data->numberofactivetask;
         }

         foreach($totalsales as $data){
             $sale = $data->totalsale;
         }


    	return response()->json([
    		'status' => true,
        	'completed_job' => $job,
        	'activetask' => $task,
        	'totalsales' => $sale

        ]);

	}
}
