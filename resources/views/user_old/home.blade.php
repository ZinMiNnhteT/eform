@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h4 class="card-title text-white">{{ __('lang.home_menu') }}</h4>
                </div>
                <div class="card-body">
                    {{ 'Hello, '.Auth::user()->name }}
                </div>
            </div>
        </div>
        {{--  <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex no-block flex-row">
                        <div class="round bg-primary cc-icon align-self-center"><i class="fa fa-home text-white" title="BTC"></i></div>
                        <div class="m-l-10 align-self-center">
                            <h4 class="m-b-0">{{ __('lang.residential_meter_apply') }}</h4>
                        </div>
                    </div>
                    <div class="no-block flex-row m-t-20 cc-details">
                        <div class="row justify-content-center text-center">
                            <div class="col-4 row border-right">
                                <div class="col-12 text-gray">
                                    {{ __('lang.user_total_form') }}
                                </div>
                                <div class="col-12 mt-3 text-danger">
                                    <h3>{{ user_applied_form(1) }}</h3>
                                </div>
                            </div>
                            <div class="col-4 row border-right">
                                <div class="col-12 text-gray">
                                    {{ __('lang.user_total_unfinished_form') }}
                                </div>
                                <div class="col-12 mt-3 text-danger">
                                    <h3>{{ user_total_unfinished_form(1) }}</h3>
                                </div>
                            </div>
                            <div class="col-4 row">
                                <div class="col-12 text-gray">
                                    {{ __('lang.user_total_send_form') }}
                                </div>
                                <div class="col-12 mt-3 text-danger">
                                    <h3>{{ user_total_send_form(1) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex no-block flex-row">
                        <div class="round bg-primary cc-icon align-self-center"><i class="fa fa-building-o text-white" title="BTC"></i></div>
                        <div class="m-l-10 align-self-center">
                            <h4 class="m-b-0">{{ __('lang.residential_power_meter_apply') }}</h4>
                        </div>
                    </div>
                    <div class="no-block flex-row m-t-20 cc-details">
                        <div class="row justify-content-center text-center">
                            <div class="col-4 row border-right">
                                <div class="col-12 text-gray">
                                    {{ __('lang.user_total_form') }}
                                </div>
                                <div class="col-12 mt-3 text-danger">
                                    <h3>{{ user_applied_form(2) }}</h3>
                                </div>
                            </div>
                            <div class="col-4 row border-right">
                                <div class="col-12 text-gray">
                                    {{ __('lang.user_total_unfinished_form') }}
                                </div>
                                <div class="col-12 mt-3 text-danger">
                                    <h3>{{ user_total_unfinished_form(2) }}</h3>
                                </div>
                            </div>
                            <div class="col-4 row">
                                <div class="col-12 text-gray">
                                    {{ __('lang.user_total_send_form') }}
                                </div>
                                <div class="col-12 mt-3 text-danger">
                                    <h3>{{ user_total_send_form(2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex no-block flex-row">
                        <div class="round bg-primary cc-icon align-self-center"><i class="fa fa-industry text-white" title="BTC"></i></div>
                        <div class="m-l-10 align-self-center">
                            <h4 class="m-b-0">{{ __('lang.commercial_power_meter_apply') }}</h4>
                        </div>
                    </div>
                    <div class="no-block flex-row m-t-20 cc-details">
                        <div class="row justify-content-center text-center">
                            <div class="col-4 row border-right">
                                <div class="col-12 text-gray">
                                    {{ __('lang.user_total_form') }}
                                </div>
                                <div class="col-12 mt-3 text-danger">
                                    <h3>{{ user_applied_form(3) }}</h3>
                                </div>
                            </div>
                            <div class="col-4 row border-right">
                                <div class="col-12 text-gray">
                                    {{ __('lang.user_total_unfinished_form') }}
                                </div>
                                <div class="col-12 mt-3 text-danger">
                                    <h3>{{ user_total_unfinished_form(3) }}</h3>
                                </div>
                            </div>
                            <div class="col-4 row">
                                <div class="col-12 text-gray">
                                    {{ __('lang.user_total_send_form') }}
                                </div>
                                <div class="col-12 mt-3 text-danger">
                                    <h3>{{ user_total_send_form(3) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex no-block flex-row">
                        <div class="round bg-primary cc-icon align-self-center"><i class="fa fa-building text-white" title="BTC"></i></div>
                        <div class="m-l-10 align-self-center">
                            <h4 class="m-b-0">{{ __('lang.contractor_meter_apply') }}</h4>
                        </div>
                    </div>
                    <div class="no-block flex-row m-t-20 cc-details">
                        <div class="row justify-content-center text-center">
                            <div class="col-4 row border-right">
                                <div class="col-12 text-gray">
                                    {{ __('lang.user_total_form') }}
                                </div>
                                <div class="col-12 mt-3 text-danger">
                                    <h3>{{ user_applied_form(5) }}</h3>
                                </div>
                            </div>
                            <div class="col-4 row border-right">
                                <div class="col-12 text-gray">
                                    {{ __('lang.user_total_unfinished_form') }}
                                </div>
                                <div class="col-12 mt-3 text-danger">
                                    <h3>{{ user_total_unfinished_form(5) }}</h3>
                                </div>
                            </div>
                            <div class="col-4 row">
                                <div class="col-12 text-gray">
                                    {{ __('lang.user_total_send_form') }}
                                </div>
                                <div class="col-12 mt-3 text-danger">
                                    <h3>{{ user_total_send_form(5) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex no-block flex-row">
                        <div class="round bg-primary cc-icon align-self-center"><i class="fa fa-bolt text-white" title="BTC"></i></div>
                        <div class="m-l-10 align-self-center">
                            <h4 class="m-b-0">{{ __('lang.transformer_apply') }}</h4>
                        </div>
                    </div>
                    <div class="no-block flex-row m-t-20 cc-details">
                        <div class="row justify-content-center text-center">
                            <div class="col-4 row border-right">
                                <div class="col-12 text-gray">
                                    {{ __('lang.user_total_form') }}
                                </div>
                                <div class="col-12 mt-3 text-danger">
                                    <h3>{{ user_applied_form(4) }}</h3>
                                </div>
                            </div>
                            <div class="col-4 row border-right">
                                <div class="col-12 text-gray">
                                    {{ __('lang.user_total_unfinished_form') }}
                                </div>
                                <div class="col-12 mt-3 text-danger">
                                    <h3>{{ user_total_unfinished_form(4) }}</h3>
                                </div>
                            </div>
                            <div class="col-4 row">
                                <div class="col-12 text-gray">
                                    {{ __('lang.user_total_send_form') }}
                                </div>
                                <div class="col-12 mt-3 text-danger">
                                    <h3>{{ user_total_send_form(4) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex no-block flex-row">
                        <div class="round bg-primary cc-icon align-self-center"><i class="fa fa-superpowers text-white" title="BTC"></i></div>
                        <div class="m-l-10 align-self-center">
                            <h4 class="m-b-0">{{ __('lang.village_meter_apply') }}</h4>
                        </div>
                    </div>
                    <div class="no-block flex-row m-t-20 cc-details">
                        <div class="row justify-content-center text-center">
                            <div class="col-4 row border-right">
                                <div class="col-12 text-gray">
                                    {{ __('lang.user_total_form') }}
                                </div>
                                <div class="col-12 mt-3 text-danger">
                                    <h3>{{ user_applied_form(6) }}</h3>
                                </div>
                            </div>
                            <div class="col-4 row border-right">
                                <div class="col-12 text-gray">
                                    {{ __('lang.user_total_unfinished_form') }}
                                </div>
                                <div class="col-12 mt-3 text-danger">
                                    <h3>{{ user_total_unfinished_form(6) }}</h3>
                                </div>
                            </div>
                            <div class="col-4 row">
                                <div class="col-12 text-gray">
                                    {{ __('lang.user_total_send_form') }}
                                </div>
                                <div class="col-12 mt-3 text-danger">
                                    <h3>{{ user_total_send_form(6) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  --}}
    </div>

@endsection