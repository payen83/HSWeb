<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
     protected $fillable = [
        'OrderID', 'user_id', 'created_at', 'update_at', 'total_price' 
    ];

    public $timestamps = false;

     public static function getSingleData($OrderID) {
        return Orders::where('orders.OrderID',$OrderID)->first();
    }

    public static function getNextOrderNumber()
	{
    	// Get the last created order
    	$lastOrder = Orders::orderBy('created_at', 'desc')->first();

    	if ( ! $lastOrder )
        	// We get here if there is no order at all
        	// If there is no number set it to 0, which will be 1 at the end.

        	$number = 0;
    	else 
        	$number = substr($lastOrder->OrderID, 3);

    	// If we have ORD000001 in the database then we only want the number
    	// So the substr returns this 000001

    	// Add the string in front and higher up the number.
    	// the %05d part makes sure that there are always 6 numbers in the string.
    	// so it adds the missing zero's when needed.
 
    	return 'ORD' . sprintf('%06d', intval($number) + 1);
	}


    
}
