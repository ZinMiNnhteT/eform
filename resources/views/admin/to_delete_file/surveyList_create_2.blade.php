@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0 {{ lang() }}">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('residentialMeterGroundCheckList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5 {{ lang() }}"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>

            <div class="card-body">
                <h3 class="text-center {{ lang() }}">{{ __('lang.residentSurvey') }} ({{ div_state($form->district_id) }}{{ checkMM() == 'mm' ? '၊' : ',' }} {{ district($form->district_id) }})</h3>

                {!! Form::open(['route' => 'residentialMeterGroundCheckList.store']) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                <div class="row justify-content-center">
                    <div class="col-md-9">

                        <div class="form-group row">
                            <label for="serial" class="control-label l-h-35 text-md-right col-md-3 {{ lang() }}">
                                {{ __('lang.serial') }}
                            </label>
                            <div class="col-md-6">
                                {!! Form::text('serial', $form->serial_code, ['id' => 'serial', 'class' => 'form-control inner-form', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fullname" class="control-label l-h-35 text-md-right col-md-3 {{ lang() }}">
                                {{ __('lang.fullname') }}
                            </label>
                            <div class="col-md-6">
                                {!! Form::text('fullname', $form->fullname, ['id' => 'fullname', 'class' => 'form-control inner-form', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="applied_address" class="control-label l-h-35 text-md-right col-md-3 {{ lang() }}">
                                {{ __('lang.applied_address') }}
                            </label>
                            <div class="col-md-6">
                                <textarea name="applied_address" class="form-control inner-form {{ lang() }}" id="applied_address" rows="3" readonly>{{ address($form->id) }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="distance" class="control-label l-h-35 text-md-right col-md-3 {{ lang() }}">
                                {{ __('lang.survey_distance') }}
                            </label>
                            <div class="col-md-6">
                                {!! Form::text('distance', null, ['id' => 'distance', 'class' => 'form-control inner-form']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label text-md-right col-md-3 {{ lang() }}">
                                {{ __('lang.living_cdt') }}
                            </label>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="living" value="on" class="custom-control-input" id="living_chkbox1">
                                            <label for="living_chkbox1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="living" value="off" class="custom-control-input" id="living_chkbox2">
                                            <label for="living_chkbox2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label text-md-right col-md-3 {{ lang() }}">
                                {{ __('lang.residential') }} {{ __('lang.rdy_applied_cdt') }}
                            </label>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="meter" value="on" class="custom-control-input" id="living_rad1">
                                            <label for="living_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="meter" value="off" class="custom-control-input" id="living_rad2">
                                            <label for="living_rad2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label text-md-right col-md-3 {{ lang() }}">
                                {{ __('lang.invade_cdt') }}
                            </label>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="invade" value="on" class="custom-control-input" id="invade_rad1">
                                            <label for="invade_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="invade" value="off" class="custom-control-input" id="invade_rad2">
                                            <label for="invade_rad2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label text-md-right col-md-3 {{ lang() }}">
                                {{ __('lang.loaded_cdt') }}
                            </label>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="loaded" value="on" class="custom-control-input" id="loaded_rad1">
                                            <label for="loaded_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="loaded" value="off" class="custom-control-input" id="loaded_rad2">
                                            <label for="loaded_rad2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="remark" class="control-label l-h-35 text-md-right col-md-3 {{ lang() }}">
                                {{ __('lang.remark') }}
                            </label>
                            <div class="col-md-6">
                                {!! Form::textarea('remark', null, ['id' => 'remark', 'class' => 'form-control inner-form', 'rows' => '3']) !!}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="text-center">
                    <a href="{{ url('residentialMeterGroundCheckList') }}" class="btn btn-rounded btn-secondary {{ lang() }}">@lang('lang.cancel')</a>
                    <input type="submit" name="survey_submit" value="@lang('lang.submit')" class="btn btn-rounded btn-info {{ lang() }}">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection