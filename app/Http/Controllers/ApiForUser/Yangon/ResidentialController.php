<?php

namespace App\Http\Controllers\ApiForUser\Yangon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Usage Models
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

// Database Models
use App\User;
use App\User\ApplicationForm;
use App\User\ApplicationFile;
use App\Admin\FormProcessAction;
use App\Admin\AdminAction;

class ResidentialController extends Controller
{
    public function __construct()
    {
        $this->apply_division = 1; // yangon
        $this->apply_type = 1; // residential
    }

    // step1 : choose meter type
    public function meter_type(Request $request){
        $validator = Validator::make($request->all(),[
            'token' => 'required'
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
        $form->apply_type = $this->apply_type;
        $form->apply_sub_type = 3; // ကောက်ခံရမည့်နှုန်းထားအရ
        $form->apply_division = $this->apply_division;
        $form->date = date('Y-m-d');
        $form->save();

        return response()->json([
            'success'   => true,
            'token'     => $this->refresh_token($request->token),
            'form'      => $form,
        ]);
    }

    // step 2 : application form
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
            'district_id'              => 'required',
            'div_state_id'                => 'required',
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

    // step 3 : application form
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
            if($front_nrc != ''){
                $old_front = $new->nrc_copy_front;
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
                $new->nrc_copy_front = $front_nrc;
            }
            if($back_nrc != ''){
                $old_back = $new->nrc_copy_back;
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
                $new->nrc_copy_back = $back_nrc;
            }
            $form->application_files()->save($new);
        } else {
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->nrc_copy_front = $front_nrc;
            $new->nrc_copy_back = $back_nrc;
            $form->application_files()->save($new);
        }

        return response()->json([
            'success'    => true,
            'token'     => $this->refresh_token($request->token),
            'form'       => $form
        ]);
    }

    // step 4 : form10  အိမ်ထောင်စုစာရင်
    public function form10(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            'front'     => 'required',
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
            if($front_form_10 != ""){
                // delete old files
                $olds = explode(',',$new->form_10_front);
                foreach($olds as $old){
                    if (file_exists($path.'/'.$old)) {
                        File::delete($path.'/'.$old);
                    }
                }
                // update new
                $new->form_10_front = $front_form_10;
            }
            if($back_form_10 != ""){
                // delete old files
                $olds = explode(',',$new->back_form_10);
                foreach($olds as $old){
                    if (file_exists($path.'/'.$old)) {
                        File::delete($path.'/'.$old);
                    }
                }
                // update new
                $new->form_10_back = $back_form_10;
            }
            $form->application_files()->save($new);
        } else {
            $new = new ApplicationFile();
            $new->form_10_front = $front_form_10;
            $new->form_10_back = $back_form_10;
            $new->save();
        }

        return response()->json([
            'success'    => true,
            'token'     => $this->refresh_token($request->token),
            'form'       => $form,
            'front'      => $front_form_10,
            'back'       => $back_form_10
        ]);
    }

    // step 5 : recommanded ထောက်ခံစာ
    public function recommanded(Request $request){
        $validator = Validator::make($request->all(),[
            'token'     => 'required',
            'form_id'   => 'required',
            'front'     => 'required|mimes:jpeg,jpg,png',
            'back'      => 'required|mimes:jpeg,jpg,png',
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

        $occupy_ext = $request->file('front')->getClientOriginalExtension();
        $occupy_img = Image::make($request->file('front'));
        $occupy = get_random_string().'_'.getdate()[0].'.'.$occupy_ext;
        $occupy_img->resize(1600, 1600, function($constraint) {
                $constraint->aspectRatio();
            });
        $occupy_img->save($path.'/'.$occupy);

        $no_invade_ext = $request->file('back')->getClientOriginalExtension();
        $no_invade_img = Image::make($request->file('back'));
        $no_invade = get_random_string().'_'.getdate()[0].'.'.$no_invade_ext;
        $no_invade_img->resize(1600, 1600, function($constraint) {
                $constraint->aspectRatio();
            });
        $no_invade_img->save($path.'/'.$no_invade);

        $form_files = $form->application_files; /* retreive data from table to check */
        if ($form_files->count() > 0) {
            $new = $form->application_files()->first();
            // delete old files
            if($occupy != ""){
                $old = $new->occupy_letter;
                if (file_exists($path.'/'.$old)) {
                    File::delete($path.'/'.$old);
                }
                $new->occupy_letter = $occupy;
            }
            // delete old files
            if($no_invade != ""){
                $old = $new->no_invade_letter;
                if (file_exists($path.'/'.$old)) {
                    File::delete($path.'/'.$old);
                }
                $new->no_invade_letter = $no_invade;
            }
            $form->application_files()->save($new);
        } else {
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->occupy_letter = $occupy;
            $new->no_invade_letter = $no_invade;
            $new->save();
        }

        return response()->json([
            'success'    => true,
            'token'     => $this->refresh_token($request->token),
            'form'       => $form
        ]);
    }

    // step 6 : ownership
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
                // update new
                $new->ownership = $img_str;
            }
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

    // step 7 : farmland 
    public function farmland(Request $request){
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
                $olds = explode(',',$new->farmland);
                foreach($olds as $old){
                    if (file_exists($path.'/'.$old)) {
                        File::delete($path.'/'.$old);
                    }
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

    // step 8 : building
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

    // step 9 : power အသုံးပြုမည့် ဝန်အားစာရင်း (မူရင်း)
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
            if($img_str != ""){
                $olds = explode(',',$new->electric_power);
                foreach($olds as $old){
                    if (file_exists($path.'/'.$old)) {
                        File::delete($path.'/'.$old);
                    }
                }
            }
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

    // step 9 : power အသုံးပြုမည့် ဝန်အားစာရင်း (မူရင်း)
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

    function refresh_token($token){
        return $token;
        try{
            $new_token = JWTAuth::refresh($token);
            return $new_token;
        }catch(TokenInvalidException $e){
            return $token;
        }
    }    
}
