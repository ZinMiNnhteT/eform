@extends('layouts.app')

@section('ban-content')

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h4 class="card-title text-white">{{ __('lang.user_home_page') }}</h4>
                </div>
                <div class="card-body">
                    {{ 'Hello,' }} {{ Auth::user()->name }}!
                </div>
            </div>
        </div>
    </div>

@endsection