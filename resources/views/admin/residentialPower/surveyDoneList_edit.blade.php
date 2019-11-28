@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('residentialPowerMeterGroundCheckDoneList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body card-body-pb-div">
                {!! Form::open(['route' => 'residentialPowerMeterGroundCheckDoneList.update', 'method' => 'PATCH', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                <div class="row justify-content-center mt-3">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="" class="text-info">
                                {{ __('lang.survey_distance') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            {!! Form::text('distance', $survey_result->distance, ['id' => 'distance', 'class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <label class="text-info">
                                {{ __('lang.survey_prev_meter_no') }} ({{ __('lang.if_have') }})
                            </label>
                                {!! Form::text('prev_meter_no', $survey_result->prev_meter_no, ['id' => 'prev_meter_no', 'class' => 'form-control inner-form']) !!}
                        </div>
                        <div class="form-group">
                            <label for="t_info" class="text-info">
                                {{ __('lang.survey_t_info') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                                <textarea name="t_info" id="t_info" rows="2" class="form-control inner-form">{{ $survey_result->t_info }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="max_load" class="text-info">
                                {{ __('lang.survey_max_load') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                                <textarea name="max_load" id="max_load" rows="2" class="form-control inner-form">{{ $survey_result->max_load }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="bg-secondary p-10">
                                    <label for="">
                                        {{ __('lang.living_cdt') }} <span class="text-danger f-s-15">&#10039;</span>
                                    </label>
                                    <div class="row mt-3">
                                    
                                        <div class="custom-control custom-radio col align-items-center text-center">
                                            <input type="radio" name="living" value="on" class="custom-control-input" id="living_chkbox1" {{ $survey_result->living ? 'checked' : '' }}>
                                            <label for="living_chkbox1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                        </div>

                                        <div class="custom-control custom-radio col text-center">
                                            <input type="radio" name="living" value="off" class="custom-control-input" id="living_chkbox2" {{ !$survey_result->living ? 'checked' : '' }}>
                                            <label for="living_chkbox2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-secondary p-10">
                                    <label for="">
                                        {{ __('lang.residential') }} {{ __('lang.rdy_applied_cdt') }} <span class="text-danger f-s-15">&#10039;</span>
                                    </label>
                                    <div class="row mt-3">
                                        <div class="custom-control custom-radio col text-center">
                                            <input type="radio" name="meter" value="on" class="custom-control-input" id="living_rad1" {{ $survey_result->meter ? 'checked' : '' }}>
                                            <label for="living_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                        </div>
                                        <div class="custom-control custom-radio col text-center">
                                            <input type="radio" name="meter" value="off" class="custom-control-input" id="living_rad2" {{ !$survey_result->meter ? 'checked' : '' }}>
                                            <label for="living_rad2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="bg-secondary p-10">
                                    <label for="">
                                        {{ __('lang.invade_cdt') }} <span class="text-danger f-s-15">&#10039;</span>
                                    </label>
                                    <div class="row mt-3">
                                    
                                        <div class="custom-control custom-radio col text-center">
                                            <input type="radio" name="invade" value="on" class="custom-control-input" id="invade_rad1" {{ $survey_result->invade ? 'checked' : '' }}>
                                            <label for="invade_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                        </div>
                                        <div class="custom-control custom-radio col text-center">
                                            <input type="radio" name="invade" value="off" class="custom-control-input" id="invade_rad2" {{ !$survey_result->invade ? 'checked' : '' }}>
                                            <label for="invade_rad2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-secondary p-10">
                                    <label for="">
                                        {{ __('lang.rpower_loaded_cdt') }} <span class="text-danger f-s-15">&#10039;</span>
                                    </label>
                                    <div class="row mt-3">
                                        <div class="custom-control custom-radio col text-center">
                                            <input type="radio" name="transmit" value="on" class="custom-control-input" id="loaded_rad1" {{ $survey_result->transmit ? 'checked' : '' }}>
                                            <label for="loaded_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                        </div>
                                        <div class="custom-control custom-radio col text-center">
                                            <input type="radio" name="transmit" value="off" class="custom-control-input" id="loaded_rad2" {{ !$survey_result->transmit ? 'checked' : '' }}>
                                            <label for="loaded_rad2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <label for="" class="text-info">
                                {{ __('lang.applied_electricpower') }}
                            </label>
                            <input type="text" name="comsumed_power_amt" value="{{ $survey_result->comsumed_power_amt }}" id="comsumed_power_amt" class="form-control">
                        </div>
                        <div class="form-group mt-4">
                            <label for="" class="text-info">
                                {{ __('lang.applied_electricpower_photo') }}
                            </label>
                                {!! Form::file('front[]',['class' => 'form-control', 'accept' => '.jpg,.png,.pdf', 'multiple']) !!}
                                <p class="px-1 py-1 text-danger text-capitalize mm">ပုံများကို တပြိုင်နက်ထဲ ရွေးချယ်တင်နိုင်ပါသည်။</p>
                        </div>
                        <div class="form-group mt-4">
                            <label for="allow_p_meter" class="text-info">
                                {{ __('lang.re_choose_p_meter') }}
                            </label>
                            <select name="allow_p_meter" id="allow_p_meter" class="form-control">
                                <option value="">{{ __('lang.choose1') }}</option>
                                @foreach ($pm_list as $pm)
                                <option value="{{ $pm->sub_type }}" {{ $pm->sub_type == $survey_result->allow_p_meter ? 'selected' : '' }}>{{ __('lang.'.$pm->slug) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-4">
                            <label for="remark" class="text-info">
                                {{ __('lang.remark') }}
                            </label>
                            {!! Form::textarea('remark', $survey_result->remark, ['id' => 'remark', 'class' => 'form-control', 'rows' => '3']) !!}
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" name="survey_submit" class="waves-effect waves-light btn btn-rounded btn-info ">{{ __('lang.submit') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection