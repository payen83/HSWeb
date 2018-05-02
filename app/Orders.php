<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
     protected $fillable = [
        'OrderID', 'customer_email', 'created_at', 'update_at',  
    ];

    public $timestamps = false;

     public static function getSingleData($OrderID) {
        return Orders::where('orders.OrderID',$OrderID)->first();
    }


    
}
