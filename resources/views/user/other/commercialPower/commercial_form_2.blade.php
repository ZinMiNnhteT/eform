@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="card-title text-center text-white">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                <br/>
                @php
                    if (isset($draft_data) && $draft_data->count() > 0) {
                        $fullname = $draft_data->fullname;
                        $nrc = $draft_data->nrc;
                        $applied_phone = $draft_data->applied_phone;
                        $job_type = $draft_data->job_type;
                        $position = $draft_data->position;
                        $department = $draft_data->department;
                        $salary = $draft_data->salary;
                        $applied_building_type = $draft_data->applied_building_type;
                        $applied_home_no = $draft_data->applied_home_no;
                        $applied_building = $draft_data->applied_building;
                        $applied_lane = $draft_data->applied_lane;
                        $applied_street = $draft_data->applied_street;
                        $applied_quarter = $draft_data->applied_quarter;
                        $applied_town = $draft_data->applied_town;
                        $township_id = $draft_data->township_id;
                        $district_id = $draft_data->district_id;
                        $district = district($draft_data->district_id);
                        $region_id = $draft_data->div_state_id;
                        $region = div_state($draft_data->div_state_id);
                    } else {
                        $fullname = $nrc = $applied_phone = $applied_building_type = $applied_home_no = $applied_building = $applied_lane = $applied_street = $applied_quarter = $applied_town = $township_id = $district_id = $district = $region_id = $region = $job_type = $position = $department = $salary = null;
                    }
                @endphp
                {!! Form::open(['route' => ['commercial_store_user_info']]) !!}
                {!! Form::hidden('form_id', $form_id) !!}
                <div class="row justify-content-center ">
                    <div class="col-md-8">
                        {{--  Fullname  --}}
                        <div class="form-group">
                            <label for="fullname" class="text-info">
                                {{ __('lang.fullname') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                             <input type="text" name="fullname" value="{{ $fullname }}" id="fullname" class="form-control {{ $errors->has('fullname') ? 'is-invalid' : '' }}" required>
                        </div>
                        {{--  NRC  --}}
                        <div class="form-group">
                            <label for="nrc" class="text-info">
                                {{ __('lang.nrc') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            <input type="text" name="nrc" value="{{ $nrc }}" id="nrc" class="form-control {{ $errors->has('nrc') ? 'is-invalid' : '' }}" required>
                        </div>
                        {{--  Mobile Phone  --}}
                        <div class="form-group">
                            <label for="applied_phone" class="text-info">
                                {{ __('lang.contact_phone') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            <input type="text" name="applied_phone" value="{{ $applied_phone }}" id="phone" class="form-control {{ $errors->has('applied_phone') ? 'is-invalid' : '' }}" required>
                        </div>
                        {{--  Work  --}}
                        <div class="form-group">
                            <label for="jobType" class="text-info">
                                {{ __('lang.job_type') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            <select name="jobType" class="form-control" id="jobType" required>
                                <option value="">{{ __('lang.choose1') }}</option>
                                <option value="gstaff" {{ $job_type != 'gstaff' ? : 'selected' }}>အစိုးရဝန်ထမ်း</option>
                                <option value="staff" {{ $job_type != 'staff' ? : 'selected' }}>ဝန်ထမ်း</option>
                                <option value="other" {{ $job_type != 'other' ? : 'selected' }}>အခြား</option>
                            </select>
                        </div>
                        {{--  Wrapper div for govStaff  --}}
                        <div class="gStaff-wrapper {{ $job_type == 'gstaff' || $job_type == 'staff' ? : 'd-none' }}" id="gStaff-wrap">
                            <div class="form-group m-t-20">
                                <div class="row">
                                    <div class="col-md-6">
                                        {{--  Position  --}}
                                        <label for="pos" class="text-info">{{ __('lang.position') }} <span class="text-danger f-s-15">&#10039;</span></label> 
                                        <input type="text" name="pos" value="{{ $job_type == 'gstaff' || $job_type == 'staff' ? $position : '' }}" class="form-control"/>
                                    </div>
                                    <div class="col-md-6">
                                        {{--  Department  --}}
                                        <label for="dep" class="text-info">{{ __('lang.mini_comp') }} <span class="text-danger f-s-15">&#10039;</span></label>
                                        <input type="text" name="dep" value="{{ $job_type == 'gstaff' || $job_type == 'staff' ? $department : '' }}" class="form-control"/>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group m-t-20">
                                    <label for="salary" class="text-info">{{ __('lang.avg_salary') }}</label>
                                    <input type="number" name="salary" value="{{ $job_type == 'gstaff' || $job_type == 'staff' ? $salary : '' }}" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="otherWrapper {{ $job_type == 'other' ? : 'd-none' }}" id="otherWrap">
                            <div class="form-group">
                                <label for="other" class="text-info">{{ __('lang.other') }} <span class="text-danger f-s-15">&#10039;</span></label>
                                <input type="text" name="other" value="{{ $job_type == 'other' ? $position : '' }}" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="other" class="text-info">{{ __('lang.avg_salary') }}
                                <input type="number" name="otherSalary" value="{{ $job_type == 'other' ? $salary : '' }}" class="form-control" />
                            </div>
                        </div>
                        {{--  Building Type  --}}
                        <div class="form-group">
                            <label for="applied_building_type" class="text-info">
                                {{ __('lang.building_type') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            <textarea name="applied_building_type" class="form-control" required>{{ $applied_building_type }}</textarea>
                        </div>
                        {{--  Home / Building No  --}}
                        <div class="form-group">
                            <label for="applied_home_no" class="text-info">
                                {{ __('lang.home_no') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            <input type="text" name="applied_home_no" value="{{ $applied_home_no }}" id="applied_home_no" class="form-control {{ $errors->has('applied_home_no') ? 'is-invalid' : '' }}" required>
                        </div>
                        {{--  Room No  --}}
                        <div class="form-group">
                            <label for="applied_building" class="text-info">
                                {{ __('lang.building') }} <span class="text-danger"></span>
                            </label>
                            <input type="text" name="applied_building" value="{{ $applied_building }}" id="applied_building" class="form-control {{ $errors->has('applied_building') ? 'is-invalid' : '' }}">
                        </div>
                        {{--  Street Address  --}}
                        <div class="form-group">
                            <label for="applied_street" class="text-info">
                                {{ __('lang.street') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            <input type="text" name="applied_street" value="{{ $applied_street }}" id="applied_street" class="form-control {{ $errors->has('applied_street') ? 'is-invalid' : '' }}" required>
                        </div>
                        {{--  Lane  --}}
                        <div class="form-group">
                            <label for="applied_lane" class="text-info">
                                {{ __('lang.lane') }} 
                            </label>
                            <input type="text" name="applied_lane" value="{{ $applied_lane }}" id="applied_lane" class="form-control {{ $errors->has('applied_lane') ? 'is-invalid' : '' }}">
                        </div>
                        {{--  Quarter  --}}
                        <div class="form-group">
                            <label for="applied_quarter" class="text-info">
                                {{ __('lang.quarter') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            <input type="text" name="applied_quarter" value="{{ $applied_quarter }}" id="applied_quarter" class="form-control {{ $errors->has('applied_quarter') ? 'is-invalid' : '' }}" required>
                        </div>
                        {{--  Town  --}}
                        <div class="form-group">
                            <label for="applied_town" class="text-info">
                                {{ __('lang.town') }}
                            </label>
                            <input type="text" name="applied_town" value="{{ $applied_town }}" id="applied_town" class="form-control {{ $errors->has('applied_town') ? 'is-invalid' : '' }}">
                        </div>
                        {{--  Township  --}}
                        <div class="form-group">
                            <label for="township_id" class="text-info">
                                {{ __('lang.township') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            <select name="township_id" class="form-control s2 {{ checkMM() }}" id="township" required>
                                <option value="">{{ __('lang.choose1') }}</option>
                                @foreach ($townships as $township)
                                <option value="{{ $township->id }}" {{ ($township_id && $township_id == $township->id) ? 'selected' : '' }}>
                                    {{ checkMM() == 'mm' ? $township->name : $township->eng }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        {{--  District  --}}
                        <div class="form-group">
                            <label for="district" class="text-info">
                                {{ __('lang.district') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            <input type="text" name="district" value="{{ $district }}" id="district" class="form-control" readonly>
                                {!! Form::hidden('district_id', $district_id, ['id' => 'district_id']) !!}
                        </div>
                        {{--  Region  --}}
                        <div class="form-group">
                            <label for="region" class="text-info">
                                {{ __('lang.div_state') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            <input type="text" name="region" value="{{ $region }}" id="region" class="form-control" readonly>
                                {!! Form::hidden('div_state_id', $region_id, ['id' => 'region_id']) !!}
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            <div class="col-md-3 mb-1">
                                <a href="{{ route('all_meter_forms') }}" class="waves-effect waves-light btn btn-block btn-rounded btn-secondary ">{{ __('lang.cancel') }}</a>
                            </div>
                            <div class="col-md-3 mb-1">
                                <button name="save_type" value="draft" type="submit" class="waves-effect waves-light btn btn-block btn-rounded btn-warning ">{{ __('lang.save_draft') }}</button>
                            </div>
                            <div class="col-md-3 mb-1">
                                <button name="save_type" value="save" type="submit" class="waves-effect waves-light btn btn-block btn-rounded btn-primary ">{{ __('lang.submit') }}</button>
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
