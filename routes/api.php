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
    Route::post('forgot/password', 'Auth\ForgotPasswordController');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    
;
    Route::post('logout', 'AuthController@logout');
    

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'products'

], function ($router) {

    Route::get('product-customer', 'APIProductController@ProductCustomer');
    Route::get('product-agent', 'APIProductController@ProductAgent');
    Route::get('product-inventory/{user_id}', 'APIProductController@ProductInventory');
    Route::post('stock-deduction/{user_id}', 'APIProductController@DeductStock');
    Route::get('merchant-view-product/{user_id}', 'APIProductMerchantController@viewProductMerchant');
    Route::post('add-product-merchant/{user_id}', 'APIProductMerchantController@addProductMerchant');
    Route::post('insert-image-merchant/{product_id}', 'APIProductMerchantController@insertimage');
    Route::post('merchant-edit-product/{product_id}', 'APIProductMerchantController@MerchantEditProduct');
    Route::post('merchant-delete-product/{product_id}', 'APIProductMerchantController@MerchantDeleteProduct');


});

Route::group([

    'middleware' => 'api',
    'prefix' => 'users'

], function ($router) {

    Route::get('view-profile/{id}', 'APIUserController@viewProfile');
    Route::post('update-profile/{id}', 'APIUserController@UserProfile');
    Route::post('change-password/{id}', 'APIUserController@ChangePassword');
    Route::post('user-image/{id}', 'APIUserController@UserImage');
    Route::post('user-save-playerId/{id}', 'APIUserController@SavePalyerId');
   
    
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'store-location'

], function ($router) {

    Route::get('view-list', 'APIUserController@ListStoreLocation'); 
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'rating'

], function ($router) {

    Route::post('job-feedback/{JobID}', 'APIRatingController@submitrating'); 
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
    Route::get('merchant-list-job/{user_id}', 'APIJobController@PendingJobMerchant');
    Route::post('merchant-pickdelivery-method/{JobID}', 'APIJobController@PickMethod');
    Route::post('merchant-mark-as-completed/{JobID}', 'APIJobController@MerchantCompleteJob');

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

Route::group([

    'middleware' => 'api',
    'prefix' => 'dashboard'

], function ($router) {

    Route::get('view/{user_id}', 'APIDashboardController@viewdashboard');
    Route::get('merchant-view/{user_id}', 'APIDashboardController@merchantviewdashboard');
    Route::get('merchant-latest-order/{user_id}', 'APIDashboardController@LatestOrder');

});


/* RESTFUL API VERSION 2 */



Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    
    Route::post('register-v2', 'Auth\RegisterController@create');
    Route::post('login-v2', 'AuthController@login');
    Route::post('forgot/password-v2', 'Auth\ForgotPasswordController');

});

Route::group([

    'middleware' => 'jwt.verify',
    'prefix' => 'auth'

], function ($router) {
    
;
    Route::post('logout-v2', 'AuthController@logout');
    

});

Route::group([

    'middleware' => 'jwt.verify',
    'prefix' => 'products'

], function ($router) {

    Route::get('product-customer-v2', 'APIProductController@ProductCustomer');
    Route::get('product-agent-v2', 'APIProductController@ProductAgent');
    Route::get('product-inventory-v2/{user_id}', 'APIProductController@ProductInventory');
    Route::post('stock-deduction-v2/{user_id}', 'APIProductController@DeductStock');
    Route::get('merchant-view-product-v2/{user_id}', 'APIProductMerchantController@viewProductMerchant');
    Route::post('add-product-merchant-v2/{user_id}', 'APIProductMerchantController@addProductMerchant');
    Route::post('insert-image-merchant-v2/{product_id}', 'APIProductMerchantController@insertimage');
    Route::post('merchant-edit-product-v2/{product_id}', 'APIProductMerchantController@MerchantEditProduct');
    Route::post('merchant-delete-product-v2/{product_id}', 'APIProductMerchantController@MerchantDeleteProduct');


});

Route::group([

    'middleware' => 'jwt.verify',
    'prefix' => 'users'

], function ($router) {

    Route::get('view-profile-v2/{id}', 'APIUserController@viewProfile');
    Route::post('update-profile-v2/{id}', 'APIUserController@UserProfile');
    Route::post('change-password-v2/{id}', 'APIUserController@ChangePassword');
    Route::post('user-image-v2/{id}', 'APIUserController@UserImage');
    Route::post('user-save-playerId-v2/{id}', 'APIUserController@SavePalyerId');
   
    
});

Route::group([

    'middleware' => 'jwt.verify',
    'prefix' => 'store-location'

], function ($router) {

    Route::get('view-list-v2', 'APIUserController@ListStoreLocation'); 
});

Route::group([

    'middleware' => 'jwt.verify',
    'prefix' => 'rating'

], function ($router) {

    Route::post('job-feedback-v2/{JobID}', 'APIRatingController@submitrating'); 
});

Route::group([

    'middleware' => 'jwt.verify',
    'prefix' => 'purchase'

], function ($router) {

    Route::post('orders-v2/{user_id}', 'APIPurchaseControllerV2@orders');

});

Route::group([

    'middleware' => 'jwt.verify',
    'prefix' => 'job'

], function ($router) {

    Route::get('pending-job-v2', 'APIJobControllerV2@PendingJob');
    Route::get('status-job-v2/{user_id}', 'APIJobControllerV2@StatusJob');
    Route::post('accept-job-v2/{JobID}', 'APIJobControllerV2@AcceptJob');
    Route::post('agent-update-job-v2/{JobID}', 'APIJobControllerV2@UpdateJob');
    Route::post('cancel-job-v2/{JobID}', 'APIJobControllerV2@CancelJob');
    Route::post('accept-delivery-v2/{JobID}', 'APIJobControllerV2@AcceptDelivery');
    Route::post('reject-delivery-v2/{JobID}', 'APIJobControllerV2@RejectDelivery');
    Route::get('view-order-status-v2/{user_id}', 'APIJobControllerV2@ViewOrderStatus');
    Route::get('view-order-timeline-v2/{JobID}', 'APIJobControllerV2@OrderTrack');
    Route::get('merchant-list-job-v2/{user_id}', 'APIJobControllerV2@PendingJobMerchant');
    Route::post('merchant-pickdelivery-method-v2/{JobID}', 'APIJobControllerV2@PickMethod');
    Route::post('merchant-mark-as-completed-v2/{JobID}', 'APIJobControllerV2@MerchantCompleteJob');

});

Route::group([

    'middleware' => 'jwt.verify',
    'prefix' => 'withdraw'

], function ($router) {

    Route::post('withdraw-request-v2/{user_id}', 'APIWithdrawController@WithdrawRequest');

});

Route::group([

    'middleware' => 'jwt.verify',
    'prefix' => 'transaction'

], function ($router) {

    Route::post('history-v2/{user_id}', 'APIWithdrawController@History');

});

Route::group([

    'middleware' => 'jwt.verify',
    'prefix' => 'wallet'

], function ($router) {

    Route::get('balance-v2/{user_id}', 'APIWithdrawController@balance');

});

Route::group([

    'middleware' => 'jwt.verify',
    'prefix' => 'dashboard'

], function ($router) {

    Route::get('view-v2/{user_id}', 'APIDashboardController@viewdashboard');
    Route::get('merchant-view-v2/{user_id}', 'APIDashboardController@merchantviewdashboard');
    Route::get('merchant-latest-order-v2/{user_id}', 'APIDashboardController@LatestOrder');

});




