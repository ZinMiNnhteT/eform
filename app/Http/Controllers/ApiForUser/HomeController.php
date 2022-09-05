<?php

namespace App\Http\Controllers\ApiForUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Usage Models
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Database Models
use App\User;
use App\User\ApplicationForm;
use App\User\ApplicationFile;
use App\Admin\FormProcessAction;
use App\Admin\AdminAction;
use App\Admin\ApplicationFormContractor;
use App\Setting\InitialCost;
use App\Setting\District;
use App\Setting\Township;


class HomeController extends Controller
{

    public function __construct() {
        $this->storagePath = 'http://192.168.99.124/eform/public/storage/user_attachments/';
    }

    // save meter type
    public function meter_type(Request $request){
        $validator = Validator::make($request->all(),[
            'token' => 'required',
            'apply_type' => 'required',
            'apply_sub_type' => 'required',
            'apply_division' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['success'=> false, 'validate' => $validator->errors()], 400);
        }
        $user = JWTAuth::authenticate($request->token);

        if($request->form_id != null || $request->form_id != ''){
            $form = ApplicationForm::find($request->form_id);
        }else{
            $form = new ApplicationForm();
        }

        $form->user_id = $user->id;
        $form->apply_type = $request->apply_type; // r => 1, rp => 2
        $form->apply_sub_type = $request->apply_sub_type;// meter sub type 1,2,3
        $form->apply_division = $request->apply_division; // ygn=>1,mdy=3, other=2
        $form->date = date('Y-m-d');
        $form->save();

        return response()->json([
            'success'   => true,
            'token'     => $this->refresh_token($request->token),
            'form'      => $form,
        ]);
    }

    // save constructor meter type
    public function meter_tye_contractor(Request $request){
        $validator = Validator::make($request->all(),[
            'token' => 'required',
            // 'room_count' => 'required|numeric|min:4',
            'room_count' => 'required|numeric',
            'apply_division' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['success'=> false, 'validate' => $validator->errors()], 400);
        }
        $user = JWTAuth::authenticate($request->token);

        $room_count         = $request->room_count;
        $apartment_count    = $request->apartment_count;
        $floor_count        = $request->floor_count;
        $pMeter10           = $request->pMeter10;
        $pMeter20           = $request->pMeter20;
        $pMeter30           = $request->pMeter30;
        $meter              = $request->meter; // total 
        $water_meter        = $request->water_meter;
        if ($water_meter == 'ON') {
            $water_meter = true;
        } else {
            $water_meter = false;
        }
        $elevator_meter = $request->elevator_meter;
        if ($elevator_meter == 'ON') {
            $elevator_meter = true;
        } else {
            $elevator_meter = false;
        }
        $sub_type = 1;
        if ($room_count > 17) {
            $sub_type = 2;
        }

        if($request->form_id != ''){
            $form = ApplicationForm::find($request->form_id);
        }else{
            $form = new ApplicationForm();
        }
        $form->user_id = $user->id;
        $form->apply_type = 5; // contractor
        $form->apply_sub_type = $sub_type;
        $form->apply_division = $request->apply_division; // ygn=1, mdy=3, other=2
        $form->date = date('Y-m-d');
        $form->save();

        if($request->form_id != ''){
            $c_form = ApplicationFormContractor::where('application_form_id', $request->form_id)->first();
        }else{
            $c_form = new ApplicationFormContractor();
        }
        $c_form->application_form_id  = $form->id;
        $c_form->room_count           = $room_count;
        $c_form->apartment_count      = $apartment_count;
        $c_form->floor_count          = $floor_count;
        $c_form->pMeter10             = $pMeter10;
        $c_form->pMeter20             = $pMeter20;
        $c_form->pMeter30             = $pMeter30;
        $c_form->meter                = $meter;
        $c_form->water_meter          = $water_meter;
        $c_form->elevator_meter       = $elevator_meter;
        $c_form->save();

        return response()->json([
            'success'   => true,
            'token'     => $this->refresh_token($request->token),
            'form'      => $form,
        ]);
    }

    // save meter type transformer
    public function meter_type_transformer(Request $request){
        $validator = Validator::make($request->all(),[
            'token' => 'required',
            'apply_division' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['success'=> false, 'validate' => $validator->errors()], 400);
        }
        $user = JWTAuth::authenticate($request->token);
        if($request->form_id != ''){
            $form = ApplicationForm::find($request->form_id);
        }else{
            $form = new ApplicationForm();
            $form->user_id = $user->id;
        }
        $form->apply_type        = $request->apply_type;
        $form->apply_division    = $request->apply_division;
        $form->apply_tsf_type    = $request->apply_tsf_type;
        $form->pole_type         = $request->pole_type;
        $form->apply_sub_type    = $request->apply_sub_type;
        $form->date              = date('Y-m-d');
        $form->save();

        return response()->json([
            'success'   => true,
            'token'     => $this->refresh_token($request->token),
            'form'      => $form,
        ]);
    }

    // save application form
    public function applicant_info(Request $request){
        $validator = Validator::make($request->all(),[
            'token'                 => 'required',
            'form_id'               => 'required',
            'fullname'              => 'required',
            'nrc'                   => 'required',
            'applied_phone'         => ['required'],
            // 'applied_phone'         => ['required', 'min:9', 'max:11'],
            'jobType'               => 'required',
            'applied_building_type' => 'required',
            'applied_home_no'       => 'required',
            'applied_street'        => 'required',
            'applied_quarter'       => 'required',
            'township_id'           => 'required',
            'district_id'           => 'required',
            'div_state_id'          => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['success'=> false, 'validate' => $validator->errors()], 400);
        }
        $user = JWTAuth::authenticate($request->token);

        $form_id        = $request->form_id;
        $fullname       = $request->fullname;
        $nrc            = $request->nrc;
        $job_type       = $request->jobType;
        if ($job_type == 'other') {
            $position   = $request->other;
            $salary     = $request->otherSalary;
        } else {
            $position   = $request->pos;
            $salary     = $request->salary;
        }
        $department             = $request->dep;
        $applied_phone          = $request->applied_phone;
        $applied_building_type  = $request->applied_building_type;
        $applied_home_no        = $request->applied_home_no;
        $applied_building       = $request->applied_building;
        $applied_lane           = $request->applied_lane;
        $applied_street         = $request->applied_street;
        $applied_quarter        = $request->applied_quarter;
        $applied_town           = $request->applied_town;
        $township_id            = $request->township_id;
        $district_id            = $request->district_id;
        $div_state_id           = $request->div_state_id;
        $serial_code            = get_serial($div_state_id);

        $form = ApplicationForm::find($form_id);
        $form->serial_code   = $serial_code;
        $form->fullname      = $fullname;
        $form->nrc           = $nrc;
        $form->applied_phone = $applied_phone;
        $form->job_type      = $request->jobType;
        $form->position      = $position;
        $form->department    = $department;
        $form->business_name = $request->other;
        $form->salary        = $salary ? $salary : 0;
        $form->applied_building_type = $applied_building_type;
        $form->applied_home_no       = $applied_home_no;
        $form->applied_building      = $applied_building;
        $form->applied_lane          = $applied_lane;
        $form->applied_street        = $applied_street;
        $form->applied_quarter       = $applied_quarter;
        $form->applied_town          = $applied_town;
        $form->township_id           = $township_id;
        $form->district_id           = $district_id;
        $form->div_state_id          = $div_state_id;
        $form->save();

        return response()->json([
            'success'   => true,
            'token'     => $this->refresh_token($request->token),
            'form'      => $form,
        ]);
    }

