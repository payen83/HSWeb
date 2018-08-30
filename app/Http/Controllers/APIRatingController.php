<?php

namespace App\Http\Controllers;

use\App\Joblist;
use\App\JobRating;
use\App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class APIRatingController extends Controller
{
    public function submitrating(Request $request, $JobID)
    	{
        	$status=Joblist::where('JobID', '=', $JobID)->value('status_job');
        	$userid=Joblist::where('JobID', '=', $JobID)->value('user_id');
        	$role = DB::table('users')->where('id', '=', $userid)->value('role');


        	if($status == 'Completed' && $userid != '' && $role == 'Agent')
        	  {
        	  	   $rate = Joblist::find($JobID);
		           $rate->job_rating = Input::get('rating');
		           $rate->feedback = Input::get('feedback');
		           $rate->save();

        	  	   $rating = new JobRating;
		           $rating->JobID = $JobID;
		           $rating->rating = Input::get('rating');
		           $rating->feedback = Input::get('feedback');
		           $rating->save();
                   
                   $numjob = DB::table('users')->where('id', '=', $userid)->value('count_job');
                   $avgrate = DB::table('users')->where('id', '=', $userid)->value('u_rating');
                   $newrate = Input::get('rating');

		           $agentrate = User::find($userid);
			       $agentrate->u_rating = ($newrate + ($avgrate*$numjob)) / ($numjob +1);
			       $agentrate->count_job = $numjob +1;
			       $agentrate->save();

			       return response()->json(['message' => 'Thank you for you feedback', 'status' => true], 201);

        	  }

        	  else{
        	  	  return response()->json(['message' => 'Fail to proceed a process', 'status' => false], 401);
        	  }
        
   		}
}
