<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="Content-Type" content="text/html">

    {{--  CSRF Token  --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'MOEE |' }} {{ config('app.name', 'Laravel') }}</title>

    {{--  Fonts  --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="icon" href="{{ asset('images/logo.png') }}">

    {{--  Styles  --}}
    {{-- Date Range Picker --}}
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style_admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-wysihtml5.css') }}">
    <link rel="stylesheet" href="{{ asset('css/waitMe.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css-chart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skins/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form-icheck.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stylish-tooltip.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mycssImg.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mycss.css') }}">
    {{--  <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">  --}}
    {{--  <link rel="stylesheet" href="{{ asset('css/switchery.min.css') }}">  --}}

</head>
<body class="skin-megna fixed-layout lock-nav">
    {{--  loader  --}}
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label {{ checkMM() }}">{{ __('lang.loading') }}</p>
        </div>
    </div>

    <div class="jsloader">
        <div class="loaderjs">
            <div class="jsloader__figure"></div>
        </div>
    </div>

    <div id="main-wrapper" class="{{ checkMM() }}">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <b>
                            <img src="{{ asset('images/logo.png') }}" width="50" height="50" alt="homepage" class="dark-logo" />
                            <img src="{{ asset('images/logo.png') }}" width="50" height="50" alt="homepage" class="light-logo" />
                        </b>
                        {{-- <span class="l-h-ini">
                            <h1 class="dark-logo m-0">OMR</h1>
                            <h1 class="light-logo m-0">OMR</h1>
                        </span> --}}
                    </a>
                </div>

                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item hidden-sm-up">
                            <a class="nav-link nav-toggler waves-effect waves-light" href="javascript:void(0)"><i class="ti-menu"></i></a>
                        </li>
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link nav-lock waves-effect waves-light" href="javascript:void(0)"><i class="ti-menu"></i></a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ti-email"></i>
                                <div class=""> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu mailbox">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <ul>
                                    <li>
                                        <div class="drop-title bg-primary text-white">
                                            <h4 class="m-b-0 m-t-5">4 New</h4>
                                            <span class="font-light">Notifications</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                                {{--  Message  --}}
                                            <a href="javascript:void(0)">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Luanch Admin</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center m-b-5" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ti-bell"></i>
                                <div class=""> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu mailbox" aria-labelledby="2">
                                <span class="with-arrow"><span class="bg-danger"></span></span>
                                <ul>
                                    <li>
                                        <div class="drop-title text-white bg-danger">
                                            <h4 class="m-b-0 m-t-5">5 New</h4>
                                            <span class="font-light">Messages</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                                {{--  Message  --}}
                                            <a href="javascript:void(0)">
                                                <div class="user-img"> <img src="{{ asset('images/8.jpg') }}" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center link m-b-5" href="javascript:void(0);"> <b>See all e-Mails</b> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        {{--  <li class="nav-item search-box"> <a class="nav-link waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <form class="app-search">
                                <input type="text" class="form-control" placeholder="Search &amp; enter"> <a class="srh-btn"><i class="ti-close"></i></a>
                            </form>
                        </li>  --}}
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item">
                            <a class="nav-link">{{ admin()->name }}</a>
                        </li>
                        {{--  <li class="nav-item">
                            <a class="nav-link text-muted waves-effect waves-dark custom-nav-link" href="{{ url('language/en') }}"><i class="flag-icon flag-icon-gb"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted waves-effect waves-dark custom-nav-link" href="{{ url('language/mm') }}"><i class="flag-icon flag-icon-mm"></i></a>
                        </li>  --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('images/user_foto.jpg') }}" alt="user" class="img-circle" width="30"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd flipInY">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class=""><img src="{{ asset('images/user_foto.jpg') }}" alt="user" class="img-circle" width="60"></div>
                                    <div class="m-l-10">
                                        <h4 class="m-b-0">{{ Auth::guard('admin')->user()->name }}</h4>
                                        <p class=" m-b-0">{{ Auth::guard('admin')->user()->email }}</p>
                                    </div>
                                </div>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-user m-r-5 m-l-5"></i> {{ __('lang.profile') }}</a>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-email m-r-5 m-l-5"></i> {{ __('lang.inbox') }}</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="ti-power-off m-r-5 m-l-5"></i> {{ __('lang.logout') }}</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="left-sidebar">
            <div class="d-flex no-block nav-text-box align-items-center">
                <span><img src="{{ asset('images/logo-icon.png') }}" alt="elegant admin template"></span>
                <a class="nav-lock waves-effect waves-dark ml-auto hidden-md-down" href="javascript:void(0)"><i class="mdi mdi-toggle-switch"></i></a>
                <a class="nav-toggler waves-effect waves-dark ml-auto hidden-sm-up" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
            </div>
            {{--  Sidebar scroll  --}}
            <div class="scroll-sidebar" style="overflow-y: scroll;">
                {{--  Sidebar navigation  --}}
                <ul class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">

                    {{--  dashboard  --}}
                    <li><a class="waves-effet waves-dark {{ $active == 'dash' ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="custom-fa fa fa-dashboard"></i>{{ __('lang.dashboard') }}</a></li>

                    {{--  inbox  --}}
                    @if (hasPermissions(['inbox-view']))

                        @if (Auth::guard('admin')->user()->id == 1)
                    <li><a class="waves-effet waves-dark {{ $active == 'mailbox' ? 'active' : '' }}" href="{{ route('mailbox') }}"><i class="custom-fa fa fa-envelope-o"></i>{{ __('lang.inbox') }}</a></li>
                        @else
                    <li><a class="waves-effet waves-dark {{ $active == 'mailbox' ? 'active' : '' }}" href="javascript:void(0)"><i class="custom-fa fa fa-envelope-o"></i>{{ __('lang.inbox') }}</a></li>
                        @endif
                    @endif
                    
                    {{--  @if (hasPermissions(['applyingForm-view']))
                    <li><a class="waves-effet waves-dark {{ $active == 'applying_form' ? 'active' : '' }}" href="javascript:void(0)"><i class="custom-fa fa fa-bars"></i>{{ __('lang.applying_form_list') }}</a></li>
                    @endif
                    @if (hasPermissions(['performingForm-view']))
                    <li><a class="waves-effet waves-dark {{ $active == 'performing_form' ? 'active' : '' }}" href="javascript:void(0)"><i class="custom-fa fa fa-exchange"></i>{{ __('lang.performing_form_list') }}</a></li>
                    @endif  --}}
                    @if (hasPermissions(['registeredForm-view']))
                    <li><a class="waves-effet waves-dark {{ $active == 'registered_form' ? 'active' : '' }}" href="{{ route('registered_form.index') }}"><i class="custom-fa fa fa-bookmark"></i>{{ __('lang.registered_form_list') }}</a></li>
                    @endif
                    @if (hasPermissions(['rejectForm-view']))
                    <li><a class="waves-effet waves-dark {{ $active == 'reject_form' ? 'active' : '' }}" href="javascript:void(0)"><i class="custom-fa fa fa-ban"></i>{{ __('lang.reject_form_list') }}</a></li>
                    @endif
                    @if (hasPermissions(['pendingForm-view']))
                    <li><a class="waves-effet waves-dark {{ $active == 'pending_form' ? 'active' : '' }}" href="javascript:void(0)"><i class="custom-fa fa fa-clock-o"></i>{{ __('lang.pending_form_list') }}</a></li>
                    @endif
                    
                    {{--  residential  --}}
                    @if (hasPermissions(['residential-view']))
                    <li>
                        <a class="waves-effet waves-dark cursor-p" data-toggle=".custom_dropdown1" onclick="event.preventDefault();" aria-haspopup="true" aria-expanded="false">
                            <i class="custom-fa fa fa-home text-primary"></i>{{ __('lang.residential') }} {{ __('lang.meter') }} <i class="fa-fw fa fa-angle-right"></i>
                        </a>
                        <ul class="custom_dropdown1 {{ ($active == 'resident_app_form' || $active == 'resident_app_reject' || $active == 'resident_app_pending' || $active == 'resident_app_survey' || $active == 'resident_app_announce' || $active == 'resident_app_payment' || $active == 'resident_app_contract' || $active == 'resident_app_chk_install' || $active == 'resident_app_reg_meter' || $active == 'resident_app_gnd_done' || $active == 'resident_app_install_done') ? 'd-block' : '' }}">
                            @if (hasPermissions(['residentApplication-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'resident_app_form' ? 'active' : '' }}" href="{{ route('residentialMeterApplicationList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentApplication') }}</a></li>
                            @endif
                            @if (hasPermissions(['residentialGrdChk-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'resident_app_survey' ? 'active' : '' }}" href="{{ route('residentialMeterGroundCheckList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentSurvey') }}</a></li>
                            @endif
                            @if (hasPermissions(['residentialChkGrdTownship-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'resident_app_gnd_done' ? 'active' : '' }}" href="{{ route('residentialMeterGroundCheckDoneList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentSurveyDoneTsp') }}</a></li>
                            @endif
                            @if (hasPermissions(['residentPending-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'resident_app_pending' ? 'active' : '' }}" href="{{ route('residentialMeterPendingForm.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentPending') }}</a></li>
                            @endif
                            @if (hasPermissions(['residentReject-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'resident_app_reject' ? 'active' : '' }}" href="{{ route('residentialMeterRejectedForm.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentReject') }}</a></li>
                            @endif
                            @if (hasPermissions(['residentialAnnounce-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'resident_app_announce' ? 'active' : '' }}" href="{{ route('residentialMeterAnnounceList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.announce') }}</a></li>
                            @endif
                            @if (hasPermissions(['residentialConfirmPayment-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'resident_app_payment' ? 'active' : '' }}" href="{{ route('residentialMeterPaymentList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentConfrimPayment') }}</a></li>
                            @endif
                            @if (hasPermissions(['residentialChkInstall-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'resident_app_chk_install' ? 'active' : '' }}" href="{{ route('residentialMeterCheckInstallList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.chk_install') }}</a></li>
                            @endif
                            @if (hasPermissions(['residentialRegisteredMeter-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'resident_app_reg_meter' ? 'active' : '' }}" href="{{ route('residentialMeterRegisterMeterList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.reg_meter') }}</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    {{--  residential Power --}}
                    @if (hasPermissions(['residentialPower-view']))
                    <li>
                        <a class="waves-effet waves-dark cursor-p" data-toggle=".custom_dropdown2" onclick="event.preventDefault();" aria-haspopup="true" aria-expanded="false">
                            <i class="custom-fa fa fa-building-o text-primary"></i>{{ __('lang.residential') }} {{ __('lang.power') }} {{ __('lang.meter') }} <i class="fa-fw fa fa-angle-right"></i>
                        </a>
                        <ul class="custom_dropdown2 {{ ($active == 'resident_power_app_form' || $active == 'resident_power_app_reject' || $active == 'resident_power_app_pending' || $active == 'resident_power_app_survey' || $active == 'resident_power_app_announce' || $active == 'resident_power_app_payment' || $active == 'resident_power_app_contract' || $active == 'resident_power_app_chk_install' || $active == 'resident_power_app_reg_meter' || $active == 'resident_power_app_gnd_done' || $active == 'resident_power_app_gnd_done_dist' || $active == 'resident_power_app_install_done') ? 'd-block' : '' }}">
                            @if (hasPermissions(['residentPowerApplication-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'resident_power_app_form' ? 'active' : '' }}" href="{{ route('residentialPowerMeterApplicationList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentApplication') }}</a></li>
                            @endif
                            @if (hasPermissions(['residentialPowerGrdChk-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'resident_power_app_survey' ? 'active' : '' }}" href="{{ route('residentialPowerMeterGroundCheckList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentSurvey') }}</a></li>
                            @endif
                            @if (hasPermissions(['residentialPowerTownshipChkGrd-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'resident_power_app_gnd_done' ? 'active' : '' }}" href="{{ route('residentialPowerMeterGroundCheckDoneList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentSurveyDoneTsp') }}</a></li>
                            @endif
                            @if (hasPermissions(['residentialPowerDistrictChkGrd-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'resident_power_app_gnd_done_dist' ? 'active' : '' }}" href="{{ route('residentialPowerMeterGroundCheckDoneListByDistrict.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentSurveyDoneDist') }}</a></li>
                            @endif
                            @if (hasPermissions(['residentPowerPending-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'resident_power_app_pending' ? 'active' : '' }}" href="{{ route('residentialPowerMeterPendingForm.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentPending') }}</a></li>
                            @endif
                            @if (hasPermissions(['residentPowerReject-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'resident_power_app_reject' ? 'active' : '' }}" href="{{ route('residentialPowerMeterRejectedForm.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentReject') }}</a></li>
                            @endif
                            @if (hasPermissions(['residentialPowerAnnounce-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'resident_power_app_announce' ? 'active' : '' }}" href="{{ route('residentialPowerMeterAnnounceList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.announce') }}</a></li>
                            @endif
                            @if (hasPermissions(['residentialPowerConfirmPayment-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'resident_power_app_payment' ? 'active' : '' }}" href="{{ route('residentialPowerMeterPaymentList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentConfrimPayment') }}</a></li>
                            @endif
                            @if (hasPermissions(['residentialPowerChkInstall-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'resident_power_app_chk_install' ? 'active' : '' }}" href="{{ route('residentialPowerMeterCheckInstallList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.chk_install') }}</a></li>
                            @endif
                            @if (hasPermissions(['residentialPowerRegisteredMeter-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'resident_power_app_reg_meter' ? 'active' : '' }}" href="{{ route('residentialPowerMeterRegisterMeterList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.reg_meter') }}</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    {{--  Commercial  --}}
                    @if (hasPermissions(['commercialPower-view']))
                    <li>
                        <a class="waves-effet waves-dark cursor-p" data-toggle=".custom_dropdown3" onclick="event.preventDefault();" aria-haspopup="true" aria-expanded="false">
                            <i class="custom-fa fa fa-industry text-primary"></i>{{ __('lang.commercial') }} {{ __('lang.power') }} {{ __('lang.meter') }} <i class="fa-fw fa fa-angle-right"></i>
                        </a>
                        <ul class="custom_dropdown3 {{ ($active == 'commercial_app_form' || $active == 'commercial_app_reject' || $active == 'commercial_app_pending' || $active == 'commercial_app_survey' || $active == 'commercial_app_announce' || $active == 'commercial_app_payment' || $active == 'commercial_app_contract' || $active == 'commercial_app_chk_install' || $active == 'commercial_app_reg_meter' || $active == 'commercial_app_gnd_done' || $active == 'commercial_app_gnd_done_dist' || $active == 'commercial_app_install_done') ? 'd-block' : '' }}">
                            @if (hasPermissions(['commercialPowerApplication-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'commercial_app_form' ? 'active' : '' }}" href="{{ route('commercialPowerMeterApplicationList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentApplication') }}</a></li>
                            @endif
                            @if (hasPermissions(['commercialPowerGrdChk-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'commercial_app_survey' ? 'active' : '' }}" href="{{ route('commercialPowerMeterGroundCheckList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentSurvey') }}</a></li>
                            @endif
                            @if (hasPermissions(['commercialPowerTownshipChkGrd-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'commercial_app_gnd_done' ? 'active' : '' }}" href="{{ route('commercialPowerMeterGroundCheckDoneList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentSurveyDoneTsp') }}</a></li>
                            @endif
                            @if (hasPermissions(['commercialPowerDistrictChkGrd-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'commercial_app_gnd_done_dist' ? 'active' : '' }}" href="{{ route('commercialPowerMeterGroundCheckDoneListDist.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentSurveyDoneDist') }}</a></li>
                            @endif
                            @if (hasPermissions(['commercialPowerPending-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'commercial_app_pending' ? 'active' : '' }}" href="{{ route('commercialPowerMeterPendingForm.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentPending') }}</a></li>
                            @endif
                            @if (hasPermissions(['commercialPowerReject-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'commercial_app_reject' ? 'active' : '' }}" href="{{ route('commercialPowerMeterRejectedForm.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentReject') }}</a></li>
                            @endif
                            @if (hasPermissions(['commercialPowerAnnounce-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'commercial_app_announce' ? 'active' : '' }}" href="{{ route('commercialPowerMeterAnnounceList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.announce') }}</a></li>
                            @endif
                            @if (hasPermissions(['commercialPowerConfirmPayment-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'commercial_app_payment' ? 'active' : '' }}" href="{{ route('commercialPowerMeterPaymentList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentConfrimPayment') }}</a></li>
                            @endif
                            @if (hasPermissions(['commercialPowerChkInstall-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'commercial_app_chk_install' ? 'active' : '' }}" href="{{ route('commercialPowerMeterCheckInstallList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.chk_install') }}</a></li>
                            @endif
                            @if (hasPermissions(['commercialPowerRegisteredMeter-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'commercial_app_reg_meter' ? 'active' : '' }}" href="{{ route('commercialPowerMeterRegisterMeterList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.reg_meter') }}</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    {{-- Contractor --}}
                    @if (hasPermissions(['contractor-view']))
                    <li>
                        <a class="waves-effet waves-dark cursor-p" data-toggle=".custom_dropdown4" onclick="event.preventDefault();" aria-haspopup="true" aria-expanded="false">
                            <i class="custom-fa fa fa-building text-primary"></i>{{ __('lang.contractor') }} {{ __('lang.meter') }} <i class="fa-fw fa fa-angle-right"></i>
                        </a>
                        <ul class="custom_dropdown4  {{ ($active == 'contractor_app_form' || $active == 'contractor_app_survey' || $active == 'contractor_app_gnd_done' || $active == 'contractor_app_gnd_done_dist' || $active == 'contractor_app_gnd_done_div_state' || $active == 'contractor_app_announce' || $active == 'contractor_app_pending' || $active == 'contractor_app_reject' || $active == 'contractor_app_payment' || $active == 'contractor_app_chk_install' || $active == 'contractor_app_reg_meter' || $active == 'contractor_app_install_done') ? 'd-block' : '' }}">
                            @if (hasPermissions(['contractorApplication-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'contractor_app_form' ? 'active' : '' }}" href="{{ route('contractorMeterApplicationList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentApplication') }}</a></li>
                            @endif
                            @if (hasPermissions(['contractorGrdChk-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'contractor_app_survey' ? 'active' : '' }}" href="{{ route('contractorMeterGroundCheckList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentSurvey') }}</a></li>
                            @endif
                            @if (hasPermissions(['contractorTownshipChkGrd-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'contractor_app_gnd_done' ? 'active' : '' }}" href="{{ route('contractorMeterGroundCheckDoneList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentSurveyDoneTsp') }}</a></li>
                            @endif
                            @if (hasPermissions(['contractorDistrictChkGrd-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'contractor_app_gnd_done_dist' ? 'active' : '' }}" href="{{ route('contractorMeterGroundCheckDoneListByDistrict.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentSurveyDoneDist') }}</a></li>
                            @endif
                            @if (hasPermissions(['contractorDivStateChkGrd-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'contractor_app_gnd_done_div_state' ? 'active' : '' }}" href="{{ route('contractorMeterGroundCheckDoneListByDivisionState.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentSurveyDoneDivstate') }}</a></li>
                            @endif
                            @if (hasPermissions(['contractorPending-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'contractor_app_pending' ? 'active' : '' }}" href="{{ route('contractorMeterPendingForm.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentPending') }}</a></li>
                            @endif
                            @if (hasPermissions(['contractorReject-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'contractor_app_reject' ? 'active' : '' }}" href="{{ route('contractorMeterRejectedForm.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentReject') }}</a></li>
                            @endif
                           
                            
                            @if (hasPermissions(['contractorAnnounce-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'contractor_app_announce' ? 'active' : '' }}" href="{{ route('contractorMeterAnnounceList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.announce') }}</a></li>
                            @endif
                            
                            @if (hasPermissions(['contractorConfirmPayment-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'contractor_app_payment' ? 'active' : '' }}" href="{{ route('contractorMeterPaymentList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentConfrimPayment') }}</a></li>
                            @endif
                            
                            @if (hasPermissions(['contractorChkInstall-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'contractor_app_chk_install' ? 'active' : '' }}" href="{{ route('contractorMeterCheckInstallList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.chk_install') }}</a></li>
                            @endif
                            
                            @if (hasPermissions(['contractorInstallDone-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'contractor_app_install_done' ? 'active' : '' }}" href="{{ route('contractorMeterInstallationDoneList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.ei_chk_install') }}</a></li>
                            @endif
                            
                            @if (hasPermissions(['contractorRegisteredMeter-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'contractor_app_reg_meter' ? 'active' : '' }}" href="{{ route('contractorMeterRegisterMeterList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.reg_meter') }}</a></li>
                            @endif
                            
                        </ul>
                    </li>
                    @endif

                    {{-- transformer --}}
                    @if (hasPermissions(['contractor-view']))
                    <li>
                        <a class="waves-effet waves-dark cursor-p" data-toggle=".custom_dropdown5" onclick="event.preventDefault();" aria-haspopup="true" aria-expanded="false">
                            <i class="custom-fa fa fa-bolt text-primary"></i>{{ __('lang.transformer') }} <i class="fa-fw fa fa-angle-right"></i>
                        </a>
                        <ul class="custom_dropdown5 {{ ($active == 'tsf_app_form' || $active == 'tsf_app_reject' || $active == 'tsf_app_pending' || $active == 'tsf_app_survey' || $active == 'tsf_app_gnd_done_dist' || $active == 'tsf_app_gnd_done_div_state' || $active == 'tsf_app_gnd_done_head_office' || $active == 'tsf_app_announce' || $active == 'tsf_app_payment' || $active == 'tsf_app_contract' || $active == 'tsf_app_chk_install' || $active == 'tsf_app_reg_meter' || $active == 'tsf_app_gnd_done' || $active == 'tsf_app_install_done') ? 'd-block' : '' }}">
                            @if (hasPermissions(['transformerApplication-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'tsf_app_form' ? 'active' : '' }}" href="{{ route('transformerApplicationList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentApplication') }}</a></li>
                            @endif
                            @if (hasPermissions(['transformerGrdChk-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'tsf_app_survey' ? 'active' : '' }}" href="{{ route('transformerGroundCheckList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentSurvey') }}</a></li>
                            @endif
                            @if (hasPermissions(['transformerTownshipChkGrd-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'tsf_app_gnd_done' ? 'active' : '' }}" href="{{ route('transformerGroundCheckDoneList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentSurveyDoneTsp') }}</a></li>
                            @endif
                            @if (hasPermissions(['transformerDistrictChkGrd-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'tsf_app_gnd_done_dist' ? 'active' : '' }}" href="{{ route('transformerGroundCheckDoneListByDistrict.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentSurveyDoneDist') }}</a></li>
                            @endif
                            @if (hasPermissions(['transformerDivStateChkGrd-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'tsf_app_gnd_done_div_state' ? 'active' : '' }}" href="{{ route('transformerGroundCheckDoneListByDivisionState.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentSurveyDoneDivstate') }}</a></li>
                            @endif
                            @if (hasPermissions(['transformerHeadChkGrd-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'tsf_app_gnd_done_head_office' ? 'active' : '' }}" href="{{ route('transformerGroundCheckDoneListByHeadOffice.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentSurveyDoneHeadOffice') }}</a></li>
                            @endif
                            @if (hasPermissions(['transformerPending-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'tsf_app_pending' ? 'active' : '' }}" href="{{ route('transformerPendingForm.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentPending') }}</a></li>
                            @endif
                            @if (hasPermissions(['transformerReject-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'tsf_app_reject' ? 'active' : '' }}" href="{{ route('transformerRejectedForm.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentReject') }}</a></li>
                            @endif
                            @if (hasPermissions(['transformerAnnounce-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'tsf_app_announce' ? 'active' : '' }}" href="{{ route('transformerAnnounceList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.announce') }}</a></li>
                            @endif
                            @if (hasPermissions(['transformerConfirmPayment-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'tsf_app_payment' ? 'active' : '' }}" href="{{ route('transformerPaymentList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.residentConfrimPayment') }}</a></li>
                            @endif
                            @if (hasPermissions(['transformerChkInstall-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'tsf_app_chk_install' ? 'active' : '' }}" href="{{ route('transformerCheckInstallList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.chk_install') }}</a></li>
                            @endif
                            @if (hasPermissions(['transformerInstallDone-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'tsf_app_install_done' ? 'active' : '' }}" href="{{ route('transformerInstallationDoneList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.ei_chk_install') }}</a></li>
                            @endif
                            @if (hasPermissions(['transformerRegisteredMeter-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'tsf_app_reg_meter' ? 'active' : '' }}" href="{{ route('transformerRegisterMeterList.index') }}"><i class="custom-fa fa fa-file-text-o"></i>{{ __('lang.reg_meter') }}</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    {{--  setting  --}}
                    @if (hasPermissions(['setting-view']))
                    <li>
                        <a class="waves-effet waves-dark cursor-p" data-toggle=".custom_dropdown6" onclick="event.preventDefault();" aria-haspopup="true" aria-expanded="false">
                            <i class="custom-fa ti-settings text-danger"></i>{{ __('lang.setting') }} <i class="fa-fw fa fa-angle-right"></i>
                        </a>
                        <ul class="custom_dropdown6 {{ ($active == 'accounts' || $active == 'roles') ? 'd-block' : '' }}">
                            {{--  account  --}}
                            @if (hasPermissions(['accountSetting-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'accounts' ? 'active' : '' }}" href="{{ route('accounts.index') }}"><i class="custom-fa fa fa fa-address-book-o"></i>{{ __('lang.accountSetting') }}</a></li>
                            @endif
                            {{--  role  --}}
                            @if (hasPermissions(['roleSetting-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'roles' ? 'active' : '' }}" href="{{ route('roles.index') }}"><i class="custom-fa fa fa fa-sitemap"></i>{{ __('lang.roleSetting') }}</a></li>
                            @endif
                            {{-- user  account  --}}
                            @if (hasPermissions(['userAccount-view']))
                            <li><a class="waves-effet waves-dark {{ $active == 'users' ? 'active' : '' }}" href="{{ route('users.index') }}"><i class="custom-fa fa fa fa-address-book-o"></i>{{ __('lang.userAccounts') }}</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                </ul>
                {{--  End Sidebar navigation  --}}
            </div>
            {{--  End Sidebar scroll  --}}
        </aside>

        <div class="page-wrapper">
            <div class="custom-container-fluid">
                
                @yield('content')
                
            </div>
        </div>

        {{--  footer  --}}
        <footer class="footer text-right">
            © {{ date('Y') }} Power by <a href="http://www.thenexthop.net" target="_blank">Next Hop</a>
        </footer>
        {{--  End footer  --}}
    </div>

    {{--  Scripts  --}}
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/custom_admin.min.js') }}"></script>
    <script src="{{ asset('js/waves.js') }}"></script>
    <script src="{{ asset('js/sidebarmenu_admin.js') }}"></script>
    <script src="{{ asset('js/wysihtml5-0.3.0.js') }}"></script>
    <script src="{{ asset('js/bootstrap-wysihtml5.js') }}"></script>
    <script src="{{ asset('js/waitMe.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js')}}"></script>
    <script src="{{ asset('js/icheck.init.js')}}"></script>
    <script src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script src="{{ asset('js/echarts-all.js') }}"></script>
    <script src="{{ asset('js/echarts-init.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/jquery.sweet-alert.custom.js') }}"></script>
    <script src="{{ asset('js/myjs.js') }}"></script>
    <script>
        $(function() {   
           $('.daterange').daterangepicker({
            // startDate: '01/01/2019',
            autoApply:true,
           });
           $('.daterange').val($('.daterange').attr("value"));
        });
    </script>

</body>
</html>