    // save application info constructor
    public function applicant_info_contractor(Request $request){
        $validator = Validator::make($request->all(),[
            'token'                 => 'required',
            'form_id'               => 'required',
            'fullname'              => 'required',
            'nrc'                   => 'required',
            // 'applied_phone'         => ['required', 'min:9', 'max:11'],
            'applied_phone'         => ['required'],
            'applied_home_no'       => 'required',
            'applied_street'        => 'required',
            'applied_quarter'       => 'required',
            'township_id'           => 'required',
            'district_id'           => 'required',
            'div_state_id'          => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['success'=> false, 'validate' => $validator->errors()], 400);
        }
        $user = JWTAuth::authenticate($request->token);

        $form_id = $request->form_id;
        $fullname = $request->fullname;
        $nrc = $request->nrc;
        $applied_phone = $request->applied_phone;
        $applied_home_no = $request->applied_home_no;
        $applied_lane = $request->applied_lane;
        $applied_street = $request->applied_street;
        $applied_quarter = $request->applied_quarter;
        $applied_town = $request->applied_town;
        $township_id = $request->township_id;
        $district_id = $request->district_id;
        $div_state_id = $request->div_state_id;

        $serial_code = get_serial($div_state_id);

        $form = ApplicationForm::find($form_id);
        $form->serial_code = $serial_code;
        $form->fullname = $fullname;
        $form->nrc = $nrc;
        $form->applied_phone = $applied_phone;
        $form->applied_home_no = $applied_home_no;
        $form->applied_lane = $applied_lane;
        $form->applied_street = $applied_street;
        $form->applied_quarter = $applied_quarter;
        $form->applied_town = $applied_town;
        $form->township_id = $township_id;
        $form->district_id = $district_id;
        $form->div_state_id = $div_state_id;
        $form->save();

        return response()->json([
            'success'   => true,
            'token'     => $this->refresh_token($request->token),
            'form'      => $form,
        ]);
    }

    // save application info constructor
    public function applicant_info_transformer(Request $request){
        $validator = Validator::make($request->all(),[
            'token'                 => 'required',
            'form_id'               => 'required',
            'religion'              => 'required',
            'fullname'              => 'required',
            'nrc'                   => 'required',
            'applied_phone'         => ['required'],
            'applied_building_type' => 'required',
            'applied_street'        => 'required',
            'applied_quarter'       => 'required',
            'township_id'           => 'required',
            'district_id'           => 'required',
            'div_state_id'          => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['success'=> false, 'validate' => $validator->errors()], 400);
        }
        $user = JWTAuth::authenticate($request->token);

        $form_id    = $request->form_id;
        $religion   = $request->religion;
        $is_light   = $request->is_light;
        $fullname   = $request->fullname;
        $nrc        = $request->nrc;
        $job_type   = $request->jobType;
        if ($job_type == 'other') {
            $position = $request->other;
            $salary = $request->otherSalary ?? $request->salary;
        } else {
            $position = $request->pos;
            $salary = $request->salary;
        }
        $department             = $request->dep;
        $applied_phone          = $request->applied_phone;
        $applied_building_type  = $request->applied_building_type;
        $applied_home_no        = $request->applied_home_no;
        $applied_building       = $request->applied_building;
        $applied_lane           = $request->applied_lane;
        $applied_street         = $request->applied_street;
        $applied_quarter        = $request->applied_quarter;
        $applied_town           = $request->applied_town;
        $township_id            = $request->township_id;
        $district_id            = $request->district_id;
        $div_state_id           = $request->div_state_id;

        $serial_code = get_serial($div_state_id);
        $form = ApplicationForm::find($form_id);
        $form->serial_code              = $serial_code;
        $form->is_religion              = $religion == 'yes' ? 1 : 0;
        $form->is_light                 = $is_light == 'yes' ? 1 : 0;
        $form->fullname                 = $fullname;
        $form->nrc                      = $nrc;
        $form->applied_phone            = $applied_phone;
        $form->job_type                 = $request->jobType;
        $form->position                 = $position;
        $form->department               = $department;
        $form->business_name            = $request->other;
        $form->salary                   = $salary ? $salary : 0;
        $form->applied_building_type    = $applied_building_type;
        $form->applied_home_no          = $applied_home_no;
        $form->applied_building         = $applied_building;
        $form->applied_lane             = $applied_lane;
        $form->applied_street           = $applied_street;
        $form->applied_quarter          = $applied_quarter;
        $form->applied_town             = $applied_town;
        $form->township_id              = $township_id;
        $form->district_id              = $district_id;
        $form->div_state_id             = $div_state_id;
        $form->save();

        return response()->json([
            'success'   => true,
            'token'     => $this->refresh_token($request->token),
            'form'      => $form,
        ]);
    }
    

