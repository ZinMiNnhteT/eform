@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="card-title text-center text-white m-0">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="m-t-10 mm" id="">
                        <ul style="list-style-type: square" class="text-justify">
                            <li>
                                <p>လျှောက်ထားသူသည် ယခုအိမ်သုံးပါဝါမီတာ လျှောက်ထားခြင်းအတွက် မည်သူကိုမျှ လာဘ်ငွေ၊ တံစိုးလက်ဆောင် တစ်စုံတစ်ရာ ပေးရခြင်းမရှိပါ။</p>
                            </li>
                            <li>
                                <p>သတ်မှတ်ကြေးငွေများကို တစ်လုံးတစ်ခဲတည်း ပေးသွင်းသွားမည်ဖြစ်ပြီး ဓာတ်အားခများကိုလည်း လစဉ်ပုံမှန်ပေးချေသွားပါမည်။</p>
                            </li>
                            <li>
                                <p>တည်ဆဲဥပဒေ၊ စည်းမျဉ်းများနှင့် အခါအားလျှော်စွာ ထုတ်ပြန်သောအမိန့်နှင့် ညွှန်ကြားချက်များကို တိကျစွာလိုက်နာ ဆောင်ရွက်သွားပါမည်ဟု ဝန်ခံကတိပြုပါသည်။</p>
                            </li>
                            <li>
                                <p>လက်ရှိတပ်ဆင်ထားသော အိမ်သုံးမီတာအား ဌာနသို့ ပြည်လည်အပ်နှံ၍ Test Lab ဌာနသို့ပေးပို့စစ်ဆေးပြီး Test Lab Result အရ  လျော်ကြေး၊ ဒဏ်ကြေး၊ နစ်နာကြေး ပေးဆောင်ရမည်ဆိုပါက ပေးဆောင်မည်ဖြစ်ပါကြောင်း ဝန်ခံကတိပြုပါသည်။</p>
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
                    <a href="{{ route('resident_power_meter_type_ygn') }}" class="waves-effect waves-light btn btn-rounded btn-info rr-accept disabled ">{{ __('lang.continue') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
