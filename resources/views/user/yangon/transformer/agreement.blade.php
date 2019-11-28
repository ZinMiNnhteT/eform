@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="card-title text-center text-white">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="m-t-10 mm" id="">
                        <ul style="list-style-type: square" class="text-justify">
                            <li>
                                <p>လျှောက်ထားသူသည် ယခုထရန်စဖေါ်မာ လျှောက်ထားခြင်းအတွက် မည်သူကိုမျှ လာဘ်ငွေ၊ တံစိုးလက်ဆောင် တစ်စုံတစ်ရာ ပေးရခြင်းမရှိပါ။</p>
                            </li>
                            <li>
                                <p>ထရန်စဖေါ်မာတည်ဆောက်ခွင့် ရရှိပါက သက်မှတ်ထားသော စံချိန်စံညွှန်းများနှင့်အညီ တည်ဆောက်သွားပါမည်။</p>
                            </li>
                            <li>
                                <p>သတ်မှတ်ကြေးငွေများကို တစ်လုံးတစ်ခဲတည်း ပေးသွင်းသွားမည်ဖြစ်ပြီး ဓာတ်အားခများကိုလည်း လစဉ်ပုံမှန်ပေးချေသွားပါမည်။</p>
                            </li>
                            <li>
                                <p>တည်ဆဲဥပဒေ၊ စည်းမျဉ်းများနှင့် အခါအားလျှော်စွာ ထုတ်ပြန်သောအမိန့်နှင့် ညွှန်ကြားချက်များကို တိကျစွာလိုက်နာ ဆောင်ရွက်သွားပါမည်ဟု ဝန်ခံကတိပြုပါသည်။</p>
                            </li>
                            <li>
                                <p>လျှောက်ထားသူသည် ဓာတ်အားသုံးစွဲခွင့် ရရှိပြီးနောက်ပိုင်းတွင် လိုအပ်လာပါက ဌာန၏ သတ်မှတ်ထားသော အခြားနေရာများသို့ ဓါတ်အားလိုင်းချိတ်ဆက်နိုင်စေရန် ခွင့်ပြုပေးရမည်ဖြစ်ပြီး ကန့်ကွက်ရန် မရှိကြောင်း ဝန်ခံကတိပြုပါသည်။</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr/>
                <div class="text-center">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input rr-ok" id="iagree">
                        <label class="custom-control-label text-danger p-l-20 {{ checkMM() }}" for="iagree">
                            {{ __('lang.i_agree_1') }}
                        </label>
                    </div>
                    <p class="text-danger mm"></p>
                    <a href="{{ route('all_meter_forms') }}" class="waves-effect waves-light btn btn-rounded btn-secondary ">{{ __('lang.cancel') }}</a>
                    <a href="{{ route('tsf_meter_type_ygn') }}" class="waves-effect waves-light btn btn-rounded btn-info rr-accept disabled ">{{ __('lang.continue') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
