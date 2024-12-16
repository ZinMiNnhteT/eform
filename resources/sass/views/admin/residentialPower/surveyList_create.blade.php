@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0 ">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('residentialPowerMeterGroundCheckList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5 "><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>

            <div class="card-body">
                <h3 class="text-center ">{{ __('lang.residentSurvey') }} ({{ div_state($form->div_state_id) }}{{ checkMM() == 'mm' ? '၊' : ',' }} {{ district($form->district_id) }})</h3>

                {!! Form::open(['route' => 'residentialPowerMeterGroundCheckList.store', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                <div class="row justify-content-center">

                    <div class="col-md-8">
                        <div class="form-info bg-secondary p-20">
                            <table class="table no-border">
                                <tbody>
                                    <tr>
                                        <td><strong>{{ __('lang.serial') }}</strong></td>
                                        <td>{{$form->serial_code}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('lang.fullname') }}</strong></td>
                                        <td>{{$form->fullname}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('lang.applied_address') }}</strong></td>
                                        <td>{{address($form->id)}}</td>
                                    </tr>
                                </tbod>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center m-t-20">
                    <div class="col-md-8">
                
                        {{--  Distance  --}}
                        <div class="form-group">
                            <label for="" class="text-info">
                                {{ __('lang.survey_distance') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            {!! Form::number('distance', null, ['id' => 'distance', 'class' => 'form-control' , 'required']) !!}
                        </div>

                        {{--  Previous Meter  --}}
                        <div class="form-group">
                            <label class="text-info">
                                {{ __('lang.survey_prev_meter_no') }} ({{ __('lang.if_have') }})
                            </label>
                                {!! Form::text('prev_meter_no', null, ['id' => 'prev_meter_no', 'class' => 'form-control inner-form']) !!}
                        </div>

                        {{--  Survey Transformer Info  --}}
                        <div class="form-group">
                            <label for="t_info" class="text-info">
                                {{ __('lang.survey_t_info') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                                <textarea name="t_info" id="t_info" rows="2" class="form-control inner-form" required></textarea>
                        </div>

                        {{--  Max Load  --}}
                        <div class="form-group">
                            <label for="max_load" class="text-info">
                                {{ __('lang.survey_max_load') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                                <textarea name="max_load" id="max_load" rows="2" class="form-control inner-form" required></textarea>
                        </div>

                        {{--  Others Survey  --}}
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="bg-secondary p-10">
                                    <label for="" class="text-info">
                                        {{ __('lang.living_cdt') }} <span class="text-danger f-s-15">&#10039;</span>
                                    </label>
                                    <div class="row m-t-20">
                                    
                                        <div class="custom-control custom-radio col align-items-center text-center" required>
                                            <input type="radio" name="living" value="on" class="custom-control-input" id="living_chkbox1">
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
                                        {{ __('lang.rpower_loaded_cdt') }} <span class="text-danger f-s-15">&#10039;</span>
                                    </label>
                                    <div class="row m-t-20">
                                        <div class="custom-control custom-radio col text-center">
                                            <input type="radio" name="transmit" value="on" class="custom-control-input" id="loaded_rad1" required>
                                            <label for="loaded_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                        </div>
                                        <div class="custom-control custom-radio col text-center">
                                            <input type="radio" name="transmit" value="off" class="custom-control-input" id="loaded_rad2" required>
                                            <label for="loaded_rad2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group m-t-20">
                            <label class="text-info ">
                                {{ __('lang.attach_files') }}
                            </label>
                                {!! Form::file('front[]',['accept' => '.jpg,.png,.pdf', 'multiple']) !!}
                                <p class="px-1 py-1 text-danger text-capitalize mm">ပုံများကို တပြိုင်နက်ထဲ ရွေးချယ်တင်နိုင်ပါသည်။</p>
                        </div>

                        <div class="form-group m-t-20">
                            <label for="remark" class="text-info">
                                {{ __('lang.remark') }}
                            </label>
                            {!! Form::textarea('remark', null, ['id' => 'remark', 'class' => 'form-control', 'rows' => '3']) !!}
                        </div>
                        

                    
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('residentialPowerMeterGroundCheckList.index') }}" class="btn btn-rounded btn-secondary ">{{ __('lang.cancel') }}</a>
                    <input type="submit" name="survey_submit" value="{{ __('lang.submit') }}" class="btn btn-rounded btn-info ">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection