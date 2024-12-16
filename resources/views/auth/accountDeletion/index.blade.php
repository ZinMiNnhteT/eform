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
                            <p>{!! __('lang.acc_del_noti') !!}</p>
                            <div class="card-body bg-secondary">
                                {!! Form::open(['route'=>['acc_delete_request'],'method' => 'POST', 'files' => true]) !!}
                                <div class="text-center">
                                    <button type="submit" class="waves-effect waves-light btn btn-rounded btn-danger text-white">{{ __('lang.req_to_delete') }}</button>
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