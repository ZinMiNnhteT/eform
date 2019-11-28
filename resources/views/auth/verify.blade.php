@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('lang.verified_alert') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('lang.send_verify_mail') }}
                        </div>
                    @endif

                    {{ __('lang.verified_msg_1') }}
                    {{ __('lang.verified_msg_2') }} <a href="{{ route('verification.resend') }}">{{ __('lang.verified_msg_3') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
