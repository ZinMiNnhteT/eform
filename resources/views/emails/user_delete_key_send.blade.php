<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-Form MOEE</title>
    <style>
        body {
            /* background: url(images/header2.png);
            background-repeat: no-repeat;
            background-size: 100% 300px; */
            /* background-color: #beeaf3; */
        }
        .header {
            padding: 30px 20px;
            display: flex;
            align-items: center;
        }
        span.slogan {
            font-size: 25px;
        }
        .logo {
            width: 100px;
        }
        .wrapper {
            width: 800px;
            margin: 0 auto;
            background: #fff;
            /* box-shadow: 0px 0px 8px 1px rgba(0, 0, 0, 0.32); */
            /* margin-bottom: 30px !important; */
            /* margin-top: 30px !important; */
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
            /* text-align: center; */
            font-size: 16px;
            /* color: #999; */
            padding-left: 30px;
            font-weight: 600;
        }
        .body {
            padding: 30px;
            text-align: justify;
            font-size: 14px;
            line-height: 26px;
        }
        a.buttton {
            text-decoration: none;
            border: 1px solid #0a47f8;
            padding: 10px 30px;
            background: #0a47f8;
            border-radius: 2px;
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
            /* border-top: 1px solid #d8d0d0; */
            color: #333;
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
            /* background: #ffe2e7; */
            font-size: 13px;
        }
        
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <img src="{{asset('images/logo.png')}}" alt="" class="logo">
            <span class="slogan">E-Form MOEE</span>
        </div>
        <div class="title"> {{ __('lang.acc_delete_mail_title')}} </div>
        <div class="body">
            <p>
                {{ __('lang.acc_delete_mail_msg')}} 
            </p>
            <p>
                Confirmation Key : {{ $key }}
            </p>
            <div class="from">
                <div class="office">MOEP-E-Form Support System</div>
                <div class="site-link"><a href="http://eformexample.moee.gov.mm/" target="_blank">eform.moee.gov.mm</a></div>
            </div>
        </div>
    </div>
</body>
</html>
