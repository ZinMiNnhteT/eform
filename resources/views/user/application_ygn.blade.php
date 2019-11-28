@extends('layouts.app')

@section('content')
<a href="{{ route('all_meter_forms') }}" class="waves-effect waves-light btn btn-info btn-rounded pull-right mb-1"><< {{ __('lang.back') }}</a>
<div class="clearfix"></div>
<div class="card-deck mb-5">
    <div class="card">
        <div class="card-header bg-info">
            <h4 class="card-title text-center text-white">{{ __('lang.residential_meter_apply') }}</h4>
        </div>
        <div class="card-body">
            <div class="text-center">
                {{-- <p class="text-danger text-center"><i class="fa fa-exclamation-circle fa-fw"></i> {{ 'Coming Soon!' }}</p> --}}
                <a href="{{ route('resident_rule_regulation_ygn') }}" class="btn waves-effect waves-light btn-rounded btn-info text-white">{{ __('lang.apply') }}</a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-info">
            <h4 class="card-title text-center text-white">{{ __('lang.residential_power_meter_apply') }}</h4>
        </div>
        <div class="card-body">
            <div class="text-center">
                <p class="text-danger text-center"><i class="fa fa-exclamation-circle fa-fw"></i> {{ 'Coming Soon!' }}</p>
                <a href="" class="btn waves-effect waves-light btn-rounded btn-info text-white disabled">{{ __('lang.apply') }}</a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-info">
            <h4 class="card-title text-center text-white">{{ __('lang.commercial_power_meter_apply') }}</h4>
        </div>
        <div class="card-body">
            <div class="text-center">
                <p class="text-danger text-center"><i class="fa fa-exclamation-circle fa-fw"></i> {{ 'Coming Soon!' }}</p>
                <a href="" class="btn waves-effect waves-light btn-rounded btn-info text-white disabled">{{ __('lang.apply') }}</a>
            </div>
        </div>
    </div>
</div>
<div class="card-deck mb-5">
    <div class="card">
        <div class="card-header bg-info">
            <h4 class="card-title text-center text-white">{{ __('lang.transformer_apply') }}</h4>
        </div>
        <div class="card-body">
            <p class="text-danger text-center"><i class="fa fa-exclamation-circle fa-fw"></i> {{ 'Coming Soon!' }}</p>
            <div class="text-center">
                <a href="" class="btn waves-effect waves-light btn-rounded btn-info text-white disabled">{{ __('lang.apply') }}</a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-info">
            <h4 class="card-title text-center text-white">{{ __('lang.contractor_meter_apply') }}</h4>
        </div>
        <div class="card-body">
            {{--  <p class="text-danger text-center"><i class="fa fa-exclamation-circle fa-fw"></i> {{ 'Coming Soon!' }}</p>  --}}
            <div class="text-center">
                <a href="{{ route('contract_rule_regulation_ygn') }}" class="btn waves-effect waves-light btn-rounded btn-info text-white">{{ __('lang.apply') }}</a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-info">
            <h4 class="card-title text-center text-white">{{ __('lang.village_meter_apply') }}</h4>
        </div>
        <div class="card-body">
            <p class="text-danger text-center"><i class="fa fa-exclamation-circle fa-fw"></i> {{ 'Coming Soon!' }}</p>
            <div class="text-center">
                <a href="" class="btn waves-effect waves-light btn-rounded btn-info text-white disabled">{{ __('lang.apply') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection