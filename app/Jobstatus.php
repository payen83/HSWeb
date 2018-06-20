<?php

namespace App;

use App\Joblist;
use Illuminate\Database\Eloquent\Model;

class Jobstatus extends Model
{
   protected $fillable = [
        'JobStatusID', 'JobID', 'job_status', 'created_at', 'update_at', 
        ]; 

    public $timestamps = false;

    public static function getSingleData($JobStatusID) {
        return Jobstatus::where('jobstatus.JobStatusID',$JobStatusID)->first();
    }

    public static function CreateStatusJob(){
    	     $lastjob = Joblist::orderBy('created_at', 'desc')->first();
           $jobstatus = new Jobstatus;
           $jobstatus->job_status = "Pending";
           $jobstatus->JobID =$lastjob->JobID;
           $jobstatus->save();
    }

    public static function CreateStatusJobHQ(){
           $lastjob = Joblist::orderBy('created_at', 'desc')->first();
           $JobID = $lastjob->JobID;

           $joblists = Joblist::find($JobID);
           $joblists->status_job='HQ Delivery';
           $joblists->user_id = 6;
           $joblists->save();


           $jobstatus = new Jobstatus;
           $jobstatus->job_status = "HQ Delivery";
           $jobstatus->JobID =$lastjob->JobID;
           $jobstatus->save();
    }
}
