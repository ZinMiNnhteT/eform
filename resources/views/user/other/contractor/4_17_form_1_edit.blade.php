@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="card-title text-center text-white">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                <h5 class="py-2 text-danger text-center">{{ __('lang.required_msg') }}</h5>
                <br/>
                @php
                    if (isset($form) && $form->count() > 0) {
                        
                        $fullname = $form->fullname;
                        $nrc = $form->nrc;
                        $applied_phone = $form->applied_phone;
                        $applied_building_type = $form->applied_building_type;
                        $applied_home_no = $form->applied_home_no;
                        $applied_lane = $form->applied_lane;
                        $applied_street = $form->applied_street;
                        $applied_quarter = $form->applied_quarter;
                        $applied_town = $form->applied_town;
                        $township_id = $form->township_id;
                        $district_id = $form->district_id;
                        $district = district($form->district_id);
                        $region_id = $form->div_state_id;
                        $region = div_state($form->div_state_id);
                    } else {
                        $fullname = $nrc = $applied_phone = $applied_building_type = $applied_home_no = $applied_building = $applied_lane = $applied_street = $applied_quarter = $applied_town = $township_id = $district_id = $district = $region_id = $region = null;
                    }
                @endphp
                {!! Form::open(['route' => ['417_update_user_info']]) !!}
                {!! Form::hidden('form_id', $form_id) !!}
                
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="fullname" class="text-info">{{__('lang.fullname')}} <span class="text-danger f-s-15">&#10039;</span></label>
                            <input type="text" name="fullname" value="{{ $fullname }}" id="fullname" class="form-control {{ $errors->has('fullname') ? 'is-invalid' : '' }}">
                        </div>
                        {{-- NRC --}}
                        <div class="form-group">
                            <label for="nrc" class="text-info">{{__('lang.nrc')}} <span class="text-danger f-s-15">&#10039;</span></label>
                            <input type="text" name="nrc" value="{{ $nrc }}" id="nrc" class="form-control {{ $errors->has('nrc') ? 'is-invalid' : '' }}" placeholder="{{__('lang.nrc_example')}}">   
                        </div>
                        {{-- Mobile --}}
                        <div class="form-group">
                            <label for="applied_phone" class="text-info"> {{ __('lang.contact_phone') }} <span class="text-danger f-s-15">&#10039;</span></label>
                            <input type="text" name="applied_phone" value="{{ $applied_phone }}" id="phone" class="form-control {{ $errors->has('applied_phone') ? 'is-invalid' : '' }}" placeholder="{{ __('lang.eg_phone1') }}">
                        </div>
                        {{-- Builing No --}}
                        <div class="form-group">
                            <label for="applied_home_no" class="text-info">{{ __('lang.home_no') }} <span class="text-danger f-s-15">&#10039;</span></label>
                            <input type="text" name="applied_home_no" value="{{ $applied_home_no }}" id="applied_home_no" class="form-control {{ $errors->has('applied_home_no') ? 'is-invalid' : '' }}">
                        </div>
                        {{-- Street Address --}}
                        <div class="form-group">
                            <label for="applied_street" class="text-info">{{ __('lang.street') }}<span class="text-danger f-s-15">&#10039;</span></label>
                            <input type="text" name="applied_street" value="{{ $applied_street }}" id="applied_street" class="form-control {{ $errors->has('applied_street') ? 'is-invalid' : '' }}">
                        </div>
                        {{-- Lane --}}
                        <div class="form-group">
                            <label for="applied_lane" class="text-info">{{ __('lang.lane') }}</label>
                            <input type="text" name="applied_lane" value="{{ $applied_lane }}" id="applied_lane" class="form-control">
                        </div>
                        {{-- Quarter --}}
                        <div class="form-group">
                            <label for="applied_quarter" class="text-info">{{ __('lang.quarter') }} <span class="text-danger f-s-15">&#10039;</span></label>
                            <input type="text" name="applied_quarter" value="{{ $applied_quarter }}" id="applied_quarter" class="form-control {{ $errors->has('applied_quarter') ? 'is-invalid' : '' }}">
                        </div>
                        {{-- Name of Town --}}
                        <div class="form-group">
                            <label for="applied_town" class="text-info">{{ __('lang.town') }}</label>
                            <input type="text" name="applied_town" value="{{ $applied_town }}" id="applied_town" class="form-control {{ $errors->has('applied_town') ? 'is-invalid' : '' }}">
                        </div>
                        {{-- Township --}}
                        <div class="form-group">
                            <label for="township_id" class="text-info">{{ __('lang.township') }} <span class="text-danger f-s-15">&#10039;</span></label>
                            <select name="township_id" class="form-control s2 {{ checkMM() }}" id="township">
                                <option value="">{{ __('lang.choose1') }}</option>
                                @foreach ($townships as $township)
                                <option value="{{ $township->id }}" {{ ($township_id && $township_id == $township->id) ? 'selected' : '' }}>
                                    {{ checkMM() == 'mm' ? $township->name : $township->eng }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- District --}}
                        <div class="form-group">
                            <label for="district" class="text-info">{{ __('lang.district') }}</label>
                            <input type="text" name="district" value="{{ $district }}" id="district" class="form-control" readonly>
                                {!! Form::hidden('district_id', $district_id, ['id' => 'district_id']) !!}
                        </div>
                        {{-- Region --}}
                        <div class="form-group">
                            <label for="" class="text-info">{{ __('lang.div_state') }}</label>
                            <input type="text" name="region" value="{{ $region }}" id="region" class="form-control " readonly>
                                {!! Form::hidden('div_state_id', $region_id, ['id' => 'region_id']) !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            <div class="col-md-3 mb-1">
                                <a href="{{ route('contractor_applied_form', $form->id) }}" class="waves-effect waves-light btn btn-block btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                            </div>
                            <div class="col-md-3 mb-1">
                                <button name="save_type" value="save" type="submit" class="waves-effect waves-light btn btn-block btn-rounded btn-primary">{{ __('lang.submit') }}</button>
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
