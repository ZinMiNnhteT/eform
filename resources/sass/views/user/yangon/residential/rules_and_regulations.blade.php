@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="text-center text-white m-0">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="m-t-10 mm" id="">
                        <ul class="pt-3 term-condition">
                            {{-- <li>
                                <p>မီတာ/ထရန်စဖေါ်မာ လျှောက်ထားရာတွင် ဌာနမှပူးတွဲတင်ပြရန် သက်မှတ်ထားသော စာရွက်စာတမ်းများအား ထင်ရှားပြတ်သားစွာ ဓါတ်ပုံရိုက်ယူ၍သော်လည်းကောင်း၊ Scan ဖတ်၍သော်လည်ကောင်း ပူးတွဲတင်ပြပေးရမည်။</p>
                            </li> --}}
                            <li>
                                <p>ပူးတွဲတင်ပြသည့် အိမ်ထောင်စုစာရင်း၊ နိုင်ငံသားစိစစ်ရေးကဒ်၊ လိုင်စင်၊ စာချုပ်စာတမ်း၊ ထောက်ခံချက်စသည့် အထောက်အထားစာရွက်စာတမ်းများနှင့် ဓာတ်ပုံများကို ထင်ရှားမြင်သာ ပေါ်လွင်ပြီး ဖျက်ရာပြင်ရာမပါရှိရန်။</p>
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
                            <li>
                                <p>
                                    မြို့ပေါ်နှင့် ကျေးရွာလယ်ယာမြေပေါ်တည်ဆောက်ထားသော လူနေအိမ်များ၊ အဆောက်အဦးများ၊ စီးပွားရေးလုပ်ငန်းများနှင့် စက်မှုလုပ်ငန်းများအတွက် လယ်ယာမြေအား အခြားနည်း သုံးစွဲခွင့် လျှောက်ထား၍ ခွင့်ပြုချက် ရရှိပြီးမှသာလျှင် မီတာ/ထရန်စဖော်မာတပ်ဆင်သုံးစွဲခွင့်ပြုမည်။
                                </p>
                            </li>
                            <li>
                                <p>
                                    ထရန်စဖော်မာ/မီတာလျှောက်ထားနိုင်ရန် ပိုင်ဆိုင်မှုအထောက်အထားတင်ပြရာတွင် ကျူးကျော်မြေ၊ အများပိုင်မြေနှင့် အမွေဆိုင်မြေများဖြင့် လျှောက်ထားခြင်းမဟုတ်ဘဲတစ်ဦးတည်းပိုင်ဆိုင်သော မြေဖြစ်ရန် လိုအပ်ပါသည်။
                                </p>
                            </li>
                            <li>
                                <p>
                                    မီတာတပ်ဆင်မည့် အဆောက်အဦးအား ဘေးပတ်ဝန်းကျင်နှင့် အဆောက်အဦးပေါ်လွင်အောင် ဓာတ်ပုံရိုက်ပြီး မှန်မှန်ကန်ကန် ပူးတွဲတင်ပြရန်။ 
                                </p>
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
                    {{-- <a href="{{ route('resident_meter_type_ygn') }}" class="waves-effect waves-light btn btn-rounded btn-info rr-accept disabled ">{{ __('lang.continue') }}</a> --}}
                    <a href="{{ route('resident_agreement_ygn') }}" class="waves-effect waves-light btn btn-rounded btn-info rr-accept disabled ">{{ __('lang.continue') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
