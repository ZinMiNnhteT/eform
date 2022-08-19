<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-Form MOEE</title>
    <style>
        body {
            /* background: url(images/header2.png); */
            /* background-repeat: no-repeat; */
            /* background-size: 100% 300px; */
        }
        .wrapper {
            width: 800px;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0px 0px 8px 1px rgba(0, 0, 0, 0.32);
            margin-bottom: 30px !important;
            margin-top: 30px !important;
        }
        img.bg {
            width: 100%;
            height: 310px;
            position: absolute;
            z-index: -1;
            margin-top: -30px;
            padding: 0px !important;
            margin-left: -8px;
        }
        .title {
            text-align: center;
            font-size: 25px;
            /* color: #999; */
        }
        .body {
            padding: 30px;
            text-align: justify;
            font-size: 14px;
            line-height: 26px;
        }
        a.buttton {
            text-decoration: none;
            border: 1px solid #44b5e4;
            padding: 10px 30px;
            background: #44b5e4;
            border-radius: 10px;
            text-align: center;
            color: #fff;
            text-transform: uppercase;
            transition: 0.3s;
            position: relative;
            top: 0px;
        }
        a.buttton:hover {
            box-shadow: 0px 0px 8px 1px rgba(0, 0, 0, 0.32);
            position: relative;
            top: -3px;
        }
        .text-center {
            text-align: center;
        }
        .p-30{
            padding: 30px;
        }
        .from {
            text-align: right;
            font-size: 14px;
        }
        a {
            text-decoration: none;
        }
        .footer {
            border-top: 1px solid #d8d0d0;
            padding: 30px;
            color: #333;
            padding-top: 10px;
        }
        .footer-body {
            font-size: 12px;
            padding: 10px 30px;
        }
        .mail img {
            width: 23px;
        }
        .footer img {
            padding-top: 10px;
            position: relative;
            top: 7px;
            padding-right: 5px;
        }
        .footer-body {
            display: flex;
            flex-shrink: 1;
        }

        .footer-body div {
            flex-grow: 1;
            text-align: center;
        }
        .text-danger{
            color:red;
        }
        .remark-danger {
            padding: 10px;
            background: #ffe2e7;
            font-size: 13px;
        }
        
    </style>
</head>
<body>
    <img src="{{asset('images/header2.png')}}" alt="" class="bg">
    <div class="wrapper">
        <div class="header">
            <img src="{{asset('images/header2.png')}}" alt="">
        </div>
        <div class="title"> {{ $header }} </div>
        <div class="body">
            <p>
                {!! str_repeat('&nbsp;',10) !!} {!! $body !!}
            </p>
            {!! $remark !!}
            @if( $link != '')
                <div class="text-center p-30">
                    <a href="{{ $link }}" class="buttton">{{ $link_name }}</a>
                </div>
            @endif
            <div class="from">
                <div class="office">{{ $office_from }}</div>
                <div class="site-link"><a href="http://eform.moee.gov.mm/" target="_blank">eform.moee.gov.mm</a></div>
            </div>
        </div>
        <div class="footer">
            <div class="footer-body">
                <div class="position">
                    <img src="{{asset('images/map.png')}}" alt=""> Nay Pyi Taw, Myanmar.
                </div>
                <div class="phone"> 
                    <img src="{{asset('images/phone.png')}}" alt=""> 0673410487, 0673410483
                </div>
                <div class="mail">
                    <img src="{{asset('images/email.png')}}" alt=""> admin@moee.gov.mm
                </div>
            </div>
        </div>
    </div>
</body>
</html>
