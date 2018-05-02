<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'ID', 'OrderID', 'payment_date', 'customer_email', 'amount', 'payment_gateway', 'currency', 'update_at',  
    ];

     public $timestamps = false;
}
