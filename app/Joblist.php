<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Joblist extends Model
{
    protected $fillable = [
        'JobID',  'OrderID', 'agent_email', 'cancelcount', 'created_at', 'update_at', 'location_address', 'LatLang', 'currency', 'job_rating',
    ];

    public $timestamps = false;
}
