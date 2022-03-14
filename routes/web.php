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

Route::get('/',['as' => 'get:admin_login', 'uses' => 'AdminController@getLogin']);
Route::post('/login',['as' => 'post:admin_login', 'uses' => 'AdminController@postLogin']);

Route::get('/dashboard',['as' => 'get:dashboard', 'uses' => 'AdminController@getDashboard']);
Route::get('/add-user',['as' => 'get:add_user', 'uses' => 'AdminController@getAddUser']);

Route::post('/add-user',['as' => 'post:add_user', 'uses' => 'AdminController@postAddEditUser']);
Route::post('/change-status',['as' => 'post:change_status', 'uses' => 'AdminController@postChangeUserStatus']);
Route::post('/delete-user',['as' => 'post:delete_user', 'uses' => 'AdminController@postDeleteUser']);
Route::get('/edit-user/{user_id}',['as' => 'get:edit_user', 'uses' => 'AdminController@getEditUser']);

Route::get('/logout',['as' => 'get:logout', 'uses' => 'AdminController@getLogout']);