    // save application form
    public function nrc(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            'front'     => 'required',
            'back'      => 'required',
            'front'     => ['image', 'mimes:jpeg,jpg,png,pdf'],
            'back'      => ['image', 'mimes:jpeg,jpg,png,pdf'],
        ]);
        if($validator->fails()){
            return response()->json(['success'=> false, 'validate' => $validator->errors()], 400);
        }

        $form = ApplicationForm::find($request->form_id);

        if (!is_dir(public_path('storage/user_attachments'))) {
            @mkdir(public_path('storage/user_attachments'));
        }
        
        if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
            @mkdir(public_path('storage/user_attachments/'.$form->id));
        }
        $path = public_path('storage/user_attachments/'.$form->id);
        // return $path;

        $front_ext = $request->file('front')->getClientOriginalExtension();
        $front_img = Image::make($request->file('front'));
        $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
        $front_img->resize(1600, 1600, function($constraint) {
                $constraint->aspectRatio();
            });
        $front_img->save($path.'/'.$front_nrc);

        $back_ext = $request->file('back')->getClientOriginalExtension();
        $back_img = Image::make($request->file('back'));
        $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
        $back_img->resize(1600, 1600, function($constraint) {
                $constraint->aspectRatio();
            });
        $back_img->save($path.'/'.$back_nrc);

        /* retreive data from table to check */
        $form_files = $form->application_files; 
        if ($form_files->count() > 0) {
            $new = $form->application_files()->first();
            // delete old front file
            $old_front = $new->nrc_copy_front;
            if (file_exists($path.'/'.$old_front)) {
                File::delete($path.'/'.$old_front);
            }
            // delete old back file
            $old_back = $new->nrc_copy_back;
            if (file_exists($path.'/'.$old_back)) {
                File::delete($path.'/'.$old_back);
            }
            $new->nrc_copy_front = $front_nrc;
            $new->nrc_copy_back = $back_nrc;
            $form->application_files()->save($new);
        } else {
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->nrc_copy_front = $front_nrc;
            $new->nrc_copy_back = $back_nrc;
            $form->application_files()->save($new);
        }

        return response()->json([
            'success'       => true,
            'token'         => $this->refresh_token($request->token),
            'form'          => $form
        ]);
    }

    // save form10  အိမ်ထောင်စုစာရင်
    public function form10(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            // 'front'     => 'required',
            'front.*'   => ['image', 'mimes:jpeg,jpg,png,pdf'],
            'back.*'    => ['image', 'mimes:jpeg,jpg,png,pdf'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $form = ApplicationForm::find($request->form_id);

        if (!is_dir(public_path('storage/user_attachments'))) {
            @mkdir(public_path('storage/user_attachments'));
        }
        
        if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
            @mkdir(public_path('storage/user_attachments/'.$form->id));
        }
        $path = public_path('storage/user_attachments/'.$form->id);

        $tmp_arr = []; 
        if ($request->hasFile('front')) {
            foreach ($request->file('front') as $key => $value) {
                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $save_db_img = get_random_string().'_'.getdate()[0].'.'.$value->getClientOriginalExtension();
                $save_file_img = Image::make($value);
                $save_file_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $save_file_img->save($path.'/'.$save_db_img);
                array_push($tmp_arr, $save_db_img);
            }
            $front_form_10 = implode(',', $tmp_arr);
        }else{
            $front_form_10 = null;
        }

        $back_form_10 = null; $tmp_arr = [];
        if ($request->hasFile('back')) {
            foreach ($request->file('back') as $key => $value) {
                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $save_db_img = get_random_string().'_'.getdate()[0].'.'.$value->getClientOriginalExtension();
                $save_file_img = Image::make($value);
                $save_file_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $save_file_img->save($path.'/'.$save_db_img);
                array_push($tmp_arr, $save_db_img);
            }
            $back_form_10 = implode(',', $tmp_arr);
        }else{
            $back_form_10 = null;
        }

        $form_files = $form->application_files; /* retreive data from table to check */
        if ($form_files->count() > 0) {
            $new = $form->application_files()->first();
            // delete old files
            $this->deleteMulipleFiles($new->form_10_front, $path);
            $this->deleteMulipleFiles($new->back_form_10, $path);
            // update new
            $new->form_10_front = $front_form_10;
            $new->form_10_back = $back_form_10;
            $form->application_files()->save($new);
        } else {
            $new = new ApplicationFile();
            $new->form_10_front = $front_form_10;
            $new->form_10_back = $back_form_10;
            $new->save();
        }

        return response()->json([
            'success'    => true,
            'token'      => $this->refresh_token($request->token),
            'form'       => $form,
            'front'      => $front_form_10,
            'back'       => $back_form_10
        ]);
    }

    // save recommanded ထောက်ခံစာ
    public function recommanded(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            'front'     => 'mimes:jpeg,jpg,png',
            'back'      => 'mimes:jpeg,jpg,png',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $form = ApplicationForm::find($request->form_id);
        
        if (!is_dir(public_path('storage/user_attachments'))) {
            @mkdir(public_path('storage/user_attachments'));
        }
        
        if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
            @mkdir(public_path('storage/user_attachments/'.$form->id));
        }
        $path = public_path('storage/user_attachments/'.$form->id);

        if ($request->hasFile('front')) {
            $occupy_ext = $request->file('front')->getClientOriginalExtension();
            $occupy_img = Image::make($request->file('front'));
            $occupy = get_random_string().'_'.getdate()[0].'.'.$occupy_ext;
            $occupy_img->resize(1600, 1600, function($constraint) {
                $constraint->aspectRatio();
            });
            $occupy_img->save($path.'/'.$occupy);
        }else{
            $occupy = null;
        }

        if ($request->hasFile('back')) {
            $no_invade_ext = $request->file('back')->getClientOriginalExtension();
            $no_invade_img = Image::make($request->file('back'));
            $no_invade = get_random_string().'_'.getdate()[0].'.'.$no_invade_ext;
            $no_invade_img->resize(1600, 1600, function($constraint) {
                $constraint->aspectRatio();
            });
            $no_invade_img->save($path.'/'.$no_invade);
        }else{
            $no_invade = null;
        }

        $form_files = $form->application_files; /* retreive data from table to check */
        if ($form_files->count() > 0) {
            $new = $form->application_files()->first();
            // delete old files
            $this->deleteFile($new->occupy_letter, $path);
            $this->deleteFile($new->no_invade_letter, $path);
            $new->occupy_letter     = $occupy;
            $new->no_invade_letter  = $no_invade;
            $form->application_files()->save($new);
        } else {
            $new = new ApplicationFile();
            $new->application_form_id   = $form->id;
            $new->occupy_letter         = $occupy;
            $new->no_invade_letter      = $no_invade;
            $new->save();
        }

        return response()->json([
            'success'    => true,
            'token'     => $this->refresh_token($request->token),
            'form'       => $form
        ]);
    }

    // save ownership
    public function ownership(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            'front'     => 'required',
            'front.*'   => ['image', 'mimes:jpeg,jpg,png,pdf'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $form = ApplicationForm::find($request->form_id);

        if (!is_dir(public_path('storage/user_attachments'))) {
            @mkdir(public_path('storage/user_attachments'));
        }
        
        if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
            @mkdir(public_path('storage/user_attachments/'.$form->id));
        }
        $path = public_path('storage/user_attachments/'.$form->id);
        $tmp_arr = [];
        $img_str = null;
        if ($request->hasFile('front')) {
            foreach ($request->file('front') as $key => $value) {
                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $save_db_img = get_random_string().'_'.getdate()[0].'.'.$value->getClientOriginalExtension();
                $save_file_img = Image::make($value);
                $save_file_img->resize(1600, 1600, function($constraint) {
                $constraint->aspectRatio();
            });
                $save_file_img->save($path.'/'.$save_db_img);
                array_push($tmp_arr, $save_db_img);
            }
            $img_str = implode(',', $tmp_arr);
        }
            
        $form_files = $form->application_files; /* retreive data from table to check */
        if ($form_files->count() > 0) {
            $new = $form->application_files()->first();
            if($img_str != ""){
                // delete old files
                $olds = explode(',',$new->ownership);
                foreach($olds as $old){
                    if (file_exists($path.'/'.$old)) {
                        File::delete($path.'/'.$old);
                    }
                }
            }
            // update new
            $new->ownership = $img_str;
            $form->application_files()->save($new);
        } else {
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->ownership = $img_str;
            $new->save();
        }
        return response()->json([
            'success'    => true,
            'token'     => $this->refresh_token($request->token),
            'form'       => $form
        ]);
    }

    // save farmland [optional]
    public function farmland(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            // 'front'     => 'required',
            'front.*'   => ['image', 'mimes:jpeg,jpg,png,pdf'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $form = ApplicationForm::find($request->form_id);

        if (!is_dir(public_path('storage/user_attachments'))) {
            @mkdir(public_path('storage/user_attachments'));
        }
        
        if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
            @mkdir(public_path('storage/user_attachments/'.$form->id));
        }
        $path = public_path('storage/user_attachments/'.$form->id);
        $tmp_arr = [];

        if ($request->hasFile('front')) {
            foreach ($request->file('front') as $key => $value) {
                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $save_db_img = get_random_string().'_'.getdate()[0].'.'.$value->getClientOriginalExtension();
                $save_file_img = Image::make($value);
                $save_file_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $save_file_img->save($path.'/'.$save_db_img);
                array_push($tmp_arr, $save_db_img);
            }
            $img_str = count($tmp_arr) > 0 ? implode(',', $tmp_arr) : null;
        }else{
            $img_str = '';
        }
        
        $form_files = $form->application_files; /* retreive data from table to check */
        if ($form_files->count() > 0) {
            $new = $form->application_files()->first();
            // delete old files
            $olds = explode(',',$new->farmland);
            foreach($olds as $old){
                if (file_exists($path.'/'.$old)) {
                    File::delete($path.'/'.$old);
                }
            }
            $new->farmland = $img_str;
            $form->application_files()->save($new);
        } else {
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->farmland = $img_str;
            $new->save();
        }
        

        return response()->json([
            'success'    => true,
            'token'     => $this->refresh_token($request->token),
            'form'       => $form
        ]);
    }

    // save building
    public function building(Request $request) {
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            'front'     => 'required',
            'front.*'   => ['image', 'mimes:jpeg,jpg,png,pdf'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $form = ApplicationForm::find($request->form_id);
        
        if (!is_dir(public_path('storage/user_attachments'))) {
            @mkdir(public_path('storage/user_attachments'));
        }
        
        if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
            @mkdir(public_path('storage/user_attachments/'.$form->id));
        }
        $path = public_path('storage/user_attachments/'.$form->id);
        $tmp_arr = [];

        foreach ($request->file('front') as $key => $value) {
            $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
            $save_db_img = get_random_string().'_'.getdate()[0].'.'.$value->getClientOriginalExtension();
            $save_file_img = Image::make($value);
            $save_file_img->resize(1600, 1600, function($constraint) {
                $constraint->aspectRatio();
            });
            $save_file_img->save($path.'/'.$save_db_img);
            array_push($tmp_arr, $save_db_img);
        }
        $img_str = count($tmp_arr) > 0 ? implode(',', $tmp_arr) : null;

        $form_files = $form->application_files; /* retreive data from table to check */
        if ($form_files->count() > 0) {
            $new = $form->application_files()->first();
            // delete old files
            if($img_str != ""){
                $olds = explode(',',$new->building);
                foreach($olds as $old){
                    if (file_exists($path.'/'.$old)) {
                        File::delete($path.'/'.$old);
                    }
                }
            }
            $new->building = $img_str;
            $form->application_files()->save($new);
        } else {
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->building = $img_str;
            $new->save();
        }

        return response()->json([
            'success'    => true,
            'token'     => $this->refresh_token($request->token),
            'form'       => $form
        ]);
    }

    // savve power အသုံးပြုမည့် ဝန်အားစာရင်း (မူရင်း)
    public function power(Request $request) {
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            'front'     => 'required',
            'front.*'     => ['image', 'mimes:jpeg,jpg,png'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $form = ApplicationForm::find($request->form_id);
        
        if (!is_dir(public_path('storage/user_attachments'))) {
            @mkdir(public_path('storage/user_attachments'));
        }
        
        if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
            @mkdir(public_path('storage/user_attachments/'.$form->id));
        }
        $path = public_path('storage/user_attachments/'.$form->id);
        $tmp_arr = [];
        
        foreach ($request->file('front') as $key => $value) {
            $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
            $save_db_img = get_random_string().'_'.getdate()[0].'.'.$value->getClientOriginalExtension();
            $save_file_img = Image::make($value);
            $save_file_img->resize(1600, 1600, function($constraint) {
                $constraint->aspectRatio();
            });
            $save_file_img->save($path.'/'.$save_db_img);
            array_push($tmp_arr, $save_db_img);
        }
        $img_str = count($tmp_arr) > 0 ? implode(',', $tmp_arr) : null;

        $form_files = $form->application_files; /* retreive data from table to check */
        if ($form_files->count() > 0) {
            $new = $form->application_files()->first();
            // delete old files
            $this->deleteMulipleFiles($new->electric_power, $path);
            $new->electric_power = $img_str;
            $form->application_files()->save($new);
        } else {
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->electric_power = $img_str;
            $new->save();
        }

        return response()->json([
            'success'    => true,
            'token'     => $this->refresh_token($request->token),
            'form'       => $form
        ]);
    }

    // save meter bill (current meter)
    public function bill(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            // 'front'     => 'required',
            'front'     => ['image', 'mimes:jpeg,jpg,png,pdf'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $form = ApplicationForm::find($request->form_id);
        
        if (!is_dir(public_path('storage/user_attachments'))) {
            @mkdir(public_path('storage/user_attachments'));
        }
        
        if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
            @mkdir(public_path('storage/user_attachments/'.$form->id));
        }
        $path = public_path('storage/user_attachments/'.$form->id);

        if ($request->hasFile('front')) {
            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_bill = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_bill);
        }else{
            $front_bill = null;
        }

        $form_files = $form->application_files; /* retreive data from table to check */
        if ($form_files->count() > 0) {
            $new = $form->application_files()->first();
            // $this->deleteFile($new->front_bill, $path);
            $new->prev_bill = $front_bill;
            $form->application_files()->save($new);
        } else {
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->prev_bill = $front_bill;
            $new->save();
        }

        return response()->json([
            'success'    => true,
            'token'      => $this->refresh_token($request->token),
            'form'       => $form
        ]);
    }

    // license
    public function license(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $form = ApplicationForm::find($request->form_id);
            
        if (!is_dir(public_path('storage/user_attachments'))) {
            @mkdir(public_path('storage/user_attachments'));
        }
        
        if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
            @mkdir(public_path('storage/user_attachments/'.$form->id));
        }
        $path = public_path('storage/user_attachments/'.$form->id);
        $tmp_arr = [];

        $img_str = null;
        if ($request->hasFile('front')) {
            foreach ($request->file('front') as $key => $value) {
                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $save_db_img = get_random_string().'_'.getdate()[0].'.'.$value->getClientOriginalExtension();
                $save_file_img = Image::make($value);
                $save_file_img->resize(1600, 1600, function($constraint) {
                $constraint->aspectRatio();
            });
                $save_file_img->save($path.'/'.$save_db_img);
                array_push($tmp_arr, $save_db_img);
            }
            $img_str = count($tmp_arr) > 0 ? implode(',', $tmp_arr) : null;
        }
            
        $form_files = $form->application_files; /* retreive data from table to check */
        if ($form_files->count() > 0) {
            $new = $form->application_files()->first();
            $olds = explode(',',$new->transaction_licence);
            foreach($olds as $old){
                if (file_exists($path.'/'.$old)) {
                    File::delete($path.'/'.$old);
                }
            }
            $new->transaction_licence = $img_str;
            $form->application_files()->save($new);
        } else {
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->transaction_licence = $img_str;
            $new->save();
        }
        
        return response()->json([
            'success'    => true,
            'token'      => $this->refresh_token($request->token),
            'form'       => $form
        ]);
    }

    // send form
    public function send_form(Request $request) {
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $form = ApplicationForm::find($request->form_id);
        if (chk_form_finish($form->id, $form->apply_type)['state']){
            if (chk_send($form->id) !== 'first' && $form->serial_code){
                $tmp_arr    = [];
                $form_id    = $request->form_id;
                $form       = ApplicationForm::find($form_id);
                $new        = FormProcessAction::where('application_form_id', $form_id)->first();
                if ($new) {
                    array_push($tmp_arr, $new->user_send_form_date);
                    array_push($tmp_arr, getdate()[0]);
                    $str_date = implode(',', $tmp_arr);
                    $new->user_send_to_office = 1;
                    $new->user_send_form_date = $str_date;
                } else {
                    $str_date = getdate()[0];
                    $new = new FormProcessAction();
                    $new->application_form_id = $form_id;
                    $new->user_send_to_office = 1;
                    $new->user_send_form_date = $str_date;
                }
                $new->save();
        
                $adminAction = new AdminAction();
                $adminAction->application_form_id = $form_id;
                $adminAction->save();

                return response()->json([
                    'success'    => true,
                    'token'     => $this->refresh_token($request->token),
                    'form'       => $form
                ]);
            }
        }

        return response()->json([
            'success'    => false,
            'title'     => 'Can\'t Sent',
            'message'    => 'This form is already sent!',
        ]);
    }

    // build allow
    public function building_permit(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            'front'     => ['image', 'mimes:jpeg,jpg,png,pdf'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $form = ApplicationForm::find($request->form_id);
        
        if (!is_dir(public_path('storage/user_attachments'))) {
            @mkdir(public_path('storage/user_attachments'));
        }
        
        if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
            @mkdir(public_path('storage/user_attachments/'.$form->id));
        }
        $path = public_path('storage/user_attachments/'.$form->id);

        $permit = null;
        if ($request->hasFile('front')) {
            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $permit = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                $constraint->aspectRatio();
            });
            $front_img->save($path.'/'.$permit);
        } 

        $form_files = $form->application_files; /* retreive data from table to check */
        if ($form_files->count() > 0) {
            $new = $form->application_files()->first();
            if($permit != null){
                if($new->building_permit != null){
                    if (file_exists($path.'/'.$new->building_permit)) {
                        File::delete($path.'/'.$new->building_permit);
                    }
                }
            }
            $new->building_permit = $permit;
            $form->application_files()->save($new);
        } else {
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->building_permit = $permit;
            $new->save();
        }

        return response()->json([
            'success'    => true,
            'token'     => $this->refresh_token($request->token),
            'form'       => $form
        ]);
    }

    // save bcc
    public function bcc(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            'front'     => ['image', 'mimes:jpeg,jpg,png,pdf'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $form = ApplicationForm::find($request->form_id);
        
        if (!is_dir(public_path('storage/user_attachments'))) {
            @mkdir(public_path('storage/user_attachments'));
        }
        
        if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
            @mkdir(public_path('storage/user_attachments/'.$form->id));
        }
        $path = public_path('storage/user_attachments/'.$form->id);

        $bcc = null;
        if ($request->hasFile('front')) {
            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $bcc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                $constraint->aspectRatio();
            });
            $front_img->save($path.'/'.$bcc);
        } 

        $form_files = $form->application_files; /* retreive data from table to check */
        if ($form_files->count() > 0) {
            $new = $form->application_files()->first();
            if($bcc != ''){
                if($new->bcc != ''){
                    if (file_exists($path.'/'.$new->bcc)) {
                        File::delete($path.'/'.$new->bcc);
                    }
                }
            }
            $new->bcc = $bcc;
            $form->application_files()->save($new);
        } else {
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->bcc = $bcc;
            $new->save();
        }

        return response()->json([
            'success'    => true,
            'token'     => $this->refresh_token($request->token),
            'form'       => $form
        ]);
    }

    // save dc
    public function dc(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            'front'     => ['image', 'mimes:jpeg,jpg,png,pdf'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $form = ApplicationForm::find($request->form_id);
            
        if (!is_dir(public_path('storage/user_attachments'))) {
            @mkdir(public_path('storage/user_attachments'));
        }
        
        if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
            @mkdir(public_path('storage/user_attachments/'.$form->id));
        }
        $path = public_path('storage/user_attachments/'.$form->id);

        $dc_recomm = null;
        if ($request->hasFile('front')) {
            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $dc_recomm = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                $constraint->aspectRatio();
            });
            $front_img->save($path.'/'.$dc_recomm);
        }

        if($dc_recomm != null){
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                if (file_exists($path.'/'.$new->dc_recomm)) {
                    File::delete($path.'/'.$new->dc_recomm);
                }
                $new->dc_recomm = $dc_recomm;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->dc_recomm = $dc_recomm;
                $new->save();
            }
        }

        return response()->json([
            'success'    => true,
            'token'     => $this->refresh_token($request->token),
            'form'       => $form
        ]);
    }

    // save bq
    public function bq(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            'front'     => 'required',
            'front.*'     => ['image', 'mimes:jpeg,jpg,png,pdf'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $form = ApplicationForm::find($request->form_id);
        
        if (!is_dir(public_path('storage/user_attachments'))) {
            @mkdir(public_path('storage/user_attachments'));
        }
        
        if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
            @mkdir(public_path('storage/user_attachments/'.$form->id));
        }
        $path = public_path('storage/user_attachments/'.$form->id);
        $tmp_arr = [];
        $img_str = null;
        if ($request->hasFile('front')) {
            foreach ($request->file('front') as $key => $value) {
                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $save_db_img = get_random_string().'_'.getdate()[0].'.'.$value->getClientOriginalExtension();
                $save_file_img = Image::make($value);
                $save_file_img->resize(1600, 1600, function($constraint) {
                $constraint->aspectRatio();
            });
                $save_file_img->save($path.'/'.$save_db_img);
                array_push($tmp_arr, $save_db_img);
            }
            $img_str = implode(',', $tmp_arr);
        }
        $form_files = $form->application_files; /* retreive data from table to check */
        if ($form_files->count() > 0) {
            $new = $form->application_files()->first();
            $this->deleteMulipleFiles($new->bq, $path);
            $new->bq = $img_str;
            $form->application_files()->save($new);
        } else {
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->bq = $img_str;
            $new->save();
        }

        return response()->json([
            'success'       => true,
            'token'         => $this->refresh_token($request->token),
            'form'          => $form
        ]);
    }

    // save bq
    public function drawing(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            'front'     => 'required',
            'front.*'     => ['image', 'mimes:jpeg,jpg,png,pdf'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $form = ApplicationForm::find($request->form_id);
            
        if (!is_dir(public_path('storage/user_attachments'))) {
            @mkdir(public_path('storage/user_attachments'));
        }
        
        if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
            @mkdir(public_path('storage/user_attachments/'.$form->id));
        }
        $path = public_path('storage/user_attachments/'.$form->id);
        $tmp_arr = [];
        $img_str = null;
        if ($request->hasFile('front')) {
            foreach ($request->file('front') as $key => $value) {
                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $save_db_img = get_random_string().'_'.getdate()[0].'.'.$value->getClientOriginalExtension();
                $save_file_img = Image::make($value);
                $save_file_img->resize(1600, 1600, function($constraint) {
                $constraint->aspectRatio();
            });
                $save_file_img->save($path.'/'.$save_db_img);
                array_push($tmp_arr, $save_db_img);
            }
            $img_str = implode(',', $tmp_arr);
        }
        $form_files = $form->application_files; /* retreive data from table to check */
        if ($form_files->count() > 0) {
            $new = $form->application_files()->first();
            if($img_str != ""){
                /* delete old file */
                $olds = explode(',',$new->drawing);
                foreach($olds as $old){
                    if (file_exists($path.'/'.$old)) {
                        File::delete($path.'/'.$old);
                    }
                }
                // update new
                $new->drawing = $img_str;
            }
            $form->application_files()->save($new);
        } else {
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->drawing = $img_str;
            $new->save();
        }

        return response()->json([
            'success'       => true,
            'token'         => $this->refresh_token($request->token),
            'form'          => $form
        ]);
    }

    // save location
    public function map(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            'front'     => 'required',
            'front.*'     => ['image', 'mimes:jpeg,jpg,png,pdf'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $form = ApplicationForm::find($request->form_id);
            
        if (!is_dir(public_path('storage/user_attachments'))) {
            @mkdir(public_path('storage/user_attachments'));
        }
        
        if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
            @mkdir(public_path('storage/user_attachments/'.$form->id));
        }
        $path = public_path('storage/user_attachments/'.$form->id);
        $tmp_arr = [];
        $img_str = null;
        if ($request->hasFile('front')) {
            foreach ($request->file('front') as $key => $value) {
                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $save_db_img = get_random_string().'_'.getdate()[0].'.'.$value->getClientOriginalExtension();
                $save_file_img = Image::make($value);
                $save_file_img->resize(1600, 1600, function($constraint) {
                $constraint->aspectRatio();
            });
                $save_file_img->save($path.'/'.$save_db_img);
                array_push($tmp_arr, $save_db_img);
            }
            $img_str = implode(',', $tmp_arr);
        }
        $form_files = $form->application_files; /* retreive data from table to check */
        if ($form_files->count() > 0) {
            $new = $form->application_files()->first();
            $this->deleteMulipleFiles($new->map, $path);
            $new->map = $img_str;
            $form->application_files()->save($new);
        } else {
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->map = $img_str;
            $new->save();
        }

        return response()->json([
            'success'       => true,
            'token'         => $this->refresh_token($request->token),
            'form'          => $form
        ]);
    }

    // save sign
    public function sign(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            'front.*'     => ['image', 'mimes:jpeg,jpg,png,pdf'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $form = ApplicationForm::find($request->form_id);
            
        if (!is_dir(public_path('storage/user_attachments'))) {
            @mkdir(public_path('storage/user_attachments'));
        }
        
        if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
            @mkdir(public_path('storage/user_attachments/'.$form->id));
        }
        $path = public_path('storage/user_attachments/'.$form->id);
        $tmp_arr = [];
        $img_str = null;
        if ($request->hasFile('front')) {
            foreach ($request->file('front') as $key => $value) {
                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $save_db_img = get_random_string().'_'.getdate()[0].'.'.$value->getClientOriginalExtension();
                $save_file_img = Image::make($value);
                $save_file_img->resize(1600, 1600, function($constraint) {
                $constraint->aspectRatio();
            });
                $save_file_img->save($path.'/'.$save_db_img);
                array_push($tmp_arr, $save_db_img);
            }
            $img_str = implode(',', $tmp_arr);
        }
        $form_files = $form->application_files; /* retreive data from table to check */
        if ($form_files->count() > 0) {
            $new = $form->application_files()->first();
            $this->deleteMulipleFiles($new->sign, $path);
            $new->sign = $img_str;
            $form->application_files()->save($new);
        } else {
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->sign = $img_str;
            $new->save();
        }

        return response()->json([
            'success'       => true,
            'token'         => $this->refresh_token($request->token),
            'form'          => $form
        ]);
    }

    // save industry
    public function industry(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            'front.*'     => ['image', 'mimes:jpeg,jpg,png,pdf'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $form = ApplicationForm::find($request->form_id);
            
        if (!is_dir(public_path('storage/user_attachments'))) {
            @mkdir(public_path('storage/user_attachments'));
        }
        
        if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
            @mkdir(public_path('storage/user_attachments/'.$form->id));
        }
        $path = public_path('storage/user_attachments/'.$form->id);
        $tmp_arr = [];

        if ($request->hasFile('front')) {
            foreach ($request->file('front') as $key => $value) {
                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $save_db_img = get_random_string().'_'.getdate()[0].'.'.$value->getClientOriginalExtension();
                $save_file_img = Image::make($value);
                $save_file_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $save_file_img->save($path.'/'.$save_db_img);
                array_push($tmp_arr, $save_db_img);
            }
        }
        $img_str = count($tmp_arr) > 0 ? implode(',', $tmp_arr) : null;
        
        $form_files = $form->application_files; /* retreive data from table to check */
        if ($form_files->count() > 0) {
            $new = $form->application_files()->first();
            $this->deleteMulipleFiles($new->industry, $path);
            $new->industry = $img_str;
            $form->application_files()->save($new);
        } else {
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->industry = $img_str;
            $new->save();
        }
        

        return response()->json([
            'success'       => true,
            'token'         => $this->refresh_token($request->token),
            'form'          => $form
        ]);
    }

    // save city_license
    public function city_license(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            'front.*'     => ['image', 'mimes:jpeg,jpg,png,pdf'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $form = ApplicationForm::find($request->form_id);
            
        if (!is_dir(public_path('storage/user_attachments'))) {
            @mkdir(public_path('storage/user_attachments'));
        }
        
        if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
            @mkdir(public_path('storage/user_attachments/'.$form->id));
        }
        $path = public_path('storage/user_attachments/'.$form->id);
        $tmp_arr = [];

        if ($request->hasFile('front')) {
            foreach ($request->file('front') as $key => $value) {
                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $save_db_img = get_random_string().'_'.getdate()[0].'.'.$value->getClientOriginalExtension();
                $save_file_img = Image::make($value);
                $save_file_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $save_file_img->save($path.'/'.$save_db_img);
                array_push($tmp_arr, $save_db_img);
            }
            $img_str = implode(',', $tmp_arr);
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                // delete old files
                $old_files = explode(',',$new->city_license);
                foreach($old_files as $old_file){
                    if (file_exists(public_path('storage/user_attachments/'.$form->id).'/'.$old_file) && $old_file != '') {
                        unlink(public_path('storage/user_attachments/'.$form->id).'/'.$old_file);
                    }
                }
                $new->city_license = $img_str;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->city_license = $img_str;
                $new->save();
            }
        }

        return response()->json([
            'success'  => true,
            'token'    => $this->refresh_token($request->token),
            'form'     => $form
        ]);
    }

     // save city_license
     public function ministry_permit(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            'front.*'     => ['image', 'mimes:jpeg,jpg,png,pdf'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $form = ApplicationForm::find($request->form_id);
            
        if (!is_dir(public_path('storage/user_attachments'))) {
            @mkdir(public_path('storage/user_attachments'));
        }
        
        if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
            @mkdir(public_path('storage/user_attachments/'.$form->id));
        }
        $path = public_path('storage/user_attachments/'.$form->id);
        $tmp_arr = [];

        if ($request->hasFile('front')) {
            foreach ($request->file('front') as $key => $value) {
                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                $save_db_img = get_random_string().'_'.getdate()[0].'.'.$value->getClientOriginalExtension();
                $save_file_img = Image::make($value);
                $save_file_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $save_file_img->save($path.'/'.$save_db_img);
                array_push($tmp_arr, $save_db_img);
            }
            $img_str = implode(',', $tmp_arr);
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                if($new->ministry_permit != ""){
                    // delete old files
                    $old_files = explode(',',$new->ministry_permit);
                    foreach($old_files as $old_file){
                        if (file_exists(public_path('storage/user_attachments/'.$form->id).'/'.$old_file) && $old_file != '') {
                            unlink(public_path('storage/user_attachments/'.$form->id).'/'.$old_file);
                        }
                    }
                }
                $new->ministry_permit = $img_str;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->ministry_permit = $img_str;
                $new->save();
            }
        }

        return response()->json([
            'success'  => true,
            'token'    => $this->refresh_token($request->token),
            'form'     => $form
        ]);
    }


    // save city_license
    public function overall_process(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $user = JWTAuth::authenticate($request->token);

        $user_data = ApplicationForm::select('application_forms.*', 'division_states.name as div_name', DB::raw('DATE_FORMAT(application_forms.date, "%d-%b-%Y") as date_f'))->where('user_id', $user->id)->orderBy('date', 'desc')->orderBy('id', 'asc')->leftJoin('division_states',function($join){
            $join->on('application_forms.div_state_id','=','division_states.id');
        })->get();
        
        $result = [];
        foreach ($user_data as $data){
            $status = cdt($data->id)[0];

            if (chk_send($data->id) == 'first'){
                $state_name = 'lang.'.chk_userForm($data->id)['msg'];
            }elseif (chk_send($data->id) == 'second'){
                $state_name = 'lang.resend_form';
            }else{
                $state_name = 'lang.'.$status;
            }
            $data->state = trans($state_name);
            array_push($result, $data);
        }

        return response()->json([
            'success'  => true,
            'token'    => $this->refresh_token($request->token),
            'count'     => count($user_data),
            'forms'     => $result
        ]);
    }

    // yangon residential meter
    public function ygn_r_show(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($request->form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');
        $fee = InitialCost::where([['type', 1], ['id', $form->apply_sub_type]])->first();

        $chk_send = false;
        if (chk_form_finish($form->id, $form->apply_type)['state']){
            if (chk_send($form->id) !== 'first' && $form->serial_code){
                $chk_send = true;
            }
        }

        if(chk_send($form->id) == 'first'){
            $msg = 'သင့်လျှောက်လွှာအား ရုံးသို့ပေးပို့ပြီးဖြစ်ပါသည်။ ';
            $state = 'send';
        }else{
            if(chk_form_finish($form->id, $form->apply_type)['state']){
                $msg = " သင့်လျှောက်လွှာအား ရုံးသို့ မပို့ရသေးပါ။ သေချာစွာစစ်ဆေး၍ ပေးပို့မည် အားနှိပ်ပါ။";
                $state = 'finish';
            }else{
                $msg="သင့်လျှောက်လွှာ ဖြည့်သွင်းခြင်း မပြီးသေးပါ။";
                $state = 'no-finish';
            }
        }
        return response()->json([
            'success'       => true,
            'token'         => $this->refresh_token($request->token),
            'form'          => $form,
            'files'         => $files,
            'tbl_col_name'  => $tbl_col_name,
            'fee_names'     => $fee,
            'chk_send'      => $chk_send,
            'msg'           => $msg,
            'state'         => $state,

            'township_name' => township_mm($form->township_id),
            'address'       => address_mm($form->id),
            'date'          => mmNum(date('d-m-Y', strtotime($form->date))),

            'path'          => $this->storagePath.$form->id.'/',
        ]);
    }
    public function mdy_r_show(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $form = ApplicationForm::find($request->form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');
        $fee = InitialCost::where([['type', 1], ['sub_type', $form->apply_sub_type]])->first();

        $chk_send = false;
        if (chk_form_finish($form->id, $form->apply_type)['state']){
            if (chk_send($form->id) !== 'first' && $form->serial_code){
                $chk_send = true;
            }
        }

        if(chk_send($form->id) == 'first'){
            $msg = 'သင့်လျှောက်လွှာအား ရုံးသို့ပေးပို့ပြီးဖြစ်ပါသည်။ ';
            $state = 'send';
        }else{
            if(chk_form_finish($form->id, $form->apply_type)['state']){
                $msg = " သင့်လျှောက်လွှာအား ရုံးသို့ မပို့ရသေးပါ။ သေချာစွာစစ်ဆေး၍ ပေးပို့မည် အားနှိပ်ပါ။";
                $state = 'finish';
            }else{
                $msg="သင့်လျှောက်လွှာ ဖြည့်သွင်းခြင်း မပြီးသေးပါ။";
                $state = 'no-finish';
            }
        }

        $total = 0; $feeMap = [];
        foreach ($tbl_col_name as $col_name){
            if ($col_name != 'building_fee' && $col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'composit_box' && $col_name != 'sub_type'){
                $name = $col_name;
                
                $value = mmNum(number_format($fee->$col_name));
                $feeMap[$name] = $value;
                $total += $fee->$col_name;
            }
        }
        $feeMap['total'] = mmNum(number_format($total));
        $feeMap['name'] = mmNum($fee->name);

        return response()->json([
            'success'       => true,
            'token'         => $this->refresh_token($request->token),
            'form'          => $form,
            'files'         => $files,
            'tbl_col_name'  => $tbl_col_name,
            'fee'           => $feeMap,
            'chk_send'      => $chk_send,
            'msg'           => $msg,
            'state'         => $state,

            'township_name' => township_mm($form->township_id),
            'address'       => address_mm($form->id),
            'date'          => mmNum(date('d-m-Y', strtotime($form->date))),

            'path'          => $this->storagePath.$form->id.'/',
        ]);
    }

    public function ygn_rp_show(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($request->form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');

        $fee = InitialCost::where([['type', 21], ['sub_type', $form->apply_sub_type]])->first();

        $chk_send = false;
        if (chk_form_finish($form->id, $form->apply_type)['state']){
            if (chk_send($form->id) !== 'first' && $form->serial_code){
                $chk_send = true;
            }
        }

        if(chk_send($form->id) == 'first'){
            $msg = 'သင့်လျှောက်လွှာအား ရုံးသို့ပေးပို့ပြီးဖြစ်ပါသည်။ ';
            $state = 'send';
        }else{
            if(chk_form_finish($form->id, $form->apply_type)['state']){
                $msg = " သင့်လျှောက်လွှာအား ရုံးသို့ မပို့ရသေးပါ။ သေချာစွာစစ်ဆေး၍ ပေးပို့မည် အားနှိပ်ပါ။";
                $state = 'finish';
            }else{
                $msg="သင့်လျှောက်လွှာ ဖြည့်သွင်းခြင်း မပြီးသေးပါ။";
                $state = 'no-finish';
            }
        }

        $total = 0; $feeMap = [];
        foreach ($tbl_col_name as $col_name){
            if ($col_name != 'building_fee' && $col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' &&  $col_name != 'incheck_fee' && $col_name != 'sub_type'){
                $name = $col_name;
                
                $value = mmNum(number_format($fee->$col_name));
                $feeMap[$name] = $value;
                $total += $fee->$col_name;
            }
        }
        $feeMap['total'] = mmNum(number_format($total));
        $feeMap['name'] = $fee->name;

         
        return response()->json([
            'success'       => true,
            'token'         => $this->refresh_token($request->token),
            'form'          => $form,
            'files'         => $files,
            'tbl_col_name'  => $tbl_col_name,
            'fee'           => $feeMap,
            'chk_send'      => $chk_send,
            'msg'           => $msg,
            'state'         => $state,

            'township_name' => township_mm($form->township_id),
            'address'       => address_mm($form->id),
            'date'          => mmNum(date('d-m-Y', strtotime($form->date))),

            'path'          => $this->storagePath.$form->id.'/',
        ]);
    }

    // yangon constructor meter show
    public function ygn_c_show(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($request->form_id);
        $c_form = ApplicationFormContractor::where('application_form_id', $request->form_id)->first();
        $files = $form->application_files;

        $chk_send = false;
        if (chk_form_finish($form->id, $form->apply_type)['state']){
            if (chk_send($form->id) !== 'first' && $form->serial_code){
                $chk_send = true;
            }
        }

        if(chk_send($form->id) == 'first'){
            $msg = 'သင့်လျှောက်လွှာအား ရုံးသို့ပေးပို့ပြီးဖြစ်ပါသည်။ ';
            $state = 'send';
        }else{
            if(chk_form_finish($form->id, $form->apply_type)['state']){
                $msg = " သင့်လျှောက်လွှာအား ရုံးသို့ မပို့ရသေးပါ။ သေချာစွာစစ်ဆေး၍ ပေးပို့မည် အားနှိပ်ပါ။";
                $state = 'finish';
            }else{
                $msg="သင့်လျှောက်လွှာ ဖြည့်သွင်းခြင်း မပြီးသေးပါ။";
                $state = 'no-finish';
            }
        }

        return response()->json([
            'success'       => true,
            'token'         => $this->refresh_token($request->token),
            'form'          => $form,
            'c_form'        => $c_form,
            'files'         => $files,
            'chk_send'      => $chk_send,
            'msg'           => $msg,
            'state'         => $state,

            'township_name' => township_mm($form->township_id),
            'address'       => address_mm($form->id),
            'date'          => mmNum(date('d-m-Y', strtotime($form->date))),

            'path'          => $this->storagePath.$form->id.'/',
        ]);

    }

    // constructor meter show
    public function constructor_show(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($request->form_id);
        $c_form = ApplicationFormContractor::where('application_form_id', $request->form_id)->first();
        $files = $form->application_files;

        $chk_send = false;
        if (chk_form_finish($form->id, $form->apply_type)['state']){
            if (chk_send($form->id) !== 'first' && $form->serial_code){
                $chk_send = true;
            }
        }

        if(chk_send($form->id) == 'first'){
            $msg = 'သင့်လျှောက်လွှာအား ရုံးသို့ပေးပို့ပြီးဖြစ်ပါသည်။ ';
            $state = 'send';
        }else{
            if(chk_form_finish($form->id, $form->apply_type)['state']){
                $msg = " သင့်လျှောက်လွှာအား ရုံးသို့ မပို့ရသေးပါ။ သေချာစွာစစ်ဆေး၍ ပေးပို့မည် အားနှိပ်ပါ။";
                $state = 'finish';
            }else{
                $msg="သင့်လျှောက်လွှာ ဖြည့်သွင်းခြင်း မပြီးသေးပါ။";
                $state = 'no-finish';
            }
        }

        return response()->json([
            'success'       => true,
            'token'         => $this->refresh_token($request->token),
            'form'          => $form,
            'c_form'        => $c_form,
            'files'         => $files,
            'chk_send'      => $chk_send,
            'msg'           => $msg,
            'state'         => $state,

            'township_name' => township_mm($form->township_id),
            'address'       => address_mm($form->id),
            'date'          => mmNum(date('d-m-Y', strtotime($form->date))),

            'path'          => $this->storagePath.$form->id.'/',
        ]);

    }

    public function ygn_t_money(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $tbl_col_name = Schema::getColumnListing('initial_costs');

        $costs = InitialCost::whereNotIn('name',['630','800','1500'])->where('type', 4)->get();

        $fees = [];
        foreach($costs as $cost){
            $total = 0; $feeMap = [];
            foreach ($tbl_col_name as $col_name){
                if ($col_name != 'building_fee' && $col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'composit_box' && $col_name != 'sub_type' && $col_name != 'incheck_fee'){
                    $name = $col_name;
                    $value = mmNum(number_format($cost->$col_name));
                    $feeMap[$name] = $value;
                    $total += $cost->$col_name;
                }
            }
            $feeMap['total'] = mmNum(number_format($total));
            $feeMap['name'] = mmNum($cost->name);
            $feeMap['type'] = $cost->sub_type;
            array_push($fees, $feeMap);
        }


        return response()->json([
            'success'       => true,
            'token'         => $this->refresh_token($request->token),
            'fees'           => $fees,
        ]);
    }

    //yangon transformer (residential transformer) show
    public function ygn_t_show(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($request->form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');
        $fee = InitialCost::whereNotIn('name',['630','800','1500'])->where([['type', 4], ['sub_type', $form->apply_sub_type]])->first();

        $chk_send = false;
        if (chk_form_finish($form->id, $form->apply_type)['state']){
            if (chk_send($form->id) !== 'first' && $form->serial_code){
                $chk_send = true;
            }
        }

        if(chk_send($form->id) == 'first'){
            $msg = 'သင့်လျှောက်လွှာအား ရုံးသို့ပေးပို့ပြီးဖြစ်ပါသည်။ ';
            $state = 'send';
        }else{
            if(chk_form_finish($form->id, $form->apply_type)['state']){
                $msg = " သင့်လျှောက်လွှာအား ရုံးသို့ မပို့ရသေးပါ။ သေချာစွာစစ်ဆေး၍ ပေးပို့မည် အားနှိပ်ပါ။";
                $state = 'finish';
            }else{
                $msg="သင့်လျှောက်လွှာ ဖြည့်သွင်းခြင်း မပြီးသေးပါ။";
                $state = 'no-finish';
            }
        }

        $total = 0; $feeMap = [];
        foreach ($tbl_col_name as $col_name){
            if ($col_name != 'building_fee' && $col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'composit_box' && $col_name != 'sub_type' && $col_name != 'incheck_fee'){
                $name = $col_name;
                $value = mmNum(number_format($fee->$col_name));
                $feeMap[$name] = $value;
                $total += $fee->$col_name;
            }
        }
        $feeMap['total'] = mmNum(number_format($total));
        $feeMap['name'] = $fee->name;


        return response()->json([
            'success'       => true,
            'token'         => $this->refresh_token($request->token),
            'form'          => $form,
            'files'         => $files,
            'tbl_col_name'  => $tbl_col_name,
            'fee'           => $feeMap,
            
            'chk_send'      => $chk_send,
            'msg'           => $msg,
            'state'         => $state,

            'township_name' => township_mm($form->township_id),
            'address'       => address_mm($form->id),
            'date'          => mmNum(date('d-m-Y', strtotime($form->date))),
            'tsf_type'      => tsf_type($form->id),

            'path'          => $this->storagePath.$form->id.'/',
        ]);

    }

    public function mdy_t_money(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $tbl_col_name = Schema::getColumnListing('initial_costs');

        $costs = InitialCost::where('building_fee','!=',null)->where('type', 4)->get();
        
        $fees = [];
        foreach($costs as $cost){
            $total = 0; $feeMap = [];
            foreach ($tbl_col_name as $col_name){
                if ($col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'composit_box' && $col_name != 'sub_type' && $col_name != 'incheck_fee'){
                    $name = $col_name;
                    $value = mmNum(number_format($cost->$col_name));
                    $feeMap[$name] = $value;
                    $total += $cost->$col_name;
                }
            }
            $feeMap['total'] = mmNum(number_format($total));
            $feeMap['name'] = mmNum($cost->name);
            $feeMap['type'] = $cost->sub_type;
            array_push($fees, $feeMap);
        }


        return response()->json([
            'success'       => true,
            'token'         => $this->refresh_token($request->token),
            'fees'           => $fees,
        ]);
    }

    // mandalary transformer show
    public function mdy_t_show(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($request->form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');
        $fee = InitialCost::where('building_fee','!=',null)->where([['type', 4], ['sub_type', $form->apply_sub_type]])->first();

        $chk_send = false;
        if (chk_form_finish($form->id, $form->apply_type)['state']){
            if (chk_send($form->id) !== 'first' && $form->serial_code){
                $chk_send = true;
            }
        }

        if(chk_send($form->id) == 'first'){
            $msg = 'သင့်လျှောက်လွှာအား ရုံးသို့ပေးပို့ပြီးဖြစ်ပါသည်။ ';
            $state = 'send';
        }else{
            if(chk_form_finish($form->id, $form->apply_type)['state']){
                $msg = " သင့်လျှောက်လွှာအား ရုံးသို့ မပို့ရသေးပါ။ သေချာစွာစစ်ဆေး၍ ပေးပို့မည် အားနှိပ်ပါ။";
                $state = 'finish';
            }else{
                $msg="သင့်လျှောက်လွှာ ဖြည့်သွင်းခြင်း မပြီးသေးပါ။";
                $state = 'no-finish';
            }
        }

        $total = 0; $feeMap = [];
        foreach ($tbl_col_name as $col_name){
            if ($col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'composit_box' && $col_name != 'sub_type' && $col_name != 'incheck_fee'){
                $name = $col_name;
                $value = mmNum(number_format($fee->$col_name));
                $feeMap[$name] = $value;
                $total += $fee->$col_name;
            }
        }
        $feeMap['total'] = mmNum(number_format($total));
        $feeMap['name'] = $fee->name;


        return response()->json([
            'success'       => true,
            'token'         => $this->refresh_token($request->token),
            'form'          => $form,
            'files'         => $files,
            'tbl_col_name'  => $tbl_col_name,
            'fee'           => $feeMap,
            
            'chk_send'      => $chk_send,
            'msg'           => $msg,
            'state'         => $state,

            'township_name' => township_mm($form->township_id),
            'address'       => address_mm($form->id),
            'date'          => mmNum(date('d-m-Y', strtotime($form->date))),
            'tsf_type'      => tsf_type($form->id),

            'path'          => $this->storagePath.$form->id.'/',
        ]);
    }

    public function other_t_money(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $tbl_col_name = Schema::getColumnListing('initial_costs');

        $costs = InitialCost::whereNotIn('name',['630','800','1500'])->where('type', 4)->get();
        
        $fees = [];
        foreach($costs as $cost){
            $total = 0; $feeMap = [];
            foreach ($tbl_col_name as $col_name){
                if ($col_name != 'building_fee' && $col_name != 'id' && $col_name != 'type' && $col_name != 'incheck_fee' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'composit_box' && $col_name != 'sub_type'){
                    $name = $col_name;
                    $value = mmNum(number_format($cost->$col_name));
                    $feeMap[$name] = $value;
                    $total += $cost->$col_name;
                }
            }
            $feeMap['total'] = mmNum(number_format($total));
            $feeMap['name'] = mmNum($cost->name);
            $feeMap['type'] = $cost->sub_type;
            array_push($fees, $feeMap);
        }


        return response()->json([
            'success'       => true,
            'token'         => $this->refresh_token($request->token),
            'fees'          => $fees,
        ]);
    }

    // mandalary transformer show
    public function other_t_show(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($request->form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');
        $fee = InitialCost::whereNotIn('name',['630','800','1500'])->where([['type', 4], ['sub_type', $form->apply_sub_type]])->first();

        $chk_send = false;
        if (chk_form_finish($form->id, $form->apply_type)['state']){
            if (chk_send($form->id) !== 'first' && $form->serial_code){
                $chk_send = true;
            }
        }

        if(chk_send($form->id) == 'first'){
            $msg = 'သင့်လျှောက်လွှာအား ရုံးသို့ပေးပို့ပြီးဖြစ်ပါသည်။ ';
            $state = 'send';
        }else{
            if(chk_form_finish($form->id, $form->apply_type)['state']){
                $msg = " သင့်လျှောက်လွှာအား ရုံးသို့ မပို့ရသေးပါ။ သေချာစွာစစ်ဆေး၍ ပေးပို့မည် အားနှိပ်ပါ။";
                $state = 'finish';
            }else{
                $msg="သင့်လျှောက်လွှာ ဖြည့်သွင်းခြင်း မပြီးသေးပါ။";
                $state = 'no-finish';
            }
        }

        $total = 0; $feeMap = [];
        foreach ($tbl_col_name as $col_name){
            if ($col_name != 'building_fee' && $col_name != 'id' && $col_name != 'type' && $col_name != 'incheck_fee' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'composit_box' && $col_name != 'sub_type'){
                $name = $col_name;
                $value = mmNum(number_format($fee->$col_name));
                $feeMap[$name] = $value;
                $total += $fee->$col_name;
            }
        }
        $feeMap['total'] = mmNum(number_format($total));
        $feeMap['name'] = $fee->name;


        return response()->json([
            'success'       => true,
            'token'         => $this->refresh_token($request->token),
            'form'          => $form,
            'files'         => $files,
            'tbl_col_name'  => $tbl_col_name,
            'fee'           => $feeMap,
            
            'chk_send'      => $chk_send,
            'msg'           => $msg,
            'state'         => $state,

            'township_name' => township_mm($form->township_id),
            'address'       => address_mm($form->id),
            'date'          => mmNum(date('d-m-Y', strtotime($form->date))),
            'tsf_type'      => tsf_type($form->id),

            'path'          => $this->storagePath.$form->id.'/',
        ]);
    }

    public function refresh_token($token){
        try{
            $new_token = JWTAuth::refresh($token);
            return $new_token;
        }catch(TokenInvalidException $e){
            return $token;
        }
    }

    function deleteMulipleFiles($files, $path){
        $olds = explode(',',$files);
        foreach($olds as $old){
            if (file_exists($path.'/'.$old)) {
                File::delete($path.'/'.$old);
            }
        }
    }
    function deleteFile($file, $path){
        if (file_exists($path.'/'.$file)) {
            File::delete($path.'/'.$file);
        }
    }


    // yangon Commerical Power  meter
    public function ygn_cp_show(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($request->form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');

        $fee = InitialCost::where([['type', 3], ['sub_type', $form->apply_sub_type]])->first();

        $chk_send = false;
        if (chk_form_finish($form->id, $form->apply_type)['state']){
            if (chk_send($form->id) !== 'first' && $form->serial_code){
                $chk_send = true;
            }
        }

        if(chk_send($form->id) == 'first'){
            $msg = 'သင့်လျှောက်လွှာအား ရုံးသို့ပေးပို့ပြီးဖြစ်ပါသည်။ ';
            $state = 'send';
        }else{
            if(chk_form_finish($form->id, $form->apply_type)['state']){
                $msg = " သင့်လျှောက်လွှာအား ရုံးသို့ မပို့ရသေးပါ။ သေချာစွာစစ်ဆေး၍ ပေးပို့မည် အားနှိပ်ပါ။";
                $state = 'finish';
            }else{
                $msg="သင့်လျှောက်လွှာ ဖြည့်သွင်းခြင်း မပြီးသေးပါ။";
                $state = 'no-finish';
            }
        }

        $total = 0; $feeMap = [];
        foreach ($tbl_col_name as $col_name){
            if ($col_name != 'building_fee' && $col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'service_fee' && $col_name != 'incheck_fee' && $col_name != 'sub_type'){
                $name = $col_name;
                
                $value = mmNum(number_format($fee->$col_name));
                $feeMap[$name] = $value;
                $total += $fee->$col_name;
            }
        }
        $feeMap['total'] = mmNum(number_format($total));
        $feeMap['name'] = $fee->name;

         
        return response()->json([
            'success'       => true,
            'token'         => $this->refresh_token($request->token),
            'form'          => $form,
            'files'         => $files,
            'tbl_col_name'  => $tbl_col_name,
            'fee'           => $feeMap,
            'chk_send'      => $chk_send,
            'msg'           => $msg,
            'state'         => $state,

            'township_name' => township_mm($form->township_id),
            'address'       => address_mm($form->id),
            'date'          => mmNum(date('d-m-Y', strtotime($form->date))),

            'path'          => $this->storagePath.$form->id.'/',
        ]);
    }
}