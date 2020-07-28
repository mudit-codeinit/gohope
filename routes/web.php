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

Route::get('/', function () {
    return view('welcome');
});

Route::group( ['middleware' => 'auth' ], function()
{
    return redirect('admin');
});


Route::group(["namespace" => "Admin" ,   "prefix" => "admin"], function(){
 Route::get('/', 'IndexController@index')->name('login') ;
Route::post('login', 'IndexController@postLogin');
Route::get('logout', 'IndexController@logout');
Route::get('dashboard', 'DashboardController@index');
Route::get('users', 'UsersController@index');
Route::get('requests', 'RequestsController@index');
//***********************************Portfolio********************************************/    
Route::get('requests/addnewrequest', 'RequestsController@addnewrequest');
Route::post('requests/addrequest', 'RequestsController@addrequest');
Route::get('requests/editrequest/{id}', 'RequestsController@addnewrequest');
Route::get('requests/deleterequest/{id}', 'RequestsController@deleterequest');
Route::get('requests/status/{id}', 'RequestsController@changestatus');//***********************************Users********************************************/    
Route::get('users/addnewuser', 'UsersController@addnewuser');
Route::post('users/adduser', 'UsersController@adduser');
Route::get('users/edituser/{id}', 'UsersController@addnewuser');
Route::get('users/deleteuser/{id}', 'UsersController@deleteuser');
Route::get('users/status/{id}', 'UsersController@changestatus');
});