<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @isset($url)
    <title>{{ 'Admin login Panel |' }} {{ config('app.name', 'Laravel') }}</title>
    @else
    <title>{{ 'login Panel |' }} {{ config('app.name', 'Laravel') }}</title>
    @endisset

    {{-- Scripts --}}
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <link rel="icon" href="{{ asset('images/logo.png') }}">
    {{-- Styles --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mycss.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="{{ checkMM() }}">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                {{-- Right Side Of Navbar --}}
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="{{ url('language/en') }}">EN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="{{ url('language/mm') }}">MM</a>
                    </li>
                    {{-- Authentication Links --}}
                    {{--  @guest  --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('lang.login_menu') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('lang.register_menu') }}</a>
                            </li>
                        @endif
                    {{--  @endguest  --}}
                </ul>
            </div>
        </nav>
        
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="{{ url('js/app.js') }}"></script>
    <script src="{{ url('js/myjs.js') }}"></script>
</body>
</html>
