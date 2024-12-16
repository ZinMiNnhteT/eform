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
        <div class="container-fluid bg-grey">
            <div class="row py-md-5 px-md-5 justify-content-center ">
                <div class="welcome-header col-md-8 text-center bg-white p-30">
                    <h2 class="text-info" style="font-size: 25px; ">{{ __('lang.omaf_msg2') }}</h2>
                    <img src="{{ asset('images/logo.png') }}" style="width: 200px; padding-bottom:10px;"/>
                    <p style="font-size: 16px; font-weight: bold;"> {{ __('lang.acc_delete_success') }} </p>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
