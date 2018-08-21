<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreLocation extends Model
{
    protected $fillable = [
        'id', 'store_address', 'store_city', 'store_postcode', 'store_state', 'store_agentphone' ,'store_userid', 'created_at', 'updated_at'
    ];

    public $timestamps = false;

    public static function getStoreData($storeid) {
        return StoreLocation::where('store_locations.id',$storeid)->first();
    }
}
