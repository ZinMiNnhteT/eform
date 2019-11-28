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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::group(['middleware' => 'auth:admin_api'], function(){
//     Route::post('login', 'Api\UserController@login');
// });

Route::post('login', 'Api\PassportController@login');
Route::post('register', 'Api\PassportController@register');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('user', 'Api\PassportController@details');
});