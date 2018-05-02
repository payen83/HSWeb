<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jobstatus extends Model
{
   protected $fillable = [
        'JobStatusID', 'JobID', 'job_status', 'created_at', 'update_at', 
        ]; 

    public $timestamps = false;
}
