<?php

use App\User;
use App\Admin\Admin;
use App\Admin\MailTbl;
use App\Admin\FormSurvey;
use App\Setting\District;
use App\Setting\Township;
use App\Admin\FormRoutine;
use App\Setting\InitialCost;
use App\User\ApplicationFile;
use App\User\ApplicationForm;
use App\Setting\DivisionState;
use App\Admin\FormProcessAction;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Admin\FormSurveyTransformer;
use Illuminate\Support\Facades\Session;
use App\Admin\ApplicationFormContractor;
use Spatie\Permission\Models\Permission;

// function countUnfinishedForm() {
//     $user = Auth::user()->id;
//     $counAaction=0;
//     $counAllForm=0;
//     $counAllForm=ApplicationForm::where('user_id',$user)->count();
//     $datas=ApplicationForm::where('user_id',$user)->get();

//     foreach ($datas as $value) {
//         $counAaction +=FormProcessAction::where('application_form_id',$value->id)->count();
//     }

//     $result=$counAllForm-$counAaction;

//     return $result;
// }
function isActive($value) {
    $user = User::find($value);
    if (!$user->active) {
        return false;
    }
    return true;
}
function getFormProcessAction($id) {
    return FormProcessAction::where('application_form_id', $id)->first();
}
function admin() {
    return Auth::guard('admin')->user();
}
function who($value) {
    return Admin::find($value);
}
function admin_info($value) {
    return Admin::find($value);
}
function hasSurvey($id) {
    return FormSurvey::where('application_form_id', $id)->first();
}
function hasSurveyTsf($id) {
    return FormSurveyTransformer::where('application_form_id', $id)->first();
}
function hasUser($id) {
    return User::find($id);
}
function hasPermissionsAndGroupLvl($array, $g_lvl) {
    if (admin()->hasAnyPermission($array, 'admin') || ($g_lvl <= 2)) {
        return true;
    } else {
        return false;
    }
}
function hasPermissionsAndGroupLvlForContractor($array, $g_lvl) {
    if (admin()->hasAnyPermission($array, 'admin') || ($g_lvl <= 2)) {
        return true;
    } else {
        return false;
    }
}
// =========== chk permission for login-user
function hasPermissions($array) {
    if (admin()->hasAnyPermission($array, 'admin')) {
        return true;
    } else {
        return false;
    }
}
function accountHasRole($model) {
    return DB::table('roles')
        ->join('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
        ->where('model_has_roles.model_id', $model)
        ->get();
}
function roleHasPermission($role_id, $perm_id) {
    $state = false;
    $rolePermissions = DB::table("role_has_permissions")
        ->where([["role_has_permissions.role_id", $role_id], ["role_has_permissions.permission_id", $perm_id]])
        ->exists();
    if ($rolePermissions) {
        return $state = true;
    }
}
/* ===================================================== chk user lvl ===================================================== */
function same_div($id) {
    if (admin()->div_state == $id) {
        return true;
    }
}
function same_dist($id) {
    if (admin()->district == $id) {
        return true;
    }
}
function same_town($id) {
    if (admin()->township == $id) {
        return true;
    }
}
function check_div_dist_town($div_state, $dist, $town) {
    if (admin()->group_lvl == 4) {
        // div_state or MESC or YESC
        if (admin()->div_state == $div_state) {
            return true;
        }
    } elseif (admin()->group_lvl == 5) {
        // district
        if (admin()->div_state == $div_state && admin()->district == $dist) {
            return true;
        }
    } elseif (admin()->group_lvl == 6) {
        // township
        if (admin()->div_state == $div_state && admin()->district == $dist && admin()->township == $town) {
            return true;
        }
    }
}
/* ================================================== end of chk user lvl ================================================== */

/* ===================================================== chk group lvl ===================================================== */
// 
/* ================================================== end of chk group lvl ================================================== */
function apply_meter_type($value, $tsf_type = null) {
    if($value == 1){
        return checkMM() == 'mm' ? 'အိမ်သုံး မီတာ' : 'Residential Meter';
    }elseif($value == 2){
        return checkMM() == 'mm' ? 'အိမ်သုံး ပါဝါ မီတာ' : 'Residential Power Meter';
    }elseif($value == 3){
        return checkMM() == 'mm' ? 'စက်မှုသုံး ပါဝါ မီတာ ' : 'Commercial Power Meter';
    }elseif($value == 4){
        if($tsf_type == 1){
            return checkMM() == 'mm' ? 'အိမ်သုံးထရန်စဖော်မာ ' : 'Home-used Transformer';
        }elseif($tsf_type == 2){
            return checkMM() == 'mm' ? 'လုပ်ငန်းသုံးထရန်စဖော်မာ ' : 'Commercial Transformer';
        }else{
            return checkMM() == 'mm' ? 'ထရန်စဖော်မာ ' : 'Transformer';
        }
    }elseif($value == 5){
        return checkMM() == 'mm' ? 'ကန်ထရိုက်တိုက် မီတာ ' : 'Contractor Meter'; 
    }
}
function group($value) {
    switch ($value) {
        case '1': return checkMM() == 'mm' ? 'WebDev' : 'WebDev'; break;
        case '2': return checkMM() == 'mm' ? 'ဝန်ကြီးရုံး' : 'Ministry'; break;
        case '3': return checkMM() == 'mm' ? 'ရုံးချုပ်' : 'Head Office'; break;
        case '4': return checkMM() == 'mm' ? 'တိုင်း' : 'Divsion/State'; break;
        case '5': return checkMM() == 'mm' ? 'ခရိုင်' : 'District'; break;
        case '6': return checkMM() == 'mm' ? 'မြို့နယ်' : 'Township'; break;
        default: ''; break;
    }
}
function account_summary() {
    $a_all = Admin::where('active', '=', 1)->count();
    $v_all = Admin::where('email_verified_at', '!=', null)->count();
    $unv_all = Admin::where('email_verified_at', '=', null)->count();
    $d_all = Admin::where('active', '=', 0)->count();
    return ['a_all' => $a_all, 'v_all' => $v_all, 'unv_all' => $unv_all, 'd_all' => $d_all];
}
function user_account_summary() {
    $a_all = User::where('active', '=', 1)->count();
    $v_all = User::where('email_verified_at', '!=', null)->count();
    $unv_all = User::where('email_verified_at', '=', null)->count();
    $d_all = User::where('active', '=', 0)->count();
    return ['a_all' => $a_all, 'v_all' => $v_all, 'unv_all' => $unv_all, 'd_all' => $d_all];
}
function mmNum($value) {
    $input = $value;
    $mya = array('၀','၁','၂','၃','၄','၅','၆','၇','၈','၉');
    $eng = array('0','1','2','3','4','5','6','7','8','9');
    return str_replace($eng,$mya,$input);
}
function mmMonth($value) {
    switch($value) {
        case '1': return 'ဇန်နဝါရီ'; break;
        case '2': return 'ဖေဖော်ဝါရီ'; break;
        case '3': return 'မတ်'; break;
        case '4': return 'ဧပြီ'; break;
        case '5': return 'မေ'; break;
        case '6': return 'ဇွန်'; break;
        case '7': return 'ဇူလိုင်'; break;
        case '8': return 'သြဂတ်'; break;
        case '9': return 'စက်တင်ဘာ'; break;
        case '10': return 'အောက်တိုဘာ'; break;
        case '11': return 'နိုဝင်ဘာ'; break;
        case '12': return 'ဒီဇင်ဘာ'; break;
    }
}
function type($value) {
    switch($value) {
        case '1': return checkMM() == 'mm' ? 'အိမ်သုံး' : 'residential'; break;
        case '2': return checkMM() == 'mm' ? 'အိမ်သုံးပါဝါ' : 'residential power'; break;
        case '3': return checkMM() == 'mm' ? 'လုပ်ငန်းသုံးပါဝါ' : 'commercial power'; break;
        case '4': return checkMM() == 'mm' ? 'ထရန်စဖော်မာ' : 'transformer'; break;
        case '5': return checkMM() == 'mm' ? 'ကန်ထရိုက်တိုက်' : 'contractor'; break;
        case '6': return checkMM() == 'mm' ? 'ကျေးရွာမီးလင်းရေး' : 'village'; break;
        default: return 'none'; break;
    }
}
function checkMM() {
    if (Session::get('locale') == 'mm') {
        return 'mm';
    }
}
function lang() {
    return 'text-capitalize '.checkMM();
}
function active($value1, $value2, $value3) {
    if ($value1 == $value2) {
        if ($value3 == null) {
            return 'custom-active'; /* for user */
        } else {
            return 'active'; /* for admin */
        }
    }
}
function err_msg() {
    return checkMM() == 'mm' ? 'မရှိသေးပါ!' : 'something\'s wrong!';
}
function get_serial($value) {
    $code = getdate()[0];
    switch ($value) {
        case '1': return 'NPT-'.$code; break;
        case '2': return 'YGN-'.$code; break;
        case '3': return 'MDY-'.$code; break;
        case '4': return 'MGW-'.$code; break;
        case '5': return 'SHA-'.$code; break;
        case '6': return 'AYA-'.$code; break;
        case '7': return 'KYI-'.$code; break;
        case '8': return 'CHI-'.$code; break;
        case '9': return 'MON-'.$code; break;
        case '10': return 'TAN-'.$code; break;
        case '11': return 'BGO-'.$code; break;
        case '12': return 'KCH-'.$code; break;
        case '13': return 'SAG-'.$code; break;
        case '14': return 'KYA-'.$code; break;
        case '15': return 'RKH-'.$code; break;
        default: return 'ERRCODE-123978'; break;
    }
}
function get_random_string() {
    // $random = 'ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnpqrstuvwxyz123456789';
    // return substr(str_shuffle($random), 0, 6);
    return Str::random(6);
}
function div_state($value) {
    if ($value) {
        return checkMM() == 'mm' ? DivisionState::find($value)->name : DivisionState::find($value)->eng;
    }
}
function district($value) {
    if ($value) {
        return checkMM() == 'mm' ? District::find($value)->name : District::find($value)->eng;
    }
}
function township($value) {
    if ($value) {
        return checkMM() == 'mm' ? Township::find($value)->name : Township::find($value)->eng;
    }
}
function div_state_mm($value) {
    if ($value) {
        return DivisionState::find($value)->name;
    }
}
function district_mm($value) {
    if ($value) {
        return District::find($value)->name;
    }
}
function township_mm($value) {
    if ($value) {
        return Township::find($value)->name;
    }
}
// function roleDropdown() {
//     $user =  Auth::guard('admin')->user()->group_lvl;
//     // if ($user == 1) {
//         // return Role::pluck('name', 'name')->all();
//     // } elseif ($user == 2) {
//         return Role::where('id', '>', 1)->pluck('name', 'name')->all();
//     // }
// }
function roleDropdown() {
    $user =  Auth::guard('admin')->user();
    $user_gp_lvl =  $user->group_lvl;
    $user_division = $user->div_state;
    $user_id = $user->id;

    $roles = Role::select('roles.*')
    ->where('roles.id', '>', 1);

    if($user_id != 1){
        $roles = $roles->join('admins','admins.id','=','roles.admin_id');
        $roles->where('admins.div_state', $user_division); // roles created by same-division-acc
        if($user_gp_lvl == 2){ // ဝန်ကြီးရုံး gp
            $roles->orWhere('roles.id','3'); //  ဝန်ကြီးရုံး အဆင့်
        }elseif($user_gp_lvl == 3){ // နေပြည်တော်ရုံးချုပ် gp
            $roles->orWhere('roles.id','4'); // နေပြည်တော်ရုံးချုပ် အဆင့်
        }else{
            $roles->orWhere('roles.name','အငယ်တန်းအင်ဂျင်နီယာ');
            if($user_division != '2'){ // other divisions except yangon
                if($user_gp_lvl == 4){ // တိုင်း gp
                    $roles->orWhere('roles.id','6');//  ခရိုင်အဆင့်
                    $roles->orWhere('roles.id','7'); // မြို့နယ် အဆင့်
                }elseif($user_gp_lvl >= 5){ // ခရိုင် gp
                    $roles->orWhere('roles.id','7'); // မြို့နယ် အဆင့်
                }
            }
        }
    }
    

    // if ($user_gp_lvl == 1) { // super admin
        // return Role::pluck('name', 'name')->all();
    // } elseif ($user_gp_lvl == 2) { // ဝန်ကြီးရုံး
        return $roles->pluck('name', 'name')->all();
    // }
}
function roleKeyValueDropdown() {
    $user =  Auth::guard('admin')->user();
    $user_gp_lvl =  $user->group_lvl;
    $user_division = $user->div_state;
    $user_id = $user->id;

    $roles = Role::select('roles.*')
    ->where('roles.id', '>', 1);

    if($user_id != 1){
        $roles = $roles->join('admins','admins.id','=','roles.admin_id');
        $roles->where('admins.div_state', $user_division);
        if($user_gp_lvl == 2){ // ဝန်ကြီးရုံး gp
            $roles->orWhere('roles.id','3'); //  ဝန်ကြီးရုံး အဆင့်
        }elseif($user_gp_lvl == 3){ // နေပြည်တော်ရုံးချုပ် gp
            $roles->orWhere('roles.id','4'); // နေပြည်တော်ရုံးချုပ် အဆင့်
        }else{
            $roles->orWhere('roles.name','အငယ်တန်းအင်ဂျင်နီယာ');
            if($user_division != '2'){ // other division
                if($user_gp_lvl == 4){ // တိုင်း gp
                    $roles->orWhere('roles.id','6');//  ခရိုင်အဆင့်
                    $roles->orWhere('roles.id','7'); // မြို့နယ် အဆင့်
                }elseif($user_gp_lvl >= 5){ // ခရိုင် gp
                    $roles->orWhere('roles.id','7'); // မြို့နယ် အဆင့်
                }
            }
        }
    }

    // if ($user_gp_lvl == 1) { // super admin
        // return Role::pluck('name', 'name')->all();
    // } elseif ($user_gp_lvl == 2) { // ဝန်ကြီးရုံး
        return $roles->pluck('name', 'id')->all();
    // }
}
function groupDropDown() {
    $user_gp =  Auth::guard('admin')->user()->group_lvl;
    if($user_gp == 1){
        return [
            '2' => checkMM() == 'mm' ? 'ဝန်ကြီးရုံး' : 'Ministry',
            '3' => checkMM() == 'mm' ? 'နေပြည်တော်ရုံးချုပ်' : 'Head Office',
            '4' => checkMM() == 'mm' ? 'တိုင်း(MESCရုံးချုပ် / YESCရုံးချုပ်)' : 'Divsion/State(MESC/YESC)',
            '5' => checkMM() == 'mm' ? 'ခရိုင်' : 'District',
            '6' => checkMM() == 'mm' ? 'မြို့နယ်' : 'Township',
        ];
    }else if($user_gp == 2){
        return [
            '2' => checkMM() == 'mm' ? 'ဝန်ကြီးရုံး' : 'Ministry'
        ];
    }else if($user_gp == 3){
        return [
            '3' => checkMM() == 'mm' ? 'နေပြည်တော်ရုံးချုပ်' : 'Head Office',
        ];
    }else if($user_gp == 4){
        return [
            '5' => checkMM() == 'mm' ? 'ခရိုင်' : 'District',
            '6' => checkMM() == 'mm' ? 'မြို့နယ်' : 'Township',
        ];
    }else{
        return [
            '6' => checkMM() == 'mm' ? 'မြို့နယ်' : 'Township',
        ];
    }
}
function regionsDropdown() {

    // if (checkMM() == 'mm') {
    //     return DivisionState::pluck('name', 'id')->all();
    // } else {
    //     return DivisionState::pluck('eng', 'id')->all();
    // }

    $user =  Auth::guard('admin')->user();
    $user_gp_lvl =  $user->group_lvl;
    $user_division = $user->div_state;

    $div_st = DivisionState::select('*');

    if($user_gp_lvl >= 4){ // တိုင်း ခရိုင် မြို့နယ်
        $div_st->where('id', $user_division);
    }

    if (checkMM() == 'mm') {
        return $div_st->pluck('name', 'id')->all();
    } else {
        return $div_st->pluck('eng', 'id')->all();
    }

    
}
function districtsDropdown() {
    // if (checkMM() == 'mm') {
    //     return District::pluck('name', 'id')->all();
    // } else {
    //     return District::pluck('eng', 'id')->all();
    // }

    $user =  Auth::guard('admin')->user();
    $user_gp_lvl =  $user->group_lvl;
    $user_division = $user->div_state;
    $user_district = $user->district;

    $district = District::select('*');

    if($user_gp_lvl == 4){ //  တိုင်း
        $district->where('division_state_id', $user_division);
    }elseif($user_gp_lvl >= 5){ //  ခရိုင် မြို့နယ်
        $district->where('id', $user_district);
    }

    if (checkMM() == 'mm') {
        return $district->pluck('name', 'id')->all();
    } else {
        return $district->pluck('eng', 'id')->all();
    }
}
function townshipsDropdown() {
    // if (checkMM() == 'mm') {
    //     return Township::pluck('name', 'id')->all();
    // } else {
    //     return Township::pluck('eng', 'id')->all();
    // }

    $user =  Auth::guard('admin')->user();
    $user_gp_lvl =  $user->group_lvl;
    $user_division = $user->div_state;
    $user_district = $user->district;
    $user_township = $user->township;

    $township = Township::select('*');

    if($user_gp_lvl == 4){ //  တိုင်း
        $township->where('division_state_id', $user_division);
    }elseif($user_gp_lvl == 5){ //  ခရိုင် 
        $township->where('id', $user_district);
    }elseif($user_gp_lvl >= 5){ //  မြို့နယ်
        $township->where('id', $user_township);
    }

    if (checkMM() == 'mm') {
        return $township->pluck('name', 'id')->all();
    } else {
        return $township->pluck('eng', 'id')->all();
    }
}
function chkbox_name($value) {
    if (strpos($value, 'view')) {
        $name = 'read';
    } elseif (strpos($value, 'create')) {
        $name = 'write';
    } elseif (strpos($value, 'edit')) {
        $name = 'edit';
    } elseif (strpos($value, 'delete')) {
        $name = 'delete';
    } elseif (strpos($value, 'show')) {
        $name = 'detailRead';
    } elseif (strpos($value, 'confirm')) {
        $name = 'confirm';
    }
    return $name;
}
function building_type_dropdown() {
    if (checkMM() == 'mm') {
        return ['1' => 'နေအိမ်', '2' => 'ရုံး'];
    } else {
        return ['1' => 'home', '2' => 'office'];
    }
}
function building_type_mm($value) {
    switch ($value) {
        case '1': return 'နေအိမ်'; break;
        case '2': return 'ရုံး'; break;
        default: 'မှားယွင်းနေပါသည်"'; break;
    }
}
function building_type($value) {
    switch ($value) {
        case '1': return 'Home'; break;
        case '2': return 'Office'; break;        
        default: return 'မှားယွင်းနေပါသည် ..'; break;
    }
}
function applied_meter_mm($value) {
    switch ($value) {
        case '1': return '၁ သွင် ၂ ကြိုး'; break;
        case '2': return '၃ သွင် ၄ ကြိုး'; break;        
        default: return 'မှားယွင်းနေပါသည် ..'; break;
    }
}
function address_mm($value) {
    $form = ApplicationForm::find($value);
    $home_no = $form->applied_home_no ? 'အမှတ် ('.$form->applied_home_no.')၊' : '';
    $building = $form->applied_building ? 'တိုက်အမှတ် ('.$form->applied_building.')၊' : '';
    $lane = $form->applied_lane ? $form->applied_lane.'၊' : '';
    $street = $form->applied_street ? $form->applied_street.'၊' : '';
    $quarter = $form->applied_quarter ? $form->applied_quarter.'၊' : '';
    $town = $form->applied_town ? $form->applied_town.'၊' : '';
    $township = $form->township_id ? township_mm($form->township_id).'၊' : '';
    $district = $form->district_id ? district_mm($form->district_id).'၊' : '';
    $div_state = $form->div_state_id ? div_state_mm($form->div_state_id).'၊' : '';
    if ($form->applied_home_no) {
        return $home_no.' '.$building.' '.$lane.' '.$street.' '.$quarter.' '.$town.' '.$township.' '.$district.' '.$div_state;
    } else {
        return null;
    }
}
function address($value) {
    $form = ApplicationForm::find($value);
    if (checkMM() == 'mm') {
        $home_no = $form->applied_home_no ? 'အမှတ် ('.$form->applied_home_no.')၊' : '';
        $building = $form->applied_building ? 'တိုက်အမှတ် ('.$form->applied_building.')၊' : '';
        $lane = $form->applied_lane ? $form->applied_lane.'၊' : '';
        $street = $form->applied_street ? $form->applied_street.'၊' : '';
        $quarter = $form->applied_quarter ? $form->applied_quarter.'၊' : '';
        $town = $form->applied_town ? $form->applied_town.'၊' : '';
        return $home_no.' '.$building.' '.$lane.' '.$street.' '.$quarter.' '.$town.' '.township_mm($form->township_id).'၊ '.district_mm($form->district_id).'၊ '.div_state_mm($form->div_state_id);
    } else {
        $home_no = $form->applied_home_no ? 'No ('.$form->applied_home_no.'),' : '';
        $building = $form->applied_building ? 'Building ('.$form->applied_building.'),' : '';
        $lane = $form->applied_lane ? $form->applied_lane.' Lane,' : '';
        $street = $form->applied_street ? $form->applied_street.' Street,' : '';
        $quarter = $form->applied_quarter ? $form->applied_quarter.' Quarter,' : '';
        $town = $form->applied_town ? $form->applied_town.' Town,' : '';
        return $home_no.' '.$building.' '.$lane.' '.$street.' '.$quarter.' '.$town.' '.township($form->township_id).', '.district($form->district_id).', '.div_state($form->div_state_id).'.';
    }
}
function sent_date($form_id) {
    $form = ApplicationForm::find($form_id);
    if (checkMM() == 'mm') {
        return mmMonth(date('m', strtotime($form->date))).' '.mmNum(date('d', strtotime($form->date))).', '.mmNum(date('Y', strtotime($form->date)));
    } else {
        return date('M d, Y', strtotime($form->date));
    }
}
function accepted_date($form_id) {
    $form = ApplicationForm::find($form_id);
    $f_actions = $form->form_actions;
    foreach ($f_actions as $data) {
        if ($data->form_accept) {
            if (checkMM() == 'mm') {
                return mmMonth(date('m', strtotime($data->accepted_date))).' '.mmNum(date('d', strtotime($data->accepted_date))).', '.mmNum(date('Y', strtotime($data->accepted_date)));
            } else {
                return date('M d, Y', strtotime($data->accepted_date));
            }
        }
    }
}
function survey_accepted_date($form_id) {
    $form = ApplicationForm::find($form_id);
    $f_actions = $form->form_actions;
    foreach ($f_actions as $data) {
        if ($data->survey_accept) {
            if (checkMM() == 'mm') {
                return mmMonth(date('m', strtotime($data->survey_accepted_date))).' '.mmNum(date('d', strtotime($data->survey_accepted_date))).', '.mmNum(date('Y', strtotime($data->survey_accepted_date)));
            } else {
                return date('M d, Y', strtotime($data->survey_accepted_date));
            }
        }
    }
}
function survey_confirmed_date($form_id) {
    $form = ApplicationForm::find($form_id);
    $f_actions = $form->form_actions;
    foreach ($f_actions as $data) {
        if ($data->survey_confirm) {
            if (checkMM() == 'mm') {
                return mmMonth(date('m', strtotime($data->survey_confirmed_date))).' '.mmNum(date('d', strtotime($data->survey_confirmed_date))).', '.mmNum(date('Y', strtotime($data->survey_confirmed_date)));
            } else {
                return date('M d, Y', strtotime($data->survey_confirmed_date));
            }
        } elseif ($data->survey_confirm_dist) {
            if (checkMM() == 'mm') {
                return mmMonth(date('m', strtotime($data->survey_confirmed_dist_date))).' '.mmNum(date('d', strtotime($data->survey_confirmed_dist_date))).', '.mmNum(date('Y', strtotime($data->survey_confirmed_dist_date)));
            } else {
                return date('M d, Y', strtotime($data->survey_confirmed_dist_date));
            }
        } elseif ($data->survey_confirm_div_state) {
            if (checkMM() == 'mm') {
                return mmMonth(date('m', strtotime($data->survey_confirmed_div_state_date))).' '.mmNum(date('d', strtotime($data->survey_confirmed_div_state_date))).', '.mmNum(date('Y', strtotime($data->survey_confirmed_div_state_date)));
            } else {
                return date('M d, Y', strtotime($data->survey_confirmed_div_state_date));
            }
        }
    }
}
function announced_date($form_id) {
    $form = ApplicationForm::find($form_id);
    $f_actions = $form->form_actions;
    foreach ($f_actions as $data) {
        if ($data->announce) {
            if (checkMM() == 'mm') {
                return mmMonth(date('m', strtotime($data->announced_date))).' '.mmNum(date('d', strtotime($data->announced_date))).', '.mmNum(date('Y', strtotime($data->announced_date)));
            } else {
                return date('M d, Y', strtotime($data->announced_date));
            }
        }
    }
}
function user_paid_date($form_id) {
    $form = ApplicationForm::find($form_id);
    $f_actions = $form->form_actions;
    foreach ($f_actions as $data) {
        if ($data->user_pay) {
            if (checkMM() == 'mm') {
                return mmMonth(date('m', strtotime($data->user_paid_date))).' '.mmNum(date('d', strtotime($data->user_paid_date))).', '.mmNum(date('Y', strtotime($data->user_paid_date)));
            } else {
                return date('M d, Y', strtotime($data->user_paid_date));
            }
        }
    }
}
function payment_accepted_date($form_id) {
    $form = ApplicationForm::find($form_id);
    $f_actions = $form->form_actions;
    foreach ($f_actions as $data) {
        if ($data->payment_accept) {
            if (checkMM() == 'mm') {
                return mmMonth(date('m', strtotime($data->payment_accepted_date))).' '.mmNum(date('d', strtotime($data->payment_accepted_date))).', '.mmNum(date('Y', strtotime($data->payment_accepted_date)));
            } else {
                return date('M d, Y', strtotime($data->payment_accepted_date));
            }
        }
    }
}
function contracted_date($form_id) {
    $form = ApplicationForm::find($form_id);
    $f_actions = $form->form_actions;
    foreach ($f_actions as $data) {
        if ($data->contract) {
            if (checkMM() == 'mm') {
                return mmMonth(date('m', strtotime($data->contracted_date))).' '.mmNum(date('d', strtotime($data->contracted_date))).', '.mmNum(date('Y', strtotime($data->contracted_date)));
            } else {
                return date('M d, Y', strtotime($data->contracted_date));
            }
        }
    }
}
function install_accepted_date($form_id) {
    $form = ApplicationForm::find($form_id);
    $f_actions = $form->form_actions;
    foreach ($f_actions as $data) {
        if ($data->install_accept) {
            if (checkMM() == 'mm') {
                return mmMonth(date('m', strtotime($data->install_accepted_date))).' '.mmNum(date('d', strtotime($data->install_accepted_date))).', '.mmNum(date('Y', strtotime($data->install_accepted_date)));
            } else {
                return date('M d, Y', strtotime($data->install_accepted_date));
            }
        }
    }
}
function install_confirmed_date($form_id) {
    $form = ApplicationForm::find($form_id);
    $f_actions = $form->form_actions;
    foreach ($f_actions as $data) {
        if ($data->install_confirm) {
            if (checkMM() == 'mm') {
                return mmMonth(date('m', strtotime($data->install_confirmed_date))).' '.mmNum(date('d', strtotime($data->install_confirmed_date))).', '.mmNum(date('Y', strtotime($data->install_confirmed_date)));
            } else {
                return date('M d, Y', strtotime($data->install_confirmed_date));
            }
        }
    }
}
function registered_meter_date($form_id) {
    $form = ApplicationForm::find($form_id);
    $f_actions = $form->form_actions;
    foreach ($f_actions as $data) {
        if ($data->register_meter) {
            if (checkMM() == 'mm') {
                return mmMonth(date('m', strtotime($data->registered_meter_date))).' '.mmNum(date('d', strtotime($data->registered_meter_date))).', '.mmNum(date('Y', strtotime($data->registered_meter_date)));
            } else {
                return date('M d, Y', strtotime($data->registered_meter_date));
            }
        }
    }
}
function chk_cdt($apply_type) {
    $user = Auth::user()->id;
    if ($apply_type !== null) {
        $form = ApplicationForm::where([['user_id', $user], ['apply_type', $apply_type]])->get();
    } else {
        $form = ApplicationForm::where('user_id', $user)->get();
    }
    $unfinished_ID = [];
    $unfinished_route = [];
    $count = 0;
    foreach ($form as $key) {
        $file = $key->application_files;
        if (!$key->fullname) {
            array_push($unfinished_ID, $key->id);
            array_push($unfinished_route, 1); /* user info */
            $count++;
        } else {
            if ($file->count() > 0) {
                foreach ($file as $value) {

                    // residential and residential power 
                    if ($apply_type == 1 || $apply_type == 2) {
                        if (!$value->form_10_front) {
                            array_push($unfinished_ID, $key->id);
                            array_push($unfinished_route, 3); /* form 10 */
                            $count++;
                        } elseif (!$value->occupy_letter) {
                            array_push($unfinished_ID, $key->id);
                            array_push($unfinished_route, 4); /* recomm letter */
                            $count++;
                        } elseif (!$value->ownership) {
                            array_push($unfinished_ID, $key->id);
                            array_push($unfinished_route, 5); /* owner */
                            $count++;
                        }
                        
                        // if yangon
                        if ($key->apply_division == 1) {
                            if (!$value->building) { // အဆောက်အဦ ဓါတ်ပုံ
                                array_push($unfinished_ID, $key->id);
                                array_push($unfinished_route, 9); /* bill list */
                                $count++;
                            }
                            if (!$value->electric_power) { // ဝန်အားစာရင်း
                                array_push($unfinished_ID, $key->id);
                                array_push($unfinished_route, 9); /* bill list */
                                $count++;
                            }
                        }        

                        // // *** if it's mandalay residential power meter and city or ministry isn't set,
                        // if((!$value->city_license || !$value->ministry_permit) && $apply_type == 2 && $key->apply_division == 3){  
                        //     array_push($unfinished_ID, $key->id);
                        //     array_push($unfinished_route, 9); /* building */
                        //     $count++;
                        // }
                    } 

                    // commercial power
                    elseif ($apply_type == 3) {
                        if (!$value->form_10_front) {
                            array_push($unfinished_ID, $key->id);
                            array_push($unfinished_route, 3); /* form 10 */
                            $count++;
                        } elseif (!$value->occupy_letter) {
                            array_push($unfinished_ID, $key->id);
                            array_push($unfinished_route, 4); /* recomm letter */
                            $count++;
                        } elseif (!$value->ownership) {
                            array_push($unfinished_ID, $key->id);
                            array_push($unfinished_route, 5); /* owner */
                            $count++;
                        } elseif (!$value->transaction_licence) { /* commercial */
                            array_push($unfinished_ID, $key->id);
                            array_push($unfinished_route, 6); /* bussiness lisence */
                            $count++;
                        }
                        // *** if it's mandalay residential power meter and city or ministry isn't set,
                        elseif((!$value->city_license) && $key->apply_division == 3){  
                            array_push($unfinished_ID, $key->id);
                            array_push($unfinished_route, 9); /* building */
                            $count++;
                        }

                        if($key->apply_division == 1){ // if yangon
                            if (!$value->building) { // အဆောက်အဦ ဓါတ်ပုံ
                                array_push($unfinished_ID, $key->id);
                                array_push($unfinished_route, 9); /* building */
                                $count++;
                            }
                            if (!$value->electric_power) { // ဝန်အားစာရင်း
                                array_push($unfinished_ID, $key->id);
                                array_push($unfinished_route, 9); /* building */
                                $count++;
                            }
                        }
                    } 
                    
                    // transformer
                    elseif ($apply_type == 4) { 
                        if ($key->is_religion) {
                            if (!$value->ownership) {
                                array_push($unfinished_ID, $key->id);
                                array_push($unfinished_route, 5); /* owner */
                                $count++;
                            }elseif (!$value->dc_recomm) { /* contractor */
                                array_push($unfinished_ID, $key->id);
                                array_push($unfinished_route, 8); /* dc_recomm list */
                                $count++;
                            }
                        } else {
                            if (!$value->form_10_front) {
                                array_push($unfinished_ID, $key->id);
                                array_push($unfinished_route, 3); /* form 10 */
                                $count++;
                            } elseif (!$value->occupy_letter) {
                                array_push($unfinished_ID, $key->id);
                                array_push($unfinished_route, 4); /* recomm letter */
                                $count++;
                            } elseif (!$value->ownership) {
                                array_push($unfinished_ID, $key->id);
                                array_push($unfinished_route, 5); /* owner */
                                $count++;
                            } 
                            
                            elseif (!$value->dc_recomm) {
                                if(!($key->div_state_id == '3' && $key->is_light)){
                                    array_push($unfinished_ID, $key->id);
                                    array_push($unfinished_route, 8); /* dc_recomm list */
                                    $count++;
                                }
                            }
                        }

                        // if yangon commercial transformer
                        if($key->apply_division == 1 && $key->apply_tsf_type == 2){ 
                            if (!$value->transaction_licence && !$key->is_religion) {// လုပ်ငန်းလိုင်စင် and ဘာသာ/သာသနာ
                                array_push($unfinished_ID, $key->id);
                                array_push($unfinished_route, 8); /* dc_recomm list */
                                $count++;
                            }
                        }

                        if($key->apply_division == 1){
                            if (!$value->electric_power) { // ဝန်အားစာရင်း
                                array_push($unfinished_ID, $key->id);
                                array_push($unfinished_route, 8); 
                                $count++;
                            }
                        }
 
                    } 
                    
                    // constractor
                    elseif ($apply_type == 5) {
                        if (!$value->form_10_front) {
                            array_push($unfinished_ID, $key->id);
                            array_push($unfinished_route, 3); /* form 10 */
                            $count++;
                        } elseif (!$value->occupy_letter) {
                            array_push($unfinished_ID, $key->id);
                            array_push($unfinished_route, 4); /* recomm letter */
                            $count++;
                        } elseif (!$value->ownership) {
                            array_push($unfinished_ID, $key->id);
                            array_push($unfinished_route, 5); /* owner */
                            $count++;
                        } elseif (!$value->building_permit && $apply_type == 5) { /* contractor */
                            array_push($unfinished_ID, $key->id);
                            array_push($unfinished_route, 6); /* permit list */
                            $count++;
                        } elseif (!$value->bcc && $apply_type == 5) { /* contractor */
                            array_push($unfinished_ID, $key->id);
                            array_push($unfinished_route, 7); /* bcc list */
                            $count++;
                        } elseif (!$value->dc_recomm && $apply_type == 5) { /* contractor */
                            array_push($unfinished_ID, $key->id);
                            array_push($unfinished_route, 8); /* dc_recomm list */
                            $count++;
                        } elseif (!$value->prev_bill && $apply_type == 5) { /* contractor */
                            array_push($unfinished_ID, $key->id);
                            array_push($unfinished_route, 9); /* bill list */
                            $count++;
                        }

                        // *** if it's yangon,
                        if($key->apply_division == 1){
                            if (!$value->building) {
                                array_push($unfinished_ID, $key->id);
                                array_push($unfinished_route, 9); /* bill list */
                                $count++;
                            }
                            if (!$value->bq) {
                                array_push($unfinished_ID, $key->id);
                                array_push($unfinished_route, 10); /* bq */
                                $count++;
                            }
                            if (!$value->drawing) {
                                array_push($unfinished_ID, $key->id);
                                array_push($unfinished_route, 11); /* drawing */
                                $count++;
                            }
                            if (!$value->map) {
                                array_push($unfinished_ID, $key->id);
                                array_push($unfinished_route, 12); /* map */
                                $count++;
                            }
                        }

                    }
                }
            } else {
                array_push($unfinished_ID, $key->id);
                array_push($unfinished_route, 2); /* nrc */
                $count++;
            }
        }
    }

    return ['id' => $unfinished_ID, 'route' => $unfinished_route, 'count' => $count]; /* return int ID and int route */
}
function cdt($form_id) { /* condition */
    $form = ApplicationForm::find($form_id);

    // $data = chk_cdt(); /* id and route  || get form_id */
    $status = 'finished_form';
    $color = 'text-success';
    if ($form->apply_division == 1) {
        if ($form->apply_type == 1) {
            $data = chk_cdt(1); /* id and route  || get form_id */
            $route = 'resident_applied_form_ygn';
        } elseif ($form->apply_type == 2) {
            $data = chk_cdt(2); /* id and route  || get form_id */
            $route = 'resident_power_applied_form_ygn';
        } elseif ($form->apply_type == 3) {
            $data = chk_cdt(3); /* id and route  || get form_id */
            $route = 'commercial_applied_form_ygn';
        } elseif ($form->apply_type == 4) {
            $data = chk_cdt(4);
            $route = 'tsf_applied_form_ygn';
        } else {
            $data = chk_cdt(5);
            $route = 'contractor_applied_form_ygn';
        }
    } elseif ($form->apply_division == 2) {
        if ($form->apply_type == 1) {
            $data = chk_cdt(1); /* id and route  || get form_id */
            $route = 'resident_applied_form';
        } elseif ($form->apply_type == 2) {
            $data = chk_cdt(2); /* id and route  || get form_id */
            $route = 'resident_power_applied_form';
        } elseif ($form->apply_type == 3) {
            $data = chk_cdt(3); /* id and route  || get form_id */
            $route = 'commercial_applied_form';
        } elseif ($form->apply_type == 4) {
            $data = chk_cdt(4);
            $route = 'tsf_applied_form';
        } else {
            $data = chk_cdt(5);
            $route = 'contractor_applied_form';
        }
    }elseif ($form->apply_division == 3) {
        if ($form->apply_type == 1) {
            $data = chk_cdt(1); /* id and route  || get form_id */
            $route = 'resident_applied_form_mdy';
        } elseif ($form->apply_type == 2) {
            $data = chk_cdt(2); /* id and route  || get form_id */
            $route = 'resident_power_applied_form_mdy';
        } elseif ($form->apply_type == 3) {
            $data = chk_cdt(3); /* id and route  || get form_id */
            $route = 'commercial_applied_form_mdy';
        } elseif ($form->apply_type == 4) {
            $data = chk_cdt(4);
            $route = 'tsf_applied_form_mdy';
        } else {
            $data = chk_cdt(5);
            $route = 'contractor_applied_form_mdy';
        }
    } else{ // npt
        if ($form->apply_type == 1) {
            $data = chk_cdt(1); /* id and route  || get form_id */
            $route = 'resident_applied_form';
        } elseif ($form->apply_type == 2) {
            $data = chk_cdt(2); /* id and route  || get form_id */
            $route = 'resident_power_applied_form';
        } elseif ($form->apply_type == 3) {
            $data = chk_cdt(3); /* id and route  || get form_id */
            $route = 'commercial_applied_form';
        } elseif ($form->apply_type == 4) {
            $data = chk_cdt(4);
            $route = 'tsf_applied_form';
        } else {
            $data = chk_cdt(5);
            $route = 'contractor_applied_form';
        }
    }
    if (count($data['id']) > 0) {
        $index = array_search($form_id, $data['id'], true);
        if (is_int($index)) {
            $status = 'unfinished_form';
            $color = 'text-danger';
        }
    }
    return [$status, $route, $color];
}
function chk_send($form_id) {
    $form = ApplicationForm::find($form_id);
    $form_action = $form->form_actions;
    if ($form_action) {
        foreach ($form_action as $send) {
            if ($send->user_send_to_office) {
                return 'first';
            } else {
                if ($send->user_send_form_date !== null) {
                    return 'second';
                }
            }
        }
    }
}
function chk_form_finish($id, $type) {
    $form = ApplicationForm::where([['id', $id], ['apply_type', $type]])->first();
    $files = $form->application_files;
    /* 1 => nrc, 2 => form 10, 3 => occupy letter, 4 => ownership, 5 => electric power, 6 => building permit, 7 => bcc, 8 => dc recomm, 9 => bill, 10 => license */
    /* state => chk its all true or all false */
    $type1 = $type2 = $type3 = $type4 = $type5 = $type6 =  $type7 = $type8 = $type9 = $type10 = $type11 = $type12 = $type13 = $type14 = $type15 = $type16 = $type17 = $type18 = $type19 = FALSE;
    $state = TRUE;
    if ($type == 1 || $type == 2) { /* residential OR residential Power*/
        if ($files->count() > 0) {
            foreach ($files as $file) {
                if (!$file->nrc_copy_fron && !$file->nrc_copy_back) {
                    $type1 = TRUE;
                    $state = FALSE;
                }
                if (!$file->form_10_front) {
                    $type2 = TRUE;
                    $state = FALSE;
                }
                if (!$file->occupy_letter && !$file->no_invade_letter) {
                    $type3 = TRUE;
                    $state = FALSE;
                }
                if (!$file->ownership) {
                    $type4 = TRUE;
                    $state = FALSE;
                }
                // *** if it's yangon residential meter,
                if($form->apply_division == 1 && $type == 1){  
                    if (!$file->farmland) {
                        $type13 = TRUE;
                    }
                    if (!$file->building) {
                        $type15 = TRUE;
                        $state = FALSE;
                    }
                    if (!$file->electric_power) {
                        $type5 = TRUE;
                        $state = FALSE;
                    }
                }
                if($type == 2){ // residential power meter

                    // *** if yangon,
                    if ($form->apply_division == 1) {
                        if (!$file->prev_bill) {
                            $type9 = TRUE;
                        }
    
                        if (!$file->farmland) { // လယ်ယာ
                            $type13 = TRUE;
                        }
                        if (!$file->building) { // အဆောက်အဦ ဓါတ်ပုံ
                            $type15 = TRUE;
                            $state = FALSE;
                        }
                        if (!$file->electric_power) { // ဝန်အားစာရင်း
                            $type5 = TRUE;
                            $state = FALSE;
                        }
                    }

                    // *** if other,
                    if ($form->apply_division == 2) {
                        // if (!$file->prev_bill) {
                        //     $type9 = TRUE;
                        //     $state = FALSE;
                        // }
                    }
                    
                    
                    // *** if mandalay,
                    // if ($form->apply_division == 3) {

                    //     if (!$file->city_license) {
                    //         $type11 = TRUE;
                    //         $state = FALSE;
                    //     }

                    //     if (!$file->ministry_permit) {
                    //         $type12 = TRUE;
                    //         $state = FALSE;
                    //     }
                    // }

                }
            }
        } else {
            $type1 = $type2 = $type3 = $type4 = $type5 = $type6 = $type9 = $type11 = $type12 = $type13 = $type15 = TRUE;
            $state = FALSE;
        }
    } elseif ($type == 3) { /* commercial */
        if ($files->count() > 0) {
            foreach ($files as $file) {
                if (!$file->nrc_copy_fron && !$file->nrc_copy_back) {
                    $type1 = TRUE;
                    $state = FALSE;
                }
                if (!$file->form_10_front) {
                    $type2 = TRUE;
                    $state = FALSE;
                }
                if (!$file->occupy_letter && !$file->no_invade_letter) {
                    $type3 = TRUE;
                    $state = FALSE;
                }
                if (!$file->ownership) {
                    $type4 = TRUE;
                    $state = FALSE;
                }
                if (!$file->transaction_licence) { // လုပ်ငန်းလိုင်စင်
                    $type10 = TRUE;
                    $state = FALSE;
                }
                // *** if mandalay,
                if ($form->apply_division == 3) {
                    if (!$file->city_license) { // စည်ပင်သာယာလိုင်စင်
                        $type11 = TRUE;
                        $state = FALSE;
                    }
                    if (!$file->ministry_permit) { // သက်ဆိုင်ရာဝန်ကြီးဌာန် ခွင့်ပြုချက်
                        $type12 = TRUE;
                        // $state = FALSE;
                    }
                }
                if($form->apply_division == 1){ // if yangon

                    if (!$file->prev_bill) {
                        $type9 = TRUE;
                    }

                    if (!$file->farmland) { // လယ်ယာ
                        $type13 = TRUE;
                    }
                    if (!$file->building) { // အဆောက်အဦ ဓါတ်ပုံ
                        $type15 = TRUE;
                        $state = FALSE;
                    }
                    if (!$file->electric_power) { // ဝန်အားစာရင်း
                        $type5 = TRUE;
                        $state = FALSE;
                    }
                }
            }
        } else {
            $type1 = $type2 = $type3 = $type4 = $type10 = TRUE;
            $state = FALSE;
        }
    } elseif ($type == 4) { /* transformer */
        if ($files->count() > 0) {
            if ($form->is_religion) { // ဘာသာ/သာသနာအတွက် ဖြစ်ပါက
                foreach ($files as $file) {
                    if (!$file->nrc_copy_front && !$file->nrc_copy_back) {// မှတ်ပုံတင်အမှတ်
                        $type1 = TRUE;
                        $state = FALSE;
                    }
                    if (!$file->ownership) {// ပိုင်ဆိုင်မှုစာရွက်စာတမ်း
                        $type4 = TRUE;
                        $state = FALSE;
                    }
                    // *** if it's mandalay and is_light transformer
                    if($form->div_state_id == '3'){ 
                        if (!$file->dc_recomm && !$form->is_light) {// စည်ပင်ထောက်ခံစာဓါတ်ပုံ
                            $type8 = TRUE;
                            $state = FALSE;
                        }
                    }else{
                        if (!$file->dc_recomm) { // စည်ပင်ထောက်ခံစာဓါတ်ပုံ
                            $type8 = TRUE;
                            $state = FALSE;
                        }
                    }
                }
            } else {
                foreach ($files as $file) {
                    if (!$file->nrc_copy_fron && !$file->nrc_copy_back) { // မှတ်ပုံတင်အမှတ်
                        $type1 = TRUE;
                        $state = FALSE;
                    }
                    if (!$file->form_10_front) { // အိမ်ထောင်စုစာရင်း
                        $type2 = TRUE;
                        $state = FALSE;
                    }
                    if (!$file->occupy_letter && !$file->no_invade_letter) { //ထောက်ခံစာ
                        $type3 = TRUE;
                        $state = FALSE;
                    }
                    if (!$file->ownership) { // ပိုင်ဆိုင်မှုစာရွက်စာတမ်း
                        $type4 = TRUE;
                        $state = FALSE;
                    }
                    if (!$file->transaction_licence) { // လုပ်ငန်းလိုင်စင်
                        $type10 = TRUE;
                        if ($form->apply_tsf_type == '2') { // လုပ်ငန်းသုံး transformer
                            $state = FALSE;
                        }
                    }
                    // *** if it's mandalay and is_light transformer
                    if($form->div_state_id == '3'){
                        if (!$file->dc_recomm  && !$form->is_light) { // စည်ပင်ထောက်ခံစာဓါတ်ပုံ
                            $type8 = TRUE;
                            $state = FALSE; 
                        }
                    }else{
                        if (!$file->dc_recomm) { // စည်ပင်ထောက်ခံစာဓါတ်ပုံ
                            $type8 = TRUE;
                            $state = FALSE;
                        }
                    }
                }
            }

            // if yangon commercial transformer
            if($form->apply_division == 1 && $form->apply_tsf_type == 2){ 
                if (!$file->transaction_licence) {// လုပ်ငန်းလိုင်စင်
                    $type10 = TRUE;
                    if(!$form->is_religion){
                        $state = FALSE;
                    }
                }
            }

            if($form->apply_division == 1){ // if yangon,
                if(!$file->industry){ // industry zone
                    $type14 = TRUE;
                }
                if (!$file->farmland) {
                    $type13 = TRUE;
                }
                if (!$file->electric_power) { // ဝန်အားစာရင်း
                    $type5 = TRUE;
                    $state = FALSE;
                }
            }


        } else {
            $type1 = $type2 = $type3 = $type4 = $type8 = $type10 = $type13 = $type14 = TRUE;
            $state = FALSE;
        }
    } elseif ($type == 5) { /* contractor */
        if ($files->count() > 0) {
            foreach ($files as $file) {
                if (!$file->nrc_copy_fron && !$file->nrc_copy_back) {
                    $type1 = TRUE;
                    $state = FALSE;
                }
                if (!$file->form_10_front) {
                    $type2 = TRUE;
                    $state = FALSE;
                }
                if (!$file->occupy_letter && !$file->no_invade_letter) {
                    $type3 = TRUE;
                    $state = FALSE;
                }
                if (!$file->ownership) {
                    $type4 = TRUE;
                    $state = FALSE;
                }
                if (!$file->building_permit) {
                    $type6 = TRUE;
                    $state = FALSE;
                }
                if (!$file->bcc) { // လူနေထိုင်ခွင့်
                    $type7 = TRUE;
                    $state = FALSE;
                }
                if (!$file->dc_recomm) {  // စည်ပင်ထောက်ခံစာ
                    $type8 = TRUE;
                    $state = FALSE;
                }
                if (!$file->prev_bill) { // ယာယီမီတာ ချလံ
                    $type9 = TRUE;
                    $state = FALSE;
                }


                // *** if it's yangon,
                if($form->apply_division == 1){  
                    if (!$file->farmland) {
                        $type13 = TRUE;
                    }
                    if (!$file->building) {
                        $type15 = TRUE;
                        $state = FALSE;
                    }
                    if (!$file->bq) {
                        $type16 = TRUE;
                        $state = FALSE;
                    }
                    if (!$file->drawing) {
                        $type17 = TRUE;
                        $state = FALSE;
                    }
                    if (!$file->map) {
                        $type18 = TRUE;
                        $state = FALSE;
                    }
                    if (!$file->sign) {
                        $type19 = TRUE;
                    }
                    
                }
            }
        } else {
            $type1 = $type2 = $type3 = $type4 = $type6 = $type7 = $type8 = $type9 = TRUE;
            $state = FALSE;
        }
    }
    $chk_state = ['nrc' => $type1, 'form10' => $type2, 'occupy' => $type3, 'ownership' => $type4, 'farmland'=>$type13, 'building'=>$type15,'electric' => $type5, 'permit' => $type6, 'bcc' => $type7,  'dc' => $type8,  'bill' => $type9, 'license' => $type10, 'city_license'=>$type11,'ministry_permit'=>$type12,'industry'=>$type14, 'building' => $type15, 'bq' => $type16, 'drawing' => $type17, 'map' => $type18, 'sign' => $type19, 'state' => $state];
    return $chk_state;
}
function chk_send_count() {
    $form = ApplicationForm::where('user_id', Auth::user()->id)->get();
    $count = 0;
    foreach ($form as $key) {

        if (cdt($key->id)[0] == "unfinished_form") {
            $count++;
        }
        
        $action = $key->form_actions()->first();
            if ($action && !$action->user_send_to_office) {
                $count++;
            }

        if (cdt($key->id)[0] == "finished_form" && !$action) {
            $count++;
        }
        // $action = $key->form_actions;
        // foreach ($action as $value) {
        //     if ($value && !$value->user_send_to_office) {
        //         $count++;
        //     }
        // }
    }
    // $count += chk_cdt(null)['count'];
    return $count;
}
function chk_userForm($form_id) {
    $form = ApplicationForm::find($form_id);
    $f_action = $form->form_actions;
    $msg = '';
    $color = '';
    $to_confirm = false;
    $to_survey = false;
    $to_confirm_survey = false;
    $to_confirm_dist = false;
    $to_confirm_div_state = false;
    $to_confirm_div_state_to_headoffice = false;
    $to_confirm_headoffice = false;
    $to_dist_approve = false;
    $to_announce = false;
    $to_pay = false;
    $to_confirm_pay = false;
    $to_contract = false;
    $to_chk_install = false;
    $ei_confirm = false;
    $to_confirm_install = false;
    $to_register = false;
    $finish = false;
    $pending = false;
    $reject = false;
    
    foreach ($f_action as $action) {
        if (! $action->form_reject && ! $action->form_pending) {
            if ($action->register_meter) { // if register finished
                $msg = 'successfully_finished';
                $color = 'text-success';
                $finish = true;
            } else {
                if (($form->apply_type == 5 || $form->apply_type == 4 || $form->apply_type == 3 || $form->apply_type == 2 ) && $action->install_confirm) { // if (power or constructor or transformer) and Ei finished
                    $msg = 'to_register';
                    $color = 'text-info';
                    $to_register = true;
                } else {
                    if ($action->install_accept) { // if apployed finished
                        if ($form->apply_type == 5 || $form->apply_type == 4|| $form->apply_type == 3 || $form->apply_type == 2 ) {
                            $msg = 'to_ei_confirm_div_state';
                            $ei_confirm = true;
                        } else {
                            $msg = 'to_register';
                            $to_register = true;
                        }
                        $color = 'text-info';
                    } else {
                        if ($action->contract) {
                            $msg = 'check_to_install';
                            $color = 'text-info';
                            $to_chk_install = true;
                        } else {
                            if ($action->payment_accept) {
                                $msg = 'check_to_install';
                                $color = 'text-info';
                                $to_chk_install = true;
                            } else  {
                                if ($action->user_pay) {
                                    $msg = 'to_confirm_payment';
                                    $color = 'text-info';
                                    $to_confirm_pay = true;
                                } else {
                                    if ($action->announce) {
                                        $msg = 'waiting_payment';
                                        $color = 'text-info';
                                        $to_pay = true;
                                    } else {
                                        // if ($action->dist_approve) {
                                        //     if ($form->apply_type == 4) {
                                        //         $msg = 'to_announce';
                                        //         $color = 'text-info';
                                        //         $to_announce = true;
                                        //     }
                                        // } else {
                                            if ($action->survey_confirm_headoffice) {
                                                if ($form->apply_type == 4) {
                                                    // $msg = 'to_dist_approve';
                                                    // $color = 'text-info';
                                                    // $to_dist_approve = true;
                                                    $msg = 'to_announce';
                                                    $color = 'text-info';
                                                    $to_announce = true;
                                                }
                                            } else {
                                                if ($action->survey_confirm_div_state_to_headoffice) {
                                                    if ($form->apply_type == 4) {
                                                        $msg = 'survey_confirm_to_headoffice_by_divs';
                                                        $color = 'text-info';
                                                        $to_confirm_div_state_to_headoffice = true;
                                                    }
                                                } else {
                                                    if ($action->survey_confirm_div_state) {
                                                        if ($form->apply_type == 5 || $form->apply_type == 4) {
                                                            $msg = 'to_announce';
                                                            $color = 'text-info';
                                                            $to_announce = true;
                                                        }
                                                    } else {
                                                        if ($action->survey_confirm_dist) {
                                                            if ($form->apply_type == 5 || $form->apply_type == 4) {
                                                                $msg = 'survey_confirm_to_divs_by_dist';
                                                                $color = 'text-info';
                                                                $to_confirm_div_state = true;
                                                            } elseif ($form->apply_type == 2 || $form->apply_type == 3) {
                                                                $msg = 'to_announce';
                                                                $color = 'text-info';
                                                                $to_announce = true;
                                                            }
                                                        } else {
                                                            if ($action->survey_confirm) {
                                                                if ($form->apply_type == 5 || $form->apply_type == 4) {
                                                                    $msg = 'survey_confirm_to_dist_by_tsp';
                                                                    $color = 'text-info';
                                                                    $to_confirm_dist = true;
                                                                } elseif ($form->apply_type == 2 || $form->apply_type == 3) {
                                                                    $msg = 'survey_confirm_to_dist_by_tsp';
                                                                    $color = 'text-info';
                                                                    $to_confirm_dist = true;
                                                                } else {
                                                                    $msg = 'to_announce';
                                                                    $color = 'text-info';
                                                                    $to_announce = true;
                                                                }
                                                            } else {
                                                                if ($action->survey_accept) {
                                                                    $msg = 'to_confirm_surveyed';
                                                                    $color = 'text-info';
                                                                    $to_confirm_survey = true;
                                                                } else {
                                                                    if ($action->form_accept) {
                                                                        $msg = 'to_survey';
                                                                        $color = 'text-info';
                                                                        $to_survey = true;
                                                                    } else {
                                                                        if ($action->user_send_to_office) {
                                                                            $msg = 'to_check_form';
                                                                            $color = 'text-info';
                                                                            $to_confirm = true;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        // }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } elseif ($action->form_pending) {
            $msg = 'pending';
            $color = 'text-info';
            $pending = true;
        } elseif ($action->form_reject) {
            $msg = 'reject';
            $color = 'text-info';
            $reject = true;
        }
    }
    return [
        'color' => $color,
        'msg' => $msg,
        'to_confirm' => $to_confirm,
        'to_survey' => $to_survey,
        'to_confirm_survey' => $to_confirm_survey,
        'to_confirm_dist' => $to_confirm_dist,
        'to_confirm_div_state' => $to_confirm_div_state,
        'to_confirm_headoffice' => $to_confirm_headoffice,
        'to_confirm_div_state_to_headoffice' => $to_confirm_div_state_to_headoffice,
        'to_dist_approve' => $to_dist_approve,
        'to_announce' => $to_announce,
        'to_pay' => $to_pay,
        'to_confirm_pay' => $to_confirm_pay,
        'to_contract' => $to_contract,
        'to_chk_install' => $to_chk_install,
        'to_confirm_install' => $to_confirm_install,
        'ei_confirm' => $ei_confirm,
        'to_register' => $to_register,
        'finish' => $finish,
        'pending' => $pending,
        'reject' => $reject,
    ];
}
function chk_resend($form_id) {
    return FormRoutine::where('application_form_id', $form_id)->orderBy('updated_at', 'desc')->first(); 
}
function power_dist($form_id) {
    $form = ApplicationForm::find($form_id);
    $f_action = $form->form_actions;
    $msg = '';
    $color = '';
    $to_confirm = false;
    foreach ($f_action as $action) {
        if (!$action->survey_confirm_dist && $action->survey_confirm) {
            $msg = 'to_confirm_dist';
            $color = 'text-info';
            $to_confirm = true;
        }
    }
    return [
        'msg' => $msg, 'color' => $color, 'to_confirm' => $to_confirm
    ];
}

// function progress($form_id) {
//     $form = ApplicationForm::find($form_id);
//     $f_action = $form->form_actions;
//     $send = $accept = $survey = $c_survey = $c_survey_dist = $c_survey_div_state = $ann = $payment = $c_payment = $install = $reg = $finish = false;
//     foreach ($f_action as $act) {
//         $send = $act->user_send_to_office ? true : false;
//         $accept = $act->form_accept ? true : false;
//         $survey = $act->survey_accept ? true : false;
//         $c_survey = $act->survey_confirm ? true : false;
//         $c_survey_dist = $act->survey_confirm_dist ? true : false;
//         $c_survey_div_state = $act->survey_confirm_div_state ? true : false;
//         $ann = $act->announce ? true : false;
//         $payment = $act->payment_accept ? true : false; //user_pay
//         $c_payment = $act->payment_accept ? true : false;
//         $install = $act->install_accept ? true : false;
//         $reg = $act->register_meter ? true : false;
//         $finish = $act->finish_form ? true : false;
//     }
//     return ['send' => $send, 'accept' => $accept, 'survey' => $survey, 'c_survey' => $c_survey, 'c_survey_dist' => $c_survey_dist, 'c_survey_div_state' => $c_survey_div_state, 'ann' => $ann, 'payment' => $payment, 'c_payment' => $c_payment, 'install' => $install, 'reg' => $reg, 'finish' => $finish];
// }

function progress($form_id) {
    $form = ApplicationForm::find($form_id);
    $f_action = $form->form_actions;
    $send = $accept = $survey = $c_survey = $c_survey_dist = $c_survey_div_state = $ann = $c_survey_head_state = $payment = $c_payment = $install = $install_confirm = $reg = $finish = false;
    foreach ($f_action as $act) {
        $send = $act->user_send_to_office ? true : false;
        $accept = $act->form_accept ? true : false;
        $survey = $act->survey_accept ? true : false;
        $c_survey = $act->survey_confirm ? true : false;
        $c_survey_dist = $act->survey_confirm_dist ? true : false;
        $c_survey_div_state = $act->survey_confirm_div_state ? true : false;
        $c_survey_head_state = $act->survey_confirm_headoffice ? true : false;
        $ann = $act->announce ? true : false;
        $payment = $act->payment_accept ? true : false; //user_pay
        $c_payment = $act->payment_accept ? true : false;
        $install = $act->install_accept ? true : false;
        $install_confirm = $act->install_confirm ? true : false;
        $reg = $act->register_meter ? true : false;
        $finish = $act->finish_form ? true : false;
    }
    return ['send' => $send, 'accept' => $accept, 'survey' => $survey, 'c_survey' => $c_survey, 'c_survey_dist' => $c_survey_dist, 'c_survey_div_state' => $c_survey_div_state, 'c_survey_head_state' => $c_survey_head_state, 'ann' => $ann, 'payment' => $payment, 'c_payment' => $c_payment, 'install' => $install, 'install_confirm' => $install_confirm, 'reg' => $reg, 'finish' => $finish];
}

function mail_type($value) {
    switch ($value) {
        case '1': return checkMM() == 'mm' ? 'လျှောက်လွှာ ပြင်ဆင်ရန် အကြောင်းကြားစာ' : 'Form Error Announcement'; break;
        case '2': return checkMM() == 'mm' ? 'လျှောက်လွှာ လက်ခံပြီးကြောင်း အကြောင်းကြားစာ' : 'Accepted Form Announcement'; break;
        case '3': return checkMM() == 'mm' ? 'လျှောက်လွှာ ဆိုင်းငံ့ထားကြောင်း အကြောင်းကြားစာ' : 'Pending Form Announcement'; break;
        case '4': return checkMM() == 'mm' ? 'လျှောက်လွှာ ပယ်ဖျက်ကြောင်း အကြောင်းကြားစာ' : 'Dismiss Form Announcement'; break;
        case '5': return checkMM() == 'mm' ? 'ငွေသွင်းရန် အကြောင်းကြားစာ' : 'payment announcement'; break;
        case '6': return checkMM() == 'mm' ? 'ငွေလက်ခံရရှိကြောင်း အကြောင်းကြားစာ' : 'payment success announcement'; break;
        default: return ''; break;
    }
}
function mail_seen_chk() {
    return MailTbl::where([['user_id', Auth::user()->id], ['mail_seen', false]])->orderBy('mail_send_date', 'desc')->get();
}
function mail_read_chk() {
    return MailTbl::where([['user_id', Auth::user()->id], ['mail_read', false]])->orderBy('mail_send_date', 'desc')->get();
}
function all_mail() {
    return MailTbl::where('user_id', Auth::user()->id)->orderBy('mail_send_date', 'desc')->get();
}
function contrator_meter_count($form_id) {
    $c_form = ApplicationFormContractor::where('application_form_id', $form_id)->first();

    if($c_form->apartment_count != "" && $c_form->floor_count != ""){
        $apartment_into_floor = mmNum($c_form->apartment_count) . " ခန်းတွဲ x ". mmNum($c_form->floor_count). " ထပ် = ";
    }else{
        $apartment_into_floor = null;
    }

    $meter_count = 'ကန်ထရိုက်တိုက် ('.$apartment_into_floor.mmNum($c_form->room_count).' ခန်း) အတွက် ';
    $meter_count .= 'အိမ်သုံးမီတာ ('.mmNum($c_form->meter).') လုံး';
    if ($c_form->pMeter10 || $c_form->pMeter20 || $c_form->pMeter30) {
        $meter_count .= '၊ ပါဝါမီတာ ('.mmNum($c_form->pMeter10 + $c_form->pMeter20 + $c_form->pMeter30).') လုံး';
    }
    if ($c_form->water_meter) {
        $meter_count .= '၊ ရေစက်မီတာ(၁)လုံး';
    }
    if ($c_form->elevator_meter) {
        $meter_count .= '၊ ဓါတ်လှေကားအသုံးပြုရန် ပါဝါမီတာ(၁)လုံး';
    }
    return $meter_count;
}
function confirm_contractor_meter_count($form_id) {
    $c_form = FormSurvey::where('application_form_id', $form_id)->first();
    $meter_count = 'အိမ်သုံးမီတာ ('.mmNum($c_form->meter_count).') လုံး';
    if ($c_form->pMeter10) {
        $meter_count .= '၊ ပါဝါမီတာ (၁၀ ကီလိုဝပ်) ('.mmNum($c_form->pMeter10).') လုံး';
    }
    if ($c_form->pMeter20) {
        $meter_count .= '၊ ပါဝါမီတာ (၂၀ ကီလိုဝပ်) ('.mmNum($c_form->pMeter20).') လုံး';
    }
    if ($c_form->pMeter30) {
        $meter_count .= '၊ ပါဝါမီတာ (၃၀ ကီလိုဝပ်) ('.mmNum($c_form->pMeter30).') လုံး';
    }
    if ($c_form->water_meter_count) {
        if ($c_form->water_meter_type == 1060) {
            $wm_type = '10/60';
        } else {
            $wm_type = '5/30';
        }
        $meter_count .= '၊ ရေစက်မီတာ ('.mmNum($wm_type).') ('.mmNum($c_form->water_meter_count).') လုံး';
    }
    if ($c_form->elevator_meter_count) {
        $meter_count .= '၊ ဓါတ်လှေကားသုံး ပါဝါမီတာ ('.mmNum($c_form->elevator_meter_type).' ကီလိုဝပ်) ('.mmNum($c_form->elevator_meter_count).') လုံး';
    }
    return $meter_count;
}
function r_meter($value) {
    return initialCost::where([['type', 1], ['sub_type', $value]])->first()->name;
}
function p_meter($value) {
    return initialCost::where([['type', 2], ['sub_type', $value]])->first()->name;
}
function cp_meter($value) {
    return initialCost::where([['type', 3], ['sub_type', $value]])->first()->name.' KW';
}
function tsf_kva($value) {
    if ($value) {
        return initialCost::where([['type', 4], ['sub_type', $value]])->first()->name.' KVA';
    }
}
function confirm_meter_price($form_id) {
    $form = ApplicationForm::find($form_id);
    $user_form = ApplicationFormContractor::where('application_form_id', $form_id)->first();
    $c_form = FormSurvey::where('application_form_id', $form_id)->first();
    $rm_price = InitialCost::where([['type', 1], ['sub_type', 3]])->first();
    $p10_price = InitialCost::where([['type', 2], ['sub_type', 1]])->first();
    $p20_price = InitialCost::where([['type', 2], ['sub_type', 2]])->first();
    $p20_price = InitialCost::where([['type', 2], ['sub_type', 2]])->first();
    $c10_price = InitialCost::where([['type', 3], ['sub_type', 1]])->first();
    $c20_price = InitialCost::where([['type', 3], ['sub_type', 2]])->first();
    $c20_price = InitialCost::where([['type', 3], ['sub_type', 2]])->first();

    if ($user_form->room_count < 18) {
        $assign_sub_total = 550000 * $c_form->room_count;
    }

    $residential_sub_total = ($c_form->meter * $resident_meter);
    $power_sub_total = (($c_form->pMeter10 * 846000) + ($c_form->pMeter20 * 1046000) + ($c_form->pMeter30 * 1246000));
    $water_meter = $c_form->water_meter * $resident_meter;
    $elevator_meter = $c_form->elevator_meter * 846000;
    $total = $assign_sub_total + $residential_sub_total + $power_sub_total + $water_meter + $elevator_meter;
}
function power_meter_type($form_id) {
    $form = ApplicationForm::find($form_id);
    if ($form->apply_type == 2) {
        if ($form->apply_sub_type == 1) {
            return 'အိမ်သုံးပါဝါမီတာ (၁၀) ကီလိုဝပ်';
        } elseif ($form->apply_sub_type == 2) {
            return 'အိမ်သုံးပါဝါမီတာ (၂၀) ကီလိုဝပ်';
        } elseif ($form->apply_sub_type == 3) {
            return 'အိမ်သုံးပါဝါမီတာ (၃၀) ကီလိုဝပ်';
        }
    }
}
function cpower_meter_type($form_id) {
    $form = ApplicationForm::find($form_id);
    if ($form->apply_type == 3) {
        if ($form->apply_sub_type == 1) {
            return 'စက်မှုသုံးပါဝါမီတာ (၁၀) ကီလိုဝပ်';
        } elseif ($form->apply_sub_type == 2) {
            return 'စက်မှုသုံးပါဝါမီတာ (၂၀) ကီလိုဝပ်';
        } elseif ($form->apply_sub_type == 3) {
            return 'စက်မှုသုံးပါဝါမီတာ (၃၀) ကီလိုဝပ်';
        }
    }
}
function tsf_type($form_id) {
    $form = ApplicationForm::find($form_id);
    if($form->apply_division == '3'){ // mdy
        $type = InitialCost::where('building_fee','!=',null)->where([['type', $form->apply_type], ['sub_type', $form->apply_sub_type]])->first();
    }elseif($form->apply_division == '1'){ // ygn
        $type = InitialCost::whereNotIn('name',['630','800','1500'])->where([['type', $form->apply_type], ['sub_type', $form->apply_sub_type]])->first();
    }else{ // other
        $type = InitialCost::where([['type', $form->apply_type], ['sub_type', $form->apply_sub_type]])->first();
    }
    return '('.$type->name.' KVA) ထရန်စဖေါ်မာတစ်လုံး';
}
function user_applied_form($type) {
    $id = Auth::user()->id;
    $forms = ApplicationForm::where([['user_id', $id], ['apply_type', $type]])->get();
    return $forms->count();
}
function user_total_unfinished_form($type) {
    $id = Auth::user()->id;
    $forms = ApplicationForm::where([['user_id', $id], ['apply_type', $type]])->get();
    $arr = [];
    $count = 0;
    if ($forms) {     
        foreach ($forms as $form) {
            if ($form->serial_code == NULL) {
                $count++;
            }
            $actions = FormProcessAction::where('application_form_id', $form->id)->get();
            $files = ApplicationFile::where('application_form_id', $form->id)->get();
            foreach ($actions as $action) {
                if (!$action->user_send_to_office) {
                    $count++;
                }
            }
            foreach ($files as $file) {
                if ($type == 1 || $type == 2) {
                    if (!$file->ownership) {
                        $count++;
                    }
                } elseif ($type == 3) {
                    if (!$file->transaction_licence) {
                        $count++;
                    }
                } elseif ($type == 4) {
                    if (!$file->dc_recomm) {
                        $count++;
                    }
                } elseif ($type == 5) {
                    if (!$file->prev_bill) {
                        $count++;
                    }
                } elseif ($type == 6) {
                    // 
                }
            }
        }
    }
    return $count;
}
function user_total_send_form($type) {
    $id = Auth::user()->id;
    $forms = ApplicationForm::where([['user_id', $id], ['apply_type', $type]])->get();
    $count = 0;
    if ($forms) {
        foreach ($forms as $form) {
            $actions = FormProcessAction::where('application_form_id', $form->id)->get();
            if ($actions) {
                foreach ($actions as $action) {
                    if ($action->user_send_to_office && !$action->register_meter) {
                        $count++;
                    }
                }
            }
        }
    }
    return $count;
}
function chk_ygn_mdy($value) {
    $data = true;
    if ($value == 2 || $value == 3) {
        if (admin()->div_state == 2 || admin()->div_state == 3) {
            $data = false;
        }
    }
    return $data;
}

function divType($type){
    if($type == '2'){
        return trans('lang.ygn_office');
    }elseif($type == '3'){
        return trans('lang.mdy_office');
    }else{
        return trans('lang.other_office');
    }
}
function user() {
    return Auth::guard('web')->user();
}

function districts($region_id) {
    $district =  Auth::guard('admin')->user()->district;
    $user =  Auth::guard('admin')->user()->group_lvl;
    if($user >= '5'){
        $districts = District::where('division_state_id', $region_id)->where('id',$district)->get();
    }else{
        $districts = District::where('division_state_id', $region_id)->get();
    }
    $output[""] = trans('lang.choose1');
    foreach ($districts as $district) {
        if (checkMM() == 'mm') {
            $output[$district->id] = $district->name;
        } else {
            $output[$district->id] = $district->eng;
        }
    }
    return $output;
}

function townships($district_id){
    $township =  Auth::guard('admin')->user()->township;
    $user =  Auth::guard('admin')->user()->group_lvl;
    if($user >= '6'){
        $townships = Township::where('district_id', $district_id)->where('id',$township)->get();
    }else{
        $townships = Township::where('district_id', $district_id)->get();
    }
    $output[""] = trans('lang.choose1');
    foreach ($townships as $township) {
        if (checkMM() == 'mm') { 
            $output[$township->id] = $township->name; 
        } else { 
            $output[$township->id] = $township->eng; 
        }
    }
    return $output;
}
function space($number){
    $space = "";
    while($number > 0){
        $space .= "&nbsp;";
        $number --;
    }
    return $space;
}

// flutter noti api helper
function save_api_noti($type, $form_id, $user_id, $remark = null, $img = null, $pdf = null){
    DB::table('flutter_notis')->insert([
        'type' => $type,
        'form_id' => $form_id,
        'user_id' => $user_id,
        'read_status' => 0,
        'send_date' => date('Y-m-d H:i:s'),
        'remark' => $remark,
        'img' =>  $img != null ? implode(',', $img) : null,
        'pdf' =>  $pdf != null ? implode(',', $pdf) : null,
    ]);
    $noti = DB::table('flutter_notis')
    ->join('application_forms',function($join){
        $join->on('application_forms.id','=','flutter_notis.form_id');
    })
    ->select('flutter_notis.*', 'application_forms.serial_code as serial_code', 'application_forms.apply_type as apply_type', 'application_forms.apply_division as apply_division')
    ->where('flutter_notis.form_id', $form_id)
    ->where('flutter_notis.user_id', $user_id)->orderBy('flutter_notis.id','desc')->first();
    
    $noti->form_id = (int) $noti->form_id;
    $noti->user_id = (int) $noti->user_id;
    $noti->read_status = (int) $noti->read_status;
    $noti->id = (int) $noti->id;
    $noti->send_date = date('d-m-Y h:i:s A', strtotime($noti->send_date));
    $noti->remark = $noti->remark != null ? $noti->remark : '';
    $noti->img = $noti->img != null ? $noti->img : '';
    $noti->pdf = $noti->pdf != null ? $noti->pdf : '';
    return $noti;
}
function form_for_api($form_id){
    $data = ApplicationForm::select('application_forms.*', 'division_states.name as div_name', DB::raw('DATE_FORMAT(application_forms.date, "%d-%b-%Y") as date_f'))->where('application_forms.id', $form_id)->orderBy('date', 'desc')->orderBy('id', 'asc')->leftJoin('division_states',function($join){
        $join->on('application_forms.div_state_id','=','division_states.id');
    })->first();
    
    $status = cdt($data->id)[0];
    if (chk_send($data->id) == 'first'){
        $state_name = 'lang.'.chk_userForm($data->id)['msg'];
        $state_lang = chk_userForm($data->id)['msg'];
    }elseif (chk_send($data->id) == 'second'){
        $state_name = 'lang.resend_form';
        $state_lang = 'resend_form';
    }else{
        $state_name = 'lang.'.$status;
        $state_lang = $status;
    }
    $data->state = trans($state_name,[], 'en');

    $data->state_lang = $state_lang;

    return $data;
}

function send_individual_noti_to_app($title, $body, $data, $token){ 

    define('API_ACCESS_KEY','AAAABgbwbXw:APA91bH5apxvy3dcBfHIcad2LK8qPqj67ybtGxlTyrW5IaEm2_fkl8Es3bMFR3hvJf3Ujx055twjMhvdYL86GMF0xWVmFKoxiQ8s30cW3imqWobyyd09ZXJdn0IUHqO2sJXyt_anDcTV');

    $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

    $notification = [
        'title'     => $title,
        'body'      => $body,
        'channelId' => 'high_importance_channel',
        "icon"      => "default",
        'sound'     => 'default'
    ];

    $fcmNotification = [
        'notification' => $notification,
        'data' => $data,

        // one device sending 
        'to' => $token, 

        // group devices sending
        // 'registration_ids' => array of register_ids or token ,

        // topic sending
        // 'to' => '/topics/alldevices',
    ];

    $headers = [
        'Authorization:key=' . API_ACCESS_KEY,
        'Content-Type:application/json'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $fcmUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;

}

function refresh_token($token){
    return $token;
    // try{
    //     $new_token = JWTAuth::refresh($token);
    //     return $new_token;
    // }catch(TokenInvalidException $e){
    //     return $token;
    // }
}

function addressApi($formId, $lang) {
    $form = ApplicationForm::find($formId);
    if ($lang == 'mm') {
        $home_no = $form->applied_home_no ? 'အမှတ် ('.$form->applied_home_no.')၊' : '';
        $building = $form->applied_building ? 'တိုက်အမှတ် ('.$form->applied_building.')၊' : '';
        $lane = $form->applied_lane ? $form->applied_lane.'၊' : '';
        $street = $form->applied_street ? $form->applied_street.'၊' : '';
        $quarter = $form->applied_quarter ? $form->applied_quarter.'၊' : '';
        $town = $form->applied_town ? $form->applied_town.'၊' : '';
        return $home_no.' '.$building.' '.$lane.' '.$street.' '.$quarter.' '.$town.' '.township_mm($form->township_id).'၊ '.district_mm($form->district_id).'၊ '.div_state_mm($form->div_state_id);
    } else {
        $home_no = $form->applied_home_no ? 'No ('.$form->applied_home_no.'),' : '';
        $building = $form->applied_building ? 'Building ('.$form->applied_building.'),' : '';
        $lane = $form->applied_lane ? $form->applied_lane.' Lane,' : '';
        $street = $form->applied_street ? $form->applied_street.' Street,' : '';
        $quarter = $form->applied_quarter ? $form->applied_quarter.' Quarter,' : '';
        $town = $form->applied_town ? $form->applied_town.' Town,' : '';
        return $home_no.' '.$building.' '.$lane.' '.$street.' '.$quarter.' '.$town.' '.township($form->township_id).', '.district($form->district_id).', '.div_state($form->div_state_id).'.';
    }
}

