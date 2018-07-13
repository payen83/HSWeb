<?php

namespace App;

use\App\Withdraw;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{    
	 protected $primaryKey = 'withdrawID';
     protected $fillable = [
        'withdrawID', 'user_id', 'walletID', 'amount', 'created_at', 'update_at', 'status'
    ];

    public $timestamps = false;

    public static function getSingleData($withdrawID) {
        return Withdraw::where('withdraws.withdrawID',$withdrawID)->first();
    }
}
