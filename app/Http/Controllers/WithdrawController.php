<?php

namespace App\Http\Controllers;

use App\Withdraw;
use App\Wallet;
use App\StoreWithdraw;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use DB;
use Auth;
use Carbon\Carbon;

class WithdrawController extends Controller
{
    	public function viewWithdraw()
    {
        $withdraw = DB:: table('withdraws')
                  -> join ('wallets', 'wallets.walletID', '=', 'withdraws.walletID')
                  -> join ('users', 'users.id', '=', 'withdraws.user_id')
                  -> select ('withdraws.withdrawID','withdraws.created_at', 'users.name','users.email', 'withdraws.amount')
                  ->where('withdraws.status', '=', 1)
                  -> get();
        return view('withdraw.index', compact('withdraw'));
    }

      public function viewWallet()
    {
        $id = Auth::user()->id;
        $wallet = DB:: table('transactions')
                  -> join ('wallets', 'wallets.walletID', '=', 'transactions.walletID')
                  -> join ('users', 'users.id', '=', 'transactions.user_id')
                  -> select ('transactions.created_at','transactions.status','transactions.message','transactions.amount', 'users.name','users.email', 'users.u_address', 'users.u_phone', 'wallets.amount as jumlah')
                  ->where('transactions.user_id', $id)
                  -> get();

        $wallet1 = DB:: table('transactions')
                  -> join ('wallets', 'wallets.walletID', '=', 'transactions.walletID')
                  -> join ('users', 'users.id', '=', 'transactions.user_id')
                  -> select ('transactions.created_at','transactions.message','transactions.amount', 'users.name','users.email', 'users.u_address', 'users.u_phone', 'wallets.amount as jumlah')
                  ->where('transactions.user_id', $id)
                  ->groupby('transactions.walletID')
                  -> get();

        return view('wallet.index', [
                    'wallet' => $wallet,
                    'wallet1' => $wallet1
                  ]);
    }

      public function viewWithdrawDetails($withdrawID)
    {
        $withdraw = DB:: table('withdraws')
                  -> join ('wallets', 'wallets.walletID', '=', 'withdraws.walletID')
                  -> join ('users', 'users.id', '=', 'withdraws.user_id')
                  -> select ('withdraws.withdrawID', 'users.name','users.email', 'users.u_bankname','users.u_accnumber','withdraws.created_at', 'withdraws.amount')
                  -> where ('withdraws.withdrawID', $withdrawID)
                  -> get();
        return view('withdraw.view', compact('withdraw'));
    }

    public function viewApproveWithdraw($withdrawID)
    {
        
        $data = DB:: table('withdraws')
                  -> join ('users', 'users.id', '=', 'withdraws.user_id')
                  -> select ('withdraws.withdrawID', 'users.name','users.email', 'users.u_bankname','users.u_accnumber','withdraws.created_at', 'withdraws.amount')
                  -> where ('withdraws.withdrawID', $withdrawID)
                  -> first();
        return view('withdraw.appwithdraw', compact('data'));
        
        
    }

   public function saveWithdrawDetails(Request $request) {
         
         $withdrawID = $request->withdrawID;
         $userid = DB::table('withdraws')->where('withdrawID', '=', $withdrawID)->value('user_id');
         $walletID = DB::table('wallets')->where('user_id', '=', $userid)->value('walletID');

          //upload new images
        if ($request->hasFile('ProofURL'))
        {
        $file = $request->file('ProofURL');
        $filename = $file->getClientOriginalName();
        $path = 'upload/files';
        $file->move($path, $filename);
        }

        else{
            $filename="NULL";
        }

         $storewithdraw = new StoreWithdraw;
         $storewithdraw->withdrawID = Input::get('withdrawID');
         $storewithdraw->ReferenceNumber = Input::get('ReferenceNumber');
         $storewithdraw->TransactionDate = Input::get('TransactionDate');
         $storewithdraw->amount = Input::get('amount');
         $storewithdraw->ProofURL = $filename;
         $storewithdraw->status = 'Approve';
         $storewithdraw->save();

         $wallet = Wallet::find($walletID);
         $wallet->pending_approval =0;
         $wallet->save();
         
         $withdraw = Withdraw::find($withdrawID);
         $withdraw->status=0;
         $withdraw->save();


         $transactions = new Transaction;
         $transactions->walletID = $walletID;
         $transactions->user_id = $userid;
         $transactions->status = 'Withdraw';
         $transactions->message = 'Withdrawal from wallet';
         $transactions->amount = Input::get('amount');
         $transactions->save();

         return redirect()->route('viewWithdraw');

    }

    public function viewRejectWithdraw($withdrawID)
    {
        
        $data = DB:: table('withdraws')
                  -> join ('users', 'users.id', '=', 'withdraws.user_id')
                  -> select ('withdraws.withdrawID', 'users.name','users.email', 'users.u_bankname','users.u_accnumber','withdraws.created_at', 'withdraws.amount')
                  -> where ('withdraws.withdrawID', $withdrawID)
                  -> first();
        return view('withdraw.reject', compact('data'));
        
        
    }

     public function saveRejectWdDetails(Request $request, $withdrawID) {

       
         $storewithdraw = new StoreWithdraw;
         $storewithdraw->withdrawID = Input::get('withdrawID');
         $storewithdraw->RejectReason = Input::get('RejectReason');
         $storewithdraw->amount = Input::get('amount');
         $storewithdraw->status = 'Reject';
         $storewithdraw->created_at =Carbon::now('Asia/Kuala_Lumpur');
         $storewithdraw->save();

         $withdraw = Withdraw::find($withdrawID);
         $withdraw->status=0;
         $withdraw->save();
         
         return redirect()->route('viewWithdraw');

    }

    public function withdrawrequest($amount)
      {
        
         $user_id = Auth::user()->id;
         $wallet_amount = DB::table('wallets')->where('user_id', '=', $user_id)->value('amount');
         $wallet_amount = DB::table('wallets')->where('user_id', '=', $user_id)->value('amount');
         $walletID = DB::table('wallets')->where('user_id', '=', $user_id)->value('walletID');
         
        
        if($wallet_amount >= $amount){
          if ($amount <= 5000){
          $walletid = DB::table('wallets')->where('user_id', '=', $user_id)->value('walletID');
            $withdraw = new Withdraw;
            $withdraw->walletID= $walletid;
            $withdraw->user_id= $user_id;
            $withdraw->amount= $amount;
            $withdraw->save();

            $wallets = Wallet::find($walletid);
            $wallets->amount = $wallet_amount - $amount;
            $wallets->pending_approval = $amount;
            $wallets->save();
            

            return redirect()->route('viewWallet');

         }

         else{
          return response()->json(['message' => 'Cannot Withdraw more than $5000', 'status' => false], 401);
         }

        }

        else
          return response()->json(['message' => 'Not enough amount in your wallet to withdraw', 'status' => false], 401);
         
      }


}
