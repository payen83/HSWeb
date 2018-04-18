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
        $users = User::getList();
        return view('user.index', compact('users'));
    }

     public function viewAddUser()
    {
        
        return view('user.add');
    }

    public function addUser(Request $request)
    {
         $input = $request->all();
         $data = User::create($input);
         return redirect()->route('viewUser');
    }

    public function viewEditUser($id)
    {
        
        $data = User::getSingleData($id);
        return view('user.edit', compact('data'));
        
        
    }

    public function editUser(Request $request, $id)
    {
        $input = $request->all();

        if (isset($input['delete'])) {
            $input['status'] = '0';
        }

        $update = User::find($id);
        $update->update($input);
         return redirect()->route('viewUser');
    }
}
