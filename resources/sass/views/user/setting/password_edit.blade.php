@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-xlg-6 col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <center class="m-t-30"> <img src="{{ asset('images/user_foto.jpg') }}" class="img-circle" width="150">
                            <h4 class="card-title m-t-10">{{ Auth::user()->name }}</h4>
                            <h6 class="card-title m-t-10">{{ Auth::user()->email }}</h4>
                        </center>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body bg-secondary">
                                {!! Form::open(['route'=>['user_password_update',$user->id],'method' => 'PATCH', 'files' => true]) !!}
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-md-right">{{ __('lang.old_password') }}</label>
                                    <div class="col-md-6">
                                        <input type="password" name="old_password" class="form-control" required/>
                                        @if(isset($password_error))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $password_error }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('lang.new_password') }}</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                        
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @else
                                            <span class="invalid-feedback" role="alert">
                                                <strong>@lang('lang.password_msg')</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('lang.confirm_password') }}</label>
        
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="col-md-3 waves-effect waves-light btn btn-rounded btn-primary text-white">{{ __('lang.edit') }}</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection