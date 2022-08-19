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

// laravel passport api
// Route::post('login', 'Api\PassportController@login');
// Route::post('register', 'Api\PassportController@register');

// Route::group(['middleware' => 'auth:api'], function(){
//     Route::get('user', 'Api\PassportController@details');
// });

// Route::group(
//     [
//         'middleware'    => 'api',
//         'namespace'     => 'App\Http\Controllers\ApiForUser',
//         'prefix'        => 'auth',
//     ],
//     function($router){
//         Route::post('login', 'AuthController@login');
//         Route::post('register', 'AuthController@register');
//         Route::post('logout', 'AuthController@logout');
//         Route::get('profile', 'AuthController@profile');
//         Route::post('refresh', 'AuthController@refresh');
//     }
// );
// Route::group(
//     [
//         'middleware'    => 'api',
//         'namespace'     => 'App\Http\Controllers\ApiForUser',
//         'prefix'        => 'auth',
//     ],
//     function($router){
//         Route::get('home', 'HomeContoller@index');
//     }
// );

// jwt api
// authentication  start -----------
Route::group([
    'middleware'    => ['cors'], 
    'namespace'     => 'ApiForUser'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
});
Route::group([
    'middleware'    => ['auth.jwt', 'cors'], 
    'namespace'     => 'ApiForUser'
], function () {
    Route::get('logout', 'AuthController@logout');
    Route::get('profile', 'AuthController@profile');
    Route::post('check_token', 'AuthController@checkToken');
    Route::post('refresh_token', 'AuthController@refresh');
});
// authentication  end -----------
// helpers        start -----------
Route::group([
    'middleware'    => ['auth.jwt', 'cors'], 
    'namespace'     => 'ApiForUser',
], function () {
    // Townships 
    Route::get('township_dropdown', 'HelperController@township_dropdown');
    Route::post('township_dropdown', 'HelperController@township_dropdown');
});
// helpsers        end -----------
// yangon        start -----------
Route::group([
    'middleware'    => ['auth.jwt', 'cors'], 
    'namespace'     => 'ApiForUser\Yangon',
    'prefix'        => 'yangon'
], function () {
    // Residential
    // step 1 : meter type
    Route::post('residential_meter_type', 'ResidentialController@meter_type');
    // step 2 : applicant info
    Route::post('residential_applicant_info', 'ResidentialController@applicant_info');
    // step 3 : nrc 
    Route::post('residential_nrc','ResidentialController@nrc');
    // step 4 : Form10
    Route::post('residential_form10','ResidentialController@form10');
    // step 5 : Recommanded
    Route::post('residential_recommanded', 'ResidentialController@recommanded');
    // step 6 :  Ownership
    Route::post('residential_ownership', 'ResidentialController@ownership');
    // step 7 : FarmLand
    Route::post('residential_farmland', 'ResidentialController@farmland');
    // step 8 : Building (can skip)
    Route::post('residential_building', 'ResidentialController@building');
    // step 9 : power
    Route::post('residential_power', 'ResidentialController@power');
    // send form
    Route::post('residential_send_form', 'ResidentialController@send_form');
});
// yangon        end -----------