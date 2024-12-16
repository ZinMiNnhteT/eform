@extends('layouts.admin_app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                </div>
    
                <div class="card-body">
    
                    <div class="row">
                        <div class="col-6">
                            <p class="text-right">{{ $all_forms->links() }}</p>
                        </div>
                    </div>
    
                    {!! Form::open(['route' => 'roles.store']) !!}
                    {!! Form::hidden('role_id', null, ['id' => 'role_id']) !!}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="div_state_id" class="form-control s2 {{ checkMM() }}" id="filter_div_state">
                                    <option value="">{{ __('lang.div_state') }}{{ __('lang.choose1') }}</option>
                                    @foreach ($div_states as $div_state)
                                    <option value="{{ $div_state->id }}">
                                        {{ checkMM() == 'mm' ? $div_state->name : $div_state->eng }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="district_id" class="form-control s2 {{ checkMM() }}" id="filter_district" disabled>
                                    <option value="">{{ __('lang.district') }}{{ __('lang.choose1') }}</option>
                                    @foreach ($districts as $district)
                                    <option value="{{ $district->id }}">
                                        {{ checkMM() == 'mm' ? $district->name : $district->eng }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="township_id" class="form-control s2 {{ checkMM() }}" id="filter_township" disabled>
                                    <option value="">{{ __('lang.township') }}{{ __('lang.choose1') }}</option>
                                    @foreach ($townships as $township)
                                    <option value="{{ $township->id }}">
                                        {{ checkMM() == 'mm' ? $township->name : $township->eng }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <a class="btn btn-rounded btn-outline-secondary btnRoleCancel d-none">{{ __('lang.cancel') }}</a>
                            <button type="submit" class="btn btn-rounded btn-info"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection