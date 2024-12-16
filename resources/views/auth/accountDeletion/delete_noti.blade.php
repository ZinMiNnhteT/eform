@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('lang.acc_delete_noti_title') }}</div>
                <div class="card-body text-center">
                    <p>{{ __('lang.acc_delete_noti_msg') }}</p>
                    <a class="btn btn-danger text-white" href="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="ti-power-off m-r-5 m-l-5"></i> {{ __('lang.logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection