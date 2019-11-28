    public function residential_contract_list() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app_contract';
            $heading = 'contract_menu';
            $form = DB::table('application_forms')
                ->join('form_process_actions', 'form_process_actions.application_form_id', '=', 'application_forms.id')
                ->where('form_process_actions.payment_accept', true)
                ->Where('form_process_actions.contract', false)
                /* ->orderBy('date', 'desc')
                ->orderBy('id', 'desc') */
                ->select('application_forms.*')
                ->paginate(10);
            $form->appends(request()->query());
            return view('admin.residential.contractList_index', compact('heading', 'active', 'form'))->with('i', (request()->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_contract_list_show($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app_contract';
            $heading = 'contract_menu';
            $data = ApplicationForm::find($form_id);
            $files = $data->application_files;
            
            $tbl_col_name = Schema::getColumnListing('initial_costs');
            $fee_names = InitialCost::where([['type', 1], ['sub_type', $data->apply_sub_type]])->get();
            return view('admin.residential.contractList_show', compact('active', 'heading', 'tbl_col_name', 'fee_names', 'data', 'files'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_contract_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'resident_app_contract';
            $heading = 'contract_menu';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('admin.residential.contractList_create', compact('heading', 'active', 'form', 'files'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function residential_contract_list_store(Request $request) {
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
            return redirect()->route('residentialMeterContractList.index');
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_grd_chk_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_survey';
            $heading = 'residentSurvey';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            $tsf_info = TsfInfo::where('application_form_id', $form_id)->get();
            return view('admin.transformer.surveyList_create', compact('heading', 'active', 'form', 'files', 'tsf_info'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_grd_done_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_gnd_done';
            $heading = 'residentSurveyDone';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            $survey_result = FormSurveyTransformer::where('application_form_id', $form_id)->first();
            $tsf_info = TsfInfo::where('application_form_id', $form_id)->get();
            return view('admin.transformer.surveyDoneList_create', compact('active', 'heading', 'form', 'survey_result', 'tsf_info'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_grd_done_list_create_by_dist($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_gnd_done_dist';
            $heading = 'residentSurveyDone';
            $form = ApplicationForm::find($form_id);
            $survey_result = FormSurveyTransformer::where('application_form_id', $form_id)->first();
            $tsf_info = TsfInfo::where('application_form_id', $form_id)->get();
            return view('admin.transformer.surveyDoneList_create_dist', compact('active', 'heading', 'form', 'survey_result', 'tsf_info'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_grd_done_list_create_by_div_state($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_gnd_done_div_state';
            $heading = 'residentSurveyDone';
            $form = ApplicationForm::find($form_id);
            $survey_result = FormSurveyTransformer::where('application_form_id', $form_id)->first();
            $tsf_info = TsfInfo::where('application_form_id', $form_id)->get();
            return view('admin.transformer.surveyDoneList_create_div_state', compact('active', 'heading', 'form', 'survey_result', 'tsf_info'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_payment_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_payment';
            $heading = 'confirm_payment';
            $form = ApplicationForm::find($form_id);
            $sub_type = InitialCost::where([['type', $form->apply_type], ['sub_type', $form->apply_sub_type]])->first();
            $user_pay = Payment::where('application_form_id', $form_id)->first();
            return view('admin.transformer.paymentList_create', compact('heading', 'active', 'form', 'sub_type', 'user_pay'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_chk_install_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_chk_install';
            $heading = 'chk_install';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('admin.transformer.installList_create', compact('heading', 'active', 'form', 'files'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_install_done_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_install_done';
            $heading = 'ei_chk_install';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('admin.transformer.installDoneList_create', compact('heading', 'active', 'form', 'files'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function tsf_reg_meter_list_create($form_id) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $active = 'tsf_app_reg_meter';
            $heading = 'reg_meter';
            $form = ApplicationForm::find($form_id);
            $files = $form->application_files;
            return view('admin.transformer.regMeterList_create', compact('heading', 'active', 'form', 'files'));
        } else {
            return redirect()->route('dashboard');
        }
    }