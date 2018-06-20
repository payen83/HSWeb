<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
     protected $fillable = [
        'id', 'walletID', 'user_id', 'amount','created_at', 'updated_at', 
    ];

    public $timestamps = false;
}
