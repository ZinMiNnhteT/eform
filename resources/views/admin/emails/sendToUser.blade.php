<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mycss.css') }}" rel="stylesheet">
</head>
<body>
    <center>
        <h3>MOEE Online Meter/Transfomer Application</h3>
    </center>
    <p>Hi {{ $name }},</p>
    <div>@php echo $mail_body; @endphp</div>
    <br/>
    <br/>
    <div class="text-right">
        <span>လျှပ်စစ်နှင့်စွမ်းအင် ဝန်ကြီးဌာန</span><br/>
        <span>e-Meter Support Team</span><br/>
        <span><a href="http://www.moee.gov.mm">moee.gov.mm</a></span>
    </div>
</body>
</html>