<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
      protected $fillable = [
        'WalletID', 'agent_email',  'amount', 'created_at', 'update_at', 
    ];

    public $timestamps = false;
}
