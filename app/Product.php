<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'id','Name', 'sku_number', 'Price', 'Description', 'Currency', 'ImageURL', 'QuantityPerPackage', 'Discount'
    ];

    public $timestamps = false;



     public static function getSingleData($id) {
        return Product::where('products.id',$id)->first();
    }

     public static function getNextSKUNumber()
	{
    	// Get the last created order
    	$lastSKU = Product::orderBy('created_at', 'desc')->first();

    	if ( ! $lastSKU )
        	// We get here if there is no order at all
        	// If there is no number set it to 0, which will be 1 at the end.

        	$number = 0;
    	else 
        	$number = substr($lastSKU->sku_number, 3);

    	// If we have ORD000001 in the database then we only want the number
    	// So the substr returns this 000001

    	// Add the string in front and higher up the number.
    	// the %05d part makes sure that there are always 6 numbers in the string.
    	// so it adds the missing zero's when needed.
 
    	return sprintf('%08d', intval($number) + 1);
	}
    
    
}
