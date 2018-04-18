<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
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
        'password', 'remember_token',
    ];
     
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
}