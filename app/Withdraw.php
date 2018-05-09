<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
     protected $fillable = [
        'WithdrawID', 'user_id', 'walletID', 'amount', 'created_at', 'update_at', 
    ];

    public $timestamps = false;

    public static function getSingleData($withdrawID) {
        return Orders::where('withdraw.WithdrawID',$withdrawID)->first();
    }
}
