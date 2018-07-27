<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class UserController extends Controller
{

    use RegistersUsers;
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }
	public function viewUser()
    {
         $users = User::all();
         return view('user.index', compact('users'));
    }

    public function viewUserAdmin()
    {
        $users = User::where('users.role', '!=', 'SuperAdmin')
                     ->get();     
        return view('user.index', compact('users'));
    }

     public function viewAddUserSuperAdmin()
    {
        
        return view('user.add');
    }

    public function viewAddUserAdmin()
    {
        
        return view('user.add-admin');
    }

    public function addUser(Request $request)
    {
     
         $data = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'role' => $request['role'],
            'status' => $request['status']? 1 : 0,
            ]);
        
         return redirect()->route('viewUser');

    
      
    }

    public function viewEditUser($id)
    {
        
        $data = User::getSingleData($id);
        return view('user.edit', compact('data'));
        
        
    }

   public function editUser(Request $request, $id) {

        
        $user = User::find($id);
        if (Input::get('password') != '')
            $user->password = bcrypt(Input::get('password'));
        $user->role = Input::get('role');
        $user->status = Input::get('status')? 1 : 0;
        $user->name = Input::get('name');
        $user->email = Input::get('email');
        $user->icnumber = Input::get('icnumber');
        $user->u_address = Input::get('u_address');
        $user->u_phone = Input::get('u_phone');
        $user->save();
        return redirect()->route('viewUser');
    }

  
   

     public function deleteuser_superadmin($id)
    {
        User::destroy($id);
        return redirect('/user/viewlist-superadmin');
    }

    public function deleteuser_admin($id)
    {
        User::destroy($id);
        return redirect('/user/viewlist-admin');
    }

    
}
