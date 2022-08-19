@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    @if (chk_userForm($data->id)['to_confirm_div_state'])
                    <a href="{{ route('transformerGroundCheckDoneListByDivisionState.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                    @elseif (chk_userForm($data->id)['to_confirm_dist'])
                    <a href="{{ route('transformerGroundCheckDoneListByDistrict.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                    @elseif (chk_userForm($data->id)['to_confirm_survey'])
                    <a href="{{ route('transformerGroundCheckDoneList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                    @endif
                </div>
            </div>
            <div class="card-body card-body-pb-div">

                @include('layouts.form-progressbar')

                <div class="container-fluid">
                    <div id="app_show" class="accordion" role="tablist" aria-multiselectable="true">
                        
                        @include('layouts.user_apply_form')

                    </div>
                    <div class="card mb-1">
                        {{--  --------------------------------- Head Office ---------------------------------  --}}
                        @if (chk_userForm($data->id)['to_confirm_div_state_to_headoffice'])
                            @if (hasPermissions(['transformerHeadChkGrd-create'])) {{--  if login-user is from township  --}}
                                {{-- @if(Auth::user()->hasRole('SeniorEngineer(Township)')) --}}
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('ရုံးချုပ်အဆင့် စစ်ဆေးရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                            <br/>
                            {!! Form::open(['route' => 'transformerGroundCheckDoneListByHeadOffice.store', 'files' => true]) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <div class="row justify-content-center m-t-20">
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label for="capacitor_bank" class="col-md-5 col-form-label text-info">{{ __('Capacitor Bank တပ်ဆင်ရန် လို/မလို') }}</label>
                                        <input type="radio" class="check" name="capacitor_bank" value="yes" id="capacitor_bank_yes" data-radio="iradio_square-red">&nbsp;
                                        <label for="capacitor_bank_yes">{{ __('လိုပါသည်') }}</label> &nbsp;&nbsp;&nbsp;
                                        <input type="radio" class="check" name="capacitor_bank" value="no" id="capacitor_bank_no" data-radio="iradio_square-red">&nbsp;
                                        <label for="capacitor_bank_no">{{ __('မလိုပါ') }}</label>
                                    </div>
                                    <!-- <div class="form-group row">
                                        <label for="outfit_meter" class="col-md-5 col-form-label text-info">{{ __('Outfit မီတာတပ်ဆင်ရန် လို/မလို') }}</label>
                                        <input type="radio" class="check" name="outfit_meter" value="yes" id="outfit_meter_yes" data-radio="iradio_square-red" >&nbsp;
                                        <label for="outfit_meter_yes">{{ __('လိုပါသည်') }}</label>&nbsp;&nbsp;&nbsp;
                                        <input type="radio" class="check" name="outfit_meter" value="no" id="outfit_meter_no" data-radio="iradio_square-red" >&nbsp;
                                        <label for="outfit_meter_no">{{ __('မလိုပါ') }}</label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="vcd" class="col-md-5 col-form-label text-info">{{ __('VCD တပ်ဆင်ရန် လို/မလို') }}</label>
                                        <input type="radio" class="check" name="vcd" value="yes" id="vcd_yes" data-radio="iradio_square-red" >&nbsp;
                                        <label for="vcd_yes">{{ __('လိုပါသည်') }}</label>&nbsp;&nbsp;&nbsp;
                                        <input type="radio" class="check" name="vcd" value="no" id="vcd_no" data-radio="iradio_square-red" >&nbsp;
                                        <label for="vcd_no">{{ __('မလိုပါ') }}</label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="load_break_switch" class="col-md-5 col-form-label text-info">{{ __('Load Break Switch တပ်ဆင်ရန် လို/မလို') }}</label>
                                        <input type="radio" class="check" name="load_break_switch" value="yes" id="load_break_switch_yes" data-radio="iradio_square-red" >&nbsp;
                                        <label for="load_break_switch_yes">{{ __('လိုပါသည်') }}</label>&nbsp;&nbsp;&nbsp;
                                        <input type="radio" class="check" name="load_break_switch" value="no" id="load_break_switch_no" data-radio="iradio_square-red" >&nbsp;
                                        <label for="load_break_switch_no">{{ __('မလိုပါ') }}</label>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="head_remark" class="text-info">မှတ်ချက် <span class="text-danger f-s-15">&#10039;</span></label>
                                        <textarea required name="head_remark" rows="5" class="form-control" id="head_remark" placeholder="မှတ်ချက်ပေးရန်"></textarea>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="head_office_recomm" class="text-info">{{ __('ထောက်ခံချက်တွဲရန်') }}</label><br>
                                        <input type="file" name="head_office_recomm" id="head_office_recomm" accept=".jpg,.png,.pdf"/>
                                    </div> --}}
                                </div>
                            </div>

                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-md-3">
                                        <button type="submit" name="survey_confirm_by_headoffice" value="approve" class="waves-effect waves-light btn btn-rounded btn-primary btn-block">{{ __('lang.send_dist_tsp') }}</button>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" name="survey_confirm_by_headoffice" value="resend" class="waves-effect waves-light btn btn-rounded btn-warning btn-block">{{ __('lang.send_tsp_error') }}</button>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                                {{--  @endif  --}}
                            @endif
                        @endif
                        {{--  ----------------------------------------------------------------------------  --}}
                        {{--  --------------------------------- Division ---------------------------------  --}}
                        @if (chk_userForm($data->id)['to_confirm_div_state'])
                            @if (hasPermissions(['transformerDivStateChkGrd-create'])) {{--  if login-user is from township  --}}
                                {{-- @if(Auth::user()->hasRole('SeniorEngineer(Township)')) --}}
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('တိုင်းဒေသကြီး/ပြည်နယ်အဆင့် စစ်ဆေးရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                            <br/>
                            {!! Form::open(['route' => 'transformerGroundCheckDoneListByDivisionState.store', 'files' => true]) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <div class="row justify-content-center m-t-20">
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <label for="capacitor_bank" class="col-md-5 col-form-label text-info">{{ __('Capacitor Bank လို/မလို') }} <span class="text-danger f-s-15">&#10039;</span></label>
                                        <div class="col-md-7">
                                            <input type="radio" class="check" name="capacitor_bank" value="yes" id="capacitor_bank_yes" data-radio="iradio_square-red" required>
                                            <label for="capacitor_bank_yes">{{ __('လိုပါသည်') }}</label>
                                            <input type="radio" class="check" name="capacitor_bank" value="no" id="capacitor_bank_no" data-radio="iradio_square-red" required>
                                            <label for="capacitor_bank_no">{{ __('မလိုပါ') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="capacitor_bank_amt" class="col-md-5 col-form-label text-info">{{ __('လိုအပ်သော KVAr') }}</label>
                                        <div class="col-md-7">
                                            <input type="text" name="capacitor_bank_amt" class="form-control" id="capacitor_bank_amt" placeholder="လိုအပ်သော KVAr" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="outfit_meter" class="col-md-5 col-form-label text-info">{{ __('Outfit မီတာတပ်ဆင်ရန် လို/မလို') }}</label>
                                        <div class="col-md-7">
                                            <input type="radio" class="check" name="outfit_meter" value="yes" id="outfit_meter_yes" data-radio="iradio_square-red" >
                                            <label for="outfit_meter_yes">{{ __('လိုပါသည်') }}</label>
                                            <input type="radio" class="check" name="outfit_meter" value="no" id="outfit_meter_no" data-radio="iradio_square-red" >
                                            <label for="outfit_meter_no">{{ __('မလိုပါ') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="vcd" class="col-md-5 col-form-label text-info">{{ __('VCD တပ်ဆင်ရန် လို/မလို') }}</label>
                                        <div class="col-md-7">
                                            <input type="radio" class="check" name="vcd" value="yes" id="vcd_yes" data-radio="iradio_square-red" >
                                            <label for="vcd_yes">{{ __('လိုပါသည်') }}</label>
                                            <input type="radio" class="check" name="vcd" value="no" id="vcd_no" data-radio="iradio_square-red" >
                                            <label for="vcd_no">{{ __('မလိုပါ') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="load_break_switch" class="col-md-5 col-form-label text-info">{{ __('Load Break Switch တပ်ဆင်ရန် လို/မလို') }}</label>
                                        <div class="col-md-7">
                                            <input type="radio" class="check" name="load_break_switch" value="yes" id="load_break_switch_yes" data-radio="iradio_square-red" >
                                            <label for="load_break_switch_yes">{{ __('လိုပါသည်') }}</label>
                                            <input type="radio" class="check" name="load_break_switch" value="no" id="load_break_switch_no" data-radio="iradio_square-red" >
                                            <label for="load_break_switch_no">{{ __('မလိုပါ') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="div_state_remark" class="text-info">မှတ်ချက်<span class="text-danger f-s-15">&#10039;</span></label>
                                        <textarea required name="div_state_remark" rows="5" class="form-control" id="div_state_remark" placeholder="မှတ်ချက်ပေးရန်"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="div_state_recomm" class="text-info">{{ __('ထောက်ခံချက်တွဲရန်') }}</label><br>
                                        <input type="file" name="div_state_recomm" id="div_state_recomm" accept=".jpg,.png,.pdf"/>
                                    </div>
                                </div>
                            </div>

                            <div class="container">
                                <div class="row justify-content-center">
                                    @if (chk_ygn_mdy($data->div_state_id))
                                    <div class="col-md-2">
                                        <button type="submit" name="survey_confirm_by_divstate" value="send" class="btn btn-rounded btn-primary btn-block">{{ __('lang.send_headoffice') }}</button>
                                    </div>
                                    @endif
                                    <div class="{{ chk_ygn_mdy($data->div_state_id) ? 'col-md-2' : 'col-md-3' }}">
                                        <button type="submit" name="survey_confirm_by_divstate" value="approve" class="btn btn-rounded btn-primary btn-block">{{ __('lang.send_dist_tsp') }}</button>
                                    </div>
                                    <div class="{{ chk_ygn_mdy($data->div_state_id) ? 'col-md-2' : 'col-md-3' }}">
                                        <button type="submit" name="survey_confirm_by_divstate" value="resend" class="btn btn-rounded btn-info btn-block">{{ __('lang.send_tsp_error') }}</button>
                                    </div>
                                    <div class="{{ chk_ygn_mdy($data->div_state_id) ? 'col-md-2' : 'col-md-3' }}">
                                        <a class="waves-effect waves-light btn btn-block btn-rounded btn-warning text-white" data-toggle="modal" data-target="#myPendingModal" data-backdrop="static" data-keyboard="false" data-id="{{ $data->id }}" data-type="3">{{ __('lang.send_pending') }}</a>
                                    </div>
                                    <div class="{{ chk_ygn_mdy($data->div_state_id) ? 'col-md-2' : 'col-md-3' }}">
                                        <a class="waves-effect waves-light btn btn-block btn-rounded btn-danger text-white" data-toggle="modal" data-target="#myRejectModal" data-backdrop="static" data-keyboard="false" data-id="{{ $data->id }}" data-type="3">{{ __('lang.send_reject') }}</a>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                                {{--  @endif  --}}
                            @endif
                        @endif
                        {{--  ----------------------------------------------------------------------------  --}}
                        {{--  --------------------------------- District ---------------------------------  --}}
                        @if (chk_userForm($data->id)['to_confirm_dist'])
                            @if (hasPermissions(['transformerDistrictChkGrd-create'])) {{--  if login-user is from township  --}}
                                {{-- @if(Auth::user()->hasRole('SeniorEngineer(Township)')) --}}
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('ခရိုင်အဆင့် စစ်ဆေးရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                            <br/>
                            {!! Form::model($survey_result, ['route' => 'transformerGroundCheckDoneListByDistrict.store', 'files' => true]) !!}
                            {!! Form::hidden('form_id', $data->id) !!}

                            <div class="row justify-content-center m-t-20">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="dist_remark" class="text-info">မှတ်ချက် <span class="text-danger f-s-15">&#10039;</span></label>
                                        <textarea required name="dist_remark" rows="5" class="form-control" id="dist_remark" placeholder="မှတ်ချက်ပေးရန်"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="dist_recomm" class="text-info">{{ __('ထောက်ခံချက်တွဲရန်') }}</label><br>
                                        <input type="file" name="dist_recomm" id="dist_recomm" accept=".jpg,.png,.pdf"/>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-3">
                                        <button type="submit" name="survey_submit_district" value="send" class="btn btn-rounded btn-block btn-primary">{{ __('lang.send_div_state') }}</button>
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" name="survey_submit_district" value="resend" class="btn btn-rounded btn-block btn-info">{{ __('lang.send_tsp_error') }}</button>
                                    </div>
                                    <div class="col-3">
                                        <a class="waves-effect waves-light btn btn-block btn-rounded btn-warning text-white" data-toggle="modal" data-target="#myPendingModal" data-backdrop="static" data-keyboard="false" data-id="{{ $data->id }}" data-type="2">{{ __('lang.send_pending') }}</a>
                                    </div>
                                    <div class="col-3">
                                        <a class="waves-effect waves-light btn btn-block btn-rounded btn-danger text-white" data-toggle="modal" data-target="#myRejectModal" data-backdrop="static" data-keyboard="false" data-id="{{ $data->id }}" data-type="2">{{ __('lang.send_reject') }}</a>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                                {{-- @endif --}}
                            @endif
                        @endif
                        {{--  ----------------------------------------------------------------------------  --}}
                        {{--  --------------------------------- Township ---------------------------------  --}}
                        @if (chk_userForm($data->id)['to_confirm_survey'])
                            @if (hasPermissions(['transformerTownshipChkGrd-create'])) {{--  if login-user is from township  --}}
                                {{-- @if(Auth::user()->hasRole('SeniorEngineer(Township)')) --}}
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('မြို့နယ်အဆင့် စစ်ဆေးရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                            <br/>
                            {!! Form::open(['route' => 'transformerGroundCheckDoneList.store', 'files' => true]) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <div class="row justify-content-center m-t-20">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="tsp_remark" class="text-info">မှတ်ချက် <span class="text-danger f-s-15">&#10039;</span></label>
                                        <textarea required name="tsp_remark" rows="5" class="form-control" id="tsp_remark" placeholder="မှတ်ချက်ပေးရန်"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label for="tsp_recomm" class="text-info">{{ __('သက်ဆိုင်ရာ ထောက်ခံချက်တွဲရန်') }}</label><br>
                                    <input type="file" name="tsp_recomm" id="tsp_recomm" accept=".jpg,.png,.pdf"/>
                                </div>
                            </div>
                            <div class="text-center">
                                <input type="submit" name="survey_submit" value="{{ __('lang.send_district') }}" class="btn btn-rounded btn-info">
                            </div>
                            {!! Form::close() !!}
                        </div>
                                {{-- @endif --}}
                            @endif
                        @endif
                        {{--  ----------------------------------------------------------------------------  --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="myPendingModal" tabindex="-1" role="dialog" aria-labelledby="pendingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title mt-3 mb-3 text-center" id="pendingModalLabel">{{ __("lang.pending_title") }}</h5>
                <hr/>
                <p class="mt-5 mb-5">{{ __("lang.pending_msg") }}</p>
                <div class="div_state_form d-none">
                    {!! Form::open(['route' => 'transformerGroundCheckDoneListByDivisionState.store']) !!}
                    <input type="hidden" name="form_id" id="p_form_id_divstate">
                    <div class="form-group">
                        <label for="pending_remark" class="text-info mt-3 mb-2">{{ __('lang.remark') }} :</label>
                        {!! Form::textarea('div_state_remark', null, ['class' => 'textarea_editor form-control', 'id' => 'pending_remark', 'required']) !!}
                    </div>
                    <div class="text-center">
                        <button type="button" class="waves-effect waves-light btn btn-rounded btn-secondary" data-dismiss="modal">{{ __('lang.cancel') }}</button>
                        <button type="submit" name="survey_confirm_by_divstate" value="pending" class="waves-effect waves-light btn btn-rounded btn-warning">{{ __('ပို့မည်') }}</button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="dist_form d-none">
                    {!! Form::open(['route' => 'transformerGroundCheckDoneListByDistrict.store']) !!}
                    {!! Form::hidden('form_id', null, ['id' => 'p_form_id_dist']) !!}
                    <div class="form-group">
                        <label for="pending_remark" class="text-info mt-3 mb-2">{{ __('lang.remark') }} :</label>
                        {!! Form::textarea('dist_remark', null, ['class' => 'textarea_editor1 form-control', 'id' => 'pending_remark', 'required']) !!}
                    </div>
                    <div class="text-center">
                        <button type="button" class="waves-effect waves-light btn btn-rounded btn-secondary" data-dismiss="modal">{{ __('lang.cancel') }}</button>
                        <button type="submit" name="survey_submit_district" value="pending" class="waves-effect waves-light btn btn-rounded btn-warning">{{ __('ပို့မည်') }}</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="myRejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title mt-3 mb-3 text-center" id="rejectModalLabel">{{ __("lang.reject_title") }}</h5>
                <hr/>
                <p class="mt-5 mb-5">{{ __("lang.reject_msg") }}</p>
                <div class="div_state_form d-none">
                    {!! Form::open(['route' => 'transformerGroundCheckDoneListByDivisionState.store']) !!}
                    {!! Form::hidden('form_id', null, ['id' => 'r_form_id_divstate']) !!}
                    <div class="form-group">
                        <label for="reject_remark" class="text-info mt-3 mb-2">{{ __('lang.remark') }} :</label>
                        <textarea name="div_state_remark" id="reject_remark" class="textarea_editor2 form-control" required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="button" class="waves-effect waves-light btn btn-rounded btn-secondary" data-dismiss="modal">{{ __('lang.cancel') }}</button>
                        <button type="submit" name="survey_confirm_by_divstate" value="reject" class="waves-effect waves-light btn btn-rounded btn-danger">{{ __('ပို့မည်') }}</button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="dist_form d-none">
                    {!! Form::open(['route' => 'transformerGroundCheckDoneListByDistrict.store']) !!}
                    {!! Form::hidden('form_id', null, ['id' => 'r_form_id_dist']) !!}
                    <div class="form-group">
                        <label for="reject_remark" class="text-info mt-3 mb-2">{{ __('lang.remark') }} :</label>
                        <textarea name="dist_remark" id="reject_remark" class="textarea_editor3 form-control" required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="button" class="waves-effect waves-light btn btn-rounded btn-secondary" data-dismiss="modal">{{ __('lang.cancel') }}</button>
                        <button type="submit" name="survey_submit_district" value="reject" class="waves-effect waves-light btn btn-rounded btn-danger">{{ __('ပို့မည်') }}</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
