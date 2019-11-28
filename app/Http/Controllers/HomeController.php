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
        return view('user.all_forms_view', compact('active'));
    }

    /* =============================================================================================================== */
    /* For Other Division/State */
    public function residential_index() {
        $active = 'resident_app';
        return view('user.application', compact('active'));
    }

    public function residential_rule_regulation() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'rule_regulation';
            return view('user.other.residential.rules_and_regulations', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }

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

    public function residential_user_information($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_info';
            $regions = DivisionState::get();
            $districts = District::get();
            $townships = Township::where('division_state_id', '!=', 2)->get();
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
            $townships = Township::where('division_state_id', '!=', 2)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if ($d_form) {
                    $form = $d_form;
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
            if (!$new->serial_code) {
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
            } elseif ($form->apply_division == 2) {
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
            $townships = Township::where('division_state_id', '!=', 2)->get();
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
            $townships = Township::get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if ($d_form) {
                    $form = $d_form;
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
            if (!$new->serial_code) {
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
            if (!$new->serial_code) {
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
            $townships = Township::where('division_state_id', '!=', 2)->get();
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
            $districts = District::where('division_state_id', 2)->get();
            $townships = Township::where('division_state_id', 2)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if ($d_form) {
                    $form = $d_form;
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
            if (!$new->serial_code) {
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
            $fee_names = InitialCost::where('type', 4)->get();
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
            $fee_names = InitialCost::where('type', 4)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                $form = $d_form;
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
            $townships = Township::where('division_state_id', '!=', 2)->get();
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
            $townships = Township::where('division_state_id', '!=', 2)->get();
            $app_form = ApplicationForm::find($form_id);
            $form = $app_form;
            if (!$app_form->serial_code) {
                $d_form = FormDraft::where('application_form_id', $form_id)->first();
                if ($d_form) {
                    $form = $d_form;
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
            if (!$new->serial_code) {
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
        $fee = InitialCost::where([['type', 4], ['sub_type', $form->apply_sub_type]])->first();
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
            return view('user.yangon.residential.rules_and_regulations', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }

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
            if (!$new->serial_code) {
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
            return redirect()->route('resident_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

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
            return redirect()->route('resident_applied_form_ygn', $form->id);
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
            return redirect()->route('resident_applied_form_ygn', $form->id);
        } else {
            return redirect()->route('home');
        }
    }

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

    public function ygn_residential_power_select_meter_type() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('type', 2)->get();
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
            if (!$new->serial_code) {
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
            return redirect()->route('resident_power_applied_form_ygn', $form->id);
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
            return redirect()->route('resident_power_applied_form_ygn', $form->id);
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
            return redirect()->route('resident_power_applied_form_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }

    public function ygn_residential_power_show($form_id) {
        $active = 'overall';
        $heading = 'applied_detail';
        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');
        $fee_names = InitialCost::where([['type', 2], ['sub_type', $form->apply_sub_type]])->get();
        return view('user.yangon.residentialPower.show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'form', 'files'));
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
                'applied_lane' => 'required',
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
            if (!$new->serial_code) {
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
            return redirect()->route('commercial_applied_form_ygn', $form->id);
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
            return redirect()->route('commercial_applied_form_ygn', $form->id);
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
                    $new->electric_power = $img_str;
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
            if (!$new->serial_code) {
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
            return redirect()->route('contractor_applied_form_ygn', $form->id);
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

    public function ygn_contractor_show($form_id) {
        $active = 'overall';
        $heading = 'applied_detail';
        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($form_id);
        $c_form = ApplicationFormContractor::where('application_form_id', $form_id)->first();
        $files = $form->application_files;
        return view('user.yangon.contractor.show', compact('active', 'heading', 'form', 'files','c_form'));
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
    public function ygn_transformer_agreement_one() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'agreement';
            return view('user.yangon.transformer.agreement_one', compact('active', 'heading'));
        } else {
            return redirect()->route('home');
        }
    }

    public function ygn_transformer_select_meter_type() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = '';
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where('type', 4)->get();
            return view('user.yangon.transformer.tsf_form_1', compact('active', 'fee_names', 'tbl_col_name'));
        } else {
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_store_meter_type(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $new = new ApplicationForm();
            $new->user_id = Auth::user()->id;
            $new->apply_type = 4;
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
            $fee_names = InitialCost::where('type', 4)->get();
            $form = ApplicationForm::find($form_id);
            return view('user.yangon.transformer.tsf_form_1_edit', compact('active', 'fee_names', 'tbl_col_name', 'form'));
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
            if (!$new->serial_code) {
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
                return redirect()->route('tsf_electricpower_create_ygn', $form->id);
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
            return view('user.yangon.transformer.tsf_form_7', compact('active', 'form_id', 'heading'));
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
            return redirect()->route('tsf_electricpower_create_ygn', $form->id);
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
    
    public function ygn_transformer_electricpower_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app';
            $heading = 'applied_dc_recomm_photo';
            return view('user.yangon.transformer.tsf_form_8', compact('active', 'form_id', 'heading'));
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_electricpower_store(Request $request) {
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
            return redirect()->route('tsf_applied_form_ygn', $form->id);
        }else{
            return redirect()->route('home');
        }
    }
    public function ygn_transformer_electricpower_edit($form_id) {
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
    public function ygn_transformer_electricpower_update(Request $request) {
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

    public function ygn_transformer_show($form_id) {
        $active = 'overall';
        $heading = 'applied_detail';
        $form = ApplicationForm::orderBy('date', 'desc')->orderBy('id', 'desc')->find($form_id);
        $files = $form->application_files;
        $tbl_col_name = Schema::getColumnListing('initial_costs');
        $fee = InitialCost::where([['type', 4], ['sub_type', $form->apply_sub_type]])->first();
        // dd(chk_cdt($form->apply_type));
        return view('user.yangon.transformer.show', compact('active', 'heading', 'tbl_col_name', 'fee', 'form', 'files'));
    }
}
