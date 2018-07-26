<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

   

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('/login');
    }

    public function login(Request $request){
        if($request->isMethod('POST')){
            $data= $request->input();
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']]))
                {
                     if (Auth::user()->role == 'SuperAdmin')
                        {
                            return redirect('/dashboard-superadmin');
                            
                        }
                    else if (Auth::user()->role == 'Admin')
                        {
                            return redirect('/dashboard-admin');
                        }
            
                    else
                        return redirect('error');
       
                }
            else
            {
                 return redirect('/login')->with('flash_message_error', 'Invalid Email or Password');
            }

            return view('auth.login');
        }
    }
}
