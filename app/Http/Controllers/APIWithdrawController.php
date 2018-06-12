<?php

namespace App\Http\Controllers;

use App\Withdraw;
use App\Wallet;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class APIWithdrawController extends Controller
{
    public function WithdrawRequest(Request $request, $user_id)
      {
      	$wallet_amount = DB::table('wallets')->where('user_id', '=', $user_id)->value('amount');
      	if($wallet_amount >= $request->amount){
      		if ($request->amount < 5000){
         	$walletid = DB::table('wallets')->where('user_id', '=', $user_id)->value('walletID');
          	$withdraw = new Withdraw;
          	$withdraw->walletID= $walletid;
          	$withdraw->user_id= $user_id;
          	$withdraw->amount= Input::get('amount');
          	$withdraw->save();
            

            return response()->json(['message' => 'Withdraw request has been send', 'status' => true], 201);

         }

         else{
         	return response()->json(['message' => 'Cannot Withdraw more than $5000', 'status' => false], 401);
         }

      	}

      	else
        	return response()->json(['message' => 'Not enough amount in your wallet to withdraw', 'status' => false], 401);
         
      }
}
