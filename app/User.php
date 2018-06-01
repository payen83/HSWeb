<?php

namespace App;

use HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status', 'icnumber', 'u_address', 'u_phone', 'role', 'u_rating'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
     
     public static function getList() {
        return User::where('users.status','<>','0')
                         ->get();     
    }

     public static function getSingleData($id) {
        return User::where('users.id',$id)->first();
    }
    
    public static function getListSelect() {
        return User::where('users.status', '=', '1')->pluck('name','id');
    }

     public static function getListSelect2() {
        return User::where('users.role', '=', 'Agent')->pluck('email','id');
    }
}