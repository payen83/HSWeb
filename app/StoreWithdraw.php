<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreWithdraw extends Model
{
      protected $fillable = [
        'ID', 'WithrawID',  'status', 'ReferenceNumber', 'TransactionDate','ProofURL', 'amount','Update_at', 'RejectReason', 
    ];

    public $timestamps = false;
}
