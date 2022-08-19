@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
            </div>
            {{--  {{ dd(regionsDropdown()) }}  --}}
            <div class="card-body">

                <div class="row justify-content-center">
                    <div class="col-7">
                        {!! Form::open(['route' => 'accounts.store']) !!}
                        <div class="form-group row">
                            <label for="name" class="col-form-label l-h-35 text-md-right col-md-3">{{ __('lang.name') }}</label>
                            <div class="col-md-9">
                                <input type="text" id="name" name="name" class="form-control inner-form {{ $errors->has('name') ? 'is-invalid' : '' }}" required value="{{old('name')}}">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-form-label l-h-35 text-md-right col-md-3">{{ __('lang.username') }}</label>
                            <div class="col-md-9">
                                <input type="text" id="username" name="username" class="form-control inner-form {{ $errors->has('username') ? 'is-invalid' : '' }}" required value="{{old('username')}}">
                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-form-label l-h-35 text-md-right col-md-3">{{ __('lang.email') }}</label>
                            <div class="col-md-9">
                                <input type="email" id="email" name="email" class="form-control inner-form {{ $errors->has('email') ? 'is-invalid' : '' }}" required value="{{old('email')}}">
                                 @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-form-label l-h-35 text-md-right col-md-3">{{ __('lang.phone') }}</label>
                            <div class="col-md-9">
                                <input type="phone" id="phone" name="phone" class="form-control inner-form {{ $errors->has('phone') ? 'is-invalid' : '' }}" required value="{{old('phone')}}">
                                 @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="position" class="col-form-label l-h-35 text-md-right col-md-3">{{ __('lang.position') }}</label>
                            <div class="col-md-9">
                                <input type="position" id="position" name="position" class="form-control inner-form {{ $errors->has('position') ? 'is-invalid' : '' }}" required value="{{old('position')}}">
                                 @if ($errors->has('position'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('position') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="department" class="col-form-label l-h-35 text-md-right col-md-3">{{ __('lang.department') }}</label>
                            <div class="col-md-9">
                                <input type="department" id="department" name="department" class="form-control inner-form {{ $errors->has('department') ? 'is-invalid' : '' }}" required value="{{old('department')}}">
                                 @if ($errors->has('department'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('department') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-form-label l-h-35 text-md-right col-md-3">{{ __('lang.password') }}</label>
                            <div class="col-md-9">
                                <input type="password" name="password" id="password" class="form-control inner-form {{ $errors->has('password') ? 'is-invalid' : '' }}" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-form-label l-h-35 text-md-right col-md-3">{{ __('lang.confirm_password') }}</label>
                            <div class="col-md-9">
                                <input type="password" id="password-confirm" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="group_lvl" class="col-form-label l-h-35 text-md-right col-md-3">{{ __('lang.group') }}</label>
                            <div class="col-md-9">
                                @php
                                    $opt_group[""] = trans('lang.choose1');
                                    foreach (groupDropDown() as $id => $name){
                                        //if(Auth::guard('admin')->user()->group_lvl == '1' ||//$id == Auth::guard('admin')->user()->group_lvl ){
                                            $opt_group[$id] = $name;
                                        //}
                                    }
                                    echo Form::select('group_lvl',$opt_group,old('group_lvl'),["class"=>"form-control inner-form","required"]);
                                @endphp
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="role" class="col-form-label l-h-35 text-md-right col-md-3">{{ __('lang.role_name') }}</label>
                            <div class="col-md-9">
                                @php
                                    $opt_role[""] = trans('lang.choose1');
                                    foreach (roleDropdown() as $key => $value){
                                        $opt_role[$key] = $value;
                                    }
                                    echo Form::select('role[]',$opt_role,old('role'),["class"=>"form-control","required","multiple"]);
                                @endphp
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="div_state" class="col-form-label l-h-35 text-md-right col-md-3">{{ __('lang.div_state') }}</label>
                            <div class="col-md-9">
                                @php
                                    $opt_div[""] = trans('lang.choose1');
                                    foreach (regionsDropdown() as $id => $name){
                                        $opt_div[$id] = $name;
                                    }
                                    echo Form::select('div_state',$opt_div,old('div_state'),["class"=>"form-control inner-form","required","id"=>"region"]);
                                @endphp
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="district" class="col-form-label l-h-35 text-md-right col-md-3">{{ __('lang.district') }}</label>
                            <div class="col-md-9">
                                @php
                                    $opt_district[""] = trans('lang.choose1');
                                    if(old('div_state') != ''){
                                        $opt_district = districts(old('div_state'));
                                    }
                                    echo Form::select('district',$opt_district,old('district'),["class"=>"form-control inner-form","required","id"=>"district"]);
                                @endphp
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="township" class="col-form-label l-h-35 text-md-right col-md-3">{{ __('lang.township') }}</label>
                            <div class="col-md-9">
                                @php
                                    $opt_township[""] = trans('lang.choose1');
                                    if(old('district') != ''){
                                        $opt_township = townships(old('district'));
                                    }
                                    echo Form::select('township',$opt_township,old('township'),["class"=>"form-control inner-form","required","id"=>"township"]);
                                @endphp
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('accounts.index') }}" class="btn btn-secondary">{{ __('lang.cancel') }}</a>
                            <input type="submit" name="acc_create_submit" value="{{ __('lang.submit') }}" class="btn btn-info">
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection