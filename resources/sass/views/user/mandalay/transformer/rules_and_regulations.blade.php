@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="card-title text-center text-white m-0">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="m-t-10 mm" id="">
                        <ul class="term-condition text-justify">
                            <li>
                                <p>မီတာ/ထရန်စဖေါ်မာ လျှောက်ထားရာတွင် ဌာနမှပူးတွဲတင်ပြရန် သက်မှတ်ထားသော စာရွက်စာတမ်းများအား ထင်ရှားပြတ်သားစွာ ဓါတ်ပုံရိုက်ယူ၍သော်လည်ကောင်း၊ Scan ဖတ်၍သော်လည်ကောင်း ပူးတွဲတင်ပြပေးရမည်။</p>
                            </li>
                            <li>
                                <p>ပူးတွဲပါစာရွက်စာတမ်းများ မပြည့်စုံခြင်း၊ ထင်ရှားမှု၊ ပြတ်သားမှုမရှိပါက လျှောက်လွှာအား ထည့်သွင်းစဉ်းစားမည် မဟုတ်ပါ။</p>
                            </li>
                            <li>
                                <p>တရားဝင်နေထိုင်ကြောင်းထောက်ခံစာနှင့် ကျူးကျော်မဟုတ်ကြောင်းထောက်ခံစာများသည် (၁ လ) အတွင်းရယူထားသော ထောက်ခံစာများဖြစ်ရမည်။</p>
                            </li>
                            <li>
                                <p>မီတာ/ထရန်စဖေါ်မာ လျှောက်ထားသူ၏ အိမ်အမှတ် / တိုက်အမှတ် / တိုက်ခန်းအမှတ်၊ လမ်းအမည်၊ လမ်းသွယ်အမည်၊ ရပ်ကွပ်အမည် နှင့် မြို့နယ်/ကျေးရွာ အမည်တို့ကို တိကျမှန်ကန်စွာ ဖြည့်သွင်းပေးရမည်။</p>
                            </li>
                            <li>
                                <p>ပူးတွဲပါစာရွက်စာတမ်းများအား အင်ဂျင်နီယာဌာနမှ ကွင်းဆင်းစစ်ဆေးသည့် အချိန်တွင် စစ်ဆေးသွားမည် ဖြစ်ပြီး စာရွက်စာတန်းများအား အတုပြုလုပ်ခြင်း၊ ပြင်ဆင်ခြင်းများ တွေ့ရှိပါက တည်ဆဲဥပဒေအရ ထိရောက်စွာ အရေးယူခြင်းခံရမည် ဖြစ်ပါသည်။</p>
                            </li>
                        </ul>
                        <hr/>
                        
                        <ul class="m-t-20 text-justify">
                            <p><strong>ကိုယ့်အားကိုယ်ကိုး ထရန်စဖေါ်မာတည်ဆောက်ခြင်းလုပ်ငန်းမှ ဓတ်အားခွဲရုံတည်ဆောက်ခြင်းလုပ်ငန်းများအား အောက်ဖော်ပြပါ သတ်မှတ်ချက်များအတိုင်း ဆောင်ရွက်ရမည် ဖြစ်ပါသည်။</strong></p>
                            <li>
                                <p>ထရန်စဖေါ်မာတပ်ဆင်ထားသော နေရာသည် လွယ်ကူစွာ ကြည့်ရှုနိုင်သော ဝန်ခြံအရှေ့မျက်နှာစာ နေရာမျိုးဖြစ်ရမည်။</p>
                            </li>
                            <li>
                                <p>နည်းပညာ စံချိန်စံညွှန်းနှင့် ကိုက်ညီမှုရှိသော အမျိုးအစားကောင်းမွန်သည့် ထရန်စဖေါ်မာကိုသာ တပ်ဆင်ရမည်။</p>
                            </li>
                            <li>
                                <p>Protection အတွက် HT Side တွင် Lightning Arrestor, Disconnection Switch, Drop Out Fuse (with respected fuse link), Enclosed Cutout Fuse တပ်ဆင်ရန်နှင့် Lightning Arrestor ကို Transformer ၏ HT Bushing နှင့် အနီးဆုံးနေရာတွင် တပ်ဆင်ရမည်။</p>
                            </li>
                            <li>
                                <p>ဗို့အားကျဆင်မှုမဖြစ်ပွားစေရန် LT Side တွင်အမျိုးအစားကောင်းမွန်သော Capacitor Bank တပ်ဆင်၍ အမြဲတမ်း အလုပ်လုပ်စေပြီး ချို့ယွင်းပျက်စီးပါက ချက်ချင်းအသစ်တစ်လုံး တပ်ဆင်ရမည်။</p>
                            </li>
                            <li>
                                <p>L.T Sideတွင် 400V Distribution Panel ( 4P – NFB + (Volt + Ampere) Meter + Pilot Lamp + Voltage Selector Switch ) တပ်ဆင်ရန်နှင့် ထရန်စဖေါ်မာ၏ LT Bushing Cap တပ်ဆင်၍ Seal ခတ်ရမည်။</p>
                            </li>
                            <li>
                                <p>Earthing System အတွက် သတ်မှတ်ထားသော earth result ရရှိရမည်ဖြစ်ပြီး earth mesh မှ L.A ၊ D.S ၊ DOF, Transformer Body နှင့် Neutral သို့ earth wire တစ်ချောင်းစီဖြင့် သီးသန့်ဆက်သွယ်ရမည်။ လျှပ်စစ်စစ်ဆေးရေးဌာနမှ ကွင်းဆင်းစစ်ဆေးသည့်အချိန်တွင် သတ်မှတ်ထားသော earth result မရရှိခြင်းနှင့် သတ်မှတ်ထားသော ညွှန်ကြားချက်များအတိုင်း လိုက်နာဆောင်ရွက်ခြင်းမရှိပါက ပြန်လည်ပြုပြင်ပေးရမည်။</p>
                            </li>
                            <li>
                                <p>မြေ/အဆောက်အဉီးဆိုင်ရာ အငြင်းပွားခြင်း၊ ဓာတ်အားသုံးစွဲသည့် လုပ်ငန်းနှင့် ပက်သက်၍ ကန့်ကွက်ခြင်းများ ပေါ်ပေါက်လာပါက ခွင့်ပြုမိန့်ရုပ်သိမ်း၍ ဓာတ်အားဖြတ်တောက်ခြင်း ဆောင်ရွက်သွားရမည်ကို သိရှိလိုက်နာရမည်။</p>
                            </li>
                            <li>
                                <p>ရုံးမှ ဓာတ်လွှတ်ရန် ခွင့်ပြုမိန့်ရရှိမှသာ ဓာတ်အားလွှတ်၍ မီးသုံးစွဲရမည်။</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr/>
                <div class="text-center">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input rr-ok" id="iagree">
                        <label class="custom-control-label text-danger p-l-20 {{ checkMM() }}" for="iagree">
                            {{ __('lang.i_agree') }}
                        </label>
                    </div>
                    <p class="text-danger mm"></p>
                    <a href="{{ route('all_meter_forms') }}" class="waves-effect waves-light btn btn-rounded btn-secondary ">{{ __('lang.cancel') }}</a>
                    <a href="{{ route('tsf_agreement_mdy') }}" class="waves-effect waves-light btn btn-rounded btn-info rr-accept disabled ">{{ __('lang.continue') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
