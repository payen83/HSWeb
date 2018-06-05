<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Joblist extends Model
{
	protected $primaryKey = 'JobID';
    protected $fillable = [
        'JobID',  'OrderID', 'agent_email', 'total_price', 'cancelcount', 'created_at', 'update_at', 'location_address', 'LatLang', 'currency', 'job_rating', 'status_job',
    ];

    public $timestamps = false;

    public static function getSingleData($JobID) {
        return Joblist::where('joblists.JobID',$JobID)->first();
    }
}
