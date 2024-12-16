@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('residentialMeterGroundCheckList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body card-body-pb-div">

                @include('layouts.form-progressbar')

                <div class="container-fluid">
                    <div id="app_show" class="accordion" role="tablist" aria-multiselectable="true">

                        @include('layouts.user_apply_form')

                        {{-- @if ($error && $error->count() > 0)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#form_resend" aria-expanded="true" aria-controls="collapseOne">{{ __('လျှောက်လွှာပြန်လည်ပြင်ဆင်ချက်များ') }}</a>
                                </h5>
                            </div>
                            <div id="form_resend" class="card-body collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th width="30%"><strong>{{ __('lang.office_send_date') }}</strong></th>
                                                <th><strong>{{ __('lang.office_send_remark') }}</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($error as $e_remark)
                                            <tr>
                                                <td>
                                                    <strong>
                                                        @if (checkMM() == 'mm')
                                                        {{ $e_remark->created_at ? mmNum(date('d-m-Y', strtotime($e_remark->created_at))) : '-' }}
                                                        @else
                                                        {{ $e_remark->created_at ? date('d-m-Y', strtotime($e_remark->created_at)) : '-' }}
                                                        @endif
                                                    </strong>
                                                </td>
                                                <td>@php echo $e_remark->error_remark ? $e_remark->error_remark : '-'; @endphp</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif --}}
                    </div>
                    @if(hasSurvey($data->id))
                        @if (hasPermissions(['residentialGrdChk-create'])) {{--  if login-user is from township  --}}                    
                            {{--  @if(admin()->id == hasSurvey($data->id)->survey_engineer)  --}}
                    <div class="card mb-1">
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('မြေပြင်စစ်ဆေးချက် ဖြည့်သွင်းရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                            <br/>
                            {!! Form::open(['route' => 'residentialMeterGroundCheckList.store', 'files' => true]) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <div class="row justify-content-center m-t-20">
                                <div class="col-md-8">
                                    {{--  line Type  --}}
                                    <div class="form-group">
                                        <label for="" class="text-info">
                                            {{ __('lang.phase_type') }}
                                        </label>
                                        <input type="text" name="phase_type" class="form-control mm" value="၁ သွင် ၂ ကြိုး (single phase)" readonly />
                                    </div>
                                    {{--  Type  --}}
                                    <div class="form-group">
                                        <label for="type" class="text-info">
                                            {{ __('lang.meter_connect_type') }}
                                        </label>
                                        <select name="applied_type" class="form-control mm" id="type">
                                            {{--  <option value="">ရွေးချယ်ရန်</option>  --}}
                                            <option value="1" selected>အသစ်</option>
                                            <option value="2" disabled>တိုးချဲ့</option>
                                            <option value="3" disabled>အမည်ပြောင်း</option>
                                            <option value="4" disabled>ပြန်ဆက်</option>
                                            <option value="5" disabled>မီတာခွဲ</option>
                                            <option value="6" disabled>ယာယီ</option>
                                        </select>
                                    </div>
                                    {{--  Voltage  --}}
                                    <div class="form-group">
                                        <label for="volt" class="text-info">
                                            {{ __('lang.volt') }} <span class="text-danger f-s-15">&#10039;</span>
                                        </label>
                                        <input type="text" name="volt" id="volt" class="form-control" required placeholder="{{ __('lang.kv_format') }}">
                                    </div>
                                    {{--  Kilowatt  --}}
                                    <div class="form-group">
                                        <label for="kilowatt" class="text-info">
                                            {{ __('lang.kilowatt') }} <span class="text-danger f-s-15">&#10039;</span>
                                        </label>
                                        <input type="text" name="kilowatt" id="kilowatt" class="form-control" required>
                                    </div>
                                    {{--  Distance  --}}
                                    <div class="form-group">
                                        <label for="" class="text-info">
                                            {{ __('lang.survey_distance') }} <span class="text-danger f-s-15">&#10039;</span>
                                        </label>
                                        <input type="text" name="distance" id="distance" class="form-control" required>
                                    </div>

                                    {{--  Others Survey  --}}
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="bg-secondary p-10">
                                                <label for="" class="text-info">
                                                    {{ __('lang.living_cdt') }} <span class="text-danger f-s-15">&#10039;</span>
                                                </label>
                                                <div class="row m-t-20">
                                                    <div class="custom-control custom-radio col align-items-center text-center">
                                                        <input type="radio" name="living" value="on" class="custom-control-input" id="living_chkbox1" required>
                                                        <label for="living_chkbox1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                                    </div>

                                                    <div class="custom-control custom-radio col text-center">
                                                        <input type="radio" name="living" value="off" class="custom-control-input" id="living_chkbox2" required>
                                                        <label for="living_chkbox2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="bg-secondary p-10">
                                                <label for="" class="text-info">
                                                    {{ __('lang.residential') }} {{ __('lang.rdy_applied_cdt') }} <span class="text-danger f-s-15">&#10039;</span>
                                                </label>
                                                <div class="row m-t-20">
                                                    <div class="custom-control custom-radio col text-center">
                                                        <input type="radio" name="meter" value="on" class="custom-control-input" id="living_rad1" required>
                                                        <label for="living_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                                    </div>
                                                    <div class="custom-control custom-radio col text-center">
                                                        <input type="radio" name="meter" value="off" class="custom-control-input" id="living_rad2" required>
                                                        <label for="living_rad2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-t-20">
                                        <div class="col-md-6">
                                            <div class="bg-secondary p-10">
                                                <label for="" class="text-info">
                                                    {{ __('lang.invade_cdt') }} <span class="text-danger f-s-15">&#10039;</span>
                                                </label>
                                                <div class="row m-t-20">
                                                
                                                    <div class="custom-control custom-radio col text-center">
                                                        <input type="radio" name="invade" value="on" class="custom-control-input" id="invade_rad1" required>
                                                        <label for="invade_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                                    </div>
                                                    <div class="custom-control custom-radio col text-center">
                                                        <input type="radio" name="invade" value="off" class="custom-control-input" id="invade_rad2" required>
                                                        <label for="invade_rad2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="bg-secondary p-10">
                                                <label for="" class="text-info">
                                                    {{ __('lang.loaded_cdt') }} <span class="text-danger f-s-15">&#10039;</span>
                                                </label>
                                                <div class="row m-t-20">
                                                    <div class="custom-control custom-radio col text-center">
                                                        <input type="radio" name="loaded" value="on" class="custom-control-input" id="loaded_rad1" required>
                                                        <label for="loaded_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                                    </div>
                                                    <div class="custom-control custom-radio col text-center">
                                                        <input type="radio" name="loaded" value="off" class="custom-control-input" id="loaded_rad2" required>
                                                        <label for="loaded_rad2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group m-t-20">
                                        <label for="" class="text-info">
                                            {{ __('lang.applied_electricpower') }} <span class="text-danger f-s-15">&#10039;</span>
                                        </label>
                                        <input type="text" name="comsumed_power_amt" id="comsumed_power_amt" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="front" class="text-info">
                                            {{ __('lang.applied_electricpower_photo') }} <span class="text-danger f-s-15">&#10039;</span>
                                        </label>
                                        <input type="file" name="front" id="front" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                                    </div>
                                    @if ($data->apply_division == 2)
                                    <div class="form-group">
                                        <label for="allowed_type" class="text-info">
                                            {{ __('ခွင့်ပြုမည့် မီတာအမျိုးအစား') }}
                                        </label>
                                        <select name="allowed_type" class="form-control mm" id="allowed_type">
                                            @foreach ($allowed_types as $type)
                                            <option value="{{ $type->sub_type }}" {{ $type->sub_type == $data->apply_sub_type ? 'selected' : '' }}>{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="remark" class="text-info">
                                            {{ __('lang.location_map_2') }}
                                        </label>
                                        <input type="file" name="location_map" accept=".jpg,.png,.pdf" class="form-control"/>
                                    </div>
                                    {{-- ဓာတ်အားပေးမည့် ထရန်စဖော်မာအမည် --}}
                                    <div class="form-group m-t-20">
                                        <label for="power_tranformer" class="text-info">
                                            {{ __('lang.power_tranformer') }}
                                        </label>
                                        <input type="text" name="power_tranformer" value="" id="power_tranformer" class="form-control" >
                                    </div>
                                    {{-- ကေဗွီအေ --}}
                                    <div class="form-group m-t-20">
                                        <label for="kva" class="text-info">
                                            {{ __('lang.kva') }}
                                        </label>
                                        <input type="text" name="kva" value="" id="kva" class="form-control" >
                                    </div>
                                    {{-- ဝန်အား --}}
                                    <div class="form-group m-t-20">
                                        <label for="the_load" class="text-info">
                                            {{ __('lang.the_load') }}
                                        </label>
                                        <input type="text" name="the_load" value="" id="the_load" class="form-control" >
                                    </div>
                                    <div class="form-group m-t-20">
                                        <label for="remark" class="text-info">
                                            {{ __('lang.remark') }} <span class="text-danger f-s-15">&#10039;</span>
                                        </label>
                                        {!! Form::textarea('remark', null, ['id' => 'remark', 'class' => 'form-control', 'rows' => '3','required']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" name="survey_submit" class="waves-effect waves-light btn btn-rounded btn-info ">{{ __('lang.submit') }}</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                            {{--  @endif  --}}
                        @endif
                    @else
                        @if (chk_userForm($data->id)['to_survey'])
                            @if (hasPermissions(['residentialGrdChk-create'])) {{--  if login-user is from township  --}}
                    <div class="card mb-1">
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('lang.choose_engineer') }}</h5>
                        </div>
                        <div class="card-body">
                            <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                            <br/>
                            {!! Form::open(['route' => 'residentialMeterGroundCheckChoose.store']) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="form-group p-20">
                                        <label for="engineer_id" class="text-info">
                                            {{ __('lang.eng_choose') }} <span class="text-danger f-s-15">&#10039;</span>
                                        </label>
                                        <select required name="engineer_id" id="engineer_name" class="form-control inner-form {{ checkMM() }}" required>
                                            <option value="">{{ __('lang.choose1') }}</option>
                                            @isset($engineerLists)
                                            @foreach ($engineerLists as $list) 
                                            @if($list->hasRole('အငယ်တန်းအင်ဂျင်နီယာ')) 
                                            <option value="{{ $list->id }}">{{ checkMM() == 'mm' ? $list->name : $list->name }}</option> 
                                            @endif 
                                            @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="text-center">
                                <input type="submit" name="survey_submit" value="{{ __('lang.choose') }}" class="btn btn-rounded btn-info">
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
