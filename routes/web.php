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
                return redirect('/dashboard');
                
            }
            
        else
            return redirect('error');
    });
    Route::get('/error', ['as' => 'viewError','uses' => 'ErrorController@viewError']);
   

    Route::get('/logout', function(){Auth::logout(); return Redirect::to('login');
    });

    // SUPER ADMIN 

    //Dashboard
    Route::get('/dashboard', ['as' => 'viewDashboard','uses' => 'DashboardController@viewDashboard'])->middleware('super_admin');

    //User Management 
    Route::get('/user', ['as' => 'viewUser','uses' => 'UserController@viewUser'])->middleware('super_admin');
    Route::get('/user/viewAdd', ['uses' => 'UserController@ViewAddUser','as' => 'viewAddUser'])->middleware('super_admin');
    Route::post('/user/add', ['as' => 'addUser','uses' => 'UserController@addUser'])->middleware('super_admin');
    Route::get('/user/edit/{id}', ['uses' => 'UserController@viewEditUser','as' => 'viewEditUser'])->middleware('super_admin');
    Route::post('/user/edit/{id}', ['uses' => 'UserController@editUser','as' => 'editUser'])->middleware('super_admin');
    Route::delete('/user/delete/{id}', ['uses' => 'UserController@deleteuser','as' => 'deleteuser'])->middleware('super_admin');
    
    
    //Product
    Route::get('/product', ['as' => 'viewProduct','uses' => 'ProductController@viewProduct'])->middleware('super_admin');
    Route::get('/product/viewAdd', ['uses' => 'ProductController@ViewAddProduct','as' => 'viewAddProduct'])->middleware('super_admin');
    Route::post('/product/add', ['as' => 'addProduct','uses' => 'ProductController@addProduct'])->middleware('super_admin');
    Route::get('/product/edit/{id}', ['uses' => 'ProductController@viewEditProduct','as' => 'viewEditProduct'])->middleware('super_admin');
    Route::post('/product/edit/{id}', ['uses' => 'ProductController@editProduct','as' => 'editProduct'])->middleware('super_admin');
    Route::delete('/product/delete/{id}', ['uses' => 'ProductController@delete','as' => 'delete'])->middleware('super_admin');
    Route::get('/product/assign/{id}', ['uses' => 'ProductController@viewAssignProduct','as' => 'viewAssignProduct'])->middleware('super_admin');
    Route::post('/product/assign/{id}', ['uses' => 'ProductController@assignProduct','as' => 'assignProduct'])->middleware('super_admin');

    //Agent Inventory
    Route::get('/Inventory', ['as' => 'viewInventory','uses' => 'ProductController@viewInventory'])->middleware('super_admin');
    Route::get('/Inventory/list-inventory/{user_id}', ['as' => 'viewInventoryDetails','uses' => 'ProductController@viewInventoryDetails'])->middleware('super_admin');
    Route::get('/Inventory/ed-inventory/{id}', ['uses' => 'ProductController@viewEditInvProduct','as' => 'viewEditInvProduct'])->middleware('super_admin');
    Route::post('/Inventory/ed-inventory/{id}', ['uses' => 'ProductController@editInventoryProduct','as' => 'editInventoryProduct'])->middleware('super_admin');
    Route::delete('/Inventory/delete/{id}', ['uses' => 'ProductController@deleteInventory','as' => 'deleteInventory'])->middleware('super_admin');

    //Joblists
    Route::get('/joblist/customer-order', ['as' => 'viewJoblist','uses' => 'JoblistController@viewJoblist'])->middleware('super_admin');
     Route::get('/joblist/agent-order', ['as' => 'viewAgentOrder','uses' => 'JoblistController@viewAgentOrder'])->middleware('super_admin');
    Route::get('/joblist/view/{JobID}', ['uses' => 'JoblistController@viewJobDetails','as' => 'viewJobDetails'])->middleware('super_admin');
    Route::get('/joblist/vwedit-agent-order/{id}', ['uses' => 'JoblistController@viewEditAgentOrder','as' => 'viewEditAgentOrder'])->middleware('super_admin');
    Route::post('/joblist/edit-agent-order/{id}', ['uses' => 'JoblistController@editAgentOrder','as' => 'editAgentOrder'])->middleware('super_admin');
    Route::get('/joblist/viewOrder', ['uses' => 'OrderController@ViewOrderList','as' => 'ViewOrderList'])->middleware('super_admin');
    Route::get('/joblist/order/{OrderID}', ['uses' => 'OrderController@ViewOrderDetails','as' => 'ViewOrderDetails'])->middleware('super_admin');

    
    //Sales Tracking
    Route::get('/sales', ['as' => 'viewSales','uses' => 'SalesController@viewSales'])->middleware('super_admin');
    
    //Withdraw
    Route::get('/withdraw', ['as' => 'viewWithdraw','uses' => 'WithdrawController@viewWithdraw'])->middleware('super_admin');
    Route::get('/withdraw/viewAppWithdraw/{withdrawID}', ['as' => 'viewWithdrawDetails','uses' => 'WithdrawController@viewWithdrawDetails'])->middleware('super_admin');
    Route::get('/withdraw/viewAppWithdrawDetails/{withdrawID}', ['as' => 'viewApproveWithdraw','uses' => 'WithdrawController@viewApproveWithdraw'])->middleware('super_admin');
    Route::post('/withdraw/edit/{withdrawID}', ['uses' => 'WithdrawController@saveWithdrawDetails','as' => 'saveWithdrawDetails'])->middleware('super_admin');
    Route::get('/withdraw/viewRejectWithdraw/{withdrawID}', ['as' => 'viewRejectWithdraw','uses' => 'WithdrawController@viewRejectWithdraw'])->middleware('super_admin');
    Route::post('/withdraw/reject/{withdrawID}', ['uses' => 'WithdrawController@saveRejectWdDetails','as' => 'saveRejectWdDetails'])->middleware('super_admin');

    // ADMIN

    //Dashboard
    Route::get('/dashboard', ['as' => 'viewDashboard','uses' => 'DashboardController@viewDashboard'])->middleware('admin');

    //User Management 
    Route::get('/user', ['as' => 'viewUser','uses' => 'UserController@viewUser'])->middleware('admin');
    Route::get('/user/viewAdd', ['uses' => 'UserController@ViewAddUser','as' => 'viewAddUser'])->middleware('admin');
    Route::post('/user/add', ['as' => 'addUser','uses' => 'UserController@addUser'])->middleware('admin');
    Route::get('/user/edit/{id}', ['uses' => 'UserController@viewEditUser','as' => 'viewEditUser'])->middleware('admin');
    Route::post('/user/edit/{id}', ['uses' => 'UserController@editUser','as' => 'editUser'])->middleware('admin');
    Route::delete('/user/delete/{id}', ['uses' => 'UserController@deleteuser','as' => 'deleteuser'])->middleware('admin');
    
    
    //Product
    Route::get('/product', ['as' => 'viewProduct','uses' => 'ProductController@viewProduct'])->middleware('admin');
    Route::get('/product/viewAdd', ['uses' => 'ProductController@ViewAddProduct','as' => 'viewAddProduct'])->middleware('admin');
    Route::post('/product/add', ['as' => 'addProduct','uses' => 'ProductController@addProduct'])->middleware('admin');
    Route::get('/product/edit/{id}', ['uses' => 'ProductController@viewEditProduct','as' => 'viewEditProduct'])->middleware('admin');
    Route::post('/product/edit/{id}', ['uses' => 'ProductController@editProduct','as' => 'editProduct'])->middleware('admin');
    Route::delete('/product/delete/{id}', ['uses' => 'ProductController@delete','as' => 'delete'])->middleware('admin');
    Route::get('/product/assign/{id}', ['uses' => 'ProductController@viewAssignProduct','as' => 'viewAssignProduct'])->middleware('super_admin');
    Route::post('/product/assign/{id}', ['uses' => 'ProductController@assignProduct','as' => 'assignProduct'])->middleware('admin');

    //Agent Inventory
    Route::get('/Inventory', ['as' => 'viewInventory','uses' => 'ProductController@viewInventory'])->middleware('admin');
    Route::get('/Inventory/list-inventory/{user_id}', ['as' => 'viewInventoryDetails','uses' => 'ProductController@viewInventoryDetails'])->middleware('super_admin');
    Route::get('/Inventory/ed-inventory/{id}', ['uses' => 'ProductController@viewEditInvProduct','as' => 'viewEditInvProduct'])->middleware('admin');
    Route::post('/Inventory/ed-inventory/{id}', ['uses' => 'ProductController@editInventoryProduct','as' => 'editInventoryProduct'])->middleware('admin');
    Route::delete('/Inventory/delete/{id}', ['uses' => 'ProductController@deleteInventory','as' => 'deleteInventory'])->middleware('admin');

    //Joblists
    Route::get('/joblist/customer-order', ['as' => 'viewJoblist','uses' => 'JoblistController@viewJoblist'])->middleware('admin');
     Route::get('/joblist/agent-order', ['as' => 'viewAgentOrder','uses' => 'JoblistController@viewAgentOrder'])->middleware('admin');
    Route::get('/joblist/view/{JobID}', ['uses' => 'JoblistController@viewJobDetails','as' => 'viewJobDetails'])->middleware('admin');
    Route::get('/joblist/vwedit-agent-order/{id}', ['uses' => 'JoblistController@viewEditAgentOrder','as' => 'viewEditAgentOrder'])->middleware('admin');
    Route::post('/joblist/edit-agent-order/{id}', ['uses' => 'JoblistController@editAgentOrder','as' => 'editAgentOrder'])->middleware('admin');
    Route::get('/joblist/viewOrder', ['uses' => 'OrderController@ViewOrderList','as' => 'ViewOrderList'])->middleware('admin');
    Route::get('/joblist/order/{OrderID}', ['uses' => 'OrderController@ViewOrderDetails','as' => 'ViewOrderDetails'])->middleware('admin');

    
    //Sales Tracking
    Route::get('/sales', ['as' => 'viewSales','uses' => 'SalesController@viewSales'])->middleware('admin');
    
    //Withdraw
    Route::get('/withdraw', ['as' => 'viewWithdraw','uses' => 'WithdrawController@viewWithdraw'])->middleware('admin');
    Route::get('/withdraw/viewAppWithdraw/{withdrawID}', ['as' => 'viewWithdrawDetails','uses' => 'WithdrawController@viewWithdrawDetails'])->middleware('admin');
    Route::get('/withdraw/viewAppWithdrawDetails/{withdrawID}', ['as' => 'viewApproveWithdraw','uses' => 'WithdrawController@viewApproveWithdraw'])->middleware('admin');
    Route::post('/withdraw/edit/{withdrawID}', ['uses' => 'WithdrawController@saveWithdrawDetails','as' => 'saveWithdrawDetails'])->middleware('admin');
    Route::get('/withdraw/viewRejectWithdraw/{withdrawID}', ['as' => 'viewRejectWithdraw','uses' => 'WithdrawController@viewRejectWithdraw'])->middleware('admin');
    Route::post('/withdraw/reject/{withdrawID}', ['uses' => 'WithdrawController@saveRejectWdDetails','as' => 'saveRejectWdDetails'])->middleware('admin');

    Route::get('bar-chart', 'ChartController@index');

});