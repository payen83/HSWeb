<?php

namespace App\Http\Controllers;


use App\Orders;
use App\StoreOrders;
use App\Payment;
use App\Joblist;
use App\Jobstatus;
use App\User;
use App\Transaction;
use App\Wallet;
use App\AgentOrder;
use App\Mail\Invoice;
use Mail;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class APIPurchaseController extends Controller
{
    public function orders(Request $request, $user_id) {
      
     
      $role= DB::table('users')->where('id', '=', $user_id)->value('role');
    	if($role =="Customer"){
            // create order no
           $order_no = Orders::getNextOrderNumber();
           $orders = new Orders;
           $orders->OrderID = $order_no;
           $orders->user_id = $user_id;
           $orders->total_price = Input::get('total_price');
           $orders->save();
       

           // store product
            
            $data = json_decode(Input::get('data'), true);
            //dd($data);
            foreach ($data as $row)
                    {  
                     //dd($row);
                     $store_orders[] = [
                    'OrderID' => $order_no,
                    'ProductID'=>$row['ProductID'],
                    'ProductQuantity'=>$row['ProductQuantity'],
                    'Discount'=>$row['Discount']/100,
                    ];

                    $ProductID = $row['ProductID'];
                    $tagto= DB::table('products')->where('id', '=', $ProductID)->value('tagto');
                    
                    if($tagto == 'MCN'){
                      $merchantid= DB::table('products')->where('id', '=', $ProductID)->value('user_id');
                      $player_id = DB::table('users')->where('id', '=', $merchantid)->value('playerId');

                      $content = array(
                      "en" => 'Yeayy, you have new orders from customer.Please check, thank you'
                      );
                
                      $fields = array(
                          'app_id' => "1d01174b-ba24-429a-87a0-2f1169f1bc84",
                          'include_player_ids' => array($player_id),
                          'data' => array("ProductID" => $ProductID),
                          'contents' => $content
                        );
                        
                      $fields = json_encode($fields);
                          print("\nJSON sent:\n");
                          print($fields);
                          
                      self::sendMessage($content,$fields);
                      }

                    }
                      

            StoreOrders::insert($store_orders);

            if($request->location_address == '' && $request->lat =='' && $request->lng =='' && $request->city == '' && $request->state == '' && $request->postcode == ''){
              $address = DB::table('users')->where('id', '=', $user_id)->value('u_address');
              $state = DB::table('users')->where('id', '=', $user_id)->value('u_state');
              $city = DB::table('users')->where('id', '=', $user_id)->value('u_city');
              $postcode = DB::table('users')->where('id', '=', $user_id)->value('u_postcode'); 
              $lat = DB::table('users')->where('id', '=', $user_id)->value('lat');
              $lng = DB::table('users')->where('id', '=', $user_id)->value('lng');
            }

            else{
              $address = Input::get('location_address');
              $state = Input::get('state');
              $city = Input::get('city');
              $postcode = Input::get('postcode');
              $lat = Input::get('lat');
              $lng = Input::get('lng');
            }

           
           $joblist = new Joblist;
           $joblist->status_job = 'Pending';
           $joblist->OrderID = $order_no;
           $joblist->location_address = $address;
           $joblist->special_notes = Input::get('special_notes');
           $joblist->city = $city;
           $joblist->postcode = $postcode;
           $joblist->state = $state;
           $joblist->Lat = $lat;
           $joblist->Lng = $lng;
           $joblist->orderfrom = 'C';
           $joblist->update_at =Carbon::now('Asia/Kuala_Lumpur');
           $joblist->save();
           Jobstatus::CreateStatusJob();

           $payment = new Payment;
           $payment ->OrderID = $order_no;
           $payment ->payment_method = Input::get('payment_method');
           $payment ->user_id = $user_id;
           $payment ->amount = Input::get('total_price');
           $payment ->currency = Input::get('currency');
           $payment ->payment_date = Input::get('payment_date');
           $payment ->transaction_id = Input::get('transaction_id');
           $payment->save();
        
             $email=User::where('users.id', '=', $user_id)->value('email');
             $name=User::where('users.id', '=', $user_id)->value('name');
             $paymentmethod = Input::get('payment_method') ;
             $order = DB:: table('store_orders')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> select ('products.Name', 'store_orders.ProductQuantity', DB::raw('(store_orders.ProductQuantity*products.Price) as Total_Amount'))
                  ->where('store_orders.OrderID', $order_no)
                  -> get();
            
             $data1 = [
                 'email'          => $email,
                 'name'           => $name,
                 'OrderID'        => $order_no,
                 'payment_date'   => Input::get('payment_date'),
                 'payment_method' => $paymentmethod,
                 'location_address' => $address,
                 'city'             => $city,
                 'state'            => $state,
                 'postcode'         => $postcode,
                 'order'            => $order,
              ];

              Mail::send('emails.invoice', $data1, function($m) use ($data1){
                 $m->to($data1['email'], '')->subject('Invoice');
              });

              if($state == 'Selangor' or $state =='Kuala Lumpur' or $state == 'Putrajaya'){

                $playerid = DB::table('users')
                              ->select('playerId')
                              ->where('role', '=', 'Agent')
                              ->where(function($q) {
                                    $q->where('u_state', '=', 'Selangor')
                                      ->orWhere('u_state', '=', 'Kuala Lumpur')
                                      ->orWhere('u_state', '=', 'Putrajaya');
                                    })
                              ->pluck('playerId');
                $content = array(
                    "en" => 'New Job Request, Please view to accept. Thank You'
                    );
                
                $fields = array(
                      'app_id' => "1d01174b-ba24-429a-87a0-2f1169f1bc84",
                      'include_player_ids' => $playerid,
                      'data' => array("OrderID" => $order_no),
                      'contents' => $content
                    );
                    
                $fields = json_encode($fields);
                      print("\nJSON sent:\n");
                      print($fields);

               self::sendMessage($content,$fields);

              }

              else{
                $playerid = DB::table('users')->select('playerId')->where('u_state', '=', $state)->where('role', '=', 'Agent')->pluck('playerId');

                $content = array(
                    "en" => 'New Job Request, Please view to accept. Thank You'
                    );
                
                $fields = array(
                      'app_id' => "1d01174b-ba24-429a-87a0-2f1169f1bc84",
                      'include_player_ids' => $playerid,
                      'data' => array("OrderID" => $order_no),
                      'contents' => $content
                    );
                    
                $fields = json_encode($fields);
                      print("\nJSON sent:\n");
                      print($fields);

               self::sendMessage($content,$fields);
              }

           return response()->json(['OrderID'=> $order_no,'message' => 'Successful Order', 'status' => true], 201);
    	}

    	else if ($role =="Agent"){

        if($request->payment_method == "PayPal"){
           // create order number
           $order_no = Orders::getNextOrderNumber();
           $orders = new Orders;
           $orders->OrderID = $order_no;
           $orders->user_id = $user_id;
           $orders->total_price = Input::get('total_price');
           $orders->save();
       

         // store product
            
            $data = json_decode(Input::get('data'), true);
            //dd($data);
            foreach ($data as $row)
                    {  
                     //dd($row);
                     $store_orders[] = [
                    'OrderID' => $order_no,
                    'ProductID'=>$row['ProductID'],
                    'ProductQuantity'=>$row['ProductQuantity'],
                    'Discount'=>$row['Discount']/100,
                    ];

           }
            StoreOrders::insert($store_orders);

              if($request->location_address == '' && $request->lat =='' && $request->lng =='' && $request->city == '' && $request->state == '' && $request->postcode == ''){
                    $address = DB::table('users')->where('id', '=', $user_id)->value('u_address');
                    $state = DB::table('users')->where('id', '=', $user_id)->value('u_state');
                    $city = DB::table('users')->where('id', '=', $user_id)->value('u_city');
                    $postcode = DB::table('users')->where('id', '=', $user_id)->value('u_postcode'); 
                    $lat = DB::table('users')->where('id', '=', $user_id)->value('lat');
                    $lng = DB::table('users')->where('id', '=', $user_id)->value('lng');
              }

              else{
                  $address = Input::get('location_address');
                  $state = Input::get('state');
                  $city = Input::get('city');
                  $postcode = Input::get('postcode');
                  $lat = Input::get('lat');
                  $lng = Input::get('lng');
              }

              // $agent = new AgentOrder;
              // $agent->status_order = 'Pending';
              // $agent->order_id = $order_no;
              // $agent->user_id = $user_id;
              // $agent->location_address = $address;
              // $agent->total_price = Input::get('total_price');
              // $agent->special_notes = Input::get('special_notes');
              // $agent->lat = $lat;
              // $agent->lng = $lng;
              // $agent->updated_at =Carbon::now('Asia/Kuala_Lumpur');
              // $agent->save();

              $joblist = new Joblist;
              $joblist->status_job = 'Pending';
              $joblist->OrderID = $order_no;
              $joblist->location_address = $address;
              $joblist->special_notes = Input::get('special_notes');
              $joblist->city = $city;
              $joblist->postcode = $postcode;
              $joblist->state = $state;
              $joblist->Lat = $lat;
              $joblist->Lng = $lng;
              $joblist->orderfrom = 'A';
              $joblist->update_at =Carbon::now('Asia/Kuala_Lumpur');
              $joblist->save();
              Jobstatus::CreateStatusJob();

              $payment = new Payment;
              $payment ->OrderID = $order_no;
              $payment ->payment_method = Input::get('payment_method');
              $payment ->user_id = $user_id;
              $payment ->amount = Input::get('total_price');
              $payment ->currency = Input::get('currency');
              $payment ->payment_date = Input::get('payment_date');
              $payment ->transaction_id = Input::get('transaction_id');
              $payment->save();

             $email=User::where('users.id', '=', $user_id)->value('email');
             $name=User::where('users.id', '=', $user_id)->value('name');
             $paymentmethod = Input::get('payment_method') ;
             $order = DB:: table('store_orders')
                  -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                  -> select ('products.Name', 'store_orders.ProductQuantity', DB::raw('(store_orders.ProductQuantity*products.Price) as Total_Amount'))
                  ->where('store_orders.OrderID', $order_no)
                  -> get();
            
             $data1 = [
                 'email'          => $email,
                 'name'           => $name,
                 'OrderID'        => $order_no,
                 'payment_date'   => Input::get('payment_date'),
                 'payment_method' => $paymentmethod,
                 'location_address' => $address,
                 'city'             => $city,
                 'state'            => $state,
                 'postcode'         => $postcode,
                 'order'            => $order,
              ];

              Mail::send('emails.invoice', $data1, function($m) use ($data1){
                 $m->to($data1['email'], '')->subject('Invoice');
              });
          
            return response()->json(['OrderID'=> $order_no,'message' => 'Successful Order', 'status' => true], 201);
        }

        else if($request->payment_method == "Wallet"){

            $walletID= DB::table('wallets')->where('user_id', '=', $user_id)->value('walletID');
            $wallet_amount = DB::table('wallets')->where('walletID', '=', $walletID)->value('amount');
            $amount=$request->total_price;
            
            if($wallet_amount >= $amount){
                    $wallet = Wallet::find($walletID);
                    $wallet->amount = $wallet_amount - $amount;
                    $wallet->save();

                    $transaction = new Transaction;
                    $transaction->walletID = $walletID;
                    $transaction->user_id = $user_id;
                    $transaction->status = 'Debit';
                    $transaction->message = 'Restock Product';
                    $transaction->amount = $amount;
                    $transaction->save();

                    // create order number
                     $order_no = Orders::getNextOrderNumber();
                     $orders = new Orders;
                     $orders->OrderID = $order_no;
                     $orders->user_id = $user_id;
                     $orders->total_price = Input::get('total_price');
                     $orders->save();
       

                     // store product
                        
                        $data = json_decode(Input::get('data'), true);
                        //dd($data);
                        foreach ($data as $row)
                                {  
                                 //dd($row);
                                 $store_orders[] = [
                                'OrderID' => $order_no,
                                'ProductID'=>$row['ProductID'],
                                'ProductQuantity'=>$row['ProductQuantity'],
                                'Discount'=>$row['Discount']/100,
                                ];

                       }
                        StoreOrders::insert($store_orders);

                        if($request->location_address == '' && $request->lat =='' && $request->lng =='' && $request->city == '' && $request->state == '' && $request->postcode == ''){
                              $address = DB::table('users')->where('id', '=', $user_id)->value('u_address');
                              $state = DB::table('users')->where('id', '=', $user_id)->value('u_state');
                              $city = DB::table('users')->where('id', '=', $user_id)->value('u_city');
                              $postcode = DB::table('users')->where('id', '=', $user_id)->value('u_postcode'); 
                              $lat = DB::table('users')->where('id', '=', $user_id)->value('lat');
                              $lng = DB::table('users')->where('id', '=', $user_id)->value('lng');
                        }

                        else{
                            $address = Input::get('location_address');
                            $state = Input::get('state');
                            $city = Input::get('city');
                            $postcode = Input::get('postcode');
                            $lat = Input::get('lat');
                            $lng = Input::get('lng');
                        }

                            // $agent = new AgentOrder;
                            // $agent->status_order = 'Pending';
                            // $agent->order_id = $order_no;
                            // $agent->user_id = $user_id;
                            // $agent->location_address = $address;
                            // $agent->total_price = Input::get('total_price');
                            // $agent->special_notes = Input::get('special_notes');
                            // $agent->lat = $lat;
                            // $agent->lng = $lng;
                            // $agent->updated_at =Carbon::now('Asia/Kuala_Lumpur');
                            // $agent->save();

                            $joblist = new Joblist;
                            $joblist->status_job = 'Pending';
                            $joblist->OrderID = $order_no;
                            $joblist->location_address = $address;
                            $joblist->city = $city;
                            $joblist->postcode = $postcode;
                            $joblist->state = $state;
                            $joblist->special_notes = Input::get('special_notes');
                            $joblist->Lat = $lat;
                            $joblist->Lng = $lng;
                            $joblist->orderfrom = 'A';
                            $joblist->update_at =Carbon::now('Asia/Kuala_Lumpur');
                            $joblist->save();
                            Jobstatus::CreateStatusJob();

                            $payment = new Payment;
                            $payment ->OrderID = $order_no;
                            $payment ->payment_method = Input::get('payment_method');
                            $payment ->user_id = $user_id;
                            $payment->payment_date = Input::get('payment_date');
                            $payment ->amount = Input::get('total_price');
                            $payment ->currency = Input::get('currency');
                            $payment->save();

                           $email=User::where('users.id', '=', $user_id)->value('email');
                           $name=User::where('users.id', '=', $user_id)->value('name');
                           $paymentmethod = Input::get('payment_method') ;
                           $order = DB:: table('store_orders')
                                -> join ('products', 'products.id', '=', 'store_orders.ProductID')
                                -> select ('products.Name', 'store_orders.ProductQuantity', DB::raw('(store_orders.ProductQuantity*products.Price) as Total_Amount'))
                                ->where('store_orders.OrderID', $order_no)
                                -> get();
                          
                           $data1 = [
                               'email'          => $email,
                               'name'           => $name,
                               'OrderID'        => $order_no,
                               'payment_date'   => Input::get('payment_date'),
                               'payment_method' => $paymentmethod,
                               'location_address' => $address,
                               'city'             => $city,
                               'state'            => $state,
                               'postcode'         => $postcode,
                               'order'            => $order,
                            ];

                            Mail::send('emails.invoice', $data1, function($m) use ($data1){
                               $m->to($data1['email'], '')->subject('Invoice');
                            });
                            return response()->json(['OrderID'=> $order_no,'message' => 'Successful Order', 'status' => true], 201);
              
            }
            else
              return response()->json(['message' => 'Not enough wallet amount to make order', 'status' => false], 401);  

        }

       
   }
   else
   return response()->json(['message' => 'You are not allowed to make order', 'status' => false], 401);
        

    }

    function sendMessage($content,$fields){
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                       'Authorization: Basic NmU4MWZjZDEtNDc5YS00NWMzLTkxMTAtNDNjMjl5ODl3YzBi'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

                $response = curl_exec($ch);
                curl_close($ch);
                
                return $response;
              

              $return["allresponses"] = $response;
              $return = json_encode( $return);
              
              print("\n\nJSON received:\n");
              print($return);
              print("\n");
              
              }

}
