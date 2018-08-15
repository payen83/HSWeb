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
         $wallet_amount = DB::table('wallets')->where('user_id', '=', $user_id)->value('amount');
         $walletID = DB::table('wallets')->where('user_id', '=', $user_id)->value('walletID');
         
        
      	if($wallet_amount >= $request->amount){
      		if ($request->amount <= 5000){
         	$walletid = DB::table('wallets')->where('user_id', '=', $user_id)->value('walletID');
          	$withdraw = new Withdraw;
          	$withdraw->walletID= $walletid;
          	$withdraw->user_id= $user_id;
          	$withdraw->amount= Input::get('amount');
          	$withdraw->save();

            $wallets = Wallet::find($walletid);
            $wallets->amount = $wallet_amount - $request->amount;
            $wallets->pending_approval = Input::get('amount');
            $wallets->save();
            

            return response()->json(['message' => 'Withdraw request has been send', 'status' => true], 201);

         }

         else{
         	return response()->json(['message' => 'Cannot Withdraw more than $5000', 'status' => false], 401);
         }

      	}

      	else
        	return response()->json(['message' => 'Not enough amount in your wallet to withdraw', 'status' => false], 401);
         
      }

      public function History (Request $request, $user_id){
      	 $year = $request->year;
         $role = DB::table('users')->where('id', '=', $user_id)->value('role');
         if($role == 'Agent' or $role == 'Merchant')
         {
            $transactions = DB:: table('transactions')
                  -> join ('users', 'users.id', '=', 'transactions.user_id')
                  -> select ('transactions.walletID' ,'users.name' , 'transactions.status', 'transactions.message', 'transactions.amount', 'transactions.created_at')
                  ->where('transactions.user_id', '=', $user_id)
                  ->where(DB::raw("year(transactions.created_at)"), $year)
                  -> get();
                  return response() -> json(['transactions' => $transactions],  200);
         }

         else
          return response()->json(['message' => 'You cannot get access to this process', 'status' => false], 401);
      	 
      }

      public function balance ($user_id){
         $role = DB::table('users')->where('id', '=', $user_id)->value('role');
         if($role == 'Agent' or $role == 'Merchant'){
            $wallets = DB::table('wallets')
                  -> join ('users', 'users.id', '=', 'wallets.user_id')
                  -> select('users.name', 'users.email','users.u_bankname','users.u_accnumber','wallets.amount', 'wallets.pending_approval')
                  -> where('user_id', '=', $user_id)
                  ->get();
         return response() -> json(['wallets' => $wallets],  200);
         }
      	 
         else
          return response()->json(['message' => 'You cannot get access to this process', 'status' => false], 401);
      }
}
