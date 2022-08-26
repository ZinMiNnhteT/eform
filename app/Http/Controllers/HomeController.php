<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\User\Payment;
use App\Admin\MailTbl;
use App\User\FormDraft;
use App\Admin\FormSurvey;
use App\Setting\District;
use App\Setting\Township;
use App\Admin\AdminAction;
use App\Setting\InitialCost;
use Illuminate\Http\Request;
use App\User\ApplicationFile;
use App\User\ApplicationForm;
use App\Setting\DivisionState;
use App\Admin\FormProcessAction;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Schema;
use App\Admin\ApplicationFormContractor;
use Hash;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /* ------------------------------------------------------------------------ */
    /* Show the application dashboard. */
    public function index() {
        $active = 'index';
        return view('user.home', compact('active'));
    }
    /* ------------------------------------------------------------------------ */

    /* ------------------------------------------------------------------------ */
    /* Show user inbox. */
    public function user_inbox() {
        $active = 'inbox';
        $click_active =  '';
        $mail = MailTbl::where('user_id', Auth::user()->id)->orderBy('mail_send_date', 'desc')->get();
        $mail_data = false;
        return view('user.inbox', compact('active', 'mail', 'mail_data','click_active'));
    }
    public function user_inbox2($mail_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'inbox';
            if ($mail_id) {
                $mail_data = MailTbl::where([['id', $mail_id], ['user_id', Auth::user()->id]])->first();
                $user = User::find($mail_data->user_id);
                $form = ApplicationForm::find($mail_data->application_form_id);
                $click_active =  'active';
                if ($mail_data->mail_read == false) {
                    $mail_data->mail_read = true;
                    $mail_data->mail_seen = true;
                    $mail_data->save();
                }
            }
            $mail = MailTbl::where('user_id', Auth::user()->id)->orderBy('mail_send_date', 'desc')->get();

            return view('user.inbox', compact('active', 'mail', 'mail_data', 'user', 'form', 'click_active'));
        } else {
            return redirect()->route('home');
        }
    }
    /* ------------------------------------------------------------------------ */

    /* ------------------------------------------------------------------------ */
    /* Show user payment. */
    public function user_payment_form_create($form_id) {
        $active = '';
        $form = ApplicationForm::find($form_id);
        $c_form = ApplicationFormContractor::where('application_form_id', $form_id)->first();
        $confirm_c_form = FormSurvey::where('application_form_id', $form_id)->first();
        $sub_type = InitialCost::where([['type', $form->apply_type], ['sub_type', $form->apply_sub_type]])->first();

        $payment = Payment::where('application_form_id', $form_id)->first();
        if ($payment) {
            abort(403, __('lang.payment_form_msg'));
        } else {
            return view('user.paymentForm_create', compact('active', 'form', 'c_form', 'sub_type', 'confirm_c_form'));
        }
    }
    public function user_payment_form_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;
            $online_payment = $request->online_payment;

            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->user_pay = true;
            $action->user_paid_date = date('Y-m-d H:i:s');
            $action->save();
            
            $payment = new Payment();
            $payment->application_form_id = $form_id;
            $payment->payment_type = 2;
            $payment->save();
            return redirect()->route('overall_process');
        } else {
            return redirect()->route('home');
        }
    }
    /* ------------------------------------------------------------------------ */

    /* ------------------------------------------------------------------------ */
    /* Show user overall process. */
    public function user_overall_process() {
        $active = 'overall';
        $heading = 'process_menu';
        $user_data = ApplicationForm::where('user_id', Auth::user()->id)->orderBy('date', 'desc')->orderBy('id', 'asc')->paginate(10);
        $user_data->appends(request()->query());
        return view('user.overallprocess', compact('active', 'heading', 'user_data'))->with('i', (request()->input('page', 1) - 1) * 10);
    }
    /* ------------------------------------------------------------------------ */

    /* ------------------------------------------------------------------------ */
    /* Show user rules and regulations. */
    public function rules_and_regulations() {
        $active = 'rule_regu';
        $heading = 'rr_menu';
        return view('user.rules_and_regulation', compact('active', 'heading'));
    }
    /* ------------------------------------------------------------------------ */

    /* ------------------------------------------------------------------------ */
    /* Show FAQs. */
    public function faqs() {
        $active = 'faqs';
        $heading = 'faqs';
        return view('user.faqs', compact('active', 'heading'));
    }
    /* ------------------------------------------------------------------------ */

    /* ------------------------------------------------------------------------ */
    /* Residentialial Meter */
    public function all_meter_forms() {
        $active = 'resident_app';
        // echo 'hello';
        return view('user.all_forms_view', compact('active'));
    }

    /* =============================================================================================================== */
    /* For Other Division/State */
    public function residential_index() {
        $active = 'resident_app';
        return view('user.application', compact('active'));
    }
    /* Rule */
    public function residential_rule_regulation() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'rule_regulation';
            return view('user.other.residential.rules_and_regulations', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }

    public function residential_agreement() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'agreement';
            return view('user.other.residential.agreement', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }

    /* Other Division/State Residential Type Start */ 
    public function residential_select_meter_type() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('type', 1)->get();
            return view('user.other.residential.residential_form_1', compact('active', 'fee_names', 'tbl_col_name'));
        } else {
            return redirect()->route('home');
        }
    }
    public function residential_store_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $new = new ApplicationForm();
            $new->user_id = Auth::user()->id;
            $new->apply_type = 1;
            $new->apply_sub_type = $request->sub_type;
            $new->apply_division = 2;
            $new->date =  date('Y-m-d');
            $new->save();
            return redirect()->route('resident_user_info', $new->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function residential_edit_meter_type($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('type', 1)->get();
            $form = ApplicationForm::find($form_id);
            return view('user.other.residential.residential_form_1_edit', compact('active', 'fee_names', 'tbl_col_name', 'form'));
        } else {
            return redirect()->route('home');
        }
    }
    public function residential_update_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;
            $new = ApplicationForm::find($form_id);
            if ($new->apply_sub_type !== $request->sub_type) {
                $new->apply_sub_type = $request->sub_type;
                $new->save();
            }
            return redirect()->route('resident_applied_form', $form_id);
        } else {
            return redirect()->route('home');
        }
    }
    /* Type End */ 
    /* Other Division/State Residential User Info Start */ 
    public function residential_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', '!=', 2)->where('division_state_id', '!=', 3)->get();
            $draft_data = FormDraft::where('application_form_id', $form_id)->first();
            // dd($draft_data);
            return view('user.other.residential.residential_form_2', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'draft_data'));
        } else {
            return redirect()->route('home');
        }
    }
    public function residential_store_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            if ($request->save_type == 'save') {
                $this->validate($request, [
                    'fullname' => 'required',
                    'nrc' => 'required',
                    'applied_phone' => ['required', 'min:9', 'max:11'],
                    'jobType' => 'required',
                    'applied_building_type' => 'required',
                    'applied_home_no' => 'required',
                    'applied_street' => 'required',
                    'applied_quarter' => 'required',
                    'township_id' => 'required',
                    'district' => 'required',
                    'region' => 'required',
                ]);
            }
            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $serial_code = get_serial($div_state_id);

            if ($request->save_type == 'save') {
                $new = ApplicationForm::find($form_id);
                $new->serial_code = $serial_code;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->save();
                return redirect()->route('resident_nrc_create', $form_id);
            } elseif ($request->save_type == 'draft') {
                $alrdy_draft = FormDraft::where('application_form_id', $form_id)->first();
                if ($alrdy_draft) {
                    $new = $alrdy_draft;
                } else {
                    $new = new FormDraft();
                }
                $new->application_form_id = $form_id;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->date = date('Y-m-d');
                $new->save();
                return redirect()->route('all_meter_forms');
            }
        } else {
            return redirect()->route('home');
        }
    }
    public function residential_edit_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', '!=', 2)->where('division_state_id', '!=', 3)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if ($d_form) {
                    $form = $d_form;
                    $form->id = $form_id;
                }
            }
            return view('user.other.residential.residential_form_2_edit', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'form'));
        } else {
            return redirect()->route('home');
        }
    }
    public function residential_update_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'fullname' => 'required',
                'nrc' => 'required',
                'applied_phone' => 'required',
                'jobType' => 'required',
                'applied_building_type' => 'required',
                'applied_home_no' => 'required',
                'applied_street' => 'required',
                'applied_quarter' => 'required',
                'township_id' => 'required',
            ]);

            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $new = ApplicationForm::find($form_id);
            if (!$new->serial_code || ($new->div_state_id == null) || ( $new->div_state_id != $div_state_id )) {
                $serial_code = get_serial($div_state_id);
                $new->serial_code = $serial_code;
            }
            $new->fullname = $fullname;
            $new->nrc = $nrc;
            $new->applied_phone = $applied_phone;
            $new->job_type = $request->jobType;
            $new->position = $position;
            $new->department = $department;
            $new->salary = $salary ? $salary : 0;
            $new->applied_building_type = $applied_building_type;
            $new->applied_home_no = $applied_home_no;
            $new->applied_building = $applied_building;
            $new->applied_street = $applied_street;
            $new->applied_quarter = $applied_quarter;
            $new->applied_town = $applied_town;
            $new->township_id = $township_id;
            $new->district_id = $district_id;
            $new->div_state_id = $div_state_id;
            $new->save();
            return redirect()->route('resident_applied_form', $form_id);
        } else {
            return redirect()->route('home');
        }
    }
    /* User Info End */ 

    /* Other Division/State Residential  Nrc Start */ 
    public function residential_nrc_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            return view('user.other.residential.residential_form_3', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function residential_nrc_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png'],
                'back' => ['image', 'mimes:jpeg,jpg,png'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

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
            
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->nrc_copy_front = $front_nrc;
            $new->nrc_copy_back = $back_nrc;
            $form->application_files()->save($new);
            return redirect()->route('resident_form10_create', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function residential_nrc_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.residential.residential_form_3_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function residential_nrc_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front ? $request->old_front : NULL;
            $old_back = $request->old_back ? $request->old_back : NULL;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $new->save();
            }
            return redirect()->route('resident_applied_form', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    /* Nrc End */ 

    /* Other Division/State Residential  Form10 Start */ 
    public function residential_form10_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            return view('user.other.residential.residential_form_4', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function residential_form10_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                $constraint->aspectRatio();
            });
            $front_img->save($path.'/'.$front_form_10);
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
            } else {
                $back_form_10 = null;
            }
            
            $new = $form->application_files()->first();
            $new->form_10_front = $front_form_10;
            $new->form_10_back = $back_form_10;
            $form->application_files()->save($new);
            return redirect()->route('resident_recomm_create', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function residential_form10_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.residential.residential_form_4_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function residential_form10_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_form_10);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_form_10 = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
                
                /* delete old file */
                if ($old_back && file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_form_10 = $old_back;
            }
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $new->save();
            }
            return redirect()->route('resident_applied_form', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    /* Form10 End */

    /* Other Division/State Residential Recommanded Start */ 
    public function residential_recomm_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            return view('user.other.residential.residential_form_5', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function residential_recomm_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required|mimes:jpeg,jpg,png,pdf',
                'back' => 'required|mimes:jpeg,jpg,png,pdf',
            ]);
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
            
            $new = $form->application_files()->first();
            $new->occupy_letter = $occupy;
            $new->no_invade_letter = $no_invade;
            $form->application_files()->save($new);
            return redirect()->route('resident_owner_create', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function residential_recomm_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.residential.residential_form_5_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function residential_recomm_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $new->save();
            }
            return redirect()->route('resident_applied_form', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    /* Recommanded End */ 

    /* Other Division/State Residential Owner Start */ 
    public function residential_owner_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            return view('user.other.residential.residential_form_6', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function residential_owner_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);
            $new = $form->application_files()->first();
            // dd($new);
            $new->ownership = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('resident_applied_form', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function residential_owner_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.residential.residential_form_6_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function residential_owner_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->ownership = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->ownership = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('resident_applied_form', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    /* Owner End */ 

    // public function residential_bill_create($form_id) {
    //     if (isset($_SERVER['HTTP_REFERER'])) {
    //         $active = 'resident_app';
    //         $heading = 'applied_neighbour_bill_photo';
    //         return view('user.other.residential.residential_form_7', compact('active', 'form_id', 'heading'));
    //     } else {
    //         return redirect()->route('home');
    //     }
    // }
    // public function residential_bill_store(Request $request) {
    //     if (isset($_SERVER['HTTP_REFERER'])) {
    //         $this->validate($request, [
    //             'front' => 'required',
    //         ]);
    //         $form = ApplicationForm::find($request->form_id);
            
    //         if (!is_dir(public_path('storage/user_attachments'))) {
    //             @mkdir(public_path('storage/user_attachments'));
    //         }
            
    //         if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
    //             @mkdir(public_path('storage/user_attachments/'.$form->id));
    //         }
    //         $path = public_path('storage/user_attachments/'.$form->id);
    //         $front_ext = $request->file('front')->getClientOriginalExtension();
    //         $front_img = Image::make($request->file('front'));
    //         $front_bill = get_random_string().'_'.getdate()[0].'.'.$front_ext;
    //         $front_img->resize(1600, 1600, function($constraint) {
    //                 $constraint->aspectRatio();
    //             });
    //         $front_img->save($path.'/'.$front_bill);

    //         $new = $form->application_files()->first();
    //         $new->prev_bill = $front_bill;
    //         $form->application_files()->save($new);
    //         return redirect()->route('resident_applied_form', $form->id);
    //     } else {
    //         return redirect()->route('home');
    //     }
    // }
    // public function residential_bill_edit($form_id) {
    //     if (isset($_SERVER['HTTP_REFERER'])) {
    //         $active = 'resident_app';
    //         $heading = 'applied_neighbour_bill_photo';
    //         $form = ApplicationForm::find($form_id);
    //         $files = $form->application_files;
    //         return view('user.other.residential.residential_form_7_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
    //     } else {
    //         return redirect()->route('home');
    //     }
    // }
    // public function residential_bill_update(Request $request) {
    //     if (isset($_SERVER['HTTP_REFERER'])) {
    //         $this->validate($request, [
    //             'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
    //         ]);
    //         $form = ApplicationForm::find($request->form_id);
            
    //         if (!is_dir(public_path('storage/user_attachments'))) {
    //             @mkdir(public_path('storage/user_attachments'));
    //         }
            
    //         if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
    //             @mkdir(public_path('storage/user_attachments/'.$form->id));
    //         }
    //         $path = public_path('storage/user_attachments/'.$form->id);
    //         $old_front = $request->old_front;

    //         if ($request->hasFile('front')) {
    //             $front_ext = $request->file('front')->getClientOriginalExtension();
    //             $front_img = Image::make($request->file('front'));
    //             $prev_bill = get_random_string().'_'.getdate()[0].'.'.$front_ext;
    //             $front_img->resize(1600, 1600, function($constraint) {
    //                 $constraint->aspectRatio();
    //             });
    //             $front_img->save($path.'/'.$prev_bill);

    //             /* delete old file */
    //             if (file_exists($path.'/'.$old_front)) {
    //                 File::delete($path.'/'.$old_front);
    //             }
    //         } else {
    //             $prev_bill = $old_front;
    //         }

    //         $form_files = $form->application_files; /* retreive data from table to check */
    //         if ($form_files->count() > 0) {
    //             $new = $form->application_files()->first();
    //             $new->prev_bill = $prev_bill;
    //             $form->application_files()->save($new);
    //         } else {
    //             $new = new ApplicationFile();
    //             $new->application_form_id = $form->id;
    //             $new->prev_bill = $prev_bill;
    //             $new->save();
    //         }
    //         return redirect()->route('resident_applied_form', $form->id);
    //     } else {
    //         return redirect()->route('home');
    //     }
    // }

    public function residential_show($form_id) {
        $active = 'overall';
        $heading = 'applied_detail';
        $form = ApplicationForm::find($form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');
        $fee_names = InitialCost::where([['type', 1], ['sub_type', $form->apply_sub_type]])->get();
        return view('user.other.residential.show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'form', 'files'));
    }

    public function residential_send_form(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $tmp_arr = [];
            $form_id = $request->form_id;
            $form = ApplicationForm::find($form_id);
            $new = FormProcessAction::where('application_form_id', $form_id)->first();
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
            if ($form->apply_division == 1) {
                if ($form->apply_type == 1) {
                    return redirect()->route('resident_applied_form_ygn', $form_id);
                } elseif ($form->apply_type == 2) {
                    return redirect()->route('resident_power_applied_form_ygn', $form_id);
                } elseif ($form->apply_type == 3) {
                    return redirect()->route('commercial_applied_form_ygn', $form_id);
                } elseif ($form->apply_type == 4) {
                    return redirect()->route('tsf_applied_form_ygn', $form_id);
                } elseif ($form->apply_type == 5) {
                    return redirect()->route('contractor_applied_form_ygn', $form_id);
                }
            }elseif ($form->apply_division == 2) {
                if ($form->apply_type == 1) {
                    return redirect()->route('resident_applied_form', $form_id);
                } elseif ($form->apply_type == 2) {
                    return redirect()->route('resident_power_applied_form', $form_id);
                } elseif ($form->apply_type == 3) {
                    return redirect()->route('commercial_applied_form', $form_id);
                } elseif ($form->apply_type == 4) {
                    return redirect()->route('tsf_applied_form_ygn', $form_id);                    
                } elseif ($form->apply_type == 5) {
                    return redirect()->route('contractor_applied_form', $form_id);
                }
            }elseif ($form->apply_division == 3) {
                if ($form->apply_type == 1) {
                    return redirect()->route('resident_applied_form_mdy', $form_id);
                } elseif ($form->apply_type == 2) {
                    return redirect()->route('resident_power_applied_form_mdy', $form_id);
                } elseif ($form->apply_type == 3) {
                    return redirect()->route('commercial_applied_form_mdy', $form_id);
                } elseif ($form->apply_type == 4) {
                    return redirect()->route('tsf_applied_form_mdy', $form_id);
                } elseif ($form->apply_type == 5) {
                    return redirect()->route('contractor_applied_form_mdy', $form_id);
                }
            }
            $adminAction = new AdminAction();
            $adminAction->application_form_id = $form_id;
            $adminAction->save();
        } else {
            return redirect()->route('home');
        }
    }
    /* Residentialial Meter End */
    /* ------------------------------------------------------------------------ */

    /* ------------------------------------------------------------------------ */
    /* Residential Power Meter */
    public function residential_power_rule_regulation() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'rule_regulation';
            return view('user.other.residentialPower.rules_and_regulations', compact('active', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }

    public function residential_power_agreement() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'agreement';
            return view('user.other.residentialPower.agreement', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }

    public function residential_power_select_meter_type() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('type', 2)->get();
            return view('user.other.residentialPower.residential_form_1', compact('active', 'fee_names', 'tbl_col_name'));
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_store_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $new = new ApplicationForm();
            $new->user_id = Auth::user()->id;
            $new->apply_type = 2;
            $new->apply_sub_type = $request->type;
            $new->apply_division = 2;
            $new->date = date('Y-m_d');
            $new->save();
            return redirect()->route('resident_power_user_info', $new->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_edit_meter_type($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('type', 2)->get();
            $form = ApplicationForm::find($form_id);
            return view('user.other.residentialPower.residential_form_1_edit', compact('active', 'fee_names', 'tbl_col_name', 'form'));
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_update_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;
            $new = ApplicationForm::find($form_id);
            $new->apply_type = 2;
            $new->apply_sub_type = $request->type;
            $new->save();
            return redirect()->route('resident_power_applied_form', $form_id);
        } else {
            return redirect()->route('home');
        }
    }

    public function residential_power_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', '!=', 2)->where('division_state_id', '!=', 3)->get();
            $draft_data = FormDraft::where('application_form_id', $form_id)->first();
            // dd($townships);
            return view('user.other.residentialPower.residential_form_2', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'draft_data'));
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_store_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'fullname' => 'required',
                'nrc' => 'required',
                'applied_phone' => 'required',
                'jobType' => 'required',
                'applied_building_type' => 'required',
                'applied_home_no' => 'required',
                'applied_street' => 'required',
                'applied_quarter' => 'required',
                'township_id' => 'required',
            ]);

            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;
            $serial_code = get_serial($div_state_id);

            if ($request->save_type == 'save') {
                $new = ApplicationForm::find($form_id);
                $new->serial_code = $serial_code;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->save();
                return redirect()->route('resident_power_nrc_create', $form_id);
            } if ($request->save_type == 'draft') {
                $alrdy_draft = FormDraft::where('application_form_id', $form_id)->first();
                if ($alrdy_draft) {
                    $new = $alrdy_draft;
                } else {
                    $new = new FormDraft();
                }
                $new->application_form_id = $form_id;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->date = date('Y-m-d');
                $new->save();
                return redirect()->route('all_meter_forms');
            }
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_edit_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', '!=', 2)->where('division_state_id', '!=', 3)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if ($d_form) {
                    $form = $d_form;
                    $form->id = $form_id;
                }
            }
            return view('user.other.residentialPower.residential_form_2_edit', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'form'));
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_update_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'fullname' => 'required',
                'nrc' => 'required',
                'applied_phone' => 'required',
                'jobType' => 'required',
                'applied_building_type' => 'required',
                'applied_home_no' => 'required',
                'applied_street' => 'required',
                'applied_quarter' => 'required',
                'township_id' => 'required',
            ]);

            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $new = ApplicationForm::find($form_id);
            if (!$new->serial_code || ($new->div_state_id == null) || ( $new->div_state_id != $div_state_id )) {
                $new->serial_code = get_serial($div_state_id);
            }
            $new->fullname = $fullname;
            $new->nrc = $nrc;
            $new->applied_phone = $applied_phone;
            $new->job_type = $request->jobType;
            $new->position = $position;
            $new->department = $department;
            $new->salary = $salary ? $salary : 0;
            $new->applied_building_type = $applied_building_type;
            $new->applied_home_no = $applied_home_no;
            $new->applied_building = $applied_building;
            $new->applied_lane = $applied_lane;
            $new->applied_street = $applied_street;
            $new->applied_quarter = $applied_quarter;
            $new->applied_town = $applied_town;
            $new->township_id = $township_id;
            $new->district_id = $district_id;
            $new->div_state_id = $div_state_id;
            $new->save();
            return redirect()->route('resident_power_applied_form', $form_id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function residential_power_nrc_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            return view('user.other.residentialPower.residential_form_3', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_nrc_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                'back' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

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
            
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->nrc_copy_front = $front_nrc;
            $new->nrc_copy_back = $back_nrc;
            $form->application_files()->save($new);
            return redirect()->route('resident_power_form10_create', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_nrc_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.residentialPower.residential_form_3_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_nrc_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $new->save();
            }
            return redirect()->route('resident_power_applied_form', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function residential_power_form10_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            return view('user.other.residentialPower.residential_form_4', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_form10_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_form_10);
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
            } else {
                $back_form_10 = null;
            }
            
            $new = $form->application_files()->first();
            $new->form_10_front = $front_form_10;
            $new->form_10_back = $back_form_10;
            $form->application_files()->save($new);
            return redirect()->route('resident_power_recomm_create', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_form10_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.residentialPower.residential_form_4_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_form10_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_form_10);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_form_10 = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
                
                /* delete old file */
                if ($old_back && file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_form_10 = $old_back;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $new->save();
            }
            return redirect()->route('resident_power_applied_form', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function residential_power_recomm_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            return view('user.other.residentialPower.residential_form_5', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_recomm_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required|mimes:jpeg,jpg,png,pdf',
                'back' => 'required|mimes:jpeg,jpg,png,pdf',
            ]);
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
            
            $new = $form->application_files()->first();
            $new->occupy_letter = $occupy;
            $new->no_invade_letter = $no_invade;
            $form->application_files()->save($new);
            return redirect()->route('resident_power_owner_create', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_recomm_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.residentialPower.residential_form_5_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_recomm_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $new->save();
            }
            return redirect()->route('resident_power_applied_form', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function residential_power_owner_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            return view('user.other.residentialPower.residential_form_6', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_owner_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->ownership = $img_str;
            $form->application_files()->save($new);
            // return redirect()->route('resident_power_electricpower_create', $form->id);
            return redirect()->route('resident_power_applied_form', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_owner_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.residentialPower.residential_form_6_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_owner_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->ownership = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->ownership = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('resident_power_applied_form', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function residential_power_electricpower_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_electricpower_photo';
            return view('user.other.residentialPower.residential_form_7', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_electricpower_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->electric_power = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('resident_power_applied_form', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_electricpower_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_electricpower_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.residentialPower.residential_form_7_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function residential_power_electricpower_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->electric_power = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->electric_power = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('resident_power_applied_form', $form->id);
        }else{
            return redirect()->route('home');
        }
    }

    public function residential_power_show($form_id) {
        $active = 'overall';
        $heading = 'applied_detail';
        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');
        $fee_names = InitialCost::where([['type', 2], ['sub_type', $form->apply_sub_type]])->get();
        return view('user.other.residentialPower.show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'form', 'files'));
    }

    public function residential_power_send_form(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $tmp_arr = [];
            $form_id = $request->form_id;
            $new = FormProcessAction::where('application_form_id', $form_id)->first();
            if ($new) {
                array_push($tmp_arr, $new->user_send_form_date);
                array_push($tmp_arr, getdate()[0]);
                $str_date = implode(',', $tmp_arr);
                $new->user_send_to_office = 1;
                $new->user_send_form_date = $str_date;
                $new->form_reject = 0;
            } else {
                $str_date = getdate()[0];
                $new = new FormProcessAction();
                $new->application_form_id = $form_id;
                $new->user_send_to_office = 1;
                $new->user_send_form_date = $str_date;
            }
            $new->save();

            $adminAction = new AdminAction();
            $adminAction->application_form_id=$form_id;
            $adminAction->save();
            
            return redirect()->route('resident_power_applied_form', $form_id);
        }else{
            return redirect()->route('home');
        }
    }
    /* Residentialial Power Meter End */
    /* ------------------------------------------------------------------------ */

    /* ------------------------------------------------------------------------ */
    /* Commercial Power Meter */
    public function commercial_rule_regulation() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'rule_regulation';
            return view('user.other.commercialPower.rules_and_regulations', compact('active', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }

    public function commercial_agreement() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'agreement';
            return view('user.other.commercialPower.agreement', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }

    public function commercial_select_meter_type() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('type', 3)->get();
            return view('user.other.commercialPower.commercial_form_1', compact('active', 'fee_names', 'tbl_col_name'));
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_store_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $new = new ApplicationForm();
            $new->user_id = Auth::user()->id;
            $new->apply_division = 2;
            $new->apply_type = 3;
            $new->apply_sub_type = $request->type;
            $new->date = date('Y-m-d');
            $new->save();
            return redirect()->route('commercial_user_info', $new->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_edit_meter_type($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('type', 3)->get();
            $form = ApplicationForm::find($form_id);
            return view('user.other.commercialPower.commercial_form_1_edit', compact('active', 'fee_names', 'tbl_col_name', 'form'));
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_update_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;
            $new = ApplicationForm::find($form_id);
            if ($new->apply_sub_type !== $request->sub_type) {
                $new->apply_sub_type = $request->sub_type;
                $new->save();
            }
            return redirect()->route('commercial_applied_form', $form_id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function commercial_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', '!=', 2)->get();
            $draft_data = FormDraft::where('application_form_id', $form_id)->first();
            // dd($townships);
            return view('user.other.commercialPower.commercial_form_2', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'draft_data'));
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_store_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'fullname' => 'required',
                'nrc' => 'required',
                'applied_phone' => 'required',
                'jobType' => 'required',
                'applied_building_type' => 'required',
                'applied_home_no' => 'required',
                'applied_street' => 'required',
                'applied_quarter' => 'required',
                'township_id' => 'required',
            ]);

            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;
            $serial_code = get_serial($div_state_id);

            if ($request->save_type == 'save') {
                $new = ApplicationForm::find($form_id);
                $new->serial_code = $serial_code;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->save();
                return redirect()->route('commercial_nrc_create', $form_id);
            } elseif ($request->save_type == 'draft') {
                $alrdy_draft = FormDraft::where('application_form_id', $form_id)->first();
                if ($alrdy_draft) {
                    $new = $alrdy_draft;
                } else {
                    $new = new FormDraft();
                }
                $new->application_form_id = $form_id;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->date = date('Y-m-d');
                $new->save();
                return redirect()->route('all_meter_forms');
            }
        } else {
            return redirect()->route('home');
        }
    }
    public function commercial_edit_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', '!=', 2)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if ($d_form) {
                    $form = $d_form;
                    $form->id = $form_id;
                }
            }
            return view('user.other.commercialPower.commercial_form_2_edit', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'form'));
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_update_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'fullname' => 'required',
                'nrc' => 'required',
                'applied_phone' => 'required',
                'applied_building_type' => 'required',
                'applied_home_no' => 'required',
                'applied_street' => 'required',
                'applied_quarter' => 'required',
                'township_id' => 'required',
            ]);

            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $new = ApplicationForm::find($form_id);
            if (!$new->serial_code || ($new->div_state_id == null) || ( $new->div_state_id != $div_state_id )) {
                $new->serial_code = get_serial($div_state_id);
            }
            $new->fullname = $fullname;
            $new->nrc = $nrc;
            $new->applied_phone = $applied_phone;
            $new->job_type = $request->jobType;
            $new->position = $position;
            $new->department = $department;
            $new->salary = $salary ? $salary : 0;
            $new->applied_building_type = $applied_building_type;
            $new->applied_home_no = $applied_home_no;
            $new->applied_building = $applied_building;
            $new->applied_lane = $applied_lane;
            $new->applied_street = $applied_street;
            $new->applied_quarter = $applied_quarter;
            $new->applied_town = $applied_town;
            $new->township_id = $township_id;
            $new->district_id = $district_id;
            $new->div_state_id = $div_state_id;
            $new->save();
            return redirect()->route('commercial_applied_form', $form_id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function commercial_nrc_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            return view('user.other.commercialPower.commercial_form_3', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_nrc_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                'back' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);

            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

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
            
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->nrc_copy_front = $front_nrc;
            $new->nrc_copy_back = $back_nrc;
            $form->application_files()->save($new);
            return redirect()->route('commercial_form10_create', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_nrc_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.commercialPower.commercial_form_3_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_nrc_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $new->save();
            }
            return redirect()->route('commercial_applied_form', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function commercial_form10_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            return view('user.other.commercialPower.commercial_form_4', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_form10_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_form_10);
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
            } else {
                $back_form_10 = null;
            }
            
            $new = $form->application_files()->first();
            $new->form_10_front = $front_form_10;
            $new->form_10_back = $back_form_10;
            $form->application_files()->save($new);
            return redirect()->route('commercial_recomm_create', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_form10_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.commercialPower.commercial_form_4_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_form10_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_form_10);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_form_10 = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
                
                /* delete old file */
                if ($old_back && file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_form_10 = $old_back;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $new->save();
            }
            return redirect()->route('commercial_applied_form', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function commercial_recomm_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            return view('user.other.commercialPower.commercial_form_5', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_recomm_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required|mimes:jpeg,jpg,png,pdf',
                'back' => 'required|mimes:jpeg,jpg,png,pdf',
            ]);
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
            
            $new = $form->application_files()->first();
            $new->occupy_letter = $occupy;
            $new->no_invade_letter = $no_invade;
            $form->application_files()->save($new);
            return redirect()->route('commercial_owner_create', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_recomm_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.commercialPower.commercial_form_5_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_recomm_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $new->save();
            }
            return redirect()->route('commercial_applied_form', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function commercial_owner_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            return view('user.other.commercialPower.commercial_form_6', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_owner_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->ownership = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('commercial_worklicence_create', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_owner_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.commercialPower.commercial_form_6_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_owner_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->ownership = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->ownership = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('commercial_applied_form', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function commercial_worklicence_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_transactionlicence_photo';
            return view('user.other.commercialPower.commercial_form_7', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_worklicence_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->transaction_licence = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('commercial_applied_form', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_worklicence_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_transactionlicence_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.commercialPower.commercial_form_7_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_worklicence_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->transaction_licence = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->transaction_licence = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('commercial_applied_form', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function commercial_electricpower_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_electricpower_photo';
            return view('user.other.commercialPower.commercial_form_8', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_electricpower_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->electric_power = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('commercial_applied_form', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_electricpower_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_electricpower_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.commercialPower.commercial_form_8_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function commercial_electricpower_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->electric_power = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->electric_power = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('commercial_applied_form', $form->id);
        }else{
            return redirect()->route('home');
        }
    }

    public function commercial_show($form_id) {
        $active = 'overall';
        $heading = 'applied_detail';
        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');
        $fee_names = InitialCost::where([['type', 3], ['sub_type', $form->apply_sub_type]])->get();
        return view('user.other.commercialPower.show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'form', 'files'));
    }

    public function commercial_send_form(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $tmp_arr = [];
            $form_id = $request->form_id;
            $new = FormProcessAction::where('application_form_id', $form_id)->first();
            if ($new) {
                array_push($tmp_arr, $new->user_send_form_date);
                array_push($tmp_arr, getdate()[0]);
                $str_date = implode(',', $tmp_arr);
                $new->user_send_to_office = 1;
                $new->user_send_form_date = $str_date;
                $new->form_reject = 0;
            } else {
                $str_date = getdate()[0];
                $new = new FormProcessAction();
                $new->application_form_id = $form_id;
                $new->user_send_to_office = 1;
                $new->user_send_form_date = $str_date;
            }
            $new->save();
            return redirect()->route('commercial_applied_form', $form_id);
        }else{
            return redirect()->route('home');
        }
    }
    /* Commercial Power Meter End */
    /* ------------------------------------------------------------------------ */

    /* Contractor Meter */
    public function contractor_rule_regulation() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'rule_regulation';
            return view('user.other.contractor.rules_and_regulations', compact('active', 'heading'));
            // return 'ok';
        } else {
            return redirect()->route('home');
        }
    }

    public function contractor_agreement() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'agreement';
            return view('user.other.contractor.agreement', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }

    public function contractor_building_room() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            return view('user.other.contractor.two_buildings', compact('active'));
        } else {
            return redirect()->route('home');
        }
    }
    public function contractor_building(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [ 
                'room_count' => 'required|numeric|min:4'
            ]);
            $room_count = $request->room_count;
            $pMeter10 = $request->pMeter10;
            $pMeter20 = $request->pMeter20;
            $pMeter30 = $request->pMeter30;
            $meter = $request->meter;
            $water_meter = $request->water_meter;
            if ($water_meter == 'on') {
                $water_meter = true;
            } else {
                $water_meter = false;
            }
            $elevator_meter = $request->elevator_meter;
            if ($elevator_meter == 'on') {
                $elevator_meter = true;
            } else {
                $elevator_meter = false;
            }
            
            $new = new ApplicationForm();
            $new->user_id = Auth::user()->id;
            $new->apply_type = 5;
            $new->apply_sub_type = 1;
            $new->apply_division = 2;
            $new->date = date('Y-m-d');
            $new->save();

            $c_form = new ApplicationFormContractor();
            $c_form->application_form_id = $new->id;
            $c_form->room_count = $room_count;
            $c_form->pMeter10 = $pMeter10;
            $c_form->pMeter20 = $pMeter20;
            $c_form->pMeter30 = $pMeter30;
            $c_form->meter = $meter;
            $c_form->water_meter = $water_meter;
            $c_form->elevator_meter = $elevator_meter;
            $c_form->save();
            
            // if ($sub_type == 1) {
                return redirect()->route('417_user_info', $new->id);
            // } else {
                // return redirect()->route('18_user_info_ygn', $new->id);
            // }
        } else {
            return redirect()->route('home');
        }
    }
    public function contractor_building_room_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $c_form = ApplicationFormContractor::where('application_form_id', $form_id)->first();
            return view('user.other.contractor.two_buildings_edit', compact('active','c_form'));
        } else {
            return redirect()->route('home');
        }
    }
    public function contractor_building_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [ 
                'room_count' => 'required|numeric|min:4'
            ]);
            $form_id = $request->form_id;
            $room_count = $request->room_count;
            $pMeter10 = $request->pMeter10;
            $pMeter20 = $request->pMeter20;
            $pMeter30 = $request->pMeter30;
            $meter = $request->meter;
            $water_meter = $request->water_meter;
            if ($water_meter == 'on') {
                $water_meter = true;
            } else {
                $water_meter = false;
            }
            $elevator_meter = $request->elevator_meter;
            if ($elevator_meter == 'on') {
                $elevator_meter = true;
            } else {
                $elevator_meter = false;
            }

            $c_form = ApplicationFormContractor::where('application_form_id', $form_id)->first();
            $c_form->room_count = $room_count;
            $c_form->pMeter10 = $pMeter10;
            $c_form->pMeter20 = $pMeter20;
            $c_form->pMeter30 = $pMeter30;
            $c_form->meter = $meter;
            $c_form->water_meter = $water_meter;
            $c_form->elevator_meter = $elevator_meter;
            $c_form->save();
            
            // if ($sub_type == 1) {
                return redirect()->route('contractor_applied_form', $form_id);
            // } else {
                // return redirect()->route('18_user_info_ygn', $new->id);
            // }
        } else {
            return redirect()->route('home');
        }
    }
    /* 4 to 17 rooms */
    public function room_417_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', '!=', 2)->where('division_state_id','!=',3)->get();
            $draft_data = FormDraft::where('application_form_id', $form_id)->first();
            return view('user.other.contractor.4_17_form_1', compact('active', 'heading', 'form_id', 'regions', 'districts', 'townships', 'draft_data'));
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_store_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            if ($request->save_type == 'save') {
                // $this->validate($request, [
                //     'fullname' => 'required',
                //     'nrc' => 'required',
                //     'applied_phone' => ['required', 'min:9', 'max:11'],
                //     'applied_building_type' => 'required',
                //     'applied_home_no' => 'required',
                //     'applied_street' => 'required',
                //     'applied_quarter' => 'required',
                //     'township_id' => 'required',
                //     'district' => 'required',
                //     'region' => 'required',
                // ]);
            }
            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $serial_code = get_serial($div_state_id);

            if ($request->save_type == 'save') {
                $new = ApplicationForm::find($form_id);
                $new->serial_code = $serial_code;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->save();
                return redirect()->route('417_nrc_create', $form_id);
            } elseif ($request->save_type == 'draft') {
                $alrdy_draft = FormDraft::where('application_form_id', $form_id)->first();
                if ($alrdy_draft) {
                    $new = $alrdy_draft;
                } else {
                    $new = new FormDraft();
                }
                $new->application_form_id = $form_id;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->date = date('Y-m-d');
                $new->save();
                return redirect()->route('all_meter_forms');
            }
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_edit_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::where('id', 2)->get();
            $districts = District::where('division_state_id', '!=', 2)->where('division_state_id','!=',3)->get();
            $townships = Township::where('division_state_id', '!=', 2)->where('division_state_id','!=',3)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if ($d_form) {
                    $form = $d_form;
                    $form->id = $form_id;
                }
            }
            return view('user.other.contractor.4_17_form_1_edit', compact('active', 'heading', 'form_id', 'regions', 'districts', 'townships', 'form'));
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_update_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'fullname' => 'required',
                'nrc' => 'required',
                'applied_phone' => ['required', 'min:9', 'max:11'],
                'applied_home_no' => 'required',
                'applied_street' => 'required',
                'applied_quarter' => 'required',
                'township_id' => 'required',
                'district' => 'required',
                'region' => 'required',
            ]);
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

            $new = ApplicationForm::find($form_id);
            if (!$new->serial_code || ($new->div_state_id == null) || ( $new->div_state_id != $div_state_id )) {
                $new->serial_code = get_serial($div_state_id);
            }
            $new->fullname = $fullname;
            $new->nrc = $nrc;
            $new->applied_phone = $applied_phone;
            $new->applied_home_no = $applied_home_no;
            $new->applied_lane = $applied_lane;
            $new->applied_street = $applied_street;
            $new->applied_quarter = $applied_quarter;
            $new->applied_town = $applied_town;
            $new->township_id = $township_id;
            $new->district_id = $district_id;
            $new->div_state_id = $div_state_id;
            $new->date = date('Y-m-d');
            $new->save();
            return redirect()->route('contractor_applied_form', $form_id);
        } else {
            return redirect()->route('home');
        }
    }

    public function room_417_nrc_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            return view('user.other.contractor.4_17_form_2', compact('active', 'heading', 'form_id'));
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_nrc_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                'back' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);

            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

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
            
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->nrc_copy_front = $front_nrc;
            $new->nrc_copy_back = $back_nrc;
            $form->application_files()->save($new);
            return redirect()->route('417_form10_create', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_nrc_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.contractor.4_17_form_2_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_nrc_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $new->save();
            }
            return redirect()->route('contractor_applied_form', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function room_417_form10_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            return view('user.other.contractor.4_17_form_3', compact('active', 'heading', 'form_id'));
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_form10_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_form_10);
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
            } else {
                $back_form_10 = null;
            }
            
            $new = $form->application_files()->first();
            $new->form_10_front = $front_form_10;
            $new->form_10_back = $back_form_10;
            $form->application_files()->save($new);
            return redirect()->route('417_recomm_create', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_form10_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.contractor.4_17_form_3_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_form10_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_form_10);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_form_10 = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
                
                /* delete old file */
                if ($old_back && file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_form_10 = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $new->save();
            }
            return redirect()->route('contractor_applied_form', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function room_417_recomm_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            return view('user.other.contractor.4_17_form_4', compact('active', 'heading', 'form_id'));
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_recomm_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            
            $new = $form->application_files()->first();
            $new->occupy_letter = $occupy;
            $new->no_invade_letter = $no_invade;
            $form->application_files()->save($new);
            $form->application_files()->save($new);
            return redirect()->route('417_owner_create', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_recomm_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.contractor.4_17_form_4_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_recomm_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $occupy_img = Image::make($request->file('front'));
                $occupy = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $occupy_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $occupy_img->save($path.'/'.$occupy);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $occupy = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $no_invade_img = Image::make($request->file('back'));
                $no_invade = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $no_invade_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $no_invade_img->save($path.'/'.$no_invade);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $no_invade = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();

                $form->application_files()->save($new);
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->occupy_letter = $occupy;
                $new->no_invade_letter = $no_invade;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->occupy_letter = $occupy;
                $new->no_invade_letter = $no_invade;
                $new->save();
            }
            return redirect()->route('contractor_applied_form', $form->id);
        } else {
            return redirect()->route('home');
        }
    }


    public function room_417_owner_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            return view('user.other.contractor.4_17_form_5', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_owner_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->ownership = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('417_permit_create', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_owner_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.contractor.4_17_form_5_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_owner_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->ownership = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->ownership = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('contractor_applied_form', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function room_417_permit_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_permit_photo';
            return view('user.other.contractor.4_17_form_6', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_permit_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_permit = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_permit);
            
            $new = $form->application_files()->first();
            $new->building_permit = $front_permit;
            $form->application_files()->save($new);
            return redirect()->route('417_bcc_create', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_permit_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_permit_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.contractor.4_17_form_6_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_permit_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $permit = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$permit);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $permit = $old_front;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->building_permit = $permit;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->building_permit = $permit;
                $new->save();
            }
            return redirect()->route('contractor_applied_form', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function room_417_bcc_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_bcc_photo';
            return view('user.other.contractor.4_17_form_7', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_bcc_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_bcc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_bcc);
            
            $new = $form->application_files()->first();
            $new->bcc = $front_bcc;
            $form->application_files()->save($new);
            return redirect()->route('417_dc_recomm_create', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_bcc_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_bcc_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.contractor.4_17_form_7_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_bcc_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $bcc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$bcc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $bcc = $old_front;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->bcc = $bcc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->bcc = $bcc;
                $new->save();
            }
            return redirect()->route('contractor_applied_form', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function room_417_dc_recomm_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_dc_recomm_photo';
            return view('user.other.contractor.4_17_form_8', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_dc_recomm_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_dc_recomm = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_dc_recomm);
            
            $new = $form->application_files()->first();
            $new->dc_recomm = $front_dc_recomm;
            $form->application_files()->save($new);
            return redirect()->route('417_bill_create', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_dc_recomm_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_dc_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.contractor.4_17_form_8_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_dc_recomm_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $dc_recomm = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$dc_recomm);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $dc_recomm = $old_front;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->dc_recomm = $dc_recomm;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->dc_recomm = $dc_recomm;
                $new->save();
            }
            return redirect()->route('contractor_applied_form', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function room_417_bill_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_bill_photo';
            return view('user.other.contractor.4_17_form_9', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_bill_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_bill = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_bill);
            
            $new = $form->application_files()->first();
            $new->prev_bill = $front_bill;
            $form->application_files()->save($new);
            return redirect()->route('contractor_applied_form', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_bill_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_bill_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.contractor.4_17_form_9_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function room_417_bill_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $prev_bill = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$prev_bill);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $prev_bill = $old_front;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->prev_bill = $prev_bill;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->prev_bill = $prev_bill;
                $new->save();
            }
            return redirect()->route('contractor_applied_form', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function contractor_show($form_id) {
        $active = 'overall';
        $heading = 'applied_detail';
        $form = ApplicationForm::orderBy('date', 'desc')->find($form_id);
        $c_form = ApplicationFormContractor::where('application_form_id', $form_id)->first();
        $files = $form->application_files;
        return view('user.other.contractor.show', compact('active', 'heading', 'form', 'files', 'c_form'));
    }
    /* Contractor Meter End */
    /* ------------------------------------------------------------------------ */

    /* ------------------------------------------------------------------------ */
    /* Transformer Start */
    public function transformer_rule_regulation() {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'rule_regulation';
            return view('user.other.transformer.rules_and_regulations', compact('active', 'heading'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_agreement() {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'agreement';
            return view('user.other.transformer.agreement', compact('active', 'heading'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_agreement_one() {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'agreement';
            return view('user.other.transformer.agreement_one', compact('active', 'heading'));
        // } else {
        //     return redirect()->route('home');
        // }
    }

    public function transformer_select_meter_type() {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::whereNotIn('name',['630','800','1500'])->where('type', 4)->get();
            return view('user.other.transformer.tsf_form_1', compact('active', 'fee_names', 'tbl_col_name'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_store_meter_type(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $new = new ApplicationForm();
            $new->user_id = Auth::user()->id;
            $new->apply_type = 4;
            $new->apply_sub_type = $request->sub_type;
            $new->apply_division = 2;
            $new->date = date('Y-m-d');
            $new->save();
            return redirect()->route('tsf_user_info', $new->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_edit_meter_type($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::whereNotIn('name',['630','800','1500'])->where('type', 4)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if($d_form){
                    $form = $d_form;
                    $form->id = $form_id;
                }
            }
            return view('user.other.transformer.tsf_form_1_edit', compact('active', 'fee_names', 'tbl_col_name', 'form'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_update_meter_type(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;
            $new = ApplicationForm::find($form_id);
            if ($new->apply_sub_type !== $request->sub_type) {
                $new->apply_sub_type = $request->sub_type;
                $new->save();
            }
            return redirect()->route('tsf_applied_form', $form_id);
        // } else {
        //     return redirect()->route('home');
        // }
    }

    public function transformer_user_information($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', '!=', 2)->where('division_state_id', '!=', 3)->get();
            $draft_data = FormDraft::where('application_form_id', $form_id)->first();
            // dd($draft_data);
            return view('user.other.transformer.tsf_form_2', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'draft_data'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_store_user_information(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            if ($request->save_type == 'save') {
                // $this->validate($request, [
                //     'fullname' => 'required',
                //     'nrc' => 'required',
                //     'applied_phone' => ['required', 'min:9', 'max:11'],
                //     'jobType' => 'required',
                //     'applied_building_type' => 'required',
                //     'applied_home_no' => 'required',
                //     'applied_street' => 'required',
                //     'applied_quarter' => 'required',
                //     'township_id' => 'required',
                //     'district' => 'required',
                //     'region' => 'required',
                // ]);
            }
            $form_id = $request->form_id;
            $religion = $request->religion;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_phone = $request->applied_phone;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $serial_code = get_serial($div_state_id);

            if ($request->save_type == 'save') {
                $new = ApplicationForm::find($form_id);

                $new->serial_code = $serial_code;
                $new->is_religion = $religion ? 1 : 0;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->save();
                return redirect()->route('tsf_nrc_create', $form_id);
            } elseif ($request->save_type == 'draft') {
                $alrdy_draft = FormDraft::where('application_form_id', $form_id)->first();
                if ($alrdy_draft) {
                    $new = $alrdy_draft;
                } else {
                    $new = new FormDraft();
                }
                $new->application_form_id = $form_id;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->date = date('Y-m-d');
                $new->save();
                return redirect()->route('all_meter_forms');
            }
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_edit_user_information($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', '!=', 2)->where('division_state_id', '!=', 3)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if ($d_form) {
                    $form = $d_form;
                    $form->id = $form_id;
                }
            }
            return view('user.other.transformer.tsf_form_2_edit', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'form'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_update_user_information(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'fullname' => 'required',
                'nrc' => 'required',
                'applied_phone' => 'required',
                // 'jobType' => 'required',
                'applied_building_type' => 'required',
                // 'applied_home_no' => 'required',
                'applied_street' => 'required',
                'applied_quarter' => 'required',
                'township_id' => 'required',
            ]);

            $form_id = $request->form_id;
            $religion = $request->religion;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $new = ApplicationForm::find($form_id);
            if (!$new->serial_code || ($new->div_state_id == null) || ( $new->div_state_id != $div_state_id )) {
                $new->serial_code = get_serial($div_state_id);
            }
            $new->fullname = $fullname;
            $new->is_religion = $religion ? 1 : 0;
            $new->nrc = $nrc;
            $new->applied_phone = $applied_phone;
            $new->job_type = $job_type;
            $new->position = $position;
            $new->department = $department;
            $new->salary = $salary ? $salary : 0;
            $new->applied_building_type = $applied_building_type;
            $new->applied_home_no = $applied_home_no;
            $new->applied_building = $applied_building;
            $new->applied_street = $applied_street;
            $new->applied_quarter = $applied_quarter;
            $new->applied_town = $applied_town;
            $new->township_id = $township_id;
            $new->district_id = $district_id;
            $new->div_state_id = $div_state_id;
            $new->save();
            return redirect()->route('tsf_applied_form', $form_id);
        // } else {
        //     return redirect()->route('home');
        // }
    }

    public function transformer_nrc_create($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            return view('user.other.transformer.tsf_form_3', compact('active', 'form_id', 'heading'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_nrc_store(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png'],
                'back' => ['image', 'mimes:jpeg,jpg,png'],
            ]);
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
            
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->nrc_copy_front = $front_nrc;
            $new->nrc_copy_back = $back_nrc;
            $form->application_files()->save($new);
            return redirect()->route('tsf_form10_create', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_nrc_edit($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.transformer.tsf_form_3_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_nrc_update(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600);
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600);
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $new->save();
            }
            return redirect()->route('tsf_applied_form', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }

    public function transformer_form10_create($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            return view('user.other.transformer.tsf_form_4', compact('active', 'form_id', 'heading'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_form10_store(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_form_10);
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
            } else {
                $back_form_10 = null;
            }
            
            $new = $form->application_files()->first();
            $new->form_10_front = $front_form_10;
            $new->form_10_back = $back_form_10;
            $form->application_files()->save($new);
            return redirect()->route('tsf_recomm_create', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_form10_edit($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.transformer.tsf_form_4_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_form10_update(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_form_10);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_form_10 = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
                
                /* delete old file */
                if ($old_back && file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_form_10 = $old_back;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $new->save();
            }
            return redirect()->route('tsf_applied_form', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }

    public function transformer_recomm_create($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            return view('user.other.transformer.tsf_form_5', compact('active', 'form_id', 'heading'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_recomm_store(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required|mimes:jpeg,jpg,png',
                'back' => 'required|mimes:jpeg,jpg,png',
            ]);
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
            
            $new = $form->application_files()->first();
            $new->occupy_letter = $occupy;
            $new->no_invade_letter = $no_invade;
            $form->application_files()->save($new);
            return redirect()->route('tsf_owner_create', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_recomm_edit($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.transformer.tsf_form_5_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_recomm_update(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if ($old_front) {
                    if (file_exists($path.'/'.$old_front)) {
                        File::delete($path.'/'.$old_front);
                    }
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if ($old_back) {
                    if (file_exists($path.'/'.$old_back)) {
                        File::delete($path.'/'.$old_back);
                    }
                }
            } else {
                $back_nrc = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $new->save();
            }
            return redirect()->route('tsf_applied_form', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }

    public function transformer_owner_create($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            return view('user.other.transformer.tsf_form_6', compact('active', 'form_id', 'heading'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_owner_store(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->ownership = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('tsf_worklicence_create', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_owner_edit($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.transformer.tsf_form_6_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_owner_update(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $tmp_arr = [];
            $old_front = $request->old_front;

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

                    /* delete old file */
                    if (file_exists($path.'/'.$old_front)) {
                        File::delete($path.'/'.$old_front);
                    }
                }
                $img_str = implode(',', $tmp_arr);
                
                $form_files = $form->application_files; /* retreive data from table to check */
                if ($form_files->count() > 0) {
                    $new = $form->application_files()->first();
                    $new->ownership = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->ownership = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('tsf_applied_form', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }
    
    public function transformer_worklicence_create($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_transactionlicence_photo';
            return view('user.other.transformer.tsf_form_7', compact('active', 'form_id', 'heading'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_worklicence_store(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            // $this->validate($request, [
            //     'front' => 'required',
            // ]);
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

                $new = $form->application_files()->first();
                $new->transaction_licence = $img_str;
                $form->application_files()->save($new);
            }
            return redirect()->route('tsf_electricpower_create', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_worklicence_edit($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_transactionlicence_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.transformer.tsf_form_7_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_worklicence_update(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->transaction_licence = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->transaction_licence = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('tsf_applied_form', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }
    
    public function transformer_electricpower_create($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_dc_recomm_photo';
            return view('user.other.transformer.tsf_form_8', compact('active', 'form_id', 'heading'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_electricpower_store(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->dc_recomm = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('tsf_applied_form', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_electricpower_edit($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_dc_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.other.transformer.tsf_form_8_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function transformer_electricpower_update(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->dc_recomm = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->dc_recomm = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('tsf_applied_form', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }

    public function transformer_show($form_id) {
        $active = 'overall';
        $heading = 'applied_detail';
        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');
        $fee = InitialCost::whereNotIn('name',['630','800','1500'])->where([['type', 4], ['sub_type', $form->apply_sub_type]])->first();
        // dd($fee);
        return view('user.other.transformer.show', compact('active', 'heading', 'tbl_col_name', 'fee', 'form', 'files'));
    }
    
    /* For Other Division/State */
    /* =============================================================================================================== */

    /* =============================================================================================================== */
    /* For Yangon Division */
    /* ------------------------------------------------------------------------- */
    /* Yangon Residential Meter */
    public function reisdential_ygn_index() {
        $active = 'resident_app';
        return view('user.application_ygn', compact('active'));
    }

    public function ygn_residential_rule_regulation() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'rule_regulation';
            return view('user/yangon/residential/rules_and_regulations', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_residential_agreement() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'agreement';
            return view('user.yangon.residential.agreement', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }

    /* Yangon Residential Type Start */ 
    public function ygn_residential_select_meter_type() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('type', 1)->get();
            return view('user.yangon.residential.residential_form_1', compact('active', 'fee_names', 'tbl_col_name'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_store_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $new = new ApplicationForm();
            $new->user_id = Auth::user()->id;
            $new->apply_type = 1;
            $new->apply_sub_type = 3;
            $new->apply_division = 1;
            $new->date = date('Y-m-d');
            $new->save();
            return redirect()->route('resident_user_info_ygn', $new->id);
        } else {
            return redirect()->route('home');
        }
    }
    /* Type End */

    /* Yangon Residential User_Info Start */ 
    public function ygn_residential_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', 2)->get();
            $draft_data = FormDraft::where('application_form_id', $form_id)->first();
            // dd($draft_data);
            return view('user.yangon.residential.residential_form_2', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'draft_data'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_store_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            if ($request->save_type == 'save') {
                $this->validate($request, [
                    'fullname' => 'required',
                    'nrc' => 'required',
                    'applied_phone' => ['required', 'min:9', 'max:11'],
                    'jobType' => 'required',
                    'applied_building_type' => 'required',
                    'applied_home_no' => 'required',
                    'applied_street' => 'required',
                    'applied_quarter' => 'required',
                    'township_id' => 'required',
                    'district' => 'required',
                    'region' => 'required',
                ]);
            }
            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_phone = $request->applied_phone;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $serial_code = get_serial($div_state_id);

            if ($request->save_type == 'save') {
                $new = ApplicationForm::find($form_id);

                $new->serial_code = $serial_code;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->save();
                return redirect()->route('resident_nrc_create_ygn', $form_id);
            } elseif ($request->save_type == 'draft') {
                $alrdy_draft = FormDraft::where('application_form_id', $form_id)->first();
                if ($alrdy_draft) {
                    $new = $alrdy_draft;
                } else {
                    $new = new FormDraft();
                }
                $new->application_form_id = $form_id;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->date = date('Y-m-d');
                $new->save();
                return redirect()->route('all_meter_forms');
            }
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_edit_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', 2)->get();
            $app_form = ApplicationForm::find($form_id);
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if ($d_form) {
                    $form = $d_form;
                    $form->id = $form_id;
                }
            }
            return view('user.yangon.residential.residential_form_2_edit', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'form'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_update_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'fullname' => 'required',
                'nrc' => 'required',
                'applied_phone' => 'required',
                'jobType' => 'required',
                'applied_building_type' => 'required',
                'applied_home_no' => 'required',
                'applied_street' => 'required',
                'applied_quarter' => 'required',
                'township_id' => 'required',
            ]);

            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $new = ApplicationForm::find($form_id);
            if (!$new->serial_code || ($new->div_state_id == null) || ( $new->div_state_id != $div_state_id )) {
                $new->serial_code = get_serial($div_state_id);
            }
            $new->fullname = $fullname;
            $new->nrc = $nrc;
            $new->applied_phone = $applied_phone;
            $new->job_type = $job_type;
            $new->position = $position;
            $new->department = $department;
            $new->salary = $salary ? $salary : 0;
            $new->applied_building_type = $applied_building_type;
            $new->applied_home_no = $applied_home_no;
            $new->applied_building = $applied_building;
            $new->applied_street = $applied_street;
            $new->applied_quarter = $applied_quarter;
            $new->applied_town = $applied_town;
            $new->township_id = $township_id;
            $new->district_id = $district_id;
            $new->div_state_id = $div_state_id;
            $new->save();
            return redirect()->route('resident_applied_form_ygn', $form_id);
        } else {
            return redirect()->route('home');
        }
    }
    /* User_Info End */

    /* Yangon Residential Nrc Start */ 
    public function ygn_residential_nrc_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            return view('user.yangon.residential.residential_form_3', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_nrc_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                'back' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->nrc_copy_front = $front_nrc;
            $new->nrc_copy_back = $back_nrc;
            $form->application_files()->save($new);
            return redirect()->route('resident_form10_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_nrc_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.residential.residential_form_3_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_nrc_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front ? $request->old_front : NULL;
            $old_back = $request->old_back ? $request->old_back : NULL;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600);
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600);
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $new->save();
            }
            return redirect()->route('resident_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    /* Nrc End */

    /* Yangon Residential Form10 Start */
    public function ygn_residential_form10_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            return view('user.yangon.residential.residential_form_4', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_form10_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                'back.*'  => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            $front_form_10 = implode(',', $tmp_arr);

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
            }
            
            $new = $form->application_files()->first();
            $new->form_10_front = $front_form_10;
            $new->form_10_back = $back_form_10;
            $form->application_files()->save($new);
            return redirect()->route('resident_recomm_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_form10_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.residential.residential_form_4_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_form10_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            if ($request->hasFile('front')) {
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
                $front_form_10 = implode(',', $tmp_arr);
            } else {
                $front_form_10 = null;
            }
            if ($request->hasFile('back')) {
                $tmp_arr = [];
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
            } else {
                $back_form_10 = null;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                if($front_form_10 != ''){
                    /* delete old file */
                    $old_fronts = explode(',',$new->form_10_front);
                    foreach($old_fronts as $old_front){
                        if (file_exists($path.'/'.$old_front)) {
                            File::delete($path.'/'.$old_front);
                        }
                    }
                    // update new
                    $new->form_10_front = $front_form_10;
                }

                if($back_form_10 != ''){
                    /* delete old file */
                    $old_backs = explode(',',$new->form_10_back);
                    foreach($old_backs as $old_back){
                        if (file_exists($path.'/'.$old_back)) {
                            File::delete($path.'/'.$old_back);
                        }
                    }
                    // update new
                    $new->form_10_back = $back_form_10;
                }
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $new->save();
            }
            return redirect()->route('resident_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    /* Form10 End */

    /* Yangon Residential Recommanded Start */ 
    public function ygn_residential_recomm_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            return view('user.yangon.residential.residential_form_5', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_recomm_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required|mimes:jpeg,jpg,png,pdf',
                'back' => 'required|mimes:jpeg,jpg,png,pdf',
            ]);
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
            
            $new = $form->application_files()->first();
            $new->occupy_letter = $occupy;
            $new->no_invade_letter = $no_invade;
            $form->application_files()->save($new);
            return redirect()->route('resident_owner_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_recomm_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.residential.residential_form_5_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_recomm_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $new->save();
            }
            return redirect()->route('resident_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    /* Recommanded End */ 

    /* Yangon Residential Owner Start*/ 
    public function ygn_residential_owner_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            return view('user.yangon.residential.residential_form_6', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_owner_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->ownership = $img_str;
            $form->application_files()->save($new);
            // return redirect()->route('resident_applied_form_ygn', $form->id);
            return redirect()->route('resident_farmland_create_ygn', $form->id);

        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_owner_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.residential.residential_form_6_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_owner_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
            
            return redirect()->route('resident_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    /* Owner End */ 

    // FarmLand Start
    public function ygn_residential_farmland_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'farmland_permit_header';
            return view('user.yangon.residential.residential_form_7', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_farmland_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->farmland = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('resident_building_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_farmland_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'farmland_permit_header';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.residential.residential_form_7_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_farmland_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $olds = explode(',',$new->farmland);
                    foreach($olds as $old){
                        if (file_exists($path.'/'.$old)) {
                            File::delete($path.'/'.$old);
                        }
                    }
                    // update new
                    $new->farmland = $img_str;
                }
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->farmland = $img_str;
                $new->save();
            }
            return redirect()->route('resident_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    // Farmand End

    // Building End Start
    public function ygn_residential_building_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'building_photo_header';
            return view('user.yangon.residential.residential_form_8', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_building_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->building = $img_str;
            $form->application_files()->save($new);
            // return redirect()->route('resident_applied_form_ygn', $form->id);
            return redirect()->route('resident_power_create_ygn', $form->id);

        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_building_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'building_photo_header';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.residential.residential_form_8_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_building_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $olds = explode(',',$new->building);
                    foreach($olds as $old){
                        if (file_exists($path.'/'.$old)) {
                            File::delete($path.'/'.$old);
                        }
                    }
                    // update new
                    $new->building = $img_str;
                }
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->building = $img_str;
                $new->save();
            }
            return redirect()->route('resident_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    // Building End

    // Power Start
    public function ygn_residential_power_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_electricpower_photo';
            return view('user.yangon.residential.residential_form_9', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->electric_power = $img_str;
            $form->application_files()->save($new);
            // return redirect()->route('resident_applied_form_ygn', $form->id);
            return redirect()->route('resident_applied_form_ygn', $form->id);

        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_electricpower_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.residential.residential_form_9_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $olds = explode(',',$new->electric_power);
                    foreach($olds as $old){
                        if (file_exists($path.'/'.$old)) {
                            File::delete($path.'/'.$old);
                        }
                    }
                    // update new
                    $new->electric_power = $img_str;
                }
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->electric_power = $img_str;
                $new->save();
            }
            return redirect()->route('resident_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    // Power End

    public function ygn_residential_show($form_id) {
        $active = 'overall';
        $heading = 'applied_detail';
        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');
        $fee_names = InitialCost::where([['type', 1], ['id', $form->apply_sub_type]])->get();
        $draft_data = FormDraft::where('application_form_id', $form_id)->first();
        return view('user.yangon.residential.show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'form', 'files', 'draft_data'));
    }
    
    /* ------------------------------------------------------------------------ */
    /* Residential Power Meter For Yangon */
    public function ygn_residential_power_rule_regulation() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'rule_regulation';
            return view('user.yangon.residentialPower.rules_and_regulations', compact('active', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }

    public function ygn_residential_power_agreement() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'agreement';
            return view('user.yangon.residentialPower.agreement', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_residential_power_select_meter_type() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('type', 21)->get();
            return view('user.yangon.residentialPower.residential_form_1', compact('active', 'fee_names', 'tbl_col_name'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_store_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $new = new ApplicationForm();
            $new->user_id = Auth::user()->id;
            $new->apply_division = 1;
            $new->apply_type = 2;
            $new->apply_sub_type = $request->type;
            $new->date = date('Y-m-d');
            $new->save();
            return redirect()->route('resident_power_user_info_ygn', $new->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_edit_meter_type($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('type', 2)->get();
            $form = ApplicationForm::find($form_id);
            return view('user.yangon.residentialPower.residential_form_1_edit', compact('active', 'fee_names', 'tbl_col_name', 'form'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_update_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;
            $sub_type = $request->type;
            $new = ApplicationForm::find($form_id);
            $new->apply_type = 2;
            $new->apply_sub_type = $sub_type;
            $new->save();
            return redirect()->route('resident_power_applied_form_ygn', $form_id);
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_residential_power_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', 2)->get();
            $draft_data = FormDraft::where('application_form_id', $form_id)->first();
            // dd($townships);
            return view('user.yangon.residentialPower.residential_form_2', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'draft_data'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_store_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'fullname' => 'required',
                'nrc' => 'required',
                'applied_phone' => 'required',
                'jobType' => 'required',
                'applied_building_type' => 'required',
                'applied_home_no' => 'required',
                'applied_street' => 'required',
                'applied_quarter' => 'required',
                'township_id' => 'required',
            ]);

            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;
            $serial_code = get_serial($div_state_id);

            if ($request->save_type == 'save') {
                $new = ApplicationForm::find($form_id);
                $new->serial_code = $serial_code;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->save();
                return redirect()->route('resident_power_nrc_create_ygn', $form_id);
            } if ($request->save_type == 'draft') {
                $alrdy_draft = FormDraft::where('application_form_id', $form_id)->first();
                if ($alrdy_draft) {
                    $new = $alrdy_draft;
                } else {
                    $new = new FormDraft();
                }
                $new->application_form_id = $form_id;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->date = date('Y-m-d');
                $new->save();
                return redirect()->route('all_meter_forms');
            }
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_edit_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id',2)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if ($d_form) {
                    $form = $d_form;
                    $form->id = $form_id;
                }
            }
            return view('user.yangon.residentialPower.residential_form_2_edit', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'form'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_update_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'fullname' => 'required',
                'nrc' => 'required',
                'applied_phone' => 'required',
                'jobType' => 'required',
                'applied_building_type' => 'required',
                'applied_home_no' => 'required',
                'applied_street' => 'required',
                'applied_quarter' => 'required',
                'township_id' => 'required',
            ]);

            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $new = ApplicationForm::find($form_id);
            if (!$new->serial_code || ($new->div_state_id == null) || ( $new->div_state_id != $div_state_id )) {
                $new->serial_code = get_serial($div_state_id);
            }
            $new->fullname = $fullname;
            $new->nrc = $nrc;
            $new->applied_phone = $applied_phone;
            $new->job_type = $request->jobType;
            $new->position = $position;
            $new->department = $department;
            $new->salary = $salary ? $salary : 0;
            $new->applied_building_type = $applied_building_type;
            $new->applied_home_no = $applied_home_no;
            $new->applied_building = $applied_building;
            $new->applied_lane = $applied_lane;
            $new->applied_street = $applied_street;
            $new->applied_quarter = $applied_quarter;
            $new->applied_town = $applied_town;
            $new->township_id = $township_id;
            $new->district_id = $district_id;
            $new->div_state_id = $div_state_id;
            $new->save();
            return redirect()->route('resident_power_applied_form_ygn', $form_id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function ygn_residential_power_nrc_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            return view('user.yangon.residentialPower.residential_form_3', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_nrc_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                'back' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);

            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

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
            
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->nrc_copy_front = $front_nrc;
            $new->nrc_copy_back = $back_nrc;
            $form->application_files()->save($new);
            return redirect()->route('resident_power_form10_create_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_nrc_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.residentialPower.residential_form_3_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_nrc_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);

            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
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
            return redirect()->route('resident_power_applied_form_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function ygn_residential_power_form10_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            return view('user.yangon.residentialPower.residential_form_4', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_form10_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                'back.*'  => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            // upload multiple stored fun
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
            $front_form_10 = implode(',', $tmp_arr);

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
            }
            
            $new = $form->application_files()->first();
            $new->form_10_front = $front_form_10;
            $new->form_10_back = $back_form_10;
            $form->application_files()->save($new);
            return redirect()->route('resident_power_recomm_create_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_form10_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.residentialPower.residential_form_4_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_form10_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                'back.*'  => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
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
                $front_form_10 = implode(',', $tmp_arr);
            } else {
                $front_form_10 = null;
            }
            if ($request->hasFile('back')) {
                $tmp_arr = [];
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
            } else {
                $back_form_10 = null;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                if($front_form_10 != ''){
                    /* delete old file */
                    $old_fronts = explode(',',$new->form_10_front);
                    foreach($old_fronts as $old_front){
                        if (file_exists($path.'/'.$old_front)) {
                            File::delete($path.'/'.$old_front);
                        }
                    }
                    // update new
                    $new->form_10_front = $front_form_10;
                }
        
                if($back_form_10 != ''){
                    /* delete old file */
                    $old_backs = explode(',',$new->form_10_back);
                    foreach($old_backs as $old_back){
                        if (file_exists($path.'/'.$old_back)) {
                            File::delete($path.'/'.$old_back);
                        }
                    }
                    // update new
                    $new->form_10_back = $back_form_10;
                }
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $new->save();
            }
            return redirect()->route('resident_power_applied_form_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function ygn_residential_power_recomm_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            return view('user.yangon.residentialPower.residential_form_5', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_recomm_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required|mimes:jpeg,jpg,png,pdf',
                'back' => 'required|mimes:jpeg,jpg,png,pdf',
            ]);
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
            
            $new = $form->application_files()->first();
            $new->occupy_letter = $occupy;
            $new->no_invade_letter = $no_invade;
            $form->application_files()->save($new);
            return redirect()->route('resident_power_owner_create_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_recomm_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.residentialPower.residential_form_5_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_recomm_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $new->save();
            }
            return redirect()->route('resident_power_applied_form_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function ygn_residential_power_owner_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            return view('user.yangon.residentialPower.residential_form_6', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_owner_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->ownership = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('resident_power_electricpower_create_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_owner_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.residentialPower.residential_form_6_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_owner_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->ownership = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->ownership = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('resident_power_applied_form_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function ygn_residential_power_electricpower_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_electricpower_photo';
            return view('user.yangon.residentialPower.residential_form_7', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_electricpower_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->electric_power = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('resident_power_bill_create_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_electricpower_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_electricpower_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.residentialPower.residential_form_7_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_residential_power_electricpower_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {

            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            
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
                    /* delete old file */
                    if($new->electric_power != ""){
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
            }
            return redirect()->route('resident_power_applied_form_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    // prev bill start
    public function ygn_resident_power_bill_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_bill_photo2';
            return view('user.yangon.residentialPower.residential_form_10', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_resident_power_bill_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_bill = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_bill);
            
            $new = $form->application_files()->first();
            $new->prev_bill = $front_bill;
            $form->application_files()->save($new);
            // return redirect()->route('contractor_applied_form_ygn', $form->id);
            return redirect()->route('resident_power_farmland_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_resident_power_bill_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_bill_photo2';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.residentialPower.residential_form_10_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_resident_power_bill_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $prev_bill = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$prev_bill);
            } else {
                $prev_bill = null;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                if($prev_bill != ""){
                    /* delete old file */
                    if (file_exists($path.'/'.$new->prev_bill)) {
                        File::delete($path.'/'.$new->prev_bill);
                    }
                    $new->prev_bill = $prev_bill;
                }
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->prev_bill = $prev_bill;
                $new->save();
            }
            return redirect()->route('resident_power_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    // prev bill end

    // FarmLand Start
    public function ygn_resident_power_farmland_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'farmland_permit_header';
            return view('user.yangon.residentialPower.residential_form_11', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_resident_power_farmland_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['required','image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->farmland = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('resident_power_building_photo_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_resident_power_farmland_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'farmland_permit_header';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.residentialPower.residential_form_11_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_resident_power_farmland_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);

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
                    $olds = explode(',',$new->farmland);
                    foreach($olds as $old){
                        if (file_exists($path.'/'.$old)) {
                            File::delete($path.'/'.$old);
                        }
                    }
                    // update new
                    $new->farmland = $img_str;
                }
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->farmland = $img_str;
                $new->save();
            }
            return redirect()->route('resident_power_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    // Farmand End

    // Building Start
    public function ygn_resident_power_building_photo_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'building_photo_header';
            return view('user.yangon.residentialPower.residential_form_12', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_resident_power_building_photo_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['required','image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->building = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('resident_power_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_resident_power_building_photo_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'building_photo_header';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.residentialPower.residential_form_12_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_resident_power_building_photo_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);

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
                    $olds = explode(',',$new->building);
                    foreach($olds as $old){
                        if (file_exists($path.'/'.$old)) {
                            File::delete($path.'/'.$old);
                        }
                    }
                    // update new
                    $new->building = $img_str;
                }
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->building = $img_str;
                $new->save();
            }
            return redirect()->route('resident_power_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_residential_power_show($form_id) {
        $active = 'overall';
        $heading = 'applied_detail';
        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');
        $fee_names = InitialCost::where([['type', 21], ['sub_type', $form->apply_sub_type]])->get();
        return view('user/yangon/residentialPower/show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'form', 'files'));
    }
    /* Residentialial Power Meter For Yangon End */
    /* ------------------------------------------------------------------------ */

    /* ------------------------------------------------------------------------ */
    /* Commercial Power Meter  For Yangon*/
    public function ygn_commercial_rule_regulation() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'rule_regulation';
            return view('user.yangon.commercialPower.rules_and_regulations', compact('active', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }

    public function ygn_commercial_agreement() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'agreement';
            return view('user.yangon.commercialPower.agreement', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_commercial_select_meter_type() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('type', 3)->get();
            return view('user.yangon.commercialPower.commercial_form_1', compact('active', 'fee_names', 'tbl_col_name'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_store_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $new = new ApplicationForm();
            $new->user_id = Auth::user()->id;
            $new->apply_division = 1;
            $new->apply_type = 3;
            $new->apply_sub_type = $request->type;
            $new->date = date('Y-m-d');
            $new->save();
            return redirect()->route('commercial_user_info_ygn', $new->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_edit_meter_type($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('type', 3)->get();
            $form = ApplicationForm::find($form_id);
            return view('user.yangon.commercialPower.commercial_form_1_edit', compact('active', 'fee_names', 'tbl_col_name', 'form'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_update_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;
            $new = ApplicationForm::find($form_id);
            if ($new->apply_sub_type !== $request->sub_type) {
                $new->apply_sub_type = $request->sub_type;
                $new->save();
            }
            return redirect()->route('commercial_applied_form_ygn', $form_id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function ygn_commercial_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id',2)->get();
            $draft_data = FormDraft::where('application_form_id', $form_id)->first();
            // dd($townships);
            return view('user.yangon.commercialPower.commercial_form_2', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'draft_data'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_store_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            if ($request->save_type == 'save') {
                $this->validate($request, [
                    'fullname' => 'required',
                    'nrc' => 'required',
                    'applied_phone' => ['required', 'min:9', 'max:11'],
                    'jobType' => 'required',
                    'applied_building_type' => 'required',
                    'applied_home_no' => 'required',
                    'applied_street' => 'required',
                    'applied_quarter' => 'required',
                    'township_id' => 'required',
                    'district' => 'required',
                    'region' => 'required',
                ]);
            }
            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $serial_code = get_serial($div_state_id);

            if ($request->save_type == 'save') {
                $new = ApplicationForm::findOrFail($form_id);

                $new->serial_code = $serial_code;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->save();
                return redirect()->route('commercial_nrc_create_ygn', $form_id);
            } elseif ($request->save_type == 'draft') {
                $alrdy_draft = FormDraft::where('application_form_id', $form_id)->first();
                if ($alrdy_draft) {
                    $new = $alrdy_draft;
                } else {
                    $new = new FormDraft();
                }
                $new->application_form_id = $form_id;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->date = date('Y-m-d');
                $new->save();
                return redirect()->route('all_meter_forms');
            }
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_edit_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id',2)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if ($d_form) {
                    $form = $d_form;
                    $form->id = $form_id;
                }
            }
            return view('user.yangon.commercialPower.commercial_form_2_edit', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'form'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_update_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'fullname' => 'required',
                'nrc' => 'required',
                'applied_phone' => 'required',
                'applied_building_type' => 'required',
                'applied_home_no' => 'required',
                // 'applied_lane' => 'required',
                'applied_street' => 'required',
                'applied_quarter' => 'required',
                'township_id' => 'required',
            ]);

            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $new = ApplicationForm::find($form_id);
            if (!$new->serial_code || ($new->div_state_id == null) || ( $new->div_state_id != $div_state_id )) {
                $new->serial_code = get_serial($div_state_id);
            }
            $new->fullname = $fullname;
            $new->nrc = $nrc;
            $new->applied_phone = $applied_phone;
            $new->job_type = $request->jobType;
            $new->position = $position;
            $new->department = $department;
            $new->salary = $salary ? $salary : 0;
            $new->applied_building_type = $applied_building_type;
            $new->applied_home_no = $applied_home_no;
            $new->applied_building = $applied_building;
            $new->applied_lane = $applied_lane;
            $new->applied_street = $applied_street;
            $new->applied_quarter = $applied_quarter;
            $new->applied_town = $applied_town;
            $new->township_id = $township_id;
            $new->district_id = $district_id;
            $new->div_state_id = $div_state_id;
            $new->save();
            return redirect()->route('commercial_applied_form_ygn', $form_id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function ygn_commercial_nrc_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            return view('user.yangon.commercialPower.commercial_form_3', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_nrc_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                'back' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);

            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

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
            
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->nrc_copy_front = $front_nrc;
            $new->nrc_copy_back = $back_nrc;
            $form->application_files()->save($new);
            return redirect()->route('commercial_form10_create_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_nrc_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.commercialPower.commercial_form_3_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_nrc_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);

            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }

            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
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
            return redirect()->route('commercial_applied_form_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function ygn_commercial_form10_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            return view('user.yangon.commercialPower.commercial_form_4', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_form10_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                'back.*'  => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            // upload multiple stored fun
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
            $front_form_10 = implode(',', $tmp_arr);

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
            }
            
            $new = $form->application_files()->first();
            $new->form_10_front = $front_form_10;
            $new->form_10_back  = $back_form_10;
            $form->application_files()->save($new);
            return redirect()->route('commercial_recomm_create_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_form10_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.commercialPower.commercial_form_4_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_form10_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                'back.*'  => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
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
                $front_form_10 = implode(',', $tmp_arr);
            } else {
                $front_form_10 = null;
            }
            if ($request->hasFile('back')) {
                $tmp_arr = [];
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
            } else {
                $back_form_10 = null;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                if($front_form_10 != ''){
                    /* delete old file */
                    $old_fronts = explode(',',$new->form_10_front);
                    foreach($old_fronts as $old_front){
                        if (file_exists($path.'/'.$old_front)) {
                            File::delete($path.'/'.$old_front);
                        }
                    }
                    // update new
                    $new->form_10_front = $front_form_10;
                }
                if($back_form_10 != ''){
                    /* delete old file */
                    $old_backs = explode(',',$new->form_10_back);
                    foreach($old_backs as $old_back){
                        if (file_exists($path.'/'.$old_back)) {
                            File::delete($path.'/'.$old_back);
                        }
                    }
                    // update new
                    $new->form_10_back = $back_form_10;
                }
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $new->save();
            }
            return redirect()->route('commercial_applied_form_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function ygn_commercial_recomm_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            return view('user.yangon.commercialPower.commercial_form_5', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_recomm_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required|mimes:jpeg,jpg,png,pdf',
                'back' => 'required|mimes:jpeg,jpg,png,pdf',
            ]);
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
            
            $new = $form->application_files()->first();
            $new->occupy_letter = $occupy;
            $new->no_invade_letter = $no_invade;
            $form->application_files()->save($new);
            return redirect()->route('commercial_owner_create_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_recomm_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.commercialPower.commercial_form_5_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_recomm_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $new->save();
            }
            return redirect()->route('commercial_applied_form_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function ygn_commercial_owner_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            return view('user.yangon.commercialPower.commercial_form_6', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_owner_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->ownership = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('commercial_worklicence_create_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_owner_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.commercialPower.commercial_form_6_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_owner_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->ownership = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->ownership = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('commercial_applied_form_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function ygn_commercial_worklicence_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_transactionlicence_photo';
            return view('user.yangon.commercialPower.commercial_form_7', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_worklicence_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->transaction_licence = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('commercial_electricpower_create_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_worklicence_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_transactionlicence_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.commercialPower.commercial_form_7_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_worklicence_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->transaction_licence = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->transaction_licence = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('commercial_applied_form_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function ygn_commercial_electricpower_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_electricpower_photo';
            return view('user.yangon.commercialPower.commercial_form_8', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_electricpower_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->electric_power = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('commercial_bill_create_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_electricpower_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_electricpower_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.commercialPower.commercial_form_8_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_electricpower_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    if($img_str != ""){
                        /* delete old file */
                        $olds = explode(',',$new->electric_power);
                        foreach($olds as $old){
                            if (file_exists($path.'/'.$old)) {
                                File::delete($path.'/'.$old);
                            }
                        }
                        // update new
                        $new->electric_power = $img_str;
                    }
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->electric_power = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('commercial_applied_form_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }

    // prev bill start
    public function ygn_commercial_bill_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_bill_photo2';
            return view('user.yangon.commercialPower.commercial_form_11', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_bill_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_bill = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_bill);
            
            $new = $form->application_files()->first();
            $new->prev_bill = $front_bill;
            $form->application_files()->save($new);
            // return redirect()->route('contractor_applied_form_ygn', $form->id);
            return redirect()->route('commercial_farmland_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_bill_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_bill_photo2';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.commercialPower.commercial_form_11_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_bill_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $prev_bill = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$prev_bill);
            } else {
                $prev_bill = null;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                if($prev_bill != ""){
                    /* delete old file */
                    if (file_exists($path.'/'.$new->prev_bill)) {
                        File::delete($path.'/'.$new->prev_bill);
                    }
                    $new->prev_bill = $prev_bill;
                }
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->prev_bill = $prev_bill;
                $new->save();
            }
            return redirect()->route('commercial_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    // prev bill end

    // FarmLand Start
    public function ygn_commercial_farmland_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'farmland_permit_header';
            return view('user.yangon.commercialPower.commercial_form_9', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_farmland_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['required','image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->farmland = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('commercial_building_photo_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_farmland_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'farmland_permit_header';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.commercialPower.commercial_form_9_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_farmland_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);

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
                    $olds = explode(',',$new->farmland);
                    foreach($olds as $old){
                        if (file_exists($path.'/'.$old)) {
                            File::delete($path.'/'.$old);
                        }
                    }
                    // update new
                    $new->farmland = $img_str;
                }
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->farmland = $img_str;
                $new->save();
            }
            return redirect()->route('commercial_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    // Farmand End

    // Building Start
    public function ygn_commercial_building_photo_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'building_photo_header';
            return view('user.yangon.commercialPower.commercial_form_10', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_building_photo_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['required','image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->building = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('commercial_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_building_photo_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'building_photo_header';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.commercialPower.commercial_form_10_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_building_photo_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);

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
                    $olds = explode(',',$new->building);
                    foreach($olds as $old){
                        if (file_exists($path.'/'.$old)) {
                            File::delete($path.'/'.$old);
                        }
                    }
                    // update new
                    $new->building = $img_str;
                }
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->building = $img_str;
                $new->save();
            }
            return redirect()->route('commercial_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    // Building End

    public function ygn_commercial_show($form_id) {
        $active = 'overall';
        $heading = 'applied_detail';
        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');
        $fee_names = InitialCost::where([['type', 3], ['sub_type', $form->apply_sub_type]])->get();
        return view('user.yangon.commercialPower.show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'form', 'files'));
    }

    /* ------------------------------------------------------------------------ */
    /* Contractor Meter */
    public function ygn_contractor_rule_regulation() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'rule_regulation';
            return view('user.yangon.contractor.rules_and_regulations', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_contractor_agreement() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'agreement';
            return view('user.yangon.contractor.agreement', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_contractor_building_room() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            return view('user.yangon.contractor.two_buildings', compact('active'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_building(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [ 
                'room_count' => 'required|numeric|min:4'
            ]);
            $room_count = $request->room_count;
            $apartment_count = $request->apartment_count;
            $floor_count = $request->floor_count;
            $pMeter10 = $request->pMeter10;
            $pMeter20 = $request->pMeter20;
            $pMeter30 = $request->pMeter30;
            $meter = $request->meter;
            $water_meter = $request->water_meter;
            if ($water_meter == 'on') {
                $water_meter = true;
            } else {
                $water_meter = false;
            }
            $elevator_meter = $request->elevator_meter;
            if ($elevator_meter == 'on') {
                $elevator_meter = true;
            } else {
                $elevator_meter = false;
            }
            $sub_type = 1;
            if ($room_count > 17) {
                $sub_type = 2;
            }
            
            $new = new ApplicationForm();
            $new->user_id = Auth::user()->id;
            $new->apply_type = 5;
            $new->apply_sub_type = $sub_type;
            $new->apply_division = 1;
            $new->date = date('Y-m-d');
            $new->save();

            $c_form = new ApplicationFormContractor();
            $c_form->application_form_id = $new->id;
            $c_form->room_count = $room_count;
            $c_form->apartment_count = $apartment_count;
            $c_form->floor_count = $floor_count;
            $c_form->pMeter10 = $pMeter10;
            $c_form->pMeter20 = $pMeter20;
            $c_form->pMeter30 = $pMeter30;
            $c_form->meter = $meter;
            $c_form->water_meter = $water_meter;
            $c_form->elevator_meter = $elevator_meter;
            $c_form->save();
            
            // if ($sub_type == 1) {
                return redirect()->route('417_user_info_ygn', $new->id);
            // } else {
                // return redirect()->route('18_user_info_ygn', $new->id);
            // }
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_building_room_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $c_form = ApplicationFormContractor::where('application_form_id', $form_id)->first();

            return view('user.yangon.contractor.two_buildings_edit', compact('active','c_form'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_building_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [ 
                'room_count' => 'required|numeric|min:4'
            ]);
            $form_id = $request->form_id;
            $room_count = $request->room_count;
            $apartment_count = $request->apartment_count;
            $floor_count = $request->floor_count;
            $pMeter10 = $request->pMeter10;
            $pMeter20 = $request->pMeter20;
            $pMeter30 = $request->pMeter30;
            $meter = $request->meter;
            $water_meter = $request->water_meter;
            if ($water_meter == 'on') {
                $water_meter = true;
            } else {
                $water_meter = false;
            }
            $elevator_meter = $request->elevator_meter;
            if ($elevator_meter == 'on') {
                $elevator_meter = true;
            } else {
                $elevator_meter = false;
            }
            $sub_type = 1;
            if ($room_count > 17) {
                $sub_type = 2;
            }

            $new = ApplicationForm::find($form_id);
            $new->user_id = Auth::user()->id;
            $new->apply_type = 5;
            $new->apply_sub_type = $sub_type;
            $new->apply_division = 1;
            $new->save();
            

            $c_form = ApplicationFormContractor::where('application_form_id', $form_id)->first();
            $c_form->room_count = $room_count;
            $c_form->apartment_count = $apartment_count;
            $c_form->floor_count = $floor_count;
            $c_form->pMeter10 = $pMeter10;
            $c_form->pMeter20 = $pMeter20;
            $c_form->pMeter30 = $pMeter30;
            $c_form->meter = $meter;
            $c_form->water_meter = $water_meter;
            $c_form->elevator_meter = $elevator_meter;
            $c_form->save();
            
            // if ($sub_type == 1) {
                return redirect()->route('contractor_applied_form_ygn', $form_id);
            // } else {
                // return redirect()->route('18_user_info_ygn', $new->id);
            // }
        } else {
            return redirect()->route('home');
        }
    }

    /* 4 to 17 rooms */
    public function ygn_room_417_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::where('id', 2)->get();
            $districts = District::where('division_state_id', 2)->get();
            $townships = Township::where('division_state_id', 2)->get();
            $draft_data = FormDraft::where('application_form_id', $form_id)->first();
            return view('user.yangon.contractor.4_17_form_1', compact('active', 'heading', 'form_id', 'regions', 'districts', 'townships', 'draft_data'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_store_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            if ($request->save_type == 'save') {
                $this->validate($request, [
                    'fullname' => 'required',
                    'nrc' => 'required',
                    'applied_phone' => ['required', 'min:9', 'max:11'],
                    'applied_home_no' => 'required',
                    'applied_street' => 'required',
                    'applied_quarter' => 'required',
                    'township_id' => 'required',
                    'district' => 'required',
                    'region' => 'required',
                ]);
            }
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

            if ($request->save_type == 'save') {
                $new = ApplicationForm::find($form_id);
                $new->serial_code = $serial_code;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->applied_home_no = $applied_home_no;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->save();
                return redirect()->route('417_nrc_create_ygn', $form_id);
            } elseif ($request->save_type == 'draft') {
                $alrdy_draft = FormDraft::where('application_form_id', $form_id)->first();
                if ($alrdy_draft) {
                    $new = $alrdy_draft;
                } else {
                    $new = new FormDraft();
                }
                $new->application_form_id = $form_id;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->applied_home_no = $applied_home_no;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->date = date('Y-m-d');
                $new->save();
                return redirect()->route('all_meter_forms');
            }
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_edit_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::where('id', 2)->get();
            $districts = District::where('division_state_id', 2)->get();
            $townships = Township::where('division_state_id', 2)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if ($d_form) {
                    $form = $d_form;
                    $form->id = $form_id;
                }
            }
            // dd($form);
            return view('user.yangon.contractor.4_17_form_1_edit', compact('active', 'heading', 'form_id', 'regions', 'districts', 'townships', 'form'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_update_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'fullname' => 'required',
                'nrc' => 'required',
                'applied_phone' => ['required', 'min:9', 'max:11'],
                'applied_home_no' => 'required',
                'applied_street' => 'required',
                'applied_quarter' => 'required',
                'township_id' => 'required',
                'district' => 'required',
                'region' => 'required',
            ]);
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

            $new = ApplicationForm::find($form_id);
            if (!$new->serial_code || ($new->div_state_id == null) || ( $new->div_state_id != $div_state_id )) {
                $new->serial_code = get_serial($div_state_id);
            }
            $new->fullname = $fullname;
            $new->nrc = $nrc;
            $new->applied_phone = $applied_phone;
            $new->applied_home_no = $applied_home_no;
            $new->applied_lane = $applied_lane;
            $new->applied_street = $applied_street;
            $new->applied_quarter = $applied_quarter;
            $new->applied_town = $applied_town;
            $new->township_id = $township_id;
            $new->district_id = $district_id;
            $new->div_state_id = $div_state_id;
            $new->date = date('Y-m-d');
            $new->save();
            return redirect()->route('contractor_applied_form_ygn', $form_id);
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_room_417_nrc_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            return view('user.yangon.contractor.4_17_form_2', compact('active', 'heading', 'form_id'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_nrc_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                'back' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);

            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

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
            
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->nrc_copy_front = $front_nrc;
            $new->nrc_copy_back = $back_nrc;
            $form->application_files()->save($new);
            return redirect()->route('417_form10_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_nrc_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.contractor.4_17_form_2_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_nrc_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $new->save();
            }
            return redirect()->route('contractor_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_room_417_form10_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            return view('user.yangon.contractor.4_17_form_3', compact('active', 'heading', 'form_id'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_form10_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                'back.*'  => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            // upload multiple stored fun
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
            $front_form_10 = implode(',', $tmp_arr);

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
            }
            
            $new = $form->application_files()->first();
            $new->form_10_front = $front_form_10;
            $new->form_10_back = $back_form_10;
            $form->application_files()->save($new);
            return redirect()->route('417_recomm_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_form10_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.contractor.4_17_form_3_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_form10_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                'back.*'  => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
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
                $front_form_10 = implode(',', $tmp_arr);
            } else {
                $front_form_10 = null;
            }
            if ($request->hasFile('back')) {
                $tmp_arr = [];
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
            } else {
                $back_form_10 = null;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                if($front_form_10 != ''){
                    /* delete old file */
                    $old_fronts = explode(',',$new->form_10_front);
                    foreach($old_fronts as $old_front){
                        if (file_exists($path.'/'.$old_front)) {
                            File::delete($path.'/'.$old_front);
                        }
                    }
                    // update new
                    $new->form_10_front = $front_form_10;
                }
        
                if($back_form_10 != ''){
                    /* delete old file */
                    $old_backs = explode(',',$new->form_10_back);
                    foreach($old_backs as $old_back){
                        if (file_exists($path.'/'.$old_back)) {
                            File::delete($path.'/'.$old_back);
                        }
                    }
                    // update new
                    $new->form_10_back = $back_form_10;
                }
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $new->save();
            }
            return redirect()->route('contractor_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_room_417_recomm_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            return view('user.yangon.contractor.4_17_form_4', compact('active', 'heading', 'form_id'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_recomm_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            
            $new = $form->application_files()->first();
            $new->occupy_letter = $occupy;
            $new->no_invade_letter = $no_invade;
            $form->application_files()->save($new);
            $form->application_files()->save($new);
            return redirect()->route('417_owner_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_recomm_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.contractor.4_17_form_4_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_recomm_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $occupy_img = Image::make($request->file('front'));
                $occupy = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $occupy_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $occupy_img->save($path.'/'.$occupy);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $occupy = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $no_invade_img = Image::make($request->file('back'));
                $no_invade = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $no_invade_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $no_invade_img->save($path.'/'.$no_invade);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $no_invade = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->occupy_letter = $occupy;
                $new->no_invade_letter = $no_invade;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->occupy_letter = $occupy;
                $new->no_invade_letter = $no_invade;
                $new->save();
            }
            return redirect()->route('contractor_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_room_417_owner_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            return view('user.yangon.contractor.4_17_form_5', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_owner_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->ownership = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('417_permit_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_owner_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.contractor.4_17_form_5_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_owner_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->ownership = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->ownership = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('contractor_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_room_417_permit_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_permit_photo';
            return view('user.yangon.contractor.4_17_form_6', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_permit_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_permit = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_permit);
            
            $new = $form->application_files()->first();
            $new->building_permit = $front_permit;
            $form->application_files()->save($new);
            return redirect()->route('417_bcc_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_permit_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_permit_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.contractor.4_17_form_6_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_permit_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $permit = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$permit);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $permit = $old_front;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->building_permit = $permit;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->building_permit = $permit;
                $new->save();
            }
            return redirect()->route('contractor_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_room_417_bcc_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_bcc_photo';
            return view('user.yangon.contractor.4_17_form_7', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_bcc_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_bcc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_bcc);
            
            $new = $form->application_files()->first();
            $new->bcc = $front_bcc;
            $form->application_files()->save($new);
            return redirect()->route('417_dc_recomm_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_bcc_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_bcc_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.contractor.4_17_form_7_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_bcc_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $bcc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$bcc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $bcc = $old_front;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->bcc = $bcc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->bcc = $bcc;
                $new->save();
            }
            return redirect()->route('contractor_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_room_417_dc_recomm_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_dc_recomm_photo';
            return view('user.yangon.contractor.4_17_form_8', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_dc_recomm_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_dc_recomm = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_dc_recomm);
            
            $new = $form->application_files()->first();
            $new->dc_recomm = $front_dc_recomm;
            $form->application_files()->save($new);
            return redirect()->route('417_bill_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_dc_recomm_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_dc_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.contractor.4_17_form_8_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_dc_recomm_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            
            $dc_recomm = null;
            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $dc_recomm = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$dc_recomm);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $dc_recomm = $old_front;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->dc_recomm = $dc_recomm;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->dc_recomm = $dc_recomm;
                $new->save();
            }
            return redirect()->route('contractor_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_room_417_bill_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_bill_photo';
            return view('user.yangon.contractor.4_17_form_9', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_bill_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_bill = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_bill);
            
            $new = $form->application_files()->first();
            $new->prev_bill = $front_bill;
            $form->application_files()->save($new);
            // return redirect()->route('contractor_applied_form_ygn', $form->id);
            return redirect()->route('contractor_farmland_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_bill_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_bill_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.contractor.4_17_form_9_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_room_417_bill_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $prev_bill = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$prev_bill);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $prev_bill = $old_front;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->prev_bill = $prev_bill;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->prev_bill = $prev_bill;
                $new->save();
            }
            return redirect()->route('contractor_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    // FarmLand Start
    public function ygn_contractor_farmland_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'farmland_permit_header';
            return view('user.yangon.contractor.4_17_form_10', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_farmland_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['required','image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->farmland = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('contractor_building_photo_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_farmland_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'farmland_permit_header';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.contractor.4_17_form_10_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_farmland_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);

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
                    $olds = explode(',',$new->farmland);
                    foreach($olds as $old){
                        if (file_exists($path.'/'.$old)) {
                            File::delete($path.'/'.$old);
                        }
                    }
                    // update new
                    $new->farmland = $img_str;
                }
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->farmland = $img_str;
                $new->save();
            }
            return redirect()->route('contractor_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    // Farmand End

    // Building Start
    public function ygn_contractor_building_photo_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'building_photo_header';
            return view('user.yangon.contractor.4_17_form_11', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_building_photo_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['required','image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->building = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('contractor_BQ_photo_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_building_photo_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'building_photo_header';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.contractor.4_17_form_11_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_building_photo_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);

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
                    $olds = explode(',',$new->building);
                    foreach($olds as $old){
                        if (file_exists($path.'/'.$old)) {
                            File::delete($path.'/'.$old);
                        }
                    }
                    // update new
                    $new->building = $img_str;
                }
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->building = $img_str;
                $new->save();
            }
            return redirect()->route('contractor_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    // Building End

    // BQ Start
    public function ygn_contractor_bq_photo_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'bq_photo_header';
            return view('user.yangon.contractor.4_17_form_12', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_bq_photo_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['required','image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->bq = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('contractor_Drawing_photo_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_bq_photo_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'bq_photo_header';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.contractor.4_17_form_12_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_bq_photo_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);

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
                    $olds = explode(',',$new->bq);
                    foreach($olds as $old){
                        if (file_exists($path.'/'.$old)) {
                            File::delete($path.'/'.$old);
                        }
                    }
                    // update new
                    $new->bq = $img_str;
                }
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->bq = $img_str;
                $new->save();
            }
            return redirect()->route('contractor_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    // BQ End

    // Drawing Start
    public function ygn_contractor_drawing_photo_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'drawing_photo_header';
            return view('user.yangon.contractor.4_17_form_13', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_drawing_photo_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['required','image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->drawing = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('contractor_Map_photo_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_drawing_photo_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'drawing_photo_header';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.contractor.4_17_form_13_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_drawing_photo_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);

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
            return redirect()->route('contractor_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    // Drawing End

    // map Start
    public function ygn_contractor_map_photo_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'map_photo_header';
            return view('user.yangon.contractor.4_17_form_14', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_map_photo_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['required','image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->map = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('contractor_sign_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_map_photo_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'map_photo_header';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.contractor.4_17_form_14_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_map_photo_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);

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
                    $olds = explode(',',$new->map);
                    foreach($olds as $old){
                        if (file_exists($path.'/'.$old)) {
                            File::delete($path.'/'.$old);
                        }
                    }
                    // update new
                    $new->map = $img_str;
                }
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->map = $img_str;
                $new->save();
            }
            return redirect()->route('contractor_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    // Map End

    // sign Start
    public function ygn_contractor_sign_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'sign_header';
            return view('user.yangon.contractor.4_17_form_15', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_sign_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['required','image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->sign = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('contractor_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_sign_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'map_photo_header';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.contractor.4_17_form_15_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_contractor_sign_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);

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
                    $olds = explode(',',$new->map);
                    foreach($olds as $old){
                        if (file_exists($path.'/'.$old)) {
                            File::delete($path.'/'.$old);
                        }
                    }
                    // update new
                    $new->sign = $img_str;
                }
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->sign = $img_str;
                $new->save();
            }
            return redirect()->route('contractor_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    // sign End

    public function ygn_contractor_show($form_id) {
        $active = 'overall';
        $heading = 'applied_detail';
        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($form_id);
        $c_form = ApplicationFormContractor::where('application_form_id', $form_id)->first();
        $files = $form->application_files;
        return view('user/yangon/contractor/show', compact('active', 'heading', 'form', 'files','c_form'));
    }
    /* Contractor Meter End */
    /* ------------------------------------------------------------------------ */

    /* ------------------------------------------------------------------------ */
    /* Transformer Start */
    public function ygn_transformer_rule_regulation() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'rule_regulation';
            return view('user.yangon.transformer.rules_and_regulations', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_agreement() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'agreement';
            return view('user.yangon.transformer.agreement', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_transformer_select_meter_type() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::whereNotIn('name',['630','800','1500'])->where('type', 4)->get();
            return view('user/yangon/transformer/tsf_form_1', compact('active', 'fee_names', 'tbl_col_name'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_store_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // return $request;
            $new = new ApplicationForm();
            $new->user_id = Auth::user()->id;
            $new->apply_type = 4;
            $new->apply_tsf_type = 1;
            $new->pole_type = $request->pole_type;
            $new->apply_sub_type = $request->sub_type;
            $new->apply_division = 1;
            $new->date = date('Y-m-d');
            $new->save();
            return redirect()->route('tsf_user_info_ygn', $new->id);
        } else {
            return redirect()->route('home');
        }
    }
    /*  *** Commercial tsf start*/
    public function ygn_commercial_transformer_rule_regulation() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'rule_regulation';
            return view('user.yangon.transformer.commercial.rules_and_regulations', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_transformer_agreement() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'agreement';
            return view('user.yangon.transformer.commercial.agreement', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    /* *** Commercial tsf start*/

    public function ygn_commercial_transformer_select_meter_type() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::whereNotIn('name',['630','800','1500'])->where('type', 4)->get();
            return view('user/yangon/transformer/commercial/tsf_form_1', compact('active', 'fee_names', 'tbl_col_name'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_commercial_transformer_store_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $new = new ApplicationForm();
            $new->user_id = Auth::user()->id;
            $new->apply_type = 4;
            $new->apply_tsf_type = 2;
            $new->pole_type = $request->pole_type;
            $new->apply_sub_type = $request->sub_type;
            $new->apply_division = 1;
            $new->date = date('Y-m-d');
            $new->save();
            return redirect()->route('tsf_user_info_ygn', $new->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_transformer_edit_meter_type($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::whereNotIn('name',['630','800','1500'])->where('type', 4)->get();
            $form = ApplicationForm::find($form_id);
            return view('user/yangon/transformer/tsf_form_1_edit', compact('active', 'fee_names', 'tbl_col_name', 'form'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_update_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;
            $new = ApplicationForm::find($form_id);
            if ($new->apply_sub_type !== $request->sub_type) {
                $new->apply_sub_type = $request->sub_type;
                $new->pole_type = $request->pole_type;
                $new->save();
            }
            return redirect()->route('tsf_applied_form_ygn', $form_id);
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_transformer_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', 2)->get();
            $draft_data = FormDraft::where('application_form_id', $form_id)->first();
            // dd($draft_data);
            return view('user.yangon.transformer.tsf_form_2', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'draft_data'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_store_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            if ($request->save_type == 'save') {
                // $this->validate($request, [
                //     'fullname' => 'required',
                //     'nrc' => 'required',
                //     'applied_phone' => ['required', 'min:9', 'max:11'],
                //     'jobType' => 'required',
                //     'applied_building_type' => 'required',
                //     'applied_home_no' => 'required',
                //     'applied_street' => 'required',
                //     'applied_quarter' => 'required',
                //     'township_id' => 'required',
                //     'district' => 'required',
                //     'region' => 'required',
                // ]);
            }
            $form_id = $request->form_id;
            $religion = $request->religion;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_phone = $request->applied_phone;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $serial_code = get_serial($div_state_id);

            if ($request->save_type == 'save') {
                $new = ApplicationForm::find($form_id);

                $new->serial_code = $serial_code;
                $new->is_religion = $religion ? 1 : 0;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->save();
                return redirect()->route('tsf_nrc_create_ygn', $form_id);
            } elseif ($request->save_type == 'draft') {
                $alrdy_draft = FormDraft::where('application_form_id', $form_id)->first();
                if ($alrdy_draft) {
                    $new = $alrdy_draft;
                } else {
                    $new = new FormDraft();
                }
                $new->application_form_id = $form_id;
                $new->is_religion = $religion ? 1 : 0;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->date = date('Y-m-d');
                $new->save();
                return redirect()->route('all_meter_forms');
            }
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_edit_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', 2)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if ($d_form) {
                    $form = $d_form;
                    $form->id = $form_id;
                }
            }
            return view('user.yangon.transformer.tsf_form_2_edit', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'form'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_update_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                // 'fullname' => 'required',
                // 'nrc' => 'required',
                // 'applied_phone' => 'required',
                // 'jobType' => 'required',
                // 'applied_building_type' => 'required',
                // 'applied_home_no' => 'required',
                // 'applied_street' => 'required',
                // 'applied_quarter' => 'required',
                // 'township_id' => 'required',
            ]);

            $form_id = $request->form_id;
            $religion = $request->religion;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $new = ApplicationForm::find($form_id);
            if (!$new->serial_code || ($new->div_state_id == null) || ( $new->div_state_id != $div_state_id )) {
                $new->serial_code = get_serial($div_state_id);
            }
            $new->is_religion = $religion ? 1 : 0;
            $new->fullname = $fullname;
            $new->nrc = $nrc;
            $new->applied_phone = $applied_phone;
            $new->job_type = $job_type;
            $new->position = $position;
            $new->department = $department;
            $new->salary = $salary ? $salary : 0;
            $new->applied_building_type = $applied_building_type;
            $new->applied_home_no = $applied_home_no;
            $new->applied_building = $applied_building;
            $new->applied_street = $applied_street;
            $new->applied_quarter = $applied_quarter;
            $new->applied_town = $applied_town;
            $new->township_id = $township_id;
            $new->district_id = $district_id;
            $new->div_state_id = $div_state_id;
            $new->save();
            return redirect()->route('tsf_applied_form_ygn', $form_id);
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_transformer_nrc_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            $form = ApplicationForm::find($form_id);
            if ($form->is_religion) {
                return view('user.yangon.transformer.tsf_form_3_religion', compact('active', 'form_id', 'heading'));
            } else {
                return view('user.yangon.transformer.tsf_form_3', compact('active', 'form_id', 'heading'));
            }
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_nrc_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png'],
                'back' => ['image', 'mimes:jpeg,jpg,png'],
            ]);
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
            
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->nrc_copy_front = $front_nrc;
            $new->nrc_copy_back = $back_nrc;
            $form->application_files()->save($new);

            if ($form->is_religion) {
                return redirect()->route('tsf_owner_create_ygn', $form->id);
            } else {
                return redirect()->route('tsf_form10_create_ygn', $form->id);
            }

        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_nrc_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            if ($form->is_religion) {
                return view('user.yangon.transformer.tsf_form_3_religion_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
            } else {
                return view('user.yangon.transformer.tsf_form_3_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
            }
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_nrc_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600);
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600);
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $new->save();
            }
            return redirect()->route('tsf_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_transformer_form10_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            return view('user.yangon.transformer.tsf_form_4', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_form10_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                'back.*'  => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            $front_form_10 = implode(',', $tmp_arr);

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
            }
            
            $new = $form->application_files()->first();
            $new->form_10_front = $front_form_10;
            $new->form_10_back = $back_form_10;
            $form->application_files()->save($new);
            return redirect()->route('tsf_recomm_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_form10_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.transformer.tsf_form_4_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_form10_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                'back.*'  => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
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
                $front_form_10 = implode(',', $tmp_arr);
            } else {
                $front_form_10 = null;
            }
            if ($request->hasFile('back')) {
                $tmp_arr = [];
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
            } else {
                $back_form_10 = null;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                if($front_form_10 != ''){
                    /* delete old file */
                    $old_fronts = explode(',',$new->form_10_front);
                    foreach($old_fronts as $old_front){
                        if (file_exists($path.'/'.$old_front)) {
                            File::delete($path.'/'.$old_front);
                        }
                    }
                    // update new
                    $new->form_10_front = $front_form_10;
                }
        
                if($back_form_10 != ''){
                    /* delete old file */
                    $old_backs = explode(',',$new->form_10_back);
                    foreach($old_backs as $old_back){
                        if (file_exists($path.'/'.$old_back)) {
                            File::delete($path.'/'.$old_back);
                        }
                    }
                    // update new
                    $new->form_10_back = $back_form_10;
                }
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $new->save();
            }
            return redirect()->route('tsf_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_transformer_recomm_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            return view('user.yangon.transformer.tsf_form_5', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_recomm_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required|mimes:jpeg,jpg,png',
                'back' => 'required|mimes:jpeg,jpg,png',
            ]);
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
            
            $new = $form->application_files()->first();
            $new->occupy_letter = $occupy;
            $new->no_invade_letter = $no_invade;
            $form->application_files()->save($new);
            return redirect()->route('tsf_owner_create_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_recomm_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.transformer.tsf_form_5_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_recomm_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $new->save();
            }
            return redirect()->route('tsf_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_transformer_owner_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            return view('user.yangon.transformer.tsf_form_6', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_owner_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->ownership = $img_str;
            $form->application_files()->save($new);
            if ($form->is_religion) {
                return redirect()->route('tsf_dcrecomm_create_ygn', $form->id);
            } else {
                return redirect()->route('tsf_worklicence_create_ygn', $form->id);
            }
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_owner_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.transformer.tsf_form_6_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_owner_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $tmp_arr = [];
            $old_front = $request->old_front;


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

                    /* delete old file */
                    if (file_exists($path.'/'.$old_front)) {
                        File::delete($path.'/'.$old_front);
                    }
                }
                $img_str = implode(',', $tmp_arr);
                
                $form_files = $form->application_files; /* retreive data from table to check */
                if ($form_files->count() > 0) {
                    $new = $form->application_files()->first();
                    $new->ownership = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->ownership = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('tsf_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    
    public function ygn_transformer_worklicence_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_transactionlicence_photo';
            $form = ApplicationForm::find($form_id);
            return view('user.yangon.transformer.tsf_form_7', compact('active', 'form_id', 'heading','form'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_worklicence_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // $this->validate($request, [
            //     'front' => 'required',
            // ]);
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

                $new = $form->application_files()->first();
                $new->transaction_licence = $img_str;
                $form->application_files()->save($new);
            }
            return redirect()->route('tsf_dcrecomm_create_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_worklicence_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_transactionlicence_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.transformer.tsf_form_7_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_worklicence_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->transaction_licence = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->transaction_licence = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('tsf_applied_form_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    
    public function ygn_transformer_dc_recomm_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_dc_recomm_photo';
            return view('user.yangon.transformer.tsf_form_8', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_dc_recomm_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->dc_recomm = $img_str;
            $form->application_files()->save($new);
            // return redirect()->route('tsf_applied_form_ygn', $form->id);
            return redirect()->route('tsf_farmland_create_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_dc_recomm_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_dc_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.transformer.tsf_form_8_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_dc_recomm_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->dc_recomm = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->dc_recomm = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('tsf_applied_form_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }

    // Yangon Transformer FarmLand start
    public function ygn_transformer_farmland_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'farmland_permit_header';
            return view('user.yangon.transformer.tsf_form_9', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_farmland_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['required','image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->farmland = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('tsf_industry_create_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_farmland_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'farmland_permit_header';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.transformer.tsf_form_9_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_farmland_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);

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
                    if($img_str != ""){
                        /* delete old file */
                        $olds = explode(',',$new->farmland);
                        foreach($olds as $old){
                            if (file_exists($path.'/'.$old)) {
                                File::delete($path.'/'.$old);
                            }
                        }
                        // update new
                        $new->farmland = $img_str;
                    }
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->farmland = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('tsf_applied_form_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    // Yangon Transformer FarmLand  FarmLand end

    // Yangon Transformer Industry Zone start
    public function ygn_transformer_industry_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'industry_zone_header';
            return view('user.yangon.transformer.tsf_form_10', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_industry_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['required','image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->industry = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('tsf_electricpower_create_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_industry_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'industry_zone_header';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.transformer.tsf_form_10_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_industry_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
                    if($img_str != ""){
                        /* delete old file */
                        $olds = explode(',',$new->industry);
                        foreach($olds as $old){
                            if (file_exists($path.'/'.$old)) {
                                File::delete($path.'/'.$old);
                            }
                        }
                        // update new
                        $new->industry = $img_str;
                    }
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->industry = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('tsf_applied_form_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    // Yangon Transformer Industry Zone  FarmLand end

    // electricpower start
    public function ygn_transformer_electricpower_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_electricpower_photo';
            return view('user.yangon.transformer.tsf_form_11', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_electricpower_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->electric_power = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('tsf_applied_form_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_electricpower_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_electricpower_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.yangon.transformer.tsf_form_11_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_electricpower_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {

            $this->validate($request, [
                'front.*' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            
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
                    /* delete old file */
                    if($new->electric_power != ""){
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
            }
            return redirect()->route('tsf_applied_form_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    // electricpower end

    public function ygn_transformer_show($form_id) {
        $active = 'overall';
        $heading = 'applied_detail';
        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');
        $fee = InitialCost::whereNotIn('name',['630','800','1500'])->where([['type', 4], ['sub_type', $form->apply_sub_type]])->first();
        // dd(chk_cdt($form->apply_type));
        return view('user/yangon/transformer/show', compact('active', 'heading', 'tbl_col_name', 'fee', 'form', 'files'));
    }

    /* For Yangon Division */
    /* =============================================================================================================== */

    /* =============================================================================================================== */
    /* For Mandalay Division */
    /* ------------------------------------------------------------------------- */
    /* Mandalay Residential Meter */
    public function reisdential_mdy_index() {
        $active = 'resident_app';
        return view('user.application_mdy', compact('active'));
    }
    
    public function mdy_residential_rule_regulation() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'rule_regulation';
            return view('user.mandalay.residential.rules_and_regulations', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_agreement() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'agreement';
            return view('user.mandalay.residential.agreement', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    /* Mandalay Residential Type start*/
    public function mdy_residential_select_meter_type() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('type', 1)->get();
            return view('user.mandalay.residential.residential_form_1', compact('active', 'fee_names', 'tbl_col_name'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_store_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $new = new ApplicationForm();
            $new->user_id = Auth::user()->id;
            $new->apply_type = 1;
            $new->apply_sub_type = $request->sub_type;
            $new->apply_division = 3;
            $new->date =  date('Y-m-d');
            $new->save();
            return redirect()->route('resident_user_info_mdy', $new->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_edit_meter_type($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('type', 1)->get();
            $form = ApplicationForm::find($form_id);
            return view('user.mandalay.residential.residential_form_1_edit', compact('active', 'fee_names', 'tbl_col_name', 'form'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_update_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;
            $new = ApplicationForm::find($form_id);
            if ($new->apply_sub_type !== $request->sub_type) {
                $new->apply_sub_type = $request->sub_type;
                $new->save();
            }
            return redirect()->route('resident_applied_form_mdy', $form_id);
        } else {
            return redirect()->route('home');
        }
    }
    /* Type end*/

    /* Mandalay Residential User Info start*/
    public function mdy_residential_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', '=', 3)->get();
            $draft_data = FormDraft::where('application_form_id', $form_id)->first();
            // dd($draft_data);
            return view('user.mandalay.residential.residential_form_2', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'draft_data'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_store_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            if ($request->save_type == 'save') {
                $this->validate($request, [
                    'fullname' => 'required',
                    'nrc' => 'required',
                    'applied_phone' => ['required', 'min:9', 'max:11'],
                    'jobType' => 'required',
                    'applied_building_type' => 'required',
                    'applied_home_no' => 'required',
                    'applied_street' => 'required',
                    'applied_quarter' => 'required',
                    'township_id' => 'required',
                    'district' => 'required',
                    'region' => 'required',
                ]);
            }
            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $serial_code = get_serial($div_state_id);

            if ($request->save_type == 'save') {
                $new = ApplicationForm::find($form_id);
                $new->serial_code = $serial_code;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->save();
                return redirect()->route('resident_nrc_create_mdy', $form_id);
            } elseif ($request->save_type == 'draft') {
                $alrdy_draft = FormDraft::where('application_form_id', $form_id)->first();
                if ($alrdy_draft) {
                    $new = $alrdy_draft;
                } else {
                    $new = new FormDraft();
                }
                $new->application_form_id = $form_id;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->date = date('Y-m-d');
                $new->save();
                return redirect()->route('all_meter_forms');
            }
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_edit_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', '=', 3)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if ($d_form) {
                    $form = $d_form;
                    $form->id = $form_id;
                }
            }
            return view('user.mandalay.residential.residential_form_2_edit', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'form'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_update_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'fullname' => 'required',
                'nrc' => 'required',
                'applied_phone' => 'required',
                'jobType' => 'required',
                'applied_building_type' => 'required',
                'applied_home_no' => 'required',
                'applied_street' => 'required',
                'applied_quarter' => 'required',
                'township_id' => 'required',
            ]);

            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $new = ApplicationForm::find($form_id);
            if (!$new->serial_code || ($new->div_state_id == null) || ( $new->div_state_id != $div_state_id )) {
                $serial_code = get_serial($div_state_id);
                $new->serial_code = $serial_code;
            }
            $new->fullname = $fullname;
            $new->nrc = $nrc;
            $new->applied_phone = $applied_phone;
            $new->job_type = $request->jobType;
            $new->position = $position;
            $new->department = $department;
            $new->salary = $salary ? $salary : 0;
            $new->applied_building_type = $applied_building_type;
            $new->applied_home_no = $applied_home_no;
            $new->applied_building = $applied_building;
            $new->applied_street = $applied_street;
            $new->applied_quarter = $applied_quarter;
            $new->applied_town = $applied_town;
            $new->township_id = $township_id;
            $new->district_id = $district_id;
            $new->div_state_id = $div_state_id;
            $new->save();
            return redirect()->route('resident_applied_form_mdy', $form_id);
        } else {
            return redirect()->route('home');
        }
    }
    /* User Info End */ 

    /* Mandalay Residential Nrc Start */ 
    public function mdy_residential_nrc_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            return view('user.mandalay.residential.residential_form_3', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_nrc_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png'],
                'back' => ['image', 'mimes:jpeg,jpg,png'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

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
            
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->nrc_copy_front = $front_nrc;
            $new->nrc_copy_back = $back_nrc;
            $form->application_files()->save($new);
            return redirect()->route('resident_form10_create_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_nrc_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.residential.residential_form_3_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_nrc_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front ? $request->old_front : NULL;
            $old_back = $request->old_back ? $request->old_back : NULL;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $new->save();
            }
            return redirect()->route('resident_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    /* Nrc End */ 

    /* Mandalay Residential  Form10 Start */ 
    public function mdy_residential_form10_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            return view('user.mandalay.residential.residential_form_4', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_form10_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                $constraint->aspectRatio();
            });
            $front_img->save($path.'/'.$front_form_10);
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
            } else {
                $back_form_10 = null;
            }
            
            $new = $form->application_files()->first();
            $new->form_10_front = $front_form_10;
            $new->form_10_back = $back_form_10;
            $form->application_files()->save($new);
            return redirect()->route('resident_recomm_create_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_form10_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.residential.residential_form_4_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_form10_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_form_10);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_form_10 = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
                
                /* delete old file */
                if ($old_back && file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_form_10 = $old_back;
            }
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $new->save();
            }
            return redirect()->route('resident_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    /* Form10 End */

    /* Mandalay Residential Recommanded Start */ 
    public function mdy_residential_recomm_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            return view('user.mandalay.residential.residential_form_5', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_recomm_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required|mimes:jpeg,jpg,png,pdf',
                'back' => 'required|mimes:jpeg,jpg,png,pdf',
            ]);
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
            
            $new = $form->application_files()->first();
            $new->occupy_letter = $occupy;
            $new->no_invade_letter = $no_invade;
            $form->application_files()->save($new);
            return redirect()->route('resident_owner_create_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_recomm_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.residential.residential_form_5_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_recomm_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $new->save();
            }
            return redirect()->route('resident_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    /* Recommanded End */ 
    /* Mandalay Residential Owner Start */ 
    public function mdy_residential_owner_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            return view('user.mandalay.residential.residential_form_6', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_owner_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);
            $new = $form->application_files()->first();
            // dd($new);
            $new->ownership = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('resident_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_owner_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.residential.residential_form_6_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_owner_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->ownership = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->ownership = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('resident_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    /* Owner End */ 

    /* View */
    public function mdy_residential_show($form_id) {
        $active = 'overall';
        $heading = 'applied_detail';
        $form = ApplicationForm::find($form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');
        $fee_names = InitialCost::where([['type', 1], ['sub_type', $form->apply_sub_type]])->get();
        return view('user.mandalay.residential.show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'form', 'files'));
    }
    /* Mandalay Residentialial Meter End */
    /* ------------------------------------------------------------------------ */

    /* ------------------------------------------------------------------------ */
    /* Mandalay Residential Power Meter */
    /* Mandalay Residential Power Rule Start */
    public function mdy_residential_power_rule_regulation() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'rule_regulation';
            return view('user.mandalay.residentialPower.rules_and_regulations', compact('active', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_agreement() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'agreement';
            return view('user.mandalay.residentialPower.agreement', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    /* Mandalay Residential Power Rule End */

    /* Mandalay Residential Power Type Start */
    public function mdy_residential_power_select_meter_type() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('type', 2)->get();
            return view('user.mandalay.residentialPower.residential_form_1', compact('active', 'fee_names', 'tbl_col_name'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_store_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $new = new ApplicationForm();
            $new->user_id = Auth::user()->id;
            $new->apply_type = 2;
            $new->apply_sub_type = $request->type;
            $new->apply_division = 3;
            $new->date = date('Y-m_d');
            $new->save();
            return redirect()->route('resident_power_user_info_mdy', $new->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_edit_meter_type($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('type', 2)->get();
            $form = ApplicationForm::find($form_id);
            return view('user.mandalay.residentialPower.residential_form_1_edit', compact('active', 'fee_names', 'tbl_col_name', 'form'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_update_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;
            $new = ApplicationForm::find($form_id);
            $new->apply_type = 2;
            $new->apply_sub_type = $request->type;
            $new->save();
            return redirect()->route('resident_power_applied_form_mdy', $form_id);
        } else {
            return redirect()->route('home');
        }
    }
    /* Mandalay Residential Power Type End */

    /* Mandalay Residential Power User Info Start */
    public function mdy_residential_power_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', '=', 3)->get();
            $draft_data = FormDraft::where('application_form_id', $form_id)->first();
            // dd($townships);
            return view('user.mandalay.residentialPower.residential_form_2', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'draft_data'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_store_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'fullname' => 'required',
                'nrc' => 'required',
                'applied_phone' => 'required',
                'jobType' => 'required',
                'applied_building_type' => 'required',
                'applied_home_no' => 'required',
                'applied_street' => 'required',
                'applied_quarter' => 'required',
                'township_id' => 'required',
            ]);

            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;
            $serial_code = get_serial($div_state_id);

            if ($request->save_type == 'save') {
                $new = ApplicationForm::find($form_id);
                $new->serial_code = $serial_code;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->save();
                return redirect()->route('resident_power_nrc_create_mdy', $form_id);
            } if ($request->save_type == 'draft') {
                $alrdy_draft = FormDraft::where('application_form_id', $form_id)->first();
                if ($alrdy_draft) {
                    $new = $alrdy_draft;
                } else {
                    $new = new FormDraft();
                }
                $new->application_form_id = $form_id;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->date = date('Y-m-d');
                $new->save();
                return redirect()->route('all_meter_forms');
            }
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_edit_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', '=', 3)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if ($d_form) {
                    $form = $d_form;
                    $form->id = $form_id;
                }
            }
            return view('user.mandalay.residentialPower.residential_form_2_edit', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'form'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_update_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'fullname' => 'required',
                'nrc' => 'required',
                'applied_phone' => 'required',
                'jobType' => 'required',
                'applied_building_type' => 'required',
                'applied_home_no' => 'required',
                'applied_street' => 'required',
                'applied_quarter' => 'required',
                'township_id' => 'required',
            ]);

            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $new = ApplicationForm::find($form_id);
            if (!$new->serial_code || ($new->div_state_id == null) || ( $new->div_state_id != $div_state_id )) {
                $new->serial_code = get_serial($div_state_id);
            }
            $new->fullname = $fullname;
            $new->nrc = $nrc;
            $new->applied_phone = $applied_phone;
            $new->job_type = $request->jobType;
            $new->position = $position;
            $new->department = $department;
            $new->salary = $salary ? $salary : 0;
            $new->applied_building_type = $applied_building_type;
            $new->applied_home_no = $applied_home_no;
            $new->applied_building = $applied_building;
            $new->applied_lane = $applied_lane;
            $new->applied_street = $applied_street;
            $new->applied_quarter = $applied_quarter;
            $new->applied_town = $applied_town;
            $new->township_id = $township_id;
            $new->district_id = $district_id;
            $new->div_state_id = $div_state_id;
            $new->save();
            return redirect()->route('resident_power_applied_form_mdy', $form_id);
        }else{
            return redirect()->route('home');
        }
    }
    /* Mandalay Residential Power User Info End */

    /* Mandalay Residential Power NRC Start */
    public function mdy_residential_power_nrc_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            return view('user.mandalay.residentialPower.residential_form_3', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_nrc_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                'back' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

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
            
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->nrc_copy_front = $front_nrc;
            $new->nrc_copy_back = $back_nrc;
            $form->application_files()->save($new);
            return redirect()->route('resident_power_form10_create_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_nrc_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.residentialPower.residential_form_3_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_nrc_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $new->save();
            }
            return redirect()->route('resident_power_applied_form_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    /* Mandalay Residential Power NRC End */

    /* Mandalay Residential Power Form10 Start */
    public function mdy_residential_power_form10_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            return view('user.mandalay.residentialPower.residential_form_4', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_form10_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_form_10);
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
            } else {
                $back_form_10 = null;
            }
            
            $new = $form->application_files()->first();
            $new->form_10_front = $front_form_10;
            $new->form_10_back = $back_form_10;
            $form->application_files()->save($new);
            return redirect()->route('resident_power_recomm_create_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_form10_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.residentialPower.residential_form_4_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_form10_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_form_10);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_form_10 = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
                
                /* delete old file */
                if ($old_back && file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_form_10 = $old_back;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $new->save();
            }
            return redirect()->route('resident_power_applied_form_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    /* Mandalay Residential Power Form10 End */

    /* Mandalay Residential Power Recommended Start */
    public function mdy_residential_power_recomm_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            return view('user.mandalay.residentialPower.residential_form_5', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_recomm_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required|mimes:jpeg,jpg,png,pdf',
                'back' => 'required|mimes:jpeg,jpg,png,pdf',
            ]);
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
            
            $new = $form->application_files()->first();
            $new->occupy_letter = $occupy;
            $new->no_invade_letter = $no_invade;
            $form->application_files()->save($new);
            return redirect()->route('resident_power_owner_create_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_recomm_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.residentialPower.residential_form_5_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_recomm_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $new->save();
            }
            return redirect()->route('resident_power_applied_form_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    /* Mandalay Residential Power Recommended End */
    
    /* Mandalay Residential Power Owner Start */
    public function mdy_residential_power_owner_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            return view('user.mandalay.residentialPower.residential_form_6', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_owner_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->ownership = $img_str;
            $form->application_files()->save($new);
            // return redirect()->route('resident_power_electricpower_create', $form->id);
            // return redirect()->route('resident_power_city_license_create_mdy', $form->id);
            return redirect()->route('resident_power_applied_form_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_owner_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.residentialPower.residential_form_6_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_owner_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->ownership = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->ownership = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('resident_power_applied_form_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    /* Mandalay Residential Power Owner End */

    /* Mandalay Residential City License Start */ 
    public function mdy_residential_power_city_license_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'apply_city_license';
            return view('user.mandalay.residentialPower.residential_form_8', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_city_license_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);
            $new = $form->application_files()->first();
            // dd($new);
            $new->city_license = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('resident_power_ministry_permit_create_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_city_license_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'apply_city_license';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.residentialPower.residential_form_8_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_city_license_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    if($new->city_license != ""){
                        // delete old files
                        $old_files = explode(',',$new->city_license);
                        foreach($old_files as $old_file){
                            if (file_exists(public_path('storage/user_attachments/'.$form->id).'/'.$old_file) && $old_file != '') {
                                unlink(public_path('storage/user_attachments/'.$form->id).'/'.$old_file);
                            }
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
            return redirect()->route('resident_power_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    /* City License End */ 
    /* Mandalay Residential Power Ministry Permit Start */ 
    public function mdy_residential_power_ministry_permit_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'apply_ministry_permit';
            return view('user.mandalay.residentialPower.residential_form_9', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_ministry_permit_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);
            $new = $form->application_files()->first();
            // dd($new);
            $new->ministry_permit = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('resident_power_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_ministry_permit_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'apply_ministry_permit';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.residentialPower.residential_form_9_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_ministry_permit_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
            return redirect()->route('resident_power_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    /* Mandalay Residential Power City License End */
    
    /* Mandalay Residential Power ElectricPower Start */
    public function mdy_residential_power_electricpower_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_electricpower_photo';
            return view('user.mandalay.residentialPower.residential_form_7', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_electricpower_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->electric_power = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('resident_power_applied_form_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_electricpower_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_electricpower_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.residentialPower.residential_form_7_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_residential_power_electricpower_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->electric_power = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->electric_power = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('resident_power_applied_form_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    /* Mandalay Residential Power ElectricPower End */

    public function mdy_residential_power_show($form_id) {
        $active = 'overall';
        $heading = 'applied_detail';
        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');
        $fee_names = InitialCost::where([['type', 2], ['sub_type', $form->apply_sub_type]])->get();
        return view('user.mandalay.residentialPower.show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'form', 'files'));
    }
    /* Mandalay Residentialial Power Meter End */
    /* ------------------------------------------------------------------------ */

    /* ------------------------------------------------------------------------ */
    /* Commercial Power Meter */
    /* Commercial Power Meter Rule Start*/
    public function mdy_commercial_rule_regulation() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'rule_regulation';
            return view('user.mandalay.commercialPower.rules_and_regulations', compact('active', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_power_agreement() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'agreement';
            return view('user.mandalay.commercialPower.agreement', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    /* Commercial Power Meter Rule End*/

    /* Commercial Power Meter Type Start*/
    public function mdy_commercial_select_meter_type() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('type', 3)->get();
            return view('user.mandalay.commercialPower.commercial_form_1', compact('active', 'fee_names', 'tbl_col_name'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_store_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $new = new ApplicationForm();
            $new->user_id = Auth::user()->id;
            $new->apply_division = 3;
            $new->apply_type = 3;
            $new->apply_sub_type = $request->type;
            $new->date = date('Y-m-d');
            $new->save();
            return redirect()->route('commercial_user_info_mdy', $new->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_edit_meter_type($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('type', 3)->get();
            $form = ApplicationForm::find($form_id);
            return view('user.mandalay.commercialPower.commercial_form_1_edit', compact('active', 'fee_names', 'tbl_col_name', 'form'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_update_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;
            $new = ApplicationForm::find($form_id);
            if ($new->apply_sub_type !== $request->sub_type) {
                $new->apply_sub_type = $request->sub_type;
                $new->save();
            }
            return redirect()->route('commercial_applied_form_mdy', $form_id);
        }else{
            return redirect()->route('home');
        }
    }
    /* Commercial Power Meter Type End*/
    
    /* Commercial Power Meter UserInfo Start*/
    public function mdy_commercial_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', '=', 3)->get();
            $draft_data = FormDraft::where('application_form_id', $form_id)->first();
            // dd($townships);
            return view('user.mandalay.commercialPower.commercial_form_2', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'draft_data'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_store_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'fullname' => 'required',
                'nrc' => 'required',
                'applied_phone' => 'required',
                'jobType' => 'required',
                'applied_building_type' => 'required',
                'applied_home_no' => 'required',
                'applied_street' => 'required',
                'applied_quarter' => 'required',
                'township_id' => 'required',
            ]);

            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;
            $serial_code = get_serial($div_state_id);

            if ($request->save_type == 'save') {
                $new = ApplicationForm::find($form_id);
                $new->serial_code = $serial_code;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->save();
                return redirect()->route('commercial_nrc_create_mdy', $form_id);
            } elseif ($request->save_type == 'draft') {
                $alrdy_draft = FormDraft::where('application_form_id', $form_id)->first();
                if ($alrdy_draft) {
                    $new = $alrdy_draft;
                } else {
                    $new = new FormDraft();
                }
                $new->application_form_id = $form_id;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->date = date('Y-m-d');
                $new->save();
                return redirect()->route('all_meter_forms');
            }
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_edit_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', '=', 3)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if ($d_form) {
                    $form = $d_form;
                    $form->id = $form_id;
                }
            }
            return view('user.mandalay.commercialPower.commercial_form_2_edit', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'form'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_update_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'fullname' => 'required',
                'nrc' => 'required',
                'applied_phone' => 'required',
                'applied_building_type' => 'required',
                'applied_home_no' => 'required',
                'applied_street' => 'required',
                'applied_quarter' => 'required',
                'township_id' => 'required',
            ]);

            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $new = ApplicationForm::find($form_id);
            if (!$new->serial_code || ($new->div_state_id == null) || ( $new->div_state_id != $div_state_id )) {
                $new->serial_code = get_serial($div_state_id);
            }
            $new->fullname = $fullname;
            $new->nrc = $nrc;
            $new->applied_phone = $applied_phone;
            $new->job_type = $request->jobType;
            $new->position = $position;
            $new->department = $department;
            $new->salary = $salary ? $salary : 0;
            $new->applied_building_type = $applied_building_type;
            $new->applied_home_no = $applied_home_no;
            $new->applied_building = $applied_building;
            $new->applied_lane = $applied_lane;
            $new->applied_street = $applied_street;
            $new->applied_quarter = $applied_quarter;
            $new->applied_town = $applied_town;
            $new->township_id = $township_id;
            $new->district_id = $district_id;
            $new->div_state_id = $div_state_id;
            $new->save();
            return redirect()->route('commercial_applied_form_mdy', $form_id);
        }else{
            return redirect()->route('home');
        }
    }
    /* Commercial Power Meter UserInfo End*/
    
    /* Commercial Power Meter NRC Start*/
    public function mdy_commercial_nrc_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            return view('user.mandalay.commercialPower.commercial_form_3', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_nrc_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                'back' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);

            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

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
            
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->nrc_copy_front = $front_nrc;
            $new->nrc_copy_back = $back_nrc;
            $form->application_files()->save($new);
            return redirect()->route('commercial_form10_create_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_nrc_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.commercialPower.commercial_form_3_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_nrc_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $new->save();
            }
            return redirect()->route('commercial_applied_form_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    /* Commercial Power Meter NRC End*/
    
    /* Commercial Power Meter Form10 Start*/
    public function mdy_commercial_form10_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            return view('user.mandalay.commercialPower.commercial_form_4', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_form10_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_form_10);
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
            } else {
                $back_form_10 = null;
            }
            
            $new = $form->application_files()->first();
            $new->form_10_front = $front_form_10;
            $new->form_10_back = $back_form_10;
            $form->application_files()->save($new);
            return redirect()->route('commercial_recomm_create_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_form10_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.commercialPower.commercial_form_4_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_form10_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_form_10);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_form_10 = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
                
                /* delete old file */
                if ($old_back && file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_form_10 = $old_back;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $new->save();
            }
            return redirect()->route('commercial_applied_form_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    /* Commercial Power Meter Form10 End*/
    
    /* Commercial Power Meter Recommended Start*/
    public function mdy_commercial_recomm_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            return view('user.mandalay.commercialPower.commercial_form_5', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_recomm_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required|mimes:jpeg,jpg,png,pdf',
                'back' => 'required|mimes:jpeg,jpg,png,pdf',
            ]);
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
            
            $new = $form->application_files()->first();
            $new->occupy_letter = $occupy;
            $new->no_invade_letter = $no_invade;
            $form->application_files()->save($new);
            return redirect()->route('commercial_owner_create_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_recomm_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.commercialPower.commercial_form_5_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_recomm_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $new->save();
            }
            return redirect()->route('commercial_applied_form_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    /* Commercial Power Meter Recommended End*/
    
    /* Commercial Power Meter Owner Start*/
    public function mdy_commercial_owner_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            return view('user.mandalay.commercialPower.commercial_form_6', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_owner_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->ownership = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('commercial_worklicence_create_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_owner_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.commercialPower.commercial_form_6_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_owner_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->ownership = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->ownership = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('commercial_applied_form_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    /* Commercial Power Meter Owner End*/
    
    /* Commercial Power Meter Worklicence Start*/
    public function mdy_commercial_worklicence_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_transactionlicence_photo';
            return view('user.mandalay.commercialPower.commercial_form_7', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_worklicence_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->transaction_licence = $img_str;
            $form->application_files()->save($new);
            // return redirect()->route('commercial_applied_form_mdy', $form->id);
            return redirect()->route('commercial_power_city_license_create_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_worklicence_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_transactionlicence_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.commercialPower.commercial_form_7_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_worklicence_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->transaction_licence = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->transaction_licence = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('commercial_applied_form_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    /* Commercial Power Meter Worklicence End*/

    /* Mandalay Residential City License Start */ 
    public function mdy_commercial_power_city_license_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'apply_city_license';
            return view('user.mandalay.commercialPower.commercial_form_9', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_power_city_license_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);
            $new = $form->application_files()->first();
            // dd($new);
            $new->city_license = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('commercial_power_ministry_permit_create_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_power_city_license_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'apply_city_license';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.commercialPower.commercial_form_9_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_power_city_license_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    if($new->city_license != ""){
                        // delete old files
                        $old_files = explode(',',$new->city_license);
                        foreach($old_files as $old_file){
                            if (file_exists(public_path('storage/user_attachments/'.$form->id).'/'.$old_file) && $old_file != '') {
                                unlink(public_path('storage/user_attachments/'.$form->id).'/'.$old_file);
                            }
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
            return redirect()->route('commercial_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    /* City License End */ 
    /* Mandalay Residential Power Ministry Permit Start */ 
    public function mdy_commercial_power_ministry_permit_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'apply_ministry_permit';
            return view('user.mandalay.commercialPower.commercial_form_10', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_power_ministry_permit_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);
            $new = $form->application_files()->first();
            // dd($new);
            $new->ministry_permit = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('commercial_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_power_ministry_permit_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'apply_ministry_permit';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.commercialPower.commercial_form_10_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_power_ministry_permit_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
            return redirect()->route('commercial_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    /* Mandalay Residential Power City License End */
    
    /* Commercial Power Meter ElectricPower Start*/
    public function mdy_commercial_electricpower_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_electricpower_photo';
            return view('user.mandalay.commercialPower.commercial_form_8', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_electricpower_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->electric_power = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('commercial_applied_form_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_electricpower_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_electricpower_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.commercialPower.commercial_form_8_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        }else{
            return redirect()->route('home');
        }
    }
    public function mdy_commercial_electricpower_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->electric_power = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->electric_power = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('commercial_applied_form_mdy', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    /* Commercial Power Meter ElectricPower End*/

    public function mdy_commercial_show($form_id) {
        $active = 'overall';
        $heading = 'applied_detail';
        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');
        $fee_names = InitialCost::where([['type', 3], ['sub_type', $form->apply_sub_type]])->get();
        return view('user.mandalay.commercialPower.show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'form', 'files'));
    }
    /* Commercial Power Meter End */
    /* ------------------------------------------------------------------------ */

    /* Mandalay Contractor Meter */
    /* Mandalay Contractor Meter Rule Start */
    public function mdy_contractor_rule_regulation() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'rule_regulation';
            return view('user.mandalay.contractor.rules_and_regulations', compact('active', 'heading'));
            // return 'ok';
        } else {
            return redirect()->route('home');
        }
    }

    public function mdy_contractor_agreement() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'agreement';
            return view('user.mandalay.contractor.agreement', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    /* Mandalay Contractor Meter Rule End */

    /* Mandalay Contractor Meter Building Start */
    public function mdy_contractor_building_room() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            return view('user.mandalay.contractor.two_buildings', compact('active'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_contractor_building(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [ 
                'room_count' => 'required|numeric|min:4'
            ]);
            $room_count = $request->room_count;
            $pMeter10 = $request->pMeter10;
            $pMeter20 = $request->pMeter20;
            $pMeter30 = $request->pMeter30;
            $meter = $request->meter;
            $water_meter = $request->water_meter;
            if ($water_meter == 'on') {
                $water_meter = true;
            } else {
                $water_meter = false;
            }
            $elevator_meter = $request->elevator_meter;
            if ($elevator_meter == 'on') {
                $elevator_meter = true;
            } else {
                $elevator_meter = false;
            }
            
            $new = new ApplicationForm();
            $new->user_id = Auth::user()->id;
            $new->apply_type = 5;
            $new->apply_sub_type = 1;
            $new->apply_division = 3;
            $new->date = date('Y-m-d');
            $new->save();

            $c_form = new ApplicationFormContractor();
            $c_form->application_form_id = $new->id;
            $c_form->room_count = $room_count;
            $c_form->pMeter10 = $pMeter10;
            $c_form->pMeter20 = $pMeter20;
            $c_form->pMeter30 = $pMeter30;
            $c_form->meter = $meter;
            $c_form->water_meter = $water_meter;
            $c_form->elevator_meter = $elevator_meter;
            $c_form->save();
            
            // if ($sub_type == 1) {
                return redirect()->route('417_user_info_mdy', $new->id);
            // } else {
                // return redirect()->route('18_user_info_ygn', $new->id);
            // }
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_contractor_building_room_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $c_form = ApplicationFormContractor::where('application_form_id', $form_id)->first();
            return view('user.mandalay.contractor.two_buildings_edit', compact('active','c_form'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_contractor_building_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [ 
                'room_count' => 'required|numeric|min:4'
            ]);
            $form_id = $request->form_id;
            $room_count = $request->room_count;
            $pMeter10 = $request->pMeter10;
            $pMeter20 = $request->pMeter20;
            $pMeter30 = $request->pMeter30;
            $meter = $request->meter;
            $water_meter = $request->water_meter;
            if ($water_meter == 'on') {
                $water_meter = true;
            } else {
                $water_meter = false;
            }
            $elevator_meter = $request->elevator_meter;
            if ($elevator_meter == 'on') {
                $elevator_meter = true;
            } else {
                $elevator_meter = false;
            }

            $c_form = ApplicationFormContractor::where('application_form_id', $form_id)->first();
            $c_form->room_count = $room_count;
            $c_form->pMeter10 = $pMeter10;
            $c_form->pMeter20 = $pMeter20;
            $c_form->pMeter30 = $pMeter30;
            $c_form->meter = $meter;
            $c_form->water_meter = $water_meter;
            $c_form->elevator_meter = $elevator_meter;
            $c_form->save();
            
            // if ($sub_type == 1) {
                return redirect()->route('contractor_applied_form_mdy', $form_id);
            // } else {
                // return redirect()->route('18_user_info_ygn', $new->id);
            // }
        } else {
            return redirect()->route('home');
        }
    }
    /* Mandalay Contractor Meter Building Start */

    /* 4 to 17 rooms */
    public function mdy_room_417_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', '=', 3)->get();
            $draft_data = FormDraft::where('application_form_id', $form_id)->first();
            return view('user.mandalay.contractor.4_17_form_1', compact('active', 'heading', 'form_id', 'regions', 'districts', 'townships', 'draft_data'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_store_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            if ($request->save_type == 'save') {
                // $this->validate($request, [
                //     'fullname' => 'required',
                //     'nrc' => 'required',
                //     'applied_phone' => ['required', 'min:9', 'max:11'],
                //     'applied_building_type' => 'required',
                //     'applied_home_no' => 'required',
                //     'applied_street' => 'required',
                //     'applied_quarter' => 'required',
                //     'township_id' => 'required',
                //     'district' => 'required',
                //     'region' => 'required',
                // ]);
            }
            $form_id = $request->form_id;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $serial_code = get_serial($div_state_id);

            if ($request->save_type == 'save') {
                $new = ApplicationForm::find($form_id);
                $new->serial_code = $serial_code;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->save();
                return redirect()->route('417_nrc_create_mdy', $form_id);
            } elseif ($request->save_type == 'draft') {
                $alrdy_draft = FormDraft::where('application_form_id', $form_id)->first();
                if ($alrdy_draft) {
                    $new = $alrdy_draft;
                } else {
                    $new = new FormDraft();
                }
                $new->application_form_id = $form_id;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->date = date('Y-m-d');
                $new->save();
                return redirect()->route('all_meter_forms');
            }
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_edit_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::where('id', 3)->get();
            $districts = District::where('division_state_id', '=', 3)->get();
            $townships = Township::where('division_state_id', '=', 3)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if ($d_form) {
                    $form = $d_form;
                    $form->id = $form_id;
                }
            }
            return view('user.mandalay.contractor.4_17_form_1_edit', compact('active', 'heading', 'form_id', 'regions', 'districts', 'townships', 'form'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_update_user_information(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'fullname' => 'required',
                'nrc' => 'required',
                'applied_phone' => ['required', 'min:9', 'max:11'],
                'applied_home_no' => 'required',
                'applied_street' => 'required',
                'applied_quarter' => 'required',
                'township_id' => 'required',
                'district' => 'required',
                'region' => 'required',
            ]);
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

            $new = ApplicationForm::find($form_id);
            if (!$new->serial_code || ($new->div_state_id == null) || ( $new->div_state_id != $div_state_id )) {
                $new->serial_code = get_serial($div_state_id);
            }
            $new->fullname = $fullname;
            $new->nrc = $nrc;
            $new->applied_phone = $applied_phone;
            $new->applied_home_no = $applied_home_no;
            $new->applied_lane = $applied_lane;
            $new->applied_street = $applied_street;
            $new->applied_quarter = $applied_quarter;
            $new->applied_town = $applied_town;
            $new->township_id = $township_id;
            $new->district_id = $district_id;
            $new->div_state_id = $div_state_id;
            $new->date = date('Y-m-d');
            $new->save();
            return redirect()->route('contractor_applied_form_mdy', $form_id);
        } else {
            return redirect()->route('home');
        }
    }

    public function mdy_room_417_nrc_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            return view('user.mandalay.contractor.4_17_form_2', compact('active', 'heading', 'form_id'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_nrc_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                'back' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);

            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

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
            
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->nrc_copy_front = $front_nrc;
            $new->nrc_copy_back = $back_nrc;
            $form->application_files()->save($new);
            return redirect()->route('417_form10_create_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_nrc_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_file_nrc';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.contractor.4_17_form_2_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_nrc_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $new->save();
            }
            return redirect()->route('contractor_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function mdy_room_417_form10_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            return view('user.mandalay.contractor.4_17_form_3', compact('active', 'heading', 'form_id'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_form10_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_form_10);
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
            } else {
                $back_form_10 = null;
            }
            
            $new = $form->application_files()->first();
            $new->form_10_front = $front_form_10;
            $new->form_10_back = $back_form_10;
            $form->application_files()->save($new);
            return redirect()->route('417_recomm_create_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_form10_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.contractor.4_17_form_3_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_form10_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_form_10);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_form_10 = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
                
                /* delete old file */
                if ($old_back && file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_form_10 = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $new->save();
            }
            return redirect()->route('contractor_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function mdy_room_417_recomm_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            return view('user.mandalay.contractor.4_17_form_4', compact('active', 'heading', 'form_id'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_recomm_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
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
            
            $new = $form->application_files()->first();
            $new->occupy_letter = $occupy;
            $new->no_invade_letter = $no_invade;
            $form->application_files()->save($new);
            $form->application_files()->save($new);
            return redirect()->route('417_owner_create_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_recomm_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.contractor.4_17_form_4_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_recomm_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $occupy_img = Image::make($request->file('front'));
                $occupy = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $occupy_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $occupy_img->save($path.'/'.$occupy);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $occupy = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $no_invade_img = Image::make($request->file('back'));
                $no_invade = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $no_invade_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $no_invade_img->save($path.'/'.$no_invade);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $no_invade = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();

                $form->application_files()->save($new);
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->occupy_letter = $occupy;
                $new->no_invade_letter = $no_invade;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->occupy_letter = $occupy;
                $new->no_invade_letter = $no_invade;
                $new->save();
            }
            return redirect()->route('contractor_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }


    public function mdy_room_417_owner_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            return view('user.mandalay.contractor.4_17_form_5', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_owner_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->ownership = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('417_permit_create_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_owner_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.contractor.4_17_form_5_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_owner_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->ownership = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->ownership = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('contractor_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function mdy_room_417_permit_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_permit_photo';
            return view('user.mandalay.contractor.4_17_form_6', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_permit_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_permit = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_permit);
            
            $new = $form->application_files()->first();
            $new->building_permit = $front_permit;
            $form->application_files()->save($new);
            return redirect()->route('417_bcc_create_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_permit_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_permit_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.contractor.4_17_form_6_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_permit_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $permit = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$permit);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $permit = $old_front;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->building_permit = $permit;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->building_permit = $permit;
                $new->save();
            }
            return redirect()->route('contractor_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function mdy_room_417_bcc_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_bcc_photo';
            return view('user.mandalay.contractor.4_17_form_7', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_bcc_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_bcc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_bcc);
            
            $new = $form->application_files()->first();
            $new->bcc = $front_bcc;
            $form->application_files()->save($new);
            return redirect()->route('417_dc_recomm_create_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_bcc_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_bcc_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.contractor.4_17_form_7_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_bcc_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $bcc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$bcc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $bcc = $old_front;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->bcc = $bcc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->bcc = $bcc;
                $new->save();
            }
            return redirect()->route('contractor_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function mdy_room_417_dc_recomm_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_dc_recomm_photo';
            return view('user.mandalay.contractor.4_17_form_8', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_dc_recomm_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_dc_recomm = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_dc_recomm);
            
            $new = $form->application_files()->first();
            $new->dc_recomm = $front_dc_recomm;
            $form->application_files()->save($new);
            return redirect()->route('417_bill_create_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_dc_recomm_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_dc_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.contractor.4_17_form_8_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_dc_recomm_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $dc_recomm = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$dc_recomm);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $dc_recomm = $old_front;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->dc_recomm = $dc_recomm;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->dc_recomm = $dc_recomm;
                $new->save();
            }
            return redirect()->route('contractor_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function mdy_room_417_bill_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_bill_photo';
            return view('user.mandalay.contractor.4_17_form_9', compact('active', 'form_id', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_bill_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_bill = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_bill);
            
            $new = $form->application_files()->first();
            $new->prev_bill = $front_bill;
            $form->application_files()->save($new);
            return redirect()->route('contractor_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_bill_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_bill_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.contractor.4_17_form_9_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        } else {
            return redirect()->route('home');
        }
    }
    public function mdy_room_417_bill_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $prev_bill = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$prev_bill);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $prev_bill = $old_front;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->prev_bill = $prev_bill;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->prev_bill = $prev_bill;
                $new->save();
            }
            return redirect()->route('contractor_applied_form_mdy', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

    public function mdy_contractor_show($form_id) {
        $active = 'overall';
        $heading = 'applied_detail';
        $form = ApplicationForm::orderBy('date', 'desc')->find($form_id);
        $c_form = ApplicationFormContractor::where('application_form_id', $form_id)->first();
        $files = $form->application_files;
        return view('user.mandalay.contractor.show', compact('active', 'heading', 'form', 'files', 'c_form'));
    }
    /* Mandalay Contractor Meter End */
    /* ------------------------------------------------------------------------ */
    /* Contractor Meter End */
    /* ------------------------------------------------------------------------ */

    /* ------------------------------------------------------------------------ */
    /* Transformer Start */
    public function mdy_transformer_rule_regulation() {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'rule_regulation';
            return view('user.mandalay.transformer.rules_and_regulations', compact('active', 'heading'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_agreement() {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'agreement';
            return view('user.mandalay.transformer.agreement', compact('active', 'heading'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_agreement_one() {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'agreement';
            return view('user.mandalay.transformer.agreement_one', compact('active', 'heading'));
        // } else {
        //     return redirect()->route('home');
        // }
    }

    public function mdy_transformer_select_meter_type() {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('building_fee','!=',null)->where('type', 4)->get();
            return view('user.mandalay.transformer.tsf_form_1', compact('active', 'fee_names', 'tbl_col_name'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_store_meter_type(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $new = new ApplicationForm();
            $new->user_id = Auth::user()->id;
            $new->apply_type = 4;
            $new->apply_sub_type = $request->sub_type;
            $new->apply_division = 3;
            $new->date = date('Y-m-d');
            $new->save();
            return redirect()->route('tsf_user_info_mdy', $new->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_edit_meter_type($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('building_fee','!=',null)->where('type', 4)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if($d_form){
                    $form = $d_form;
                    $form->id = $form_id;
                }
                $form->apply_sub_type = $app_form->apply_sub_type;
            }
            return view('user.mandalay.transformer.tsf_form_1_edit', compact('active', 'fee_names', 'tbl_col_name', 'form'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_update_meter_type(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;
            $new = ApplicationForm::find($form_id);
            if ($new->apply_sub_type !== $request->sub_type) {
                $new->apply_sub_type = $request->sub_type;
                $new->save();
            }
            return redirect()->route('tsf_applied_form_mdy', $form_id);
        // } else {
        //     return redirect()->route('home');
        // }
    }

    public function mdy_transformer_user_information($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', '=', 3)->get();
            $draft_data = FormDraft::where('application_form_id', $form_id)->first();
            // dd($draft_data);
            return view('user.mandalay.transformer.tsf_form_2', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'draft_data'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_store_user_information(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            if ($request->save_type == 'save') {
                // $this->validate($request, [
                //     'fullname' => 'required',
                //     'nrc' => 'required',
                //     'applied_phone' => ['required', 'min:9', 'max:11'],
                //     'jobType' => 'required',
                //     'applied_building_type' => 'required',
                //     'applied_home_no' => 'required',
                //     'applied_street' => 'required',
                //     'applied_quarter' => 'required',
                //     'township_id' => 'required',
                //     'district' => 'required',
                //     'region' => 'required',
                // ]);
            }
            $form_id = $request->form_id;
            $religion = $request->religion;
            $is_light = $request->is_light;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $business_name = $request->business_name;
            $department = $request->dep;
            $applied_phone = $request->applied_phone;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_lane = $request->applied_lane;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $serial_code = get_serial($div_state_id);

            if ($request->save_type == 'save') {
                $new = ApplicationForm::find($form_id);

                $new->serial_code = $serial_code;
                $new->is_religion = $religion ? 1 : 0;
                $new->is_light = $is_light ? 1 : 0;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->business_name = $business_name;
                $new->save();
                return redirect()->route('tsf_nrc_create_mdy', $form_id);
            } elseif ($request->save_type == 'draft') {
                $alrdy_draft = FormDraft::where('application_form_id', $form_id)->first();
                if ($alrdy_draft) {
                    $new = $alrdy_draft;
                } else {
                    $new = new FormDraft();
                }
                $new->application_form_id = $form_id;
                $new->fullname = $fullname;
                $new->nrc = $nrc;
                $new->applied_phone = $applied_phone;
                $new->job_type = $request->jobType;
                $new->position = $position;
                $new->department = $department;
                $new->salary = $salary ? $salary : 0;
                $new->applied_building_type = $applied_building_type;
                $new->applied_home_no = $applied_home_no;
                $new->applied_building = $applied_building;
                $new->applied_lane = $applied_lane;
                $new->applied_street = $applied_street;
                $new->applied_quarter = $applied_quarter;
                $new->applied_town = $applied_town;
                $new->township_id = $township_id;
                $new->district_id = $district_id;
                $new->div_state_id = $div_state_id;
                $new->date = date('Y-m-d');
                $new->business_name = $business_name;
                $new->save();
                return redirect()->route('all_meter_forms');
            }
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_edit_user_information($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', '=', 3)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if ($d_form) {
                    $form = $d_form;
                    $form->id = $form_id;
                }
            }
            return view('user.mandalay.transformer.tsf_form_2_edit', compact('active', 'form_id', 'heading', 'regions', 'districts', 'townships', 'form'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_update_user_information(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'fullname' => 'required',
                'nrc' => 'required',
                'applied_phone' => 'required',
                // 'jobType' => 'required',
                'applied_building_type' => 'required',
                // 'applied_home_no' => 'required',
                'applied_street' => 'required',
                'applied_quarter' => 'required',
                'township_id' => 'required',
            ]);

            $form_id = $request->form_id;
            $religion = $request->religion;
            $is_light = $request->is_light;
            $fullname = $request->fullname;
            $nrc = $request->nrc;
            $applied_phone = $request->applied_phone;
            $job_type = $request->jobType;
            if ($job_type == 'other') {
                $position = $request->other;
                $salary = $request->otherSalary;
            } else {
                $position = $request->pos;
                $salary = $request->salary;
            }
            $business_name = $request->business_name;
            $department = $request->dep;
            $applied_building_type = $request->applied_building_type;
            $applied_home_no = $request->applied_home_no;
            $applied_building = $request->applied_building;
            $applied_street = $request->applied_street;
            $applied_quarter = $request->applied_quarter;
            $applied_town = $request->applied_town;
            $township_id = $request->township_id;
            $district_id = $request->district_id;
            $div_state_id = $request->div_state_id;

            $new = ApplicationForm::find($form_id);
            if (!$new->serial_code || ($new->div_state_id == null) || ( $new->div_state_id != $div_state_id )) {
                $new->serial_code = get_serial($div_state_id);
            }
            $new->fullname = $fullname;
            $new->is_religion = $religion ? 1 : 0;
            $new->is_light = $is_light ? 1 : 0;
            $new->nrc = $nrc;
            $new->applied_phone = $applied_phone;
            $new->job_type = $job_type;
            $new->position = $position;
            $new->department = $department;
            $new->salary = $salary ? $salary : 0;
            $new->applied_building_type = $applied_building_type;
            $new->applied_home_no = $applied_home_no;
            $new->applied_building = $applied_building;
            $new->applied_street = $applied_street;
            $new->applied_quarter = $applied_quarter;
            $new->applied_town = $applied_town;
            $new->township_id = $township_id;
            $new->district_id = $district_id;
            $new->div_state_id = $div_state_id;
            $new->business_name = $business_name;
            $new->save();
            return redirect()->route('tsf_applied_form_mdy', $form_id);
        // } else {
        //     return redirect()->route('home');
        // }
    }

    public function mdy_transformer_nrc_create($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'nrc_or_religious_card';
            return view('user.mandalay.transformer.tsf_form_3', compact('active', 'form_id', 'heading'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_nrc_store(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png'],
                'back' => ['image', 'mimes:jpeg,jpg,png'],
            ]);
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
            
            $new = new ApplicationFile();
            $new->application_form_id = $form->id;
            $new->nrc_copy_front = $front_nrc;
            $new->nrc_copy_back = $back_nrc;
            $form->application_files()->save($new);
            return redirect()->route('tsf_form10_create_mdy', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_nrc_edit($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'nrc_or_religious_card';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.transformer.tsf_form_3_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_nrc_update(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600);
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600);
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if (file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_nrc = $old_back;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->nrc_copy_front = $front_nrc;
                $new->nrc_copy_back = $back_nrc;
                $new->save();
            }
            return redirect()->route('tsf_applied_form_mdy', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }

    public function mdy_transformer_form10_create($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            return view('user.mandalay.transformer.tsf_form_4', compact('active', 'form_id', 'heading'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_form10_store(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);

            $front_ext = $request->file('front')->getClientOriginalExtension();
            $front_img = Image::make($request->file('front'));
            $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
            $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
            $front_img->save($path.'/'.$front_form_10);
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
            } else {
                $back_form_10 = null;
            }
            
            $new = $form->application_files()->first();
            $new->form_10_front = $front_form_10;
            $new->form_10_back = $back_form_10;
            $form->application_files()->save($new);
            return redirect()->route('tsf_recomm_create_mdy', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_form10_edit($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_form10';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.transformer.tsf_form_4_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_form10_update(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
            ]);
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_form_10 = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_form_10);

                /* delete old file */
                if (file_exists($path.'/'.$old_front)) {
                    File::delete($path.'/'.$old_front);
                }
            } else {
                $front_form_10 = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_form_10 = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_form_10);
                
                /* delete old file */
                if ($old_back && file_exists($path.'/'.$old_back)) {
                    File::delete($path.'/'.$old_back);
                }
            } else {
                $back_form_10 = $old_back;
            }
            
            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->form_10_front = $front_form_10;
                $new->form_10_back = $back_form_10;
                $new->save();
            }
            return redirect()->route('tsf_applied_form_mdy', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }

    public function mdy_transformer_recomm_create($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            return view('user.mandalay.transformer.tsf_form_5', compact('active', 'form_id', 'heading'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_recomm_store(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required|mimes:jpeg,jpg,png',
                'back' => 'required|mimes:jpeg,jpg,png',
            ]);
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
            
            $new = $form->application_files()->first();
            $new->occupy_letter = $occupy;
            $new->no_invade_letter = $no_invade;
            $form->application_files()->save($new);
            return redirect()->route('tsf_owner_create_mdy', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_recomm_edit($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.transformer.tsf_form_5_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_recomm_update(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $old_front = $request->old_front;
            $old_back = $request->old_back;

            if ($request->hasFile('front')) {
                $front_ext = $request->file('front')->getClientOriginalExtension();
                $front_img = Image::make($request->file('front'));
                $front_nrc = get_random_string().'_'.getdate()[0].'.'.$front_ext;
                $front_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $front_img->save($path.'/'.$front_nrc);

                /* delete old file */
                if ($old_front) {
                    if (file_exists($path.'/'.$old_front)) {
                        File::delete($path.'/'.$old_front);
                    }
                }
            } else {
                $front_nrc = $old_front;
            }
            if ($request->hasFile('back')) {
                $back_ext = $request->file('back')->getClientOriginalExtension();
                $back_img = Image::make($request->file('back'));
                $back_nrc = get_random_string().'_'.getdate()[0].'.'.$back_ext;
                $back_img->resize(1600, 1600, function($constraint) {
                    $constraint->aspectRatio();
                });
                $back_img->save($path.'/'.$back_nrc);

                /* delete old file */
                if ($old_back) {
                    if (file_exists($path.'/'.$old_back)) {
                        File::delete($path.'/'.$old_back);
                    }
                }
            } else {
                $back_nrc = $old_back;
            }

            $form_files = $form->application_files; /* retreive data from table to check */
            if ($form_files->count() > 0) {
                $new = $form->application_files()->first();
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $form->application_files()->save($new);
            } else {
                $new = new ApplicationFile();
                $new->application_form_id = $form->id;
                $new->occupy_letter = $front_nrc;
                $new->no_invade_letter = $back_nrc;
                $new->save();
            }
            return redirect()->route('tsf_applied_form_mdy', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }

    public function mdy_transformer_owner_create($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            return view('user.mandalay.transformer.tsf_form_6', compact('active', 'form_id', 'heading'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_owner_store(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->ownership = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('tsf_worklicence_create_mdy', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_owner_edit($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_other_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.transformer.tsf_form_6_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_owner_update(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($request->form_id);
            
            if (!is_dir(public_path('storage/user_attachments'))) {
                @mkdir(public_path('storage/user_attachments'));
            }
            
            if (!is_dir(public_path('storage/user_attachments/'.$form->id))) {
                @mkdir(public_path('storage/user_attachments/'.$form->id));
            }
            $path = public_path('storage/user_attachments/'.$form->id);
            $tmp_arr = [];
            $old_front = $request->old_front;

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

                    /* delete old file */
                    if (file_exists($path.'/'.$old_front)) {
                        File::delete($path.'/'.$old_front);
                    }
                }
                $img_str = implode(',', $tmp_arr);
                
                $form_files = $form->application_files; /* retreive data from table to check */
                if ($form_files->count() > 0) {
                    $new = $form->application_files()->first();
                    $new->ownership = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->ownership = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('tsf_applied_form_mdy', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }
    
    public function mdy_transformer_worklicence_create($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_transactionlicence_photo';
            return view('user.mandalay.transformer.tsf_form_7', compact('active', 'form_id', 'heading'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_worklicence_store(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            // $this->validate($request, [
            //     'front' => 'required',
            // ]);
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

                $new = $form->application_files()->first();
                $new->transaction_licence = $img_str;
                $form->application_files()->save($new);
            }
            return redirect()->route('tsf_electricpower_create_mdy', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_worklicence_edit($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_transactionlicence_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.transformer.tsf_form_7_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_worklicence_update(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->transaction_licence = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->transaction_licence = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('tsf_applied_form_mdy', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }
    
    public function mdy_transformer_electricpower_create($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_dc_recomm_photo';
            return view('user.mandalay.transformer.tsf_form_8', compact('active', 'form_id', 'heading'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_electricpower_store(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'front' => 'required',
            ]);
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
            $img_str = implode(',', $tmp_arr);

            $new = $form->application_files()->first();
            $new->dc_recomm = $img_str;
            $form->application_files()->save($new);
            return redirect()->route('tsf_applied_form_mdy', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_electricpower_edit($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_dc_recomm_photo';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('user.mandalay.transformer.tsf_form_8_edit', compact('active', 'form_id', 'heading', 'form', 'files'));
        // } else {
        //     return redirect()->route('home');
        // }
    }
    public function mdy_transformer_electricpower_update(Request $request) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
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
                    $new->dc_recomm = $img_str;
                    $form->application_files()->save($new);
                } else {
                    $new = new ApplicationFile();
                    $new->application_form_id = $form->id;
                    $new->dc_recomm = $img_str;
                    $new->save();
                }
            }
            return redirect()->route('tsf_applied_form_mdy', $form->id);
        // } else {
        //     return redirect()->route('home');
        // }
    }

    public function mdy_transformer_show($form_id) {
        $active = 'overall';
        $heading = 'applied_detail';
        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');
        $fee = InitialCost::where('building_fee','!=',null)->where([['type', 4], ['sub_type', $form->apply_sub_type]])->first();
        // dd($fee);
        return view('user.mandalay.transformer.show', compact('active', 'heading', 'tbl_col_name', 'fee', 'form', 'files'));
    }
    
    /* For Mandalay */
    /* =============================================================================================================== */

    public function user_profile_edit(){
        $user           = user();
        $password_error = Session::get('password_error');
        return view('user.setting.profile_edit', compact('user','password_error'));
    }

    public function user_profile_update(Request $request,$id){
        if($id != user()->id){
            $id = '0';
        }
        $user = User::findOrFail($id);
        if(Hash::check($request->password, $user->password)){
            
            $logout = false;
            $rules['name'] = ['required', 'string', 'max:255'];
            if($user->email != $request->email){
                $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users'];
                $user->email_verified_at = null;
                $logout = true;
            }

            Validator::make($request->all(), $rules)->validate();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();
            if(!$logout){
                return redirect()->route('home');
            }else{
                $user->sendApiEmailVerificationNotification();
                Auth::guard('web')->logout();
                return redirect('/login');
            }
        }else{
            $password_error = trans('lang.password_false');
            return redirect()->route('user_profile_edit')->with(['password_error'=>$password_error]);
        }
        
    }

    public function user_password_edit(){
        $user           = user();
        $password_error = Session::get('password_error');
        return view('user.setting.password_edit', compact('user','password_error'));
    }

    public function user_password_update(Request $request,$id){
        if($id != user()->id){
            $id = '0';
        }
        $user = User::findOrFail($id);
        if(Hash::check($request->old_password, $user->password)){
            Validator::make($request->all(), [
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ])->validate();
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::guard('web')->logout();
            return redirect('/login');
        }else{
            $password_error = trans('lang.password_false');
            return redirect()->route('user_password_edit')->with(['password_error'=>$password_error]);
        }
    }
}
