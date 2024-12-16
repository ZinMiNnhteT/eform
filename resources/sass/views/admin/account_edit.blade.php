@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <div class="row">
                    <div class="col-6"><h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5></div>
                    <div class="col-6 text-right"><a href="{{ route('accounts.index') }}" class="text-white">{{ __('lang.back') }}</a></div>
                </div>
            </div>
            
            <div class="card-body">
                
                <div class="row justify-content-center">
                    <div class="col-7">
                        {!! Form::open(['route' => ['accounts.update', $account->id], 'method' => 'PATCH']) !!}
                        <div class="form-group row">
                            <label for="name" class="col-form-label l-h-35 text-md-right col-md-3">{{ __('lang.name') }}</label>
                            <div class="col-md-9">
                                <input type="text" id="name" name="name" value="{{ $account->name }}" class="form-control inner-form {{ $errors->has('password') ? 'is-invalid' : '' }}" required>
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
                                <input type="text" id="username" name="username" value="{{ $account->username }}" class="form-control inner-form {{ checkMM() }} {{ $errors->has('username') ? 'is-invalid' : '' }}" required>
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
                                <input type="email" id="email" name="email" value="{{ $account->email }}" class="form-control inner-form {{ $errors->has('email') ? 'is-invalid' : '' }}" required>
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
                                <input type="phone" id="phone" name="phone" value="{{ $account->phone }}" class="form-control inner-form {{ $errors->has('phone') ? 'is-invalid' : '' }}" required>
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
                                <input type="position" id="position" name="position" value="{{ $account->position }}" class="form-control inner-form {{ checkMM() }} {{ $errors->has('position') ? 'is-invalid' : '' }}" required>
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
                                <input type="department" id="department" name="department" value="{{ $account->department }}" class="form-control inner-form {{ checkMM() }} {{ $errors->has('department') ? 'is-invalid' : '' }}" required>
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
                                <input type="password" name="password" id="password" class="form-control inner-form {{ $errors->has('password') ? 'is-invalid' : '' }}">
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
                                <input type="password" id="password-confirm" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="group_lvl" class="col-form-label l-h-35 text-md-right col-md-3">{{ __('lang.group') }}</label>
                            <div class="col-md-9">
                                <select name="group_lvl" id="group_lvl" class="form-control {{ checkMM() }}" required>
                                    <option value="">{{ __('lang.choose1') }}</option>
                                    @foreach (groupDropDown() as $key => $value)
                                        
                                            <option value="{{ $key }}" {{ $key == $account->group_lvl ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="role" class="col-form-label l-h-35 text-md-right col-md-3">{{ __('lang.role_name') }}</label>
                            <div class="col-md-9">
                                <select name="role[]" id="role" class="form-control {{ checkMM() }}" multiple required>
                                    <option value="">{{ __('lang.choose1') }}</option>
                                    @php
                                        if (isset($userRole)) {
                                            $role =  $userRole;
                                        } else {
                                            $role = null;
                                        }
                                    @endphp
                                    @foreach (roleDropdown() as $key => $value)
                                        <option value="{{ $key }}" {{ $key == $role ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="region" class="col-form-label l-h-35 text-md-right col-md-3">{{ __('lang.div_state') }}</label>
                            <div class="col-md-9">
                                <select name="div_state" id="region" class="form-control {{ checkMM() }}" required>
                                    <option value="">{{ __('lang.choose1') }}</option>
                                    @foreach (regionsDropdown() as $key => $value)
                                    <option value="{{ $key }}" {{ $key == $account->div_state ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="district" class="col-form-label l-h-35 text-md-right col-md-3">{{ __('lang.district') }}</label>
                            <div class="col-md-9">
                                <select name="district" id="district" class="form-control {{ checkMM() }}">
                                    <option value="">{{ __('lang.choose1') }}</option>
                                    @foreach (districtsDropdown() as $key => $value)
                                    <option value="{{ $key }}" {{ $key == $account->district ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="township" class="col-form-label l-h-35 text-md-right col-md-3">{{ __('lang.township') }}</label>
                            <div class="col-md-9">
                                <select name="township" id="township" class="form-control {{ checkMM() }}">
                                    <option value="">{{ __('lang.choose1') }}</option>
                                    @foreach (townshipsDropdown() as $key => $value)
                                    <option value="{{ $key }}" {{ $key == $account->township ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
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