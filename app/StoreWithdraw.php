<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreWithdraw extends Model
{
      protected $fillable = [
        'ID', 'WithrawID',  'status', 'ReferenceNumber', 'TransactionDate','ProofURL', 'Update_at', 
    ];

    public $timestamps = false;
}
