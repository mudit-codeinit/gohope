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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user(); 
});
Route::post('login', 'ApiController@login');
Route::post('signup', 'ApiController@signup');
Route::post('social_login', 'ApiController@social_login');
Route::post('forgotpassword', 'ApiController@forgotpassword');
Route::post('changepassword', 'ApiController@changepassword'); 
Route::post('pickup_request', 'ApiController@pickup_request'); 
Route::post('accept_reject_request', 'ApiController@accept_reject_request'); 
Route::post('assigned_requests', 'ApiController@assigned_requests');  
Route::post('single_request', 'ApiController@single_request');  
Route::post('update_request_status', 'ApiController@update_request_status'); 
Route::post('update_profile', 'ApiController@update_profile'); 
Route::post('get_profile', 'ApiController@get_profile'); 
Route::post('get_lat_long_from_address', 'ApiController@get_lat_long_from_address'); 
Route::post('get_address_from_lat_long', 'ApiController@get_address_from_lat_long'); 
Route::post('get_pickup_details', 'ApiController@get_pickup_details');
Route::post('get_estimated_time', 'ApiController@get_estimated_time');
 
Route::post('push_notification', 'ApiController@push_notification');        
