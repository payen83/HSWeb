<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
     protected $fillable = [
        'OrderID', 'productID', 'product_quantity',  'total_price', 'created_at', 'update_at',  'job_rating',
    ];

    public $timestamps = false;
}
