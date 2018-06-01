<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'ID', 'OrderID', 'payment_date', 'user_id', 'amount', 'payment_method', 'currency', 'update_at',  
    ];

     public $timestamps = false;
}
