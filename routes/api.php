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

    // Residential Power
    // step 1 : meter type
    Route::post('rp_meter_type', 'ResidentialPowerController@meter_type');
    // step 2 : applicant info
    Route::post('rp_info', 'ResidentialPowerController@info');
    // step 3 : nrc 
    Route::post('rp_nrc','ResidentialPowerController@nrc');
    // step 4 : Form10
    Route::post('rp_form10','ResidentialPowerController@form10');
    // step 5 : Recommanded
    Route::post('rp_recommanded', 'ResidentialPowerController@recommanded');
    // step 6 :  Ownership
    Route::post('rp_ownership', 'ResidentialPowerController@ownership');
    // step 7 : power
    Route::post('rp_power', 'ResidentialPowerController@power');
    // send form
    Route::post('rp_send_form', 'ResidentialPowerController@send_form');
});
// yangon        end -----------


Route::group([
    'middleware'    => ['auth.jwt', 'cors'], 
    'namespace'     => 'ApiForUser',
], function () {
    // save meter type (မီတာအမျိုးအစား) for (r,rp,cp)
    Route::post('meter_type', 'HomeController@meter_type');
    // save contractor meter type (မီတာအမျိုးအစား)
    Route::post('meter_tye_contractor', 'HomeController@meter_tye_contractor');
    // save transformer meter type (မီတာအမျိုးအစား)
    Route::post('meter_type_transformer', 'HomeController@meter_type_transformer');
    // save applicant info (လျှောက်ထားသူ)
    Route::post('applicant_info', 'HomeController@applicant_info');
    // save applicant info (လျှောက်ထားသူ)
    Route::post('applicant_info_contractor', 'HomeController@applicant_info_contractor');
    // save applicant info (လျှောက်ထားသူ)
    Route::post('applicant_info_transformer', 'HomeController@applicant_info_transformer');
    // save nrc (မှတ်ပုံတင်/ ဘာသာရေးကတ်)
    Route::post('nrc','HomeController@nrc');
    // save household/Form10 (အိမ်ထောင်စုစာရင်း)
    Route::post('form10','HomeController@form10');
    // save Recommanded (ထောက်ခံစာ)
    Route::post('recommanded', 'HomeController@recommanded');
    // save  Ownership (ပိုင်ဆိုင်မှုအထောက်အထား)
    Route::post('ownership', 'HomeController@ownership');
    // save FarmLand (လယ်ယာပိုင်မြေ)
    Route::post('farmland', 'HomeController@farmland');
    // save Building (အဆောက်အဦးပုံ)
    Route::post('building', 'HomeController@building');
    // save power (ဝန်အားစာရင်း)
    Route::post('power', 'HomeController@power');
    // save meter bill (current meter) (လက်ရှိတပ်ဆင်ထားသောမီတာ)
    Route::post('bill', 'HomeController@bill');
    // save license (လုပ်ငန်းလိုင်စင်)
    Route::post('license', 'HomeController@license');
    // save build permit  (ဆောက်လုပ်ခွင့်)
    Route::post('building_permit', 'HomeController@building_permit');
    // save bcc (လူနေထိုင်ခွင့်)
    Route::post('bcc', 'HomeController@bcc');
    // save dc (စည်ပင်ထောက်ခံစာ)
    Route::post('dc', 'HomeController@dc');
    // save bq တိုက်ပုံစံဓါတ်ပုံ BQ
    Route::post('bq', 'HomeController@bq');
    // save drawng (ဆောက်အဦး Drawing)
    Route::post('drawing', 'HomeController@drawing');
    // save map (တည်နေရာ)
    Route::post('map', 'HomeController@map');
    // save sign (လက်မှတ်ရေးထိုး)
    Route::post('sign', 'HomeController@sign');
    // save sign (စက်မှုဇုံထောက်ခံစာ)
    Route::post('industry', 'HomeController@industry');
    // save sign (စည်ပင်သာယာလိုင်စင်)
    Route::post('city_license', 'HomeController@city_license');
    // save ministry_permit (သက်ဆိုင်ရာဝန်ကြီးဌာန ခွင့်ပြုမိန့်)
    Route::post('ministry_permit', 'HomeController@ministry_permit');
    // send form
    Route::post('send_form', 'HomeController@send_form');
});