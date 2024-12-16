<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="icon" href="{{ asset('images/logo.png') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    </head>
    <body class="bg-img {{ checkMM() }}">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand d-sm-none d-block" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @if (Auth::guard('admin')->user())
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">{{ __('lang.dashboard') }}</a>
                        </li>
                    </ul>
                @else
                    @auth
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">{{ __('lang.user_home_page') }}</a>
                            </li>
                        </ul>
                    @else
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('lang.login_menu') }}</a>
                            </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('lang.register_menu') }}</a>
                            </li>
                        @endif
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('language/en') }}"><i class="flag-icon flag-icon-gb"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('language/mm') }}"><i class="flag-icon flag-icon-mm"></i></a>
                            </li>
                        </ul>
                    @endauth
                @endif
            </div>
        </nav>
        
        <div class="container-fluid">
            <div class="row py-md-5 px-md-5">
                <div class="welcome-header col-md-4 text-center">
                    <h2 class="text-info">{{ __('lang.omaf_msg2') }}</h2>
                    <h4 class="text-warning">{{ __('lang.omaf') }}</h4>
                    <img class="m-t-20" src="{{ asset('images/logo.png') }}" style="width: 50%"/>
                </div>
                <div class="col-md-8">
                    <div class="card bg-none">
                        <div class="card-body py-md-5 px-md-5">
                            <ul class="p-0 notice jstf">
                                <li><h4 class="custom-text">မီတာ/ပါဝါမီတာ/ထရန်စဖေါ်မာ လျှောက်ထားရာတွင် လျှောက်ထားသူ၏ ကိုယ်ရေးအချက်အလက်များနှင့် ပူးတွဲပါစာရွက်စာတမ်းများကို တိကျမှန်ကန်စွာ ဖြည့်သွင်းပေးရမည်။</h4></li>
                                <li><h4 class="custom-text">မီတာ/ပါဝါမီတာ/ထရန်စဖေါ်မာ လျှောက်ထားရာတွင် ဌာနမှ ပူးတွဲတင်ပြရန် သက်မှတ်ထားသော စာရွက်စာတမ်းများအား ထင်ရှားပြတ်သားစွာ ဓါတ်ပုံရိုက်ယူ၍သော်လည်ကောင်း၊ Scan ဖတ်၍သော်လည်ကောင်း ပူးတွဲတင်ပြပေးရမည်။</h4></li>
                                <li><h4 class="custom-text">ပူးတွဲပါစာရွက်စာတမ်းများ မပြည့်စုံခြင်း၊ ထင်ရှားမှု၊ ပြတ်သားမှုမရှိပါက လျှောက်လွှာအား ထည့်သွင်းစဉ်းစားမည် မဟုတ်ပါ။</h4></li>
                                <li><h4 class="custom-text">တရားဝင်နေထိုင်ကြောင်းထောက်ခံစာနှင့် ကျူးကျော်မဟုတ်ကြောင်းထောက်ခံစာများသည် (၁ လ) အတွင်းရယူထားသော ထောက်ခံစာများဖြစ်ရမည်။</h4></li>
                                <li><h4 class="custom-text">ပူးတွဲပါစာရွက်စာတမ်းများအား အတုပြုလုပ်ခြင်း၊ ပြင်ဆင်ခြင်းများ တွေ့ရှိပါက တည်ဆဲဥပဒေအရ ထိရောက်စွာ အရေးယူခြင်းခံရမည် ဖြစ်ပါသည်။</h4></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
