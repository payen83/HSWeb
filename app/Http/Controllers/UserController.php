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

class UserController extends Controller
{
	public function viewUser()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

     public function viewAddUser()
    {
        
        return view('user.add');
    }

    public function addUser()
    {
     
         $user = new User;

         $user->name = Input::get('name');
         $user->email = Input::get('email');
         $user->password = bcrypt(Input::get('password'));
         $user->role = Input::get('role');
         $user->status = Input::get('status') ? 1 : 0;
         $user->save();
         return redirect()->route('viewUser');

    
      
    }

    public function viewEditUser($id)
    {
        
        $data = User::getSingleData($id);
        return view('user.edit', compact('data'));
        
        
    }

   public function editUser(Request $request, $id) {

        if (isset($request['delete'])) {
            User::destroy($id);
        }


        if ($request->isMethod('get'))
        return view('user.edit', ['user' => User::find($id)]);
        
        $user = User::find($id);
        $user->name = Input::get('name');
        $user->email = Input::get('email');
        if (Input::get('password') != '')
            $user->password = bcrypt(Input::get('password'));
        $user->role = Input::get('role');
        $user->status = Input::get('status')? 1 : 0;
        $user->save();
        return redirect()->route('viewUser');
    }

     // public function deleteUser($id)
    //{
        //User::destroy($id);
        //DB::table('users')->where('id', $id)->delete();
        //return redirect()->route('viewUser');

    //}

     public function delete($id)
    {
        User::destroy($id);
        return redirect('user');
    }

    
}
