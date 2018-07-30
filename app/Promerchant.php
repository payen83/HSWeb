<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promerchant extends Model
{
    protected $fillable = [
        'pro_merchant_id', 'user_id', 'product_id', 'created_at', 'updated_at'
    ];

    public $timestamps = false;
}
