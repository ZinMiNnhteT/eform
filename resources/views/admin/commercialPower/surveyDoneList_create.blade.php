@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0 ">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('commercialPowerMeterGroundCheckDoneList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5 "><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>

            <div class="card-body">
                <h3 class="text-center ">{{ __('lang.residentSurvey') }} ({{ div_state($form->div_state_id) }}{{ checkMM() == 'mm' ? '၊' : ',' }} {{ district($form->district_id) }})</h3>

                {!! Form::open(['route' => 'commercialPowerMeterGroundCheckDoneList.store']) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                <div class="row justify-content-center">
                    <div class="col-md-9">

                        <div class="form-group row mb-2">
                            <label for="serial" class="control-label text-md-right col-md-4 ">
                                {{ __('lang.serial') }}
                            </label>
                            <div class="col-md-6">
                                <p class="">{{ $form->serial_code }}</p>
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <label for="fullname" class="control-label text-md-right col-md-4 ">
                                {{ __('lang.fullname') }}
                            </label>
                            <div class="col-md-6">
                                <p class="">{{ $form->fullname }}</p>
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <label for="applied_address" class="control-label text-md-right col-md-4 ">
                                {{ __('lang.applied_address') }}
                            </label>
                            <div class="col-md-6">
                                <p class="">{{ address($form->id) }}</p>
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <label for="distance" class="control-label text-md-right col-md-4 ">
                                {{ __('lang.survey_distance') }}
                            </label>
                            <div class="col-md-6">
                                <p class="">{{ checkMM() == 'mm' ? mmNum($survey_result->distance) : $survey_result->distance }}</p>
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <label class="control-label text-md-right col-md-4 ">
                                {{ __('lang.survey_prev_meter_no') }}
                            </label>
                            <div class="col-md-6">
                                <p class="">{{ $survey_result->prev_meter_no }}</p>
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <label class="control-label text-md-right col-md-4 ">
                                {{ __('lang.survey_t_info') }}
                            </label>
                            <div class="col-md-6">
                                <p class="">{{ $survey_result->t_info }}</p>
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <label class="control-label text-md-right col-md-4 ">
                                {{ __('lang.survey_max_load') }}
                            </label>
                            <div class="col-md-6">
                                <p class="">{{ $survey_result->max_load }}</p>
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <label class="control-label text-md-right col-md-4 ">
                                {{ __('lang.living_cdt') }}
                            </label>
                            <div class="col-md-6">
                                @if ($survey_result->living)
                                    <p class="">{{ __('lang.radio_yes') }}</p>
                                @elseif (!$survey_result->living)
                                    <p class="">{{ __('lang.radio_no') }}</p>
                                @else
                                    <p class="">{{ err_msg() }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <label class="control-label text-md-right col-md-4 ">
                                {{ __('lang.residential') }} {{ __('lang.rdy_applied_cdt') }}
                            </label>
                            <div class="col-md-6">
                                @if ($survey_result->meter)
                                    <p class="">{{ __('lang.radio_yes') }}</p>
                                @elseif (!$survey_result->meter)
                                    <p class="">{{ __('lang.radio_no') }}</p>
                                @else
                                    <p class="">{{ err_msg() }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <label class="control-label text-md-right col-md-4 ">
                                {{ __('lang.invade_cdt') }}
                            </label>
                            <div class="col-md-6">
                                @if ($survey_result->invade)
                                    <p class="">{{ __('lang.radio_yes') }}</p>
                                @elseif (!$survey_result->invade)
                                    <p class="">{{ __('lang.radio_no') }}</p>
                                @else
                                    <p class="">{{ err_msg() }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <label class="control-label text-md-right col-md-4 ">
                                {{ __('lang.rpower_loaded_cdt') }}
                            </label>
                            <div class="col-md-6">
                                @if ($survey_result->transmit)
                                    <p class="">{{ __('lang.radio_yes') }}</p>
                                @elseif (!$survey_result->transmit)
                                    <p class="">{{ __('lang.radio_no') }}</p>
                                @else
                                    <p class="">{{ err_msg() }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <label for="remark" class="control-label text-md-right col-md-4 ">
                                {{ __('lang.remark') }}
                            </label>
                            <div class="col-md-6">
                                <p class="">{{ $survey_result->remark }}</p>
                            </div>
                        </div>

                        <div class="form-group row mb-2 mt-5">
                            <label class="control-label text-md-right col-md-4 ">
                                <strong>{{ __('lang.chk_person') }}</strong>
                            </label>
                        </div>

                        <div class="form-group row mb-1">
                            <label for="remark" class="control-label text-md-right col-md-4 ">
                                {{ __('lang.account') }}
                            </label>
                            <div class="col-md-6">
                                <p class="">{{ who($survey_result->survey_engineer) }}</p>
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label for="remark" class="control-label text-md-right col-md-4 ">
                                {{ __('lang.name') }}
                            </label>
                            <div class="col-md-6">
                                <p class="">{{ 'ဦးအေး' }}</p>
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label for="remark" class="control-label text-md-right col-md-4 ">
                                {{--  {{ __('lang.name') }}  --}}
                                {{ 'ရာထူး' }}
                            </label>
                            <div class="col-md-6">
                                <p class="">{{ 'ဝန်ထမ်း' }}</p>
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label for="remark" class="control-label text-md-right col-md-4 ">
                                {{ __('lang.phone') }}
                            </label>
                            <div class="col-md-6">
                                <p class="">{{ '၀၉၂၃၄၂၃၄၂၃၄' }}</p>
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label for="remark" class="control-label text-md-right col-md-4 ">
                                {{--  {{ __('lang.name') }}  --}}
                                {{ 'တည်နေရာ' }}
                            </label>
                            <div class="col-md-6">
                                <p class="">{{ '11.2 22.1' }}</p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="text-center">
                    <a href="{{ url('commercialPowerMeterGroundCheckDoneList') }}" class="btn btn-rounded btn-secondary ">{{ __('lang.cancel') }}</a>
                    <input type="submit" name="survey_submit" value="{{ __('lang.survey_confirm_send_dist') }}" class="btn btn-rounded btn-info ">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection