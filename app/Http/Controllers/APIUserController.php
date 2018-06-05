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
use Illuminate\Support\Facades\Storage;

class APIUserController extends Controller
{

	 public function viewProfile($id)
    {
        
        $data = User::getSingleData($id);
        return response() -> json(['data' => $data], 200);
        
        
    }

    public function UserProfile(Request $request, $id) {
         
        $input = $request->all();
        $update = User::find($id);
        $update->update($input);
        return response()->json(['message' => 'Your Profile has been update', 'status' => true], 201);
    }

    public function ChangePassword(Request $request, $id){
        $user = User::find($id);
         if (Input::get('password') != '')
            $user->password = bcrypt(Input::get('password'));
            $user->save();
            return response()->json(['message' => 'Password has been change', 'status' => true], 201);
    }

    public function UserImage (Request $request, $id){

        if($request != ''){
        $user = User::find($id);
        //upload new images
        if ($request->hasFile('url_image'))
        {
        $file = $request->file('url_image');
        $filename = time() . str_random(5) . '_' . $user->id . '.' . $file->getClientOriginalExtension();
        $path = 'upload/userpic';
        $file->move($path, $filename);
        $oldFilename = $user->url_image;

        //delete oldpicture
        Storage::disk('public')->delete("upload/userpic/$oldFilename");
        }

        else{
            $filename=$user->url_image;
        }

        $user->url_image = $filename;
        $user->save();
        return response()->json(['message' => 'Image has been update', 'status' => true], 201);
        }

        else
          return response()->json(['message' => 'Failed to update Image', 'status' => false], 401);

    }

    public function BankDetails (Request $request, $id){
        $user = User::find($id);
        $user->u_bankname = Input::get('u_bankname');
        $user->u_accnumber = Input::get('u_accnumber');
        $user->save();
        return response()->json(['message' => 'Bank Details has been update', 'status' => true], 201);
    }

}
