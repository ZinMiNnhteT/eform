<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-Form MOEE</title>
    <style>
        
    </style>
</head>
<body>
    <div class="container pt-20 pb-20">
        http://localhost/moeedemo/public/email/verify/10?expires=1581586063&signature=ee8f3ba619c0fc6a1ca4017c47c2fd968d786a4be6e06a6db3b9ffa1e56f7fef


        <a href="{{ asset('email/verify/'.$user->id.'?expires='.'&signature=') }}">Verify Email Address</a>
    </div>
</body>
</html>
