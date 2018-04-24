<?php

namespace App\Http\Controllers;

use App\Joblist;
use Illuminate\Http\Request;

class JoblistController extends Controller
{
    	public function viewJoblist()
    {
       
        $joblists = Joblist::all();
        return view('joblist.index', compact('joblists'));
    }
}
