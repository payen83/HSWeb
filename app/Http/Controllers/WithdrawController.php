<?php

namespace App\Http\Controllers;

use App\Withdraw;
use App\Wallet;
use App\StoreWithdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use DB;

class WithdrawController extends Controller
{
    	public function viewWithdraw()
    {
       
        //$joblists = Joblist::all();
        //return view('joblist.index', compact('joblists'));

        $withdraw = DB:: table('withdraws')
                  -> join ('wallets', 'wallets.walletID', '=', 'withdraws.walletID')
                  -> join ('users', 'users.id', '=', 'withdraws.user_id')
                  -> select ('withdraws.withdrawID','withdraws.created_at', 'users.name','users.email', 'withdraws.amount')
                  -> get();
        return view('withdraw.index', compact('withdraw'));
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
         $wallet_amount = DB::table('wallets')->where('user_id', '=', $userid)->value('amount');
         $walletID = DB::table('wallets')->where('user_id', '=', $userid)->value('walletID');
         $withdraw_amount = DB::table('withdraws')->where('withdrawID', '=', $withdrawID)->value('amount');
         
         $newamount= $wallet_amount - $withdraw_amount;
         $file = $request->file('ProofURL');
         $filename = $file->getClientOriginalName();

         $path = 'upload/files';
         $file->move($path, $filename);
         $storewithdraw = new StoreWithdraw;
         $storewithdraw->withdrawID = Input::get('withdrawID');
         $storewithdraw->ReferenceNumber = Input::get('ReferenceNumber');
         $storewithdraw->TransactionDate = Input::get('TransactionDate');
         $storewithdraw->amount = Input::get('amount');
         $storewithdraw->ProofURL = $filename;
         $storewithdraw->status = 'Approve';
         $storewithdraw->save();

         $wallet = Wallet::find($walletID);
         $wallet->amount = $newamount;
         $wallet->save();
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

     public function saveRejectWdDetails(Request $request) {

        
         $storewithdraw = new StoreWithdraw;
         $storewithdraw->withdrawID = Input::get('withdrawID');
         $storewithdraw->ReasonReject = Input::get('ReasonReject');
         $storewithdraw->amount = Input::get('amount');
         $storewithdraw->status = 'Reject';
         $storewithdraw->save();
         return redirect()->route('viewWithdraw');

    }


}
