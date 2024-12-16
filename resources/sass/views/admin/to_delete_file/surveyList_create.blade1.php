@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0 ">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('residentialMeterGroundCheckList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5 "><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>

            <div class="card-body">
                <h3 class="text-center ">{{ __('lang.residentSurvey') }} ({{ div_state($form->div_state_id) }}{{ checkMM() == 'mm' ? '၊' : ',' }} {{ district($form->district_id) }})</h3>

                {!! Form::open(['route' => 'residentialMeterGroundCheckList.store']) !!}
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
                        {{--  Type  --}}
                        <div class="form-group">
                            <label for="" class="text-info">
                                {{ __('lang.meter_connect_type') }}
                            </label>
                            <select name="applied_type" class="form-control mm" id="type" readonly>
                                {{--  <option value="">ရွေးချယ်ရန်</option>  --}}
                                <option value="1" selected>အသစ်</option>
                                <option value="2" disabled>တိုးချဲ့</option>
                                <option value="3" disabled>အမည်ပြောင်း</option>
                                <option value="4" disabled>ပြန်ဆက်</option>
                                <option value="5" disabled>မီတာခွဲ</option>
                                <option value="6" disabled>ယာယီ</option>
                            </select>
                        </div>
                        {{--  line Type  --}}
                        <div class="form-group">
                            <label for="" class="text-info">
                                {{ __('lang.phase_type') }}
                            </label>
                            <input type="text" name="phase_type" class="form-control mm" value="၁ သွင် ၂ ကြိုး (single phase)" readonly />
                        </div>
                        {{--  Voltage  --}}
                        <div class="form-group">
                            <label for="volt" class="text-info">
                                {{ __('lang.volt') }}
                            </label>
                            <input type="number" name="volt" id="volt" class="form-control" placeholder="{{ __('lang.by_english') }}" required>
                        </div>
                        {{--  Kilowatt  --}}
                        <div class="form-group">
                            <label for="kilowatt" class="text-info">
                                {{ __('lang.kilowatt') }}
                            </label>
                            <input type="number" name="kilowatt" id="kilowatt" class="form-control" placeholder="{{ __('lang.by_english') }}" required>
                        </div>
                        {{--  Distance  --}}
                        <div class="form-group">
                            <label for="" class="text-info">
                                {{ __('lang.survey_distance') }}
                            </label>
                            <input type="number" name="distance" id="distance" class="form-control" placeholder="{{ __('lang.by_english') }}" required>
                        </div>

                        {{--  Others Survey  --}}
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="bg-secondary p-10">
                                    <label for="" class="text-info">
                                        {{ __('lang.living_cdt') }}
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
                                        {{ __('lang.residential') }} {{ __('lang.rdy_applied_cdt') }}
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
                                        {{ __('lang.invade_cdt') }}
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
                                        {{ __('lang.loaded_cdt') }}
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
                            <label for="remark" class="text-info">
                                {{ __('lang.remark') }}
                            </label>
                            {!! Form::textarea('remark', null, ['id' => 'remark', 'class' => 'form-control', 'rows' => '3']) !!}
                        </div>
                        

                    
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('residentialMeterGroundCheckList.index') }}" class="btn btn-rounded btn-secondary ">{{ __('lang.cancel') }}</a>
                    <input type="submit" name="survey_submit" value="{{ __('lang.submit') }}" class="btn btn-rounded btn-info ">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection