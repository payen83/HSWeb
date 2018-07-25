<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
    Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        if (Auth::user()->role == 'Admin' or Auth::user()->role == 'SuperAdmin')
            {
                dd(Auth::user()->role);
                
            }
            
        else
            return redirect('error');
    });
    Route::get('error', function () {
        return redirect('/login')->with('flash_message_error', 'You are not authorized');
        return view('auth.login');
    });
   

    Route::get('/logout', function(){
    Auth::logout();
    return Redirect::to('login');
    });

    Route::get('/user', ['as' => 'viewUser','uses' => 'UserController@viewUser']);
    Route::get('/dashboard', ['as' => 'viewDashboard','uses' => 'DashboardController@viewDashboard']);
    Route::get('/user/viewAdd', ['uses' => 'UserController@ViewAddUser','as' => 'viewAddUser']);
    Route::post('/user/add', ['as' => 'addUser','uses' => 'UserController@addUser']);
    Route::get('/user/edit/{id}', ['uses' => 'UserController@viewEditUser','as' => 'viewEditUser']);
    Route::post('/user/edit/{id}', ['uses' => 'UserController@editUser','as' => 'editUser']);
    Route::delete('/user/delete/{id}', ['uses' => 'UserController@deleteuser','as' => 'deleteuser']);
    

    Route::get('/product', ['as' => 'viewProduct','uses' => 'ProductController@viewProduct']);
    Route::get('/product/viewAdd', ['uses' => 'ProductController@ViewAddProduct','as' => 'viewAddProduct']);
    Route::post('/product/add', ['as' => 'addProduct','uses' => 'ProductController@addProduct']);
    Route::get('/product/edit/{id}', ['uses' => 'ProductController@viewEditProduct','as' => 'viewEditProduct']);
    Route::post('/product/edit/{id}', ['uses' => 'ProductController@editProduct','as' => 'editProduct']);
    Route::delete('/product/delete/{id}', ['uses' => 'ProductController@delete','as' => 'delete']);
    Route::get('/product/assign/{id}', ['uses' => 'ProductController@viewAssignProduct','as' => 'viewAssignProduct']);
    Route::post('/product/assign/{id}', ['uses' => 'ProductController@assignProduct','as' => 'assignProduct']);

    Route::get('/Inventory', ['as' => 'viewInventory','uses' => 'ProductController@viewInventory']);
    Route::get('/Inventory/list-inventory/{user_id}', ['as' => 'viewInventoryDetails','uses' => 'ProductController@viewInventoryDetails']);
    Route::get('/Inventory/ed-inventory/{id}', ['uses' => 'ProductController@viewEditInvProduct','as' => 'viewEditInvProduct']);
    Route::post('/Inventory/ed-inventory/{id}', ['uses' => 'ProductController@editInventoryProduct','as' => 'editInventoryProduct']);
    Route::delete('/Inventory/delete/{id}', ['uses' => 'ProductController@deleteInventory','as' => 'deleteInventory']);

    Route::get('/joblist/customer-order', ['as' => 'viewJoblist','uses' => 'JoblistController@viewJoblist']);
     Route::get('/joblist/agent-order', ['as' => 'viewAgentOrder','uses' => 'JoblistController@viewAgentOrder']);
    Route::get('/joblist/view/{JobID}', ['uses' => 'JoblistController@viewJobDetails','as' => 'viewJobDetails']);
    Route::get('/joblist/vwedit-agent-order/{id}', ['uses' => 'JoblistController@viewEditAgentOrder','as' => 'viewEditAgentOrder']);
    Route::post('/joblist/edit-agent-order/{id}', ['uses' => 'JoblistController@editAgentOrder','as' => 'editAgentOrder']);
    Route::get('/joblist/viewOrder', ['uses' => 'OrderController@ViewOrderList','as' => 'ViewOrderList']);
    Route::get('/joblist/order/{OrderID}', ['uses' => 'OrderController@ViewOrderDetails','as' => 'ViewOrderDetails']);

     
    Route::get('/sales', ['as' => 'viewSales','uses' => 'SalesController@viewSales']);

    Route::get('/withdraw', ['as' => 'viewWithdraw','uses' => 'WithdrawController@viewWithdraw']);
    Route::get('/withdraw/viewAppWithdraw/{withdrawID}', ['as' => 'viewWithdrawDetails','uses' => 'WithdrawController@viewWithdrawDetails']);
    Route::get('/withdraw/viewAppWithdrawDetails/{withdrawID}', ['as' => 'viewApproveWithdraw','uses' => 'WithdrawController@viewApproveWithdraw']);
    Route::post('/withdraw/edit/{withdrawID}', ['uses' => 'WithdrawController@saveWithdrawDetails','as' => 'saveWithdrawDetails']);
    Route::get('/withdraw/viewRejectWithdraw/{withdrawID}', ['as' => 'viewRejectWithdraw','uses' => 'WithdrawController@viewRejectWithdraw']);
    Route::post('/withdraw/reject/{withdrawID}', ['uses' => 'WithdrawController@saveRejectWdDetails','as' => 'saveRejectWdDetails']);

    Route::get('bar-chart', 'ChartController@index');

});