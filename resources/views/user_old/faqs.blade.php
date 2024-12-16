@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-12">

            <div class="card">
                <div class="card-header bg-info">
                    <h4 class="card-title text-white">{{ __('lang.'.$heading) }}</h4>
                </div>
                <div class="card-body">

                    <div class="vtabs customvtab">
                        <ul class="nav nav-tabs tabs-vertical" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#pills-residential-page" role="tab">
                                    <span class="hidden-sm-up"><i class="ti-home"></i></span>
                                    <span class="hidden-xs-down">{{ __('lang.residential') }} {{ __('lang.meter') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#pills-residential-power-page" role="tab">
                                    <span class="hidden-sm-up"><i class="ti-user"></i></span>
                                    <span class="hidden-xs-down">{{ __('lang.residential') }} {{ __('lang.power') }} {{ __('lang.meter') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#pills-commercial-power-page" role="tab">
                                    <span class="hidden-sm-up"><i class="ti-email"></i></span>
                                    <span class="hidden-xs-down">{{ __('lang.commercial') }} {{ __('lang.power') }} {{ __('lang.meter') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#pills-contractor-page" role="tab">
                                    <span class="hidden-sm-up"><i class="ti-email"></i></span>
                                    <span class="hidden-xs-down">{{ __('lang.contractor') }} {{ __('lang.meter') }}</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pills-residential-page" role="tabpanel">
                                {{ __('lang.residential') }} {{ __('lang.meter') }}
                            </div>
                            <div class="tab-pane fade" id="pills-residential-power-page" role="tabpanel">
                                {{ __('lang.residential') }} {{ __('lang.power') }} {{ __('lang.meter') }}
                            </div>
                            <div class="tab-pane fade" id="pills-commercial-power-page" role="tabpanel">
                                {{ __('lang.commercial') }} {{ __('lang.power') }} {{ __('lang.meter') }}
                            </div>
                            <div class="tab-pane fade" id="pills-contractor-page" role="tabpanel">
                                {{ __('lang.contractor') }} {{ __('lang.meter') }}
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

@endsection