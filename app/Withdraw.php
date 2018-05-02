<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
     protected $fillable = [
        'WithdrawID',  'walletID', 'amount', 'created_at', 'update_at', 
    ];

    public $timestamps = false;
}
