@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="card-title text-center text-white m-0">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5><br/>
                {!! Form::model($form, ['route' => ['commercial_update_user_info_ygn'], 'method' => 'PATCH', 'class' => 'form-horizontal mm']) !!}
                {!! Form::hidden('form_id', $form_id) !!}
                <div class="row justify-content-center">
                     <div class="col-md-8">
                        {{--  Fullname  --}}
                        <div class="form-group">
                            <label for="fullname" class="text-info">
                                {{ __('lang.fullname') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            {!! Form::text('fullname', null, ['id' => 'fullname', 'class' => 'form-control inner-form', 'required']) !!}
                        </div>
                        {{--  NRC  --}}
                        <div class="form-group">
                            <label for="nrc" class="text-info">
                                {{ __('lang.nrc') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            {!! Form::text('nrc', null, ['id' => 'nrc', 'class' => 'form-control inner-form', 'required']) !!}
                            <small class="text-danger"> {{ __('lang.nrc_help') }}</small>
                        </div>
                        {{--  Mobile Phone  --}}
                        <div class="form-group">
                            <label for="applied_phone" class="text-info">
                                {{ __('lang.contact_phone') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            {!! Form::text('applied_phone', null, ['id' => 'phone', 'class' => 'form-control inner-form', 'required']) !!}
                            <small class="text-danger"> {{ __('lang.phone_help') }}</small>
                        </div>
                        {{--  Work  --}}
                        <div class="form-group">
                            <label for="jobType" class="text-info">
                                {{ __('lang.job_type') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            <select name="jobType" class="form-control" id="jobType" required>
                                <option value="">{{ __('lang.choose1') }}</option>
                                <option value="gstaff" {{ 'gstaff' == $form->job_type ? 'selected' : '' }}>{{ __('lang.civil_servant') }}</option>
                                <option value="staff" {{ 'staff' == $form->job_type ? 'selected' : '' }}>{{ __('lang.staff') }}</option>
                                <option value="other" {{ 'other' == $form->job_type ? 'selected' : '' }}>{{ __('lang.other') }}</option>
                            </select>
                        </div>
                        {{--  Wrapper div for govStaff  --}}
                        <div class="gStaff-wrapper {{ $form->job_type == 'gstaff' || $form->job_type == 'staff' ? : 'd-none' }}" id="gStaff-wrap">
                            <div class="form-group m-t-20">
                                <div class="row input-required">
                                    <div class="col-md-6">
                                        {{--  Position  --}}
                                        <label for="pos" class="text-info">{{ __('lang.position') }} <span class="text-danger f-s-15">&#10039;</span></label> 
                                        <input type="text" name="pos" value="{{ $form->job_type == 'gstaff' || $form->job_type == 'staff' ? $form->position : ''}}" class="form-control" {{ $form->job_type != 'other' ? 'required' : '' }}/>
                                    </div>
                                    <div class="col-md-6">
                                        {{--  Department  --}}
                                        <label for="dep" class="text-info">{{ __('lang.mini_comp') }} <span class="text-danger f-s-15">&#10039;</span></label>
                                        <input type="text" name="dep" value="{{ $form->job_type == 'gstaff' || $form->job_type == 'staff' ? $form->department : '' }}" class="form-control" {{ $form->job_type != 'other' ? 'required' : '' }}/>

                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group m-t-20">
                                    <label for="salary" class="text-info">{{ __('lang.avg_salary') }}</label>
                                    <input type="number" name="salary" value="{{ $form->job_type == 'gstaff' || $form->job_type == 'staff' ? ($form->salary > 0 ? $form->salary : '') : '' }}" id="salary" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="otherWrapper {{ $form->job_type == 'other' ? : 'd-none' }}" id="otherWrap">
                            <div class="form-group input-required">
                                <label for="other" class="text-info">{{ __('lang.other') }} <span class="text-danger f-s-15">&#10039;</span></label>
                                <input type="text" name="other" value="{{ $form->job_type == 'other' ? $form->position : '' }}" class="form-control" {{ $form->job_type == 'other' ? 'required' : '' }}/>
                            </div>
                            <div class="form-group">
                                <label for="otherSalary" class="text-info">{{ __('lang.avg_salary') }}
                                <input type="number" name="otherSalary" value="{{ $form->job_type == 'other' ? ($form->salary > 0 ? $form->salary : '') : '' }}" id="otherSalary" class="form-control" />
                            </div>
                        </div>
                        {{--  Building Type  --}}
                        <div class="form-group">
                            <label for="applied_building_type" class="text-info">
                                {{ __('lang.building_type') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            {!! Form::textarea('applied_building_type', null, ['id' => 'applied_building_type', 'class' => 'form-control inner-form','style' =>'height:130px', 'required']) !!}
                        </div>
                        {{--  Home / Building No  --}}
                        <div class="form-group">
                            <label for="applied_home_no" class="text-info">
                                {{ __('lang.home_no') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            {!! Form::text('applied_home_no', null, ['id' => 'applied_home_no', 'class' => 'form-control inner-form','required']) !!}
                        </div>
                        {{--  Room No  --}}
                        <div class="form-group">
                            <label for="applied_building" class="text-info">
                                {{ __('lang.building') }} <span class="text-danger"></span>
                            </label>
                            {!! Form::text('applied_building', null, ['id' => 'applied_building', 'class' => 'form-control inner-form']) !!}
                        </div>
                        {{--  Street Address  --}}
                        <div class="form-group">
                            <label for="applied_street" class="text-info">
                                {{ __('lang.street') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            {!! Form::text('applied_street', null, ['id' => 'applied_street', 'class' => 'form-control inner-form','required']) !!}
                        </div>
                        {{--  Lane  --}}
                        <div class="form-group">
                            <label for="applied_lane" class="text-info">
                                {{ __('lang.lane') }} 
                            </label>
                            {!! Form::text('applied_lane', null, ['id' => 'applied_lane', 'class' => 'form-control inner-form']) !!}
                        </div>
                        {{--  Quarter  --}}
                        <div class="form-group">
                            <label for="applied_quarter" class="text-info">
                                {{ __('lang.quarter') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            {!! Form::text('applied_quarter', null, ['id' => 'applied_quarter', 'class' => 'form-control inner-form', 'required']) !!}
                        </div>
                        {{--  Town  --}}
                        <div class="form-group">
                            <label for="applied_town" class="text-info">
                                {{ __('lang.town') }}
                            </label>
                            {!! Form::text('applied_town', null, ['id' => 'applied_town', 'class' => 'form-control inner-form']) !!}
                        </div>
                        {{--  Township  --}}
                        <div class="form-group">
                            <label for="township_id" class="text-info">
                                {{ __('lang.township') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            <select name="township_id" class="form-control inner-form {{ checkMM() }}" id="township" required>
                                <option value="">{{ __('lang.choose1') }}</option>
                                @foreach ($townships as $township)
                                <option value="{{ $township->id }}" {{ $township->id == $form->township_id ? 'selected' : '' }}>{{ checkMM() == 'mm' ? $township->name : $township->eng }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{--  District  --}}
                        <div class="form-group">
                            <label for="district" class="text-info">
                                {{ __('lang.district') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            {!! Form::text('district', district($form->district_id), ['id' => 'district', 'class' => 'form-control inner-form', 'required', 'readonly','required']) !!}
                            {!! Form::hidden('district_id', $form->district_id, ['id' => 'district_id']) !!}
                        </div>
                        {{--  Region  --}}
                        <div class="form-group">
                            <label for="region" class="text-info">
                                {{ __('lang.div_state') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            {!! Form::text('region', div_state($form->div_state_id), ['id' => 'region', 'class' => 'form-control inner-form', 'required', 'readonly','required']) !!}
                            {!! Form::hidden('div_state_id', $form->div_state_id, ['id' => 'region_id']) !!}
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            <div class="col-md-3">
                                <a href="{{ route('commercial_applied_form_ygn', $form->id) }}" class="waves-effect waves-light btn btn-block btn-rounded btn-secondary ">{{ __('lang.cancel') }}</a>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="waves-effect waves-light btn btn-block btn-rounded btn-primary ">{{ __('lang.submit') }}</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>
@endsection
