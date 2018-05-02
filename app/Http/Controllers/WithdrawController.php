<?php

namespace App\Http\Controllers;

use App\Withdraw;
use App\Wallet;
use Illuminate\Http\Request;
use DB;

class WithdrawController extends Controller
{
    	public function viewWithdraw()
    {
       
        //$joblists = Joblist::all();
        //return view('joblist.index', compact('joblists'));

        $withdraw = DB:: table('withdraw')
                  -> join ('wallet', 'wallet.walletID', '=', 'withdraw.walletID')
                  -> select ('withdraw.created_at', 'wallet.agent_email', 'withdraw.amount')
                  -> get();
        return view('withdraw.index', compact('withdraw'));
    }

     public static function getSingleData($id) {
        return Wallet::where('wallet.walletID',$id)->first();
    }

}
