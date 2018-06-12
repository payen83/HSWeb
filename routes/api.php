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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    
    Route::post('register', 'Auth\RegisterController@create');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('forgot/password', 'Auth\ForgotPasswordController');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'products'

], function ($router) {

    Route::get('productcustomer', 'APIProductController@ProductCustomer');
    Route::get('productagent', 'APIProductController@ProductAgent');
    Route::get('productinventory', 'APIProductController@ProductInventory');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'users'

], function ($router) {

    Route::get('viewProfile/{id}', 'APIUserController@viewProfile');
    Route::post('UserProfile/{id}', 'APIUserController@UserProfile');
    Route::post('UserProfile/{id}', 'APIUserController@UserProfile');
    Route::post('ChangePassword/{id}', 'APIUserController@ChangePassword');
    Route::post('UserImage/{id}', 'APIUserController@UserImage');
    Route::post('BankDetails/{id}', 'APIUserController@BankDetails');
    
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'purchase'

], function ($router) {

    Route::post('orders', 'APIPurchaseController@orders');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'job'

], function ($router) {

    Route::get('PendingJob', 'APIJobController@PendingJob');
    Route::get('ActiveJob', 'APIJobController@ActiveJob');
    Route::post('AcceptJob/{JobID}', 'APIJobController@AcceptJob');
    Route::post('UpdateJob/{JobID}', 'APIJobController@UpdateJob');
    Route::post('CancelJob/{JobID}', 'APIJobController@CancelJob');
    Route::post('AcceptDelivery/{JobID}', 'APIJobController@AcceptDelivery');
    Route::post('RejectDelivery/{JobID}', 'APIJobController@RejectDelivery');
    Route::get('ViewOrderStatus/{user_id}', 'APIJobController@ViewOrderStatus');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'withdraw'

], function ($router) {

    Route::post('WithdrawRequest/{user_id}', 'APIWithdrawController@WithdrawRequest');

});


