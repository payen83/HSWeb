<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
	  protected $primaryKey = 'walletID';
      protected $fillable = [
        'walletID', 'agent_email',  'amount', 'created_at', 'update_at', 'pending_approval'
    ];

    public $timestamps = false;
}
