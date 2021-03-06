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
        if (Auth::user()->role == 'SuperAdmin')
            {
                return redirect('/dashboard-superadmin');
                
            }
        else if (Auth::user()->role == 'Admin')
            {
                return redirect('/dashboard-admin');
            }
        else if (Auth::user()->role == 'Merchant')
            {
                return redirect('/home-merchant');
            }
            
        else
            return redirect('error');
    });
    Route::get('/error', ['as' => 'viewError','uses' => 'ErrorController@viewError']);
   

    Route::get('/logout', function(){Auth::logout(); return Redirect::to('login');
    });
    
    //MERCHANT
    Route::get('/home-merchant', ['as' => 'viewHome','uses' => 'HomeController@viewHome'])->middleware('merchant');
    Route::get('/product-merchant', ['as' => 'viewProductMerchant','uses' => 'ProductMerchantController@viewProductMerchant'])->middleware('merchant')->middleware('merchant');
    Route::get('/product/merchant-vwaddproduct', ['uses' => 'ProductMerchantController@viewAddMerchantProduct','as' => 'viewAddMerchantProduct'])->middleware('merchant');
    Route::post('/product/merchant-add-product', ['as' => 'addProductMerchant','uses' => 'ProductMerchantController@addProductMerchant'])->middleware('merchant');
    Route::get('/product/-mc-vw-edit/{id}', ['uses' => 'ProductMerchantController@viewEditProductMerchant','as' => 'viewEditProductMerchant'])->middleware('merchant');
    Route::post('/product/mc-edit/{id}', ['uses' => 'ProductMerchantController@editProductMerchant','as' => 'editProductMerchant'])->middleware('merchant');
    Route::delete('/product/merchant-delete-product/{id}', ['uses' => 'ProductMerchantController@deleteproductmerchant','as' => 'deleteproductmerchant'])->middleware('merchant');
    Route::get('/joblist-merchant', ['as' => 'listpendingjob','uses' => 'JoblistController@listpendingjob'])->middleware('merchant');
    Route::get('/joblist-merchant-completed', ['as' => 'completedjob','uses' => 'JoblistController@completedjob'])->middleware('merchant');
    Route::get('/joblist-orders/viewdetails/{OrderID}', ['as' => 'MerchantOrderDetails','uses' => 'JoblistController@MerchantOrderDetails'])->middleware('merchant')->middleware('merchant');
     Route::get('/joblist-merchant/update/{JobID}', ['uses' => 'JoblistController@viewEditStatusJob','as' => 'viewEditStatusJob'])->middleware('merchant')->middleware('merchant');
     Route::post('/joblist-merchant/update-status/{JobID}', ['uses' => 'JoblistController@editStatusOrder','as' => 'editStatusOrder']);
     Route::get('/wallet-merchant', ['uses' => 'WithdrawController@viewWallet','as' => 'viewWallet'])->middleware('merchant')->middleware('merchant');
     Route::get('/wallet-merchant/withdraw/{amount}', ['uses' => 'WithdrawController@withdrawrequest','as' => 'withdrawrequest'])->middleware('merchant');

    // SUPER ADMIN 

    //Dashboard
    Route::get('/dashboard-superadmin', ['as' => 'viewDashboard','uses' => 'DashboardController@viewDashboard'])->middleware('super_admin');
    Route::get('/user/viewlist-superadmin', ['as' => 'viewUser','uses' => 'UserController@viewUser'])->middleware('super_admin');
    Route::get('/user/viewAdd-superadmin', ['uses' => 'UserController@viewAddUserSuperAdmin','as' => 'viewAddUserSuperAdmin'])->middleware('super_admin');;
    Route::delete('/user/delete-superadmin/{id}', ['uses' => 'UserController@deleteuser_superadmin','as' => 'deleteuser_superadmin'])->middleware('super_admin');

    // ADMIN

    //Dashboard
    Route::get('/dashboard-admin', ['as' => 'viewDashboard','uses' => 'DashboardController@viewDashboard'])->middleware('admin');
    Route::get('/user/viewlist-admin', ['as' => 'viewUserAdmin','uses' => 'UserController@viewUserAdmin'])->middleware('admin');
    Route::get('/user/viewAdd-admin', ['uses' => 'UserController@viewAddUserAdmin','as' => 'viewAddUserAdmin'])->middleware('admin');
    Route::delete('/user/delete-admin/{id}', ['uses' => 'UserController@deleteuser_admin','as' => 'deleteuser_admin'])->middleware('admin');

    //User Management 
    //Route::get('/user', ['as' => 'viewUser','uses' => 'UserController@viewUser']);
    //Route::get('/user/viewAdd', ['uses' => 'UserController@ViewAddUser','as' => 'viewAddUser']);
    Route::post('/user/add', ['as' => 'addUser','uses' => 'UserController@addUser']);
    Route::get('/user/edit/{id}', ['uses' => 'UserController@viewEditUser','as' => 'viewEditUser']);
    Route::post('/user/edit/{id}', ['uses' => 'UserController@editUser','as' => 'editUser']);
    //Route::delete('/user/delete/{id}', ['uses' => 'UserController@deleteuser','as' => 'deleteuser']);
    
    
    //Product
    Route::get('/product', ['as' => 'viewProduct','uses' => 'ProductController@viewProduct']);
    Route::get('/product-approval', ['as' => 'viewProductApproval','uses' => 'ProductController@viewProductApproval']);
    Route::get('/product/update-approval/{id}', ['uses' => 'ProductController@updateApproval','as' => 'updateApproval']);
    Route::get('/product/viewAdd', ['uses' => 'ProductController@ViewAddProduct','as' => 'viewAddProduct']);
    Route::post('/product/add', ['as' => 'addProduct','uses' => 'ProductController@addProduct']);
    Route::get('/product/edit/{id}', ['uses' => 'ProductController@viewEditProduct','as' => 'viewEditProduct']);
    Route::get('/product-approval/view-detail/{id}', ['uses' => 'ProductController@viewDeatilProduct','as' => 'viewDeatilProduct']);
    Route::post('/product/edit/{id}', ['uses' => 'ProductController@editProduct','as' => 'editProduct']);
    Route::delete('/product/delete/{id}', ['uses' => 'ProductController@delete','as' => 'delete']);
    Route::get('/product/assign/{id}', ['uses' => 'ProductController@viewAssignProduct','as' => 'viewAssignProduct']);
    Route::post('/product/assign/{id}', ['uses' => 'ProductController@assignProduct','as' => 'assignProduct']);

    //Agent Inventory
    Route::get('/Inventory', ['as' => 'viewInventory','uses' => 'ProductController@viewInventory']);
    Route::get('/Inventory/list-inventory/{user_id}', ['as' => 'viewInventoryDetails','uses' => 'ProductController@viewInventoryDetails']);
    Route::get('/Inventory/ed-inventory/{id}', ['uses' => 'ProductController@viewEditInvProduct','as' => 'viewEditInvProduct']);
    Route::post('/Inventory/ed-inventory/{id}', ['uses' => 'ProductController@editInventoryProduct','as' => 'editInventoryProduct']);
    Route::delete('/Inventory/delete/{id}', ['uses' => 'ProductController@deleteInventory','as' => 'deleteInventory']);

    //Joblists
    Route::get('/joblist-customer-order', ['as' => 'viewJoblist','uses' => 'JoblistController@viewJoblist']);
    Route::get('/joblist/agent-order', ['as' => 'viewAgentOrder','uses' => 'JoblistController@viewAgentOrder']);
    Route::get('/joblist-pending-order', ['as' => 'viewPendingJoblist','uses' => 'JoblistController@viewPendingJoblist']);
    Route::get('/joblist-pending-merchant', ['as' => 'viewMerchantPending','uses' => 'JoblistController@viewMerchantPending']);
    Route::get('/joblist-complete-merchant', ['as' => 'viewMerchantCompleted','uses' => 'JoblistController@viewMerchantCompleted']);
    Route::get('/joblist/view/{JobID}', ['uses' => 'JoblistController@viewJobDetails','as' => 'viewJobDetails']);
    Route::get('/joblist/vwedit-agent-order/{JobID}', ['uses' => 'JoblistController@viewEditAgentOrder','as' => 'viewEditAgentOrder']);
    Route::post('/joblist/edit-agent-order/{JobID}', ['uses' => 'JoblistController@editAgentOrder','as' => 'editAgentOrder']);
    Route::get('/joblist/viewOrder', ['uses' => 'OrderController@ViewOrderList','as' => 'ViewOrderList']);
    Route::get('/joblist/order/{OrderID}', ['uses' => 'OrderController@ViewOrderDetails','as' => 'ViewOrderDetails']);
    Route::get('/agent-order/{OrderID}', ['uses' => 'OrderController@ViewAgentOrderDetails','as' => 'ViewAgentOrderDetails']);
    Route::get('/joblist-order-merchant/{OrderID}', ['as' => 'MerchantOrder','uses' => 'JoblistController@MerchantOrder']);

    
    //Sales Tracking
    Route::get('/sales', ['as' => 'viewSales','uses' => 'SalesController@viewSales']);
    Route::get('/sales-filter', ['as' => 'filterSales','uses' => 'SalesController@filterSales']);
    
    //Withdraw
    Route::get('/withdraw', ['as' => 'viewWithdraw','uses' => 'WithdrawController@viewWithdraw']);
    Route::get('/withdraw/viewAppWithdraw/{withdrawID}', ['as' => 'viewWithdrawDetails','uses' => 'WithdrawController@viewWithdrawDetails']);
    Route::get('/withdraw/viewAppWithdrawDetails/{withdrawID}', ['as' => 'viewApproveWithdraw','uses' => 'WithdrawController@viewApproveWithdraw']);
    Route::post('/withdraw/edit/{withdrawID}', ['uses' => 'WithdrawController@saveWithdrawDetails','as' => 'saveWithdrawDetails']);
    Route::get('/withdraw/viewRejectWithdraw/{withdrawID}', ['as' => 'viewRejectWithdraw','uses' => 'WithdrawController@viewRejectWithdraw']);
    Route::post('/withdraw/reject/{withdrawID}', ['uses' => 'WithdrawController@saveRejectWdDetails','as' => 'saveRejectWdDetails']);

});