<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')
    ->get('/user', function (Request $request) {
        return $request->user();
    });

//Authentication 
    Route::post('auth/register', 'Auth\RegisterController@create');
    Route::post('auth/login', 'Auth\LoginController@logs');
    Route::post('auth/logout', 'Auth\LoginController@out');
    Route::post('forgot/password', 'Auth\ForgotPasswordController');


//Product
    Route::get('ProductCustomer', 'APIProductController@ProductCustomer');
    Route::get('ProductAgent', 'APIProductController@ProductAgent');
    Route::get('ProductInventory', 'APIProductController@ProductInventory');


//Profile
    Route::get('viewProfile/{id}', 'APIUserController@viewProfile');
    Route::post('UpdateProfile/{id}', 'APIUserController@UpdateProfile');
    



