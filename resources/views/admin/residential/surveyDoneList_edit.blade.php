@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('residentialMeterGroundCheckDoneList.show', $data->id) }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body card-body-pb-div">
                <div class="container-fluid">
                    {!! Form::open(['route' => ['residentialMeterGroundCheckDoneListEdit.update'], 'method' => 'PATCH', 'files' => true]) !!}
                    {!! Form::hidden('form_id', $data->id) !!}
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            {{--  Type  --}}
                            <div class="form-group">
                                <label for="" class="text-info">
                                    {{ __('lang.meter_connect_type') }}
                                </label>
                                <select name="applied_type" class="form-control mm" id="type" readonly>
                                    {{--  <option value="">ရွေးချယ်ရန်</option>  --}}
                                    <option value="1" {{ $survey_result->applied_type == 1 ? 'selected' : 'disabled' }}>အသစ်</option>
                                    <option value="2" {{ $survey_result->applied_type == 2 ? 'selected' : 'disabled' }}>တိုးချဲ့</option>
                                    <option value="3" {{ $survey_result->applied_type == 3 ? 'selected' : 'disabled' }}>အမည်ပြောင်း</option>
                                    <option value="4" {{ $survey_result->applied_type == 4 ? 'selected' : 'disabled' }}>ပြန်ဆက်</option>
                                    <option value="5" {{ $survey_result->applied_type == 5 ? 'selected' : 'disabled' }}>မီတာခွဲ</option>
                                    <option value="6" {{ $survey_result->applied_type == 6 ? 'selected' : 'disabled' }}>ယာယီ</option>
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
                                <input type="text" name="volt" value="{{ $survey_result->volt }}" id="volt" class="form-control" >
                            </div>
                            {{--  Kilowatt  --}}
                            <div class="form-group">
                                <label for="kilowatt" class="text-info">
                                    {{ __('lang.kilowatt') }}
                                </label>
                                <input type="text" name="kilowatt" value="{{ $survey_result->kilowatt }}" id="kilowatt" class="form-control" >
                            </div>
                            {{--  Distance  --}}
                            <div class="form-group">
                                <label for="" class="text-info">
                                    {{ __('lang.survey_distance') }}
                                </label>
                                <input type="text" name="distance" value="{{ $survey_result->distance }}" id="distance" class="form-control" >
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
                                                <input type="radio" name="living" value="on" class="custom-control-input" id="living_chkbox1" {{ $survey_result->living ? 'checked' : '' }} >
                                                <label for="living_chkbox1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                            </div>

                                            <div class="custom-control custom-radio col text-center">
                                                <input type="radio" name="living" value="off" class="custom-control-input" id="living_chkbox2" {{ $survey_result->living ? : 'checked' }} >
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
                                                <input type="radio" name="meter" value="on" class="custom-control-input" id="living_rad1" {{ $survey_result->meter ? 'checked' : '' }} >
                                                <label for="living_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                            </div>
                                            <div class="custom-control custom-radio col text-center">
                                                <input type="radio" name="meter" value="off" class="custom-control-input" id="living_rad2" {{ $survey_result->meter ? : 'checked' }} >
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
                                                <input type="radio" name="invade" value="on" class="custom-control-input" id="invade_rad1" {{ $survey_result->invade ? 'checked' : '' }} >
                                                <label for="invade_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                            </div>
                                            <div class="custom-control custom-radio col text-center">
                                                <input type="radio" name="invade" value="off" class="custom-control-input" id="invade_rad2" {{ $survey_result->invade ? : 'checked' }} >
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
                                                <input type="radio" name="loaded" value="on" class="custom-control-input" id="loaded_rad1" {{ $survey_result->loaded ? 'checked' : '' }} >
                                                <label for="loaded_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                            </div>
                                            <div class="custom-control custom-radio col text-center">
                                                <input type="radio" name="loaded" value="off" class="custom-control-input" id="loaded_rad2" {{ $survey_result->loaded ? : 'checked' }} >
                                                <label for="loaded_rad2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-t-20">
                                <label for="" class="text-info">
                                    {{ __('lang.applied_electricpower') }}
                                </label>
                                <input type="text" name="comsumed_power_amt" value="{{ $survey_result->comsumed_power_amt }}" id="comsumed_power_amt" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="front" class="text-info">
                                    {{ __('lang.applied_electricpower_photo') }}
                                </label>
                                <input type="file" name="front" id="front" class="form-control" accept=".jpg,.jpeg,.png" >
                            </div>
                            <div class="form-group m-t-20">
                                <label for="remark" class="text-info">
                                    {{ __('lang.remark') }}
                                </label>
                                {!! Form::textarea('remark', $survey_result->remark, ['id' => 'remark', 'class' => 'form-control', 'rows' => '3']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" name="survey_submit" value="{{ __('lang.submit') }}" class="btn btn-rounded btn-info ">
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection