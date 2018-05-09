<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
     protected $fillable = [
         'id', 'product_id', 'agent_email', 'quantity','user_id'
    ];

    public $timestamps = false;

     public static function getSingleData($id) {
        return Inventory::where('inventories.id',$id)->first();
    }
}
