<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentOrder extends Model
{
    protected $fillable = [
        'id',  'order_id','user_id','total_price','created_at', 'updated_at', 'location_address', 'lat', 'lng','special_notes', 'tracking_number', 'status_order',
    ];

    public $timestamps = false;
}
