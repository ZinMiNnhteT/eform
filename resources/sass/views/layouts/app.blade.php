<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    {{--  CSRF Token  --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'MOEE |' }} {{ config('app.name', 'Laravel') }}</title>

    {{--  Fonts  --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="icon" href="{{ asset('images/logo.png') }}">

    {{--  Styles  --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/horizontal-timeline.css') }}">
    <link rel="stylesheet" href="{{ asset('css/timeline-vertical-horizontal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/waitMe.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ribbon-page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/inbox.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skins/all.css') }}">
    <link href="{{ asset('css/form-icheck.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/stylish-tooltip.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tab-page.css') }}">
    {{--  <link rel="stylesheet" href="{{ asset('css/mycssImg.css') }}">  --}}
    <link rel="stylesheet" href="{{ asset('css/mycss.css') }}">
</head>
<body class="horizontal-nav skin-megna-dark fixed-layout {{ checkMM() }}">
    @php
    $chking_user = App\User::find(Auth::user()->id);
    @endphp
    {{--  loader  --}}
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label {{ checkMM() }}">{{ __('lang.loading') }}</p>
        </div>
    </div>

    <div id="main-wrapper">
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
                        {{--  <li class="nav-item d-sm-none"> <a class="nav-link nav-toggler waves-effect waves-light" href="javascript:void(0)"><i class="ti-menu"></i></a></li>  --}}
                        <li class="nav-item d-sm-none">
                            <button class="nav-link navbar-toggler waves-effect waves-light" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </li>

                        
                        {{--  @if ($chking_user->active && $chking_user->email_verified_at)  --}}
                        @if ($chking_user->active)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark mail-dd" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ti-email"></i>
                                <div class="nav-notify {{ mail_seen_chk()->count() > 0 ? 'notify' : '' }}"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu mailbox" aria-labelledby="2">
                                <span class="with-arrow"><span class="bg-danger"></span></span>
                                <ul>
                                    <li>
                                        <div class="drop-title text-white bg-info">
                                            <h4 class="m-b-0 m-t-5"><span class="noti-seen-count" data-count="{{ mail_seen_chk()->count() }}">{{ mail_seen_chk()->count() }}</span> New Messages</h4>
                                            <span class="font-light"><span class="noti-read-count" data-count="{{ mail_read_chk()->count() }}">{{ mail_read_chk()->count() }}</span> Unread Messages</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            @if (all_mail()->count() > 0)
                                            @foreach (all_mail() as $item)
                                            @php
                                                if ($item->mail_read) {
                                                    $read = '';
                                                } else {
                                                    $read = 'mail_un_read';
                                                }
                                            @endphp
                                            <a href="{{ route('inbox.index2', $item->id) }}" class="{{ $read }} clk-mail-notify" data-id="{{ $item->id }}">
                                                <div class="mail-contnet">
                                                    <p class="mb-0">{{ mail_type($item->send_type) }}</p>
                                                    {{--  <span class="mail-desc">Just see the my admin!</span>  --}}
                                                    <span class="time">
                                                        {{ date('d-m-Y',strtotime($item->mail_send_date)) }}
                                                    </span>
                                                </div>
                                            </a>
                                            @endforeach
                                            @endif
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center link m-b-5" href="{{ route('inbox.index') }}"> <b>See all Mails</b> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endif
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item">
                            <a class="nav-link text-muted waves-effect waves-dark custom-nav-link" href="{{ url('language/en') }}"><i class="flag-icon flag-icon-gb"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted waves-effect waves-dark custom-nav-link" href="{{ url('language/mm') }}"><i class="flag-icon flag-icon-mm"></i></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('images/user_foto.jpg') }}" alt="user" class="img-circle" width="30"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd flipInY">
                                <span class="with-arrow"><span class="bg-primary"></span></span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class=""><img src="{{ asset('images/user_foto.jpg') }}" alt="user" class="img-circle" width="60"></div>
                                    <div class="m-l-10">
                                        <h4 class="m-b-0">{{ Auth::user()->name }}</h4>
                                        <h4 class="m-b-0">{{ Auth::user()->id }}</h4>
                                        <p class=" m-b-0">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                                @if ($chking_user->active)
                                <a class="dropdown-item" href="{{ route('user_profile_edit') }}"><i class="ti-user m-r-5 m-l-5"></i> {{ __('lang.profile') }}</a>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-email m-r-5 m-l-5"></i> {{ __('lang.inbox') }}</a>
                                <a class="dropdown-item" href="{{ route('user_password_edit') }}"><i class="ti-key m-r-5 m-l-5"></i> {{ __('lang.change_password') }}</a> 
                                @endif
                                <a class="dropdown-item text-danger" href="{{ route('acc_delete') }}"><i class="ti-key m-r-5 m-l-5"></i> {{ __('lang.account_deletion') }}</a> 
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

        {{--  checking user is active or not  --}}
        @if (!$chking_user->active)
        <div class="page-wrapper p-0">
            <div class="custom-container-fluid">
                <div class="card p-5 text-center">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-8">
                                <div class="card text-center bg-warning">
                                    <div class="card-body">
                                        <div class="card">
                                            <div class="card-header bg-warning">
                                                <h3 class="p-3">{{ 'Hello,' }} {{ Auth::user()->name }}!</h3>
                                            </div>
                                            <div class="card-body">
                                                <p class="p-3">{{ 'Now you temporarily cannot be access for this website!' }}</p>
                                                <p class="p-3">{{ 'Please contact admin for more information!' }}</p>
                                            </div>
                                            <div class="footer bg-warning">
                                                <div class="row justify-content-center">
                                                    <div class="col-3">
                                                        <a class="dropdown-item btn-rounded" href="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('lang.logout') }}</a>
                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                            @csrf
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @else
            {{--  @if ($chking_user->email_verified_at)  --}}
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark-custom nav-sm-none">
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item m-l-10 m-r-10">
                        <a class="nav-link {{ active('index', @$active, null) }}" href="{{ route('home') }}"><i class="ti-home f-s-15 text-danger vm"></i> {{ __('lang.user_home_page') }}</a>
                    </li>
                    <li class="nav-item m-l-10 m-r-10">
                        <a class="nav-link {{ active('resident_app', @$active, null) }}" href="{{ route('all_meter_forms') }}"><i class="ti-layout-grid2 f-s-15 text-danger vm"></i> {{ __('lang.app_form_menu') }}</a>
                    </li>
                    <li class="nav-item m-l-10 m-r-10">
                        <a class="nav-link {{ active('inbox', @$active, null) }}" href="{{ route('inbox.index') }}"><i class="ti-email f-s-15 text-danger vm"></i> {{ __('lang.mail_menu') }}</a>
                    </li>
                    <li class="nav-item m-l-10 m-r-10">
                        <a class="nav-link {{ active('overall', @$active, null) }}" href="{{ route('overall_process') }}"><i class="ti-bar-chart f-s-15 text-danger vm"></i> {{ __('lang.process_menu') }}
                            {{--  @if (chk_send_count())
                            <span class="badge badge-danger">{{ chk_send_count() }}</span>
                            @endif  --}}
                        </a>
                    </li>
                    <li class="nav-item m-l-10 m-r-10">
                        <a class="nav-link {{ active('rule_regu', @$active, null) }}" href="{{ route('rule_regu') }}"><i class="fa fa-fw fa-bullhorn f-s-15 text-danger vm"></i> {{ __('lang.rr_menu') }}</a>
                    </li>
                    <li class="nav-item m-l-10 m-r-10">
                        <a class="nav-link {{ active('faqs', @$active, null) }}" href="{{ route('faqs') }}"><i class="fa fa-fw fa-question-circle f-s-15 text-danger vm"></i> {{ __('lang.faqs') }}</a>
                    </li>
                </ul>
            </div>
        </nav>
            {{--  @endif  --}}

        <div class="page-wrapper p-0">
            <div class="custom-container-fluid">

            @yield('content')

            </div>
        </div>
        @endif

        {{--  footer  --}}
        <footer class="footer text-right">
            © {{ date('Y') }} Power by <a href="http://www.thenexthop.net" target="_blank">Next Hop</a>
        </footer>
        {{--  End footer  --}}
    </div>

    

    {{--  Scripts  --}}
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="{{ asset('js/pusher.min.js') }}"></script> --}}
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/waves.js') }}"></script>
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup-init.js') }}"></script>
    <script src="{{ asset('js/horizontal-timeline.js') }}"></script>
    <script src="{{ asset('js/waitMe.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
     <!-- icheck -->
    <script src="{{ asset('js/icheck.min.js') }}"></script>
    <script src="{{ asset('js/icheck.init.js') }}"></script>
    {{-- <script src="{{ asset('js/noti.js') }}"></script> --}}
    <script src="{{ asset('js/myjs.js') }}"></script>
    {{--  <script src="{{ asset('js/perfect-scrollbar.jquery.min.js') }}"></script>  --}}
    {{--  <script src="{{ asset('js/mask.js') }}"></script>  --}}
    <script>
        
        // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = true;

        // var seenCount = $(".noti-seen-count").data("count");
        // var readCount = $(".noti-read-count").data("count");

        // var pusher = new Pusher('fa47486f1a0831ec0f3c', {
        //     cluster: 'ap1',
        //     encrypted: true
        // });

        // var channel = pusher.subscribe('notify');

        // channel.bind('App\\Events\\sendNote', function(data) {
        //     alert(JSON.stringify(data));
            // $(".nav-notify").addClass("notify");
            // $(".noti-seen-count").attr("data-count", seenCount++);
            // $(".noti-seen-count").text(seenCount++);
        // });
    </script>
</body>
</html>