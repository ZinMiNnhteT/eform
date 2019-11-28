<?php

use App\Events\sendNote;

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

/* For Test Error Pages */
Route::get('/pages/{page}', function($page) {
    switch ($page) {
        case '401': abort(401); break;
        case '403': abort(403); break;
        case '404': abort(404); break;
        case '419': abort(419); break;
        case '429': abort(429); break;
        case '500': abort(500); break;
        case '503': abort(503); break;
        default: return 'This is Error Testing Page. Type error codes (401, 403, 404, 419, 429, 500 and 503) in the URL\'s end'; break;
    }
});
Route::get('/test', function() {
    event(new sendNote('1'));
});
Route::get('send_mail', 'AdminHomeController@send_mail');
/* For Test Error Pages */

Route::view('/', 'welcome');
Auth::routes(['verify' => true]);

Route::get('/language/{locale}', function($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});

Route::get('/login/moee', 'Auth\LoginController@showAdminLoginForm');
Route::post('/login/moee', 'Auth\LoginController@adminLogin');
// Route::get('/register/moee', 'Auth\RegisterController@showAdminRegisterForm');
Route::post('/register/moee', 'Auth\RegisterController@createAdmin');
Route::get('refresh_captcha', 'SettingController@refresh_captcha');

Route::get('chart_with_database', 'SettingController@chart_data');
/* --------------------------------------------------------------------------------------------------------------- */
/* User Route */
/* ========== */
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
    Route::get('/onlineMeterApplyingForm', 'HomeController@all_meter_forms')->name('all_meter_forms')->middleware('verified');
    // Route::get('/applicationForm', 'HomeController@residential_index')->name('resident_app')->middleware('verified');
    // Route::get('/applicationFormYangon', 'HomeController@reisdential_ygn_index')->name('resident_app_ygn')->middleware('verified');

    /* ========================================================= USER INBOX ========================================================= */
    Route::get('/inbox', 'HomeController@user_inbox')->name('inbox.index')->middleware('verified');
    Route::get('/inbox/{id}', 'HomeController@user_inbox2')->name('inbox.index2')->middleware('verified');

    /* ================================================ USER APPLICATION FORM PROCESS ================================================ */
    Route::get('/overallProcess', 'HomeController@user_overall_process')->name('overall_process')->middleware('verified');

    /* ================================================ USER RLUES AND REGULATION ================================================ */
    Route::get('/rulesAndRegulations', 'HomeController@rules_and_regulations')->name('rule_regu')->middleware('verified');

    /* ================================================ FAQs ================================================ */
    Route::get('/faqs', 'HomeController@faqs')->name('faqs')->middleware('verified');

    /* =========================================================== JS route =========================================================== */
    Route::post('/choose_township', 'SettingController@choose_township')->middleware('verified');
    Route::post('/delete_old_back', 'SettingController@delete_old_back')->middleware('verified');
    Route::post('/mail_detail_show', 'SettingController@mail_detail_show')->middleware('verified');
    Route::post('/disabled_mail_alert', 'SettingController@disabled_mail_alert')->middleware('verified');

    /* ========================================================= payment form ========================================================= */
    Route::get('/paymentForm/{id}', 'HomeController@user_payment_form_create')->name('user_pay_form.create')->middleware('verified');
    Route::post('/paymentForm', 'HomeController@user_payment_form_store')->name('user_pay_form.store')->middleware('verified');
    /* ======================================================================================================================================= */
    /* ================================================== Other Divisions and States ================================================== */
    /* ======================================================================================================================================= */
    /* ================================================== Start Residential Meter ================================================== */
    /* Rule and Regulation */
    Route::get('/residentialMeterRuleAndRegulation', 'HomeController@residential_rule_regulation')->name('resident_rule_regulation')->middleware('verified');
    /* Reisdential Meter Type */
    Route::get('/residentialMeterType', 'HomeController@residential_select_meter_type')->name('resident_meter_type')->middleware('verified');
    Route::post('/residentialMeterType', 'HomeController@residential_store_meter_type')->name('resident_store_meter_type')->middleware('verified');
    Route::get('/residentialMeterTypeEdit/{id}', 'HomeController@residential_edit_meter_type')->name('resident_edit_meter_type')->middleware('verified');
    Route::patch('/residentialMeterTypeUpdate', 'HomeController@residential_update_meter_type')->name('resident_update_meter_type')->middleware('verified');
    /* User Info */
    Route::get('/residentialMeterApplicantInfo/{id}', 'HomeController@residential_user_information')->name('resident_user_info')->middleware('verified');
    Route::post('/residentialMeterApplicantInfo', 'HomeController@residential_store_user_information')->name('resident_store_user_info')->middleware('verified');
    Route::get('/residentialMeterApplicantInfoEdit/{id}', 'HomeController@residential_edit_user_information')->name('resident_edit_user_info')->middleware('verified');
    Route::patch('/residentialMeterApplicantInfoUpdate', 'HomeController@residential_update_user_information')->name('resident_update_user_info')->middleware('verified');
    /* User NRC */
    Route::get('/residentialMeterApplicantNRC/{id}', 'HomeController@residential_nrc_create')->name('resident_nrc_create')->middleware('verified');
    Route::post('/residentialMeterApplicantNRC', 'HomeController@residential_nrc_store')->name('resident_nrc_store')->middleware('verified');
    Route::get('/residentialMeterApplicantNRCEdit/{id}', 'HomeController@residential_nrc_edit')->name('resident_nrc_edit')->middleware('verified');
    Route::patch('/residentialMeterApplicantNRCUpdate', 'HomeController@residential_nrc_update')->name('resident_nrc_update')->middleware('verified');
    /* User Form10 */
    Route::get('/residentialMeterApplicantForm10/{id}', 'HomeController@residential_form10_create')->name('resident_form10_create')->middleware('verified');
    Route::post('/residentialMeterApplicantForm10', 'HomeController@residential_form10_store')->name('resident_form10_store')->middleware('verified');
    Route::get('/residentialMeterApplicantForm10Edit/{id}', 'HomeController@residential_form10_edit')->name('resident_form10_edit')->middleware('verified');
    Route::patch('/residentialMeterApplicantForm10Update', 'HomeController@residential_form10_update')->name('resident_form10_update')->middleware('verified');
    /* User Recommmanded Letter */
    Route::get('/residentialMeterApplicantRecommanded/{id}', 'HomeController@residential_recomm_create')->name('resident_recomm_create')->middleware('verified');
    Route::post('/residentialMeterApplicantRecommanded', 'HomeController@residential_recomm_store')->name('resident_recomm_store')->middleware('verified');
    Route::get('/residentialMeterApplicantRecommandedEdit/{id}', 'HomeController@residential_recomm_edit')->name('resident_recomm_edit')->middleware('verified');
    Route::patch('/residentialMeterApplicantRecommandedUpdate', 'HomeController@residential_recomm_update')->name('resident_recomm_update')->middleware('verified');
    /* User Ownership */
    Route::get('/residentialMeterApplicantOwnership/{id}', 'HomeController@residential_owner_create')->name('resident_owner_create')->middleware('verified');
    Route::post('/residentialMeterApplicantOwnership', 'HomeController@residential_owner_store')->name('resident_owner_store')->middleware('verified');
    Route::get('/residentialMeterApplicantOwnershipEdit/{id}', 'HomeController@residential_owner_edit')->name('resident_owner_edit')->middleware('verified');
    Route::patch('/residentialMeterApplicantOwnershipUpdate', 'HomeController@residential_owner_update')->name('resident_owner_update')->middleware('verified');
    /* User Applied Form View */
    Route::get('/residentialMeterAppliedForm/{id}', 'HomeController@residential_show')->name('resident_applied_form')->middleware('verified');
    /* User Send Form to Office */
    Route::post('/residentialOverallProcess', 'HomeController@residential_send_form')->name('resident_user_send_form')->middleware('verified');
    /* ================================================== End Residential Meter ================================================== */

    /* ================================================== Start Residential Power Meter ================================================== */
    Route::get('/residentialPowerMeterRuleAndRegulation', 'HomeController@residential_power_rule_regulation')->name('resident_power_rule_regulation')->middleware('verified');
     /* Reisdential Power Meter Type */
    Route::get('/residentialPowerMeterType', 'HomeController@residential_power_select_meter_type')->name('resident_power_meter_type')->middleware('verified');
    Route::post('/residentialPowerMeterType', 'HomeController@residential_power_store_meter_type')->name('resident_power_store_meter_type')->middleware('verified');
    Route::get('/residentialPowerMeterTypeEdit/{id}', 'HomeController@residential_power_edit_meter_type')->name('resident_power_edit_meter_type')->middleware('verified');
    Route::patch('/residentialPowerMeterTypeUpdate', 'HomeController@residential_power_update_meter_type')->name('resident_power_update_meter_type')->middleware('verified');
    /* User Info */
    Route::get('/residentialPowerMeterApplicantInfo/{id}', 'HomeController@residential_power_user_information')->name('resident_power_user_info')->middleware('verified');
    Route::post('/residentialPowerMeterApplicantInfo', 'HomeController@residential_power_store_user_information')->name('resident_power_store_user_info')->middleware('verified');
    Route::get('/residentialPowerMeterApplicantInfoEdit/{id}', 'HomeController@residential_power_edit_user_information')->name('resident_power_edit_user_info')->middleware('verified');
    Route::patch('/residentialPowerMeterApplicantInfoUpdate', 'HomeController@residential_power_update_user_information')->name('resident_power_update_user_info')->middleware('verified');
    /* User NRC */
    Route::get('/residentialPowerMeterApplicantNRC/{id}', 'HomeController@residential_power_nrc_create')->name('resident_power_nrc_create')->middleware('verified');
    Route::post('/residentialPowerMeterApplicantNRC', 'HomeController@residential_power_nrc_store')->name('resident_power_nrc_store')->middleware('verified');
    Route::get('/residentialPowerMeterApplicantNRCEdit/{id}', 'HomeController@residential_power_nrc_edit')->name('resident_power_nrc_edit')->middleware('verified');
    Route::patch('/residentialPowerMeterApplicantNRCUpdate', 'HomeController@residential_power_nrc_update')->name('resident_power_nrc_update')->middleware('verified');
     /* User Form10 */
    Route::get('/residentialPowerMeterApplicantForm10/{id}', 'HomeController@residential_power_form10_create')->name('resident_power_form10_create')->middleware('verified');
    Route::post('/residentialPowerMeterApplicantForm10', 'HomeController@residential_power_form10_store')->name('resident_power_form10_store')->middleware('verified');
    Route::get('/residentialPowerMeterApplicantForm10Edit/{id}', 'HomeController@residential_power_form10_edit')->name('resident_power_form10_edit')->middleware('verified');
    Route::patch('/residentialPowerMeterApplicantForm10Update', 'HomeController@residential_power_form10_update')->name('resident_power_form10_update')->middleware('verified');
     /* User Recommmanded Letter */
    Route::get('/residentialPowerMeterApplicantRecommanded/{id}', 'HomeController@residential_power_recomm_create')->name('resident_power_recomm_create')->middleware('verified');
    Route::post('/residentialPowerMeterApplicantRecommanded', 'HomeController@residential_power_recomm_store')->name('resident_power_recomm_store')->middleware('verified');
    Route::get('/residentialPowerMeterApplicantRecommandedEdit/{id}', 'HomeController@residential_power_recomm_edit')->name('resident_power_recomm_edit')->middleware('verified');
    Route::patch('/residentialPowerMeterApplicantRecommandedUpdate', 'HomeController@residential_power_recomm_update')->name('resident_power_recomm_update')->middleware('verified');
    /* User Ownership */
    Route::get('/residentialPowerMeterApplicantOwnership/{id}', 'HomeController@residential_power_owner_create')->name('resident_power_owner_create')->middleware('verified');
    Route::post('/residentialPowerMeterApplicantOwnership', 'HomeController@residential_power_owner_store')->name('resident_power_owner_store')->middleware('verified');
    Route::get('/residentialPowerMeterApplicantOwnershipEdit/{id}', 'HomeController@residential_power_owner_edit')->name('resident_power_owner_edit')->middleware('verified');
    Route::patch('/residentialPowerMeterApplicantOwnershipUpdate', 'HomeController@residential_power_owner_update')->name('resident_power_owner_update')->middleware('verified');
    /* Use Electric Power */
    Route::get('/residentialPowerMeterUseElectricPower/{id}', 'HomeController@residential_power_electricpower_create')->name('resident_power_electricpower_create')->middleware('verified');
    Route::post('/residentialPowerMeterUseElectricPower', 'HomeController@residential_power_electricpower_store')->name('resident_power_electricpower_store')->middleware('verified');
    Route::get('/residentialPowerMeterUseElectricPowerEdit/{id}', 'HomeController@residential_power_electricpower_edit')->name('resident_power_electricpower_edit')->middleware('verified');
    Route::patch('/residentialPowerMeterUseElectricPowerUpdate', 'HomeController@residential_power_electricpower_update')->name('resident_power_electricpower_update')->middleware('verified');
    /* User Applied Form View */
    Route::get('/residentialPowerMeterAppliedForm/{id}', 'HomeController@residential_power_show')->name('resident_power_applied_form')->middleware('verified');
    /* User Send Form to Office */
    Route::post('/residentialPowerOverallProcess', 'HomeController@residential_power_send_form')->name('resident_power_user_send_form')->middleware('verified');
    /* ================================================== Start Residential Power Meter ================================================== */

    /* ================================================== Start Commercial Power Merter ================================================== */
    /* Rule and Regulation */
    Route::get('/commercialPowerMeterRuleAndRegulation', 'HomeController@commercial_rule_regulation')->name('commercial_rule_regulation')->middleware('verified');
    /* Reisdential Meter Type */
    Route::get('/commercialPowerMeterType', 'HomeController@commercial_select_meter_type')->name('commercial_meter_type')->middleware('verified');
    Route::post('/commercialPowerMeterType', 'HomeController@commercial_store_meter_type')->name('commercial_store_meter_type')->middleware('verified');
    Route::get('/commercialPowerMeterTypeEdit/{id}', 'HomeController@commercial_edit_meter_type')->name('commercial_edit_meter_type')->middleware('verified');
    Route::patch('/commercialPowerMeterTypeUpdate', 'HomeController@commercial_update_meter_type')->name('commercial_update_meter_type')->middleware('verified');
    /* User Info */
    Route::get('/commercialPowerMeterApplicantInfo/{id}', 'HomeController@commercial_user_information')->name('commercial_user_info')->middleware('verified');
    Route::post('/commercialPowerMeterApplicantInfo', 'HomeController@commercial_store_user_information')->name('commercial_store_user_info')->middleware('verified');
    Route::get('/commercialPowerMeterApplicantInfoEdit/{id}', 'HomeController@commercial_edit_user_information')->name('commercial_edit_user_info')->middleware('verified');
    Route::patch('/commercialPowerMeterApplicantInfoUpdate', 'HomeController@commercial_update_user_information')->name('commercial_update_user_info')->middleware('verified');
    /* User NRC */
    Route::get('/commercialPowerMeterApplicantNRC/{id}', 'HomeController@commercial_nrc_create')->name('commercial_nrc_create')->middleware('verified');
    Route::post('/commercialPowerMeterApplicantNRC', 'HomeController@commercial_nrc_store')->name('commercial_nrc_store')->middleware('verified');
    Route::get('/commercialPowerMeterApplicantNRCEdit/{id}', 'HomeController@commercial_nrc_edit')->name('commercial_nrc_edit')->middleware('verified');
    Route::patch('/commercialPowerMeterApplicantNRCUpdate', 'HomeController@commercial_nrc_update')->name('commercial_nrc_update')->middleware('verified');
    /* User Form10 */
    Route::get('/commercialPowerMeterApplicantForm10/{id}', 'HomeController@commercial_form10_create')->name('commercial_form10_create')->middleware('verified');
    Route::post('/commercialPowerMeterApplicantForm10', 'HomeController@commercial_form10_store')->name('commercial_form10_store')->middleware('verified');
    Route::get('/commercialPowerMeterApplicantForm10Edit/{id}', 'HomeController@commercial_form10_edit')->name('commercial_form10_edit')->middleware('verified');
    Route::patch('/commercialPowerMeterApplicantForm10Update', 'HomeController@commercial_form10_update')->name('commercial_form10_update')->middleware('verified');
    /* User Recommmanded Letter */
    Route::get('/commercialPowerMeterApplicantRecommanded/{id}', 'HomeController@commercial_recomm_create')->name('commercial_recomm_create')->middleware('verified');
    Route::post('/commercialPowerMeterApplicantRecommanded', 'HomeController@commercial_recomm_store')->name('commercial_recomm_store')->middleware('verified');
    Route::get('/commercialPowerMeterApplicantRecommandedEdit/{id}', 'HomeController@commercial_recomm_edit')->name('commercial_recomm_edit')->middleware('verified');
    Route::patch('/commercialPowerMeterApplicantRecommandedUpdate', 'HomeController@commercial_recomm_update')->name('commercial_recomm_update')->middleware('verified');
    /* User Ownership */
    Route::get('/commercialPowerMeterApplicantOwnership/{id}', 'HomeController@commercial_owner_create')->name('commercial_owner_create')->middleware('verified');
    Route::post('/commercialPowerMeterApplicantOwnership', 'HomeController@commercial_owner_store')->name('commercial_owner_store')->middleware('verified');
    Route::get('/commercialPowerMeterApplicantOwnershipEdit/{id}', 'HomeController@commercial_owner_edit')->name('commercial_owner_edit')->middleware('verified');
    Route::patch('/commercialPowerMeterApplicantOwnershipUpdate', 'HomeController@commercial_owner_update')->name('commercial_owner_update')->middleware('verified');
    /* Use Work Licence */
    Route::get('/commercialPowerMeterWorkLicence/{id}', 'HomeController@commercial_worklicence_create')->name('commercial_worklicence_create')->middleware('verified');
    Route::post('/commercialPowerMeterWorkLicence', 'HomeController@commercial_worklicence_store')->name('commercial_worklicence_store')->middleware('verified');
    Route::get('/commercialPowerMeterWorkLicenceEdit/{id}', 'HomeController@commercial_worklicence_edit')->name('commercial_worklicence_edit')->middleware('verified');
    Route::patch('/commercialPowerMeterWorkLicenceUpdate', 'HomeController@commercial_worklicence_update')->name('commercial_worklicence_update')->middleware('verified');
    /* Use Electric Power */
    Route::get('/commercialPowerMeterUseElectricPower/{id}', 'HomeController@commercial_electricpower_create')->name('commercial_electricpower_create')->middleware('verified');
    Route::post('/commercialPowerMeterUseElectricPower', 'HomeController@commercial_electricpower_store')->name('commercial_electricpower_store')->middleware('verified');
    Route::get('/commercialPowerMeterUseElectricPowerEdit/{id}', 'HomeController@commercial_electricpower_edit')->name('commercial_electricpower_edit')->middleware('verified');
    Route::patch('/commercialPowerMeterUseElectricPowerUpdate', 'HomeController@commercial_electricpower_update')->name('commercial_electricpower_update')->middleware('verified');
     /* User Applied Form View */
    Route::get('/commercialPowerMeterAppliedForm/{id}', 'HomeController@commercial_show')->name('commercial_applied_form')->middleware('verified');
     /* User Send Form to Office */
    Route::post('/commercialOverallProcess', 'HomeController@commercial_send_form')->name('commercial_user_send_form')->middleware('verified');
    /* ================================================== End Commercial Power Merter ================================================== */

    /* ================================================== Start Contractor Merter ================================================== */
    /* Rule and Regulation */
    Route::get('/contractorRuleAndRegulation', 'HomeController@contractor_rule_regulation')->name('contract_rule_regulation')->middleware('verified');
    /* Choose buildings ==> 4-17 and 18andOver */
    Route::get('/contractorBuildingRoom', 'HomeController@contractor_building_room')->name('contract_building_room')->middleware('verified');

    Route::get('/contractorBuildingRoomEdit/{id}', 'HomeController@contractor_building_room_edit')->name('contract_building_room_edit')->middleware('verified');
    Route::patch('/contractorBuildingRoomUpdate', 'HomeController@contractor_building_update')->name('contract_building_room_update')->middleware('verified');

    Route::post('/contractorChooseBuilding', 'HomeController@contractor_building')->name('contractor_choose_form')->middleware('verified');
    Route::post('/chooseBuilding18Under', 'HomeController@contractor_building_4_17')->name('contractor_choose_4_17')->middleware('verified');
    Route::post('/chooseBuilding18Over', 'HomeController@contractor_building_18')->name('contractor_choose_18')->middleware('verified');
    /* 4-17 rooms */
    /* User Info */
    Route::get('/contractorMeterOneUserInformation/{id}', 'HomeController@room_417_user_information')->name('417_user_info')->middleware('verified');
    Route::post('/contractorMeterOneUserInformation', 'HomeController@room_417_store_user_information')->name('417_store_user_info')->middleware('verified');
    Route::get('/contractorMeterOneUserInformationEdit/{id}', 'HomeController@room_417_edit_user_information')->name('417_edit_user_info')->middleware('verified');
    Route::patch('/contractorMeterOneUserInformationUpdate', 'HomeController@room_417_update_user_information')->name('417_update_user_info')->middleware('verified');
    /* User NRC */
    Route::get('/contractorMeterOneUserNRC/{id}', 'HomeController@room_417_nrc_create')->name('417_nrc_create')->middleware('verified');
    Route::post('/contractorMeterOneUserNRC', 'HomeController@room_417_nrc_store')->name('417_store_nrc_create')->middleware('verified');
    Route::get('/contractorMeterOneUserNRCEdit/{id}', 'HomeController@room_417_nrc_edit')->name('417_nrc_edit')->middleware('verified');
    Route::patch('/contractorMeterOneUserNRCUpdate', 'HomeController@room_417_nrc_update')->name('417_nrc_update')->middleware('verified');
    /* User Form10 */
    Route::get('/contractorMeterOneUserForm10/{id}', 'HomeController@room_417_form10_create')->name('417_form10_create')->middleware('verified');
    Route::post('/contractorMeterOneUserForm10', 'HomeController@room_417_form10_store')->name('417_form10_store')->middleware('verified');
    Route::get('/contractorMeterOneUserForm10Edit/{id}', 'HomeController@room_417_form10_edit')->name('417_form10_edit')->middleware('verified');
    Route::patch('/contractorMeterOneUserForm10Update', 'HomeController@room_417_form10_update')->name('417_form10_update')->middleware('verified');
    /* User Recommmanded Letter */
    Route::get('/contractorMeterOneRecommanded/{id}', 'HomeController@room_417_recomm_create')->name('417_recomm_create')->middleware('verified');
    Route::post('/contractorMeterOneRecommanded', 'HomeController@room_417_recomm_store')->name('417_recomm_store')->middleware('verified');
    Route::get('/contractorMeterOneRecommandedEdit/{id}', 'HomeController@room_417_recomm_edit')->name('417_recomm_edit')->middleware('verified');
    Route::patch('/contractorMeterOneRecommandedUpdate', 'HomeController@room_417_recomm_update')->name('417_recomm_update')->middleware('verified');
    /* User Owner Letter */
    Route::get('/contractorMeterOneUserOwnership/{id}', 'HomeController@room_417_owner_create')->name('417_owner_create')->middleware('verified');
    Route::post('/contractorMeterOneUserOwnership', 'HomeController@room_417_owner_store')->name('417_owner_store')->middleware('verified');
    Route::get('/contractorMeterOneUserOwnershipEdit/{id}', 'HomeController@room_417_owner_edit')->name('417_owner_edit')->middleware('verified');
    Route::patch('/contractorMeterOneUserOwnershipUpdate', 'HomeController@room_417_owner_update')->name('417_owner_update')->middleware('verified');
    /* User Building Permit Letter */
    Route::get('/contractorMeterOneUserConstructionPermit/{id}', 'HomeController@room_417_permit_create')->name('417_permit_create')->middleware('verified');
    Route::post('/contractorMeterOneUserConstructionPermit', 'HomeController@room_417_permit_store')->name('417_permit_store')->middleware('verified');
    Route::get('/contractorMeterOneUserConstructionPermitEdit/{id}', 'HomeController@room_417_permit_edit')->name('417_permit_edit')->middleware('verified');
    Route::patch('/contractorMeterOneUserConstructionPermitUpdate', 'HomeController@room_417_permit_update')->name('417_permit_update')->middleware('verified');
    /* User BCC Letter */
    Route::get('/contractorMeterOneUserResidentPermit/{id}', 'HomeController@room_417_bcc_create')->name('417_bcc_create')->middleware('verified');
    Route::post('/contractorMeterOneUserResidentPermit', 'HomeController@room_417_bcc_store')->name('417_bcc_store')->middleware('verified');
    Route::get('/contractorMeterOneUserResidentPermitEdit/{id}', 'HomeController@room_417_bcc_edit')->name('417_bcc_edit')->middleware('verified');
    Route::patch('/contractorMeterOneUserResidentPermitUpdate', 'HomeController@room_417_bcc_update')->name('417_bcc_update')->middleware('verified');
    /* User DC Recomm Letter */
    Route::get('/contractorMeterOneUserDCRecommanded/{id}', 'HomeController@room_417_dc_recomm_create')->name('417_dc_recomm_create')->middleware('verified');
    Route::post('/contractorMeterOneUserDCRecommanded', 'HomeController@room_417_dc_recomm_store')->name('417_dc_recomm_store')->middleware('verified');
    Route::get('/contractorMeterOneUserDCRecommandedEdit/{id}', 'HomeController@room_417_dc_recomm_edit')->name('417_dc_recomm_edit')->middleware('verified');
    Route::patch('/contractorMeterOneUserDCRecommandedUpdate', 'HomeController@room_417_dc_recomm_update')->name('417_dc_recomm_update')->middleware('verified');
    /* User Previous Bill */
    Route::get('/contractorMeterOneUserMeterBill/{id}', 'HomeController@room_417_bill_create')->name('417_bill_create')->middleware('verified');
    Route::post('/contractorMeterOneUserMeterBill', 'HomeController@room_417_bill_store')->name('417_bill_store')->middleware('verified');
    Route::get('/contractorMeterOneUserMeterBillEdit/{id}', 'HomeController@room_417_bill_edit')->name('417_bill_edit')->middleware('verified');
    Route::patch('/contractorMeterOneUserMeterBillUpdate', 'HomeController@room_417_bill_update')->name('417_bill_update')->middleware('verified');
    /* 18 and over rooms */
    /* User Info */
    Route::get('/contractorMeterTwoUserInformation/{id}', 'HomeController@room_18_user_information')->name('18_user_info')->middleware('verified');
    Route::post('/contractorMeterTwoUserInformation', 'HomeController@room_18_store_user_information')->name('18_store_user_info')->middleware('verified');
    Route::get('/contractorMeterTwoUserInformationEdit/{id}', 'HomeController@room_18_edit_user_information')->name('18_edit_user_info')->middleware('verified');
    Route::patch('/contractorMeterTwoUserInformationUpdate', 'HomeController@room_18_update_user_information')->name('18_update_user_info')->middleware('verified');
    /* User NRC */
    Route::get('/contractorMeterTwoUserNRC/{id}', 'HomeController@room_18_nrc_create')->name('18_nrc_create')->middleware('verified');
    Route::post('/contractorMeterTwoUserNRC', 'HomeController@room_18_nrc_store')->name('18_store_nrc_create')->middleware('verified');
    Route::get('/contractorMeterTwoUserNRCEdit/{id}', 'HomeController@room_18_nrc_edit')->name('18_nrc_edit')->middleware('verified');
    Route::patch('/contractorMeterTwoUserNRCUpdate', 'HomeController@room_18_nrc_update')->name('18_nrc_update')->middleware('verified');
    /* User Form10 */
    Route::get('/contractorMeterTwoUserForm10/{id}', 'HomeController@room_18_form10_create')->name('18_form10_create')->middleware('verified');
    Route::post('/contractorMeterTwoUserForm10', 'HomeController@room_18_form10_store')->name('18_form10_store')->middleware('verified');
    Route::get('/contractorMeterTwoUserForm10Edit/{id}', 'HomeController@room_18_form10_edit')->name('18_form10_edit')->middleware('verified');
    Route::patch('/contractorMeterTwoUserForm10Update', 'HomeController@room_18_form10_update')->name('18_form10_update')->middleware('verified');
    /* User Recommmanded Letter */
    Route::get('/contractorMeterTwoRecommanded/{id}', 'HomeController@room_18_recomm_create')->name('18_recomm_create')->middleware('verified');
    Route::post('/contractorMeterTwoRecommanded', 'HomeController@room_18_recomm_store')->name('18_recomm_store')->middleware('verified');
    Route::get('/contractorMeterTwoRecommandedEdit/{id}', 'HomeController@room_18_recomm_edit')->name('18_recomm_edit')->middleware('verified');
    Route::patch('/contractorMeterTwoRecommandedUpdate', 'HomeController@room_18_recomm_update')->name('18_recomm_update')->middleware('verified');
    /* User Owner Letter */
    Route::get('/contractorMeterTwoUserOwnership/{id}', 'HomeController@room_18_owner_create')->name('18_owner_create')->middleware('verified');
    Route::post('/contractorMeterTwoUserOwnership', 'HomeController@room_18_owner_store')->name('18_owner_store')->middleware('verified');
    Route::get('/contractorMeterTwoUserOwnershipEdit/{id}', 'HomeController@room_18_owner_edit')->name('18_owner_edit')->middleware('verified');
    Route::patch('/contractorMeterTwoUserOwnershipUpdate', 'HomeController@room_18_owner_update')->name('18_owner_update')->middleware('verified');
    /* User Building Permit Letter */
    Route::get('/contractorMeterTwoUserConstructionPermit/{id}', 'HomeController@room_18_permit_create')->name('18_permit_create')->middleware('verified');
    Route::post('/contractorMeterTwoUserConstructionPermit', 'HomeController@room_18_permit_store')->name('18_permit_store')->middleware('verified');
    Route::get('/contractorMeterTwoUserConstructionPermitEdit/{id}', 'HomeController@room_18_permit_edit')->name('18_permit_edit')->middleware('verified');
    Route::patch('/contractorMeterTwoUserConstructionPermitUpdate', 'HomeController@room_18_permit_update')->name('18_permit_update')->middleware('verified');
    /* User BCC Letter */
    Route::get('/contractorMeterTwoUserResidentPermit/{id}', 'HomeController@room_18_bcc_create')->name('18_bcc_create')->middleware('verified');
    Route::post('/contractorMeterTwoUserResidentPermit', 'HomeController@room_18_bcc_store')->name('18_bcc_store')->middleware('verified');
    Route::get('/contractorMeterTwoUserResidentPermitEdit/{id}', 'HomeController@room_18_bcc_edit')->name('18_bcc_edit')->middleware('verified');
    Route::patch('/contractorMeterTwoUserResidentPermitUpdate', 'HomeController@room_18_bcc_update')->name('18_bcc_update')->middleware('verified');
    /* User DC Recomm Letter */
    Route::get('/contractorMeterTwoUserDCRecommanded/{id}', 'HomeController@room_18_dc_recomm_create')->name('18_dc_recomm_create')->middleware('verified');
    Route::post('/contractorMeterTwoUserDCRecommanded', 'HomeController@room_18_dc_recomm_store')->name('18_dc_recomm_store')->middleware('verified');
    Route::get('/contractorMeterTwoUserDCRecommandedEdit/{id}', 'HomeController@room_18_dc_recomm_edit')->name('18_dc_recomm_edit')->middleware('verified');
    Route::patch('/contractorMeterTwoUserDCRecommandedUpdate', 'HomeController@room_18_dc_recomm_update')->name('18_dc_recomm_update')->middleware('verified');
    /* User Previous Bill */
    Route::get('/contractorMeterTwoUserMeterBill/{id}', 'HomeController@room_18_bill_create')->name('18_bill_create')->middleware('verified');
    Route::post('/contractorMeterTwoUserMeterBill', 'HomeController@room_18_bill_store')->name('18_bill_store')->middleware('verified');
    Route::get('/contractorMeterTwoUserMeterBillEdit/{id}', 'HomeController@room_18_bill_edit')->name('18_bill_edit')->middleware('verified');
    Route::patch('/contractorMeterTwoUserMeterBillUpdate', 'HomeController@room_18_bill_update')->name('18_bill_update')->middleware('verified');

    Route::get('/contractorMeterAppliedForm/{id}', 'HomeController@contractor_show')->name('contractor_applied_form')->middleware('verified');
    /* ================================================== End Contractor Merter ===================================================== */
    
    /* ================================================== Start Transformer Meter ================================================== */
    /* Reisdential Meter Type */
    Route::get('/transformerRuleAndRegulation', 'HomeController@transformer_rule_regulation')->name('tsf_rule_regulation')->middleware('verified');
    Route::get('/transformerAgreement', 'HomeController@transformer_agreement')->name('tsf_agreement')->middleware('verified');
    Route::get('/transformerAgreementOne', 'HomeController@transformer_agreement_one')->name('tsf_agreement_one')->middleware('verified');
    /* Reisdential Meter Type */
    Route::get('/transformerType', 'HomeController@transformer_select_meter_type')->name('tsf_meter_type')->middleware('verified');
    Route::post('/transformerType', 'HomeController@transformer_store_meter_type')->name('tsf_store_meter_type')->middleware('verified');
    Route::get('/transformerTypeEdit/{id}', 'HomeController@transformer_edit_meter_type')->name('tsf_edit_meter_type')->middleware('verified');
    Route::patch('/transformerTypeUpdate', 'HomeController@transformer_update_meter_type')->name('tsf_update_meter_type')->middleware('verified');
    /* User Info */
    Route::get('/transformerApplicantInfo/{id}', 'HomeController@transformer_user_information')->name('tsf_user_info')->middleware('verified');
    Route::post('/transformerApplicantInfo', 'HomeController@transformer_store_user_information')->name('tsf_store_user_info')->middleware('verified');
    Route::get('/transformerApplicantInfoEdit/{id}', 'HomeController@transformer_edit_user_information')->name('tsf_edit_user_info')->middleware('verified');
    Route::patch('/transformerApplicantInfoUpdate', 'HomeController@transformer_update_user_information')->name('tsf_update_user_info')->middleware('verified');
    /* User NRC */
    Route::get('/transformerApplicantNRC/{id}', 'HomeController@transformer_nrc_create')->name('tsf_nrc_create')->middleware('verified');
    Route::post('/transformerApplicantNRC', 'HomeController@transformer_nrc_store')->name('tsf_nrc_store')->middleware('verified');
    Route::get('/transformerApplicantNRCEdit/{id}', 'HomeController@transformer_nrc_edit')->name('tsf_nrc_edit')->middleware('verified');
    Route::patch('/transformerApplicantNRCUpdate', 'HomeController@transformer_nrc_update')->name('tsf_nrc_update')->middleware('verified');
    /* User Form10 */
    Route::get('/transformerApplicantForm10/{id}', 'HomeController@transformer_form10_create')->name('tsf_form10_create')->middleware('verified');
    Route::post('/transformerApplicantForm10', 'HomeController@transformer_form10_store')->name('tsf_form10_store')->middleware('verified');
    Route::get('/transformerApplicantForm10Edit/{id}', 'HomeController@transformer_form10_edit')->name('tsf_form10_edit')->middleware('verified');
    Route::patch('/transformerApplicantForm10Update', 'HomeController@transformer_form10_update')->name('tsf_form10_update')->middleware('verified');
    /* User Recommmanded Letter */
    Route::get('/transformerApplicantRecommanded/{id}', 'HomeController@transformer_recomm_create')->name('tsf_recomm_create')->middleware('verified');
    Route::post('/transformerApplicantRecommanded', 'HomeController@transformer_recomm_store')->name('tsf_recomm_store')->middleware('verified');
    Route::get('/transformerApplicantRecommandedEdit/{id}', 'HomeController@transformer_recomm_edit')->name('tsf_recomm_edit')->middleware('verified');
    Route::patch('/transformerApplicantRecommandedUpdate', 'HomeController@transformer_recomm_update')->name('tsf_recomm_update')->middleware('verified');
    /* User Ownership */
    Route::get('/transformerApplicantOwnership/{id}', 'HomeController@transformer_owner_create')->name('tsf_owner_create')->middleware('verified');
    Route::post('/transformerApplicantOwnership', 'HomeController@transformer_owner_store')->name('tsf_owner_store')->middleware('verified');
    Route::get('/transformerApplicantOwnershipEdit/{id}', 'HomeController@transformer_owner_edit')->name('tsf_owner_edit')->middleware('verified');
    Route::patch('/transformerApplicantOwnershipUpdate', 'HomeController@transformer_owner_update')->name('tsf_owner_update')->middleware('verified');
    /* Use Work Licence */
    Route::get('/transformerWorkLicence/{id}', 'HomeController@transformer_worklicence_create')->name('tsf_worklicence_create')->middleware('verified');
    Route::post('/transformerWorkLicence', 'HomeController@transformer_worklicence_store')->name('tsf_worklicence_store')->middleware('verified');
    Route::get('/transformerWorkLicenceEdit/{id}', 'HomeController@transformer_worklicence_edit')->name('tsf_worklicence_edit')->middleware('verified');
    Route::patch('/transformerWorkLicenceUpdate', 'HomeController@transformer_worklicence_update')->name('tsf_worklicence_update')->middleware('verified');
    /* Use Electric Power */
    Route::get('/transformerUseElectricPower/{id}', 'HomeController@transformer_electricpower_create')->name('tsf_electricpower_create')->middleware('verified');
    Route::post('/transformerUseElectricPower', 'HomeController@transformer_electricpower_store')->name('tsf_electricpower_store')->middleware('verified');
    Route::get('/transformerUseElectricPowerEdit/{id}', 'HomeController@transformer_electricpower_edit')->name('tsf_electricpower_edit')->middleware('verified');
    Route::patch('/transformerUseElectricPowerUpdate', 'HomeController@transformer_electricpower_update')->name('tsf_electricpower_update')->middleware('verified');
    /* User Applied Form View */
    Route::get('/transformerAppliedForm/{id}', 'HomeController@transformer_show')->name('tsf_applied_form')->middleware('verified');
    
    /* ======================================================================================================================================= */
    /* =============================================================== Yangon =============================================================== */
    /* ======================================================================================================================================= */
    /* ================================================== Start Residential Meter ================================================== */
    /* Rule and Regulation */
    Route::get('/residentialMeterYangonRuleAndRegulation', 'HomeController@ygn_residential_rule_regulation')->name('resident_rule_regulation_ygn')->middleware('verified');
    Route::get('/residentialMeterYangonType', 'HomeController@ygn_residential_select_meter_type')->name('resident_meter_type_ygn')->middleware('verified');
    Route::post('/residentialMeterYangonType', 'HomeController@ygn_residential_store_meter_type')->name('resident_store_meter_type_ygn')->middleware('verified');
    Route::get('/residentialMeterYangonTypeEdit/{id}', 'HomeController@ygn_residential_edit_meter_type')->name('resident_edit_meter_type_ygn')->middleware('verified');
    Route::patch('/residentialMeterYangonTypeUpdate', 'HomeController@ygn_residential_update_meter_type')->name('resident_update_meter_type_ygn')->middleware('verified');
    /* User Info */
    Route::get('/residentialMeterYangonApplicantInfo/{id}', 'HomeController@ygn_residential_user_information')->name('resident_user_info_ygn')->middleware('verified');
    Route::post('/residentialMeterYangonApplicantInfo', 'HomeController@ygn_residential_store_user_information')->name('resident_store_user_info_ygn')->middleware('verified');
    Route::get('/residentialMeterYangonApplicantInfoEdit/{id}', 'HomeController@ygn_residential_edit_user_information')->name('resident_edit_user_info_ygn')->middleware('verified');
    Route::patch('/residentialMeterYangonApplicantInfoUpdate', 'HomeController@ygn_residential_update_user_information')->name('resident_update_user_info_ygn')->middleware('verified');
    /* User NRC */
    Route::get('/residentialMeterYangonApplicantNRC/{id}', 'HomeController@ygn_residential_nrc_create')->name('resident_nrc_create_ygn')->middleware('verified');
    Route::post('/residentialMeterYangonApplicantNRC', 'HomeController@ygn_residential_nrc_store')->name('resident_nrc_store_ygn')->middleware('verified');
    Route::get('/residentialMeterYangonApplicantNRCEdit/{id}', 'HomeController@ygn_residential_nrc_edit')->name('resident_nrc_edit_ygn')->middleware('verified');
    Route::patch('/residentialMeterYangonApplicantNRCUpdate', 'HomeController@ygn_residential_nrc_update')->name('resident_nrc_update_ygn')->middleware('verified');
    /* User Form10 */
    Route::get('/residentialMeterYangonApplicantForm10/{id}', 'HomeController@ygn_residential_form10_create')->name('resident_form10_create_ygn')->middleware('verified');
    Route::post('/residentialMeterYangonApplicantForm10', 'HomeController@ygn_residential_form10_store')->name('resident_form10_store_ygn')->middleware('verified');
    Route::get('/residentialMeterYangonApplicantForm10Edit/{id}', 'HomeController@ygn_residential_form10_edit')->name('resident_form10_edit_ygn')->middleware('verified');
    Route::patch('/residentialMeterYangonApplicantForm10Update', 'HomeController@ygn_residential_form10_update')->name('resident_form10_update_ygn')->middleware('verified');
    /* User Recommmanded Letter */
    Route::get('/residentialMeterYangonApplicantRecommanded/{id}', 'HomeController@ygn_residential_recomm_create')->name('resident_recomm_create_ygn')->middleware('verified');
    Route::post('/residentialMeterYangonApplicantRecommanded', 'HomeController@ygn_residential_recomm_store')->name('resident_recomm_store_ygn')->middleware('verified');
    Route::get('/residentialMeterYangonApplicantRecommandedEdit/{id}', 'HomeController@ygn_residential_recomm_edit')->name('resident_recomm_edit_ygn')->middleware('verified');
    Route::patch('/residentialMeterYangonApplicantRecommandedUpdate', 'HomeController@ygn_residential_recomm_update')->name('resident_recomm_update_ygn')->middleware('verified');
    /* User Ownership */
    Route::get('/residentialMeterYangonApplicantOwnership/{id}', 'HomeController@ygn_residential_owner_create')->name('resident_owner_create_ygn')->middleware('verified');
    Route::post('/residentialMeterYangonApplicantOwnership', 'HomeController@ygn_residential_owner_store')->name('resident_owner_store_ygn')->middleware('verified');
    Route::get('/residentialMeterYangonApplicantOwnershipEdit/{id}', 'HomeController@ygn_residential_owner_edit')->name('resident_owner_edit_ygn')->middleware('verified');
    Route::patch('/residentialMeterYangonApplicantOwnershipUpdate', 'HomeController@ygn_residential_owner_update')->name('resident_owner_update_ygn')->middleware('verified');
    /* User Applied Form View */
    Route::get('/residentialMeterYangonAppliedForm/{id}', 'HomeController@ygn_residential_show')->name('resident_applied_form_ygn')->middleware('verified');
    /* ================================================== Start Residential Power Meter ================================================== */

    /* ================================================== Start Residential Power Meter For Yangon ================================================== */
    Route::get('/residentialPowerMeterYangonRuleAndRegulation', 'HomeController@ygn_residential_power_rule_regulation')->name('resident_power_rule_regulation_ygn')->middleware('verified');
    /* Reisdential Power Meter Type */
    Route::get('/residentialPowerMeterYangonType', 'HomeController@ygn_residential_power_select_meter_type')->name('resident_power_meter_type_ygn')->middleware('verified');
    Route::post('/residentialPowerMeterYangonType', 'HomeController@ygn_residential_power_store_meter_type')->name('resident_power_store_meter_type_ygn')->middleware('verified');
    Route::get('/residentialPowerMeterYangonTypeEdit/{id}', 'HomeController@ygn_residential_power_edit_meter_type')->name('resident_power_edit_meter_type_ygn')->middleware('verified');
    Route::patch('/residentialPowerMeterYangonTypeUpdate', 'HomeController@ygn_residential_power_update_meter_type')->name('resident_power_update_meter_type_ygn')->middleware('verified');
    /* User Info */
    Route::get('/residentialPowerMeterYangonApplicantInfo/{id}', 'HomeController@ygn_residential_power_user_information')->name('resident_power_user_info_ygn')->middleware('verified');
    Route::post('/residentialPowerMeterYangonApplicantInfo', 'HomeController@ygn_residential_power_store_user_information')->name('resident_power_store_user_info_ygn')->middleware('verified');
    Route::get('/residentialPowerMeterYangonApplicantInfoEdit/{id}', 'HomeController@ygn_residential_power_edit_user_information')->name('resident_power_edit_user_info_ygn')->middleware('verified');
    Route::patch('/residentialPowerMeterYangonApplicantInfoUpdate', 'HomeController@ygn_residential_power_update_user_information')->name('resident_power_update_user_info_ygn')->middleware('verified');
    /* User NRC */
    Route::get('/residentialPowerMeterYangonApplicantNRC/{id}', 'HomeController@ygn_residential_power_nrc_create')->name('resident_power_nrc_create_ygn')->middleware('verified');
    Route::post('/residentialPowerMeterYangonApplicantNRC', 'HomeController@ygn_residential_power_nrc_store')->name('resident_power_nrc_store_ygn')->middleware('verified');
    Route::get('/residentialPowerMeterYangonApplicantNRCEdit/{id}', 'HomeController@ygn_residential_power_nrc_edit')->name('resident_power_nrc_edit_ygn')->middleware('verified');
    Route::patch('/residentialPowerMeterYangonApplicantNRCUpdate', 'HomeController@ygn_residential_power_nrc_update')->name('resident_power_nrc_update_ygn')->middleware('verified');
    /* User Form10 */
    Route::get('/residentialPowerMeterYangonApplicantForm10/{id}', 'HomeController@ygn_residential_power_form10_create')->name('resident_power_form10_create_ygn')->middleware('verified');
    Route::post('/residentialPowerMeterYangonApplicantForm10', 'HomeController@ygn_residential_power_form10_store')->name('resident_power_form10_store_ygn')->middleware('verified');
    Route::get('/residentialPowerMeterYangonApplicantForm10Edit/{id}', 'HomeController@ygn_residential_power_form10_edit')->name('resident_power_form10_edit_ygn')->middleware('verified');
    Route::patch('/residentialPowerMeterYangonApplicantForm10Update', 'HomeController@ygn_residential_power_form10_update')->name('resident_power_form10_update_ygn')->middleware('verified');
    /* User Recommmanded Letter */
    Route::get('/residentialPowerMeterYangonApplicantRecommanded/{id}', 'HomeController@ygn_residential_power_recomm_create')->name('resident_power_recomm_create_ygn')->middleware('verified');
    Route::post('/residentialPowerMeterYangonApplicantRecommanded', 'HomeController@ygn_residential_power_recomm_store')->name('resident_power_recomm_store_ygn')->middleware('verified');
    Route::get('/residentialPowerMeterYangonApplicantRecommandedEdit/{id}', 'HomeController@ygn_residential_power_recomm_edit')->name('resident_power_recomm_edit_ygn')->middleware('verified');
    Route::patch('/residentialPowerMeterYangonApplicantRecommandedUpdate', 'HomeController@ygn_residential_power_recomm_update')->name('resident_power_recomm_update_ygn')->middleware('verified');
    /* User Ownership */
    Route::get('/residentialPowerMeterYangonApplicantOwnership/{id}', 'HomeController@ygn_residential_power_owner_create')->name('resident_power_owner_create_ygn')->middleware('verified');
    Route::post('/residentialPowerMeterYangonApplicantOwnership', 'HomeController@ygn_residential_power_owner_store')->name('resident_power_owner_store_ygn')->middleware('verified');
    Route::get('/residentialPowerMeterYangonApplicantOwnershipEdit/{id}', 'HomeController@ygn_residential_power_owner_edit')->name('resident_power_owner_edit_ygn')->middleware('verified');
    Route::patch('/residentialPowerMeterYangonApplicantOwnershipUpdate', 'HomeController@ygn_residential_power_owner_update')->name('resident_power_owner_update_ygn')->middleware('verified');
    /* Use Electric Power */
    Route::get('/residentialPowerMeterYangonUseElectricPower/{id}', 'HomeController@ygn_residential_power_electricpower_create')->name('resident_power_electricpower_create_ygn')->middleware('verified');
    Route::post('/residentialPowerMeterYangonUseElectricPower', 'HomeController@ygn_residential_power_electricpower_store')->name('resident_power_electricpower_store_ygn')->middleware('verified');
    Route::get('/residentialPowerMeterYangonUseElectricPowerEdit/{id}', 'HomeController@ygn_residential_power_electricpower_edit')->name('resident_power_electricpower_edit_ygn')->middleware('verified');
    Route::patch('/residentialPowerMeterYangonUseElectricPowerUpdate', 'HomeController@ygn_residential_power_electricpower_update')->name('resident_power_electricpower_update_ygn')->middleware('verified');
    /* User Applied Form View */
    Route::get('/residentialPowerMeterYangonAppliedForm/{id}', 'HomeController@ygn_residential_power_show')->name('resident_power_applied_form_ygn')->middleware('verified');
    /* ================================================== End Residential Power Meter For Yangon ================================================== */

    /* ================================================== Start Commercial Power Merter For Yangon ================================================== */
    /* Rule and Regulation */
    Route::get('/commercialPowerMeterYangonRuleAndRegulation', 'HomeController@ygn_commercial_rule_regulation')->name('commercial_rule_regulation_ygn')->middleware('verified');
    /* Reisdential Meter Type */
    Route::get('/commercialPowerMeterYangonType', 'HomeController@ygn_commercial_select_meter_type')->name('commercial_meter_type_ygn')->middleware('verified');
    Route::post('/commercialPowerMeterYangonType', 'HomeController@ygn_commercial_store_meter_type')->name('commercial_store_meter_type_ygn')->middleware('verified');
    Route::get('/commercialPowerMeterYangonTypeEdit/{id}', 'HomeController@ygn_commercial_edit_meter_type')->name('commercial_edit_meter_type_ygn')->middleware('verified');
    Route::patch('/commercialPowerMeterYangonTypeUpdate', 'HomeController@ygn_commercial_update_meter_type')->name('commercial_update_meter_type_ygn')->middleware('verified');
    /* User Info */
    Route::get('/commercialPowerMeterYangonApplicantInfo/{id}', 'HomeController@ygn_commercial_user_information')->name('commercial_user_info_ygn')->middleware('verified');
    Route::post('/commercialPowerMeterYangonApplicantInfo', 'HomeController@ygn_commercial_store_user_information')->name('commercial_store_user_info_ygn')->middleware('verified');
    Route::get('/commercialPowerMeterYangonApplicantInfoEdit/{id}', 'HomeController@ygn_commercial_edit_user_information')->name('commercial_edit_user_info_ygn')->middleware('verified');
    Route::patch('/commercialPowerMeterYangonApplicantInfoUpdate', 'HomeController@ygn_commercial_update_user_information')->name('commercial_update_user_info_ygn')->middleware('verified');
    /* User NRC */
    Route::get('/commercialPowerMeterYangonApplicantNRC/{id}', 'HomeController@ygn_commercial_nrc_create')->name('commercial_nrc_create_ygn')->middleware('verified');
    Route::post('/commercialPowerMeterYangonApplicantNRC', 'HomeController@ygn_commercial_nrc_store')->name('commercial_nrc_store_ygn')->middleware('verified');
    Route::get('/commercialPowerMeterYangonApplicantNRCEdit/{id}', 'HomeController@ygn_commercial_nrc_edit')->name('commercial_nrc_edit_ygn')->middleware('verified');
    Route::patch('/commercialPowerMeterYangonApplicantNRCUpdate', 'HomeController@ygn_commercial_nrc_update')->name('commercial_nrc_update_ygn')->middleware('verified');
    /* User Form10 */
    Route::get('/commercialPowerMeterYangonApplicantForm10/{id}', 'HomeController@ygn_commercial_form10_create')->name('commercial_form10_create_ygn')->middleware('verified');
    Route::post('/commercialPowerMeterYangonApplicantForm10', 'HomeController@ygn_commercial_form10_store')->name('commercial_form10_store_ygn')->middleware('verified');
    Route::get('/commercialPowerMeterYangonApplicantForm10Edit/{id}', 'HomeController@ygn_commercial_form10_edit')->name('commercial_form10_edit_ygn')->middleware('verified');
    Route::patch('/commercialPowerMeterYangonApplicantForm10Update', 'HomeController@ygn_commercial_form10_update')->name('commercial_form10_update_ygn')->middleware('verified');
    /* User Recommmanded Letter */
    Route::get('/commercialPowerMeterYangonApplicantRecommanded/{id}', 'HomeController@ygn_commercial_recomm_create')->name('commercial_recomm_create_ygn')->middleware('verified');
    Route::post('/commercialPowerMeterYangonApplicantRecommanded', 'HomeController@ygn_commercial_recomm_store')->name('commercial_recomm_store_ygn')->middleware('verified');
    Route::get('/commercialPowerMeterYangonApplicantRecommandedEdit/{id}', 'HomeController@ygn_commercial_recomm_edit')->name('commercial_recomm_edit_ygn')->middleware('verified');
    Route::patch('/commercialPowerMeterYangonApplicantRecommandedUpdate', 'HomeController@ygn_commercial_recomm_update')->name('commercial_recomm_update_ygn')->middleware('verified');
    /* User Ownership */
    Route::get('/commercialPowerMeterYangonApplicantOwnership/{id}', 'HomeController@ygn_commercial_owner_create')->name('commercial_owner_create_ygn')->middleware('verified');
    Route::post('/commercialPowerMeterYangonApplicantOwnership', 'HomeController@ygn_commercial_owner_store')->name('commercial_owner_store_ygn')->middleware('verified');
    Route::get('/commercialPowerMeterYangonApplicantOwnershipEdit/{id}', 'HomeController@ygn_commercial_owner_edit')->name('commercial_owner_edit_ygn')->middleware('verified');
    Route::patch('/commercialPowerMeterYangonApplicantOwnershipUpdate', 'HomeController@ygn_commercial_owner_update')->name('commercial_owner_update_ygn')->middleware('verified');
    /* Use Work Licence */
    Route::get('/commercialPowerMeterYangonWorkLicence/{id}', 'HomeController@ygn_commercial_worklicence_create')->name('commercial_worklicence_create_ygn')->middleware('verified');
    Route::post('/commercialPowerMeterYangonWorkLicence', 'HomeController@ygn_commercial_worklicence_store')->name('commercial_worklicence_store_ygn')->middleware('verified');
    Route::get('/commercialPowerMeterYangonWorkLicenceEdit/{id}', 'HomeController@ygn_commercial_worklicence_edit')->name('commercial_worklicence_edit_ygn')->middleware('verified');
    Route::patch('/commercialPowerMeterYangonWorkLicenceUpdate', 'HomeController@ygn_commercial_worklicence_update')->name('commercial_worklicence_update_ygn')->middleware('verified');
    /* Use Electric Power */
    Route::get('/commercialPowerMeterYangonUseElectricPower/{id}', 'HomeController@ygn_commercial_electricpower_create')->name('commercial_electricpower_create_ygn')->middleware('verified');
    Route::post('/commercialPowerMeterYangonUseElectricPower', 'HomeController@ygn_commercial_electricpower_store')->name('commercial_electricpower_store_ygn')->middleware('verified');
    Route::get('/commercialPowerMeterYangonUseElectricPowerEdit/{id}', 'HomeController@ygn_commercial_electricpower_edit')->name('commercial_electricpower_edit_ygn')->middleware('verified');
    Route::patch('/commercialPowerMeterYangonUseElectricPowerUpdate', 'HomeController@ygn_commercial_electricpower_update')->name('commercial_electricpower_update_ygn')->middleware('verified');
    /* User Applied Form View */
    Route::get('/commercialPowerMeterYangonAppliedForm/{id}', 'HomeController@ygn_commercial_show')->name('commercial_applied_form_ygn')->middleware('verified');
    /* User Send Form to Office */
  /* ================================================== End Commercial Power Merter  For Yangon================================================== */

    /* ================================================== Start Contractor Merter ================================================== */
    /* Rule and Regulation */
    Route::get('/contractorYangonRuleAndRegulation', 'HomeController@ygn_contractor_rule_regulation')->name('contract_rule_regulation_ygn')->middleware('verified');
    /* Choose buildings ==> 4-17 and 18andOver */
    Route::get('/contractorYangonBuildingRoom', 'HomeController@ygn_contractor_building_room')->name('contract_building_room_ygn')->middleware('verified');

    Route::get('/contractorYangonBuildingRoomEdit/{id}', 'HomeController@ygn_contractor_building_room_edit')->name('contract_building_room_edit_ygn')->middleware('verified');
    Route::patch('/contractorYangonBuildingRoomUpdate', 'HomeController@ygn_contractor_building_update')->name('contract_building_room_update_ygn')->middleware('verified');


    Route::post('/contractorYangonChooseBuilding', 'HomeController@ygn_contractor_building')->name('contractor_choose_form_ygn')->middleware('verified');
    Route::post('/contractorYangonChooseBuilding18Under', 'HomeController@ygn_contractor_building_4_17')->name('contractor_choose_4_17_ygn')->middleware('verified');
    Route::post('/contractorYangonChooseBuilding18Over', 'HomeController@ygn_contractor_building_18')->name('contractor_choose_18_ygn')->middleware('verified');
    /* 4-17 rooms */
    /* User Info */
    Route::get('/contractorMeterYangonUserInformation/{id}', 'HomeController@ygn_room_417_user_information')->name('417_user_info_ygn')->middleware('verified');
    Route::post('/contractorMeterYangonUserInformation', 'HomeController@ygn_room_417_store_user_information')->name('417_store_user_info_ygn')->middleware('verified');
    Route::get('/contractorMeterYangonUserInformationEdit/{id}', 'HomeController@ygn_room_417_edit_user_information')->name('417_edit_user_info_ygn')->middleware('verified');
    Route::patch('/contractorMeterYangonUserInformationUpdate', 'HomeController@ygn_room_417_update_user_information')->name('417_update_user_info_ygn')->middleware('verified');
    /* User NRC */
    Route::get('/contractorMeterYangonUserNRC/{id}', 'HomeController@ygn_room_417_nrc_create')->name('417_nrc_create_ygn')->middleware('verified');
    Route::post('/contractorMeterYangonUserNRC', 'HomeController@ygn_room_417_nrc_store')->name('417_store_nrc_create_ygn')->middleware('verified');
    Route::get('/contractorMeterYangonUserNRCEdit/{id}', 'HomeController@ygn_room_417_nrc_edit')->name('417_nrc_edit_ygn')->middleware('verified');
    Route::patch('/contractorMeterYangonUserNRCUpdate', 'HomeController@ygn_room_417_nrc_update')->name('417_nrc_update_ygn')->middleware('verified');
    /* User Form10 */
    Route::get('/contractorMeterYangonUserForm10/{id}', 'HomeController@ygn_room_417_form10_create')->name('417_form10_create_ygn')->middleware('verified');
    Route::post('/contractorMeterYangonUserForm10', 'HomeController@ygn_room_417_form10_store')->name('417_form10_store_ygn')->middleware('verified');
    Route::get('/contractorMeterYangonUserForm10Edit/{id}', 'HomeController@ygn_room_417_form10_edit')->name('417_form10_edit_ygn')->middleware('verified');
    Route::patch('/contractorMeterYangonUserForm10Update', 'HomeController@ygn_room_417_form10_update')->name('417_form10_update_ygn')->middleware('verified');
    /* User Recommmanded Letter */
    Route::get('/contractorMeterYangonRecommanded/{id}', 'HomeController@ygn_room_417_recomm_create')->name('417_recomm_create_ygn')->middleware('verified');
    Route::post('/contractorMeterYangonRecommanded', 'HomeController@ygn_room_417_recomm_store')->name('417_recomm_store_ygn')->middleware('verified');
    Route::get('/contractorMeterYangonRecommandedEdit/{id}', 'HomeController@ygn_room_417_recomm_edit')->name('417_recomm_edit_ygn')->middleware('verified');
    Route::patch('/contractorMeterYangonRecommandedUpdate', 'HomeController@ygn_room_417_recomm_update')->name('417_recomm_update_ygn')->middleware('verified');
    /* User Owner Letter */
    Route::get('/contractorMeterYangonUserOwnership/{id}', 'HomeController@ygn_room_417_owner_create')->name('417_owner_create_ygn')->middleware('verified');
    Route::post('/contractorMeterYangonUserOwnership', 'HomeController@ygn_room_417_owner_store')->name('417_owner_store_ygn')->middleware('verified');
    Route::get('/contractorMeterYangonUserOwnershipEdit/{id}', 'HomeController@ygn_room_417_owner_edit')->name('417_owner_edit_ygn')->middleware('verified');
    Route::patch('/contractorMeterYangonUserOwnershipUpdate', 'HomeController@ygn_room_417_owner_update')->name('417_owner_update_ygn')->middleware('verified');
    /* User Building Permit Letter */
    Route::get('/contractorMeterYangonUserConstructionPermit/{id}', 'HomeController@ygn_room_417_permit_create')->name('417_permit_create_ygn')->middleware('verified');
    Route::post('/contractorMeterYangonUserConstructionPermit', 'HomeController@ygn_room_417_permit_store')->name('417_permit_store_ygn')->middleware('verified');
    Route::get('/contractorMeterYangonUserConstructionPermitEdit/{id}', 'HomeController@ygn_room_417_permit_edit')->name('417_permit_edit_ygn')->middleware('verified');
    Route::patch('/contractorMeterYangonUserConstructionPermitUpdate', 'HomeController@ygn_room_417_permit_update')->name('417_permit_update_ygn')->middleware('verified');
    /* User BCC Letter */
    Route::get('/contractorMeterYangonUserResidentPermit/{id}', 'HomeController@ygn_room_417_bcc_create')->name('417_bcc_create_ygn')->middleware('verified');
    Route::post('/contractorMeterYangonUserResidentPermit', 'HomeController@ygn_room_417_bcc_store')->name('417_bcc_store_ygn')->middleware('verified');
    Route::get('/contractorMeterYangonUserResidentPermitEdit/{id}', 'HomeController@ygn_room_417_bcc_edit')->name('417_bcc_edit_ygn')->middleware('verified');
    Route::patch('/contractorMeterYangonUserResidentPermitUpdate', 'HomeController@ygn_room_417_bcc_update')->name('417_bcc_update_ygn')->middleware('verified');
    /* User DC Recomm Letter */
    Route::get('/contractorMeterYangonUserDCRecommanded/{id}', 'HomeController@ygn_room_417_dc_recomm_create')->name('417_dc_recomm_create_ygn')->middleware('verified');
    Route::post('/contractorMeterYangonUserDCRecommanded', 'HomeController@ygn_room_417_dc_recomm_store')->name('417_dc_recomm_store_ygn')->middleware('verified');
    Route::get('/contractorMeterYangonUserDCRecommandedEdit/{id}', 'HomeController@ygn_room_417_dc_recomm_edit')->name('417_dc_recomm_edit_ygn')->middleware('verified');
    Route::patch('/contractorMeterYangonUserDCRecommandedUpdate', 'HomeController@ygn_room_417_dc_recomm_update')->name('417_dc_recomm_update_ygn')->middleware('verified');
    /* User Previous Bill */
    Route::get('/contractorMeterYangonUserMeterBill/{id}', 'HomeController@ygn_room_417_bill_create')->name('417_bill_create_ygn')->middleware('verified');
    Route::post('/contractorMeterYangonUserMeterBill', 'HomeController@ygn_room_417_bill_store')->name('417_bill_store_ygn')->middleware('verified');
    Route::get('/contractorMeterYangonUserMeterBillEdit/{id}', 'HomeController@ygn_room_417_bill_edit')->name('417_bill_edit_ygn')->middleware('verified');
    Route::patch('/contractorMeterYangonUserMeterBillUpdate', 'HomeController@ygn_room_417_bill_update')->name('417_bill_update_ygn')->middleware('verified');
    /* 18 and over rooms */
    /* User Info */
    Route::get('/contractorMeterTwoYangonUserInformation/{id}', 'HomeController@ygn_room_18_user_information')->name('18_user_info_ygn')->middleware('verified');
    Route::post('/contractorMeterTwoYangonUserInformation', 'HomeController@ygn_room_18_store_user_information')->name('18_store_user_info_ygn')->middleware('verified');
    Route::get('/contractorMeterTwoYangonUserInformationEdit/{id}', 'HomeController@ygn_room_18_edit_user_information')->name('18_edit_user_info_ygn')->middleware('verified');
    Route::patch('/contractorMeterTwoYangonUserInformationUpdate', 'HomeController@ygn_room_18_update_user_information')->name('18_update_user_info_ygn')->middleware('verified');
    /* User NRC */
    Route::get('/contractorMeterTwoYangonUserNRC/{id}', 'HomeController@ygn_room_18_nrc_create')->name('18_nrc_create_ygn')->middleware('verified');
    Route::post('/contractorMeterTwoYangonUserNRC', 'HomeController@ygn_room_18_nrc_store')->name('18_store_nrc_create_ygn')->middleware('verified');
    Route::get('/contractorMeterTwoYangonUserNRCEdit/{id}', 'HomeController@ygn_room_18_nrc_edit')->name('18_nrc_edit_ygn')->middleware('verified');
    Route::patch('/contractorMeterTwoYangonUserNRCUpdate', 'HomeController@ygn_room_18_nrc_update')->name('18_nrc_update_ygn')->middleware('verified');
    /* User Form10 */
    Route::get('/contractorMeterTwoYangonUserForm10/{id}', 'HomeController@ygn_room_18_form10_create')->name('18_form10_create_ygn')->middleware('verified');
    Route::post('/contractorMeterTwoYangonUserForm10', 'HomeController@ygn_room_18_form10_store')->name('18_form10_store_ygn')->middleware('verified');
    Route::get('/contractorMeterTwoYangonUserForm10Edit/{id}', 'HomeController@ygn_room_18_form10_edit')->name('18_form10_edit_ygn')->middleware('verified');
    Route::patch('/contractorMeterTwoYangonUserForm10Update', 'HomeController@ygn_room_18_form10_update')->name('18_form10_update_ygn')->middleware('verified');
    /* User Recommmanded Letter */
    Route::get('/contractorMeterTwoYangonRecommanded/{id}', 'HomeController@ygn_room_18_recomm_create')->name('18_recomm_create_ygn')->middleware('verified');
    Route::post('/contractorMeterTwoYangonRecommanded', 'HomeController@ygn_room_18_recomm_store')->name('18_recomm_store_ygn')->middleware('verified');
    Route::get('/contractorMeterTwoYangonRecommandedEdit/{id}', 'HomeController@ygn_room_18_recomm_edit')->name('18_recomm_edit_ygn')->middleware('verified');
    Route::patch('/contractorMeterTwoYangonRecommandedUpdate', 'HomeController@ygn_room_18_recomm_update')->name('18_recomm_update_ygn')->middleware('verified');
    /* User Owner Letter */
    Route::get('/contractorMeterTwoYangonUserOwnership/{id}', 'HomeController@ygn_room_18_owner_create')->name('18_owner_create_ygn')->middleware('verified');
    Route::post('/contractorMeterTwoYangonUserOwnership', 'HomeController@ygn_room_18_owner_store')->name('18_owner_store_ygn')->middleware('verified');
    Route::get('/contractorMeterTwoYangonUserOwnershipEdit/{id}', 'HomeController@ygn_room_18_owner_edit')->name('18_owner_edit_ygn')->middleware('verified');
    Route::patch('/contractorMeterTwoYangonUserOwnershipUpdate', 'HomeController@ygn_room_18_owner_update')->name('18_owner_update_ygn')->middleware('verified');
    /* User Building Permit Letter */
    Route::get('/contractorMeterTwoYangonUserConstructionPermit/{id}', 'HomeController@ygn_room_18_permit_create')->name('18_permit_create_ygn')->middleware('verified');
    Route::post('/contractorMeterTwoYangonUserConstructionPermit', 'HomeController@ygn_room_18_permit_store')->name('18_permit_store_ygn')->middleware('verified');
    Route::get('/contractorMeterTwoYangonUserConstructionPermitEdit/{id}', 'HomeController@ygn_room_18_permit_edit')->name('18_permit_edit_ygn')->middleware('verified');
    Route::patch('/contractorMeterTwoYangonUserConstructionPermitUpdate', 'HomeController@ygn_room_18_permit_update')->name('18_permit_update_ygn')->middleware('verified');
    /* User BCC Letter */
    Route::get('/contractorMeterTwoYangonUserResidentPermit/{id}', 'HomeController@ygn_room_18_bcc_create')->name('18_bcc_create_ygn')->middleware('verified');
    Route::post('/contractorMeterTwoYangonUserResidentPermit', 'HomeController@ygn_room_18_bcc_store')->name('18_bcc_store_ygn')->middleware('verified');
    Route::get('/contractorMeterTwoYangonUserResidentPermitEdit/{id}', 'HomeController@ygn_room_18_bcc_edit')->name('18_bcc_edit_ygn')->middleware('verified');
    Route::patch('/contractorMeterTwoYangonUserResidentPermitUpdate', 'HomeController@ygn_room_18_bcc_update')->name('18_bcc_update_ygn')->middleware('verified');
    /* User DC Recomm Letter */
    Route::get('/contractorMeterTwoYangonUserDCRecommanded/{id}', 'HomeController@ygn_room_18_dc_recomm_create')->name('18_dc_recomm_create_ygn')->middleware('verified');
    Route::post('/contractorMeterTwoYangonUserDCRecommanded', 'HomeController@ygn_room_18_dc_recomm_store')->name('18_dc_recomm_store_ygn')->middleware('verified');
    Route::get('/contractorMeterTwoYangonUserDCRecommandedEdit/{id}', 'HomeController@ygn_room_18_dc_recomm_edit')->name('18_dc_recomm_edit_ygn')->middleware('verified');
    Route::patch('/contractorMeterTwoYangonUserDCRecommandedUpdate', 'HomeController@ygn_room_18_dc_recomm_update')->name('18_dc_recomm_update_ygn')->middleware('verified');
    /* User Previous Bill */
    Route::get('/contractorMeterTwoYangonUserMeterBill/{id}', 'HomeController@ygn_room_18_bill_create')->name('18_bill_create_ygn')->middleware('verified');
    Route::post('/contractorMeterTwoYangonUserMeterBill', 'HomeController@ygn_room_18_bill_store')->name('18_bill_store_ygn')->middleware('verified');
    Route::get('/contractorMeterTwoYangonUserMeterBillEdit/{id}', 'HomeController@ygn_room_18_bill_edit')->name('18_bill_edit_ygn')->middleware('verified');
    Route::patch('/contractorMeterTwoYangonUserMeterBillUpdate', 'HomeController@ygn_room_18_bill_update')->name('18_bill_update_ygn')->middleware('verified');
    /* User Build Transformer */

    Route::get('/contractorMeterYangonAppliedForm/{id}', 'HomeController@ygn_contractor_show')->name('contractor_applied_form_ygn')->middleware('verified');
    /* ================================================== End Contractor ================================================== */
    
    /* ================================================== Start Transformer ================================================== */
    /* Rule and Regulation */
    Route::get('/transformerYangonRuleAndRegulation', 'HomeController@ygn_transformer_rule_regulation')->name('tsf_rule_regulation_ygn')->middleware('verified');
    Route::get('/transformerYangonAgreement', 'HomeController@ygn_transformer_agreement')->name('tsf_agreement_ygn')->middleware('verified');
    Route::get('/transformerYangonAgreementOne', 'HomeController@ygn_transformer_agreement_one')->name('tsf_agreement_one_ygn')->middleware('verified');
    /* Reisdential Meter Type */
    Route::get('/transformerYangonType', 'HomeController@ygn_transformer_select_meter_type')->name('tsf_meter_type_ygn')->middleware('verified');
    Route::post('/transformerYangonType', 'HomeController@ygn_transformer_store_meter_type')->name('tsf_store_meter_type_ygn')->middleware('verified');
    Route::get('/transformerYangonTypeEdit/{id}', 'HomeController@ygn_transformer_edit_meter_type')->name('tsf_edit_meter_type_ygn')->middleware('verified');
    Route::patch('/transformerYangonTypeUpdate', 'HomeController@ygn_transformer_update_meter_type')->name('tsf_update_meter_type_ygn')->middleware('verified');
    /* User Info */
    Route::get('/transformerYangonApplicantInfo/{id}', 'HomeController@ygn_transformer_user_information')->name('tsf_user_info_ygn')->middleware('verified');
    Route::post('/transformerYangonApplicantInfo', 'HomeController@ygn_transformer_store_user_information')->name('tsf_store_user_info_ygn')->middleware('verified');
    Route::get('/transformerYangonApplicantInfoEdit/{id}', 'HomeController@ygn_transformer_edit_user_information')->name('tsf_edit_user_info_ygn')->middleware('verified');
    Route::patch('/transformerYangonApplicantInfoUpdate', 'HomeController@ygn_transformer_update_user_information')->name('tsf_update_user_info_ygn')->middleware('verified');
    /* User NRC */
    Route::get('/transformerYangonApplicantNRC/{id}', 'HomeController@ygn_transformer_nrc_create')->name('tsf_nrc_create_ygn')->middleware('verified');
    Route::post('/transformerYangonApplicantNRC', 'HomeController@ygn_transformer_nrc_store')->name('tsf_nrc_store_ygn')->middleware('verified');
    Route::get('/transformerYangonApplicantNRCEdit/{id}', 'HomeController@ygn_transformer_nrc_edit')->name('tsf_nrc_edit_ygn')->middleware('verified');
    Route::patch('/transformerYangonApplicantNRCUpdate', 'HomeController@ygn_transformer_nrc_update')->name('tsf_nrc_update_ygn')->middleware('verified');
    /* User Form10 */
    Route::get('/transformerYangonApplicantForm10/{id}', 'HomeController@ygn_transformer_form10_create')->name('tsf_form10_create_ygn')->middleware('verified');
    Route::post('/transformerYangonApplicantForm10', 'HomeController@ygn_transformer_form10_store')->name('tsf_form10_store_ygn')->middleware('verified');
    Route::get('/transformerYangonApplicantForm10Edit/{id}', 'HomeController@ygn_transformer_form10_edit')->name('tsf_form10_edit_ygn')->middleware('verified');
    Route::patch('/transformerYangonApplicantForm10Update', 'HomeController@ygn_transformer_form10_update')->name('tsf_form10_update_ygn')->middleware('verified');
    /* User Recommmanded Letter */
    Route::get('/transformerYangonApplicantRecommanded/{id}', 'HomeController@ygn_transformer_recomm_create')->name('tsf_recomm_create_ygn')->middleware('verified');
    Route::post('/transformerYangonApplicantRecommanded', 'HomeController@ygn_transformer_recomm_store')->name('tsf_recomm_store_ygn')->middleware('verified');
    Route::get('/transformerYangonApplicantRecommandedEdit/{id}', 'HomeController@ygn_transformer_recomm_edit')->name('tsf_recomm_edit_ygn')->middleware('verified');
    Route::patch('/transformerYangonApplicantRecommandedUpdate', 'HomeController@ygn_transformer_recomm_update')->name('tsf_recomm_update_ygn')->middleware('verified');
    /* User Ownership */
    Route::get('/transformerYangonApplicantOwnership/{id}', 'HomeController@ygn_transformer_owner_create')->name('tsf_owner_create_ygn')->middleware('verified');
    Route::post('/transformerYangonApplicantOwnership', 'HomeController@ygn_transformer_owner_store')->name('tsf_owner_store_ygn')->middleware('verified');
    Route::get('/transformerYangonApplicantOwnershipEdit/{id}', 'HomeController@ygn_transformer_owner_edit')->name('tsf_owner_edit_ygn')->middleware('verified');
    Route::patch('/transformerYangonApplicantOwnershipUpdate', 'HomeController@ygn_transformer_owner_update')->name('tsf_owner_update_ygn')->middleware('verified');
    /* Use Work Licence */
    Route::get('/transformerYangonWorkLicence/{id}', 'HomeController@ygn_transformer_worklicence_create')->name('tsf_worklicence_create_ygn')->middleware('verified');
    Route::post('/transformerYangonWorkLicence', 'HomeController@ygn_transformer_worklicence_store')->name('tsf_worklicence_store_ygn')->middleware('verified');
    Route::get('/transformerYangonWorkLicenceEdit/{id}', 'HomeController@ygn_transformer_worklicence_edit')->name('tsf_worklicence_edit_ygn')->middleware('verified');
    Route::patch('/transformerYangonWorkLicenceUpdate', 'HomeController@ygn_transformer_worklicence_update')->name('tsf_worklicence_update_ygn')->middleware('verified');
    /* Use Electric Power */
    Route::get('/transformerYangonUseElectricPower/{id}', 'HomeController@ygn_transformer_electricpower_create')->name('tsf_electricpower_create_ygn')->middleware('verified');
    Route::post('/transformerYangonUseElectricPower', 'HomeController@ygn_transformer_electricpower_store')->name('tsf_electricpower_store_ygn')->middleware('verified');
    Route::get('/transformerYangonUseElectricPowerEdit/{id}', 'HomeController@ygn_transformer_electricpower_edit')->name('tsf_electricpower_edit_ygn')->middleware('verified');
    Route::patch('/transformerYangonUseElectricPowerUpdate', 'HomeController@ygn_transformer_electricpower_update')->name('tsf_electricpower_update_ygn')->middleware('verified');
    /* User Applied Form View */
    Route::get('/transformerYangonAppliedForm/{id}', 'HomeController@ygn_transformer_show')->name('tsf_applied_form_ygn')->middleware('verified');
    /* ================================================== End Yangon Transformer Meter ================================================== */
});
/* --------------------------------------------------------------------------------------------------------------- */

