<?php

namespace App\Http\Controllers;


use App\Orders;
use App\StoreOrders;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class APIPurchaseController extends Controller
{
    public function checkout(Request $request) {
     
    //create orders number 
       $order_no = Orders::getNextOrderNumber();

        $orders = new Orders;
        $orders->OrderID = $order_no;
        $orders->user_id = Input::get('user_id');
        $orders->total_price = Input::get('total_price');
        $orders->save();
        return response() -> json(['orders' => $orders], 200);
    }

     public function reconfirmorder(Request $request){
        $store_orders = new StoreOrders;
        $store_orders ->OrderID = Input::get('OrderID');
        $store_orders ->ProductID = Input::get('ProductID');
        $store_orders ->ProductQuantity = Input::get('ProductQuantity');
        $store_orders ->Discount = Input::get('Discount')/100;
        $store_orders->save();
        return response() -> json(['store_orders' => $store_orders], 200);

    }

     public function payment(Request $request){
        $payment = new StoreOrders;
        $payment ->OrderID = Input::get('OrderID');
        $payment ->payment_method = Input::get('payment_method');
        $payment ->user_id = Input::get('user_id');
        $payment ->amount = Input::get('amount');
        $payment ->currency = Input::get('currency');
        $payment->save();
        return response() -> json(['payment' => $payment], 200);

    }
}
