<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'id','Name', 'Price', 'Description', 'Currency', 'ImageURL', 'QuantityPerPackage', 'Discount'
    ];

    public $timestamps = false;



     public static function getSingleData($id) {
        return Product::where('products.id',$id)->first();
    }
    
    
}
