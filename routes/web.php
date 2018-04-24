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
        if (Auth::user()->role == 'Super Admin' or 'Admin')
            return view('layouts.app');
      
        else
            return redirect('error');
    });
    Route::get('error', function () {
        return "Sorry, you are unauthorized to access this page.";
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@index');
        //Route::delete('delete/{id}', 'UserController@delete');
       
  });


     Route::get('/user', [
        'as' => 'viewUser',
        'uses' => 'UserController@viewUser'
    ]);


     Route::get('/user/viewAdd', [
        'uses' => 'UserController@ViewAddUser',
        'as' => 'viewAddUser'
    ]);
    Route::post('/user/add', [
        'as' => 'addUser',
        'uses' => 'UserController@addUser'
    ]);
    Route::get('/user/edit/{id}', [
        'uses' => 'UserController@viewEditUser',
        'as' => 'viewEditUser'
    ]);
    Route::post('/user/edit/{id}', [
        'uses' => 'UserController@editUser',
        'as' => 'editUser'
    ]);

    Route::post('/user/delete/{id}', [
      'uses' => 'UserController@delete',
      'as' => 'delete'
    ]);

    Route::patch('/user/update/{id}', [
        'as' => 'updateUser',
        'uses' => 'UserController@updateUser'
    ]);


     Route::get('/product', [
        'as' => 'viewProduct',
        'uses' => 'ProductController@viewProduct'
    ]);

    Route::get('/product/viewAdd', [
        'uses' => 'ProductController@ViewAddProduct',
        'as' => 'viewAddProduct'
    ]);
    Route::post('/product/add', [
        'as' => 'addProduct',
        'uses' => 'ProductController@addProduct'
     ]);

    Route::get('/product/edit/{id}', [
        'uses' => 'ProductController@viewEditProduct',
        'as' => 'viewEditProduct'
    ]);
    Route::post('/product/edit/{id}', [
        'uses' => 'ProductController@editProduct',
        'as' => 'editProduct'
    ]);

    Route::get('/product/assign/{id}', [
        'uses' => 'ProductController@viewAssignProduct',
        'as' => 'viewAssignProduct'
    ]);
    Route::post('/product/assign/{id}', [
        'uses' => 'ProductController@assignProduct',
        'as' => 'assignProduct'
    ]);

     Route::get('/Inventory', [
        'as' => 'viewInventory',
        'uses' => 'ProductController@viewInventory'
    ]);

     Route::get('/Inventory/ed-inventory/{id}', [
        'uses' => 'ProductController@viewEditInvProduct',
        'as' => 'viewEditInvProduct'
    ]);
    Route::post('/Inventory/ed-inventory/{id}', [
        'uses' => 'ProductController@editInventoryProduct',
        'as' => 'editInventoryProduct'
    ]);


     Route::get('/joblist', [
        'as' => 'viewJoblist',
        'uses' => 'JoblistController@viewJoblist'
    ]);

});