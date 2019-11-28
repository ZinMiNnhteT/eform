@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('residentialPowerMeterGroundCheckList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>

            <div class="card-body">
                <h3 class="text-center">{{ __('lang.residentSurvey') }} ({{ div_state($form->div_state_id) }}{{ checkMM() == 'mm' ? '၊' : ',' }} {{ district($form->district_id) }})</h3>

                {!! Form::open(['route' => 'residentialPowerMeterGroundCheckList.store']) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                <div class="row justify-content-center mt-5">
                    <div class="col-md-9">

                        <div class="form-group row">
                            <label for="serial" class="control-label l-h-35 text-md-right col-md-3">
                                {{ __('lang.serial') }}
                            </label>
                            <div class="col-md-6">
                                {!! Form::text('serial', $form->serial_code, ['id' => 'serial', 'class' => 'form-control inner-form', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fullname" class="control-label l-h-35 text-md-right col-md-3">
                                {{ __('lang.fullname') }}
                            </label>
                            <div class="col-md-6">
                                <input type="text" name="fullname" value="{{ $form->fullname }}" id="fullname" class="form-control inner-form"  readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="applied_address" class="control-label l-h-35 text-md-right col-md-3">
                                {{ __('lang.applied_address') }}
                            </label>
                            <div class="col-md-6">
                                <textarea name="applied_address" class="form-control inner-form" id="applied_address" rows="3" readonly>{{ address($form->id) }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="distance" class="control-label l-h-35 text-md-right col-md-3">
                                {{ __('lang.survey_distance') }}
                            </label>
                            <div class="col-md-6">
                                {!! Form::text('distance', null, ['id' => 'distance', 'class' => 'form-control inner-form']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="prev_meter_no" class="control-label l-h-35 text-md-right col-md-3">
                                {{ __('lang.survey_prev_meter_no') }}
                            </label>
                            <div class="col-md-6">
                                {!! Form::text('prev_meter_no', null, ['id' => 'prev_meter_no', 'class' => 'form-control inner-form']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="t_info" class="control-label l-h-35 text-md-right col-md-3">
                                {{ __('lang.survey_t_info') }}
                            </label>
                            <div class="col-md-6">
                                <textarea name="t_info" id="t_info" rows="2" class="form-control inner-form"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="max_load" class="control-label l-h-35 text-md-right col-md-3">
                                {{ __('lang.survey_max_load') }}
                            </label>
                            <div class="col-md-6">
                                <textarea name="max_load" id="max_load" rows="2" class="form-control inner-form"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label text-md-right col-md-3">
                                {{ __('lang.rpower_loaded_cdt') }}
                            </label>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="transmit" class="custom-control-input" id="loaded_rad1">
                                            <label for="loaded_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="transmit" value="off" class="custom-control-input" id="loaded_rad2">
                                            <label for="loaded_rad2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label text-md-right col-md-3 ">
                                {{ __('lang.attach_files') }}
                            </label>
                            <div class="col-md-6">
                                {!! Form::file('front[]',['accept' => '.jpg,.png,.pdf', 'multiple']) !!}
                                <p class="px-1 py-1 text-danger text-capitalize mm">ပုံများကို တပြိုင်နက်ထဲ ရွေးချယ်တင်နိုင်ပါသည်။</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="remark" class="control-label l-h-35 text-md-right col-md-3">
                                {{ __('lang.remark') }}
                            </label>
                            <div class="col-md-6">
                                {!! Form::textarea('remark', null, ['id' => 'remark', 'class' => 'form-control inner-form', 'rows' => '3']) !!}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="text-center">
                    <a href="{{ url('residentialPowerMeterGroundCheckList') }}" class="btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                    <button type="submit" name="survey_submit" class="btn btn-rounded btn-info">{{ __('lang.submit') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection