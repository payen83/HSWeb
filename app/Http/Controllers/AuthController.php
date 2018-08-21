<?php

namespace App\Http\Controllers;
use\App\User;
use\App\StoreLocation;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);

    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $email = $request->email;

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token,$email);

        }

        return response()->json(['error' => 'Invalid Username or Password','status' => false], 401);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();
        
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token,$email)
    {
      $userid=User::where('email', '=', $email)->value('id');
      $storeid = DB::table('store_locations')->where('store_userid', '=', $userid)->value('id');
      $data = DB:: table('users')
              -> select ('id','name', 'role','email', 'icnumber', 'u_address', 'lat', 'lng','u_bankname', 'u_accnumber', 'u_phone', 'url_image')
              -> where('id',$userid)
              -> get();
       $store_location = StoreLocation::getStoreData($storeid);
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'status' => true,
            'users' => $data,
            'store_location' => $store_location
        ]);
    }

   
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }
}