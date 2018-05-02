<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreOrders extends Model
{
     protected $fillable = [
        'StoreOrderID', 'ProductID', 'OrderID', 'ProductQuantity', 'Created_at', 'Update_at',  
    ];

    public $timestamps = false;
}
