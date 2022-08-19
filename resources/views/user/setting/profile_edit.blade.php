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
                                {!! Form::open(['route'=>['user_profile_update',$user->id],'method' => 'PATCH', 'files' => true]) !!}
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-md-right">{{ __('lang.name') }}</label>
                                    <div class="col-md-6">
                                        <input type="text" value="{{ old('name') ?? $user->name }}" name="name" class="form-control" required>
                                        @if($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-md-right">{{ __('lang.email') }}</label>
                                    <div class="col-md-6">
                                        <input type="text" value="{{ old('email') ?? $user->email }}" name="email" class="form-control" required/>
                                        @if($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-md-right">{{ __('lang.phone') }}</label>
                                    <div class="col-md-6">
                                        <input type="text" value="{{ old('phone') ?? $user->phone }}" name="phone" class="form-control" placeholder="-"/>
                                        @if($errors->has('phone'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-md-right">{{ __('lang.password') }}</label>
                                    <div class="col-md-6">
                                        <input type="password" name="password" class="form-control" required/>
                                        @if(isset($password_error))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $password_error }}</strong>
                                            </span>
                                        @endif
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