/* --------------------------------------------------------------------------------------------------------------- */
/* Admin Route */
/* =========== */
Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('/dashboard', 'AdminHomeController@index')->name('dashboard');

    Route::get('/mailbox', 'AdminHomeController@inbox')->name('mailbox');

    Route::get('/applyingFormList', 'AdminHomeController@applying_form')->name('applying_form.index');
    Route::get('/applyingFormListShow/{id}', 'AdminHomeController@applying_form_show')->name('applying_form.show');
    Route::get('/performingFormList', 'AdminHomeController@performing_form')->name('performing_form.index');
    Route::get('/performingFormListShow/{id}', 'AdminHomeController@performing_form_show')->name('performing_form.show');

    Route::get('/rejectFormList', 'AdminHomeController@reject_form')->name('reject_form.index');
    Route::get('/rejectFormListShow/{id}', 'AdminHomeController@reject_form_show')->name('reject_form.show');

    Route::get('/pendingFormList', 'AdminHomeController@pending_form')->name('pending_form.index');
    Route::get('/pendingFormListShow/{id}', 'AdminHomeController@pending_form_show')->name('pending_form.show');

    Route::get('/registeredFormList', 'AdminHomeController@registered_form')->name('registered_form.index');
    Route::get('/registeredFormListShow/{id}', 'AdminHomeController@registered_form_show')->name('registered_form.show');

    Route::get('/finishedFormList', 'AdminHomeController@finished_form')->name('finished_form');
    /* Admin Accounts */
    Route::get('/accounts', 'AdminHomeController@account_index')->name('accounts.index');
    Route::get('/createAccount', 'AdminHomeController@account_create')->name('accounts.create');
    Route::post('/account', 'AdminHomeController@account_store')->name('accounts.store');
    Route::get('/account/{id}', 'AdminHomeController@account_show')->name('accounts.show');
    Route::get('/editAccount/{id}', 'AdminHomeController@account_edit')->name('accounts.edit');
    Route::patch('/updateAccount/{id}', 'AdminHomeController@account_update')->name('accounts.update');
    Route::delete('/account/{id}', 'AdminHomeController@account_destroy')->name('accounts.destroy');
    /* Admin Roles */
    Route::get('/roles', 'AdminHomeController@roles_index')->name('roles.index');
    Route::post('/roles', 'AdminHomeController@roles_store')->name('roles.store');
    Route::get('/roles/{id}', 'AdminHomeController@roles_show')->name('roles.show');
    Route::delete('/roles/{id}', 'AdminHomeController@roles_destroy')->name('roles.destroy');

    Route::get('/userAccounts', 'AdminHomeController@user_index')->name('users.index');
    /* ============================================================================================================================ */
    /* =============================================== Residential Meter Form =============================================== */
    /* Form */
    Route::get('/residentialMeterApplicationList', 'AdminHomeController@residential_applied_form_list')->name('residentialMeterApplicationList.index');
    Route::get('/residentialMeterApplicationList/{id}', 'AdminHomeController@residential_applied_form_list_show')->name('residentialMeterApplicationList.show');

    Route::get('/residentialMeterFormPending/{id}', 'AdminHomeController@residential_form_pending_create')->name('residentialMeterFormPending.create');
    Route::post('/residentialMeterFormPending', 'AdminHomeController@residential_form_pending_store')->name('residentialMeterFormPending.store');

    Route::get('/residentialMeterFormErrorSend/{id}', 'AdminHomeController@residential_form_error_send_create')->name('residentialMeterFormErrorSend.create');
    Route::post('/residentialMeterFormErrorSend', 'AdminHomeController@residential_form_error_send_store')->name('residentialMeterFormErrorSend.store');
    Route::get('/residentialMeterFormAccept/{id}', 'AdminHomeController@residential_form_accept')->name('residentialMeterFormAccept.store');

    Route::get('/residentialMeterApplicationDoneList', 'AdminHomeController@residential_form_done_list');

    Route::get('/residentialMeterPendingForm', 'AdminHomeController@residential_pending_list')->name('residentialMeterPendingForm.index');
    Route::get('/residentialMeterPendingFormShow/{id}', 'AdminHomeController@residential_pending_list_show')->name('residentialMeterPendingForm.show');
    Route::post('/residentialMeterPendingForm', 'AdminHomeController@residential_pending_list_store')->name('residentialMeterPendingForm.store');

    Route::get('/residentialMeterRejectedForm', 'AdminHomeController@residential_reject_list')->name('residentialMeterRejectedForm.index');
    Route::get('/residentialMeterRejectedFormShow/{id}', 'AdminHomeController@residential_reject_list_show')->name('residentialMeterRejectedForm.show');

    Route::get('/residentialMeterGroundCheckList', 'AdminHomeController@residential_grd_chk_list')->name('residentialMeterGroundCheckList.index');
    Route::get('/residentialMeterGroundCheckListShow/{id}', 'AdminHomeController@residential_grd_chk_list_show')->name('residentialMeterGroundCheckList.show');
    Route::get('/residentialMeterGroundCheckListForm/{id}', 'AdminHomeController@residential_grd_chk_list_create')->name('residentialMeterGroundCheckList.create');
    Route::post('/residentialMeterGroundCheckListForm', 'AdminHomeController@residential_grd_chk_list_store')->name('residentialMeterGroundCheckList.store');

    Route::get('/residentialMeterGroundCheckChooseForm/{id}', 'AdminHomeController@residential_grd_chk_choose_create')->name('residentialMeterGroundCheckChoose.create');
    Route::post('/residentialMeterGroundCheckChooseForm', 'AdminHomeController@residential_grd_chk_choose_store')->name('residentialMeterGroundCheckChoose.store');

    Route::get('/residentialMeterGroundCheckDoneList', 'AdminHomeController@residential_grd_done_list')->name('residentialMeterGroundCheckDoneList.index');
    Route::get('/residentialMeterGroundCheckDoneListShow/{id}', 'AdminHomeController@residential_grd_done_list_show')->name('residentialMeterGroundCheckDoneList.show');
    Route::get('/residentialMeterGroundCheckDoneListForm/{id}', 'AdminHomeController@residential_grd_done_list_create')->name('residentialMeterGroundCheckDoneList.create');
    Route::post('/residentialMeterGroundCheckDoneListForm', 'AdminHomeController@residential_grd_done_list_store')->name('residentialMeterGroundCheckDoneList.store');
    Route::get('residentialMeterGroundCheckDoneListEdit/{id}', 'AdminHomeController@residential_grd_done_list_edit')->name('residentialMeterGroundCheckDoneListEdit.edit');
    Route::patch('residentialMeterGroundCheckDoneListEdit', 'AdminHomeController@residential_grd_done_list_update')->name('residentialMeterGroundCheckDoneListEdit.update');

    Route::get('/residentialMeterAnnounceList', 'AdminHomeController@residential_anno_list')->name('residentialMeterAnnounceList.index');
    Route::get('/residentialMeterAnnounceListShow/{id}', 'AdminHomeController@residential_anno_list_show')->name('residentialMeterAnnounceList.show');
    Route::get('/residentialMeterAnnounceListForm/{id}', 'AdminHomeController@residential_anno_list_create')->name('residentialMeterAnnounceList.create');
    
    Route::get('/residentialMeterPaymentList', 'AdminHomeController@residential_payment_list')->name('residentialMeterPaymentList.index');
    Route::get('/residentialMeterPaymentListShow/{id}', 'AdminHomeController@residential_payment_show')->name('residentialMeterPaymentList.show');
    Route::get('/residentialMeterPaymentListForm/{id}', 'AdminHomeController@residential_payment_create')->name('residentialMeterPaymentList.create');
    Route::post('/residentialMeterPaymentListForm', 'AdminHomeController@residential_payment_store')->name('residentialMeterPaymentList.store');
    
    Route::get('/residentialMeterContractList', 'AdminHomeController@residential_contract_list')->name('residentialMeterContractList.index');
    Route::get('/residentialMeterContractListShow/{id}', 'AdminHomeController@residential_contract_list_show')->name('residentialMeterContractList.show');
    Route::get('/residentialMeterContractListForm/{id}', 'AdminHomeController@residential_contract_list_create')->name('residentialMeterContractList.create');
    Route::post('/residentialMeterContractListForm', 'AdminHomeController@residential_contract_list_store')->name('residentialMeterContractList.store');

    Route::get('/residentialMeterCheckInstallList', 'AdminHomeController@residential_chk_install_list')->name('residentialMeterCheckInstallList.index');
    Route::get('/residentialMeterCheckInstallListShow/{id}', 'AdminHomeController@residential_chk_install_list_show')->name('residentialMeterCheckInstallList.show');
    Route::get('/residentialMeterCheckInstallListForm/{id}', 'AdminHomeController@residential_chk_install_list_create')->name('residentialMeterCheckInstallList.create');
    Route::post('/residentialMeterCheckInstallListForm', 'AdminHomeController@residential_chk_install_list_store')->name('residentialMeterCheckInstallList.store');

    Route::get('/residentialMeterInstallationDoneList', 'AdminHomeController@residential_install_done_list')->name('residentialMeterInstallationDoneList.index');
    Route::get('/residentialMeterInstallationDoneListShow/{id}', 'AdminHomeController@residential_install_done_list_show')->name('residentialMeterInstallationDoneList.show');
    Route::get('/residentialMeterInstallationDoneListForm/{id}', 'AdminHomeController@residential_install_done_list_create')->name('residentialMeterInstallationDoneList.create');

    Route::get('/residentialMeterRegisterMeterList', 'AdminHomeController@residential_reg_meter_list')->name('residentialMeterRegisterMeterList.index');
    Route::get('/residentialMeterRegisterMeterListShow/{id}', 'AdminHomeController@residential_reg_meter_list_show')->name('residentialMeterRegisterMeterList.show');
    Route::get('/residentialMeterRegisterMeterListForm/{id}', 'AdminHomeController@residential_reg_meter_list_create')->name('residentialMeterRegisterMeterList.create');
    Route::post('/residentialMeterRegisterMeterListForm', 'AdminHomeController@residential_reg_meter_list_store')->name('residentialMeterRegisterMeterList.store');
    /* ================================================================================================================================================================== */
    /* ===================================================================== Residential Power Meter ===================================================================== */
     /* Form */
    Route::get('/residentialPowerMeterApplicationList', 'AdminHomeController@residential_power_applied_form_list')->name('residentialPowerMeterApplicationList.index');
    Route::get('/residentialPowerMeterApplicationList/{id}', 'AdminHomeController@residential_power_applied_form_list_show')->name('residentialPowerMeterApplicationList.show');

    Route::get('/residentialPowerMeterFormPending/{id}', 'AdminHomeController@residential_power_form_pending_create')->name('residentialPowerMeterFormPending.create');
    Route::post('/residentialPowerMeterFormPending', 'AdminHomeController@residential_power_form_pending_store')->name('residentialPowerMeterFormPending.store');

    // *************** Error *************************
    Route::get('/residentialPowerMeterFormErrorSend/{id}', 'AdminHomeController@residential_power_form_error_send_create')->name('residentialPowerMeterFormErrorSend.create');
    Route::post('/residentialPowerMeterFormErrorSend', 'AdminHomeController@residential_power_form_error_send_store')->name('residentialPowerMeterFormErrorSend.store');
    Route::get('/residentialPowerMeterFormAccept/{id}', 'AdminHomeController@residential_power_form_accept')->name('residentialPowerMeterFormAccept.store');

    // *********** Ground Check ***********
    Route::get('/residentialPowerMeterGroundCheckList', 'AdminHomeController@residential_power_grd_chk_list')->name('residentialPowerMeterGroundCheckList.index');
    Route::get('/residentialPowerMeterGroundCheckListShow/{id}', 'AdminHomeController@residential_power_grd_chk_list_show')->name('residentialPowerMeterGroundCheckList.show');
    Route::get('/residentialPowerMeterGroundCheckListForm/{id}', 'AdminHomeController@residential_power_grd_chk_list_create')->name('residentialPowerMeterGroundCheckList.create');
    Route::post('/residentialPowerMeterGroundCheckListForm', 'AdminHomeController@residential_power_grd_chk_list_store')->name('residentialPowerMeterGroundCheckList.store');

    // ************ Choose Engineer ****************
    Route::get('/residentialPowerMeterGroundCheckChooseForm/{id}', 'AdminHomeController@residential_power_grd_chk_choose_create')->name('residentialPowerMeterGroundCheckChoose.create');
    Route::post('/residentialPowerMeterGroundCheckChooseForm', 'AdminHomeController@residential_power_grd_chk_choose_store')->name('residentialPowerMeterGroundCheckChoose.store');

    // *********** Ground Check Done List***********
    Route::get('/residentialPowerMeterGroundCheckDoneList', 'AdminHomeController@residential_power_grd_done_list')->name('residentialPowerMeterGroundCheckDoneList.index');
    Route::get('/residentialPowerMeterGroundCheckDoneListShow/{id}', 'AdminHomeController@residential_power_grd_done_list_show')->name('residentialPowerMeterGroundCheckDoneList.show');
    Route::get('/residentialPowerMeterGroundCheckDoneListForm/{id}', 'AdminHomeController@residential_power_grd_done_list_create')->name('residentialPowerMeterGroundCheckDoneList.create');
    Route::post('/residentialPowerMeterGroundCheckDoneListForm', 'AdminHomeController@residential_power_grd_done_list_store')->name('residentialPowerMeterGroundCheckDoneList.store');
    Route::get('/residentialPowerMeterGroundCheckDoneListFormEidt/{id}', 'AdminHomeController@residential_power_grd_done_list_edit')->name('residentialPowerMeterGroundCheckDoneList.edit');
    Route::patch('/residentialPowerMeterGroundCheckDoneListForm', 'AdminHomeController@residential_power_grd_done_list_update')->name('residentialPowerMeterGroundCheckDoneList.update');
    
    // *********** Ground Check Done List District ***********
    Route::get('/residentialPowerMeterGroundCheckDoneListByDistrict', 'AdminHomeController@residential_power_grd_done_list_dist')->name('residentialPowerMeterGroundCheckDoneListByDistrict.index');
    Route::get('/residentialPowerMeterGroundCheckDoneListShowByDistrict/{id}', 'AdminHomeController@residential_power_grd_done_list_show_dist')->name('residentialPowerMeterGroundCheckDoneListByDistrict.show');
    Route::post('/residentialPowerMeterGroundCheckDoneListFormByDistrict', 'AdminHomeController@residential_power_grd_done_list_store_dist')->name('residentialPowerMeterGroundCheckDoneListByDistrict.store');

    // ************ Pending & Reject ************
    Route::get('/residentialPowerMeterPendingForm', 'AdminHomeController@residential_power_pending_list')->name('residentialPowerMeterPendingForm.index');
    Route::get('/residentialPowerMeterPendingFormShow/{id}', 'AdminHomeController@residential_power_pending_list_show')->name('residentialPowerMeterPendingForm.show');
    Route::post('/residentialPowerMeterPendingForm', 'AdminHomeController@residential_power_pending_list_store')->name('residentialPowerMeterPendingForm.store');

    Route::get('/residentialPowerMeterRejectedForm', 'AdminHomeController@residential_power_reject_list')->name('residentialPowerMeterRejectedForm.index');
    Route::get('/residentialPowerMeterRejectedFormShow/{id}', 'AdminHomeController@residential_power_reject_list_show')->name('residentialPowerMeterRejectedForm.show');

    // *********** Announce List***********
    Route::get('/residentialPowerMeterAnnounceList', 'AdminHomeController@residential_power_anno_list')->name('residentialPowerMeterAnnounceList.index');
    Route::get('/residentialPowerMeterAnnounceListShow/{id}', 'AdminHomeController@residential_power_anno_list_show')->name('residentialPowerMeterAnnounceList.show');
    Route::get('/residentialPowerMeterAnnounceListForm/{id}', 'AdminHomeController@residential_power_anno_list_create')->name('residentialPowerMeterAnnounceList.create');

    // *********** Payment List***********
    Route::get('/residentialPowerMeterPaymentList', 'AdminHomeController@residential_power_payment_list')->name('residentialPowerMeterPaymentList.index');
    Route::get('/residentialPowerMeterPaymentListShow/{id}', 'AdminHomeController@residential_power_payment_show')->name('residentialPowerMeterPaymentList.show');
    Route::get('/residentialPowerMeterPaymentListForm/{id}', 'AdminHomeController@residential_power_payment_create')->name('residentialPowerMeterPaymentList.create');
    Route::post('/residentialPowerMeterPaymentListForm', 'AdminHomeController@residential_power_payment_store')->name('residentialPowerMeterPaymentList.store');

    // *********** Contract List***********
    Route::get('/residentialPowerMeterContractList', 'AdminHomeController@residential_power_contract_list')->name('residentialPowerMeterContractList.index');
    Route::get('/residentialPowerMeterContractListShow/{id}', 'AdminHomeController@residential_power_contract_list_show')->name('residentialPowerMeterContractList.show');
    Route::get('/residentialPowerMeterContractListForm/{id}', 'AdminHomeController@residential_power_contract_list_create')->name('residentialPowerMeterContractList.create');
    Route::post('/residentialPowerMeterContractListForm', 'AdminHomeController@residential_power_contract_list_store')->name('residentialPowerMeterContractList.store');

    // *********** Check Install List***********
    Route::get('/residentialPowerMeterCheckInstallList', 'AdminHomeController@residential_power_chk_install_list')->name('residentialPowerMeterCheckInstallList.index');
    Route::get('/residentialPowerMeterCheckInstallListShow/{id}', 'AdminHomeController@residential_power_chk_install_list_show')->name('residentialPowerMeterCheckInstallList.show');
    Route::get('/residentialPowerMeterCheckInstallListForm/{id}', 'AdminHomeController@residential_power_chk_install_list_create')->name('residentialPowerMeterCheckInstallList.create');
    Route::post('/residentialPowerMeterCheckInstallListForm', 'AdminHomeController@residential_power_chk_install_list_store')->name('residentialPowerMeterCheckInstallList.store');

    // ***********  Install Done List***********
    Route::get('/residentialPowerMeterInstallationDoneList', 'AdminHomeController@residential_power_install_done_list')->name('residentialPowerMeterInstallationDoneList.index');
    Route::get('/residentialPowerMeterInstallationDoneListShow/{id}', 'AdminHomeController@residential_power_install_done_list_show')->name('residentialPowerMeterInstallationDoneList.show');
    Route::get('/residentialPowerMeterInstallationDoneListForm/{id}', 'AdminHomeController@residential_power_install_done_list_create')->name('residentialPowerMeterInstallationDoneList.create');

    // *********** Ground Register List***********
    Route::get('/residentialPowerMeterRegisterMeterList', 'AdminHomeController@residential_power_reg_meter_list')->name('residentialPowerMeterRegisterMeterList.index');
    Route::get('/residentialPowerMeterRegisterMeterListShow/{id}', 'AdminHomeController@residential_power_reg_meter_list_show')->name('residentialPowerMeterRegisterMeterList.show');
    Route::get('/residentialPowerMeterRegisterMeterListForm/{id}', 'AdminHomeController@residential_power_reg_meter_list_create')->name('residentialPowerMeterRegisterMeterList.create');
    Route::post('/residentialPowerMeterRegisterMeterListForm', 'AdminHomeController@residential_power_reg_meter_list_store')->name('residentialPowerMeterRegisterMeterList.store');
    /* ================================================================================================================================================================== */
    /* ===================================================================== Commercial Power Meter ===================================================================== */
    /* Form */
    Route::get('/commercialPowerMeterApplicationList', 'AdminHomeController@commercial_applied_form_list')->name('commercialPowerMeterApplicationList.index');
    Route::get('/commercialPowerMeterApplicationList/{id}', 'AdminHomeController@commercial_applied_form_list_show')->name('commercialPowerMeterApplicationList.show');

    // Error
    Route::get('/commercialPowerMeterFormErrorSend/{id}', 'AdminHomeController@commercial_form_error_send_create')->name('commercialPowerMeterFormErrorSend.create');
    Route::post('/commercialPowerMeterFormErrorSend', 'AdminHomeController@commercial_form_error_send_store')->name('commercialPowerMeterFormErrorSend.store');

    Route::get('/commercialPowerMeterFormAccept/{id}', 'AdminHomeController@commercial_form_accept')->name('commercialPowerMeterFormAccept.store');

    // Ground Check
    Route::get('/commercialPowerMeterGroundCheckList', 'AdminHomeController@commercial_grd_chk_list')->name('commercialPowerMeterGroundCheckList.index');
    Route::get('/commercialPowerMeterGroundCheckListShow/{id}', 'AdminHomeController@commercial_grd_chk_list_show')->name('commercialPowerMeterGroundCheckList.show');
    Route::post('/commercialPowerMeterGroundCheckChooseForm', 'AdminHomeController@commercial_grd_chk_choose_store')->name('commercialPowerMeterGroundCheckChoose.store');
    Route::post('/commercialPowerMeterGroundCheckListForm', 'AdminHomeController@commercial_grd_chk_list_store')->name('commercialPowerMeterGroundCheckList.store');

    // Ground Check Done
    Route::get('/commercialPowerMeterGroundCheckDoneList', 'AdminHomeController@commercial_grd_done_list')->name('commercialPowerMeterGroundCheckDoneList.index');
    Route::get('/commercialPowerMeterGroundCheckDoneListShow/{id}', 'AdminHomeController@commercial_grd_done_list_show')->name('commercialPowerMeterGroundCheckDoneList.show');
    Route::get('/commercialPowerMeterGroundCheckDoneListForm/{id}', 'AdminHomeController@commercial_grd_done_list_create')->name('commercialPowerMeterGroundCheckDoneList.create');
    Route::post('/commercialPowerMeterGroundCheckDoneListForm', 'AdminHomeController@commercial_grd_done_list_store')->name('commercialPowerMeterGroundCheckDoneList.store');
    Route::get('/commercialPowerMeterGroundCheckDoneListFormEidt/{id}', 'AdminHomeController@commercial_grd_done_list_edit')->name('commercialPowerMeterGroundCheckDoneList.edit');
    Route::patch('/commercialPowerMeterGroundCheckDoneListForm', 'AdminHomeController@commercial_grd_done_list_update')->name('commercialPowerMeterGroundCheckDoneList.update');

    Route::get('/commercialPowerMeterGroundCheckDoneListByDistrict', 'AdminHomeController@commercial_grd_done_list_dist')->name('commercialPowerMeterGroundCheckDoneListDist.index');
    Route::get('/commercialPowerMeterGroundCheckDoneListShowFormByDistrict/{id}', 'AdminHomeController@commercial_grd_done_list_show_dist')->name('commercialPowerMeterGroundCheckDoneListDist.show');
    Route::post('/commercialPowerMeterGroundCheckDoneListFormByDistrict', 'AdminHomeController@commercial_grd_done_list_store_dist')->name('commercialPowerMeterGroundCheckDoneListDist.store');
    
    // ************ Pending & Reject ************
    Route::get('/commercialPowerMeterPendingForm', 'AdminHomeController@commercial_pending_list')->name('commercialPowerMeterPendingForm.index');
    Route::get('/commercialPowerMeterPendingFormShow/{id}', 'AdminHomeController@commercial_pending_list_show')->name('commercialPowerMeterPendingForm.show');
    Route::post('/commercialPowerMeterPendingForm', 'AdminHomeController@commercial_pending_list_store')->name('commercialPowerMeterPendingForm.store');

    Route::get('/commercialPowerMeterRejectedForm', 'AdminHomeController@commercial_reject_list')->name('commercialPowerMeterRejectedForm.index');
    Route::get('/commercialPowerMeterRejectedFormShow/{id}', 'AdminHomeController@commercial_reject_list_show')->name('commercialPowerMeterRejectedForm.show');

    //  Announce List
    Route::get('/commercialPowerMeterAnnounceList', 'AdminHomeController@commercial_anno_list')->name('commercialPowerMeterAnnounceList.index');
    Route::get('/commercialPowerMeterAnnounceListShow/{id}', 'AdminHomeController@commercial_anno_list_show')->name('commercialPowerMeterAnnounceList.show');
    Route::get('/commercialPowerMeterAnnounceListForm/{id}', 'AdminHomeController@commercial_anno_list_create')->name('commercialPowerMeterAnnounceList.create');

    //Payment List
    Route::get('/commercialPowerMeterPaymentList', 'AdminHomeController@commercial_payment_list')->name('commercialPowerMeterPaymentList.index');
    Route::get('/commercialPowerMeterPaymentListShow/{id}', 'AdminHomeController@commercial_payment_show')->name('commercialPowerMeterPaymentList.show');
    Route::get('/commercialPowerMeterPaymentListForm/{id}', 'AdminHomeController@commercial_payment_create')->name('commercialPowerMeterPaymentList.create');
    Route::post('/commercialPowerMeterPaymentListForm', 'AdminHomeController@commercial_payment_store')->name('commercialPowerMeterPaymentList.store');
    
    // Contract List
    Route::get('/commercialPowerMeterContractList', 'AdminHomeController@commercial_contract_list')->name('commercialPowerMeterContractList.index');
    Route::get('/commercialPowerMeterContractListShow/{id}', 'AdminHomeController@commercial_contract_list_show')->name('commercialPowerMeterContractList.show');
    Route::get('/commercialPowerMeterContractListForm/{id}', 'AdminHomeController@commercial_contract_list_create')->name('commercialPowerMeterContractList.create');
    Route::post('/commercialPowerMeterContractListForm', 'AdminHomeController@commercial_contract_list_store')->name('commercialPowerMeterContractList.store');

    // Check Install
    Route::get('/commercialPowerMeterCheckInstallList', 'AdminHomeController@commercial_chk_install_list')->name('commercialPowerMeterCheckInstallList.index');
    Route::get('/commercialPowerMeterCheckInstallListShow/{id}', 'AdminHomeController@commercial_chk_install_list_show')->name('commercialPowerMeterCheckInstallList.show');
    Route::get('/commercialPowerMeterCheckInstallListForm/{id}', 'AdminHomeController@commercial_chk_install_list_create')->name('commercialPowerMeterCheckInstallList.create');
    Route::post('/commercialPowerMeterCheckInstallListForm', 'AdminHomeController@commercial_chk_install_list_store')->name('commercialPowerMeterCheckInstallList.store');

    // Check Install Done
    Route::get('/commercialPowerMeterInstallationDoneList', 'AdminHomeController@commercial_install_done_list')->name('commercialPowerMeterInstallationDoneList.index');
    Route::get('/commercialPowerMeterInstallationDoneListShow/{id}', 'AdminHomeController@commercial_install_done_list_show')->name('commercialPowerMeterInstallationDoneList.show');
    Route::get('/commercialPowerMeterInstallationDoneListForm/{id}', 'AdminHomeController@commercial_install_done_list_create')->name('commercialPowerMeterInstallationDoneList.create');

    //Register
    Route::get('/commercialPowerMeterRegisterMeterList', 'AdminHomeController@commercial_reg_meter_list')->name('commercialPowerMeterRegisterMeterList.index');
    Route::get('/commercialPowerMeterRegisterMeterListShow/{id}', 'AdminHomeController@commercial_reg_meter_list_show')->name('commercialPowerMeterRegisterMeterList.show');
    Route::get('/commercialPowerMeterRegisterMeterListForm/{id}', 'AdminHomeController@commercial_reg_meter_list_create')->name('commercialPowerMeterRegisterMeterList.create');
    Route::post('/commercialPowerMeterRegisterMeterListForm', 'AdminHomeController@commercial_reg_meter_list_store')->name('commercialPowerMeterRegisterMeterList.store');
    /* ================================================================================================================================================================== */
    /* ===================================================================== Contractor Meter ============================================================================ */
    /* Form */
    Route::get('/contractorMeterApplicationList', 'AdminHomeController@contractor_applied_form_list')->name('contractorMeterApplicationList.index');
    Route::get('/contractorMeterApplicationList/{id}', 'AdminHomeController@contractor_applied_form_list_show')->name('contractorMeterApplicationList.show');

    Route::get('/contractorMeterFormPending/{id}', 'AdminHomeController@contractor_form_pending_create')->name('contractorMeterFormPending.create');
    Route::post('/contractorMeterFormPending', 'AdminHomeController@contractor_form_pending_store')->name('contractorMeterFormPending.store');

    Route::get('/contractorMeterFormErrorSend/{id}', 'AdminHomeController@contractor_form_error_send_create')->name('contractorMeterFormErrorSend.create');
    Route::post('/contractorMeterFormErrorSend', 'AdminHomeController@contractor_form_error_send_store')->name('contractorMeterFormErrorSend.store');
    Route::get('/contractorMeterFormAccept/{id}', 'AdminHomeController@contractor_form_accept')->name('contractorMeterFormAccept.store');

    Route::get('/contractorMeterGroundCheckList', 'AdminHomeController@contractor_grd_chk_list')->name('contractorMeterGroundCheckList.index');
    Route::get('/contractorMeterGroundCheckListShow/{id}', 'AdminHomeController@contractor_grd_chk_list_show')->name('contractorMeterGroundCheckList.show');
    Route::get('/contractorMeterGroundCheckListForm/{id}', 'AdminHomeController@contractor_grd_chk_list_create')->name('contractorMeterGroundCheckList.create');
    Route::post('/contractorMeterGroundCheckListForm', 'AdminHomeController@contractor_grd_chk_list_store')->name('contractorMeterGroundCheckList.store');
    
    Route::get('/contractorMeterGroundCheckChooseForm/{id}', 'AdminHomeController@contractor_grd_chk_list_choose_create')->name('contractorMeterGroundCheckChoose.create');
    Route::post('/contractorMeterGroundCheckChooseForm', 'AdminHomeController@contractor_grd_chk_list_choose_store')->name('contractorMeterGroundCheckChoose.store');

    Route::get('/contractorMeterGroundCheckDoneList', 'AdminHomeController@contractor_grd_done_list')->name('contractorMeterGroundCheckDoneList.index');
    Route::get('/contractorMeterGroundCheckDoneListShow/{id}', 'AdminHomeController@contractor_grd_done_list_show')->name('contractorMeterGroundCheckDoneList.show');
    Route::get('/contractorMeterGroundCheckDoneListForm/{id}', 'AdminHomeController@contractor_grd_done_list_create')->name('contractorMeterGroundCheckDoneList.create');
    Route::post('/contractorMeterGroundCheckDoneListForm', 'AdminHomeController@contractor_grd_done_list_store')->name('contractorMeterGroundCheckDoneList.store');

    Route::get('/contractorMeterGroundCheckListFormEdit/{id}', 'AdminHomeController@contractor_grd_chk_list_edit')->name('contractorMeterGroundCheckList.edit');
    Route::post('/contractorMeterGroundCheckListFormUpdate', 'AdminHomeController@contractor_grd_chk_list_update')->name('contractorMeterGroundCheckList.update');


    Route::get('/contractorMeterGroundCheckDoneListByDistrict', 'AdminHomeController@contractor_grd_done_list_by_dist')->name('contractorMeterGroundCheckDoneListByDistrict.index');
    Route::get('/contractorMeterGroundCheckDoneListShowByDistrict/{id}', 'AdminHomeController@contractor_grd_done_list_show_by_dist')->name('contractorMeterGroundCheckDoneListByDistrict.show');
    Route::get('/contractorMeterGroundCheckDoneListFormByDistrict/{id}', 'AdminHomeController@contractor_grd_done_list_create_by_dist')->name('contractorMeterGroundCheckDoneListByDistrict.create');
    Route::post('/contractorMeterGroundCheckDoneListFormByDistrict', 'AdminHomeController@contractor_grd_done_list_store_by_dist')->name('contractorMeterGroundCheckDoneListByDistrict.store');

    Route::get('/contractorMeterGroundCheckDoneListByDivisionState', 'AdminHomeController@contractor_grd_done_list_by_div_state')->name('contractorMeterGroundCheckDoneListByDivisionState.index');
    Route::get('/contractorMeterGroundCheckDoneListByDivisionStateShow/{id}', 'AdminHomeController@contractor_grd_done_list_show_by_div_state')->name('contractorMeterGroundCheckDoneListByDivisionState.show');
    Route::get('/contractorMeterGroundCheckDoneListFormByDivisionState/{id}', 'AdminHomeController@contractor_grd_done_list_create_by_div_state')->name('contractorMeterGroundCheckDoneListByDivisionState.create');
    Route::post('/contractorMeterGroundCheckDoneListFormByDivisionState', 'AdminHomeController@contractor_grd_done_list_store_by_div_state')->name('contractorMeterGroundCheckDoneListByDivisionState.store');

    // ************ Pending & Reject ************
    Route::get('/contractorMeterPendingForm', 'AdminHomeController@contractor_pending_list')->name('contractorMeterPendingForm.index');
    Route::get('/contractorMeterPendingFormShow/{id}', 'AdminHomeController@contractor_pending_list_show')->name('contractorMeterPendingForm.show');
    Route::post('/contractorMeterPendingForm', 'AdminHomeController@contractor_pending_list_store')->name('contractorMeterPendingForm.store');

    Route::get('/contractorMeterRejectedForm', 'AdminHomeController@contractor_reject_list')->name('contractorMeterRejectedForm.index');
    Route::get('/contractorMeterRejectedFormShow/{id}', 'AdminHomeController@contractor_reject_list_show')->name('contractorMeterRejectedForm.show');
    

    Route::get('/contractorMeterAnnounceList', 'AdminHomeController@contractor_anno_list')->name('contractorMeterAnnounceList.index');
    Route::get('/contractorMeterAnnounceListShow/{id}', 'AdminHomeController@contractor_anno_list_show')->name('contractorMeterAnnounceList.show');
    Route::get('/contractorMeterAnnounceListForm/{id}', 'AdminHomeController@contractor_anno_list_create')->name('contractorMeterAnnounceList.create');
    
    Route::get('/contractorMeterPaymentList', 'AdminHomeController@contractor_payment_list')->name('contractorMeterPaymentList.index');
    Route::get('/contractorMeterPaymentListShow/{id}', 'AdminHomeController@contractor_payment_show')->name('contractorMeterPaymentList.show');
    Route::get('/contractorMeterPaymentListForm/{id}', 'AdminHomeController@contractor_payment_create')->name('contractorMeterPaymentList.create');
    Route::post('/contractorMeterPaymentListForm', 'AdminHomeController@contractor_payment_store')->name('contractorMeterPaymentList.store');

    Route::get('/contractorMeterCheckInstallList', 'AdminHomeController@contractor_chk_install_list')->name('contractorMeterCheckInstallList.index');
    Route::get('/contractorMeterCheckInstallListShow/{id}', 'AdminHomeController@contractor_chk_install_list_show')->name('contractorMeterCheckInstallList.show');
    Route::get('/contractorMeterCheckInstallListForm/{id}', 'AdminHomeController@contractor_chk_install_list_create')->name('contractorMeterCheckInstallList.create');
    Route::post('/contractorMeterCheckInstallListForm', 'AdminHomeController@contractor_chk_install_list_store')->name('contractorMeterCheckInstallList.store');

    Route::get('/contractorMeterInstallationDoneList', 'AdminHomeController@contractor_install_done_list')->name('contractorMeterInstallationDoneList.index');
    Route::get('/contractorMeterInstallationDoneListShow/{id}', 'AdminHomeController@contractor_install_done_list_show')->name('contractorMeterInstallationDoneList.show');
    Route::get('/contractorMeterEICheckForm/{id}', 'AdminHomeController@contractor_install_done_list_create')->name('contractorMeterInstallationDoneList.create');
    Route::post('/contractorMeterEICheckForm', 'AdminHomeController@contractor_install_done_list_store')->name('contractorMeterInstallationDoneList.store');

    Route::get('/contractorMeterRegisterMeterList', 'AdminHomeController@contractor_reg_meter_list')->name('contractorMeterRegisterMeterList.index');
    Route::get('/contractorMeterRegisterMeterListShow/{id}', 'AdminHomeController@contractor_reg_meter_list_show')->name('contractorMeterRegisterMeterList.show');
    Route::get('/contractorMeterRegisterMeterListForm/{id}', 'AdminHomeController@contractor_reg_meter_list_create')->name('contractorMeterRegisterMeterList.create');
    Route::post('/contractorMeterRegisterMeterListForm', 'AdminHomeController@contractor_reg_meter_list_store')->name('contractorMeterRegisterMeterList.store');

    /* ===================================================================== Transformer Form ===================================================================== */
    /* Form */
    Route::get('/transformerApplicationList', 'AdminHomeController@tsf_applied_form_list')->name('transformerApplicationList.index');
    Route::get('/transformerApplicationList/{id}', 'AdminHomeController@tsf_applied_form_list_show')->name('transformerApplicationList.show');

    Route::get('/transformerFormErrorSend/{id}', 'AdminHomeController@tsf_form_error_send_create')->name('transformerFormErrorSend.create');
    Route::post('/transformerFormErrorSend', 'AdminHomeController@tsf_form_error_send_store')->name('transformerFormErrorSend.store');
    Route::get('/transformerFormAccept/{id}', 'AdminHomeController@tsf_form_accept')->name('transformerFormAccept.store');

    Route::get('/transformerApplicationDoneList', 'AdminHomeController@tsf_form_done_list');
    // Route::get('/transformerRejectForm', 'AdminHomeController@tsf_reject_list');

    Route::get('/transformerPendingForm', 'AdminHomeController@tsf_pending_list')->name('transformerPendingForm.index');
    Route::get('/transformerPendingFormShow/{id}', 'AdminHomeController@tsf_pending_list_show')->name('transformerPendingForm.show');
    Route::post('/transformerPendingForm', 'AdminHomeController@tsf_pending_list_store')->name('transformerPendingForm.store');

    Route::get('/transformerRejectedForm', 'AdminHomeController@tsf_reject_list')->name('transformerRejectedForm.index');
    Route::get('/transformerRejectedFormShow/{id}', 'AdminHomeController@tsf_reject_list_show')->name('transformerRejectedForm.show');

    Route::get('/transformerGroundCheckList', 'AdminHomeController@tsf_grd_chk_list')->name('transformerGroundCheckList.index');
    Route::get('/transformerGroundCheckListShow/{id}', 'AdminHomeController@tsf_grd_chk_list_show')->name('transformerGroundCheckList.show');
    Route::get('/transformerGroundCheckListForm/{id}', 'AdminHomeController@tsf_grd_chk_list_create')->name('transformerGroundCheckList.create');
    Route::post('/transformerGroundCheckListForm', 'AdminHomeController@tsf_grd_chk_list_store')->name('transformerGroundCheckList.store');
    /* Chooose Engineer */
    Route::get('/transformerGroundCheckChooseForm/{id}', 'AdminHomeController@tsf_grd_chk_choose_create')->name('transformerGroundCheckChoose.create');
    Route::post('/transformerGroundCheckChooseForm', 'AdminHomeController@tsf_grd_chk_choose_store')->name('transformerGroundCheckChoose.store');
    /* Insert Transformer Information */
    // Route::get('/transformerInformationForm/{id}', 'AdminHomeController@tsf_grd_chk_info_create')->name('transformerInformation.create');
    // Route::post('/transformerInformationForm', 'AdminHomeController@tsf_grd_chk_info_stroe')->name('transformerInformation.store');

    Route::get('/transformerGroundCheckDoneList', 'AdminHomeController@tsf_grd_done_list')->name('transformerGroundCheckDoneList.index');
    Route::get('/transformerGroundCheckDoneListShow/{id}', 'AdminHomeController@tsf_grd_done_list_show')->name('transformerGroundCheckDoneList.show');
    Route::get('/transformerGroundCheckDoneListForm/{id}', 'AdminHomeController@tsf_grd_done_list_create')->name('transformerGroundCheckDoneList.create');
    Route::post('/transformerGroundCheckDoneListForm', 'AdminHomeController@tsf_grd_done_list_store')->name('transformerGroundCheckDoneList.store');
    Route::get('/transformerGroundCheckDoneListFormEdit/{id}', 'AdminHomeController@tsf_grd_done_list_edit')->name('transformerGroundCheckDoneList.edit');
    Route::patch('/transformerGroundCheckDoneListForm', 'AdminHomeController@tsf_grd_done_list_update')->name('transformerGroundCheckDoneList.update');

    Route::get('/transformerGroundCheckDoneListByDistrict', 'AdminHomeController@tsf_grd_done_list_by_dist')->name('transformerGroundCheckDoneListByDistrict.index');
    Route::get('/transformerGroundCheckDoneListShowByDistrict/{id}', 'AdminHomeController@tsf_grd_done_list_show_by_dist')->name('transformerGroundCheckDoneListByDistrict.show');
    Route::get('/transformerGroundCheckDoneListFormByDistrict/{id}', 'AdminHomeController@tsf_grd_done_list_create_by_dist')->name('transformerGroundCheckDoneListByDistrict.create');
    Route::post('/transformerGroundCheckDoneListFormByDistrict', 'AdminHomeController@tsf_grd_done_list_store_by_dist')->name('transformerGroundCheckDoneListByDistrict.store');

    Route::get('/transformerGroundCheckDoneListByDivisionState', 'AdminHomeController@tsf_grd_done_list_by_div_state')->name('transformerGroundCheckDoneListByDivisionState.index');
    Route::get('/transformerGroundCheckDoneListShowByDivisionState/{id}', 'AdminHomeController@tsf_grd_done_list_show_by_div_state')->name('transformerGroundCheckDoneListByDivisionState.show');
    Route::get('/transformerGroundCheckDoneListFormByDivisionState/{id}', 'AdminHomeController@tsf_grd_done_list_create_by_div_state')->name('transformerGroundCheckDoneListByDivisionState.create');
    Route::post('/transformerGroundCheckDoneListFormByDivisionState', 'AdminHomeController@tsf_grd_done_list_store_by_div_state')->name('transformerGroundCheckDoneListByDivisionState.store');

    Route::post('/transformerGroundCheckDoneListConfirmByDivisionState', 'AdminHomeController@tsf_grd_done_list_confirm_by_div_state')->name('transformerGroundCheckDoneListConfirmByDivisionState.store');    
    Route::get('/transformerGroundCheckDoneListByHeadOffice', 'AdminHomeController@tsf_grd_done_list_by_head_office')->name('transformerGroundCheckDoneListByHeadOffice.index');
    Route::get('/transformerGroundCheckDoneListShowByHeadOffice/{id}', 'AdminHomeController@tsf_grd_done_list_show_by_head_office')->name('transformerGroundCheckDoneListByHeadOffice.show');
    Route::get('/transformerGroundCheckDoneListFormByHeadOffice/{id}', 'AdminHomeController@tsf_grd_done_list_create_by_head_office')->name('transformerGroundCheckDoneListByHeadOffice.create');
    Route::post('/transformerGroundCheckDoneListFormByHeadOffice', 'AdminHomeController@tsf_grd_done_list_store_by_head_office')->name('transformerGroundCheckDoneListByHeadOffice.store');
    
    Route::get('/transformerAnnounceList', 'AdminHomeController@tsf_anno_list')->name('transformerAnnounceList.index');
    Route::get('/transformerAnnounceListShow/{id}', 'AdminHomeController@tsf_anno_list_show')->name('transformerAnnounceList.show');
    Route::get('/transformerAnnounceListForm/{id}', 'AdminHomeController@tsf_anno_list_create')->name('transformerAnnounceList.create');
    
    Route::get('/transformerPaymentList', 'AdminHomeController@tsf_payment_list')->name('transformerPaymentList.index');
    Route::get('/transformerPaymentListShow/{id}', 'AdminHomeController@tsf_payment_show')->name('transformerPaymentList.show');
    Route::get('/transformerPaymentListForm/{id}', 'AdminHomeController@tsf_payment_create')->name('transformerPaymentList.create');
    Route::post('/transformerPaymentListForm', 'AdminHomeController@tsf_payment_store')->name('transformerPaymentList.store');
    
    Route::get('/transformerContractList', 'AdminHomeController@tsf_contract_list')->name('transformerContractList.index');
    Route::get('/transformerContractListShow/{id}', 'AdminHomeController@tsf_contract_list_show')->name('transformerContractList.show');
    Route::get('/transformerContractListForm/{id}', 'AdminHomeController@tsf_contract_list_create')->name('transformerContractList.create');
    Route::post('/transformerContractListForm', 'AdminHomeController@tsf_contract_list_store')->name('transformerContractList.store');

    Route::get('/transformerCheckInstallList', 'AdminHomeController@tsf_chk_install_list')->name('transformerCheckInstallList.index');
    Route::get('/transformerCheckInstallListShow/{id}', 'AdminHomeController@tsf_chk_install_list_show')->name('transformerCheckInstallList.show');
    Route::get('/transformerCheckInstallListForm/{id}', 'AdminHomeController@tsf_chk_install_list_create')->name('transformerCheckInstallList.create');
    Route::post('/transformerCheckInstallListForm', 'AdminHomeController@tsf_chk_install_list_store')->name('transformerCheckInstallList.store');

    Route::get('/transformerInstallationDoneList', 'AdminHomeController@tsf_install_done_list')->name('transformerInstallationDoneList.index');
    Route::get('/transformerInstallationDoneListShow/{id}', 'AdminHomeController@tsf_install_done_list_show')->name('transformerInstallationDoneList.show');
    Route::get('/transformerInstallationDoneListForm/{id}', 'AdminHomeController@tsf_install_done_list_create')->name('transformerInstallationDoneList.create');
    Route::post('/transformerEICheckForm', 'AdminHomeController@tsf_install_done_list_store')->name('transformerInstallationDoneList.store');

    Route::get('/transformerRegisterMeterList', 'AdminHomeController@tsf_reg_meter_list')->name('transformerRegisterMeterList.index');
    Route::get('/transformerRegisterMeterListShow/{id}', 'AdminHomeController@tsf_reg_meter_list_show')->name('transformerRegisterMeterList.show');
    Route::get('/transformerRegisterMeterListForm/{id}', 'AdminHomeController@tsf_reg_meter_list_create')->name('transformerRegisterMeterList.create');
    Route::post('/transformerRegisterMeterListForm', 'AdminHomeController@tsf_reg_meter_list_store')->name('transformerRegisterMeterList.store');
    /* ================================================================================================================================== */
    
    /* ============================================= JS route ============================================================== */
    Route::post('/role_action', 'SettingController@role_chk_action');
    Route::post('/choose_region', 'SettingController@choose_region');
    Route::post('/choose_district', 'SettingController@choose_district');

    Route::post('/resetDivisionState', 'SettingController@reset_division_state');

    Route::post('/filterDivisionState', 'SettingController@filter_division_state');
    Route::post('/filterDistrict', 'SettingController@filter_district');
    Route::post('/filterTownship', 'SettingController@filter_township');
    Route::post('/lock_account', 'SettingController@lock_account');

    Route::get('exportPDF/{id}', 'AdminHomeController@generate_pdf')->name('pdf');
});
/* --------------------------------------------------------------------------------------------------------------- */
