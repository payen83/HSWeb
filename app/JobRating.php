<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobRating extends Model
{
    protected $fillable = [
        'id',  'JobID','rating','feedback','created_at', 'updated_at', 
    ];

    public $timestamps = false;
}
