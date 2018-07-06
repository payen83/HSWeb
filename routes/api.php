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

    'middleware' => 'jwt.auth',
    'prefix' => 'products'

], function ($router) {

    Route::get('product-customer', 'APIProductController@ProductCustomer');
    Route::get('product-agent', 'APIProductController@ProductAgent');
    Route::get('product-inventory/{user_id}', 'APIProductController@ProductInventory');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'users'

], function ($router) {

    Route::get('view-profile/{id}', 'APIUserController@viewProfile');
    Route::post('update-profile/{id}', 'APIUserController@UserProfile');
    Route::post('change-password/{id}', 'APIUserController@ChangePassword');
    Route::post('user-image/{id}', 'APIUserController@UserImage');
   
    
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'purchase'

], function ($router) {

    Route::post('orders/{user_id}', 'APIPurchaseController@orders');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'job'

], function ($router) {

    Route::get('pending-job', 'APIJobController@PendingJob');
    Route::get('status-job/{user_id}', 'APIJobController@StatusJob');
    Route::post('accept-job/{JobID}', 'APIJobController@AcceptJob');
    Route::post('agent-update-job/{JobID}', 'APIJobController@UpdateJob');
    Route::post('cancel-job/{JobID}', 'APIJobController@CancelJob');
    Route::post('accept-delivery/{JobID}', 'APIJobController@AcceptDelivery');
    Route::post('reject-delivery/{JobID}', 'APIJobController@RejectDelivery');
    Route::get('view-order-status/{user_id}', 'APIJobController@ViewOrderStatus');
    Route::get('view-order-timeline/{JobID}', 'APIJobController@OrderTrack');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'withdraw'

], function ($router) {

    Route::post('withdraw-request/{user_id}', 'APIWithdrawController@WithdrawRequest');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'transaction'

], function ($router) {

    Route::post('history/{user_id}', 'APIWithdrawController@History');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'wallet'

], function ($router) {

    Route::get('balance/{user_id}', 'APIWithdrawController@balance');

});



