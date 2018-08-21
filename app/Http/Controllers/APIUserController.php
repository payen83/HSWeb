<?php

namespace App\Http\Controllers;

use App\User;
use App\StoreLocation;
use DB;
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
        $storeid = DB::table('store_locations')->where('store_userid', '=', $id)->value('id');
        $role = DB::table('users')->where('id', '=', $id)->value('role');

        if($role == 'Agent' or $role == 'Merchant')
        {
            $user = DB:: table('users')
                  -> select ('id', 'playerId', 'name','email', 'icnumber', 'u_address', 'u_city', 'u_postcode', 'u_state', 'lat', 'lng', 'url_image', 'u_bankname', 'u_accnumber', 'u_phone', 'role')
                  ->where('id', $id)
                  -> get();

            $store_location = StoreLocation::getStoreData($storeid);
            $array = [];
            foreach($user as $data){       
                        $array[] = [
                                      'id'=> $data->id,
                                      'playerId'=> $data->playerId,
                                      'name' => $data->name,
                                      'email' => $data->email,
                                      'icnumber' => $data->icnumber,
                                      'u_address' => $data->u_address,
                                      'u_city' => $data->u_city,
                                      'u_postcode' => $data->u_postcode,
                                      'u_state' => $data->u_state,
                                      'lat' => $data->lat,
                                      'lng' => $data->lng,
                                      'url_image' => $data->url_image,
                                      'u_bankname' => $data->u_bankname,
                                      'u_accnumber' => $data->u_accnumber,
                                      'u_phone' => $data->u_phone,
                                      'role' => $data->role,
                                      'store_location' => $store_location
                                    ];
                        
                        }
            return response() -> json($array);
        }

        else{
            $data = User::getSingleData($id);
            return response() -> json(['data' => $data], 200);
        }
        
        
        
        
    }

    public function UserProfile(Request $request, $id) {

        $storeid = DB::table('store_locations')->where('store_userid', '=', $id)->value('id');
        $role = DB::table('users')->where('id', '=', $id)->value('role');
        
        if($request->u_phone=='')
        {
            $phone = DB::table('users')->where('id', '=', $id)->value('u_phone');
        }

        else{
            $phone = Input::get('u_phone');
        }

        $input = $request->all();
        
        $user = User::find($id);
        $user->update($input);
        $user->save();
        
        if($role == 'Agent' or $role == 'Merchant'){
                if($request->availability == 'true')
                {
                    if (!$storeid == null){
                        $store = StoreLocation::find($storeid);
                        $store->store_address = Input::get('store_address');
                        $store->store_city = Input::get('store_city');
                        $store->store_postcode = Input::get('store_postcode');
                        $store->store_state = Input::get('store_state');
                        $store->store_userid = $id;
                        $store->store_agentphone = $phone;
                        $store->save();
                    }

                    else{
                        $store = new StoreLocation;
                        $store->store_address = Input::get('store_address');
                        $store->store_city = Input::get('store_city');
                        $store->store_postcode = Input::get('store_postcode');
                        $store->store_state = Input::get('store_state');
                        $store->store_userid = $id;
                        $store->store_agentphone = $phone;
                        $store->save();
                    }

                    
                } //end if

                else if ($request->availability == 'false')
                  {
                     if (!$storeid == null){
                        StoreLocation::destroy($storeid);
                        return response()->json(['message' => 'Store location has been deleted', 'status' => true], 201);
                     }
                    
                     else{
                        return response()->json(['message' => 'Store location data not found', 'status' => false], 401);
                     }
                  } //end else if
        } //end if

        else{
            return response()->json(['message' => 'This application are for authorized person', 'status' => false], 401);
        }

        return response()->json(['message' => 'Your Profile has been updated', 'status' => true], 201);
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

    public function SavePalyerId(Request $request, $id) {
        
        if ($request->playerId != ''){
            $user = User::find($id);
            $user->playerId = Input::get('playerId');
            $user->save();
            return response()->json(['message' => 'Player Id has been saved', 'status' => true], 201);
        }

        else
           return response()->json(['message' => 'Failed to saved Player Id', 'status' => false], 401); 
       
    }

    public function ListStoreLocation()
    {
        $details = DB:: table('store_locations')
                  -> join ('users', 'users.id', '=', 'store_locations.store_userid')
                  -> select ('store_locations.id','users.name','users.email', 'store_locations.store_agentphone','store_locations.store_address', 'store_locations.store_city', 'store_locations.store_postcode', 'store_locations.store_state')
                  ->orderby('store_locations.id')
                  ->get();
        
        return response() -> json($details);
       
    }

}
