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
                            <h3 class="text-danger">{{ __('lang.account_deletion') }}</h3> <br>
                            <p>{!! __('lang.acc_del_noti2') !!}</p>
                            <div class="card-body bg-secondary">
                                {!! Form::open(['route'=>['acc_delete_done'],'method' => 'POST', 'files' => true]) !!}
                                {{-- <div class="form-group">
                                    {!! Form::label('key', 'Confirmation Key', []) !!}
                                    <input id="key" type="text" class="form-control {{ $key_error != null ? 'is-invalid' : '' }}" name="key" value="{{ old('key') }}" required autofocus>

                                    @if ($key_error != null)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $key_error }}</strong>
                                        </span>
                                    @endif
                                    <small>Get the key in your mail. Didn't get the key? Please click Go back to request the key again.</small>
                                </div> --}}
                                <div class="form-group">
                                    {!! Form::label('password', 'Password', []) !!}
                                    <input id="password" type="password" class="form-control {{ $psw_error != null ? 'is-invalid' : '' }}" name="password" value="{{ old('password') }}" required>

                                    @if ($psw_error != null)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $psw_error }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="text-center">
                                    <a href="{{ route('acc_delete') }}" class="waves-effect waves-light btn btn-rounded btn-warning" >Go Back</a>
                                    <button type="submit" class="waves-effect waves-light btn btn-rounded btn-danger text-white">{{ __('lang.acc_delete') }}</button>
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