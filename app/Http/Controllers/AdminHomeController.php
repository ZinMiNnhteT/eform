<?php

namespace App\Http\Controllers;

use PDF;
use App\User;
use Carbon\Carbon;
use App\Admin\Admin;
use App\Admin\Form16;
use App\Admin\Form66;
use App\User\Payment;
use App\Admin\Form138;
use App\Admin\MailTbl;
use App\Admin\FormEiChk;
use App\Mail\sendToUser;
use App\Admin\FormSurvey;
use App\Setting\District;
use App\Setting\Township;
use App\Admin\AdminAction;
use App\Admin\FormRoutine;
use App\Jobs\sendToUserJob;
use App\Jobs\PaymentDoneJob;
use App\Setting\InitialCost;
use Illuminate\Http\Request;
use App\User\ApplicationForm;
use App\Setting\DivisionState;
use App\Admin\FormProcessAction;
use App\Admin\FormProcessRemark;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Admin\FormSurveyTransformer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Schema;
use App\Admin\ApplicationFormContractor;
use Spatie\Permission\Models\Permission;
use App\Mail\SendMail;
use Session;
use Illuminate\Support\Facades\Validator;

class AdminHomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $active = 'dash';
        return view('admin.dashboard', compact('active'));
    }

    /* Testing Mail Start */
    public function send_mail() {
        $mail_detail = [
            'email' => 'htetaung@thenexthop.net',
            'name' => 'Customer',
            'mail_body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<div class="text-center mt-5 mb-5"><a href="#" class="btn btn-info text-center">Click for payment</a></div>'
        ];

        $header     = 'လျှောက်လွှာလက်ခံပြီးဖြစ်ကြောင်း အကြောင်းကြားခြင်း';
        $body       = 'လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger"></span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားပါသည်။';
        $remark     = '';
        $link       = '#';
        $link_name  = "Go to Form";
        $office_from       = divType(2);
        Mail::to('htetaung@thenexthop.net')->send(new SendMail($header, $body, $remark, $link, $link_name, $office_from));
        /* queue and mail */
        // dispatch(new sendToUserJob($mail_detail));

        // $mail = MailTbl::orderBy('created_at', 'asc')->find(1);
        return view('emails.sendMail', compact('header', 'body', 'remark', 'link', 'link_name', 'office_from'));
    }
    /* Testing Mail End */

    /* Roles */
    public function roles_index(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $heading = 'roleSetting';
            $active = 'roles';

            $user_glvl = Auth::guard('admin')->user()->group_lvl;
            $user_division = Auth::guard('admin')->user()->div_state;
            $user_id = Auth::guard('admin')->user()->id;

            $roles = Role::select('roles.*')
            ->where('roles.id', '>', 1);
            if($request->name != ''){
                $roles = $roles->where('roles.name','LIKE','%'.$request->name.'%');
            } 

            // if($user_id != 1){
            //     $roles = $roles->join('admins','admins.id','=','roles.admin_id');
            //     $roles->where('admins.div_state', $user_division);
            // }
            
            if($user_id != 1){
                $roles = $roles->join('admins','admins.id','=','roles.admin_id');
                $roles->where('admins.div_state', $user_division); // roles created by same-division-acc
                if($user_glvl == 2){ // ဝန်ကြီးရုံး gp
                    $roles->orWhere('roles.id','3'); //  ဝန်ကြီးရုံး အဆင့်
                }elseif($user_glvl == 3){ // နေပြည်တော်ရုံးချုပ် gp
                    $roles->orWhere('roles.id','4'); // နေပြည်တော်ရုံးချုပ် အဆင့်
                }else{
                    $roles->orWhere('roles.name','အငယ်တန်းအင်ဂျင်နီယာ');
                    if($user_division != '2'){ // other divisions except yangon
                        if($user_glvl == 4){ // တိုင်း gp
                            $roles->orWhere('roles.id','6');//  ခရိုင်အဆင့်
                            $roles->orWhere('roles.id','7'); // မြို့နယ် အဆင့်
                        }elseif($user_glvl >= 5){ // ခရိုင် or မြို့နယ် gp
                            $roles->orWhere('roles.id','7'); // မြို့နယ် အဆင့်
                        }
                    }
                }
            }
            
            // if ($user_glvl == 1) {
            //     $roles = Role::orderBy('id','asc')->paginate(10);
            // } else {   
                      
                $roles = $roles->orderBy('id','asc')->paginate(10);
            // }
            $roles->appends(request()->query());
            return view('admin.role_index', compact('heading', 'active', 'roles'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function roles_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // dd($request->all());b
            $this->validate($request, [
                'role_name' => ['required']
            ]);
            $role_name = $request->role_name;
            $role_id = $request->role_id;

            if ($role_id) { /* ============================== edit ============================== */
                $role = Role::find($role_id);
                $role->name = $role_name;
                $role->save();
                $msg = 'record_update_success_msg';
            } else { /* ============================== create ============================== */
                $role = new Role();
                $role->name = $role_name;
                $role->guard_name = 'admin';
                $role->admin_id = Auth::guard('admin')->user()->id;
                $role->save();
                $role->givePermissionTo(['dashboard-view', 'dashboard-create', 'dashboard-edit', 'dashboard-delete', 'dashboard-show']);
                $msg = 'record_create_success_msg';
            }
            return redirect()->route('roles.index')->with('status', $msg);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function roles_show($id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $heading = 'permissions';
            $active = 'roles';
            $name = Role::find($id)->name;
            $tbl_col_name = Schema::getColumnListing('roles');
            $permissions = Permission::get();
            $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
                ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                ->all();
            return view('admin/role_show', compact('heading', 'active', 'id', 'name', 'tbl_col_name', 'permissions', 'rolePermissions'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    /* ------------------------------------------------------------------------------ */
    
    /* Accounts */
    public function account_index(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $heading    = 'accountSetting';
            $active     = 'accounts';
            $user_glvl  = Auth::guard('admin')->user()->group_lvl;
            $accounts   = DB::table('admins')->where('active', 1);

            // search
            if($request->name != ''){
                $accounts = $accounts->where('name','LIKE',"%".$request->name.'%');
            }
            if($request->role != ''){
                $accounts = $accounts->join('model_has_roles','model_has_roles.model_id','=','admins.id')->where('model_has_roles.role_id', $request->role);
            }
            if($request->group_lvl != ''){
                $accounts = $accounts->where('admins.group_lvl',$request->group_lvl);
            }
            if($request->div_state != ''){
                $accounts = $accounts->where('admins.div_state',$request->div_state);
            }
            if($request->district != ''){
                $accounts = $accounts->where('admins.district',$request->district);
            }
            if($request->township != ''){
                $accounts = $accounts->where('admins.township',$request->township);
            }

            if($user_glvl == 1) {
                $accounts = $accounts->orderBy('admins.group_lvl', 'asc')->orderBy('created_at', 'asc')->paginate(10);
            } else {
                if($user_glvl == '4'){
                    $field = 'div_state';
                    $val = admin()->div_state;
                    $state = '=';
                }elseif($user_glvl == '5'){
                    $field = 'district';
                    $val = admin()->district;
                    $state = '=';
                }elseif($user_glvl == '6'){
                    $field = 'township';
                    $val = admin()->township;
                    $state = '=';
                }else{
                    if(admin()->group_lvl == 2){
                        $field = 'group_lvl';
                        $val = admin()->group_lvl;
                        $state = '>=';
                    }else{
                        $field = 'group_lvl';
                        $val = admin()->group_lvl;
                        $state = '=';
                    }
                }
                
                // $accounts = Admin::where([['group_lvl', '>', 1], [$field, $val], ['active', 1]])->orderBy('group_lvl', 'asc')->orderBy('created_at', 'asc')->paginate(10)->onEachSide(1);
                $accounts = $accounts->where([['admins.group_lvl', '>', 1],[$field, $state, $val]])->orderBy('group_lvl', 'asc')->orderBy('created_at', 'asc')->paginate(10);
            }
            $accounts->appends(request()->query());
            return view('admin.account_index', compact('heading', 'active', 'accounts'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function account_create() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $heading = 'accountSetting';
            $active = 'accounts';
            return view('admin.account_create', compact('heading', 'active'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function account_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
                'phone' => ['required', 'min:9', 'max:11', 'unique:admins'],
                'group_lvl' => ['required'],
                'role' => ['required'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);
            $new = new Admin();
            $new->name = $request->name;
            $new->username = $request->username;
            $new->email = $request->email;
            $new->password = Hash::make($request->password);
            $new->position = $request->position;
            $new->department = $request->department;
            $new->phone = $request->phone;
            $new->div_state = $request->div_state ? $request->div_state : 0;
            $new->district = $request->district ? $request->district : 0;
            $new->township = $request->township ? $request->township : 0;
            $new->group_lvl = $request->group_lvl;
            $new->save();

            foreach ($request->role as $role) {
                $new->assignRole($role);
            }

            return redirect()->route('accounts.index')->with('status', 'record_create_success_msg');
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function account_edit($id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $heading = 'accountSetting';
            $active = 'accounts';
            $account = Admin::find($id);
            $get_role = DB::table('admins')->join('model_has_roles', 'admins.id', '=', 'model_has_roles.model_id')->where('admins.id', $id)->first();
            if ($get_role) {
                $userRole = Role::find($get_role->role_id)->name;
            }
            return view('admin.account_edit', compact('heading', 'active', 'account', 'userRole'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function account_update(Request $request, $id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'string', 'max:255', 'unique:admins,email,'.$id],
                'phone' => ['required'],
                'group_lvl' => ['required'],
                'role' => ['required'],
                // 'div_state' => ['required'],
                // 'district' => ['required'],
                // 'township' => ['required'],
            ]);

            $new = Admin::find($id);
            $new->name = $request->name;
            $new->username = $request->username;
            $new->email = $request->email;
            if ($request->password !== null) {
                $new->password = Hash::make($request->password);
            }
            $new->position = $request->position;
            $new->department = $request->department;
            $new->phone = $request->phone;
            $new->div_state = $request->div_state ? $request->div_state : 0;
            $new->district = $request->district ? $request->district : 0;
            $new->township = $request->township ? $request->township : 0;
            $new->group_lvl = $request->group_lvl;
            $new->save();

            DB::table('model_has_roles')->where('model_id', $id)->delete();
            foreach ($request->role as $role) {
                $new->assignRole($role);
            }

            return redirect()->route('accounts.index')->with('status', 'record_update_success_msg');
        } else {
            return redirect()->route('dashboard');
        }
    }
    /* ------------------------------------------------------------------------------ */

    /* Accounts */
    public function user_index(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $heading = 'userAccounts';
            $active = 'users';
            if($request->name != ''){
                $accounts = User::where('name','LIKE','%'.$request->name.'%')->paginate(10);
            }else{
                $accounts = User::paginate(10);
            }
            $accounts->appends(request()->query());
            return view('admin.users_index', compact('heading', 'active', 'accounts'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    /* ------------------------------------------------------------------------------ */

    /* Inbox */
    public function inbox() {
        $active = 'mailbox';
        return 'Mailbox';
    }
    /* ------------------------------------------------------------------------------ */

    public function applying_form(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $divisionId=$request->div_state_id ? $request->div_state_id : null;
            $districtId=$request->district_id ? $request->district_id : null;
            $townshipId=$request->township_id ? $request->township_id : null;
            $name=$request->name ? $request->name : null;
            $serial=$request->serial ? $request->serial : null;
            $date=$request->date ? $request->date : null;
            $meterType=$request->meterType ? $request->meterType : null;

            $active = 'applying_form';
            $heading = 'applying_form_list';
            $div_states = DivisionState::get();
            $districts = District::get();
            $townships = Township::get();
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([['form_process_actions.form_accept', false],['form_process_actions.form_reject', false], ['form_process_actions.form_pending', false]])
                // ->where('register_meter', '=', false)
                ->when($divisionId, function ($query, $divisionId) {
                    return $query->where('application_forms.div_state_id', $divisionId);
                })
                ->when($districtId, function ($query, $districtId) {
                    return $query->where('application_forms.district_id', $districtId);
                })
                ->when($townshipId, function ($query, $townshipId) {
                    return $query->where('application_forms.township_id', $townshipId);
                })
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->when($date, function ($query, $date) {
                    $explodeDate=(explode('-', $date));
                    $startDate=date('Y-m-d', strtotime($explodeDate[0]));
                    $endDate=date('Y-m-d', strtotime($explodeDate[1]));
                    return $query->whereBetween('application_forms.date', array($startDate, $endDate));
                })
                ->when($meterType, function ($query, $meterType) {
                    return $query->where('application_forms.apply_type', $meterType);
                })
                /* ->orderBy('date', 'desc')
                ->orderBy('id', 'desc') */
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
                return view('admin.applying_form', compact('heading', 'active', 'div_states', 'districts', 'townships', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function applying_form_show($id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'applying_form';
            $heading = 'applying_form_list';
            $data = ApplicationForm::find($id);
            $files = $data->application_files;
            if ($data->apply_type == 1) {
                $type =1;
            }elseif ($data->apply_type == 2) {
                $type =2;
            }elseif ($data->apply_type == 3) {
                $type =3;
            }else{
                $type=0;
            }
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            if($data->apply_type == 2 && $data->apply_division == 1){
                $fee_names = InitialCost::where([['type', 21], ['sub_type', $data->apply_sub_type]])->get();
            }else{
                $fee_names = InitialCost::where([['type', $type], ['sub_type', $data->apply_sub_type]])->get();
            }
            return view('admin.applying_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    /* ------------------------------------------------------------------------------ */

    public function performing_form(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $divisionId=$request->div_state_id ? $request->div_state_id : null;
            $districtId=$request->district_id ? $request->district_id : null;
            $townshipId=$request->township_id ? $request->township_id : null;
            $name=$request->name ? $request->name : null;
            $serial=$request->serial ? $request->serial : null;
            $meterType=$request->meterType ? $request->meterType : null;
            $date=$request->date ? $request->date : null;

            $active = 'performing_form';
            $heading = 'performing_form_list';
            $div_states = DivisionState::get();
            $districts = District::get();
            $townships = Township::get();
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([['form_process_actions.form_accept', true], ['form_process_actions.form_reject', false], ['form_process_actions.form_pending', false], ['form_process_actions.register_meter', false]])
                // ->where('register_meter', '=', false)
                ->when($divisionId, function ($query, $divisionId) {
                    return $query->where('application_forms.div_state_id', $divisionId);
                })
                ->when($districtId, function ($query, $districtId) {
                    return $query->where('application_forms.district_id', $districtId);
                })
                ->when($townshipId, function ($query, $townshipId) {
                    return $query->where('application_forms.township_id', $townshipId);
                })
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->when($date, function ($query, $date) {
                    $explodeDate=(explode('-', $date));
                    $startDate=date('Y-m-d', strtotime($explodeDate[0]));
                    $endDate=date('Y-m-d', strtotime($explodeDate[1]));
                    return $query->whereBetween('application_forms.date', array($startDate, $endDate));
                })
                ->when($meterType, function ($query, $meterType) {
                    return $query->where('application_forms.apply_type', $meterType);
                })
                /* ->orderBy('date', 'desc')
                ->orderBy('id', 'desc') */
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.performing_form', compact('heading', 'active', 'div_states', 'districts', 'townships', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function performing_form_show($id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'performing_form';
            $heading = 'performing_form_list';
            $data = ApplicationForm::find($id);
            $files = $data->application_files;
            if ($data->apply_type == 1) {
                $type = 1;
            } elseif ($data->apply_type == 2) {
                $type = 2;
            } elseif ($data->apply_type == 3) {
                $type = 3;
            } else {
                $type = 0;
            }
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            if($data->apply_type == 2 && $data->apply_division == 1){
                $fee_names = InitialCost::where([['type', 21], ['sub_type', $data->apply_sub_type]])->get();
            }else{
                $fee_names = InitialCost::where([['type', $type], ['sub_type', $data->apply_sub_type]])->get();
            }
            $adminActionData = AdminAction::where('application_form_id',$id)->first();
            $formActionData = FormProcessAction::where('application_form_id',$id)->first();
            $formSurveyData = FormSurvey::where('application_form_id',$id)->first();

            return view('admin.performing_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files','adminActionData','formActionData','formSurveyData'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    /* ------------------------------------------------------------------------------ */

    public function registered_form(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $divisionId = $request->div_state_id ? $request->div_state_id : null;
            $districtId = $request->district_id ? $request->district_id : null;
            $townshipId = $request->township_id ? $request->township_id : null;
            $name = $request->name ? $request->name : null;
            $serial = $request->serial ? $request->serial : null;
            $meterType = $request->meterType ? $request->meterType : null;
            $date = $request->date ? $request->date : null;

            $active = 'registered_form';
            $heading = 'registered_form_list';
            $div_states = DivisionState::get();
            $districts = District::get();
            $townships = Township::get();
            if(admin()->group_lvl == '1' || admin()->group_lvl == '2'){
                 $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where('form_process_actions.register_meter', true)
                // ->where('register_meter', '=', false)
                ->when($divisionId, function ($query, $divisionId) {
                    return $query->where('application_forms.div_state_id', $divisionId);
                })
                ->when($districtId, function ($query, $districtId) {
                    return $query->where('application_forms.district_id', $districtId);
                })
                ->when($townshipId, function ($query, $townshipId) {
                    return $query->where('application_forms.township_id', $townshipId);
                })
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->when($date, function ($query, $date) {
                    $explodeDate=(explode('-', $date));
                    $startDate=date('Y-m-d', strtotime($explodeDate[0]));
                    $endDate=date('Y-m-d', strtotime($explodeDate[1]));
                    return $query->whereBetween('application_forms.date', array($startDate, $endDate));
                })
                ->when($meterType, function ($query, $meterType) {
                    return $query->where('application_forms.apply_type', $meterType);
                })
                /* ->orderBy('date', 'desc')
                ->orderBy('id', 'desc') */
                ->select('application_forms.*')
                ->paginate(10);
                $form->appends(request()->query());
            }else{
                if(admin()->group_lvl == '6'){
                    $val = admin()->township;
                    $field = 'application_forms.township_id';
                    
                }elseif(admin()->group_lvl == '5'){
                    $val = admin()->district;
                    $field = 'application_forms.district_id';
                }elseif(admin()->group_lvl == '4'){
                    $val	 = admin()->div_state;
                    $field = 'application_forms.div_state_id';
                }
                
                    $form = DB::table('application_forms')
                    ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                    ->where('form_process_actions.register_meter', true)
                    ->where($field, $val)
                    ->when($name, function ($query, $name) {
                        return $query->where('application_forms.fullname', $name);
                    })
                    ->when($serial, function ($query, $serial) {
                        return $query->where('application_forms.serial_code', $serial);
                    })
                    ->when($date, function ($query, $date) {
                        $explodeDate=(explode('-', $date));
                        $startDate=date('Y-m-d', strtotime($explodeDate[0]));
                        $endDate=date('Y-m-d', strtotime($explodeDate[1]));
                        return $query->whereBetween('application_forms.date', array($startDate, $endDate));
                    })
                    ->when($meterType, function ($query, $meterType) {
                        return $query->where('application_forms.apply_type', $meterType);
                    })
                    /* ->orderBy('date', 'desc')
                    ->orderBy('id', 'desc') */
                    ->select('application_forms.*')
                    ->paginate(10);
                $form->appends(request()->query());
            }
            // $form = DB::table('application_forms')
            //     ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
            //     ->where('form_process_actions.register_meter', true)
            //     // ->where('register_meter', '=', false)
            //     ->when($divisionId, function ($query, $divisionId) {
            //         return $query->where('application_forms.div_state_id', $divisionId);
            //     })
            //     ->when($districtId, function ($query, $districtId) {
            //         return $query->where('application_forms.district_id', $districtId);
            //     })
            //     ->when($townshipId, function ($query, $townshipId) {
            //         return $query->where('application_forms.township_id', $townshipId);
            //     })
            //     ->when($name, function ($query, $name) {
            //         return $query->where('application_forms.fullname', $name);
            //     })
            //     ->when($serial, function ($query, $serial) {
            //         return $query->where('application_forms.serial_code', $serial);
            //     })
            //     ->when($date, function ($query, $date) {
            //         $explodeDate=(explode('-', $date));
            //         $startDate=date('Y-m-d', strtotime($explodeDate[0]));
            //         $endDate=date('Y-m-d', strtotime($explodeDate[1]));
            //         return $query->whereBetween('application_forms.date', array($startDate, $endDate));
            //     })
            //     ->when($meterType, function ($query, $meterType) {
            //         return $query->where('application_forms.apply_type', $meterType);
            //     })
            //     /* ->orderBy('date', 'desc')
            //     ->orderBy('id', 'desc') */
            //     ->select('application_forms.*')
            //     ->paginate(10);
            // $form->appends(request()->query());
            return view('admin.registered_form', compact('heading', 'active', 'div_states', 'districts', 'townships', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function registered_form_show($id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'registered_form';
            $heading = 'registered_form_list';
            $data = ApplicationForm::find($id);
            $install_date = $action = FormProcessAction::where('application_form_id', $id)->first()->install_accepted_date;
            $formActionData = FormProcessAction::where('application_form_id', $id)->first();
            $formSurveyData = FormSurvey::where('application_form_id',$id)->first();
            $transformerformSurveyData = FormSurveyTransformer::where('application_form_id',$id)->first();
            $adminActionData = AdminAction::where('application_form_id',$id)->first();
            $files = $data->application_files;
            if ($data->apply_type == 1) {
                $type =1;
            }elseif ($data->apply_type == 2) {
                $type =2;
            }elseif ($data->apply_type == 3) {
                $type =3;
            }else{
                $type=0;
            }
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $meter_infos=Form66::where('application_form_id',$id)->first();
            $error = FormProcessRemark::where([['application_form_id', $id], ['error_remark', '!=', NULL]])->get();
            if($data->apply_type != 4){
                $survey_result = FormSurvey::where([['application_form_id', $id], ['survey_date', '!=', NULL]])->first();
            }else{
                $survey_result = FormSurveyTransformer::where('application_form_id', $id)->first();
            }

            if($data->apply_type == 2 && $data->apply_division == 1){
                $fee_names = InitialCost::where([['type', 21], ['sub_type', $data->apply_sub_type]])->get();
            }else{
                $fee_names = InitialCost::where([['type', $type], ['sub_type', $data->apply_sub_type]])->get();
            }

            $fee_names_trf = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->first();


            $survey_result_transfor = FormSurveyTransformer::where('application_form_id', $id)->first();
            $pending = FormProcessRemark::where([['application_form_id', $id], ['pending_remark', '!=', NULL]])->get();
            $install = Form138::where('application_form_id',$id)->first();

            $c_form = ApplicationFormContractor::where('application_form_id', $id)->first();

            $ei_data = FormEiChk::where('application_form_id', $id)->first();
            return view('admin/registered_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data','formActionData','adminActionData','formSurveyData', 'files','survey_result','meter_infos','error','pending','survey_result_transfor','install','ei_data','fee_names_trf','transformerformSurveyData', 'install_date','c_form'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    /* ------------------------------------------------------------------------------ */

    public function reject_form(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $divisionId=$request->div_state_id ? $request->div_state_id : null;
            $districtId=$request->district_id ? $request->district_id : null;
            $townshipId=$request->township_id ? $request->township_id : null;
            $name=$request->name ? $request->name : null;
            $serial=$request->serial ? $request->serial : null;
            $meterType=$request->meterType ? $request->meterType : null;
            $date=$request->date ? $request->date : null;

            $active = 'reject_form';
            $heading = 'reject_form_list';
            $div_states = DivisionState::get();
            $districts = District::get();
            $townships = Township::get();
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where('form_process_actions.form_reject', true)
                // ->where('register_meter', '=', false)
                ->when($divisionId, function ($query, $divisionId) {
                    return $query->where('application_forms.div_state_id', $divisionId);
                })
                ->when($districtId, function ($query, $districtId) {
                    return $query->where('application_forms.district_id', $districtId);
                })
                ->when($townshipId, function ($query, $townshipId) {
                    return $query->where('application_forms.township_id', $townshipId);
                })
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->when($date, function ($query, $date) {
                    $explodeDate=(explode('-', $date));
                    $startDate=date('Y-m-d', strtotime($explodeDate[0]));
                    $endDate=date('Y-m-d', strtotime($explodeDate[1]));
                    return $query->whereBetween('application_forms.date', array($startDate, $endDate));
                })
                ->when($meterType, function ($query, $meterType) {
                    return $query->where('application_forms.apply_type', $meterType);
                })
                /* ->orderBy('date', 'desc')
                ->orderBy('id', 'desc') */
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.reject_form', compact('heading', 'active', 'div_states', 'districts', 'townships', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function reject_form_show($id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'reject_form';
            $heading = 'reject_form_list';
            $data = ApplicationForm::find($id);
            $files = $data->application_files;
            if ($data->apply_type == 1) {
                $type =1;
            }elseif ($data->apply_type == 2) {
                $type =2;
            }elseif ($data->apply_type == 3) {
                $type =3;
            }else{
                $type=0;
            }
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            if($data->apply_type == 2 && $data->apply_division == 1){
                $fee_names = InitialCost::where([['type', 21], ['sub_type', $data->apply_sub_type]])->get();
            }else{
                $fee_names = InitialCost::where([['type', $type], ['sub_type', $data->apply_sub_type]])->get();
            }
            return view('admin.reject_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    /* ------------------------------------------------------------------------------ */

    public function pending_form(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $divisionId=$request->div_state_id ? $request->div_state_id : null;
            $districtId=$request->district_id ? $request->district_id : null;
            $townshipId=$request->township_id ? $request->township_id : null;
            $name=$request->name ? $request->name : null;
            $serial=$request->serial ? $request->serial : null;
            $meterType=$request->meterType ? $request->meterType : null;
            $date=$request->date ? $request->date : null;

            $active = 'pending_form';
            $heading = 'pending_form_list';
            $div_states = DivisionState::get();
            $districts = District::get();
            $townships = Township::get();
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where('form_process_actions.form_pending', true)
                // ->where('register_meter', '=', false)
                ->when($divisionId, function ($query, $divisionId) {
                    return $query->where('application_forms.div_state_id', $divisionId);
                })
                ->when($districtId, function ($query, $districtId) {
                    return $query->where('application_forms.district_id', $districtId);
                })
                ->when($townshipId, function ($query, $townshipId) {
                    return $query->where('application_forms.township_id', $townshipId);
                })
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->when($date, function ($query, $date) {
                    $explodeDate=(explode('-', $date));
                    $startDate=date('Y-m-d', strtotime($explodeDate[0]));
                    $endDate=date('Y-m-d', strtotime($explodeDate[1]));
                    return $query->whereBetween('application_forms.date', array($startDate, $endDate));
                })
                ->when($meterType, function ($query, $meterType) {
                    return $query->where('application_forms.apply_type', $meterType);
                })
                /* ->orderBy('date', 'desc')
                ->orderBy('id', 'desc') */
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.pending_form', compact('heading', 'active', 'div_states', 'districts', 'townships', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function pending_form_show($id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'pending_form';
            $heading = 'pending_form_list';
            $data = ApplicationForm::find($id);
            $files = $data->application_files;
            if ($data->apply_type == 1) {
                $type =1;
            }elseif ($data->apply_type == 2) {
                $type =2;
            }elseif ($data->apply_type == 3) {
                $type =3;
            }else{
                $type=0;
            }
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            if($data->apply_type == 2 && $data->apply_division == 1){
                $fee_names = InitialCost::where([['type', 21], ['sub_type', $data->apply_sub_type]])->get();
            }else{
                $fee_names = InitialCost::where([['type', $type], ['sub_type', $data->apply_sub_type]])->get();
            }
            return view('admin.pending_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    /* ------------------------------------------------------------------------------ */

    public function finished_form() {
        $active = 'finished_form';
        $heading = 'finished_form_list';
        $div_states = DivisionState::get();
        $districts = District::get();
        $townships = Township::get();
        $all_forms = ApplicationForm::paginate(20);
        $all_forms->appends(request()->query());
        return view('admin.finished_form', compact('active', 'heading', 'div_states', 'districts', 'townships', 'all_forms'))->with('i', (request()->input('page', 1) -1) * 20);
    }
    /* ------------------------------------------------------------------------------ */

    /* PDF */
    public function generate_pdf($form_id) {
        // $data = ApplicationForm::find($form_id);
        // $files = $data->application_files;
        // $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
        // $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();            
        // $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
        // $tbl_col_name = Schema::getColumnListing('initial_costs');
        // $fee_names = InitialCost::where([['type', 1], ['sub_type', $data->apply_sub_type]])->get();
        // $data = [
        //     'data' => $data,
        //     'files' => $files,
        //     'survey_result' => $survey_result,
        //     'error' => $error,
        //     'pending' => $pending,
        //     'tbl_col_name' => $tbl_col_name,
        //     'fee_names' => $fee_names,
        //     'title' => 'လျှောက်ထားသူ၏ လျှောက်လွှာအပြည့်အစုံ',
        // ];
        // $path = public_path('storage/user_pdfs/');
        // $pdf = PDF::loadView('admin.pdf.myFile', $data);
        // return $pdf->stream('test_pdf_download.pdf');
        return 'This is not available right now !!!!';
    }
    /* =============================================================================== */

    /* ------------------------------------------------------------------------------ */

    public function form_reject_send_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'reject_remark' => 'required',
            ]);
            $id = $request->form_id;
            // dd($id);

            $form = ApplicationForm::find($id);
            $user = User::find($form->user_id);

            $action = FormProcessAction::where('application_form_id', $id)->first();
            $action->form_reject = true;
            $action->reject_date = date('Y-m-d H:i:s');
            $action->save();

            $remark = new FormProcessRemark();
            $remark->application_form_id = $id;
            $remark->reject_remark = $request->reject_remark;
            $remark->who_did_this = admin()->id;
            $remark->save();

            /* residential */
            if ($form->apply_type == 1) {
                $type = 'အိမ်သုံးမီတာ';
                $route = route('resident_applied_form_ygn', $id);
                if ($form->apply_division == 2) {
                    $route = route('resident_applied_form', $id);
                }elseif ($form->apply_division == 3) {
                    $route = route('resident_applied_form_mdy', $id);
                }
            /* residential Power */
            } elseif ($form->apply_type == 2) {
                $type = 'အိမ်သုံးပါဝါမီတာ';
                $route = route('resident_power_applied_form_ygn', $id);
                if ($form->apply_division == 2) {
                    $route = route('resident_power_applied_form', $id);
                }elseif ($form->apply_division == 3) {
                    $route = route('resident_power_applied_form_mdy', $id);
                }
            /* commercial Power */
            } elseif ($form->apply_type == 3) {
                $type = 'စက်မှုသုံးပါဝါမီတာ';
                $route = route('commercial_applied_form_ygn', $id);
                if ($form->apply_division == 2) {
                    $route = route('commercial_applied_form', $id);
                }elseif ($form->apply_division == 3) {
                    $route = route('commercial_applied_form_mdy', $id);
                }
            /* contractor */
            } elseif ($form->apply_type == 5) {
                $type = 'ကန်ထရိုက်တာမီတာ';
                $route = route('contractor_applied_form_ygn', $id);
                if ($form->apply_division == 2) {
                    $route = route('contractor_applied_form', $id);
                }elseif ($form->apply_division == 3) {
                    $route = route('contractor_applied_form_mdy', $id);
                }
            /* transformer */
            } else {
                $type = 'ထရန်စဖော်မာ';
                $route = route('tsf_applied_form_ygn', $id);
                if ($form->apply_division == 2) {
                    $route = route('tsf_applied_form', $id);
                }elseif ($form->apply_division == 3) {
                    $route = route('tsf_applied_form_mdy', $id);
                }
            }

            // save mail to mailtbl
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော '.$type.'( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ပယ်ဖျက်လိုက်ကြောင်း အကြောင်းကြားပါသည်။</p>';
            $mail_body .= '<div class="mt-3 mb-5">'.$request->reject_remark.'</div>';
            $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id  = $id;
            $mail->user_id              = $form->user_id;
            $mail->sender_id            = admin()->id;
            $mail->send_type            = 4;
            $mail->mail_send_date       = date('Y-m-d H:i:s');
            $mail->mail_body            = $mail_body;
            $mail->save();

            if($form->apply_type == '1'){
                $meter_type = 'home_meter_no';
            }elseif($form->apply_type == '2'){
                $meter_type = 'home_power_meter_no';
            }elseif($form->apply_type == '3'){
                $meter_type = 'commercial_power_meter_no';
            }elseif($form->apply_type == '4'){
                $meter_type = 'contractor_meter_no';
            }else{
                $meter_type = 'transformer_meter_no';
            }

            // send email
            $header     = trans('lang.delete_form_title');
            $body       = trans('lang.delete_form_text',['meter'=>trans('lang.'.$meter_type,['no'=>$form->serial_code])]);
            $remark     = '<div class="remark-danger">&#10039; '.$request->reject_remark.'</div>';
            $link       = $route;
            $link_name  = trans('lang.go_to_form');
            $from       = divType($form->div_state_id);
            Mail::to($user->email)->send(new sendMail($header, $body, $remark, $link, $link_name, $from));

            $chkAction = AdminAction::where('application_form_id', $id)->first();
            if ($chkAction) {
                $adminAction = $chkAction;
            } else {
                $adminAction = new AdminAction();
                $adminAction->application_form_id = $id;
            }
            $adminAction->survey_confirm = admin()->id;
            $adminAction->save();
            /* residential */
            if ($form->apply_type == 1) {
                return redirect()->route('residentialMeterApplicationList.index');
            /* residential Power */
            } elseif ($form->apply_type == 2) {
                return redirect()->route('residentialPowerMeterApplicationList.index');
            /* commercial Power */
            } elseif ($form->apply_type == 3) {
                return redirect()->route('commercialPowerMeterApplicationList.index');
            /* contractor */
            } elseif ($form->apply_type == 5) {
                return redirect()->route('contractorMeterApplicationList.index');
            /* transformer */
            } else {
                return redirect()->route('transformerApplicationList.index');
            }
            
        } else {
            return redirect()->route('dashboard');
        }
    }

    /* Residential Application Form */
    public function residential_applied_form_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;

            $heading = 'residentApplication';
            $active = 'resident_app_form';
            
            
            if(admin()->group_lvl == '1' || admin()->group_lvl == '2'){
                $div_state	 = admin()->div_state;
                 $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 1],
                    ['form_process_actions.user_send_to_office', true],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.register_meter', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
                $form->appends(request()->query());
            }else{
                if(admin()->group_lvl == '6'){
                    $val = admin()->township;
                    $field = 'application_forms.township_id';
                    
                }elseif(admin()->group_lvl == '5'){
                    $val = admin()->district;
                    $field = 'application_forms.district_id';
                }elseif(admin()->group_lvl == '4'){
                    $val	 = admin()->div_state;
                    $field = 'application_forms.div_state_id';
                }
                
                    $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 1],
                    [$field, $val],
                    ['form_process_actions.user_send_to_office', true],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.register_meter', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
                $form->appends(request()->query());
            }
            
            // $form = DB::table('application_forms')
            //     ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
            //     ->where([
            //         ['application_forms.apply_type', 1],
            //         ['form_process_actions.user_send_to_office', true],
            //         ['form_process_actions.form_reject', false],
            //         ['form_process_actions.form_pending', false],
            //         ['form_process_actions.register_meter', false]
            //     ])
            //     ->when($name, function ($query, $name) {
            //         return $query->where('application_forms.fullname', $name);
            //     })
            //     ->when($serial, function ($query, $serial) {
            //         return $query->where('application_forms.serial_code', $serial);
            //     })
            //     ->select('application_forms.*')
            //     ->paginate(10);
            // $form->appends(request()->query());
            return view('admin.residential.applicationForm_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_applied_form_list_show($id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app_form';
            $heading = 'residentApplication';
            $data = ApplicationForm::find($id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $id], ['error_remark', '!=', NULL]])->get();            
            $pending = FormProcessRemark::where([['application_form_id', $id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', 1], ['sub_type', $data->apply_sub_type]])->get();
            $install = Form138::where('application_form_id', $id)->first();
            $install_date = $action = FormProcessAction::where('application_form_id', $id)->first()->install_accepted_date;
            return view('admin.residential.applicationForm_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending','install','install_date'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function residential_form_error_send_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'remark' => 'required',
            ]);
            
            $form = ApplicationForm::find($request->form_id);
            $user = User::find($form->user_id);

            $action = FormProcessAction::where('application_form_id', $request->form_id)->first();
            $action->user_send_to_office = 0;
            $action->save();
            
            $remark = new FormProcessRemark();
            $remark->application_form_id = $request->form_id;
            $remark->error_remark = $request->remark;
            $remark->who_did_this = admin()->id;
            $remark->save();

            $route = route('resident_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('resident_applied_form', $form->id);
            }elseif($form->apply_division == 3){
                $route = route('resident_applied_form_mdy', $form->id);
            }
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ လိုအပ်ချက်များရှိနေပါသောကြောင့် အောက်ဖေါ်ပြပါ အကြောင်းအရာများကို ကြည့်ရှုစစ်ဆေးပြီး ပြန်လည်ပေးပို့ပေးပါရန် အကြောင်းကြားပါသည်။</p>';
            $mail_body .= '<div class="mt-3 mb-5">'.$request->remark.'</div>';
            $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form->id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 1;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();

            $header     = trans('lang.required_form_title');
            $body       = trans('lang.required_form_text',['meter'=>trans('lang.home_meter_no',['no'=>$form->serial_code])]);
            $remark     = '<div class="remark-danger">&#10039; '.$request->remark.'</div>';
            $link       = $route;
            $link_name  = trans('lang.go_to_form');
            $from       = divType($form->div_state_id);
            Mail::to($user->email)->send(new sendMail($header, $body, $remark, $link, $link_name, $from));
            
            return redirect()->route('residentialMeterApplicationList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function residential_form_accept($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);

            $new = FormProcessAction::where('application_form_id', $form_id)->first();
            $new->form_accept = 1;
            $new->accepted_date = date('Y-m-d H:i:s');
            $new->save();

            $adminAction = new AdminAction();
            $adminAction->application_form_id = $form_id;
            $adminAction->form_accept=admin()->id;
            $adminAction->save();

            $route = route('resident_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('resident_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('resident_applied_form_mdy', $form->id);
            }
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားပါသည်။</p>';
            $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form_id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 2;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();

            $header     = trans('lang.accept_form_title');
            $body       = trans('lang.accept_form_text',['meter'=>trans('lang.home_meter_no',['no'=>$form->serial_code])]);
            $remark     = '';
            $link       = $route;
            $link_name  = trans('lang.go_to_form');
            $from       = divType($form->div_state_id);
            Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));

            return redirect()->route('residentialMeterApplicationList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function residential_grd_chk_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;

            $active = 'resident_app_survey';
            $heading = 'residentSurvey';
            if(admin()->group_lvl == '1' || admin()->group_lvl == '2'){
                $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 1],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.form_accept', true],
                    ['form_process_actions.survey_accept', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                /* ->orderBy('date', 'desc')
                ->orderBy('id', 'desc') */
                ->select('application_forms.*')
                ->paginate(10);
                $form->appends(request()->query());
            }else{
                if(admin()->group_lvl == '6'){
                    $val = admin()->township;
                    $field = 'application_forms.township_id';
                    
                }elseif(admin()->group_lvl == '5'){
                    $val = admin()->district;
                    $field = 'application_forms.district_id';
                }elseif(admin()->group_lvl == '4'){
                    $val	 = admin()->div_state;
                    $field = 'application_forms.div_state_id';
                }
                
                $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 1],
                    [$field, $val],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.form_accept', true],
                    ['form_process_actions.survey_accept', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                /* ->orderBy('date', 'desc')
                ->orderBy('id', 'desc') */
                ->select('application_forms.*')
                ->paginate(10);
                $form->appends(request()->query());
            }
            // $form = DB::table('application_forms')
            //     ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
            //     ->where([
            //         ['application_forms.apply_type', 1],
            //         ['form_process_actions.form_reject', false],
            //         ['form_process_actions.form_pending', false],
            //         ['form_process_actions.form_accept', true],
            //         ['form_process_actions.survey_accept', false]
            //     ])
            //     ->when($name, function ($query, $name) {
            //         return $query->where('application_forms.fullname', $name);
            //     })
            //     ->when($serial, function ($query, $serial) {
            //         return $query->where('application_forms.serial_code', $serial);
            //     })
            //     /* ->orderBy('date', 'desc')
            //     ->orderBy('id', 'desc') */
            //     ->select('application_forms.*')
            //     ->paginate(10);
            // $form->appends(request()->query());
            return view('admin.residential.surveyList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_grd_chk_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app_survey';
            $heading = 'residentSurvey';
            $data = ApplicationForm::find($form_id);
            $engineerLists = Admin::where([['div_state', $data->div_state_id], ['district', $data->district_id], ['township', $data->township_id]])->get();
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();            
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();       
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', 1], ['sub_type', $data->apply_sub_type]])->get();
            $allowed_types = InitialCost::where('type', 1)->get();
            return view('admin.residential.surveyList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'engineerLists', 'files', 'survey_result', 'error', 'allowed_types'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_grd_chk_choose_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'engineer_id' => 'required',
            ]);
            $id = $request->form_id;
            $engineerId = $request->engineer_id;
            $survey = new FormSurvey();
            $survey->application_form_id = $id;
            $survey->survey_engineer = $engineerId;
            $survey->save();

            $adminAction = AdminAction::where('application_form_id', $id)->first();
            $adminAction->survey_accept=admin()->id;
            $adminAction->save();

            return redirect()->route('residentialMeterGroundCheckList.show', $id);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_grd_chk_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'form_id' => 'required',
                'living' => 'required',
                'meter' => 'required',
                'invade' => 'required',
                'loaded' => 'required',
                'volt' => 'required',
                'kilowatt' => 'required',
                'distance' => 'required',
                'remark' => 'required',
            ]);
            // dd($request->all());
            $id = $request->form_id;
            if ($request->living == 'on') {
                $living = true;
            } elseif ($request->living == 'off') {
                $living = false;
            } else {
                $living = null;
            }

            if ($request->meter == 'on') {
                $meter = true;
            } elseif ($request->meter == 'off') {
                $meter = false;
            } else {
                $meter = null;
            }

            if ($request->invade == 'on') {
                $invade = true;
            } elseif ($request->invade == 'off') {
                $invade = false;
            } else {
                $invade = null;
            }
            
            if ($request->loaded == 'on') {
                $loaded = true;
            } elseif ($request->loaded == 'off') {
                $loaded = false;
            } else {
                $loaded = null;
            }

            $date = date('Y-m-d H:i:s');

            $action = FormProcessAction::where('application_form_id', $id)->first();
            $action->survey_accept = true;
            $action->survey_accepted_date = $date;
            $action->save();

            $power_file = null;
            if ($request->hasFile('front')) {
                $form = ApplicationForm::find($id);
                $folder_name = $form->id;

                $path = public_path('storage/user_attachments/'.$folder_name);
                $pathPDF = "user_attachments/".$folder_name;

                $power_ext = $request->file('front')->getClientOriginalExtension();
                $power_file = get_random_string().'_'.getdate()[0].'.'.$power_ext;

                if($power_ext != 'pdf'){ 
                    $power_img = Image::make($request->file('front'));
                    $power_img->resize(800, 800, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $power_img->save($path.'/'.$power_file);
                }else{ // pdf
                    //Upload File
                    $request->file('front')->storeAs($pathPDF,$power_file);
                }
            }
            // dd($power_file);

            $survey = FormSurvey::where('application_form_id', $id)->first();
            $survey->survey_date = $date;
            $survey->applied_type = $request->applied_type;
            $survey->phase_type = $request->phase_type;
            $survey->volt = $request->volt;
            $survey->kilowatt = $request->kilowatt;
            $survey->distance = $request->distance;
            $survey->living = $living;
            $survey->meter = $meter;
            $survey->invade = $invade;
            $survey->loaded = $loaded;
            $survey->comsumed_power_amt = $request->comsumed_power_amt;
            $survey->comsumed_power_file = $power_file;
            $survey->latitude = '18.545465562';
            $survey->longitude = '65.545465562';
            $survey->remark = $request->remark;
            if ($form->apply_division == 2 || $form->apply_division == 3) {
                $survey->origin_p_meter = $form->apply_sub_type;
                if($form->apply_division == 2){
                    $survey->allow_p_meter = $request->allowed_type;
                }else{
                    $survey->allow_p_meter = $form->apply_sub_type;
                }
            }
            $folder_name = $form->id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            if ($request->hasFile('location_map')) {
                $location_map_ext = $request->file('location_map')->getClientOriginalExtension();
                $location_map_save_img = get_random_string().'_'.getdate()[0].'.'.$location_map_ext;
                if($location_map_ext != 'pdf'){ // jpg, png
                    $location_map_img = Image::make($request->file('location_map'));
                    $location_map_img->resize(800, 800);
                    $location_map_img->save($path.'/'.$location_map_save_img);
                }else{ // pdf
                    //Upload File
                    $request->file('location_map')->storeAs($pathPDF,$location_map_save_img);
                }
                $survey->location_map = $location_map_save_img;
            }

            $survey->power_tranformer = $request->power_tranformer;
            $survey->kva = $request->kva;
            $survey->the_load = $request->the_load;

            $survey->save();

            if ($form->apply_division == 2) {
                $form->apply_sub_type = $request->allowed_type;
                $form->save();
            }

            return redirect()->route('residentialMeterGroundCheckList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function residential_grd_done_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;

            $active = 'resident_app_gnd_done';
            $heading = 'residentSurveyDone';
            
            if(admin()->group_lvl == '1' || admin()->group_lvl == '2'){
                $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 1],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_accept', true],
                    ['form_process_actions.survey_confirm', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                /* ->orderBy('date', 'desc')
                ->orderBy('id', 'desc') */
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            }else{
                if(admin()->group_lvl == '6'){
                    $val = admin()->township;
                    $field = 'application_forms.township_id';
                    
                }elseif(admin()->group_lvl == '5'){
                    $val = admin()->district;
                    $field = 'application_forms.district_id';
                }elseif(admin()->group_lvl == '4'){
                    $val	 = admin()->div_state;
                    $field = 'application_forms.div_state_id';
                }
                
                    $form = DB::table('application_forms')
                    ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                    ->where([
                        ['application_forms.apply_type', 1],
                        [$field, $val],
                        ['form_process_actions.form_reject', false],
                        ['form_process_actions.form_pending', false],
                        ['form_process_actions.survey_accept', true],
                        ['form_process_actions.survey_confirm', false]
                    ])
                    ->when($name, function ($query, $name) {
                        return $query->where('application_forms.fullname', $name);
                    })
                    ->when($serial, function ($query, $serial) {
                        return $query->where('application_forms.serial_code', $serial);
                    })
                    /* ->orderBy('date', 'desc')
                    ->orderBy('id', 'desc') */
                    ->select('application_forms.*')
                    ->paginate(10);
                $form->appends(request()->query());
            }
            
            // $form = DB::table('application_forms')
            //     ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
            //     ->where([
            //         ['application_forms.apply_type', 1],
            //         ['form_process_actions.form_reject', false],
            //         ['form_process_actions.form_pending', false],
            //         ['form_process_actions.survey_accept', true],
            //         ['form_process_actions.survey_confirm', false]
            //     ])
            //     ->when($name, function ($query, $name) {
            //         return $query->where('application_forms.fullname', $name);
            //     })
            //     ->when($serial, function ($query, $serial) {
            //         return $query->where('application_forms.serial_code', $serial);
            //     })
            //     /* ->orderBy('date', 'desc')
            //     ->orderBy('id', 'desc') */
            //     ->select('application_forms.*')
            //     ->paginate(10);
            // $form->appends(request()->query());
            return view('admin.residential.surveyDoneList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_grd_done_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app_gnd_done';
            $heading = 'residentSurveyDone';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();            
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();       
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', 1], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin/residential/surveyDoneList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_grd_done_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'remark_tsp' => 'required',
            ]);
            // dd($request->all());
            $id = $request->form_id;
            
            $form = ApplicationForm::find($id);
            $user = User::find($form->user_id);
            $route = route('resident_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('resident_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('resident_applied_form_mdy', $form->id);
            }
            if ($request->survey_submit == 'approve') {
                $action = FormProcessAction::where('application_form_id', $id)->first();
                $action->survey_confirm = true;
                $action->survey_confirmed_date = date('Y-m-d H:i:s');
                $action->save();

                $survey = FormSurvey::where('application_form_id',$id)->first();
                $survey->remark_tsp = $request->remark_tsp;
                $survey->save();
            } elseif ($request->survey_submit == 'pending') {
                $action = FormProcessAction::where('application_form_id', $id)->first();
                $action->form_pending = true;
                $action->pending_date = date('Y-m-d H:i:s');
                $action->save();
            
                $remark = new FormProcessRemark();
                $remark->application_form_id = $id;
                $remark->pending_remark = $request->remark_tsp;
                $remark->who_did_this = admin()->id;
                $remark->save();

                $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ခေတ္တဆိုင်းငံ့ထားပါကြောင်း အကြောင်းကြားပါသည်။</p>';
                $mail_body .= '<div class="mt-3 mb-5">'.$request->remark_tsp.'</div>';
                $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

                $mail = new MailTbl();
                $mail->application_form_id = $id;
                $mail->user_id = $form->user_id;
                $mail->sender_id = admin()->id;
                $mail->send_type = 3;
                $mail->mail_send_date = date('Y-m-d H:i:s');
                $mail->mail_body = $mail_body;
                $mail->save();

                $header     = trans('lang.suspend_form_title');
                $body       = trans('lang.suspend_form_text',['meter'=>trans('lang.home_meter_no',['no'=>$form->serial_code])]);
                $remark     = '<div class="remark-danger">&#10039; '.$request->remark_tsp.'</div>';
                $link       = $route;
                $link_name  = trans('lang.go_to_form');
                $from       = divType($form->div_state_id);
                Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));
            } elseif ($request->survey_submit == 'reject') {
                $action = FormProcessAction::where('application_form_id', $id)->first();
                $action->form_reject = true;
                $action->reject_date = date('Y-m-d H:i:s');
                $action->save();
            
                $remark = new FormProcessRemark();
                $remark->application_form_id = $id;
                $remark->reject_remark = $request->remark_tsp;
                $remark->who_did_this = admin()->id;
                $remark->save();

                $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ပယ်ဖျက်လိုက်ကြောင်း အကြောင်းကြားပါသည်။</p>';
                $mail_body .= '<div class="mt-3 mb-5">'.$request->remark_tsp.'</div>';
                $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

                $mail = new MailTbl();
                $mail->application_form_id = $id;
                $mail->user_id = $form->user_id;
                $mail->sender_id = admin()->id;
                $mail->send_type = 4;
                $mail->mail_send_date = date('Y-m-d H:i:s');
                $mail->mail_body = $mail_body;
                $mail->save();

                $header     = trans('lang.delete_form_title');
                $body       = trans('lang.delete_form_text',['meter'=>trans('lang.home_meter_no',['no'=>$form->serial_code])]);
                $remark     = '<div class="remark-danger">&#10039; '.$request->remark_tsp.'</div>';
                $link       = $route;
                $link_name  = trans('lang.go_to_form');
                $from       = divType($form->div_state_id);
                Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));
            }

            $adminAction = AdminAction::where('application_form_id', $id)->first();
            $adminAction->survey_confirm = admin()->id;
            $adminAction->save();
            return redirect()->route('residentialMeterGroundCheckDoneList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_grd_done_list_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app_gnd_done';
            $heading = 'residentSurveyDoneEdit';
            $data = ApplicationForm::find($form_id);
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();   
            $allowed_types = InitialCost::where('type', 1)->get();
            return view('admin/residential/surveyDoneList_edit', compact('active', 'heading', 'data', 'survey_result', 'allowed_types'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_grd_done_list_update(Request $request) {
        // return $request;
        if (isset($_SERVER['HTTP_REFERER'])) {
            $id = $request->form_id;
            if ($request->living == 'on') {
                $living = true;
            } elseif ($request->living == 'off') {
                $living = false;
            } else {
                $living = null;
            }

            if ($request->meter == 'on') {
                $meter = true;
            } elseif ($request->meter == 'off') {
                $meter = false;
            } else {
                $meter = null;
            }

            if ($request->invade == 'on') {
                $invade = true;
            } elseif ($request->invade == 'off') {
                $invade = false;
            } else {
                $invade = null;
            }
            
            if ($request->loaded == 'on') {
                $loaded = true;
            } elseif ($request->loaded == 'off') {
                $loaded = false;
            } else {
                $loaded = null;
            }

            $date = date('Y-m-d H:i:s');

            $power_file = null;
            $form = ApplicationForm::find($id);
            
            if ($request->hasFile('front')) {
                $form = ApplicationForm::find($id);
                $folder_name = $form->id;

                $path = public_path('storage/user_attachments/'.$folder_name);
                $pathPDF = "user_attachments/".$folder_name;

                $power_ext = $request->file('front')->getClientOriginalExtension();
                $power_file = get_random_string().'_'.getdate()[0].'.'.$power_ext;

                if($power_ext != 'pdf'){ 
                    $power_img = Image::make($request->file('front'));
                    $power_img->resize(800, 800, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $power_img->save($path.'/'.$power_file);
                }else{ // pdf
                    //Upload File
                    $request->file('front')->storeAs($pathPDF,$power_file);
                }
            }

            $survey = FormSurvey::where('application_form_id', $id)->first();
            $survey->survey_date = $date;
            $survey->applied_type = $request->applied_type;
            $survey->phase_type = $request->phase_type;
            $survey->volt = $request->volt;
            $survey->kilowatt = $request->kilowatt;
            $survey->distance = $request->distance;
            $survey->living = $living;
            $survey->meter = $meter;
            $survey->invade = $invade;
            $survey->loaded = $loaded;
            $survey->comsumed_power_amt = $request->comsumed_power_amt;
            if ($power_file) {
                $survey->comsumed_power_file = $power_file;
            }
            $survey->remark = $request->remark;
            if ($form->apply_division == 2) {
                $survey->allow_p_meter = $request->allowed_type;
            }

            // location map
            $folder_name = $id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            if ($request->hasFile('location_map')) {
                $location_map_ext = $request->file('location_map')->getClientOriginalExtension();
                $location_map_save_img = get_random_string().'_'.getdate()[0].'.'.$location_map_ext;
                if($location_map_ext != 'pdf'){ // jpg, png
                    $location_map_img = Image::make($request->file('location_map'));
                    $location_map_img->resize(800, 800);
                    $location_map_img->save($path.'/'.$location_map_save_img);
                }else{ // pdf
                    //Upload File
                    $request->file('location_map')->storeAs($pathPDF,$location_map_save_img);
                }

                if (file_exists(public_path('storage/user_attachments/'.$id).'/'.$survey->location_map) && $survey->location_map != '') {
                    unlink(public_path('storage/user_attachments/'.$id).'/'.$survey->location_map);
                }

                $survey->location_map = $location_map_save_img;
            }

            $survey->power_tranformer = $request->power_tranformer;
            $survey->kva = $request->kva;
            $survey->the_load = $request->the_load;

            $survey->save();

            if ($form->apply_division == 2) {
                $form->apply_sub_type = $request->allowed_type;
                $form->save();
            }
            return redirect()->route('residentialMeterGroundCheckDoneList.show', $id);
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function residential_pending_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;

            $active = 'resident_app_pending';
            $heading = 'pending';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 1],
                    ['form_process_actions.form_pending', true],
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                /* ->orderBy('date', 'desc')
                ->orderBy('id', 'desc') */
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.residential.pendingList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_pending_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app_pending';
            $heading = 'pending';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin.residential.pendingList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_pending_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;

            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->form_pending = false;
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->form_pending = admin()->id;
            $adminAction->save();
            return redirect()->route('residentialMeterPendingForm.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function residential_reject_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;

            $active = 'resident_app_reject';
            $heading = 'reject';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 1],
                    ['form_process_actions.form_reject', true],
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                /* ->orderBy('date', 'desc')
                ->orderBy('id', 'desc') */
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.residential.rejectList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_reject_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app_reject';
            $heading = 'reject';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $reject = FormProcessRemark::where([['application_form_id', $form_id], ['reject_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin.residential.rejectList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'reject', 'pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function residential_anno_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;

            $active = 'resident_app_announce';
            $heading = 'announce';
            if(admin()->group_lvl == '1' || admin()->group_lvl == '2'){
                $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 1],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_confirm', true],
                    ['form_process_actions.announce', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                /* ->orderBy('date', 'desc')
                ->orderBy('id', 'desc') */
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            }else{
                if(admin()->group_lvl == '6'){
                    $val = admin()->township;
                    $field = 'application_forms.township_id';
                    
                }elseif(admin()->group_lvl == '5'){
                    $val = admin()->district;
                    $field = 'application_forms.district_id';
                }elseif(admin()->group_lvl == '4'){
                    $val	 = admin()->div_state;
                    $field = 'application_forms.div_state_id';
                }
                
                
                $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 1],
                    [$field, $val],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_confirm', true],
                    ['form_process_actions.announce', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                /* ->orderBy('date', 'desc')
                ->orderBy('id', 'desc') */
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            }
            // $form = DB::table('application_forms')
            //     ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
            //     ->where([
            //         ['application_forms.apply_type', 1],
            //         ['form_process_actions.form_reject', false],
            //         ['form_process_actions.form_pending', false],
            //         ['form_process_actions.survey_confirm', true],
            //         ['form_process_actions.announce', false]
            //     ])
            //     ->when($name, function ($query, $name) {
            //         return $query->where('application_forms.fullname', $name);
            //     })
            //     ->when($serial, function ($query, $serial) {
            //         return $query->where('application_forms.serial_code', $serial);
            //     })
            //     /* ->orderBy('date', 'desc')
            //     ->orderBy('id', 'desc') */
            //     ->select('application_forms.*')
            //     ->paginate(10);
            // $form->appends(request()->query());
            return view('admin.residential.announceList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_anno_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app_announce';
            $heading = 'announce';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();            
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', 1], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin.residential.announceList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'pending', 'error'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_anno_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);

            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->announce = true;
            $action->announced_date = date('Y-m-d H:i:s');
            $action->user_pay = true;
            $action->user_paid_date = date('Y-m-d H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->announce=admin()->id;
            $adminAction->save();

            $expDate = Carbon::now()->addDay(7);

            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် လျှောက်လွှာအတွင်းပါရှိသော အထောက်အထားများ၏ မူရင်းများကို တပါတည်းယူဆောင်၍ သက်မှတ်ရက် ( <span class="text-danger">'.$expDate->format('d-m-Y').'</span> )ထက်နောက်မကျစေဘဲ ရုံးသို့ လူကိုယ်တိုင် လာရောက် ငွေသွင်းနိုင်ပြီဖြစ်ကြောင်း အကြောင်းကြားပါသည်။</p>';
            // $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.route('user_pay_form.create', $form_id).'" class="btn btn-info text-center">Click for payment</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form_id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 5;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();

            $header     = trans('lang.pay_form_title');
            $body       = trans('lang.pay_form_text',['meter'=>trans('lang.home_meter_no',['no'=>$form->serial_code]),'date'=>$expDate->format('d-m-Y')]);
            $remark     = '';
            $link       = '';
            $link_name  = "";
            $from       = divType($form->div_state_id);
            Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));

            return redirect()->route('residentialMeterAnnounceList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function residential_payment_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;

            $active = 'resident_app_payment';
            $heading = 'confirm_payment';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 1],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.announce', true],
                    ['form_process_actions.payment_accept', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                /* ->orderBy('date', 'desc')
                ->orderBy('id', 'desc') */
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.residential.paymentList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_payment_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app_payment';
            $heading = 'confirm_payment';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();            
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $sub_type = InitialCost::find($data->apply_sub_type);
            $user_pay = Payment::where('application_form_id', $form_id)->first();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', 1], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin.residential.paymentList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending', 'sub_type', 'user_pay'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_payment_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;
            // $office_payment = $request->office_payment;
            // $online_payment = $request->online_payment;
            $paid_date = date('Y-m-d', strtotime($request->accept_date));

            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->payment_accept = true;
            $action->payment_accepted_date = $paid_date.' '.date('H:i:s');
            $path = public_path('storage/user_attachments/'.$form_id);
            $pathPDF = "user_attachments/".$form_id;
            if ($request->hasFile('payment_accepted_slips')) {
                foreach($request->file('payment_accepted_slips') as $slip){
                    $ext = $slip->getClientOriginalExtension();
                    $file = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $image = Image::make($slip);
                        $image->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $image->save($path.'/'.$file);
                    }else{ // pdf
                        //Upload File
                        $slip->storeAs($pathPDF,$file);
                    }
                    $data[] = $file;
                }
                $files  = implode(',', $data);
            }else{
                $files = null;
            }
            $action->payment_accepted_slips = $files;
            $action->payment_accepted_slip_nos = $request->payment_accepted_slip_nos;
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->payment_accept=admin()->id;
            $adminAction->save();
            
            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);
            // $pay_date = Payment::where('application_form_id', $form_id)->first()->created_at;
            $route = route('resident_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('resident_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('resident_applied_form_mdy', $form->id);
            }
            
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ ( '.mmNum(date('d-m-Y', strtotime($paid_date))).' )တွင် ငွေသွင်းလက်ခံ ရရှိပြီးဖြစ်ကြောင်း အကြောင်းကြားပါသည်။</p>';
            // add the payment slips to mail body
            $fpa = DB::table("form_process_actions")->where("application_form_id", $form->id)->first();
            $files = explode(",",$fpa->payment_accepted_slips);
            if(count($files)> 0){
                $payment_slips = "Payment Slips : </br>";
                $payment_slips .= '<div class="row">';
                foreach ($files as $file) {
                    $filename = asset('storage/user_attachments/'.$form->id.'/'.$file);
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    ;
                    if($file != ""){
                        if($ext != 'pdf'){
                            $payment_slips .= "<div class='col-md-2'><img src='".asset('storage/user_attachments/'.$form->id.'/'.$file)."' alt='".$file."' class='img-thumbnail'  data-toggle='modal' data-target='#myImg'></div>";
                        }else{
                            $payment_slips .= "<a href='".asset('storage/user_attachments/'.$form->id.'/'.$file)."' target='_blank' class='pdf-block'>".$file."</a>";
                        }
                    }
                }
                $payment_slips .= '</div>';
                $mail_body .= $payment_slips;
            }
            $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form_id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 6;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();

            $header     = trans('lang.receivepay_form_title');
            $body       = trans('lang.receivepay_form_text',['meter'=>trans('lang.home_meter_no',['no'=>$form->serial_code]),'date'=>mmNum(date('d-m-Y', strtotime($paid_date)))]);
            $remark     = '';
            $link       = $route;
            $link_name  = trans('lang.go_to_form');
            $from       = divType($form->div_state_id);
            $file_path  = public_path('storage/user_attachments/'.$form->id.'/');
            Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from, $files, $file_path));
            return redirect()->route('residentialMeterPaymentList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function residential_chk_install_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;

            $active = 'resident_app_chk_install';
            $heading = 'chk_install';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 1],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.payment_accept', true],
                    ['form_process_actions.install_accept', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                /* ->orderBy('date', 'desc')
                ->orderBy('id', 'desc') */
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());

            return view('admin.residential.installList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_chk_install_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app_chk_install';
            $heading = 'chk_install';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();            
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', 1], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin.residential.installList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_chk_install_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // dd($request->all());
            $action = FormProcessAction::where('application_form_id', $request->form_id)->first();
            $action->install_accept = true;
            // $action->install_accepted_date = date('Y-m-d H:i:s');
            $action->install_accepted_date = date('Y-m-d', strtotime($request->accept_date)).' '.date('H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $request->form_id)->first();
            $adminAction->install_accept=admin()->id;
            $adminAction->save();

            $form138 = new Form138();
            $form138->application_form_id = $request->form_id;
            $form138->form_send_date = $request->form_send_date;
            $form138->form_get_date = $request->form_get_date;
            $form138->description = $request->description;
            $form138->cash_kyat = $request->cash_kyat;
            $form138->calculator = $request->calculator;
            $form138->calcu_date = $request->calcu_date;
            $form138->payment_form_no = $request->payment_form_no;
            $form138->payment_form_date = $request->payment_form_date;
            $form138->deposite_form_no = $request->deposite_form_no;
            $form138->deposite_form_date = $request->deposite_form_date;
            $form138->somewhat = $request->somewhat;
            $form138->somewhat_form_date = $request->somewhat_form_date;
            $form138->string_form_no = $request->string_form_no;
            $form138->string_form_date = $request->string_form_date;
            $form138->service_string_form_date = $request->service_string_form_date;
            $form138->save();
            return redirect()->route('residentialMeterCheckInstallList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function residential_reg_meter_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;

            $active = 'resident_app_reg_meter';
            $heading = 'reg_meter';
            if(admin()->group_lvl == '1' || admin()->group_lvl == '2'){
                $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 1],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.install_accept', true],
                    ['form_process_actions.register_meter', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                /* ->orderBy('date', 'desc')
                ->orderBy('id', 'desc') */
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            }else{
                if(admin()->group_lvl == '6'){
                    $val = admin()->township;
                    $field = 'application_forms.township_id';
                    
                }elseif(admin()->group_lvl == '5'){
                    $val = admin()->district;
                    $field = 'application_forms.district_id';
                }elseif(admin()->group_lvl == '4'){
                    $val	 = admin()->div_state;
                    $field = 'application_forms.div_state_id';
                }
                
                $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 1],
                    [$field, $val],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.install_accept', true],
                    ['form_process_actions.register_meter', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                /* ->orderBy('date', 'desc')
                ->orderBy('id', 'desc') */
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            }
            // $form = DB::table('application_forms')
            //     ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
            //     ->where([
            //         ['application_forms.apply_type', 1],
            //         ['form_process_actions.form_reject', false],
            //         ['form_process_actions.form_pending', false],
            //         ['form_process_actions.install_accept', true],
            //         ['form_process_actions.register_meter', false]
            //     ])
            //     ->when($name, function ($query, $name) {
            //         return $query->where('application_forms.fullname', $name);
            //     })
            //     ->when($serial, function ($query, $serial) {
            //         return $query->where('application_forms.serial_code', $serial);
            //     })
            //     /* ->orderBy('date', 'desc')
            //     ->orderBy('id', 'desc') */
            //     ->select('application_forms.*')
            //     ->paginate(10);
            // $form->appends(request()->query());

            return view('admin.residential.regMeterList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_reg_meter_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app_reg_meter';
            $heading = 'reg_meter';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $install_date = $action = FormProcessAction::where('application_form_id', $form_id)->first()->install_accepted_date;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();            
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', 1], ['sub_type', $data->apply_sub_type]])->get();
            $install = Form138::where('application_form_id',$form_id)->first();
            return view('admin.residential.regMeterList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending', 'install', 'install_date'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_reg_meter_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app_reg_meter';
            $heading = 'reg_meter';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('admin.residential.regMeterList_create', compact('heading', 'active', 'form', 'files'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_reg_meter_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // dd($request->all());
            $id = $request->form_id;

            $action = FormProcessAction::where('application_form_id', $id)->first();
            $action->register_meter = true;
            $action->registered_meter_date = date('Y-m-d H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $id)->first();
            $adminAction->register_meter=admin()->id;
            $adminAction->save();
            
            $remark = new Form66();
            $remark->application_form_id = $id;
            $remark->meter_no = $request->meter_no;
            $remark->who_made_meter = $request->who_made_meter;
            $remark->meter_unit_no = $request->meter_unit_no;
            $remark->cover_seal_no = $request->cover_seal_no;
            $remark->terminal_seal_no = $request->terminal_seal_no;
            $remark->box_seal_no = $request->box_seal_no;
            $remark->ledger_no = $request->ledger_no;
            $remark->meter_get_date = $request->meter_get_date != "" ? date('Y-m-d', strtotime($request->meter_get_date)) : null;
            $remark->ampere = $request->ampere;
            $remark->pay_date = $request->pay_date != "" ? date('Y-m-d', strtotime($request->pay_date)) : null;
            // $remark->mark_user_no = $request->mark_user_no;
            $remark->budget = $request->budget;
            $remark->move_date = $request->move_date != "" ? date('Y-m-d', strtotime($request->move_date)) : null;
            $remark->move_budget = $request->move_budget;
            $remark->move_order = $request->move_order;
            $remark->test_date = $request->test_date != "" ? date('Y-m-d', strtotime($request->test_date)) : null;
            $remark->test_no = $request->test_no;
            $remark->installer_name = $request->installer_name;
            $remark->installer_post = $request->installer_post;
            $remark->remark = $request->remark;
            $remark->save();
            return redirect()->route('residentialMeterRegisterMeterList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }
    /* ------------------------------------------------------------------------------ */

    /* ------------------------------------------------------------------------------ */
    /* Residential Power Meter */
    public function residential_power_applied_form_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;

            $heading = 'residentApplication';
            $active = 'resident_power_app_form';
            if(admin()->group_lvl == '1' || admin()->group_lvl == '2'){
                $div_state	 = admin()->div_state;
                $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 2],
                    ['form_process_actions.user_send_to_office', true],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.register_meter', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
                $form->appends(request()->query());
            }else{
                if(admin()->group_lvl == '6'){
                    $val = admin()->township;
                    $field = 'application_forms.township_id';
                    
                }elseif(admin()->group_lvl == '5'){
                    $val = admin()->district;
                    $field = 'application_forms.district_id';
                }elseif(admin()->group_lvl == '4'){
                    $val	 = admin()->div_state;
                    $field = 'application_forms.div_state_id';
                }
                
                $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 2],
                    [$field, $val],
                    ['form_process_actions.user_send_to_office', true],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.register_meter', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
                $form->appends(request()->query());
            }
            return view('admin/residentialPower/applicationForm_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_applied_form_list_show($id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_power_app_form';
            $heading = 'residentApplication';
            $data = ApplicationForm::find($id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $install = Form138::where('application_form_id',$id)->first();

            if($data->apply_division == 1){
                $fee_names = InitialCost::where([['type', 21], ['sub_type', $data->apply_sub_type]])->get();
            }else{
                $fee_names = InitialCost::where([['type', 2], ['sub_type', $data->apply_sub_type]])->get();
            }
            return view('admin.residentialPower.applicationForm_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending','install'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    
    public function residential_power_form_error_send_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'remark' => 'required',
            ]);
            
            $form = ApplicationForm::find($request->form_id);
            $user = User::find($form->user_id);

            $action = FormProcessAction::where('application_form_id', $request->form_id)->first();
            $action->user_send_to_office = 0;
            $action->save();
            
            $remark = new FormProcessRemark();
            $remark->application_form_id = $request->form_id;
            $remark->error_remark = $request->remark;
            $remark->who_did_this = admin()->id;
            $remark->save();

            $route = route('resident_power_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('resident_power_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('resident_power_applied_form_mdy', $form->id);
            }
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ လိုအပ်ချက်များရှိနေပါသောကြောင့် အောက်ဖေါ်ပြပါ အကြောင်းအရာများကို ကြည့်ရှုစစ်ဆေးပြီး ပြန်လည်ပေးပို့ပေးပါရန် အကြောင်းကြားပါသည်။</p>';
            $mail_body .= '<div class="mt-3 mb-5">'.$request->remark.'</div>';
            $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form->id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 1;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();

            $header     = trans('lang.required_form_title');
            $body       = trans('lang.required_form_text',['meter'=>trans('lang.home_power_meter_no',['no'=>$form->serial_code])]);
            $remark     = '<div class="remark-danger">&#10039; '.$request->remark.'</div>';
            $link       = $route;
            $link_name  = trans('lang.go_to_form');
            $from       = divType($form->div_state_id);
            Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));

            return redirect()->route('residentialPowerMeterApplicationList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function residential_power_form_accept($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);

            $new = FormProcessAction::where('application_form_id', $form_id)->first();
            $new->form_accept = 1;
            $new->accepted_date = date('Y-m-d H:i:s');
            $new->save();

            $adminAction = new AdminAction();
            $adminAction->application_form_id = $form_id;
            $adminAction->form_accept=admin()->id;
            $adminAction->save();
            
            $route = route('resident_power_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('resident_power_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('resident_power_applied_form_mdy', $form->id);
            }
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားပါသည်။</p>';
            $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form_id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 2;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();

            $header     = trans('lang.accept_form_title');
            $body       = trans('lang.accept_form_text',['meter'=>trans('lang.home_power_meter_no',['no'=>$form->serial_code])]);
            $remark     = '';
            $link       = $route;
            $link_name  = trans('lang.go_to_form');
            $from       = divType($form->div_state_id);
            Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));

            return redirect()->route('residentialPowerMeterApplicationList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }
    
    public function residential_power_grd_chk_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'resident_power_app_survey';
            $heading = 'residentSurvey';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 2],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.form_accept', true],
                    ['form_process_actions.survey_accept', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.residentialPower.surveyList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_grd_chk_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_power_app_survey';
            $heading = 'residentSurvey';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $engineerLists = Admin::where([['div_state', $data->div_state_id], ['district', $data->district_id], ['township', $data->township_id]])->get();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->get();
            $pm_list = InitialCost::where('type', $data->apply_type)->get();
            return view('admin/residentialPower/surveyList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'error', 'pending', 'pm_list', 'engineerLists'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_grd_chk_choose_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'engineer_id' => 'required',
            ]);
            $id = $request->form_id;
            $engineerId = $request->engineer_id;
            $survey = new FormSurvey();
            $survey->application_form_id = $id;
            $survey->survey_engineer = $engineerId;
            $survey->save();

            $adminAction = AdminAction::where('application_form_id', $id)->first();
            $adminAction->survey_accept=admin()->id;
            $adminAction->save();
            return redirect()->route('residentialPowerMeterGroundCheckList.show', $id);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_grd_chk_list_store(Request $request) {
        // dd($request->all());
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'form_id' => 'required',
                'living' => 'required',
                'meter' => 'required',
                'invade' => 'required',
                'transmit' => 'required',
                'distance' => 'required',
                't_info' => 'required',
                'max_load' => 'required',
            ]);
            $id = $request->form_id;
           
            if ($request->living == 'on') {
                $living = true;
            } elseif ($request->living == 'off') {
                $living = false;
            } else {
                $living = null;
            }

            if ($request->meter == 'on') {
                $meter = true;
            } elseif ($request->meter == 'off') {
                $meter = false;
            } else {
                $meter = null;
            }

            if ($request->invade == 'on') {
                $invade = true;
            } elseif ($request->invade == 'off') {
                $invade = false;
            } else {
                $invade = null;
            }
            
            if ($request->transmit == 'on') {
                $transmit = true;
            } elseif ($request->transmit == 'off') {
                $transmit = false;
            } else {
                $transmit = null;
            }

            if ($request->cable_extend == 'on') {
                $cable_extend = true;
            } elseif ($request->cable_extend == 'off') {
                $cable_extend = false;
            }

            if ($request->transmitter_error == 'on') {
                $transmitter_error = true;
            } elseif ($request->transmitter_error == 'off') {
                $transmitter_error = false;
            }

            if($request->curr_transmitter_date != "" && $request->curr_transmitter_time != ""){
                $curr_transmitter_date_time = date('Y-m-d', strtotime($request->curr_transmitter_date)).' '.date('H:i:s', strtotime($request->curr_transmitter_time));
            }else{
                $curr_transmitter_date_time = null;
            }

            $insulation_date = $request->insulation_date != "" ? date('Y-m-d', strtotime($request->insulation_date)) : null;

            $date = date('Y-m-d H:i:s');
            $img_str = null;

            $form = ApplicationForm::find($id);
            if ($request->hasFile('front')) {
                $folder_name = $form->id;
                $path = public_path('storage/user_attachments/'.$folder_name);
                $pathPDF = "user_attachments/".$folder_name;
                $tmp_arr = [];

                foreach ($request->file('front') as $key => $value) {
                    $ext = $value->getClientOriginalExtension();
                    $save_db_img = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $save_file_img = Image::make($value);
                        $save_file_img->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $save_file_img->save($path.'/'.$save_db_img);
                    }else{ // pdf
                        //Upload File
                        $value->storeAs($pathPDF,$save_db_img);
                    }
                    array_push($tmp_arr, $save_db_img);
                }
                $img_str = implode(',', $tmp_arr);
            }

            $img_str_building = null;
            if ($request->hasFile('building_photos')) {
                $folder_name = $form->id;
                $path = public_path('storage/user_attachments/'.$folder_name);
                $pathPDF = "user_attachments/".$folder_name;
                $tmp_arr = [];

                foreach ($request->file('building_photos') as $key => $value) {
                    $ext = $value->getClientOriginalExtension();
                    $save_db_img = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $save_file_img = Image::make($value);
                        $save_file_img->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $save_file_img->save($path.'/'.$save_db_img);
                    }else{ // pdf
                        //Upload File
                        $value->storeAs($pathPDF,$save_db_img);
                    }
                    array_push($tmp_arr, $save_db_img);
                }
                $img_str_building = implode(',', $tmp_arr);
            }

            $action = FormProcessAction::where('application_form_id', $id)->first();
            $action->survey_accept = true;
            $action->survey_accepted_date = $date;
            $action->save();
            
            $remark = FormSurvey::where('application_form_id', $id)->first();
            $remark->survey_date = $date;
            $remark->distance = $request->distance;
            $remark->t_info = $request->t_info;
            $remark->max_load = $request->max_load;
            $remark->curr_transmitter_date = $curr_transmitter_date_time;
            $remark->curr_transmitter_volt = $request->curr_transmitter_volt;
            $remark->amper_r = $request->amper_r;
            $remark->amper_y = $request->amper_y;
            $remark->amper_b = $request->amper_b;
            $remark->amper_n = $request->amper_n;
            $remark->cable_extend = $cable_extend;
            $remark->transmitter_error = $transmitter_error;
            $remark->cable_size_type = $request->cable_size_type;
            $remark->insulation_date = $insulation_date;

            $remark->chtry = $request->chtry;
            $remark->chtyb = $request->chtyb;
            $remark->chtbr = $request->chtbr;
            $remark->ihtre = $request->ihtre;
            $remark->ihtye = $request->ihtye;
            $remark->ihtbe = $request->ihtbe;
            $remark->ihtne = $request->ihtne;
            $remark->ihtry = $request->ihtry;
            $remark->ihthte = $request->ihthte;
            $remark->ihthtlt = $request->ihthtlt;
            $remark->cltry = $request->cltry;
            $remark->cltyb = $request->cltyb;
            $remark->cltbr = $request->cltbr;
            $remark->iltre = $request->iltre;
            $remark->iltye = $request->iltye;
            $remark->iltbe = $request->iltbe;
            $remark->iltne = $request->iltne;
            $remark->iltry = $request->iltry;
            $remark->ilthte = $request->ilthte;
            $remark->ilthtlt = $request->ilthtlt;

            $remark->living = $living;
            $remark->meter = $meter;
            $remark->invade = $invade;
            $remark->transmit = $transmit;
            $remark->prev_meter_no = $request->prev_meter_no;
            $remark->comsumed_power_amt = $request->comsumed_power_amt;
            $remark->origin_p_meter = $form->apply_sub_type;
            $remark->allow_p_meter = $request->allow_p_meter;
            if ($img_str) {
                $remark->r_power_files = $img_str;
            }
            if ($img_str_building) {
                $remark->r_building_files = $img_str_building;
            }
            $remark->latitude = '11.2';
            $remark->longitude = '22.1';
            $remark->remark = $request->remark;

            // location map file upload saves
            $folder_name = $id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            if ($request->hasFile('location_map')) {
                $location_map_ext = $request->file('location_map')->getClientOriginalExtension();
                $location_map_save_img = get_random_string().'_'.getdate()[0].'.'.$location_map_ext;
                if($location_map_ext != 'pdf'){ // jpg, png
                    $location_map_img = Image::make($request->file('location_map'));
                    $location_map_img->resize(800, 800);
                    $location_map_img->save($path.'/'.$location_map_save_img);
                }else{ // pdf
                    // Upload File
                    $request->file('location_map')->storeAs($pathPDF,$location_map_save_img);
                }
                $remark->location_map = $location_map_save_img;
            }
            
            // ဓာတ်အားပေးမည့် ထရန်စဖော်မာအမည်
            $remark->power_tranformer = $request->power_tranformer;

            // ၄၀၀ဗို့ ဓာတ်အားလိုင်းပြမြေပုံ
            $folder_name = $id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            if ($request->hasFile('line_map_400')) {
                $ext = $request->file('line_map_400')->getClientOriginalExtension();
                $img = get_random_string().'_'.getdate()[0].'.'.$ext;
                if($ext != 'pdf'){ // jpg, png
                    $location_map_img = Image::make($request->file('line_map_400'));
                    $location_map_img->resize(800, 800);
                    $location_map_img->save($path.'/'.$img);
                }else{ // pdf
                    // Upload File
                    $request->file('line_map_400')->storeAs($pathPDF,$img);
                }
                $remark->line_map_400 = $img;
            }

            $remark->save();

            $form->apply_sub_type = $request->allow_p_meter;
            $form->save();
            
            return redirect()->route('residentialPowerMeterGroundCheckList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }
    
    public function residential_power_grd_done_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;

            $active = 'resident_power_app_gnd_done';
            $heading = 'residentSurveyDoneTsp';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 2],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_accept', true],
                    ['form_process_actions.survey_confirm', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.residentialPower.surveyDoneList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_grd_done_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_power_app_gnd_done';
            $heading = 'residentSurveyDoneTsp';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            if($data->apply_division == 1){
                $fee_names = InitialCost::where([['type', 21], ['sub_type', $data->apply_sub_type]])->get();
            }else{
                $fee_names = InitialCost::where([['type', 2], ['sub_type', $data->apply_sub_type]])->get();
            }
            return view('admin/residentialPower/surveyDoneList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_grd_done_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_power_app_gnd_done';
            $heading = 'residentSurveyDoneTsp';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            return view('admin.residentialPower.surveyDoneList_create', compact('active', 'heading', 'form', 'survey_result'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_grd_done_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'remark_tsp' => 'required',
            ]);
            // dd($request->all());
            $id = $request->form_id;
            $action = FormProcessAction::where('application_form_id', $id)->first();
            $action->survey_confirm = true;
            $action->survey_confirmed_date = date('Y-m-d H:i:s');
            $action->save();

            $send_from_to = new FormRoutine();
            $send_from_to->application_form_id = $id;
            $send_from_to->send_from = 1;
            $send_from_to->send_to = 2;
            $send_from_to->remark = $request->remark_tsp;
            $send_from_to->type = 'send';
            $send_from_to->save();

            $path = public_path('storage/user_attachments/'.$id);
            $pathPDF = "user_attachments/".$id;

            $remark = FormSurvey::where('application_form_id', $id)->first();
            $remark->remark_tsp = $request->remark_tsp;
            if ($request->hasFile('tsp_recomm')) {
                $ext = $request->file('tsp_recomm')->getClientOriginalExtension();
                $file = get_random_string().'_'.getdate()[0].'.'.$ext;
                if($ext != 'pdf'){ // jpg, png
                    $image = Image::make($request->file('tsp_recomm'));
                    $image->resize(800, 800, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $image->save($path.'/'.$file);
                }else{ // pdf
                    //Upload File
                    $request->file('tsp_recomm')->storeAs($pathPDF,$file);
                }
                // delete old file
                if (file_exists(public_path('storage/user_attachments/'.$id).'/'.$remark->tsp_recomm) && $remark->tsp_recomm != '') {
                    unlink(public_path('storage/user_attachments/'.$id).'/'.$remark->tsp_recomm);
                }
            }else{
                $file = null;
            }
            $remark->tsp_recomm = $file;
            $remark->save();

            $adminAction = AdminAction::where('application_form_id', $id)->first();
            $adminAction->survey_confirm=admin()->id;
            $adminAction->save();
            
            return redirect()->route('residentialPowerMeterGroundCheckDoneList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_grd_done_list_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_power_app_gnd_done';
            $heading = 'residentSurveyDoneTsp';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $pm_list = InitialCost::where('type', $form->apply_type)->get();
            return view('admin/residentialPower/surveyDoneList_edit', compact('active', 'heading', 'form', 'survey_result', 'pm_list'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_grd_done_list_update(Request $request) {
        // dd($request->all());
        if (isset($_SERVER['HTTP_REFERER'])) {
            $id = $request->form_id;
           
            if ($request->living == 'on') {
                $living = true;
            } elseif ($request->living == 'off') {
                $living = false;
            } else {
                $living = null;
            }

            if ($request->meter == 'on') {
                $meter = true;
            } elseif ($request->meter == 'off') {
                $meter = false;
            } else {
                $meter = null;
            }

            if ($request->invade == 'on') {
                $invade = true;
            } elseif ($request->invade == 'off') {
                $invade = false;
            } else {
                $invade = null;
            }
            
            if ($request->transmit == 'on') {
                $transmit = true;
            } elseif ($request->transmit == 'off') {
                $transmit = false;
            } else {
                $transmit = null;
            }

            if ($request->cable_extend == 'on') {
                $cable_extend = true;
            } elseif ($request->cable_extend == 'off') {
                $cable_extend = false;
            }

            if ($request->transmitter_error == 'on') {
                $transmitter_error = true;
            } elseif ($request->transmitter_error == 'off') {
                $transmitter_error = false;
            }

            if($request->curr_transmitter_date != "" && $request->curr_transmitter_time != ""){
                $curr_transmitter_date_time = date('Y-m-d', strtotime($request->curr_transmitter_date)).' '.date('H:i:s', strtotime($request->curr_transmitter_time));
            }else{
                $curr_transmitter_date_time = null;
            }

            $insulation_date = $request->insulation_date != "" ? date('Y-m-d', strtotime($request->insulation_date)) : null;

            $date = date('Y-m-d H:i:s');
            $img_str = null;

            $form = ApplicationForm::find($id);
            if ($request->hasFile('front')) {
                $folder_name = $form->id;
                $path = public_path('storage/user_attachments/'.$folder_name);
                $pathPDF = "user_attachments/".$folder_name;
                $tmp_arr = [];

                foreach ($request->file('front') as $key => $value) {
                    $ext = $value->getClientOriginalExtension();
                    $save_db_img = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $save_file_img = Image::make($value);
                        $save_file_img->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $save_file_img->save($path.'/'.$save_db_img);
                    }else{ // pdf
                        //Upload File
                        $value->storeAs($pathPDF,$save_db_img);
                    }
                    array_push($tmp_arr, $save_db_img);
                }
                $img_str = implode(',', $tmp_arr);
            }

            $img_str_building = null;
            if ($request->hasFile('building_photos')) {
                $folder_name = $form->id;
                $path = public_path('storage/user_attachments/'.$folder_name);
                $pathPDF = "user_attachments/".$folder_name;
                $tmp_arr = [];

                foreach ($request->file('building_photos') as $key => $value) {
                    $ext = $value->getClientOriginalExtension();
                    $save_db_img = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $save_file_img = Image::make($value);
                        $save_file_img->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $save_file_img->save($path.'/'.$save_db_img);
                    }else{ // pdf
                        //Upload File
                        $value->storeAs($pathPDF,$save_db_img);
                    }
                    array_push($tmp_arr, $save_db_img);
                }
                $img_str_building = implode(',', $tmp_arr);
            }
            
            $remark = FormSurvey::where('application_form_id', $id)->first();
            $remark->survey_date = $date;
            $remark->distance = $request->distance;
            $remark->t_info = $request->t_info;
            $remark->max_load = $request->max_load;
            $remark->curr_transmitter_date = $curr_transmitter_date_time;
            $remark->curr_transmitter_volt = $request->curr_transmitter_volt;
            $remark->amper_r = $request->amper_r;
            $remark->amper_y = $request->amper_y;
            $remark->amper_b = $request->amper_b;
            $remark->amper_n = $request->amper_n;
            $remark->cable_extend = $cable_extend;
            $remark->transmitter_error = $transmitter_error;
            $remark->cable_size_type = $request->cable_size_type;
            $remark->insulation_date = $insulation_date;

            $remark->chtry = $request->chtry;
            $remark->chtyb = $request->chtyb;
            $remark->chtbr = $request->chtbr;
            $remark->ihtre = $request->ihtre;
            $remark->ihtye = $request->ihtye;
            $remark->ihtbe = $request->ihtbe;
            $remark->ihtne = $request->ihtne;
            $remark->ihtry = $request->ihtry;
            $remark->ihthte = $request->ihthte;
            $remark->ihthtlt = $request->ihthtlt;
            $remark->cltry = $request->cltry;
            $remark->cltyb = $request->cltyb;
            $remark->cltbr = $request->cltbr;
            $remark->iltre = $request->iltre;
            $remark->iltye = $request->iltye;
            $remark->iltbe = $request->iltbe;
            $remark->iltne = $request->iltne;
            $remark->iltry = $request->iltry;
            $remark->ilthte = $request->ilthte;
            $remark->ilthtlt = $request->ilthtlt;

            $remark->living = $living;
            $remark->meter = $meter;
            $remark->invade = $invade;
            $remark->transmit = $transmit;
            $remark->prev_meter_no = $request->prev_meter_no;
            $remark->comsumed_power_amt = $request->comsumed_power_amt;
            if ($img_str) {
                // delete old files
                $old_files = explode(',',$remark->r_power_files);
                foreach($old_files as $old_file){
                    if (file_exists(public_path('storage/user_attachments/'.$folder_name).'/'.$old_file) && $old_file != '') {
                        unlink(public_path('storage/user_attachments/'.$folder_name).'/'.$old_file);
                    }
                }
                // save new files
                $remark->r_power_files = $img_str;
            }
            if ($img_str_building) {
                // delete old files
                $old_files = explode(',',$remark->r_building_files);
                foreach($old_files as $old_file){
                    if (file_exists(public_path('storage/user_attachments/'.$folder_name).'/'.$old_file) && $old_file != '') {
                        unlink(public_path('storage/user_attachments/'.$folder_name).'/'.$old_file);
                    }
                }
                // save new files
                $remark->r_building_files = $img_str_building;
            }
            $remark->latitude = '11.2';
            $remark->longitude = '22.1';
            $remark->allow_p_meter = $request->allow_p_meter;
            $remark->remark = $request->remark;

            // location map save
            $folder_name = $id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            if ($request->hasFile('location_map')) {
                $location_map_ext = $request->file('location_map')->getClientOriginalExtension();
                $location_map_save_img = get_random_string().'_'.getdate()[0].'.'.$location_map_ext;
                if($location_map_ext != 'pdf'){ // jpg, png
                    $location_map_img = Image::make($request->file('location_map'));
                    $location_map_img->resize(800, 800);
                    $location_map_img->save($path.'/'.$location_map_save_img);
                }else{ // pdf
                    //Upload File
                    $request->file('location_map')->storeAs($pathPDF,$location_map_save_img);
                }
                if (file_exists(public_path('storage/user_attachments/'.$id).'/'.$remark->location_map) && $remark->location_map != '') {
                    unlink(public_path('storage/user_attachments/'.$id).'/'.$remark->location_map);
                }
                $remark->location_map = $location_map_save_img;
            }

            // ဓာတ်အားပေးမည့် ထရန်စဖော်မာအမည်
            $remark->power_tranformer = $request->power_tranformer;

            // ၄၀၀ဗို့ ဓာတ်အားလိုင်းပြမြေပုံ
            $folder_name = $id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            if ($request->hasFile('line_map_400')) {
                $ext = $request->file('line_map_400')->getClientOriginalExtension();
                $img = get_random_string().'_'.getdate()[0].'.'.$ext;
                if($ext != 'pdf'){ // jpg, png
                    $location_map_img = Image::make($request->file('line_map_400'));
                    $location_map_img->resize(800, 800);
                    $location_map_img->save($path.'/'.$img);
                }else{ // pdf
                    //Upload File
                    $request->file('line_map_400')->storeAs($pathPDF,$img);
                }

                if (file_exists(public_path('storage/user_attachments/'.$id).'/'.$remark->line_map_400) && $remark->line_map_400 != '') {
                    unlink(public_path('storage/user_attachments/'.$id).'/'.$remark->line_map_400);
                }

                $remark->line_map_400 = $img;
            }

            $remark->save();

            $form->apply_sub_type = $request->allow_p_meter;
            $form->save();

            return redirect()->route('residentialPowerMeterGroundCheckDoneList.show', $id);
        }else{
            return redirect()->route('dashboard');
        }
    }
    
    public function residential_power_grd_done_list_dist(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;

            $active = 'resident_power_app_gnd_done_dist';
            $heading = 'residentSurveyDoneDist';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 2],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_confirm', true],
                    ['form_process_actions.survey_confirm_dist', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.residentialPower.surveyDoneListDist_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_grd_done_list_show_dist($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_power_app_gnd_done_dist';
            $heading = 'residentSurveyDone';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            if($data->apply_division == 1){
                $fee_names = InitialCost::where([['type', 21], ['sub_type', $data->apply_sub_type]])->get();
            }else{
                $fee_names = InitialCost::where([['type', 2], ['sub_type', $data->apply_sub_type]])->get();
            }
            return view('admin.residentialPower.surveyDoneList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_grd_done_list_store_dist(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // dd($request->all());
            $id = $request->form_id;

            $form = ApplicationForm::find($id);
            $user = User::find($form->user_id);
            $route = route('resident_power_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('resident_power_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('resident_power_applied_form_mdy', $form->id);
            }
            if ($request->survey_submit_dist == 'approve') {
                $action = FormProcessAction::where('application_form_id', $id)->first();
                $action->survey_confirm_dist = true;
                $action->survey_confirmed_dist_date = date('Y-m-d H:i:s');
                $action->save();

                $send_from_to = new FormRoutine();
                $send_from_to->application_form_id = $id;
                $send_from_to->send_from = 2;
                $send_from_to->send_to = 1;
                $send_from_to->remark = $request->remark_dist;
                $send_from_to->type = 'approve';
                $send_from_to->save();

                $path = public_path('storage/user_attachments/'.$id);
                $pathPDF = "user_attachments/".$id;
    
                $remark = FormSurvey::where('application_form_id', $id)->first();
                $remark->remark_dist = $request->remark_dist;
                if ($request->hasFile('dist_recomm')) {
                    $ext = $request->file('dist_recomm')->getClientOriginalExtension();
                    $file = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $image = Image::make($request->file('dist_recomm'));
                        $image->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $image->save($path.'/'.$file);
                    }else{ // pdf
                        //Upload File
                        $request->file('dist_recomm')->storeAs($pathPDF,$file);
                    }
                }else{
                    $file = null;
                }
                // delete old file
                if (file_exists(public_path('storage/user_attachments/'.$id).'/'.$remark->dist_recomm) && $remark->dist_recomm != '') {
                    unlink(public_path('storage/user_attachments/'.$id).'/'.$remark->dist_recomm);
                }
                $remark->dist_recomm = $file;
                $remark->save();
            } elseif ($request->survey_submit_dist == 'resend') {
                $action = FormProcessAction::where('application_form_id', $id)->first();
                $action->survey_confirm = false;
                $action->save();

                $remark = FormSurvey::where('application_form_id', $id)->first();
                $remark->remark_dist = $request->remark_dist;
                $remark->save();

                $send_from_to = new FormRoutine();
                $send_from_to->application_form_id = $id;
                $send_from_to->send_from = 2;
                $send_from_to->send_to = 1;
                $send_from_to->remark = $request->remark_dist;
                $send_from_to->type = 'resend';
                $send_from_to->save();
            } elseif ($request->survey_submit_dist == 'pending') {
                $action = FormProcessAction::where('application_form_id', $id)->first();
                $action->form_pending = true;
                $action->pending_date = date('Y-m-d H:i:s');
                $action->save();
            
                $remark = new FormProcessRemark();
                $remark->application_form_id = $id;
                $remark->pending_remark = $request->remark_dist;
                $remark->who_did_this = admin()->id;
                $remark->save();

                $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ခေတ္တဆိုင်းငံ့ထားပါကြောင်း အကြောင်းကြားပါသည်။</p>';
                $mail_body .= '<div class="mt-3 mb-5">'.$request->remark_dist.'</div>';
                $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

                $mail = new MailTbl();
                $mail->application_form_id = $id;
                $mail->user_id = $form->user_id;
                $mail->sender_id = admin()->id;
                $mail->send_type = 3;
                $mail->mail_send_date = date('Y-m-d H:i:s');
                $mail->mail_body = $mail_body;
                $mail->save();

                $header     = trans('lang.suspend_form_title');
                $body       = trans('lang.suspend_form_text',['meter'=>trans('lang.home_power_meter_no',['no'=>$form->serial_code])]);
                $remark     = '<div class="remark-danger">&#10039; '.$request->remark_dist.'</div>';
                $link       = $route;
                $link_name  = trans('lang.go_to_form');
                $from       = divType($form->div_state_id);
                Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));
                
            } elseif ($request->survey_submit_dist == 'reject') {
                $action = FormProcessAction::where('application_form_id', $id)->first();
                $action->form_reject = true;
                $action->reject_date = date('Y-m-d H:i:s');
                $action->save();
            
                $remark = new FormProcessRemark();
                $remark->application_form_id = $id;
                $remark->reject_remark = $request->remark_dist;
                $remark->who_did_this = admin()->id;
                $remark->save();

                $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ပယ်ဖျက်လိုက်ကြောင်း အကြောင်းကြားပါသည်။</p>';
                $mail_body .= '<div class="mt-3 mb-5">'.$request->remark_dist.'</div>';
                $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

                $mail = new MailTbl();
                $mail->application_form_id = $id;
                $mail->user_id = $form->user_id;
                $mail->sender_id = admin()->id;
                $mail->send_type = 4;
                $mail->mail_send_date = date('Y-m-d H:i:s');
                $mail->mail_body = $mail_body;
                $mail->save();

                $header     = trans('lang.delete_form_title');
                $body       = trans('lang.delete_form_text',['meter'=>trans('lang.home_power_meter_no',['no'=>$form->serial_code])]);
                $remark     = '<div class="remark-danger">&#10039; '.$request->remark_dist.'</div>';
                $link       = $route;
                $link_name  = trans('lang.go_to_form');
                $from       = divType($form->div_state_id);
                Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));

            }

            $adminAction = AdminAction::where('application_form_id', $id)->first();
            $adminAction->survey_confirm_dist = admin()->id;
            $adminAction->save();
            return redirect()->route('residentialPowerMeterGroundCheckDoneListByDistrict.index');
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function residential_power_pending_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;

            $active = 'resident_power_app_pending';
            $heading = 'pending';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 2],
                    ['form_process_actions.form_pending', true],
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.residentialPower.pendingList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_pending_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_power_app_pending';
            $heading = 'pending';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin.residentialPower.pendingList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_pending_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;

            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->form_pending = false;
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->form_pending = admin()->id;
            $adminAction->save();
            return redirect()->route('residentialPowerMeterPendingForm.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function residential_power_reject_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;

            $active = 'resident_power_app_reject';
            $heading = 'reject';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 2],
                    ['form_process_actions.form_reject', true],
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.residentialPower.rejectList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_reject_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_power_app_reject';
            $heading = 'reject';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $reject = FormProcessRemark::where([['application_form_id', $form_id], ['reject_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin.residentialPower.rejectList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'reject', 'pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    
    public function residential_power_anno_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;

            $active = 'resident_power_app_announce';
            $heading = 'announce';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 2],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_confirm_dist', true],
                    ['form_process_actions.announce', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.residentialPower.announceList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_anno_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_power_app_announce';
            $heading = 'announce';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            if($data->apply_division == 1){
                $fee_names = InitialCost::where([['type', 21], ['sub_type', $data->apply_sub_type]])->get();
            }else{
                $fee_names = InitialCost::where([['type', 2], ['sub_type', $data->apply_sub_type]])->get();
            }
            return view('admin.residentialPower.announceList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_anno_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);

            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->announce = true;
            $action->announced_date = date('Y-m-d H:i:s');
            $action->user_pay = true;
            $action->user_paid_date = date('Y-m-d H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->announce=admin()->id;
            $adminAction->save();
            $expDate = Carbon::now()->addDay(7);

            // $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် အောက်ဖေါ်ပြပါ လင့်ခ် (Link) ကိုနှိပ်၍ ကျသင့်ငွေအား အွန်လိုင်းငွေချေစနစ်ဖြင့် ငွေပေးသွင်းနိုင်ပြီ ဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class="text-danger">'.$expDate->format('d-m-Y').' ၂:၀၀ နာရီ'.'</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားပါသည်။</p>';
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် လျှောက်လွှာအတွင်းပါရှိသော အထောက်အထားများ၏ မူရင်းများကို တပါတည်းယူဆောင်၍ သက်မှတ်ရက် ( <span class="text-danger">'.$expDate->format('d-m-Y').' ၂:၀၀ နာရီ'.'</span> ) ထက်နောက်မကျဘဲ ရုံးသို့ လူကိုယ်တိုင် လာရောက် ငွေသွင်းပေးပါရန် အကြောင်းကြားပါသည်။</p>';
            // $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.route('user_pay_form.create', $form_id).'" class="btn btn-info text-center">Click for payment</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form_id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 5;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();
            
            $header     = trans('lang.pay_form_title');
            $body       = trans('lang.pay_form_text',['meter'=>trans('lang.home_power_meter_no',['no'=>$form->serial_code]), 'date' => $expDate->format('d-m-Y')]);
            $remark     = '';
            // $link       = route('user_pay_form.create', $form_id);
			// $link_name  = trans('lang.click_for_payment');
			$link       = '';
            $link_name  = "";
            $from       = divType($form->div_state_id);
            Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));

            // dispatch(new announceToUserJob($mail_detail));
            return redirect()->route('residentialPowerMeterAnnounceList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }
    
    public function residential_power_payment_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;

            $active = 'resident_power_app_payment';
            $heading = 'confirm_payment';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 2],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.announce', true],
                    ['form_process_actions.payment_accept', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.residentialPower.paymentList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_payment_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_power_app_payment';
            $heading = 'confirm_payment';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $sub_type = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->first();
            $user_pay = Payment::where('application_form_id', $form_id)->first();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            if($data->apply_division == 1){
                $fee_names = InitialCost::where([['type', 21], ['sub_type', $data->apply_sub_type]])->get();
            }else{
                $fee_names = InitialCost::where([['type', 2], ['sub_type', $data->apply_sub_type]])->get();
            }
            return view('admin.residentialPower.paymentList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending', 'sub_type', 'user_pay'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_payment_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_power_app_payment';
            $heading = 'confirm_payment';
            $form = ApplicationForm::find($form_id);
            $sub_type = InitialCost::where([['type', $form->apply_type], ['sub_type', $form->apply_sub_type]])->first();
            $user_pay = Payment::where('application_form_id', $form_id)->first();
            return view('admin.residentialPower.paymentList_create', compact('heading', 'active', 'form', 'sub_type', 'user_pay'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_payment_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;
            $paid_date = date('Y-m-d', strtotime($request->accept_date));

            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->payment_accept = true;
            $action->payment_accepted_date = $paid_date.' '.date('H:i:s');
            $path = public_path('storage/user_attachments/'.$form_id);
            $pathPDF = "user_attachments/".$form_id;
            if ($request->hasFile('payment_accepted_slips')) {
                foreach($request->file('payment_accepted_slips') as $slip){
                    $ext = $slip->getClientOriginalExtension();
                    $file = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $image = Image::make($slip);
                        $image->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $image->save($path.'/'.$file);
                    }else{ // pdf
                        //Upload File
                        $slip->storeAs($pathPDF,$file);
                    }
                    $data[] = $file;
                }
                $files  = implode(',', $data);
            }else{
                $files = null;
            }
            $action->payment_accepted_slips = $files;
            $action->payment_accepted_slip_nos = $request->payment_accepted_slip_nos;
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->payment_accept=admin()->id;
            $adminAction->save();
            
            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);
            $route = route('resident_power_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('resident_power_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('resident_power_applied_form_mdy', $form->id);
            }
            
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ ('.date('d-m-Y', strtotime($paid_date)).')တွင် ငွေသွင်းလက်ခံ ရရှိပြီးဖြစ်ကြောင်း အကြောင်းကြားပါသည်။</p>';
            // add the payment slips to mail body
            $fpa = DB::table("form_process_actions")->where("application_form_id", $form->id)->first();
            $files = explode(",",$fpa->payment_accepted_slips);
            if(count($files)> 0){
                $payment_slips = "Payment Slips : </br>";
                $payment_slips .= '<div class="row">';
                foreach ($files as $file) {
                    $filename = asset('storage/user_attachments/'.$form->id.'/'.$file);
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    ;
                    if($file != ""){
                        if($ext != 'pdf'){
                            $payment_slips .= "<div class='col-md-2'><img src='".asset('storage/user_attachments/'.$form->id.'/'.$file)."' alt='".$file."' class='img-thumbnail'  data-toggle='modal' data-target='#myImg'></div>";
                        }else{
                            $payment_slips .= "<a href='".asset('storage/user_attachments/'.$form->id.'/'.$file)."' target='_blank' class='pdf-block'>".$file."</a>";
                        }
                    }
                }
                $payment_slips .= '</div>';
                $mail_body .= $payment_slips;
            }
            $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form_id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 6;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();
            
            $header     = trans('lang.receivepay_form_title');
            $body       = trans('lang.receivepay_form_text',['meter'=>trans('lang.home_power_meter_no',['no'=>$form->serial_code]),'date'=>mmNum(date('d-m-Y', strtotime($paid_date)))]);
            $remark     = '';
            $link       = $route;
            $link_name  = trans('lang.go_to_form');
            $from       = divType($form->div_state_id);
            $file_path  = public_path('storage/user_attachments/'.$form->id.'/');
            Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from, $files, $file_path));

            return redirect()->route('residentialPowerMeterPaymentList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }
    
    public function residential_power_contract_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;

            $active = 'resident_power_app_contract';
            $heading = 'contract_menu';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 2],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.payment_accept', true],
                    ['form_process_actions.contract', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.residentialPower.contractList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_contract_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_power_app_contract';
            $heading = 'contract_menu';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            if($data->apply_division == 1){
                $fee_names = InitialCost::where([['type', 21], ['sub_type', $data->apply_sub_type]])->get();
            }else{
                $fee_names = InitialCost::where([['type', 2], ['sub_type', $data->apply_sub_type]])->get();
            }
            return view('admin.residentialPower.contractList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_contract_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_power_app_contract';
            $heading = 'contract_menu';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('admin.residentialPower.contractList_create', compact('heading', 'active', 'form', 'files'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_contract_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $id = $request->form_id;

            $action = FormProcessAction::where('application_form_id', $id)->first();
            $action->contract = true;
            $action->contracted_date = date('Y-m-d H:i:s');
            $action->save();
            
            $has_form16 = Form16::where('application_form_id', $id)->first();
            if ($has_form16) {
                $new = Form16::where('application_form_id', $id)->first();
                $new->applied_type = $request->applied_type;
                $new->date_from = $request->date_from;
                $new->date_to = $request->date_to;
                $new->elec_type = $request->elec_type;
                $new->volt = $request->volt;
                $new->kilowatt = $request->kilowatt;
                $new->why_to_use = $request->why_to_use;
                $new->temp_name = $request->temp_name;
                $new->temp_meter_no = $request->temp_meter_no;
                $new->other_name = $request->other_name;
                $new->other_meter_no = $request->other_meter_no;
                $new->finance_no = $request->finance_no;
                $new->name = $request->name;
                $new->job = $request->job;
                $new->nrc = $request->nrc;
                $new->date = $request->date;
                $new->save();
            } else {
                $new = new Form16();
                $new->application_form_id = $id;
                $new->applied_type = $request->applied_type;
                $new->date_from = $request->date_from;
                $new->date_to = $request->date_to;
                $new->elec_type = $request->elec_type;
                $new->volt = $request->volt;
                $new->kilowatt = $request->kilowatt;
                $new->why_to_use = $request->why_to_use;
                $new->temp_name = $request->temp_name;
                $new->temp_meter_no = $request->temp_meter_no;
                $new->other_name = $request->other_name;
                $new->other_meter_no = $request->other_meter_no;
                $new->finance_no = $request->finance_no;
                $new->name = $request->name;
                $new->job = $request->job;
                $new->nrc = $request->nrc;
                $new->date = $request->date;
                $new->save();
            }
            return redirect()->route('residentialPowerMeterContractList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }
    
    public function residential_power_chk_install_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'resident_power_app_chk_install';
            $heading = 'chk_install';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 2],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.payment_accept', true],
                    ['form_process_actions.install_accept', false],
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.residentialPower.installList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_chk_install_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_power_app_chk_install';
            $heading = 'chk_install';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            if($data->apply_division == 1){
                $fee_names = InitialCost::where([['type', 21], ['sub_type', $data->apply_sub_type]])->get();
            }else{
                $fee_names = InitialCost::where([['type', 2], ['sub_type', $data->apply_sub_type]])->get();
            }
            return view('admin.residentialPower.installList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_chk_install_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_power_app_chk_install';
            $heading = 'chk_install';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('admin.residentialPower.installList_create', compact('heading', 'active', 'form', 'files'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_chk_install_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $action = FormProcessAction::where('application_form_id', $request->form_id)->first();
            $action->install_accept = true;
            $action->install_accepted_date = date('Y-m-d', strtotime($request->accept_date)).' '.date('H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $request->form_id)->first();
            $adminAction->install_accept = admin()->id;
            $adminAction->save();

            $form138 = new Form138();
            $form138->application_form_id = $request->form_id;
            $form138->form_send_date = $request->form_send_date;
            $form138->form_get_date = $request->form_get_date;
            $form138->description = $request->description;
            $form138->cash_kyat = $request->cash_kyat;
            $form138->calculator = $request->calculator;
            $form138->calcu_date = $request->calcu_date;
            $form138->payment_form_no = $request->payment_form_no;
            $form138->payment_form_date = $request->payment_form_date;
            $form138->deposite_form_no = $request->deposite_form_no;
            $form138->deposite_form_date = $request->deposite_form_date;
            $form138->somewhat = $request->somewhat;
            $form138->somewhat_form_date = $request->somewhat_form_date;
            $form138->string_form_no = $request->string_form_no;
            $form138->string_form_date = $request->string_form_date;
            $form138->service_string_form_date = $request->service_string_form_date;
            $form138->save();
            return redirect()->route('residentialPowerMeterCheckInstallList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }
    
    public function residential_power_install_done_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'resident_power_app_install_done';
            $heading = 'chk_install_done';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 2],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.install_accept', true],
                    ['form_process_actions.install_confirm', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin/residentialPower/installDoneList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_install_done_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_power_app_install_done';
            $heading = 'chk_install_done';

            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            if($data->apply_division == 1){
                $fee_names = InitialCost::where([['type', 21], ['sub_type', $data->apply_sub_type]])->get();
            }else{
                $fee_names = InitialCost::where([['type', 2], ['sub_type', $data->apply_sub_type]])->get();
            }

            $survey_result = FormSurvey::where('application_form_id', $form_id)->first();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $install = Form138::where('application_form_id',$form_id)->first();
            $install_date = $action = FormProcessAction::where('application_form_id', $form_id)->first()->install_accepted_date;
            return view('admin/residentialPower/installDoneList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending', 'install', 'install_date'));

        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_install_done_list_create(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // $action = FormProcessAction::where('application_form_id', $form_id)->first();
            // $action->install_confirm = true;
            // $action->install_confirmed_date = date('Y-m-d H:i:s');
            // $action->save();
            $this->validate($request, [
                'form_id' => 'required',
                'front' => 'required',
                'ei_remark' => 'required',
            ]);
            // dd($request->all());
            $form = ApplicationForm::find($request->form_id);
            $folder_name = $form->id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            $tmp_arr = [];
            if ($request->hasFile('front')) {
                foreach($request->file('front') as $front){
                    $ext = $front->getClientOriginalExtension();
                    $file = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $image = Image::make($front);
                        $image->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $image->save($path.'/'.$file);
                    }else{ // pdf
                        //Upload File
                        $front->storeAs($pathPDF,$file);
                    }
                    $data[] = $file;
                }
                $files  = implode(',', $data);
            }else{
                $files = null;
            }

            $new = new FormEiChk();
            $new->application_form_id = $form->id;
            $new->ei_files = $files;
            $new->ei_remark = $request->ei_remark;
            $new->save();   

            $action = FormProcessAction::where('application_form_id', $form->id)->first();
            $action ->install_confirm = true;
            $action->install_confirmed_date = date('Y-m-d H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form->id)->first();
            $adminAction->install_confirm = admin()->id;
            $adminAction->save();
            return redirect()->route('residentialPowerMeterInstallationDoneList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }
    
    public function residential_power_reg_meter_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'resident_power_app_reg_meter';
            $heading = 'reg_meter';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 2],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.install_confirm', true],
                    ['form_process_actions.register_meter', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin/residentialPower/regMeterList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_reg_meter_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_power_app_reg_meter';
            $heading = 'reg_meter';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            if($data->apply_division == 1){
                $fee_names = InitialCost::where([['type', 21], ['sub_type', $data->apply_sub_type]])->get();
            }else{
                $fee_names = InitialCost::where([['type', 2], ['sub_type', $data->apply_sub_type]])->get();
            }
            $install = Form138::where('application_form_id',$form_id)->first();
            $install_date = $action = FormProcessAction::where('application_form_id', $form_id)->first()->install_accepted_date;

            $ei_data = FormEiChk::where('application_form_id', $form_id)->first();

            return view('admin.residentialPower.regMeterList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending', 'install', 'install_date','ei_data'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_reg_meter_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_power_app_reg_meter';
            $heading = 'reg_meter';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('admin.residentialPower.regMeterList_create', compact('heading', 'active', 'form', 'files'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function residential_power_reg_meter_list_store(Request $request) {
        // dd($request->all());
        if (isset($_SERVER['HTTP_REFERER'])) {
            $id = $request->form_id;

            $action = FormProcessAction::where('application_form_id', $id)->first();
            $action->register_meter = true;
            $action->registered_meter_date = date('Y-m-d H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $id)->first();
            $adminAction->register_meter=admin()->id;
            $adminAction->save();
            
            $remark = new Form66();
            $remark->application_form_id = $id;
            $remark->meter_no = $request->meter_no;
            $remark->meter_unit_no = $request->meter_unit_no;
            $remark->cover_seal_no = $request->cover_seal_no;
            $remark->terminal_seal_no = $request->terminal_seal_no;
            $remark->box_seal_no = $request->box_seal_no;
            $remark->ledger_no = $request->ledger_no;
            $remark->meter_get_date = $request->meter_get_date != "" ? date('Y-m-d', strtotime($request->meter_get_date)) : null;
            $remark->who_made_meter = $request->who_made_meter;
            $remark->ampere = $request->ampere;
            $remark->pay_date = $request->pay_date != "" ? date('Y-m-d', strtotime($request->pay_date)) : null;
            // $remark->mark_user_no = $request->mark_user_no;
            $remark->budget = $request->budget;
            $remark->move_date = $request->move_date != "" ? date('Y-m-d', strtotime($request->move_date)) : null;
            $remark->move_budget = $request->move_budget;
            $remark->move_order = $request->move_order;
            $remark->test_date = $request->test_date != "" ? date('Y-m-d', strtotime($request->test_date)) : null;
            $remark->test_no = $request->test_no;
            $remark->installer_name = $request->installer_name;
            $remark->installer_post = $request->installer_post;
            $remark->remark = $request->remark;
            $remark->save();
            return redirect()->route('residentialPowerMeterRegisterMeterList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }
    //--------------------------------------------------------------------------------------------//

    /* --------------------------------------------------------------------------------------------- */
    // Commercial Power Start
    public function commercial_applied_form_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $heading = 'residentApplication';
            $active = 'commercial_app_form';
            if(admin()->group_lvl == '1' || admin()->group_lvl == '2'){
                $div_state	 = admin()->div_state;
                $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 3],
                    ['form_process_actions.user_send_to_office', true],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.register_meter', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
                $form->appends(request()->query());
            }else{
                if(admin()->group_lvl == '6'){
                    $val = admin()->township;
                    $field = 'application_forms.township_id';
                    
                }elseif(admin()->group_lvl == '5'){
                    $val = admin()->district;
                    $field = 'application_forms.district_id';
                }elseif(admin()->group_lvl == '4'){
                    $val	 = admin()->div_state;
                    $field = 'application_forms.div_state_id';
                }
                
                $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 3],
                    [$field, $val],
                    ['form_process_actions.user_send_to_office', true],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.register_meter', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
                $form->appends(request()->query());
            }
            return view('admin.commercialPower.applicationForm_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_applied_form_list_show($id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'commercial_app_form';
            $heading = 'residentApplication';
            $data = ApplicationForm::find($id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', 3], ['sub_type', $data->apply_sub_type]])->get();
            $install = Form138::where('application_form_id',$id)->first();

            return view('admin.commercialPower.applicationForm_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending', 'install'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    
    public function commercial_form_error_send_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'remark' => 'required',
            ]);
            
            $form = ApplicationForm::find($request->form_id);
            $user = User::find($form->user_id);

            $action = FormProcessAction::where('application_form_id', $request->form_id)->first();
            $action->user_send_to_office = 0;
            $action->save();
            
            $remark = new FormProcessRemark();
            $remark->application_form_id = $request->form_id;
            $remark->error_remark = $request->remark;
            $remark->who_did_this = admin()->id;
            $remark->save();

            $route = route('commercial_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('commercial_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('commercial_applied_form_mdy', $form->id);
            }
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော စက်မှုသုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ လိုအပ်ချက်များရှိနေပါသောကြောင့် အောက်ဖေါ်ပြပါ အကြောင်းအရာများကို ကြည့်ရှုစစ်ဆေးပြီး ပြန်လည်ပေးပို့ပေးပါရန် အကြောင်းကြားပါသည်။</p>';
            $mail_body .= '<div class="mt-3 mb-5">'.$request->remark.'</div>';
            $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">'.trans('lang.go_to_form').'</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form->id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 1;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();
            
            $header     = trans('lang.required_form_title');
            $body       = trans('lang.required_form_text',['meter'=>trans('lang.commercial_power_meter_no',['no'=>$form->serial_code])]);
            $remark     = '<div class="remark-danger">&#10039; '.$request->remark.'</div>';
            $link       = $route;
            $link_name  = trans('lang.go_to_form');
            $from       = divType($form->div_state_id);
            Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));

            return redirect()->route('commercialPowerMeterApplicationList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function commercial_form_accept($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);

            $new = FormProcessAction::where('application_form_id', $form_id)->first();
            $new->form_accept = 1;
            $new->accepted_date = date('Y-m-d H:i:s');
            $new->save();

            $adminAction = new AdminAction();
            $adminAction->application_form_id = $form_id;
            $adminAction->form_accept=admin()->id;
            $adminAction->save();

            $route = route('commercial_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('commercial_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('commercial_applied_form_mdy', $form->id);
            }
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော စက်မှုသုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားပါသည်။</p>';
            $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form_id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 2;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();

            $header     = trans('lang.accept_form_title');
            $body       = trans('lang.accept_form_text',['meter'=>trans('lang.commercial_power_meter_no',['no'=>$form->serial_code])]);
            $remark     = '';
            $link       = $route;
            $link_name  = trans('lang.go_to_form');
            $from       = divType($form->div_state_id);
            Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));

            return redirect()->route('commercialPowerMeterApplicationList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }
    
    public function commercial_grd_chk_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'commercial_app_survey';
            $heading = 'residentSurvey';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 3],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.form_accept', true],
                    ['form_process_actions.survey_accept', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.commercialPower.surveyList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_grd_chk_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'commercial_app_survey';
            $heading = 'residentSurvey';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $engineerLists = Admin::where([['div_state', $data->div_state_id], ['district', $data->district_id], ['township', $data->township_id]])->get();
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', 3], ['sub_type', $data->apply_sub_type]])->get();
            $pm_list = InitialCost::where('type', $data->apply_type)->get();
            return view('admin/commercialPower/surveyList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending', 'pm_list', 'engineerLists'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_grd_chk_choose_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'engineer_id' => 'required',
            ]);
            $id = $request->form_id;
            $engineerId = $request->engineer_id;
            $survey = new FormSurvey();
            $survey->application_form_id = $id;
            $survey->survey_engineer = $engineerId;
            $survey->save();

            $adminAction = AdminAction::where('application_form_id', $id)->first();
            $adminAction->survey_accept=admin()->id;
            $adminAction->save();
            return redirect()->route('commercialPowerMeterGroundCheckList.show', $id);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_grd_chk_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'commercial_app_survey';
            $heading = 'residentSurvey';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('admin.commercialPower.surveyList_create', compact('heading', 'active', 'form', 'files'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_grd_chk_list_store(Request $request) {
        // dd($request->all());
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'form_id' => 'required',
                'living' => 'required',
                'meter' => 'required',
                'invade' => 'required',
                'transmit' => 'required',
                'distance' => 'required',
            ]);
            $id = $request->form_id;
           
            if ($request->living == 'on') {
                $living = true;
            } elseif ($request->living == 'off') {
                $living = false;
            } else {
                $living = null;
            }

            if ($request->meter == 'on') {
                $meter = true;
            } elseif ($request->meter == 'off') {
                $meter = false;
            } else {
                $meter = null;
            }

            if ($request->invade == 'on') {
                $invade = true;
            } elseif ($request->invade == 'off') {
                $invade = false;
            } else {
                $invade = null;
            }
            
            if ($request->transmit == 'on') {
                $transmit = true;
            } elseif ($request->transmit == 'off') {
                $transmit = false;
            } else {
                $transmit = null;
            }

            if ($request->cable_extend == 'on') {
                $cable_extend = true;
            } elseif ($request->cable_extend == 'off') {
                $cable_extend = false;
            }

            if ($request->transmitter_error == 'on') {
                $transmitter_error = true;
            } elseif ($request->transmitter_error == 'off') {
                $transmitter_error = false;
            }

            if($request->curr_transmitter_date != "" && $request->curr_transmitter_time){
                $curr_transmitter_date_time = date('Y-m-d', strtotime($request->curr_transmitter_date)).' '.date('H:i:s', strtotime($request->curr_transmitter_time));
            }else{
                $curr_transmitter_date_time = null;
            }
            if($request->insulation_date != ""){
                $insulation_date = $request->insulation_date != "" ? date('Y-m-d', strtotime($request->insulation_date)) : null;
            }else{
                $insulation_date = null;
            }

            $date = date('Y-m-d H:i:s');
            $img_str = null;

            $form = ApplicationForm::find($id);
            if ($request->hasFile('front')) {
                $folder_name = $form->id;
                $path = public_path('storage/user_attachments/'.$folder_name);
                $pathPDF = "user_attachments/".$folder_name;
                $tmp_arr = [];

                foreach ($request->file('front') as $key => $value) {
                    $ext = $value->getClientOriginalExtension();
                    $save_db_img = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $save_file_img = Image::make($value);
                        $save_file_img->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $save_file_img->save($path.'/'.$save_db_img);
                    }else{ // pdf
                        //Upload File
                        $value->storeAs($pathPDF,$save_db_img);
                    }
                    
                    array_push($tmp_arr, $save_db_img);
                }
                $img_str = implode(',', $tmp_arr);
            }

            $img_str_building = null;
            if ($request->hasFile('building_photos')) {
                $folder_name = $form->id;
                $path = public_path('storage/user_attachments/'.$folder_name);
                $pathPDF = "user_attachments/".$folder_name;
                $tmp_arr = [];

                foreach ($request->file('building_photos') as $key => $value) {
                    $ext = $value->getClientOriginalExtension();
                    $save_db_img = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $save_file_img = Image::make($value);
                        $save_file_img->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $save_file_img->save($path.'/'.$save_db_img);
                    }else{ // pdf
                        //Upload File
                        $value->storeAs($pathPDF,$save_db_img);
                    }
                    array_push($tmp_arr, $save_db_img);
                }
                $img_str_building = implode(',', $tmp_arr);
            }

            $action = FormProcessAction::where('application_form_id', $id)->first();
            $action->survey_accept = true;
            $action->survey_accepted_date = $date;
            $action->save();

            $remark = FormSurvey::where('application_form_id', $id)->first();
            $remark->survey_date = $date;
            $remark->distance = $request->distance;
            $remark->t_info = $request->t_info;
            $remark->max_load = $request->max_load;
            $remark->curr_transmitter_date = $curr_transmitter_date_time;
            $remark->curr_transmitter_volt = $request->curr_transmitter_volt;
            $remark->amper_r = $request->amper_r;
            $remark->amper_y = $request->amper_y;
            $remark->amper_b = $request->amper_b;
            $remark->amper_n = $request->amper_n;
            $remark->cable_extend = $cable_extend;
            $remark->transmitter_error = $transmitter_error;
            $remark->cable_size_type = $request->cable_size_type;
            $remark->insulation_date = $insulation_date;

            $remark->chtry = $request->chtry;
            $remark->chtyb = $request->chtyb;
            $remark->chtbr = $request->chtbr;
            $remark->ihtre = $request->ihtre;
            $remark->ihtye = $request->ihtye;
            $remark->ihtbe = $request->ihtbe;
            $remark->ihtne = $request->ihtne;
            $remark->ihtry = $request->ihtry;
            $remark->ihthte = $request->ihthte;
            $remark->ihthtlt = $request->ihthtlt;
            $remark->cltry = $request->cltry;
            $remark->cltyb = $request->cltyb;
            $remark->cltbr = $request->cltbr;
            $remark->iltre = $request->iltre;
            $remark->iltye = $request->iltye;
            $remark->iltbe = $request->iltbe;
            $remark->iltne = $request->iltne;
            $remark->iltry = $request->iltry;
            $remark->ilthte = $request->ilthte;
            $remark->ilthtlt = $request->ilthtlt;

            $remark->living = $living;
            $remark->meter = $meter;
            $remark->invade = $invade;
            $remark->transmit = $transmit;
            $remark->prev_meter_no = $request->prev_meter_no;
            $remark->comsumed_power_amt = $request->comsumed_power_amt;
            if ($img_str) {
                $remark->r_power_files = $img_str;
            }
            if ($img_str_building) {
                $remark->r_building_files = $img_str_building;
            }
            $remark->origin_p_meter = $request->origin_p_meter;
            $remark->allow_p_meter = $request->allow_p_meter;
            $remark->latitude = '11.2';
            $remark->longitude = '22.1';
            $remark->remark = $request->remark;

            // location map
            $folder_name = $id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            if ($request->hasFile('location_map')) {
                $location_map_ext = $request->file('location_map')->getClientOriginalExtension();
                $location_map_save_img = get_random_string().'_'.getdate()[0].'.'.$location_map_ext;
                if($location_map_ext != 'pdf'){ // jpg, png
                    $location_map_img = Image::make($request->file('location_map'));
                    $location_map_img->resize(800, 800);
                    $location_map_img->save($path.'/'.$location_map_save_img);
                }else{ // pdf
                    //Upload File
                    $request->file('location_map')->storeAs($pathPDF,$location_map_save_img);
                }
                $remark->location_map = $location_map_save_img;
            }

            // ဓာတ်အားပေးမည့် ထရန်စဖော်မာအမည်
            $remark->power_tranformer = $request->power_tranformer;

            // ၄၀၀ဗို့ ဓာတ်အားလိုင်းပြမြေပုံ
            $folder_name = $id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            if ($request->hasFile('line_map_400')) {
                $ext = $request->file('line_map_400')->getClientOriginalExtension();
                $img = get_random_string().'_'.getdate()[0].'.'.$ext;
                if($ext != 'pdf'){ // jpg, png
                    $location_map_img = Image::make($request->file('line_map_400'));
                    $location_map_img->resize(800, 800);
                    $location_map_img->save($path.'/'.$img);
                }else{ // pdf
                    //Upload File
                    $request->file('line_map_400')->storeAs($pathPDF,$img);
                }
                $remark->line_map_400 = $img;
            }

            $remark->save();

            $form->apply_sub_type = $request->allow_p_meter;
            $form->save();

            return redirect()->route('commercialPowerMeterGroundCheckList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }
    
    public function commercial_grd_done_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'commercial_app_gnd_done';
            $heading = 'residentSurveyDoneTsp';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 3],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_accept', true],
                    ['form_process_actions.survey_confirm', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.commercialPower.surveyDoneList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_grd_done_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'commercial_app_gnd_done';
            $heading = 'residentSurveyDoneTsp';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', 3], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin/commercialPower/surveyDoneList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_grd_done_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'commercial_app_gnd_done';
            $heading = 'residentSurveyDone';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            return view('admin/commercialPower/surveyDoneList_create', compact('active', 'heading', 'form', 'survey_result'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_grd_done_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'remark_tsp' => 'required',
            ]);
            // dd($request->all());
            $id = $request->form_id;
            $action = FormProcessAction::where('application_form_id', $id)->first();
            $action->survey_confirm = true;
            $action->survey_confirmed_date = date('Y-m-d H:i:s');
            $action->save();

            $path = public_path('storage/user_attachments/'.$id);
            $pathPDF = "user_attachments/".$id;
            
            $remark = FormSurvey::where('application_form_id', $id)->first();
            $remark->remark_tsp = $request->remark_tsp;
            if ($request->hasFile('tsp_recomm')) {
                $ext = $request->file('tsp_recomm')->getClientOriginalExtension();
                $file = get_random_string().'_'.getdate()[0].'.'.$ext;
                if($ext != 'pdf'){ // jpg, png
                    $image = Image::make($request->file('tsp_recomm'));
                    $image->resize(800, 800, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $image->save($path.'/'.$file);
                }else{ // pdf
                    //Upload File
                    $request->file('tsp_recomm')->storeAs($pathPDF,$file);
                }
            }else{
                $file = null;
            }
            if (file_exists(public_path('storage/user_attachments/'.$id).'/'.$remark->tsp_recomm) && $remark->tsp_recomm != '') {
                unlink(public_path('storage/user_attachments/'.$id).'/'.$remark->tsp_recomm);
            }
            $remark->tsp_recomm = $file;
            $remark->save();

            $adminAction = AdminAction::where('application_form_id', $id)->first();
            $adminAction->survey_confirm=admin()->id;
            $adminAction->save();
            return redirect()->route('commercialPowerMeterGroundCheckDoneList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_grd_done_list_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'commercial_app_gnd_done';
            $heading = 'residentSurveyDone';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $pm_list = InitialCost::where('type', $form->apply_type)->get();
            return view('admin/commercialPower/surveyDoneList_edit', compact('active', 'heading', 'form', 'survey_result', 'pm_list'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_grd_done_list_update(Request $request) {
        // dd($request->all());
        if (isset($_SERVER['HTTP_REFERER'])) {
            $id = $request->form_id;
           
            if ($request->living == 'on') {
                $living = true;
            } elseif ($request->living == 'off') {
                $living = false;
            } else {
                $living = null;
            }

            if ($request->meter == 'on') {
                $meter = true;
            } elseif ($request->meter == 'off') {
                $meter = false;
            } else {
                $meter = null;
            }

            if ($request->invade == 'on') {
                $invade = true;
            } elseif ($request->invade == 'off') {
                $invade = false;
            } else {
                $invade = null;
            }
            
            if ($request->transmit == 'on') {
                $transmit = true;
            } elseif ($request->transmit == 'off') {
                $transmit = false;
            } else {
                $transmit = null;
            }

            if ($request->cable_extend == 'on') {
                $cable_extend = true;
            } elseif ($request->cable_extend == 'off') {
                $cable_extend = false;
            }

            if ($request->transmitter_error == 'on') {
                $transmitter_error = true;
            } elseif ($request->transmitter_error == 'off') {
                $transmitter_error = false;
            }

            if($request->curr_transmitter_date != "" && $request->curr_transmitter_time != ""){
                $curr_transmitter_date_time = date('Y-m-d', strtotime($request->curr_transmitter_date)).' '.date('H:i:s', strtotime($request->curr_transmitter_time));
            }else{
                $curr_transmitter_date_time = null;
            }

            $insulation_date = $request->insulation_date != "" ? date('Y-m-d', strtotime($request->insulation_date)) : null;

            $date = date('Y-m-d H:i:s');
            $img_str = null;
            
            $form = ApplicationForm::find($id);

            $remark = FormSurvey::where('application_form_id', $id)->first();

            if ($request->hasFile('front')) {
                $folder_name = $form->id;
                $path = public_path('storage/user_attachments/'.$folder_name);
                $pathPDF = "user_attachments/".$folder_name;
                $tmp_arr = [];

                foreach ($request->file('front') as $key => $value) {
                    $ext = $value->getClientOriginalExtension();
                    $save_db_img = get_random_string().'_'.getdate()[0].'.'.$ext;

                    if($ext != 'pdf'){ // jpg, png
                        $save_file_img = Image::make($value);
                        $save_file_img->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $save_file_img->save($path.'/'.$save_db_img);
                    }else{ // pdf
                        //Upload File
                        $value->storeAs($pathPDF,$save_db_img);
                    }
                    array_push($tmp_arr, $save_db_img);
                }
                $img_str = implode(',', $tmp_arr);
            }

            $img_str_building = null;
            if ($request->hasFile('building_photos')) {
                $folder_name = $form->id;
                $path = public_path('storage/user_attachments/'.$folder_name);
                $pathPDF = "user_attachments/".$folder_name;
                $tmp_arr = [];

                foreach ($request->file('building_photos') as $key => $value) {
                    $ext = $value->getClientOriginalExtension();
                    $save_db_img = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $save_file_img = Image::make($value);
                        $save_file_img->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $save_file_img->save($path.'/'.$save_db_img);
                    }else{ // pdf
                        //Upload File
                        $value->storeAs($pathPDF,$save_db_img);
                    }
                    array_push($tmp_arr, $save_db_img);
                }
                $img_str_building = implode(',', $tmp_arr);
            }

            $action = FormProcessAction::where('application_form_id', $id)->first();
            $action->survey_accept = true;
            $action->survey_accepted_date = $date;
            $action->save();

            
            $remark->survey_date = $date;
            $remark->distance = $request->distance;
            $remark->t_info = $request->t_info;
            $remark->max_load = $request->max_load;
            $remark->curr_transmitter_date = $curr_transmitter_date_time;
            $remark->curr_transmitter_volt = $request->curr_transmitter_volt;
            $remark->amper_r = $request->amper_r;
            $remark->amper_y = $request->amper_y;
            $remark->amper_b = $request->amper_b;
            $remark->amper_n = $request->amper_n;
            $remark->cable_extend = $cable_extend;
            $remark->transmitter_error = $transmitter_error;
            $remark->cable_size_type = $request->cable_size_type;
            $remark->insulation_date = $insulation_date;

            $remark->chtry = $request->chtry;
            $remark->chtyb = $request->chtyb;
            $remark->chtbr = $request->chtbr;
            $remark->ihtre = $request->ihtre;
            $remark->ihtye = $request->ihtye;
            $remark->ihtbe = $request->ihtbe;
            $remark->ihtne = $request->ihtne;
            $remark->ihtry = $request->ihtry;
            $remark->ihthte = $request->ihthte;
            $remark->ihthtlt = $request->ihthtlt;
            $remark->cltry = $request->cltry;
            $remark->cltyb = $request->cltyb;
            $remark->cltbr = $request->cltbr;
            $remark->iltre = $request->iltre;
            $remark->iltye = $request->iltye;
            $remark->iltbe = $request->iltbe;
            $remark->iltne = $request->iltne;
            $remark->iltry = $request->iltry;
            $remark->ilthte = $request->ilthte;
            $remark->ilthtlt = $request->ilthtlt;

            $remark->living = $living;
            $remark->meter = $meter;
            $remark->invade = $invade;
            $remark->transmit = $transmit;
            $remark->prev_meter_no = $request->prev_meter_no;
            $remark->comsumed_power_amt = $request->comsumed_power_amt;
            if ($img_str) {
                // delete old files
                $old_files = explode(',',$remark->r_power_files);
                foreach($old_files as $old_file){
                    if (file_exists(public_path('storage/user_attachments/'.$folder_name).'/'.$old_file) && $old_file != '') {
                        unlink(public_path('storage/user_attachments/'.$folder_name).'/'.$old_file);
                    }
                }
                $remark->r_power_files = $img_str;
            }
            if ($img_str_building) {
                // delete old files
                $old_files = explode(',',$remark->r_building_files);
                foreach($old_files as $old_file){
                    if (file_exists(public_path('storage/user_attachments/'.$folder_name).'/'.$old_file) && $old_file != '') {
                        unlink(public_path('storage/user_attachments/'.$folder_name).'/'.$old_file);
                    }
                }
                // save new files
                $remark->r_building_files = $img_str_building;
            }
            $remark->allow_p_meter = $request->allow_p_meter;            
            $remark->latitude = '11.2';
            $remark->longitude = '22.1';
            $remark->remark = $request->remark;
            
            // location map
            $folder_name = $id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            if ($request->hasFile('location_map')) {
                $location_map_ext = $request->file('location_map')->getClientOriginalExtension();
                $location_map_save_img = get_random_string().'_'.getdate()[0].'.'.$location_map_ext;
                if($location_map_ext != 'pdf'){ // jpg, png
                    $location_map_img = Image::make($request->file('location_map'));
                    $location_map_img->resize(800, 800);
                    $location_map_img->save($path.'/'.$location_map_save_img);
                }else{ // pdf
                    //Upload File
                    $request->file('location_map')->storeAs($pathPDF,$location_map_save_img);
                }

                if (file_exists(public_path('storage/user_attachments/'.$id).'/'.$remark->location_map) && $remark->location_map != '') {
                    unlink(public_path('storage/user_attachments/'.$id).'/'.$remark->location_map);
                }
                $remark->location_map = $location_map_save_img;
            }

            // ဓာတ်အားပေးမည့် ထရန်စဖော်မာအမည်
            $remark->power_tranformer = $request->power_tranformer;

            // ၄၀၀ဗို့ ဓာတ်အားလိုင်းပြမြေပုံ
            $folder_name = $id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            if ($request->hasFile('line_map_400')) {
                $ext = $request->file('line_map_400')->getClientOriginalExtension();
                $img = get_random_string().'_'.getdate()[0].'.'.$ext;
                if($ext != 'pdf'){ // jpg, png
                    $map = Image::make($request->file('line_map_400'));
                    $map->resize(800, 800);
                    $map->save($path.'/'.$img);
                }else{ // pdf
                    //Upload File
                    $request->file('line_map_400')->storeAs($pathPDF,$img);
                }

                if (file_exists(public_path('storage/user_attachments/'.$id).'/'.$remark->line_map_400) && $remark->line_map_400 != '') {
                    unlink(public_path('storage/user_attachments/'.$id).'/'.$remark->line_map_400);
                }
                $remark->line_map_400 = $img;
            }

            $remark->save();

            $form->apply_sub_type = $request->allow_p_meter;
            $form->save();

            return redirect()->route('commercialPowerMeterGroundCheckDoneList.show', $id);
        }else{
            return redirect()->route('dashboard');
        }
    }


    public function commercial_grd_done_list_dist(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'commercial_app_gnd_done_dist';
            $heading = 'residentSurveyDoneDist';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 3],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_confirm', true],
                    ['form_process_actions.survey_confirm_dist', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.commercialPower.surveyDoneListDist_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_grd_done_list_show_dist($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'commercial_app_gnd_done_dist';
            $heading = 'residentSurveyDoneDist';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', 3], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin/commercialPower/surveyDoneList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_grd_done_list_store_dist(Request $request) {
        // dd($request->all());
        if (isset($_SERVER['HTTP_REFERER'])) {
            $id = $request->form_id;

            $form = ApplicationForm::find($id);
            $path = public_path('storage/user_attachments/'.$id);
            $pathPDF = "user_attachments/".$id; 

            $user = User::find($form->user_id);
            $route = route('commercial_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('commercial_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('commercial_applied_form_mdy', $form->id);
            }

            if ($request->survey_submit_dist == 'approve') {
                $action = FormProcessAction::where('application_form_id', $id)->first();
                $action->survey_confirm_dist = true;
                $action->survey_confirmed_dist_date = date('Y-m-d H:i:s');
                $action->save();

                $send_from_to = new FormRoutine();
                $send_from_to->application_form_id = $id;
                $send_from_to->send_from = 2;
                $send_from_to->send_to = 1;
                $send_from_to->remark = $request->remark_dist;
                $send_from_to->type = 'approve';
                $send_from_to->save();
    
                $remark = FormSurvey::where('application_form_id', $id)->first();
                $remark->remark_dist = $request->remark_dist;
                if ($request->hasFile('dist_recomm')) {
                    $ext = $request->file('dist_recomm')->getClientOriginalExtension();
                    $file = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $image = Image::make($request->file('dist_recomm'));
                        $image->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $image->save($path.'/'.$file);
                    }else{ // pdf
                        //Upload File
                        $request->file('dist_recomm')->storeAs($pathPDF,$file);
                    }
                }else{
                    $file = null;
                }
                if (file_exists(public_path('storage/user_attachments/'.$id).'/'.$remark->dist_recomm) && $remark->dist_recomm != '') {
                    unlink(public_path('storage/user_attachments/'.$id).'/'.$remark->dist_recomm);
                }
                $remark->dist_recomm = $file;
                $remark->save();
            } elseif ($request->survey_submit_dist == 'resend') {
                $action = FormProcessAction::where('application_form_id', $id)->first();
                $action->survey_confirm = false;
                $action->save();

                $remark = FormSurvey::where('application_form_id', $id)->first();
                $remark->remark_dist = $request->remark_dist;
                $remark->save();

                $send_from_to = new FormRoutine();
                $send_from_to->application_form_id = $id;
                $send_from_to->send_from = 2;
                $send_from_to->send_to = 1;
                $send_from_to->remark = $request->remark_dist;
                $send_from_to->type = 'resend';
                $send_from_to->save();
            } elseif ($request->survey_submit_dist == 'pending') {
                $action = FormProcessAction::where('application_form_id', $id)->first();
                $action->form_pending = true;
                $action->pending_date = date('Y-m-d H:i:s');
                $action->save();
            
                $remark = new FormProcessRemark();
                $remark->application_form_id = $id;
                $remark->pending_remark = $request->remark_dist;
                $remark->who_did_this = admin()->id;
                $remark->save();

                $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော စက်မှုသုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ခေတ္တဆိုင်းငံ့ထားပါကြောင်း အကြောင်းကြားပါသည်။</p>';
                $mail_body .= '<div class="mt-3 mb-5">'.$request->remark_dist.'</div>';
                $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

                $mail = new MailTbl();
                $mail->application_form_id = $id;
                $mail->user_id = $form->user_id;
                $mail->sender_id = admin()->id;
                $mail->send_type = 3;
                $mail->mail_send_date = date('Y-m-d H:i:s');
                $mail->mail_body = $mail_body;
                $mail->save();

                $header     = trans('lang.suspend_form_title');
                $body       = trans('lang.suspend_form_text',['meter'=>trans('lang.commercial_power_meter_no',['no'=>$form->serial_code])]);
                $remark     = '<div class="remark-danger">&#10039; '.$request->remark_dist.'</div>';
                $link       = $route;
                $link_name  = trans('lang.go_to_form');
                $from       = divType($form->div_state_id);
                Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));

            } elseif ($request->survey_submit_dist == 'reject') {
                $action = FormProcessAction::where('application_form_id', $id)->first();
                $action->form_reject = true;
                $action->reject_date = date('Y-m-d H:i:s');
                $action->save();
            
                $remark = new FormProcessRemark();
                $remark->application_form_id = $id;
                $remark->reject_remark = $request->remark_dist;
                $remark->who_did_this = admin()->id;
                $remark->save();

                $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော စက်မှုသုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ပယ်ဖျက်လိုက်ကြောင်း အကြောင်းကြားပါသည်။</p>';
                $mail_body .= '<div class="mt-3 mb-5">'.$request->remark_dist.'</div>';
                $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

                $mail = new MailTbl();
                $mail->application_form_id = $id;
                $mail->user_id = $form->user_id;
                $mail->sender_id = admin()->id;
                $mail->send_type = 4;
                $mail->mail_send_date = date('Y-m-d H:i:s');
                $mail->mail_body = $mail_body;
                $mail->save();

                $header     = trans('lang.delete_form_title');
                $body       = trans('lang.delete_form_text',['meter'=>trans('lang.commercial_power_meter_no',['no'=>$form->serial_code])]);
                $remark     = '<div class="remark-danger">&#10039; '.$request->remark_dist.'</div>';
                $link       = $route;
                $link_name  = trans('lang.go_to_form');
                $from       = divType($form->div_state_id);
                Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));
                
            }

            $adminAction = AdminAction::where('application_form_id', $id)->first();
            $adminAction->survey_confirm_dist = admin()->id;
            $adminAction->save();
            return redirect()->route('commercialPowerMeterGroundCheckDoneListDist.index');
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function commercial_pending_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'commercial_app_pending';
            $heading = 'pending';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 3],
                    ['form_process_actions.form_pending', true],
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.commercialPower.pendingList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function commercial_pending_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'commercial_app_pending';
            $heading = 'pending';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin.commercialPower.pendingList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function commercial_pending_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;

            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->form_pending = false;
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->form_pending = admin()->id;
            $adminAction->save();
            return redirect()->route('commercialPowerMeterPendingForm.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function commercial_reject_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'commercial_app_reject';
            $heading = 'reject';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 3],
                    ['form_process_actions.form_reject', true],
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.commercialPower.rejectList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function commercial_reject_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'commercial_app_reject';
            $heading = 'reject';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $reject = FormProcessRemark::where([['application_form_id', $form_id], ['reject_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin.commercialPower.rejectList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'reject', 'pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    
    public function commercial_anno_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'commercial_app_announce';
            $heading = 'announce';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 3],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_confirm_dist', true],
                    ['form_process_actions.announce', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.commercialPower.announceList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_anno_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'commercial_app_announce';
            $heading = 'announce';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', 3], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin.commercialPower.announceList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_anno_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);

            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->announce = true;
            $action->announced_date = date('Y-m-d H:i:s');
            $action->user_pay = true;
            $action->user_paid_date = date('Y-m-d H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->announce=admin()->id;
            $adminAction->save();
            $expDate = Carbon::now()->addDay(7);

            // $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော စက်မှုသုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် အောက်ဖေါ်ပြပါ လင့်ခ် (Link) ကိုနှိပ်၍ ကျသင့်ငွေအား အွန်လိုင်းငွေချေစနစ်ဖြင့် ငွေပေးသွင်းနိုင်ပြီ ဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class="text-danger">'.$expDate->format('d-m-Y').' ၂:၀၀ နာရီ'.'</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားပါသည်။</p>';
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော စက်မှုသုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် လျှောက်လွှာအတွင်းပါရှိသော အထောက်အထားများ၏ မူရင်းများကို တပါတည်းယူဆောင်၍  သက်မှတ်ရက် ( <span class="text-danger">'.$expDate->format('d-m-Y').' ၂:၀၀ နာရီ'.'</span> ) ထက်နောက်မကျဘဲ ရုံးသို့ လူကိုယ်တိုင် လာရောက်ငွေသွင်းပေးပါရန် အကြောင်းကြားပါသည်။</p>';
            // $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.route('user_pay_form.create', $form_id).'" class="btn btn-info text-center">Click for payment</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form_id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 5;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();

            $header     = trans('lang.pay_form_title');
            $body       = trans('lang.pay_form_text',['meter'=>trans('lang.commercial_power_meter_no',['no'=>$form->serial_code]), 'date' => $expDate->format('d-m-Y')]);
            $remark     = '';
            // $link       = route('user_pay_form.create', $form_id);
			// $link_name  = trans('lang.click_for_payment');
			$link       = '';
            $link_name  = "";
            $from       = divType($form->div_state_id);
            Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));
            return redirect()->route('commercialPowerMeterAnnounceList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }
    
    public function commercial_payment_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'commercial_app_payment';
            $heading = 'confirm_payment';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 3],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.announce', true],
                    ['form_process_actions.payment_accept', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.commercialPower.paymentList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_payment_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'commercial_app_payment';
            $heading = 'confirm_payment';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $sub_type = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->first();
            $user_pay = Payment::where('application_form_id', $form_id)->first();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin.commercialPower.paymentList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending', 'sub_type', 'user_pay'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_payment_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'commercial_app_payment';
            $heading = 'confirm_payment';
            $form = ApplicationForm::find($form_id);
            $sub_type = InitialCost::where([['type', $form->apply_type], ['sub_type', $form->apply_sub_type]])->first();
            $user_pay = Payment::where('application_form_id', $form_id)->first();
            return view('admin.commercialPower.paymentList_create', compact('heading', 'active', 'form', 'sub_type', 'user_pay'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_payment_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;
            $paid_date = date('Y-m-d', strtotime($request->accept_date));

            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->payment_accept = true;
            $action->payment_accepted_date = $paid_date.' '.date('H:i:s');
            $path = public_path('storage/user_attachments/'.$form_id);
            $pathPDF = "user_attachments/".$form_id;
            if ($request->hasFile('payment_accepted_slips')) {
                foreach($request->file('payment_accepted_slips') as $slip){
                    $ext = $slip->getClientOriginalExtension();
                    $file = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $image = Image::make($slip);
                        $image->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $image->save($path.'/'.$file);
                    }else{ // pdf
                        //Upload File
                        $slip->storeAs($pathPDF,$file);
                    }
                    $data[] = $file;
                }
                $files  = implode(',', $data);
            }else{
                $files = null;
            }
            $action->payment_accepted_slips = $files;
            $action->payment_accepted_slip_nos = $request->payment_accepted_slip_nos;
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->payment_accept=admin()->id;
            $adminAction->save();
            
            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);
            // $pay_date = Payment::where('application_form_id', $form_id)->first()->created_at;
            $route = route('commercial_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('commercial_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('commercial_applied_form_mdy', $form->id);
            }
            
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ ('.date('d-m-Y', strtotime($paid_date)).')တွင် ငွေသွင်းလက်ခံ ရရှိပြီးဖြစ်ကြောင်း အကြောင်းကြားပါသည်။</p>';
            // add the payment slips to mail body
            $fpa = DB::table("form_process_actions")->where("application_form_id", $form->id)->first();
            $files = explode(",",$fpa->payment_accepted_slips);
            if(count($files)> 0){
                $payment_slips = "Payment Slips : </br>";
                $payment_slips .= '<div class="row">';
                foreach ($files as $file) {
                    $filename = asset('storage/user_attachments/'.$form->id.'/'.$file);
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    ;
                    if($file != ""){
                        if($ext != 'pdf'){
                            $payment_slips .= "<div class='col-md-2'><img src='".asset('storage/user_attachments/'.$form->id.'/'.$file)."' alt='".$file."' class='img-thumbnail'  data-toggle='modal' data-target='#myImg'></div>";
                        }else{
                            $payment_slips .= "<a href='".asset('storage/user_attachments/'.$form->id.'/'.$file)."' target='_blank' class='pdf-block'>".$file."</a>";
                        }
                    }
                }
                $payment_slips .= '</div>';
                $mail_body .= $payment_slips;
            }
            $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form_id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 6;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();

            $header     = trans('lang.receivepay_form_title');
            $body       = trans('lang.receivepay_form_text',['meter'=>trans('lang.commercial_power_meter_no',['no'=>$form->serial_code]),'date'=>(date('d-m-Y', strtotime($paid_date)))]);
            $remark     = '';
            $link       = $route;
            $link_name  = trans('lang.go_to_form');
            $from       = divType($form->div_state_id);
            $file_path  = public_path('storage/user_attachments/'.$form->id.'/');
            Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from, $files, $file_path));

            return redirect()->route('commercialPowerMeterPaymentList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }
    
    public function commercial_contract_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'commercial_app_contract';
            $heading = 'contract_menu';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 3],
                    ['form_process_actions.payment_accept', true],
                    ['form_process_actions.contract', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.commercialPower.contractList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_contract_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'commercial_app_contract';
            $heading = 'contract_menu';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', 3], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin.commercialPower.contractList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_contract_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'commercial_app_contract';
            $heading = 'contract_menu';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('admin.commercialPower.contractList_create', compact('heading', 'active', 'form', 'files'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_contract_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $id = $request->form_id;

            $action = FormProcessAction::where('application_form_id', $id)->first();
            $action->contract = true;
            $action->contracted_date = date('Y-m-d H:i:s');
            $action->save();
            
            $has_form16 = Form16::where('application_form_id', $id)->first();
            if ($has_form16) {
                $new = Form16::where('application_form_id', $id)->first();
                $new->applied_type = $request->applied_type;
                $new->date_from = $request->date_from;
                $new->date_to = $request->date_to;
                $new->elec_type = $request->elec_type;
                $new->volt = $request->volt;
                $new->kilowatt = $request->kilowatt;
                $new->why_to_use = $request->why_to_use;
                $new->temp_name = $request->temp_name;
                $new->temp_meter_no = $request->temp_meter_no;
                $new->other_name = $request->other_name;
                $new->other_meter_no = $request->other_meter_no;
                $new->finance_no = $request->finance_no;
                $new->name = $request->name;
                $new->job = $request->job;
                $new->nrc = $request->nrc;
                $new->date = $request->date;
                $new->save();
            } else {
                $new = new Form16();
                $new->application_form_id = $id;
                $new->applied_type = $request->applied_type;
                $new->date_from = $request->date_from;
                $new->date_to = $request->date_to;
                $new->elec_type = $request->elec_type;
                $new->volt = $request->volt;
                $new->kilowatt = $request->kilowatt;
                $new->why_to_use = $request->why_to_use;
                $new->temp_name = $request->temp_name;
                $new->temp_meter_no = $request->temp_meter_no;
                $new->other_name = $request->other_name;
                $new->other_meter_no = $request->other_meter_no;
                $new->finance_no = $request->finance_no;
                $new->name = $request->name;
                $new->job = $request->job;
                $new->nrc = $request->nrc;
                $new->date = $request->date;
                $new->save();
            }
            return redirect()->route('commercialPowerMeterContractList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }
    
    public function commercial_chk_install_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'commercial_app_chk_install';
            $heading = 'chk_install';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 3],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.payment_accept', true],
                    ['form_process_actions.install_accept', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.commercialPower.installList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_chk_install_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'commercial_app_chk_install';
            $heading = 'chk_install';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', 3], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin.commercialPower.installList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_chk_install_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'commercial_app_chk_install';
            $heading = 'chk_install';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('admin.commercialPower.installList_create', compact('heading', 'active', 'form', 'files'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_chk_install_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $action = FormProcessAction::where('application_form_id', $request->form_id)->first();
            $action->install_accept = true;
            $action->install_accepted_date = date('Y-m-d', strtotime($request->accept_date)).' '.date('H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $request->form_id)->first();
            $adminAction->install_accept = admin()->id;
            $adminAction->save();

            $form138 = new Form138();
            $form138->application_form_id = $request->form_id;
            $form138->form_send_date = $request->form_send_date;
            $form138->form_get_date = $request->form_get_date;
            $form138->description = $request->description;
            $form138->cash_kyat = $request->cash_kyat;
            $form138->calculator = $request->calculator;
            $form138->calcu_date = $request->calcu_date;
            $form138->payment_form_no = $request->payment_form_no;
            $form138->payment_form_date = $request->payment_form_date;
            $form138->deposite_form_no = $request->deposite_form_no;
            $form138->deposite_form_date = $request->deposite_form_date;
            $form138->somewhat = $request->somewhat;
            $form138->somewhat_form_date = $request->somewhat_form_date;
            $form138->string_form_date = $request->string_form_date;
            $form138->service_string_form_date = $request->service_string_form_date;
            $form138->save();
            return redirect()->route('commercialPowerMeterCheckInstallList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }
    
    public function commercial_install_done_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'commercial_app_install_done';
            $heading = 'chk_install_done';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 3],
                    ['form_process_actions.install_accept', true],
                    ['form_process_actions.install_confirm', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin/commercialPower/installDoneList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_install_done_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'commercial_app_install_done';
            $heading = 'chk_install_done';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', 3], ['sub_type', $data->apply_sub_type]])->get();

            $survey_result = FormSurvey::where('application_form_id', $form_id)->first();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $install = Form138::where('application_form_id',$form_id)->first();
            $install_date = $action = FormProcessAction::where('application_form_id', $form_id)->first()->install_accepted_date;
            return view('admin/commercialPower/installDoneList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending', 'install', 'install_date'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_install_done_list_create(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // $action = FormProcessAction::where('application_form_id', $form_id)->first();
            // $action->install_confirm = true;
            // $action->install_confirmed_date = date('Y-m-d H:i:s');
            // $action->save();
            $this->validate($request, [
                'form_id' => 'required',
                'front' => 'required',
                'ei_remark' => 'required',
            ]);
            // dd($request->all());
            $form = ApplicationForm::find($request->form_id);
            $folder_name = $form->id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            $tmp_arr = [];
            if ($request->hasFile('front')) {
                foreach($request->file('front') as $front){
                    $ext = $front->getClientOriginalExtension();
                    $file = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $image = Image::make($front);
                        $image->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $image->save($path.'/'.$file);
                    }else{ // pdf
                        //Upload File
                        $front->storeAs($pathPDF,$file);
                    }
                    $data[] = $file;
                }
                $files  = implode(',', $data);
            }else{
                $files = null;
            }

            $new = new FormEiChk();
            $new->application_form_id = $form->id;
            $new->ei_files = $files;
            $new->ei_remark = $request->ei_remark;
            $new->save();   

            $action = FormProcessAction::where('application_form_id', $form->id)->first();
            $action ->install_confirm = true;
            $action->install_confirmed_date = date('Y-m-d H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form->id)->first();
            $adminAction->install_confirm = admin()->id;
            $adminAction->save();
            return redirect()->route('commercialPowerMeterInstallationDoneList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function commercial_reg_meter_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'commercial_app_reg_meter';
            $heading = 'reg_meter';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 3],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.install_confirm', true],
                    ['form_process_actions.register_meter', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.commercialPower.regMeterList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_reg_meter_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'commercial_app_reg_meter';
            $heading = 'reg_meter';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', 3], ['sub_type', $data->apply_sub_type]])->get();
            $install = Form138::where('application_form_id',$form_id)->first();
            $install_date = $action = FormProcessAction::where('application_form_id', $form_id)->first()->install_accepted_date;

            $ei_data = FormEiChk::where('application_form_id', $form_id)->first();

            return view('admin/commercialPower/regMeterList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending', 'install', 'install_date','ei_data'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_reg_meter_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'commercial_app_reg_meter';
            $heading = 'reg_meter';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('admin.commercialPower.regMeterList_create', compact('heading', 'active', 'form', 'files'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function commercial_reg_meter_list_store(Request $request) {
        // dd($request->all());
        if (isset($_SERVER['HTTP_REFERER'])) {
            $id = $request->form_id;

            $action = FormProcessAction::where('application_form_id', $id)->first();
            $action->register_meter = true;
            $action->registered_meter_date = date('Y-m-d H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $id)->first();
            $adminAction->register_meter=admin()->id;
            $adminAction->save();
            
            $remark = new Form66();
            $remark->application_form_id = $id;
            $remark->meter_no = $request->meter_no;
            $remark->meter_unit_no = $request->meter_unit_no;
            $remark->cover_seal_no = $request->cover_seal_no;
            $remark->terminal_seal_no = $request->terminal_seal_no;
            $remark->box_seal_no = $request->box_seal_no;
            $remark->ledger_no = $request->ledger_no;
            $remark->meter_get_date = $request->meter_get_date != '' ? date('Y-m-d', strtotime($request->meter_get_date)): null;
            $remark->who_made_meter = $request->who_made_meter;
            $remark->ampere = $request->ampere;
            $remark->pay_date = $request->pay_date != "" ? date('Y-m-d', strtotime($request->pay_date)) : null;
            // $remark->mark_user_no = $request->mark_user_no;
            $remark->budget = $request->budget;
            $remark->move_date = $request->move_date != '' ? date('Y-m-d', strtotime($request->move_date)) : null;
            $remark->move_budget = $request->move_budget;
            $remark->move_order = $request->move_order;
            $remark->test_date = $request->test_date != "" ? date('Y-m-d', strtotime($request->test_date)) : null;
            $remark->test_no = $request->test_no;
            $remark->installer_name = $request->installer_name;
            $remark->installer_post = $request->installer_post;
            $remark->remark = $request->remark;
            $remark->save();
            return redirect()->route('commercialPowerMeterRegisterMeterList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }
    //--------------------------------------------------------------------------------------------//

    /* --------------------------------------------------------------------------------------------- */
    // Contractor Power Start
    public function contractor_applied_form_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $heading = 'residentApplication';
            $active = 'contractor_app_form';
            
            if(admin()->group_lvl == '1' || admin()->group_lvl == '2'){
                 $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 5],
                    ['form_process_actions.user_send_to_office', true],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.register_meter', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            }else{
                if(admin()->group_lvl == '6'){
                    $val = admin()->township;
                    $field = 'application_forms.township_id';
                    
                }elseif(admin()->group_lvl == '5'){
                    $val = admin()->district;
                    $field = 'application_forms.district_id';
                }elseif(admin()->group_lvl == '4'){
                    $val	 = admin()->div_state;
                    $field = 'application_forms.div_state_id';
                }
                
                    $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 5],
                    [$field, $val],
                    ['form_process_actions.user_send_to_office', true],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.register_meter', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            }
            
            // $form = DB::table('application_forms')
            //     ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
            //     ->where([
            //         ['application_forms.apply_type', 5],
            //         ['form_process_actions.user_send_to_office', true],
            //         ['form_process_actions.form_reject', false],
            //         ['form_process_actions.form_pending', false],
            //         ['form_process_actions.register_meter', false]
            //     ])
            //     ->when($name, function ($query, $name) {
            //         return $query->where('application_forms.fullname', $name);
            //     })
            //     ->when($serial, function ($query, $serial) {
            //         return $query->where('application_forms.serial_code', $serial);
            //     })
            //     ->select('application_forms.*')
            //     ->paginate(10);
            // $form->appends(request()->query());
            return view('admin.contractor.applicationForm_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_applied_form_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $heading = 'residentApplication';
            $active = 'contractor_app_form';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            return view('admin/contractor/applicationForm_show', compact('active', 'heading', 'data', 'files','error','pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function contractor_form_error_send_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // dd($request->all());
            $this->validate($request, [
                'remark' => 'required',
            ]);
            
            $form = ApplicationForm::find($request->form_id);
            $user = User::find($form->user_id);

            $action = FormProcessAction::where('application_form_id', $request->form_id)->first();
            $action->user_send_to_office = 0;
            $action->save();
            
            $remark = new FormProcessRemark();
            $remark->application_form_id = $request->form_id;
            $remark->error_remark = $request->remark;
            $remark->who_did_this = admin()->id;
            $remark->save();

            $route = route('contractor_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('contractor_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('contractor_applied_form_mdy', $form->id);
            }
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော ကန်ထရိုက်တိုက်မီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ လိုအပ်ချက်များရှိနေပါသောကြောင့် အောက်ဖေါ်ပြပါ အကြောင်းအရာများကို ကြည့်ရှုစစ်ဆေးပြီး ပြန်လည်ပေးပို့ပေးပါရန် အကြောင်းကြားပါသည်။</p>';
            $mail_body .= '<div class="mt-3 mb-5">'.$request->remark.'</div>';
            $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form->id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 1;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();
           
            $header     = trans('lang.required_form_title');
            $body       = trans('lang.required_form_text',['meter'=>trans('lang.contractor_meter_no',['no'=>$form->serial_code])]);
            $remark     = '<div class="remark-danger">&#10039; '.$request->remark.'</div>';
            $link       = $route;
            $link_name  = trans('lang.go_to_form');
            $from       = divType($form->div_state_id);
            Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));

            return redirect()->route('contractorMeterApplicationList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function contractor_form_accept($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);

            $new = FormProcessAction::where('application_form_id', $form_id)->first();
            $new->form_accept = 1;
            $new->accepted_date = date('Y-m-d H:i:s');
            $new->save();

            $adminAction = new AdminAction();
            $adminAction->application_form_id = $form_id;
            $adminAction->form_accept=admin()->id;
            $adminAction->save();

            $route = route('contractor_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('contractor_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('contractor_applied_form_mdy', $form->id);
            }
            // $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော ကန်ထရိုက်တိုက်မီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားပါသည်။</p>';
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော စက်မှုသုံးမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class="text-danger">'.$expDate->format('d-m-Y').' ၂:၀၀ နာရီ'.'</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားပါသည်။</p>';
            $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form_id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 2;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();

            $header     = trans('lang.accept_form_title');
            $body       = trans('lang.accept_form_text',['meter'=>trans('lang.contractor_meter_no',['no'=>$form->serial_code])]);
            $remark     = '';
            $link       = $route;
            $link_name  = trans('lang.go_to_form');
            $from       = divType($form->div_state_id);
            Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));

            return redirect()->route('contractorMeterApplicationList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function contractor_grd_chk_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'contractor_app_survey';
            $heading = 'residentSurvey';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 5],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.form_accept', true],
                    ['form_process_actions.survey_accept', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.contractor.surveyList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_grd_chk_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_survey';
            $heading = 'residentSurvey';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;

            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $c_form = ApplicationFormContractor::where('application_form_id', $form_id)->first();

            $form = ApplicationForm::find($form_id);
            $engineerLists = Admin::where('div_state', $form->div_state_id)->where('district', $form->district_id)->where('township', $form->township_id)->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', 3], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin/contractor/surveyList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names','engineerLists', 'data', 'files','error','pending','c_form'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_grd_chk_list_choose_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_survey';
            $heading = 'residentSurvey';
            $form = ApplicationForm::find($form_id);
            // $engineerLists = Admin::where('div_state', $form->div_state_id)->where('district', $form->district_id)->where('township', $form->township_id)->where('group_lvl', 6)->get();
            
            $files = $form->application_files;
            return view('admin.contractor.surveyChoose_create', compact('heading', 'active', 'form', 'files','engineerLists'));
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function contractor_grd_chk_list_choose_store(Request $request) {
        // return dd($request->all());
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'engineer_id' => 'required',
            ]);
            $id = $request->form_id;
            $engineerId = $request->engineer_id;
            $survey = new FormSurvey();
            $survey->application_form_id = $id;
            $survey->survey_engineer = $engineerId;
            $survey->save();

            $adminAction = AdminAction::where('application_form_id', $id)->first();
            $adminAction->survey_accept=admin()->id;
            $adminAction->save();
            return redirect()->route('contractorMeterGroundCheckList.show',$id);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function contractor_grd_chk_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_survey';
            $heading = 'residentSurvey';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $c_form = ApplicationFormContractor::where('application_form_id', $form_id)->first();
            return view('admin.contractor.surveyList_create', compact('heading', 'active', 'form', 'c_form', 'files', 'survey_result'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_grd_chk_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // dd($request->all());
            $form_id = $request->form_id;
            $date = date('Y-m-d H:i:s');

            $loaded = false;
            if ($request->loaded == 'on') {
                $loaded = true;
            }

            $new = FormSurvey::where('application_form_id', $form_id)->first();
            $new->survey_date = $date;
            $new->loaded = $loaded;
            $new->amp = $request->amp;
            $new->meter_count = $request->meter_count;
            $new->pMeter10 = $request->pMeter10_count;
            $new->pMeter20 = $request->pMeter20_count;
            $new->pMeter30 = $request->pMeter30_count;
            $new->water_meter_count = $request->water_meter_count;
            $new->water_meter_type = $request->water_meter_type;
            $new->elevator_meter_count = $request->elevator_meter_count;
            $new->elevator_meter_type = $request->elevator_meter_type;

            $new->tsf_transmit_distance_feet = $request->tsf_transmit_distance_feet;
            $new->tsf_transmit_distance_kv = $request->tsf_transmit_distance_kv;
            $new->exist_transformer = $request->exist_transformer;
            $new->remark = $request->remark;

            $folder_name = $form_id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            if ($request->hasFile('location_map')) {
                $location_map_ext = $request->file('location_map')->getClientOriginalExtension();
                $location_map_save_img = get_random_string().'_'.getdate()[0].'.'.$location_map_ext;
                if($location_map_ext != 'pdf'){ // jpg, png
                    $location_map_img = Image::make($request->file('location_map'));
                    $location_map_img->resize(800, 800);
                    $location_map_img->save($path.'/'.$location_map_save_img);
                }else{ // pdf
                    //Upload File
                    $request->file('location_map')->storeAs($pathPDF,$location_map_save_img);
                }
                $new->location_map = $location_map_save_img;
            }
            $new->save();

            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->survey_accept = true;
            $action->survey_accepted_date = $date;
            $action->save();

            return redirect()->route('contractorMeterGroundCheckList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function contractor_grd_chk_list_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_survey';
            $heading = 'residentSurveyDone';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $c_form = ApplicationFormContractor::where('application_form_id', $form_id)->first();
            return view('admin/contractor/surveyList_edit', compact('heading', 'active', 'form', 'c_form', 'files', 'survey_result'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_grd_chk_list_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // dd($request->all());
            $form_id = $request->form_id;
            $date = date('Y-m-d H:i:s');

            $loaded = false;
            if ($request->loaded == 'on') {
                $loaded = true;
            }

            $new = FormSurvey::where('application_form_id', $form_id)->first();
            $new->survey_date = $date;
            $new->loaded = $loaded;
            $new->amp = $request->amp;
            $new->meter_count = $request->meter_count;
            $new->pMeter10 = $request->pMeter10_count;
            $new->pMeter20 = $request->pMeter20_count;
            $new->pMeter30 = $request->pMeter30_count;
            $new->water_meter_count = $request->water_meter_count;
            $new->water_meter_type = $request->water_meter_type;
            $new->elevator_meter_count = $request->elevator_meter_count;
            $new->elevator_meter_type = $request->elevator_meter_type;

            $new->tsf_transmit_distance_feet = $request->tsf_transmit_distance_feet;
            $new->tsf_transmit_distance_kv = $request->tsf_transmit_distance_kv;
            $new->exist_transformer = $request->exist_transformer;
            $new->remark = $request->remark;

            $folder_name    = $form_id;
            $path           = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF        = "user_attachments/".$folder_name;
            if ($request->hasFile('location_map')) {
                $location_map_ext = $request->file('location_map')->getClientOriginalExtension();
                $location_map_save_img = get_random_string().'_'.getdate()[0].'.'.$location_map_ext;
                if($location_map_ext != 'pdf'){ // jpg, png
                    $location_map_img = Image::make($request->file('location_map'));
                    $location_map_img->resize(800, 800);
                    $location_map_img->save($path.'/'.$location_map_save_img);
                }else{ // pdf
                    //Upload File
                    $request->file('location_map')->storeAs($pathPDF,$location_map_save_img);
                }

                if (file_exists(public_path('storage/user_attachments/'.$form_id).'/'.$new->location_map) && $new->location_map != '') {
                    unlink(public_path('storage/user_attachments/'.$form_id).'/'.$new->location_map);
                }

                $new->location_map = $location_map_save_img;
            }

            $new->save();

            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->survey_accept = true;
            $action->survey_accepted_date = $date;
            $action->save();

            return redirect()->route('contractorMeterGroundCheckDoneList.show',$form_id);
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function contractor_grd_done_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'contractor_app_gnd_done';
            $heading = 'residentSurveyDone';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 5],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_accept', true],
                    ['form_process_actions.survey_confirm', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.contractor.surveyDoneList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_grd_done_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_gnd_done';
            $heading = 'residentSurveyDone';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();

            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();

            return view('admin/contractor/surveyDoneList_show', compact('pending','active', 'heading','data', 'files','error','survey_result'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_grd_done_list_create($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_gnd_done';
            $heading = 'residentSurveyDone';
            $form = ApplicationForm::find($form_id);
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            return view('admin.contractor.surveyDoneList_create', compact('active', 'heading', 'form', 'survey_result'));
        // } else {
        //     return redirect()->route('dashboard');
        // }
    }
    public function contractor_grd_done_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // dd($request->all());
            $form_id = $request->form_id;
            /* ခရိုင်သို့ တင်ပြ  */
            $date = date('Y-m-d H:i:s');

            $form = ApplicationForm::find($form_id);
            $folder_name = $form->id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            $tmp_arr1 = [];
            $tmp_arr2 = [];
            $bq_img_str = null;
            $location_img_str = null;
            
            if ($request->hasFile('bq_files')) {
                foreach ($request->file('bq_files') as $key => $value) {
                    $ext = $value->getClientOriginalExtension();
                    $save_db_img = get_random_string().'_'.getdate()[0].'.'.$ext;

                    if($ext != 'pdf'){ // jpg, png
                        $image = Image::make($value);
                        $image->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $image->save($path.'/'.$save_db_img);
                    }else{ // pdf
                        //Upload File
                        $value->storeAs($pathPDF,$save_db_img);
                    }
                    array_push($tmp_arr1, $save_db_img);
                }
                $bq_img_str = implode(',', $tmp_arr1);
            }
            if ($request->hasFile('location_files')) {
                foreach ($request->file('location_files') as $key => $value) {
                    $ext = $value->getClientOriginalExtension();
                    $save_db_img2 = get_random_string().'_'.getdate()[0].'.'.$ext;

                    if($ext != 'pdf'){ // jpg, png
                        $image = Image::make($value);
                        $image->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $image->save($path.'/'.$save_db_img2);
                    }else{ // pdf
                        //Upload File
                        $value->storeAs($pathPDF,$save_db_img2);
                    }
                    array_push($tmp_arr2, $save_db_img2);
                }
                $location_img_str = implode(',', $tmp_arr2);
            }

            $path = public_path('storage/user_attachments/'.$form_id);
            $pathPDF = "user_attachments/".$form_id;

            if ($request->hasFile('tsp_recomm')) {
                $ext = $request->file('tsp_recomm')->getClientOriginalExtension();
                $file = get_random_string().'_'.getdate()[0].'.'.$ext;
                if($ext != 'pdf'){ // jpg, png
                    $image = Image::make($request->file('tsp_recomm'));
                    $image->resize(800, 800, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $image->save($path.'/'.$file);
                }else{ // pdf
                    //Upload File
                    $request->file('tsp_recomm')->storeAs($pathPDF,$file);
                }
            }else{
                $file = null;
            }

            $new = FormSurvey::where('application_form_id', $form_id)->first();
            $new->new_tsf_name = $request->new_tsf_name;
            $new->new_tsf_distance = $request->new_tsf_distance;
            $new->distance_04 = $request->distance_04;
            $new->new_line_type = $request->new_line_type;
            $new->new_tsf_info_volt = $request->new_tsf_info_volt;
            $new->new_tsf_info_kv = $request->new_tsf_info_kv;
            $new->new_tsf_info_volt_two = $request->new_tsf_info_volt_two;
            $new->new_tsf_info_kv_two = $request->new_tsf_info_kv_two;
            $new->bq_cost = $request->bq_cost;
            if ($bq_img_str) {
                $new->bq_cost_files = $bq_img_str;
            }
            $new->budget_name = $request->budget_name;
            $new->longitude = $request->longitude;
            $new->latitude = $request->latitude;
            if ($location_img_str) {
                $new->location_files = $location_img_str;
            }
            $new->remark_tsp = $request->remark_tsp;
            if ($file != null) {
                // delete old file
                if (file_exists(public_path('storage/user_attachments/'.$form_id).'/'.$new->tsp_recomm) && $new->tsp_recomm != '') {
                    unlink(public_path('storage/user_attachments/'.$form_id).'/'.$new->tsp_recomm);
                }
                $new->tsp_recomm = $file;
            }
            $new->save();

            $send_from_to = new FormRoutine();
            $send_from_to->application_form_id = $form_id;
            $send_from_to->send_from = 1;
            $send_from_to->send_to = 2;
            $send_from_to->save();

            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->survey_confirm = true;
            $action->survey_confirmed_date = $date;
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->survey_confirm=admin()->id;
            $adminAction->save();
            return redirect()->route('contractorMeterGroundCheckDoneList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function contractor_grd_done_list_by_dist(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'contractor_app_gnd_done_dist';
            $heading = 'residentSurveyDone';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 5],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_confirm', true],
                    ['form_process_actions.survey_confirm_dist', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.contractor.surveyDoneListDist_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_grd_done_list_show_by_dist($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_gnd_done_dist';
            $heading = 'residentSurveyDoneDist';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();

            return view('admin.contractor.surveyDoneList_show', compact('active', 'heading', 'data', 'files','error','survey_result','pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_grd_done_list_create_by_dist($form_id) {
        // if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_gnd_done_dist';
            $heading = 'residentSurveyDone';
            $form = ApplicationForm::find($form_id);
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            return view('admin.contractor.surveyDoneList_create_dist', compact('active', 'heading', 'form', 'survey_result'));
        // } else {
        //     return redirect()->route('dashboard');
        // }
    }
    public function contractor_grd_done_list_store_by_dist(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // dd($request->all());
            $form_id = $request->form_id;

            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);
            $route = route('contractor_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('contractor_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('contractor_applied_form_mdy', $form->id);
            }
            /* ခရိုင်မှ တိုင်းသို့ တင်ပြ */
            $date = date('Y-m-d H:i:s');

            if ($request->survey_submit_district == 'send') {
                $date = date('Y-m-d H:i:s');
                $form = ApplicationForm::find($form_id);
                $folder_name = $form->id;
                $path = public_path('storage/user_attachments/'.$folder_name);
                $pathPDF = "user_attachments/".$folder_name;
                $tmp_arr = [];
                
                $bq_img_str = null;
                
                if ($request->hasFile('bq_files')) {
                    foreach ($request->file('bq_files') as $key => $value) {
                        $ext = $value->getClientOriginalExtension();
                        $save_db_img = get_random_string().'_'.getdate()[0].'.'.$ext;
                        if($ext != 'pdf'){ // jpg, png
                            $image = Image::make($value);
                            $image->resize(800, 800, function($constraint) {
                                $constraint->aspectRatio();
                            });
                            $image->save($path.'/'.$save_db_img);
                        }else{ // pdf
                            //Upload File
                            $value->storeAs($pathPDF,$save_db_img);
                        }
                        array_push($tmp_arr, $save_db_img);
                    }
                    $bq_img_str = implode(',', $tmp_arr);
                }

                $path = public_path('storage/user_attachments/'.$form_id);
                $pathPDF = "user_attachments/".$form_id;

                if ($request->hasFile('dist_recomm')) {
                    $ext = $request->file('dist_recomm')->getClientOriginalExtension();
                    $file = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $image = Image::make($request->file('dist_recomm'));
                        $image->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $image->save($path.'/'.$file);
                    }else{ // pdf
                        //Upload File
                        $request->file('dist_recomm')->storeAs($pathPDF,$file);
                    }
                }else{
                    $file = null;
                }

                $bq_cost = FormSurvey::where('application_form_id', $form_id)->first();
                $bq_cost->bq_cost_dist = $request->bq_cost_dist;
                if ($bq_img_str) {
                    $bq_cost->bq_cost_dist_files = $bq_img_str;
                }
                $bq_cost->remark_dist = $request->remark_dist;
                if($file != null){
                    // delete old file
                    if (file_exists(public_path('storage/user_attachments/'.$form_id).'/'.$bq_cost->dist_recomm) && $bq_cost->dist_recomm != '') {
                        unlink(public_path('storage/user_attachments/'.$form_id).'/'.$bq_cost->dist_recomm);
                    }
                    $bq_cost->dist_recomm = $file;
                }
                $bq_cost->save();

                $send_from_to = new FormRoutine();
                $send_from_to->application_form_id = $form_id;
                $send_from_to->send_from = 2;
                $send_from_to->send_to = 3;
                $send_from_to->save();

                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->survey_confirm_dist = true;
                $action->survey_confirmed_dist_date = $date;
                $action->save();

                $adminAction = AdminAction::where('application_form_id', $form_id)->first();
                $adminAction->survey_confirm_dist=admin()->id;
                $adminAction->save();
            } elseif ($request->survey_submit_district == 'resend') {
                $send_from_to = new FormRoutine();
                $send_from_to->application_form_id = $form_id;
                $send_from_to->send_from = 2;
                $send_from_to->send_to = 1;
                $send_from_to->remark = $request->dist_remark;
                $send_from_to->type = 'resend';
                $send_from_to->office_send_date = $date;
                $send_from_to->save();

                $survey = FormSurvey::where('application_form_id',$form_id)->first();
                $survey->remark_dist = $request->remark_dist;
                $survey->save();
                
                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->survey_confirm = false;
                $action->save();
            } elseif ($request->survey_submit_district == 'pending') {
                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->form_pending = true;
                $action->pending_date = $date;
                $action->save();
            
                $remark = new FormProcessRemark();
                $remark->application_form_id = $form_id;
                $remark->pending_remark = $request->dist_remark;
                $remark->who_did_this = admin()->id;
                $remark->save();
                
                $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော ကန်ထရိုက်တိုက်မီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ခေတ္တဆိုင်းငံ့ထားပါကြောင်း အကြောင်းကြားပါသည်။</p>';
                $mail_body .= '<div class="mt-3 mb-5">'.$request->dist_remark.'</div>';
                $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

                $mail = new MailTbl();
                $mail->application_form_id = $form_id;
                $mail->user_id = $form->user_id;
                $mail->sender_id = admin()->id;
                $mail->send_type = 3;
                $mail->mail_send_date = date('Y-m-d H:i:s');
                $mail->mail_body = $mail_body;
                $mail->save();

                $header     = trans('lang.suspend_form_title');
                $body       = trans('lang.suspend_form_text',['meter'=>trans('lang.contractor_meter_no',['no'=>$form->serial_code])]);
                $remark     = '<div class="remark-danger">&#10039; '.$request->dist_remark.'</div>';
                $link       = $route;
                $link_name  = trans('lang.go_to_form');
                $from       = divType($form->div_state_id);
                Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));

            } elseif ($request->survey_submit_district == 'reject') {
                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->form_reject = true;
                $action->reject_date = $date;
                $action->save();
            
                $remark = new FormProcessRemark();
                $remark->application_form_id = $form_id;
                $remark->reject_remark = $request->dist_remark;
                $remark->who_did_this = admin()->id;
                $remark->save();

                $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော ကန်ထရိုက်တိုက်မီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ပယ်ဖျက်လိုက်ကြောင်း အကြောင်းကြားပါသည်။</p>';
                $mail_body .= '<div class="mt-3 mb-5">'.$request->dist_remark.'</div>';
                $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

                $mail = new MailTbl();
                $mail->application_form_id = $form_id;
                $mail->user_id = $form->user_id;
                $mail->sender_id = admin()->id;
                $mail->send_type = 4;
                $mail->mail_send_date = date('Y-m-d H:i:s');
                $mail->mail_body = $mail_body;
                $mail->save();

                $header     = trans('lang.delete_form_title');
                $body       = trans('lang.delete_form_text',['meter'=>trans('lang.contractor_meter_no',['no'=>$form->serial_code])]);
                $remark     = '<div class="remark-danger">&#10039; '.$request->dist_remark.'</div>';
                $link       = $route;
                $link_name  = trans('lang.go_to_form');
                $from       = divType($form->div_state_id);
                Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));
            }

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->survey_confirm_dist = admin()->id;
            $adminAction->save();
            return redirect()->route('contractorMeterGroundCheckDoneListByDistrict.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function contractor_grd_done_list_by_div_state(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'contractor_app_gnd_done_div_state';
            $heading = 'residentSurveyDoneDivstate';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 5],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_confirm_dist', true],
                    ['form_process_actions.survey_confirm_div_state', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.contractor.surveyDoneListDivstate_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_grd_done_list_show_by_div_state($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_gnd_done_div_state';
            $heading = 'residentSurveyDoneDivstate';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();

            return view('admin.contractor.surveyDoneList_show', compact('active', 'heading', 'data', 'files','error','survey_result','pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_grd_done_list_create_by_div_state($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_gnd_done_div_state';
            $heading = 'residentSurveyDone';
            $form = ApplicationForm::find($form_id);
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            return view('admin.contractor.surveyDoneList_create_div_state', compact('active', 'heading', 'form', 'survey_result'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_grd_done_list_store_by_div_state(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // dd($request->all());
            $form_id = $request->form_id;

            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);
            $route = route('contractor_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('contractor_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('contractor_applied_form_mdy', $form->id);
            }
            $date = date('Y-m-d H:i:s');

            if ($request->survey_confirm_by_divstate == 'approve') {
                $date = date('Y-m-d H:i:s');
                $form = ApplicationForm::find($form_id);
                $folder_name = $form->id;
                $path = public_path('storage/user_attachments/'.$folder_name);
                $pathPDF = "user_attachments/".$folder_name;
                $tmp_arr = [];
                
                $bq_img_str = null;
                
                if ($request->hasFile('bq_files')) {
                    foreach ($request->file('bq_files') as $key => $value) {
                        $ext = $value->getClientOriginalExtension();
                        $save_db_img = get_random_string().'_'.getdate()[0].'.'.$ext;
                        if($ext != 'pdf'){
                            $save_file_img = Image::make($value);
                            $save_file_img->resize(800, 800, function($constraint) {
                                $constraint->aspectRatio();
                            });
                            $save_file_img->save($path.'/'.$save_db_img);
                        }else{ // pdf
                            //Upload File
                            $value->storeAs($pathPDF,$save_db_img);
                        }
                        array_push($tmp_arr, $save_db_img);
                    }
                    $bq_img_str = implode(',', $tmp_arr);
                }

                $bq_cost = FormSurvey::where('application_form_id', $form_id)->first();
                $bq_cost->bq_cost_div_state = $request->bq_cost_div_state;
                if ($bq_img_str) {
                    $bq_cost->bq_cost_div_state_files = $bq_img_str;
                }
                $bq_cost->save();

                $send_from_to = new FormRoutine();
                $send_from_to->application_form_id = $form_id;
                $send_from_to->send_from = 3;
                $send_from_to->send_to = 1;
                $send_from_to->save();


                $send_from_to1 = new FormRoutine();
                $send_from_to1->application_form_id = $form_id;
                $send_from_to1->send_from = 3;
                $send_from_to1->send_to = 2;
                $send_from_to1->office_send_date = $date;
                $send_from_to1->save();

                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->survey_confirm_div_state = true;
                $action->survey_confirmed_div_state_date = date('Y-m-d H:i:s');
                $action->save();

                $adminAction = AdminAction::where('application_form_id', $form_id)->first();
                $adminAction->survey_confirm_div_state=admin()->id;
                $adminAction->save();
            }elseif ($request->survey_confirm_by_divstate == 'resend') {
                $send_from_to = new FormRoutine();
                $send_from_to->application_form_id = $form_id;
                $send_from_to->send_from = 3;
                $send_from_to->send_to = 2;
                $send_from_to->remark = $request->div_state_remark;
                $send_from_to->type = 'resend';
                $send_from_to->save();

                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->survey_confirm_dist = false;
                $action->save();
            } elseif ($request->survey_confirm_by_divstate == 'pending') {
                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->form_pending = true;
                $action->pending_date = $date;
                $action->save();
            
                $remark = new FormProcessRemark();
                $remark->application_form_id = $form_id;
                $remark->pending_remark = $request->div_state_remark;
                $remark->who_did_this = admin()->id;
                $remark->save();
                
                $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော ကန်ထရိုက်တိုက်မီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ခေတ္တဆိုင်းငံ့ထားပါကြောင်း အကြောင်းကြားပါသည်။</p>';
                $mail_body .= '<div class="mt-3 mb-5">'.$request->div_state_remark.'</div>';
                $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

                $mail = new MailTbl();
                $mail->application_form_id = $form_id;
                $mail->user_id = $form->user_id;
                $mail->sender_id = admin()->id;
                $mail->send_type = 3;
                $mail->mail_send_date = date('Y-m-d H:i:s');
                $mail->mail_body = $mail_body;
                $mail->save();

                $header     = trans('lang.suspend_form_title');
                $body       = trans('lang.suspend_form_text',['meter'=>trans('lang.contractor_meter_no',['no'=>$form->serial_code])]);
                $remark     = '<div class="remark-danger">&#10039; '.$request->div_state_remark.'</div>';
                $link       = $route;
                $link_name  = trans('lang.go_to_form');
                $from       = divType($form->div_state_id);
                Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));

            } elseif ($request->survey_confirm_by_divstate == 'reject') {
                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->form_reject = true;
                $action->reject_date = $date;
                $action->save();
            
                $remark = new FormProcessRemark();
                $remark->application_form_id = $form_id;
                $remark->reject_remark = $request->div_state_remark;
                $remark->who_did_this = admin()->id;
                $remark->save();

                $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော ကန်ထရိုက်တိုက်မီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ပယ်ဖျက်လိုက်ကြောင်း အကြောင်းကြားပါသည်။</p>';
                $mail_body .= '<div class="mt-3 mb-5">'.$request->div_state_remark.'</div>';
                $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

                $mail = new MailTbl();
                $mail->application_form_id = $form_id;
                $mail->user_id = $form->user_id;
                $mail->sender_id = admin()->id;
                $mail->send_type = 4;
                $mail->mail_send_date = date('Y-m-d H:i:s');
                $mail->mail_body = $mail_body;
                $mail->save();

                $header     = trans('lang.delete_form_title');
                $body       = trans('lang.delete_form_text',['meter'=>trans('lang.contractor_meter_no',['no'=>$form->serial_code])]);
                $remark     = '<div class="remark-danger">&#10039; '.$request->div_state_remark.'</div>';
                $link       = $route;
                $link_name  = trans('lang.go_to_form');
                $from       = divType($form->div_state_id);
                Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));
                
            }

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->survey_confirm_div_state = admin()->id;
            $adminAction->survey_confirm_div_state_to_headoffice = admin()->id;
            $adminAction->save();

            return redirect()->route('contractorMeterGroundCheckDoneListByDivisionState.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function contractor_pending_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'contractor_app_pending';
            $heading = 'pending';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 5],
                    ['form_process_actions.form_pending', true],
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.contractor.pendingList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_pending_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_pending';
            $heading = 'pending';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin.contractor.pendingList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_pending_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;

            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->form_pending = false;
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->form_pending = admin()->id;
            $adminAction->save();
            return redirect()->route('contractorMeterPendingForm.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function contractor_reject_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'contractor_app_reject';
            $heading = 'reject';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 5],
                    ['form_process_actions.form_reject', true],
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.contractor.rejectList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_reject_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_reject';
            $heading = 'reject';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $reject = FormProcessRemark::where([['application_form_id', $form_id], ['reject_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin.contractor.rejectList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'reject', 'pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function contractor_anno_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'contractor_app_announce';
            $heading = 'announce';
            
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 5],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_confirm_div_state', true],
                    ['form_process_actions.announce', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            
            $form->appends(request()->query());
            return view('admin.contractor.announceList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_anno_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_announce';
            $heading = 'announce';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            return view('admin.contractor.announceList_show', compact('active', 'heading', 'data', 'files','error','survey_result'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_anno_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);
            $expDate = Carbon::now()->addDay(7);

            // $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော ကန်ထရိုက်တိုက်မီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် အောက်ဖေါ်ပြပါ လင့်ခ် (Link) ကိုနှိပ်၍ ကျသင့်ငွေအား အွန်လိုင်းငွေချေစနစ်ဖြင့် ငွေပေးသွင်းနိုင်ပြီ ဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class="text-danger">'.$expDate->format('d-m-Y').' ၂:၀၀ နာရီ'.'</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားပါသည်။</p>';
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော ကန်ထရိုက်တိုက်မီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် လျှောက်လွှာအတွင်းပါရှိသော အထောက်အထားများ၏ မူရင်းများကို တပါတည်းယူဆောင်၍  သက်မှတ်ရက် ( <span class="text-danger">'.$expDate->format('d-m-Y').' ၂:၀၀ နာရီ'.'</span> ) ထက်နောက်မကျဘဲ ရုံးသို့ လူကိုယ်တိုင် လာရောက်ငွေသွင်းပေးပါရန် အကြောင်းကြားပါသည်။</p>';
            $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.route('user_pay_form.create', $form_id).'" class="btn btn-info text-center">Click for payment</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form_id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 5;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();

            $header     = trans('lang.pay_form_title');
            $body       = trans('lang.pay_form_text',['meter'=>trans('lang.contractor_meter_no',['no'=>$form->serial_code]), 'date' => $expDate->format('d-m-Y')]);
            $remark     = '';
            $link       = route('user_pay_form.create', $form_id);
			$link_name  = trans('lang.click_for_payment');
			$link       = '';
            $link_name  = "";
            $from       = divType($form->div_state_id);
            Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));
            
            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->announce = true;
            $action->announced_date = date('Y-m-d H:i:s');
            $action->user_pay = true;
            $action->user_paid_date = date('Y-m-d H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->announce=admin()->id;
            $adminAction->save();

            return redirect()->route('contractorMeterAnnounceList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function contractor_payment_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'contractor_app_payment';
            $heading = 'confirm_payment';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 5],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.announce', true],
                    ['form_process_actions.payment_accept', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.contractor.paymentList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_payment_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_payment';
            $heading = 'confirm_payment';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $c_form = ApplicationFormContractor::where('application_form_id', $form_id)->first();

            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();

            if ($data->apply_type == 5) {
                if ($data->apply_sub_type == 1) {
                    $c_417 = true;
                } elseif ($data->apply_sub_type == 2) {
                    $c_18over = true;
                    $c_417 = false;
                }
            } else {
                $sub_type = InitialCost::find($data->apply_sub_type);
                $c_417 = false;
            }

            $user_pay = Payment::where('application_form_id', $form_id)->first();

            // $sub_type = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->first();
            // $user_pay = Payment::where('application_form_id', $form_id)->first();
            
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', 3], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin/contractor/paymentList_show', compact('active', 'heading', 'data', 'files','error','survey_result','c_417','c_form', 'user_pay'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_payment_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_payment';
            $heading = 'confirm_payment';
            $form = ApplicationForm::find($form_id);
            $c_form = ApplicationFormContractor::where('application_form_id', $form_id)->first();
            if ($form->apply_type == 5) {
                if ($form->apply_sub_type == 1) {
                    $c_417 = true;
                } elseif ($form->apply_sub_type == 2) {
                    $c_18over = true;
                }
            } else {
                $sub_type = InitialCost::find($form->apply_sub_type);
            }

            $user_pay = Payment::where('application_form_id', $form_id)->first();
            return view('admin.contractor.paymentList_create', compact('heading', 'active', 'form', 'c_form', 'sub_type', 'c_417', 'c_18over', 'user_pay'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_payment_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;
            $office_payment = $request->office_payment;
            $online_payment = $request->online_payment;            
            $paid_date = date('Y-m-d', strtotime($request->accept_date));

            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->payment_accept = true;
            $action->payment_accepted_date = date('Y-m-d H:i:s');
            $action->save();
            
            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);
            // $pay_date = Payment::where('application_form_id', $form_id)->first()->created_at;
            $route = route('contractor_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('contractor_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('contractor_applied_form_mdy', $form->id);
            }
            
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော အိမ်သုံးပါဝါမီတာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ ('.date('d-m-Y', strtotime($paid_date)).')တွင် ငွေသွင်းလက်ခံ ရရှိပြီးဖြစ်ကြောင်း အကြောင်းကြားပါသည်။</p>';
            $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form_id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 6;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();

            $header     = trans('lang.receivepay_form_title');
            $body       = trans('lang.receivepay_form_text',['meter'=>trans('lang.contractor_meter_no',['no'=>$form->serial_code]),'date'=>(date('d-m-Y', strtotime($paid_date)))]);
            $remark     = '';
            $link       = $route;
            $link_name  = trans('lang.go_to_form');
            $from       = divType($form->div_state_id);
            Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));

            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->payment_accept = true;
            $action->payment_accepted_date = date('Y-m-d H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->payment_accept=admin()->id;
            $adminAction->save();

            return redirect()->route('contractorMeterPaymentList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function contractor_chk_install_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'contractor_app_chk_install';
            $heading = 'chk_install';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 5],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.payment_accept', true],
                    ['form_process_actions.install_accept', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());

            return view('admin.contractor.installList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_chk_install_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_chk_install';
            $heading = 'chk_install';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            return view('admin/contractor/installList_show', compact('active', 'heading', 'data', 'files', 'error', 'survey_result'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_chk_install_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_chk_install';
            $heading = 'chk_install';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('admin.contractor.installList_create', compact('heading', 'active', 'form', 'files'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_chk_install_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $survey = FormSurvey::where('application_form_id', $request->form_id)->first();
            $action = FormProcessAction::where('application_form_id', $request->form_id)->first();
            $action->install_accept = true;
            $action->install_accepted_date = date('Y-m-d H:i:s');
            if ($survey->loaded) {
                $action->install_confirm = true;
                $action->install_confirmed_date = date('Y-m-d H:i:s');
            }
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $request->form_id)->first();
            $adminAction->install_accept=admin()->id;
            $adminAction->save();

            $form138 = new Form138();
            $form138->application_form_id = $request->form_id;
            $form138->form_send_date = $request->form_send_date;
            $form138->form_get_date = $request->form_get_date;
            $form138->description = $request->description;
            $form138->cash_kyat = $request->cash_kyat;
            $form138->calculator = $request->calculator;
            $form138->calcu_date = $request->calcu_date != "" ? date('Y-m-d', strtotime($request->calcu_date)) : null;
            $form138->payment_form_no = $request->payment_form_no;
            $form138->payment_form_date = $request->payment_form_date != "" ? date('Y-m-d', strtotime($request->payment_form_date)) : null;
            $form138->deposite_form_no = $request->deposite_form_no;
            $form138->deposite_form_date = $request->deposite_form_date != "" ? date('Y-m-d', strtotime($request->deposite_form_date)) : null;
            $form138->somewhat = $request->somewhat;
            $form138->somewhat_form_date = $request->somewhat_form_date != "" ? date('Y-m-d', strtotime($request->somewhat_form_date)) : null;
            $form138->string_form_date = $request->string_form_date != "" ? date('Y-m-d', strtotime($request->string_form_date)) : null;
            $form138->service_string_form_date = $request->service_string_form_date != "" ? date('Y-m-d', strtotime($request->service_string_form_date)) : null;
            $form138->save();
            return redirect()->route('contractorMeterCheckInstallList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function contractor_install_done_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'contractor_app_install_done';
            $heading = 'ei_chk_install';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 5],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.install_accept', true],
                    ['form_process_actions.install_confirm', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.contractor.installDoneList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_install_done_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_install_done';
            $heading = 'ei_chk_install';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $install = Form138::where('application_form_id',$form_id)->first();
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            return view('admin.contractor.installDoneList_show', compact('active', 'heading', 'data', 'files','error','survey_result','install'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_install_done_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_install_done';
            $heading = 'ei_chk_install';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('admin.contractor.installDoneList_create', compact('heading', 'active', 'form', 'files'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_install_done_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // dd($request->all());
            // $this->validate($request, [
                // 'front' => ['image', 'mimes:jpeg,jpg,png,pdf'],
                // 'ei_remark' => 'required'
            // ]);
            $form = ApplicationForm::find($request->form_id);
            $folder_name = $form->id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            $tmp_arr = [];
            $img_str = [];

            if ($request->hasFile('front')) {
                foreach ($request->file('front') as $key => $value) {
                    $ext = $value->getClientOriginalExtension();
                    $save_db_img = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $save_file_img = Image::make($value);
                        $save_file_img->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $save_file_img->save($path.'/'.$save_db_img);
                    }else{ // pdf
                        //Upload File
                        $value->storeAs($pathPDF,$save_db_img);
                    }
                    array_push($tmp_arr, $save_db_img);
                }
                $img_str = implode(',', $tmp_arr);
            }
            $new = new FormEiChk();
            $new->application_form_id = $form->id;
            $new->ei_files = $img_str;
            $new->ei_remark = $request->ei_remark;
            $new->save();   

            $action = FormProcessAction::where('application_form_id', $form->id)->first();
            $action ->install_confirm = true;
            $action->install_confirmed_date = date('Y-m-d H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form->id)->first();
            $adminAction->install_confirm=admin()->id;
            $adminAction->save();

            return redirect()->route('contractorMeterInstallationDoneList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function contractor_reg_meter_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'contractor_app_reg_meter';
            $heading = 'reg_meter';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 5],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.install_confirm', true],
                    ['form_process_actions.register_meter', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());

            return view('admin.contractor.regMeterList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_reg_meter_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'contractor_app_reg_meter';
            $heading = 'reg_meter';
            $data = ApplicationForm::find($form_id);
            $install = Form138::where('application_form_id',$form_id)->first();
            $files = $data->application_files;
            $survey_result = FormSurvey::where([['application_form_id', $form_id], ['survey_date', '!=', NULL]])->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $c_form = ApplicationFormContractor::where('application_form_id', $form_id)->first();
            return view('admin.contractor.regMeterList_show', compact('active', 'heading', 'data', 'files', 'error', 'survey_result', 'c_form','install'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function contractor_reg_meter_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $id = $request->form_id;

            $action = FormProcessAction::where('application_form_id', $id)->first();
            $action->register_meter = true;
            $action->registered_meter_date = date('Y-m-d H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $id)->first();
            $adminAction->register_meter = admin()->id;
            $adminAction->save();

            $room_count = ApplicationFormContractor::where('application_form_id', $id)->first();
            
            // အခန်:အတွက် မီတာအမှတ်များ ဖြည့်သွင်:
            for ($n = 0; $n < $room_count->room_count; $n++) { 
                $data1 = new Form66();
                $data1->application_form_id = $id;
                $data1->room_no = $request->room_no[$n];
                $data1->meter_no = $request->meter_no[$n];
                $data1->meter_seal_no = $request->meter_seal_no[$n];
                $data1->who_made_meter = $request->who_made_meter[$n];
                $data1->ampere = $request->ampere[$n];
                $data1->save();
            }

            // ရေစက်မီတာအမှတ်
            for ($nn = 0; $nn < $room_count->water_meter; $nn++) { 
                $data2 = new Form66();
                $data2->application_form_id = $id;
                $data2->water_meter_no = $request->water_meter_no[$nn];
                $data2->water_meter_seal_no = $request->water_meter_seal_no[$nn];//new
                $data2->water_who_made_meter = $request->water_who_made_meter[$nn];//new
                $data2->water_ampere = $request->water_ampere[$nn];//new
                $data2->save();
            }

            // ပါဝါမီတာအမှတ်
            for ($nnn = 0; $nnn < $room_count->elevator_meter; $nnn++) { 
                $data3 = new Form66();
                $data3->application_form_id = $id;
                $data3->elevator_meter_no = $request->elevator_meter_no[$nnn];
                $data3->elevator_meter_seal_no = $request->elevator_meter_seal_no[$nnn];//m
                $data3->elevator_who_made_meter = $request->elevator_who_made_meter[$nnn];//m
                $data3->elevator_ampere = $request->elevator_ampere[$nnn];//m
                $data3->save();
            }

            $data4 = Form66::where('application_form_id', $id)->get();
            foreach ($data4 as $key) {
                $key->meter_get_date = $request->meter_get_date != "" ? date('Y-m-d', strtotime($request->meter_get_date)) : null;
                $key->pay_date = $request->pay_date != "" ? date('Y-m-d', strtotime($request->pay_date)) : null;
                $key->mark_user_no = $request->mark_user_no;
                $key->budget = $request->budget;
                $key->move_date = $request->move_date != "" ? date('Y-m-d', strtotime($request->move_date)) : null;
                $key->move_budget = $request->move_budget;
                $key->move_order = $request->move_order;
                $key->test_date = $request->test_date != "" ? date('Y-m-d', strtotime($request->test_date)) : null;
                $key->test_no = $request->test_no;
                $key->remark = $request->remark;
                $key->save();
            }
            return redirect()->route('contractorMeterRegisterMeterList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }
    /* ------------------------------------------------------------------------------ */

    /* ------------------------------------------------------------------------------ */
    /* Transformer Application Form */
    public function tsf_applied_form_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $heading = 'residentApplication';
            $active = 'tsf_app_form';
            if(admin()->group_lvl == '1' || admin()->group_lvl == '2'){
                $form = DB::table('application_forms')
                    ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                    ->where([
                        ['application_forms.apply_type', 4],
                        ['form_process_actions.user_send_to_office', true],
                        ['form_process_actions.form_reject', false],
                        ['form_process_actions.form_pending', false],
                        ['form_process_actions.register_meter', false]
                    ])
                    ->when($name, function ($query, $name) {
                        return $query->where('application_forms.fullname', $name);
                    })
                    ->when($serial, function ($query, $serial) {
                        return $query->where('application_forms.serial_code', $serial);
                    })
                    ->select('application_forms.*')
                    ->paginate(10);
                $form->appends(request()->query());
            }else{
                if(admin()->group_lvl == '6'){
                    $val = admin()->township;
                    $field = 'application_forms.township_id';
                    
                }elseif(admin()->group_lvl == '5'){
                    $val = admin()->district;
                    $field = 'application_forms.district_id';
                }elseif(admin()->group_lvl == '4'){
                    $val	 = admin()->div_state;
                    $field = 'application_forms.div_state_id';
                }
                
                    $form = DB::table('application_forms')
                    ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                    ->where([
                        ['application_forms.apply_type', 4],
                        [$field, $val],
                        ['form_process_actions.user_send_to_office', true],
                        ['form_process_actions.form_reject', false],
                        ['form_process_actions.form_pending', false],
                        ['form_process_actions.register_meter', false]
                    ])
                    ->when($name, function ($query, $name) {
                        return $query->where('application_forms.fullname', $name);
                    })
                    ->when($serial, function ($query, $serial) {
                        return $query->where('application_forms.serial_code', $serial);
                    })
                    ->select('application_forms.*')
                    ->paginate(10);
                $form->appends(request()->query());
            }
            // $form = DB::table('application_forms')
            //     ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
            //     ->where([
            //         ['application_forms.apply_type', 4],
            //         ['form_process_actions.user_send_to_office', true],
            //         ['form_process_actions.form_reject', false],
            //         ['form_process_actions.form_pending', false],
            //         ['form_process_actions.register_meter', false]
            //     ])
            //     ->when($name, function ($query, $name) {
            //         return $query->where('application_forms.fullname', $name);
            //     })
            //     ->when($serial, function ($query, $serial) {
            //         return $query->where('application_forms.serial_code', $serial);
            //     })
            //     ->select('application_forms.*')
            //     ->paginate(10);
            // $form->appends(request()->query());
            return view('admin/transformer/applicationForm_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_applied_form_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_form';
            $heading = 'residentApplication';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $survey_result = FormSurveyTransformer::where('application_form_id', $form_id)->first();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $install = Form138::where('application_form_id',$form_id)->first();

            $ei_data = FormEiChk::where('application_form_id', $form_id)->first();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names_trf = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->first();
            return view('admin/transformer/applicationForm_show', compact('active', 'heading', 'tbl_col_name', 'fee_names_trf', 'data', 'files', 'error', 'survey_result', 'pending','install','ei_data'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function tsf_form_error_send_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // dd($request->all());
            $this->validate($request, [
                'remark' => 'required',
            ]);
            
            $form = ApplicationForm::find($request->form_id);
            $user = User::find($form->user_id);

            $action = FormProcessAction::where('application_form_id', $request->form_id)->first();
            $action->user_send_to_office = 0;
            $action->save();
            
            $remark = new FormProcessRemark();
            $remark->application_form_id = $request->form_id;
            $remark->error_remark = $request->remark;
            $remark->who_did_this = admin()->id;
            $remark->save();

            $route = route('tsf_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('tsf_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('tsf_applied_form_mdy', $form->id);
            }
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ လိုအပ်ချက်များရှိနေပါသောကြောင့် အောက်ဖေါ်ပြပါ အကြောင်းအရာများကို ကြည့်ရှုစစ်ဆေးပြီး ပြန်လည်ပေးပို့ပေးပါရန် အကြောင်းကြားပါသည်။</p>';
            $mail_body .= '<div class="mt-3 mb-5">'.$request->remark.'</div>';
            $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form->id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 1;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();

            $header     = trans('lang.required_form_title');
            $body       = trans('lang.required_form_text',['meter'=>trans('lang.transformer_meter_no',['no'=>$form->serial_code])]);
            $remark     = '<div class="remark-danger">&#10039; '.$request->remark.'</div>';
            $link       = $route;
            $link_name  = trans('lang.go_to_form');
            $from       = divType($form->div_state_id);
            Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));

            return redirect()->route('transformerApplicationList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function tsf_form_accept($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);

            $new = FormProcessAction::where('application_form_id', $form_id)->first();
            $new->form_accept = 1;
            $new->accepted_date = date('Y-m-d H:i:s');
            $new->save();

            $adminAction = new AdminAction();
            $adminAction->application_form_id = $form_id;
            $adminAction->form_accept = admin()->id;
            $adminAction->save();

            $route = route('tsf_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('tsf_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('tsf_applied_form_mdy', $form->id);
            }
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံပြီးဖြစ်ကြောင်းနှင့် လုပ်ငန်းစဥ်အခြေအနေအား အောက်ပါ လင့်ခ်(Link)တဆင့် ဝင်ရောက်ကြည့်ရှုနိုင်ပါကြောင်း အကြောင်းကြားပါသည်။</p>';
            $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form_id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 2;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();

            $header     = trans('lang.accept_form_title');
            $body       = trans('lang.accept_form_text',['meter'=>trans('lang.transformer_meter_no',['no'=>$form->serial_code])]);
            $remark     = '';
            $link       = $route;
            $link_name  = trans('lang.go_to_form');
            $from       = divType($form->div_state_id);
            Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));

            return redirect()->route('transformerApplicationList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function tsf_grd_chk_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'tsf_app_survey';
            $heading = 'residentSurvey';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 4],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.form_accept', true],
                    ['form_process_actions.survey_accept', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.transformer.surveyList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_grd_chk_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_survey';
            $heading = 'residentSurvey';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $engineerLists = Admin::where([['div_state', $data->div_state_id], ['district', $data->district_id], ['township', $data->township_id]])->get();
            $survey_result = FormSurveyTransformer::where('application_form_id', $form_id)->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $kva = InitialCost::where('type', 4)->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names_trf = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->first();
            return view('admin.transformer.surveyList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names_trf', 'data', 'files', 'kva', 'survey_result', 'error', 'pending', 'engineerLists'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_grd_chk_choose_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $id = $request->form_id;
            $engineerId = $request->engineer_id;

            $survey = new FormSurveyTransformer();
            $survey->application_form_id = $id;
            $survey->survey_engineer = $engineerId;
            $survey->save();

            $adminAction = AdminAction::where('application_form_id', $id)->first();
            $adminAction->survey_accept=admin()->id;
            $adminAction->save();

            return redirect()->route('transformerGroundCheckList.show', $id);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function tsf_grd_chk_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // dd($request->all());
            $id = $request->form_id;
            $date = date('Y-m-d H:i:s');

            $action = FormProcessAction::where('application_form_id', $id)->first();
            $action->survey_accept = true;
            $action->survey_accepted_date = $date;
            $action->save();

            $form = ApplicationForm::find($id);
            $folder_name = $id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            $one_line_save_img = null;
            $map_save_img = null;
            $power_recomm_save_img = null;
            $google_map_save_img = null;
            $comsumed_power_save_img = null;

            if ($request->hasFile('power_station_recomm')) {
                $power_recomm_ext       = $request->file('power_station_recomm')->getClientOriginalExtension();
                $power_recomm_save_img  = get_random_string().'_'.getdate()[0].'.'.$power_recomm_ext;
                if($power_recomm_ext != 'pdf'){ // jpg, png
                    $power_recomm_img = Image::make($request->file('power_station_recomm'));
                    $power_recomm_img->resize(400, null, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $power_recomm_img->save($path.'/'.$power_recomm_save_img);
                }else{ // pdf
                    //Upload File
                    $request->file('power_station_recomm')->storeAs($pathPDF,$power_recomm_save_img);
                }
            }
            if ($request->hasFile('one_line_diagram')) {
                $one_line_ext = $request->file('one_line_diagram')->getClientOriginalExtension();
                $one_line_save_img = get_random_string().'_'.getdate()[0].'.'.$one_line_ext;
                if($one_line_ext != 'pdf'){ // jpg, png
                    $one_line_img = Image::make($request->file('one_line_diagram'));
                    $one_line_img->resize(400, null);
                    $one_line_img->save($path.'/'.$one_line_save_img);
                }else{ // pdf
                    //Upload File
                    $request->file('one_line_diagram')->storeAs($pathPDF,$one_line_save_img);
                }
            }
            if ($request->hasFile('location_map')) {
                $map_ext = $request->file('location_map')->getClientOriginalExtension();
                $map_save_img = get_random_string().'_'.getdate()[0].'.'.$map_ext;
                if($map_ext != 'pdf'){ // jpg, png
                    $map_img = Image::make($request->file('location_map'));
                    $map_img->resize(400,null);
                    $map_img->save($path.'/'.$map_save_img);
                }else{ // pdf
                    //Upload File
                    $request->file('location_map')->storeAs($pathPDF,$map_save_img);
                }
            }
            if ($request->hasFile('google_map')) {
                $google_map_ext = $request->file('google_map')->getClientOriginalExtension();
                $google_map_save_img = get_random_string().'_'.getdate()[0].'.'.$google_map_ext;
                if($google_map_ext != 'pdf'){ // jpg, png
                    $google_map_img = Image::make($request->file('google_map'));
                    $google_map_img->resize(800, 800);
                    $google_map_img->save($path.'/'.$google_map_save_img);
                }else{ // pdf
                    //Upload File
                    $request->file('google_map')->storeAs($pathPDF,$google_map_save_img);
                }
            }
            if ($request->hasFile('comsumed_power_list')) {
                $comsumed_power_ext = $request->file('comsumed_power_list')->getClientOriginalExtension();
                $comsumed_power_save_img = get_random_string().'_'.getdate()[0].'.'.$comsumed_power_ext;
                if($comsumed_power_ext != 'pdf'){ // jpg, png
                    $comsumed_power_img = Image::make($request->file('comsumed_power_list'));
                    $comsumed_power_img->resize(800, 800);
                    $comsumed_power_img->save($path.'/'.$comsumed_power_save_img);
                }else{ // pdf
                    //Upload File
                    $request->file('comsumed_power_list')->storeAs($pathPDF,$comsumed_power_save_img);
                }
            }

            $survey = FormSurveyTransformer::where('application_form_id', $id)->first();
            $survey->pri_tsf_type = $request->pri_tsf_type;
            $survey->pri_tsf_name = $request->pri_tsf_name;
            $survey->pri_capacity = $request->pri_capacity;
            $survey->ct_ratio = $request->ct_ratio;
            $survey->ct_ratio_amt = $request->ct_ratio_amt;
            $survey->pri_main_ct_ratio = $request->pri_main_ct_ratio;
            $survey->pri_main_ct_ratio_amt = $request->pri_main_ct_ratio_amt;
            $survey->main_feeder_peak_load = $request->main_feeder_peak_load;
            $survey->main_feeder_peak_load_amt = $request->main_feeder_peak_load_amt;
            $survey->pri_feeder_ct_ratio = $request->pri_feeder_ct_ratio;
            $survey->pri_feeder_ct_ratio_amt = $request->pri_feeder_ct_ratio_amt;
            $survey->feeder_peak_load = $request->feeder_peak_load;
            $survey->feeder_peak_load_amt = $request->feeder_peak_load_amt;
            $survey->p_tsf_type = $request->p_tsf_type;
            $survey->p_tsf_name = $request->p_tsf_name;
            $survey->p_capacity = $request->p_capacity;
            $survey->p_main_ct_ratio = $request->p_main_ct_ratio;
            $survey->p_main_ct_ratio_amt = $request->p_main_ct_ratio_amt;
            $survey->p_11_main_ct_ratio = $request->p_11_main_ct_ratio;
            $survey->p_11_peak_load_day = $request->p_11_peak_load_day;
            $survey->p_11_peak_load_night = $request->p_11_peak_load_night;
            $survey->p_11_installed_capacity = $request->p_11_installed_capacity;
            $survey->sec_tsf_type = $request->sec_tsf_type;
            $survey->sec_tsf_name = $request->sec_tsf_name;
            $survey->sec_capacity = $request->sec_capacity;
            $survey->sec_main_ct_ratio = $request->sec_main_ct_ratio;
            $survey->sec_main_ct_ratio_amt = $request->sec_main_ct_ratio_amt;
            $survey->sec_11_main_ct_ratio = $request->sec_11_main_ct_ratio;
            $survey->sec_11_peak_load_day = $request->sec_11_peak_load_day;
            $survey->sec_11_peak_load_night = $request->sec_11_peak_load_night;
            $survey->sec_11_installed_capacity = $request->sec_11_installed_capacity;
            $survey->feeder_name = $request->feeder_name;
            $survey->feeder_ct_ratio = $request->feeder_ct_ratio;
            $survey->feeder_peak_load_day = $request->feeder_peak_load_day;
            $survey->feeder_peak_load_night = $request->feeder_peak_load_night;
            $survey->online_installed_capacity = $request->online_installed_capacity;
            $survey->total_line_length = $request->total_line_length;
            $survey->request_line_length = $request->request_line_length;
            $survey->conductor = $request->conductor;
            $survey->string_change = $request->string_change;
            if ($request->string_change == 'yes') {
                $survey->string_change_type_length = $request->string_change_type_length;
            }
            $survey->string_new_type_length = $request->string_new_type_length;
            $survey->load_percent = $request->load_percent;
            $survey->survey_remark = $request->survey_remark;
            $survey->power_station_recomm = $power_recomm_save_img;
            $survey->one_line_diagram = $one_line_save_img;
            $survey->location_map = $map_save_img;
            $survey->longitude = $request->longitude;
            $survey->latitude = $request->latitude;
            $survey->google_map = $google_map_save_img;
            $survey->comsumed_power_list = $comsumed_power_save_img;
            $survey->comsumed_power_amt = $request->comsumed_power_amt;
            $survey->allowed_tsf = $request->allowed_tsf;
            $survey->original_tsf = $request->original_tsf;
            $survey->save();

            $new_tsf = ApplicationForm::find($id);
            $new_tsf->apply_sub_type = $request->allowed_tsf;
            $new_tsf->save();

            return redirect()->route('transformerGroundCheckList.index');
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function tsf_grd_done_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'tsf_app_gnd_done';
            $heading = 'residentSurveyDoneTsp';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 4],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_accept', true],
                    ['form_process_actions.survey_confirm', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
                // ->get();
            // dd($form);
            $form->appends(request()->query());
            return view('admin.transformer.surveyDoneList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_grd_done_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_gnd_done';
            $heading = 'residentSurveyDone';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurveyTransformer::where('application_form_id', $form_id)->first();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names_trf = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->first();
            return view('admin.transformer.surveyDoneList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names_trf', 'data', 'files', 'survey_result', 'error', 'pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_grd_done_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'tsp_remark' => ['required']
            ]);

            $id = $request->form_id;
            $date = date('Y-m-d H:i:s');
            $folder_name = $id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;

            $action = FormProcessAction::where('application_form_id', $id)->first();
            $action->survey_confirm = true;
            $action->survey_confirmed_date = date('Y-m-d H:i:s');
            $action->save();

            if ($request->hasFile('tsp_recomm')) {
                $ext = $request->file('tsp_recomm')->getClientOriginalExtension();
                $file = get_random_string().'_'.getdate()[0].'.'.$ext;
                if($ext != 'pdf'){ // jpg, png
                    $image = Image::make($request->file('tsp_recomm'));
                    $image->resize(800, 800, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $image->save($path.'/'.$file);
                }else{ // pdf
                    //Upload File
                    $request->file('tsp_recomm')->storeAs($pathPDF,$file);
                }
            }else{
                $file = null;
            }

            $survey = FormSurveyTransformer::where('application_form_id', $id)->first();
            $survey->tsp_remark = $request->tsp_remark;
            $survey->tsp_recomm = $file;
            $survey->save();

            $send_from_to = new FormRoutine();
            $send_from_to->application_form_id = $id;
            $send_from_to->send_from = 1;
            $send_from_to->send_to = 2;
            $send_from_to->remark = $request->tsp_remark;
            $send_from_to->type = 'send';
            $send_from_to->save();

            $adminAction = AdminAction::where('application_form_id', $id)->first();
            $adminAction->survey_confirm = admin()->id;
            $adminAction->save();

            return redirect()->route('transformerGroundCheckDoneList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_grd_done_list_edit($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_gnd_done';
            $heading = 'residentSurveyDone';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurveyTransformer::where('application_form_id', $form_id)->first();
            $kva = InitialCost::where('type', 4)->get();
            return view('admin.transformer.surveyDoneListEditTsp', compact('active', 'heading', 'data', 'files', 'survey_result', 'kva'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_grd_done_list_update(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;
            $form = ApplicationForm::find($form_id);
            $folder_name = $form_id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            $power_recomm_save_img = null;
            $one_line_save_img = null;
            $map_save_img = null;
            $google_map_save_img = null;
            $comsumed_power_save_img = null;
            
            $survey = FormSurveyTransformer::where('application_form_id', $form_id)->first();
            if ($survey->power_station_recomm) {
                $power_recomm_save_img = $survey->power_station_recomm;
            }
            if ($survey->one_line_diagram) {
                $one_line_save_img = $survey->one_line_diagram;
            }
            if ($survey->location_map) {
                $map_save_img = $survey->location_map;
            }
            if ($survey->google_map) {
                $google_map_save_img = $survey->google_map;
            }
            if ($survey->comsumed_power_list) {
                $comsumed_power_save_img = $survey->comsumed_power_list;
            }

            if ($request->hasFile('power_station_recomm')) {
                $power_recomm_ext       = $request->file('power_station_recomm')->getClientOriginalExtension();
                $power_recomm_save_img  = get_random_string().'_'.getdate()[0].'.'.$power_recomm_ext;
                if($power_recomm_ext != 'pdf'){ // jpg, png
                    $power_recomm_img = Image::make($request->file('power_station_recomm'));
                    $power_recomm_img->resize(800, 800, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $power_recomm_img->save($path.'/'.$power_recomm_save_img);
                }else{ // pdf
                    //Upload File
                    $request->file('power_station_recomm')->storeAs($pathPDF,$power_recomm_save_img);
                }
                /* ----------- delete old file ----------- */
                if (file_exists(public_path('storage/user_attachments/'.$folder_name).'/'.$survey->power_station_recomm) && $survey->power_station_recomm != '') {
                    unlink(public_path('storage/user_attachments/'.$folder_name).'/'.$survey->power_station_recomm);
                }
            }
            if ($request->hasFile('one_line_diagram')) {
                $one_line_ext = $request->file('one_line_diagram')->getClientOriginalExtension();
                $one_line_save_img = get_random_string().'_'.getdate()[0].'.'.$one_line_ext;
                if($one_line_ext != 'pdf'){ // jpg, png
                    $one_line_img = Image::make($request->file('one_line_diagram'));
                    $one_line_img->resize(800, 800);
                    $one_line_img->save($path.'/'.$one_line_save_img);
                }else{ // pdf
                    //Upload File
                    $request->file('one_line_diagram')->storeAs($pathPDF,$one_line_save_img);
                }

                /* ----------- delete old file ----------- */
                if (file_exists(public_path('storage/user_attachments/'.$folder_name).'/'.$survey->one_line_diagram) && $survey->one_line_diagram != '') {
                    unlink(public_path('storage/user_attachments/'.$folder_name).'/'.$survey->one_line_diagram);
                }
            }
            if ($request->hasFile('location_map')) {
                $map_ext = $request->file('location_map')->getClientOriginalExtension();
                $map_save_img = get_random_string().'_'.getdate()[0].'.'.$map_ext;
                if($map_ext != 'pdf'){ // jpg, png
                    $map_img = Image::make($request->file('location_map'));
                    $map_img->resize(800, 800);
                    $map_img->save($path.'/'.$map_save_img);
                }else{ // pdf
                    //Upload File
                    $request->file('location_map')->storeAs($pathPDF,$map_save_img);
                }

                /* ----------- delete old file ----------- */
                if (file_exists(public_path('storage/user_attachments/'.$folder_name).'/'.$survey->location_map) && $survey->location_map != '') {
                    unlink(public_path('storage/user_attachments/'.$folder_name).'/'.$survey->location_map);
                }
            }
            if ($request->hasFile('google_map')) {
                $google_map_ext = $request->file('google_map')->getClientOriginalExtension();
                $google_map_save_img = get_random_string().'_'.getdate()[0].'.'.$google_map_ext;
                if($google_map_ext != 'pdf'){ // jpg, png
                    $google_map_img = Image::make($request->file('google_map'));
                    $google_map_img->resize(800, 800);
                    $google_map_img->save($path.'/'.$google_map_save_img);
                }else{ // pdf
                    //Upload File
                    $request->file('google_map')->storeAs($pathPDF,$google_map_save_img);
                }

                /* ----------- delete old file ----------- */
                if (file_exists(public_path('storage/user_attachments/'.$folder_name).'/'.$survey->google_map) && $survey->google_map != '') {
                    unlink(public_path('storage/user_attachments/'.$folder_name).'/'.$survey->google_map);
                }
            }
            if ($request->hasFile('comsumed_power_list')) {
                $comsumed_power_ext = $request->file('comsumed_power_list')->getClientOriginalExtension();
                $comsumed_power_save_img = get_random_string().'_'.getdate()[0].'.'.$comsumed_power_ext;
                if($comsumed_power_ext != 'pdf'){ // jpg, png
                    $comsumed_power_img = Image::make($request->file('comsumed_power_list'));
                    $comsumed_power_img->resize(800, 800);
                    $comsumed_power_img->save($path.'/'.$comsumed_power_save_img);
                }else{ // pdf
                    //Upload File
                    $request->file('comsumed_power_list')->storeAs($pathPDF,$comsumed_power_save_img);
                }

                /* ----------- delete old file ----------- */
                if (file_exists(public_path('storage/user_attachments/'.$folder_name).'/'.$survey->comsumed_power_list) && $survey->comsumed_power_list != '') {
                    unlink(public_path('storage/user_attachments/'.$folder_name).'/'.$survey->comsumed_power_list);
                }
            }

            $survey->pri_tsf_type = $request->pri_tsf_type;
            $survey->pri_tsf_name = $request->pri_tsf_name;
            $survey->pri_capacity = $request->pri_capacity;
            $survey->ct_ratio = $request->ct_ratio;
            $survey->ct_ratio_amt = $request->ct_ratio_amt;
            $survey->pri_main_ct_ratio = $request->pri_main_ct_ratio;
            $survey->pri_main_ct_ratio_amt = $request->pri_main_ct_ratio_amt;
            $survey->main_feeder_peak_load = $request->main_feeder_peak_load;
            $survey->main_feeder_peak_load_amt = $request->main_feeder_peak_load_amt;
            $survey->pri_feeder_ct_ratio = $request->pri_feeder_ct_ratio;
            $survey->pri_feeder_ct_ratio_amt = $request->pri_feeder_ct_ratio_amt;
            $survey->feeder_peak_load = $request->feeder_peak_load;
            $survey->feeder_peak_load_amt = $request->feeder_peak_load_amt;
            $survey->p_tsf_type = $request->p_tsf_type;
            $survey->p_tsf_name = $request->p_tsf_name;
            $survey->p_capacity = $request->p_capacity;
            $survey->p_main_ct_ratio = $request->p_main_ct_ratio;
            $survey->p_main_ct_ratio_amt = $request->p_main_ct_ratio_amt;
            $survey->p_11_main_ct_ratio = $request->p_11_main_ct_ratio;
            $survey->p_11_peak_load_day = $request->p_11_peak_load_day;
            $survey->p_11_peak_load_night = $request->p_11_peak_load_night;
            $survey->p_11_installed_capacity = $request->p_11_installed_capacity;
            $survey->sec_tsf_type = $request->sec_tsf_type;
            $survey->sec_tsf_name = $request->sec_tsf_name;
            $survey->sec_capacity = $request->sec_capacity;
            $survey->sec_main_ct_ratio = $request->sec_main_ct_ratio;
            $survey->sec_main_ct_ratio_amt = $request->sec_main_ct_ratio_amt;
            $survey->sec_11_main_ct_ratio = $request->sec_11_main_ct_ratio;
            $survey->sec_11_peak_load_day = $request->sec_11_peak_load_day;
            $survey->sec_11_peak_load_night = $request->sec_11_peak_load_night;
            $survey->sec_11_installed_capacity = $request->sec_11_installed_capacity;

            $survey->feeder_name = $request->feeder_name;
            $survey->feeder_ct_ratio = $request->feeder_ct_ratio;
            $survey->feeder_peak_load_day = $request->feeder_peak_load_day;
            $survey->feeder_peak_load_night = $request->feeder_peak_load_night;
            $survey->online_installed_capacity = $request->online_installed_capacity;
            $survey->total_line_length = $request->total_line_length;
            $survey->request_line_length = $request->request_line_length;
            $survey->conductor = $request->conductor;
            $survey->string_change = $request->string_change;
            if ($request->string_change == 'yes') {
                $survey->string_change_type_length = $request->string_change_type_length;
            }
            $survey->string_new_type_length = $request->string_new_type_length;
            $survey->load_percent = $request->load_percent;
            $survey->survey_remark = $request->survey_remark;
            $survey->power_station_recomm = $power_recomm_save_img;
            $survey->one_line_diagram = $one_line_save_img;
            $survey->location_map = $map_save_img;
            $survey->longitude = $request->longitude;
            $survey->latitude = $request->latitude;
            $survey->google_map = $google_map_save_img;
            $survey->comsumed_power_list = $comsumed_power_save_img;
            $survey->comsumed_power_amt = $request->comsumed_power_amt;
            $survey->allowed_tsf = $request->allowed_tsf;
            $survey->save();

            $new_tsf = ApplicationForm::find($form_id);
            $new_tsf->apply_sub_type = $request->allowed_tsf;
            $new_tsf->save();

            return redirect()->route('transformerGroundCheckDoneList.show', $form_id);
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function tsf_grd_done_list_by_dist(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'tsf_app_gnd_done_dist';
            $heading = 'residentSurveyDoneDist';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 4],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_confirm', true],
                    ['form_process_actions.survey_confirm_dist', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.transformer.surveyDoneListDist_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_grd_done_list_show_by_dist($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_gnd_done_dist';
            $heading = 'residentSurveyDoneDist';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurveyTransformer::where('application_form_id', $form_id)->first();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();

            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names_trf = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->first();
            return view('admin.transformer.surveyDoneList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names_trf', 'data', 'files', 'survey_result', 'error','pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_grd_done_list_store_by_dist(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'dist_remark' => ['required']
            ]);
            $form_id = $request->form_id;

            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);
            $route = route('tsf_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('tsf_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('tsf_applied_form_mdy', $form->id);
            }
            /* ခရိုင်မှ တိုင်းသို့ တင်ပြ */
            $date = date('Y-m-d H:i:s');

            if ($request->survey_submit_district == 'send') {

            
                $survey = FormSurveyTransformer::where('application_form_id', $form_id)->first();
                $survey->dist_remark = $request->dist_remark;

                $folder_name = $form_id;
                $path = public_path('storage/user_attachments/'.$folder_name);
                $pathPDF = "user_attachments/".$folder_name;
                if ($request->hasFile('dist_recomm')) {
                    $ext = $request->file('dist_recomm')->getClientOriginalExtension();
                    $file = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $image = Image::make($request->file('dist_recomm'));
                        $image->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $image->save($path.'/'.$file);
                    }else{ // pdf
                        //Upload File
                        $request->file('dist_recomm')->storeAs($pathPDF,$file);
                    }
                }else{
                    $file = null;
                }
                $survey->dist_recomm = $file;

                $survey->save();

                $send_from_to = new FormRoutine();
                $send_from_to->application_form_id = $form_id;
                $send_from_to->send_from = 2;
                $send_from_to->send_to = 3;
                $send_from_to->remark = $request->dist_remark;
                $send_from_to->type = 'send';
                $send_from_to->save();


                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->survey_confirm_dist = true;
                $action->survey_confirmed_dist_date = $date;
                $action->save();
            } elseif ($request->survey_submit_district == 'resend') {
                $send_from_to = new FormRoutine();
                $send_from_to->application_form_id = $form_id;
                $send_from_to->send_from = 2;
                $send_from_to->send_to = 1;
                $send_from_to->remark = $request->dist_remark;
                $send_from_to->type = 'resend';
                $send_from_to->save();


                $survey = FormSurveyTransformer::where('application_form_id',$form_id)->first();
                $survey->dist_remark = $request->dist_remark;
                $folder_name = $form_id;
                $path = public_path('storage/user_attachments/'.$folder_name);
                $pathPDF = "user_attachments/".$folder_name;
                if ($request->hasFile('dist_recomm')) {
                    $ext = $request->file('dist_recomm')->getClientOriginalExtension();
                    $file = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $image = Image::make($request->file('dist_recomm'));
                        $image->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $image->save($path.'/'.$file);
                    }else{ // pdf
                        //Upload File
                        $request->file('dist_recomm')->storeAs($pathPDF,$file);
                    }
                }else{
                    $file = null;
                }
                $survey->dist_recomm = $file;
                $survey->save();
                
                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->survey_confirm = false;
                $action->save();
            } elseif ($request->survey_submit_district == 'pending') {
                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                // dd($action);
                $action->form_pending = true;
                $action->pending_date = $date;
                $action->save();
            
                $remark = new FormProcessRemark();
                $remark->application_form_id = $request->form_id;
                $remark->pending_remark = $request->dist_remark;
                $remark->who_did_this = admin()->id;
                $remark->save();
                
                $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ခေတ္တဆိုင်းငံ့ထားပါကြောင်း အကြောင်းကြားပါသည်။</p>';
                $mail_body .= '<div class="mt-3 mb-5">'.$request->dist_remark.'</div>';
                $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

                $mail = new MailTbl();
                $mail->application_form_id = $form_id;
                $mail->user_id = $form->user_id;
                $mail->sender_id = admin()->id;
                $mail->send_type = 3;
                $mail->mail_send_date = date('Y-m-d H:i:s');
                $mail->mail_body = $mail_body;
                $mail->save();

                $header     = trans('lang.suspend_form_title');
                $body       = trans('lang.suspend_form_text',['meter'=>trans('lang.transformer_meter_no',['no'=>$form->serial_code])]);
                $remark     = '<div class="remark-danger">&#10039; '.$request->dist_remark.'</div>';
                $link       = $route;
                $link_name  = trans('lang.go_to_form');
                $from       = divType($form->div_state_id);
                Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));
                
            } elseif ($request->survey_submit_district == 'reject') {
                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->form_reject = true;
                $action->reject_date = $date;
                $action->save();
            
                $remark = new FormProcessRemark();
                $remark->application_form_id = $request->form_id;
                $remark->reject_remark = $request->dist_remark;
                $remark->who_did_this = admin()->id;
                $remark->save();

                $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ပယ်ဖျက်လိုက်ကြောင်း အကြောင်းကြားပါသည်။</p>';
                $mail_body .= '<div class="mt-3 mb-5">'.$request->dist_remark.'</div>';
                $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

                $mail = new MailTbl();
                $mail->application_form_id = $form_id;
                $mail->user_id = $form->user_id;
                $mail->sender_id = admin()->id;
                $mail->send_type = 4;
                $mail->mail_send_date = date('Y-m-d H:i:s');
                $mail->mail_body = $mail_body;
                $mail->save();

                $header     = trans('lang.delete_form_title');
                $body       = trans('lang.delete_form_text',['meter'=>trans('lang.transformer_meter_no',['no'=>$form->serial_code])]);
                $remark     = '<div class="remark-danger">&#10039; '.$request->dist_remark.'</div>';
                $link       = $route;
                $link_name  = trans('lang.go_to_form');
                $from       = divType($form->div_state_id);
                Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));
                
            }

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->survey_confirm_dist = admin()->id;
            $adminAction->save();
            return redirect()->route('transformerGroundCheckDoneListByDistrict.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function tsf_grd_done_list_by_div_state(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'tsf_app_gnd_done_div_state';
            $heading = 'residentSurveyDoneDivstate';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 4],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_confirm_dist', true],
                    ['form_process_actions.survey_confirm_div_state', false]
                ])
                ->orWhere([
                    ['application_forms.apply_type', 4],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_confirm_dist', true],
                    ['form_process_actions.survey_confirm_div_state', NULL]
                ])
                ->orWhere([
                    ['application_forms.apply_type', 4],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_confirm_dist', true],
                    ['form_process_actions.survey_confirm_div_state', true],
                    ['form_process_actions.survey_confirm_div_state_to_headoffice', true],
                    ['form_process_actions.survey_confirm_headoffice', true],
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.transformer.surveyDoneListDivstate_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_grd_done_list_show_by_div_state($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_gnd_done_div_state';
            $heading = 'residentSurveyDoneDivstate';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurveyTransformer::where('application_form_id', $form_id)->first();                        
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names_trf = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->first();
            return view('admin/transformer/surveyDoneList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names_trf', 'data', 'files', 'survey_result', 'error','pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_grd_done_list_store_by_div_state(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                'div_state_remark' => ['required']
            ]);
            $form_id = $request->form_id;

            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);
            $route = route('tsf_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('tsf_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('tsf_applied_form_mdy', $form->id);
            }
            $date = date('Y-m-d H:i:s');

            if ($request->survey_confirm_by_divstate == 'approve') {
                $this->validate($request, [
                    'capacitor_bank' => ['required']
                ]);

                $send_from_to = new FormRoutine();
                $send_from_to->application_form_id = $form_id;
                $send_from_to->send_from = 3;
                $send_from_to->send_to = 1;
                $send_from_to->remark = $request->div_state_remark;
                $send_from_to->type = 'approve';
                $send_from_to->save();

                $send_from_to1 = new FormRoutine();
                $send_from_to1->application_form_id = $form_id;
                $send_from_to1->send_from = 3;
                $send_from_to1->send_to = 2;
                $send_from_to1->remark = $request->div_state_remark;
                $send_from_to1->type = 'approve';
                $send_from_to1->office_send_date = $date;
                $send_from_to1->save();

                $survey = FormSurveyTransformer::where('application_form_id', $form_id)->first();
                $survey->capacitor_bank = $request->capacitor_bank;
                if ($request->capacitor_bank == 'yes') {
                    $survey->capacitor_bank_amt = $request->capacitor_bank_amt;
                }
                // $survey->outfit_meter = $request->outfit_meter;
                // $survey->vcd = $request->vcd;
                // $survey->load_break_switch = $request->load_break_switch;
                $survey->div_state_remark = $request->div_state_remark;
                $survey->save();

                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->survey_confirm_div_state = true;
                $action->survey_confirmed_div_state_date = date('Y-m-d H:i:s');
                $action->survey_confirm_div_state_to_headoffice = false;
                $action->survey_confirm_headoffice = false;
                $action->save();
            } elseif ($request->survey_confirm_by_divstate == 'send') {
                // $this->validate($request, [
                //     'capacitor_bank' => ['required']
                // ]);
                $send_from_to = new FormRoutine();
                $send_from_to->application_form_id = $form_id;
                $send_from_to->send_from = 3;
                $send_from_to->send_to = 4;
                $send_from_to->remark = $request->div_state_remark;
                $send_from_to->type = 'send';
                $send_from_to->save();

                $survey = FormSurveyTransformer::where('application_form_id', $form_id)->first();
                $survey->capacitor_bank = $request->capacitor_bank;
                if ($request->capacitor_bank == 'yes') {
                    $survey->capacitor_bank_amt = $request->capacitor_bank_amt;
                }
                // $survey->outfit_meter = $request->outfit_meter;
                // $survey->vcd = $request->vcd;
                // $survey->load_break_switch = $request->load_break_switch;
                $survey->div_state_remark = $request->div_state_remark;
                $folder_name = $form_id;
                $path = public_path('storage/user_attachments/'.$folder_name);
                $pathPDF = "user_attachments/".$folder_name;
                if ($request->hasFile('div_state_recomm')) {
                    $ext = $request->file('div_state_recomm')->getClientOriginalExtension();
                    $file = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $image = Image::make($request->file('div_state_recomm'));
                        $image->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $image->save($path.'/'.$file);
                    }else{ // pdf
                        //Upload File
                        $request->file('div_state_recomm')->storeAs($pathPDF,$file);
                    }
                }else{
                    $file = null;
                }
                $survey->div_state_recomm = $file;
                $survey->save();

                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->survey_confirm_div_state = true;
                $action->survey_confirmed_div_state_date = date('Y-m-d H:i:s');
                $action->survey_confirm_div_state_to_headoffice = true;
                $action->survey_confirmed_div_state_to_headoffice_date = date('Y-m-d H:i:s');
                $action->save();
            } elseif ($request->survey_confirm_by_divstate == 'resend') {
                $send_from_to = new FormRoutine();
                $send_from_to->application_form_id = $form_id;
                $send_from_to->send_from = 3;
                $send_from_to->send_to = 2;
                $send_from_to->remark = $request->div_state_remark;
                $send_from_to->type = 'resend';
                $send_from_to->save();

                $survey = FormSurveyTransformer::where('application_form_id',$form_id)->first();
                $survey->div_state_remark = $request->div_state_remark;
                $survey->save();

                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->survey_confirm_dist = false;
                $action->save();
            } elseif ($request->survey_confirm_by_divstate == 'pending') {
                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->form_pending = true;
                $action->pending_date = $date;
                $action->save();
            
                $remark = new FormProcessRemark();
                $remark->application_form_id = $request->form_id;
                $remark->pending_remark = $request->div_state_remark;
                $remark->who_did_this = admin()->id;
                $remark->save();
                
                $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ခေတ္တဆိုင်းငံ့ထားပါကြောင်း အကြောင်းကြားပါသည်။</p>';
                $mail_body .= '<div class="mt-3 mb-5">'.$request->div_state_remark.'</div>';
                $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

                $mail = new MailTbl();
                $mail->application_form_id = $form_id;
                $mail->user_id = $form->user_id;
                $mail->sender_id = admin()->id;
                $mail->send_type = 3;
                $mail->mail_send_date = date('Y-m-d H:i:s');
                $mail->mail_body = $mail_body;
                $mail->save();

                $header     = trans('lang.suspend_form_title');
                $body       = trans('lang.suspend_form_text',['meter'=>trans('lang.transformer_meter_no',['no'=>$form->serial_code])]);
                $remark     = '<div class="remark-danger">&#10039; '.$request->div_state_remark.'</div>';
                $link       = $route;
                $link_name  = trans('lang.go_to_form');
                $from       = divType($form->div_state_id);
                Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));
                
            } elseif ($request->survey_confirm_by_divstate == 'reject') {
                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->form_reject = true;
                $action->reject_date = $date;
                $action->save();
            
                $remark = new FormProcessRemark();
                $remark->application_form_id = $request->form_id;
                $remark->reject_remark = $request->div_state_remark;
                $remark->who_did_this = admin()->id;
                $remark->save();

                $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ပယ်ဖျက်လိုက်ကြောင်း အကြောင်းကြားပါသည်။</p>';
                $mail_body .= '<div class="mt-3 mb-5">'.$request->div_state_remark.'</div>';
                $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

                $mail = new MailTbl();
                $mail->application_form_id = $form_id;
                $mail->user_id = $form->user_id;
                $mail->sender_id = admin()->id;
                $mail->send_type = 4;
                $mail->mail_send_date = date('Y-m-d H:i:s');
                $mail->mail_body = $mail_body;
                $mail->save();

                $header     = trans('lang.delete_form_title');
                $body       = trans('lang.delete_form_text',['meter'=>trans('lang.transformer_meter_no',['no'=>$form->serial_code])]);
                $remark     = '<div class="remark-danger">&#10039; '.$request->div_state_remark.'</div>';
                $link       = $route;
                $link_name  = trans('lang.go_to_form');
                $from       = divType($form->div_state_id);
                Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));

            }

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->survey_confirm_div_state = admin()->id;
            $adminAction->survey_confirm_div_state_to_headoffice = admin()->id;
            $adminAction->save();

            return redirect()->route('transformerGroundCheckDoneListByDivisionState.index');
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_grd_done_list_confirm_by_div_state(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;
            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->dist_approve = true;
            $action->dist_approved_date = date('Y-m-d H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->dist_approve = admin()->id;
            $adminAction->save();
            return redirect()->route('transformerGroundCheckDoneListByDivisionState.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function tsf_grd_done_list_by_head_office(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'tsf_app_gnd_done_head_office';
            $heading = 'residentSurveyDoneHeadOffice';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 4],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_confirm_div_state', true],
                    ['form_process_actions.survey_confirm_div_state_to_headoffice', true],
                    ['form_process_actions.survey_confirm_headoffice', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
                // ->get();
            // dd($form);
            $form->appends(request()->query());
            return view('admin.transformer.surveyDoneListHeadOffice_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_grd_done_list_show_by_head_office($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_gnd_done_head_office';
            $heading = 'residentSurveyDoneHeadOffice';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurveyTransformer::where('application_form_id', $form_id)->first();                        
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names_trf = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->first();
            return view('admin.transformer.surveyDoneList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names_trf', 'data', 'files', 'survey_result', 'error', 'pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_grd_done_list_store_by_head_office(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // $this->validate($request, [
            //     'head_remark' => ['required']
            // ]);
            $form_id = $request->form_id;

            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);
            $route = route('tsf_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('tsf_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('tsf_applied_form_mdy', $form->id);
            }
            $date = date('Y-m-d H:i:s');

            $survey = FormSurveyTransformer::where('application_form_id', $form_id)->first();
            $survey->head_office_remark = $request->head_remark;
            $folder_name = $form_id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            if ($request->hasFile('head_office_recomm')) {
                $ext = $request->file('head_office_recomm')->getClientOriginalExtension();
                $file = get_random_string().'_'.getdate()[0].'.'.$ext;
                if($ext != 'pdf'){ // jpg, png
                    $image = Image::make($request->file('head_office_recomm'));
                    $image->resize(800, 800, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $image->save($path.'/'.$file);
                }else{ // pdf
                    //Upload File
                    $request->file('head_office_recomm')->storeAs($pathPDF,$file);
                }
            }else{
                $file = null;
            }
            $survey->head_office_recomm = $file;
            $survey->outfit_meter = $request->outfit_meter;
            $survey->vcd = $request->vcd;
            $survey->load_break_switch = $request->load_break_switch;
            $survey->save();

            if ($request->survey_confirm_by_headoffice == 'approve') {
                $send_from_to = new FormRoutine();
                $send_from_to->application_form_id = $form_id;
                $send_from_to->send_from = 4;
                $send_from_to->send_to = 3;
                $send_from_to->remark = $request->head_remark;
                $send_from_to->type = 'approve';
                $send_from_to->save();

                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->survey_confirm_headoffice = true;
                $action->survey_confirmed_headoffice_date = date('Y-m-d H:i:s');
                $action->save();
            } elseif ($request->survey_confirm_by_headoffice == 'resend') {
                $send_from_to = new FormRoutine();
                $send_from_to->application_form_id = $form_id;
                $send_from_to->send_from = 4;
                $send_from_to->send_to = 3;
                $send_from_to->remark = $request->head_remark;
                $send_from_to->type = 'resend';
                $send_from_to->save();

                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->survey_confirm_div_state = false;
                $action->survey_confirm_div_state_to_headoffice = false;
                $action->save();
            } elseif ($request->survey_confirm_by_headoffice == 'pending') {
                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->form_pending = true;
                $action->pending_date = $date;
                $action->save();
            
                $remark = new FormProcessRemark();
                $remark->application_form_id = $request->form_id;
                $remark->pending_remark = $request->head_remark;
                $remark->who_did_this = admin()->id;
                $remark->save();
                
                $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ခေတ္တဆိုင်းငံ့ထားပါကြောင်း အကြောင်းကြားပါသည်။</p>';
                $mail_body .= '<div class="mt-3 mb-5">'.$request->head_remark.'</div>';
                $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

                $mail = new MailTbl();
                $mail->application_form_id = $form_id;
                $mail->user_id = $form->user_id;
                $mail->sender_id = admin()->id;
                $mail->send_type = 3;
                $mail->mail_send_date = date('Y-m-d H:i:s');
                $mail->mail_body = $mail_body;
                $mail->save();

                $header     = trans('lang.suspend_form_title');
                $body       = trans('lang.suspend_form_text',['meter'=>trans('lang.transformer_meter_no',['no'=>$form->serial_code])]);
                $remark     = '<div class="remark-danger">&#10039; '.$request->head_remark.'</div>';
                $link       = $route;
                $link_name  =  trans('lang.go_to_form');
                $from       = divType($form->div_state_id);
                Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));
                
            } elseif ($request->survey_confirm_by_headoffice == 'reject') {
                $action = FormProcessAction::where('application_form_id', $form_id)->first();
                $action->form_reject = true;
                $action->reject_date = $date;
                $action->save();
            
                $remark = new FormProcessRemark();
                $remark->application_form_id = $request->form_id;
                $remark->reject_remark = $request->head_remark;
                $remark->who_did_this = admin()->id;
                $remark->save();

                $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ မြို့နယ်ရုံးမှ လက်ခံစစ်ဆေးပြီး အောက်ဖော်ပြပါ အကြောင်းအရာများကြောင့် ပယ်ဖျက်လိုက်ကြောင်း အကြောင်းကြားပါသည်။</p>';
                $mail_body .= '<div class="mt-3 mb-5">'.$request->head_remark.'</div>';
                $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

                $mail = new MailTbl();
                $mail->application_form_id = $form_id;
                $mail->user_id = $form->user_id;
                $mail->sender_id = admin()->id;
                $mail->send_type = 4;
                $mail->mail_send_date = date('Y-m-d H:i:s');
                $mail->mail_body = $mail_body;
                $mail->save();

                $header     = trans('lang.delete_form_title');
                $body       = trans('lang.delete_form_text',['meter'=>trans('lang.transformer_meter_no',['no'=>$form->serial_code])]);
                $remark     = '<div class="remark-danger">&#10039; '.$request->head_remark.'</div>';
                $link       = $route;
                $link_name  = trans('lang.go_to_form');
                $from       = divType($form->div_state_id);
                Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));

            }

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->survey_confirm_headoffice = admin()->id;
            $adminAction->save();

            return redirect()->route('transformerGroundCheckDoneListByHeadOffice.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function tsf_pending_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'tsf_app_pending';
            $heading = 'pending';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                /* Tsf end by div_state */
                ->where([
                    ['application_forms.apply_type', 4],
                    ['form_process_actions.form_pending', true],
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.transformer.pendingList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_pending_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_pending';
            $heading = 'pending';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurveyTransformer::where('application_form_id', $form_id)->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->first();
            return view('admin.transformer.pendingList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files', 'survey_result', 'error', 'pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_pending_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;

            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->form_pending = false;
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->form_pending = admin()->id;
            $adminAction->save();
            return redirect()->route('transformerPendingForm.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function tsf_reject_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'tsf_app_reject';
            $heading = 'reject';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                /* Tsf end by div_state */
                ->where([
                    ['application_forms.apply_type', 4],
                    ['form_process_actions.form_reject', true],
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.transformer.rejectList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_reject_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_reject';
            $heading = 'reject';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurveyTransformer::where('application_form_id', $form_id)->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $reject = FormProcessRemark::where([['application_form_id', $form_id], ['reject_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names_trf = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->first();
            return view('admin.transformer.rejectList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names_trf', 'data', 'files', 'survey_result', 'error', 'pending', 'reject'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function tsf_anno_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'tsf_app_announce';
            $heading = 'announce';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                /* Tsf end by div_state */
                ->where([
                    ['application_forms.apply_type', 4],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_confirm_div_state', true],
                    ['form_process_actions.survey_confirm_div_state_to_headoffice', false],
                    ['form_process_actions.survey_confirm_headoffice', false],
                    ['form_process_actions.announce', false]
                ])
                /* Tsf end by head office */
                ->orWhere([
                    ['application_forms.apply_type', 4],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.survey_confirm_div_state', true],
                    ['form_process_actions.survey_confirm_div_state_to_headoffice', true],
                    ['form_process_actions.survey_confirm_headoffice', true],
                    ['form_process_actions.announce', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.transformer.announceList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_anno_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_announce';
            $heading = 'announce';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurveyTransformer::where('application_form_id', $form_id)->first();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names_trf = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->first();
            return view('admin.transformer.announceList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names_trf', 'data', 'files', 'survey_result', 'error', 'pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_anno_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);

            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->announce = true;
            $action->announced_date = date('Y-m-d H:i:s');
            $action->user_pay = true;
            $action->user_paid_date = date('Y-m-d H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->announce = admin()->id;
            $adminAction->save();

            $expDate = Carbon::now()->addDay(7);

            // $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသောကြောင့် အောက်ဖေါ်ပြပါ လင့်ခ် (Link) ကိုနှိပ်၍ ကျသင့်ငွေအား အွန်လိုင်းငွေချေစနစ်ဖြင့် ငွေပေးသွင်းနိုင်ပြီ ဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် သက်မှတ်ရက် ( <span class="text-danger">'.$expDate->format('d-m-Y').' ၂:၀၀ နာရီ'.'</span> ) ထက်နောက်မကျဘဲ ငွေသွင်းပေးပါရန် အကြောင်းကြားပါသည်။</p>';
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ ငွေသွင်းရန်အဆင့်သို့ ရောက်ရှိနေပြီဖြစ်ပါသည်။ လုပ်ငန်းစဉ်များ ဆက်လက်လုပ်ဆောင်နိုင်ရန်အတွက် လူကြီးမင်းတို့အနေဖြင့် လျှောက်လွှာအတွင်းပါရှိသော အထောက်အထားများ၏ မူရင်းများကို တပါတည်းယူဆောင်၍  သက်မှတ်ရက် ( <span class="text-danger">'.$expDate->format('d-m-Y').' ၂:၀၀ နာရီ'.'</span> ) ထက်နောက်မကျဘဲ ရုံးသို့ လူကိုယ်တိုင် လာရောက်ငွေသွင်းပေးပါရန် အကြောင်းကြားပါသည်။</p>';
            // $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.route('user_pay_form.create', $form_id).'" class="btn btn-info text-center">Click for payment</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form_id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 5;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();

            $header     = trans('lang.pay_form_title');
            $body       = trans('lang.pay_form_text',['meter'=>trans('lang.transformer_meter_no',['no'=>$form->serial_code]), 'date' => $expDate->format('d-m-Y')]);
            $remark     = '';
            // $link       = route('user_pay_form.create', $form_id);
			// $link_name  = trans('lang.click_for_payment');
			$link       = '';
            $link_name  = "";
            $from       = divType($form->div_state_id);
            Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from));

            return redirect()->route('transformerAnnounceList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function tsf_payment_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'tsf_app_payment';
            $heading = 'confirm_payment';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 4],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.announce', true],
                    ['form_process_actions.payment_accept', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.transformer.paymentList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_payment_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_payment';
            $heading = 'confirm_payment';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurveyTransformer::where('application_form_id', $form_id)->first();            
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names_trf = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->first();
            $sub_type = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->first();
            $user_pay = Payment::where('application_form_id', $form_id)->first();
            return view('admin.transformer.paymentList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names_trf', 'data', 'files', 'survey_result', 'sub_type', 'user_pay', 'error', 'pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_payment_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $form_id = $request->form_id;
            $paid_date = date('Y-m-d', strtotime($request->accept_date));

            $action = FormProcessAction::where('application_form_id', $form_id)->first();
            $action->payment_accept = true;
            $action->payment_accepted_date = $paid_date.' '.date('H:i:s');
            $folder_name = $form_id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            if ($request->hasFile('payment_accepted_slips')) {
                foreach($request->file('payment_accepted_slips') as $slip){
                    $ext = $slip->getClientOriginalExtension();
                    $file = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $image = Image::make($slip);
                        $image->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $image->save($path.'/'.$file);
                    }else{ // pdf
                        //Upload File
                        $slip->storeAs($pathPDF,$file);
                    }
                    $data[] = $file;
                }
                $files  = implode(',', $data);
            }else{
                $files = null;
            }
            $action->payment_accepted_slips = $files;
            $action->payment_accepted_slip_nos = $request->payment_accepted_slip_nos;
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form_id)->first();
            $adminAction->payment_accept = admin()->id;
            $adminAction->save();
            
            $form = ApplicationForm::find($form_id);
            $user = User::find($form->user_id);
            // $pay_date = Payment::where('application_form_id', $form_id)->first()->created_at;
            $route = route('tsf_applied_form_ygn', $form->id);
            if ($form->apply_division == 2) {
                $route = route('tsf_applied_form', $form->id);
            }elseif ($form->apply_division == 3) {
                $route = route('tsf_applied_form_mdy', $form->id);
            }
            
            $mail_body = '<p>လူကြီးမင်း လျှောက်ထားသော ထရန်စဖော်မာ ( လျှောက်လွှာအမှတ်စဉ်-<span class="text-danger">'.$form->serial_code.'</span> ) မှာ ('.date('d-m-Y', strtotime($paid_date)).')တွင် ငွေသွင်းလက်ခံ ရရှိပြီးဖြစ်ကြောင်း အကြောင်းကြားပါသည်။</p>';

            // add the payment slips to mail body
            $fpa = DB::table("form_process_actions")->where("application_form_id", $form->id)->first();
            $files = explode(",",$fpa->payment_accepted_slips);
            if(count($files)> 0){
                $payment_slips = "Payment Slips : </br>";
                $payment_slips .= '<div class="row">';
                foreach ($files as $file) {
                    $filename = asset('storage/user_attachments/'.$form->id.'/'.$file);
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    ;
                    if($file != ""){
                        if($ext != 'pdf'){
                            $payment_slips .= "<div class='col-md-2'><img src='".asset('storage/user_attachments/'.$form->id.'/'.$file)."' alt='".$file."' class='img-thumbnail'  data-toggle='modal' data-target='#myImg'></div>";
                        }else{
                            $payment_slips .= "<a href='".asset('storage/user_attachments/'.$form->id.'/'.$file)."' target='_blank' class='pdf-block'>".$file."</a>";
                        }
                    }
                }
                $payment_slips .= '</div>';
                $mail_body .= $payment_slips;
            }

            $mail_body .= '<div class="text-center mt-5 mb-5"><a href="'.$route.'" class="btn btn-info text-center">Go to Form</a></div>';

            $mail = new MailTbl();
            $mail->application_form_id = $form_id;
            $mail->user_id = $form->user_id;
            $mail->sender_id = admin()->id;
            $mail->send_type = 6;
            $mail->mail_send_date = date('Y-m-d H:i:s');
            $mail->mail_body = $mail_body;
            $mail->save();

            $header     = trans('lang.receivepay_form_title');
            $body       = trans('lang.receivepay_form_text',['meter'=>trans('lang.transformer_meter_no',['no'=>$form->serial_code]),'date'=>(date('d-m-Y', strtotime($paid_date)))]);
            $remark     = '';
            $link       = $route;
            $link_name  = trans('lang.go_to_form');
            $from       = divType($form->div_state_id);
            $file_path  = public_path('storage/user_attachments/'.$form->id.'/');
            Mail::to($user->email)->send(new SendMail($header, $body, $remark, $link, $link_name, $from, $files, $file_path));

            /* queue and mail */
            // dispatch(new PaymentDoneJob($mail_detail));
            return redirect()->route('transformerPaymentList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function tsf_chk_install_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'tsf_app_chk_install';
            $heading = 'chk_install';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 4],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.payment_accept', true],
                    ['form_process_actions.install_accept', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());

            return view('admin.transformer.installList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_chk_install_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_chk_install';
            $heading = 'chk_install';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurveyTransformer::where('application_form_id', $form_id)->first();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names_trf = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->first();
            return view('admin.transformer.installList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names_trf', 'data', 'files', 'survey_result', 'error', 'pending'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_chk_install_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // $this->validate($request, [
            //         'form_id' => 'required',
            //         'date' => 'required',
            //         // 'form_get_date' => 'required',
            //         'description' => 'required',
            //         'cash_kyat' => 'required',
            //         'calculator' => 'required',
            //         'calcu_date' => 'required',
            //         'payment_form_no' => 'required',
            //         'payment_form_date' => 'required',
            //         'deposite_form_no' => 'required',
            //         'deposite_form_date' => 'required',
            //         'somewhat' => 'required',
            //         'somewhat_form_date' => 'required',
            //         'string_form_no' => 'required',
            //         'string_form_date' => 'required',
            //         'service_string_form_date' => 'required',
            //     ]);
            // dd($request->all());
            $action = FormProcessAction::where('application_form_id', $request->form_id)->first();
            $action->install_accept = true;
            $action->install_accepted_date = date('Y-m-d', strtotime($request->accept_date)).' '.date('H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $request->form_id)->first();
            $adminAction->install_accept = admin()->id;
            $adminAction->save();

            $form138 = new Form138();
            $form138->application_form_id = $request->form_id;
            $form138->form_send_date = $request->date;
            $form138->form_get_date = $request->form_get_date;
            $form138->description = $request->description;
            $form138->cash_kyat = $request->cash_kyat;
            $form138->calculator = $request->calculator;
            $form138->calcu_date = $request->calcu_date;
            $form138->payment_form_no = $request->payment_form_no;
            $form138->payment_form_date = $request->payment_form_date;
            $form138->deposite_form_no = $request->deposite_form_no;
            $form138->deposite_form_date = $request->deposite_form_date;
            $form138->somewhat = $request->somewhat;
            $form138->somewhat_form_date = $request->somewhat_form_date;
            $form138->string_form_no = $request->string_form_no;
            $form138->string_form_date = $request->string_form_date;
            $form138->service_string_form_date = $request->service_string_form_date;
            $form138->save();
            return redirect()->route('transformerCheckInstallList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function tsf_install_done_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'tsf_app_install_done';
            $heading = 'to_ei_confirm_div_state';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 4],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.install_accept', true],
                    ['form_process_actions.install_confirm', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin/transformer/installDoneList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_install_done_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_install_done';
            $heading = 'to_ei_confirm_div_state';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurveyTransformer::where('application_form_id', $form_id)->first();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $install = Form138::where('application_form_id',$form_id)->first();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names_trf = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->first();
            $install_date = $action = FormProcessAction::where('application_form_id', $form_id)->first()->install_accepted_date;
            return view('admin.transformer.installDoneList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names_trf', 'data', 'files', 'survey_result', 'error', 'pending', 'install', 'install_date'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_install_done_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->validate($request, [
                    'form_id' => 'required',
                    'front' => 'required',
                    'ei_remark' => 'required',
                ]);
            // dd($request->all());
            $form = ApplicationForm::find($request->form_id);
            $folder_name = $form->id;
            $path = public_path('storage/user_attachments/'.$folder_name);
            $pathPDF = "user_attachments/".$folder_name;
            $tmp_arr = [];
            if ($request->hasFile('front')) {
                foreach($request->file('front') as $front){
                    $ext = $front->getClientOriginalExtension();
                    $file = get_random_string().'_'.getdate()[0].'.'.$ext;
                    if($ext != 'pdf'){ // jpg, png
                        $image = Image::make($front);
                        $image->resize(800, 800, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $image->save($path.'/'.$file);
                    }else{ // pdf
                        //Upload File
                        $front->storeAs($pathPDF,$file);
                    }
                    $data[] = $file;
                }
                $files  = implode(',', $data);
            }else{
                $files = null;
            }

            $new = new FormEiChk();
            $new->application_form_id = $form->id;
            $new->ei_files = $files;
            $new->ei_remark = $request->ei_remark;
            $new->save();   

            $action = FormProcessAction::where('application_form_id', $form->id)->first();
            $action ->install_confirm = true;
            $action->install_confirmed_date = date('Y-m-d H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $form->id)->first();
            $adminAction->install_confirm = admin()->id;
            $adminAction->save();

            return redirect()->route('transformerInstallationDoneList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function tsf_reg_meter_list(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $serial = $request->serial ? $request->serial : null;
            $name = $request->name ? $request->name : null;
            
            $active = 'tsf_app_reg_meter';
            $heading = 'reg_meter';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where([
                    ['application_forms.apply_type', 4],
                    ['form_process_actions.form_reject', false],
                    ['form_process_actions.form_pending', false],
                    ['form_process_actions.install_confirm', true],
                    ['form_process_actions.register_meter', false]
                ])
                ->when($name, function ($query, $name) {
                    return $query->where('application_forms.fullname', $name);
                })
                ->when($serial, function ($query, $serial) {
                    return $query->where('application_forms.serial_code', $serial);
                })
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());

            return view('admin.transformer.regMeterList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_reg_meter_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_reg_meter';
            $heading = 'reg_meter';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            $survey_result = FormSurveyTransformer::where('application_form_id', $form_id)->first();            
            $error = FormProcessRemark::where([['application_form_id', $form_id], ['error_remark', '!=', NULL]])->get();
            $pending = FormProcessRemark::where([['application_form_id', $form_id], ['pending_remark', '!=', NULL]])->get();
            $install = Form138::where('application_form_id',$form_id)->first();
            $install_date = $action = FormProcessAction::where('application_form_id', $form_id)->first()->install_accepted_date;

            $ei_data = FormEiChk::where('application_form_id', $form_id)->first();
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names_trf = InitialCost::where([['type', $data->apply_type], ['sub_type', $data->apply_sub_type]])->first();
            return view('admin.transformer.regMeterList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names_trf', 'data', 'files', 'survey_result', 'error', 'pending', 'ei_data', 'install', 'install_date'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_reg_meter_list_store(Request $request) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            // dd($request->all());
            $id = $request->form_id;

            $action = FormProcessAction::where('application_form_id', $id)->first();
            $action->register_meter = true;
            $action->registered_meter_date = date('Y-m-d H:i:s');
            $action->save();

            $adminAction = AdminAction::where('application_form_id', $id)->first();
            $adminAction->register_meter = admin()->id;
            $adminAction->save();
            
            $remark = new Form66();
            $remark->application_form_id = $id;
            $remark->meter_no = $request->meter_no;
            $remark->meter_unit_no = $request->meter_unit_no;
            $remark->cover_seal_no = $request->cover_seal_no;
            $remark->terminal_seal_no = $request->terminal_seal_no;
            $remark->box_seal_no = $request->box_seal_no;
            $remark->ledger_no = $request->ledger_no;
            // $remark->meter_seal_no = $request->meter_seal_no;
            $remark->meter_get_date = $request->meter_get_date != "" ? date('Y-m-d', strtotime($request->meter_get_date)) : null;
            $remark->who_made_meter = $request->who_made_meter;
            $remark->ampere = $request->ampere;
            $remark->pay_date = $request->pay_date != "" ? date('Y-m-d', strtotime($request->pay_date)) : null;
            // $remark->mark_user_no = $request->mark_user_no;
            $remark->budget = $request->budget;
            $remark->move_date = $request->move_date != "" ? date('Y-m-d', strtotime($request->move_date)) : null;
            $remark->move_budget = $request->move_budget;
            $remark->move_order = $request->move_order;
            $remark->test_date = $request->test_date != "" ? date('Y-m-d', strtotime($request->test_date)) : null;
            $remark->test_no = $request->test_no;
            $remark->installer_name = $request->installer_name;
            $remark->installer_post = $request->installer_post;
            $remark->remark = $request->remark;
            $remark->save();
            return redirect()->route('transformerRegisterMeterList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }
    /* ------------------------------------------------------------------------------ */

    public function admin_profile_edit(){
        $admin           = admin();
        $password_error = Session::get('password_error');
        $active = '';
        $heading = '';
        return view('admin/setting/profile_edit', compact('admin','password_error','active','heading'));
    }

    public function admin_profile_update(Request $request,$id){
        if($id != admin()->id){
            $id = '0';
        }
        $admin = Admin::findOrFail($id);
        if(Hash::check($request->password, $admin->password)){
            
            $logout = false;
            $rules['name'] = ['required', 'string', 'max:255'];
            if($admin->username != $request->username){
                $rules['username'] = ['required', 'string', 'max:255', 'unique:admins'];
                $logout = true;
            }
            if($admin->email != $request->email){
                $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:admins'];
                $logout = true;
            }

            Validator::make($request->all(), $rules)->validate();
            $admin->name        = $request->name;
            $admin->username    = $request->username;
            $admin->email       = $request->email;
            $admin->phone       = $request->phone;
            $admin->save();

            if(!$logout){
                return redirect()->route('dashboard');
            }else{
                Auth::guard('admin')->logout();
                return redirect('/login/moee');
            }
        }else{
            $password_error = trans('lang.password_false');
            return redirect()->route('admin_profile_edit')->with(['password_error'=>$password_error]);
        }
        
    }

    public function admin_password_edit(){
        $admin           = admin();
        $password_error = Session::get('password_error');
        $active = '';
        $heading = '';
        return view('admin.setting.password_edit', compact('admin','password_error','active','heading'));
    }

    public function admin_password_update(Request $request,$id){
        if($id != admin()->id){
            $id = '0';
        }
        $admin = Admin::findOrFail($id);
        if(Hash::check($request->old_password, $admin->password)){
            Validator::make($request->all(), [
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ])->validate();
            $admin->password = Hash::make($request->password);
            $admin->save();
            Auth::guard('admin')->logout();
            return redirect('/login/moee');
        }else{
            $password_error = trans('lang.password_false');
            return redirect()->route('admin_password_edit')->with(['password_error'=>$password_error]);
        }
	}
	
	public function delete_form_respective($form_id){

        DB::table('application_files')->where('application_form_id', $form_id)->delete();

        DB::table('application_form_contractors')->where('application_form_id', $form_id)->delete();
        DB::table('form66s')->where('application_form_id', $form_id)->delete();
        DB::table('form138s')->where('application_form_id', $form_id)->delete();
        DB::table('form_drafts')->where('application_form_id', $form_id)->delete();
        DB::table('form_ei_chks')->where('application_form_id', $form_id)->delete();
        DB::table('form_process_actions')->where('application_form_id', $form_id)->delete();
        DB::table('form_process_remarks')->where('application_form_id', $form_id)->delete();
        DB::table('form_routines')->where('application_form_id', $form_id)->delete();
        DB::table('form_surveys')->where('application_form_id', $form_id)->delete();
        DB::table('form_survey_transformers')->where('application_form_id', $form_id)->delete();

        return true;
        
    }


    public function delete_form(Request $request){
        if(Auth::guard('admin')->check()){
            if(Auth::guard('admin')->user()->email == 'system@mail.com'){
                $field = $request->field;
                $value = $request->value;
                if($field != '' && $value != ''){
                    $form = ApplicationForm::where($field,$value)->first();

                    if(!isset($form)){
                        $form_id = $value;
                    }else{
                        $form_id = $form->id;
                    }
                    $this->delete_form_respective($form_id);
                    if(ApplicationForm::where($field, '=', $value)->delete()){
                        $this->delete_form_respective($form->id);
                       
                        $path = public_path('storage/user_attachments/'.$form->id);
                     
                        if(is_dir($path)) {
                            if(File::deleteDirectory($path)){
                                return "delete db and file uploads of ".$field.": ".$value;
                            }else{
                                return "delete db but error in deleting file uploads of ".$field.": ".$value;
                            }
                        }else{
                            return "delete db success but no upload file of ".$field.": ".$value;
                        }
                    }else{
                        return "delete db failed of ".$field.": ".$value;
                    }
                }else{
                    return $field." is null.";
                }
            }else{
                return "Permission denied!";
            }
        }else{
            return "Permission denied!";
        }
    }
 
    public function delete_multiform(Request $request){
        $count = 0;
        $file = public_path('storage/delete_id.txt');
        $handle = fopen($file, "r");
        $field = $request->field ?? 'id';
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                // process the line read.
                $request = new Request();
                $request->replace(['value' => $line, 'field' => $field]);
                echo $this->delete_form($request);

                // echo $line;
                $count++;
                echo "<br>";
            }
            fclose($handle);
            echo "delete ".$count." files successful! ";
        } else {
            // error opening the file.
            return 'cannot open file';
        }
    }
}
