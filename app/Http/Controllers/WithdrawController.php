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

        $withdraw = DB:: table('withdraw')
                  -> join ('wallet', 'wallet.walletID', '=', 'withdraw.walletID')
                  -> join ('users', 'users.id', '=', 'withdraw.user_id')
                  -> select ('withdraw.withdrawID','withdraw.created_at', 'users.name','users.email', 'withdraw.amount')
                  -> get();
        return view('withdraw.index', compact('withdraw'));
    }

      public function viewWithdrawDetails($withdrawID)
    {
        $withdraw = DB:: table('withdraw')
                  -> join ('wallet', 'wallet.walletID', '=', 'withdraw.walletID')
                  -> join ('users', 'users.id', '=', 'withdraw.user_id')
                  -> select ('withdraw.withdrawID', 'users.name','users.email', 'users.u_bankname','users.u_accnumber','withdraw.created_at', 'withdraw.amount')
                  -> where ('withdraw.withdrawID', $withdrawID)
                  -> get();
        return view('withdraw.view', compact('withdraw'));
    }

    public function viewApproveWithdraw($withdrawID)
    {
        
        $data = DB:: table('withdraw')
                  -> join ('users', 'users.id', '=', 'withdraw.user_id')
                  -> select ('withdraw.withdrawID', 'users.name','users.email', 'users.u_bankname','users.u_accnumber','withdraw.created_at', 'withdraw.amount')
                  -> where ('withdraw.withdrawID', $withdrawID)
                  -> first();
        return view('withdraw.appwithdraw', compact('data'));
        
        
    }

   public function saveWithdrawDetails(Request $request) {

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
         $storewithdraw->save();
         return redirect()->route('viewWithdraw');

    }


}
