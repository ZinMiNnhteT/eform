<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/pdfcss.css') }}">
    <title>{{ $title }}</title>
</head>
<body>
    <htmlpageheader name="page-header">
        <span class="logo_img"></span> MOEE
    </htmlpageheader>

    {{--  <htmlpagefooter name="page-footer">
        Your Footer Content
    </htmlpagefooter>  --}}

    <h4 class="text-center">ကိုယ်တိုင်ရေးလျှောက်လွှာပုံစံ</h4>
    <p class="text-sm text-right">အမှတ်စဥ် - {{ $data->serial_code }}</p>
    <div class="to-div">
        <p>သို့</p>
        <p>မြို့နယ်လျှပ်စစ်မှူး/မြို့နယ်လျှပ်စစ်အင်ဂျင်နီယာ</p>
        <p>လျှပ်စစ်ဓာတ်အားဖြန့်ဖြူးရေးလုပ်ငန်း</p>
        <p>{{ township_mm($data->township_id) }}</p>
    </div>
    <p class="text-right">ရက်စွဲ။   ။ {{ mmNum(date('d-m-Y', strtotime($data->date))) }}</p>
    <div>
        <p>အကြောင်းအရာ။   ။ <strong>{{ tsf_type($data->id) }}  တည်ဆောက် တပ်ဆင် ခွင့်ပြုပါရန် လျှောက်ထားခြင်း။</strong></p>
        <p><span class=""></span>အထက်ပါကိစ္စနှင့်ပတ်သက်၍ {{ address_mm($data->id) }}နေ ကျွန်တော်/ကျွန်မ၏ <b>{{ $data->applied_building_type ? $data->applied_building_type : '<span class="p-l-40"></span>' }}</b> တွင် {{ tsf_type($data->id) }} တပ်ဆင်သုံးစွဲခွင့်ပြုပါရန် လျှောက်ထားအပ်ပါသည်။</p>
        <p>တပ်ဆင်သုံးစွဲခွင့်ပြုပါက လျှပ်စစ်ဓာတ်အားဖြန့်ဖြူးရေးလုပ်ငန်းမှ သတ်မှတ်ထားသော အခွန်အခများကို အကြေပေးဆောင်မည့်အပြင် တည်ဆဲဥပဒေများအတိုင်း လိုက်နာဆောင်ရွက်မည်ဖြစ်ပါကြောင်းနှင့် အိမ်တွင်းဝါယာသွယ်တန်းခြင်းလုပ်ငန်းများကို လျှပ်စစ်ကျွမ်းကျင်လက်မှတ်ရှိသူများနှင့်သာ ဆောင်ရွက်မည်ဖြစ်ကြောင်း ဝန်ခံကတိပြုလျှောက်ထားအပ်ပါသည်။</p>
    </div>
    <table class="mt-50 mb-50 table">
        <tbody>
            <tr>
                <td width="40%"><strong>တပ်ဆင်သုံးစွဲလိုသည့် လိပ်စာ</strong></td>
                <td width="60%"></td>
            </tr>
            <tr>
                <td width="40%">
                    <p>{{ address_mm($data->id) }}</p>
                </td>
                <td width="60%"></td>
            </tr>
            
            <tr>
                <td width="80%"></td>
                <td width="20%">
                    {{ $data->fullname }}<br/>
                    {{ $data->nrc }}<br/>
                    {{ mmNum($data->applied_phone) }}
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>