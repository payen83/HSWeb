<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Joblist extends Model
{
    protected $fillable = [
        'JobID', 'agent_email', 'customer_email', 'total_price', 'cancelcount', 'created_at', 'update_at', 'location_address', 'LatLang', 'currency', 'job_rating',
    ];

    public $timestamps = false;
}
