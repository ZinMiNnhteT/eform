@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="container">
                    <div class="m-t-10 mm" id="">
                        <h4 class="card-title text-center ">{{ __('lang.'.$heading) }} {{ '(၂)' }}</h4>
                        <hr/>
                        <p style="line-height: 30px;">လျှောက်ထားသူသည် ဓာတ်အားသုံးစွဲခွင့် ရရှိပါက ဌာန၏ သတ်မှတ်ထားသော အခြားနေရာများသို့လည်း ချိတ်ဆက်လာပါက ခွင့်ပြုပေးမည်ဖြစ်ပြီး ကန့်ကွက်ရန် မရှိကြောင်း ဝန်ခံကတိပြုပါသည်။</p>
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
                    <a href="{{ route('tsf_meter_type_mdy') }}" class="waves-effect waves-light btn btn-rounded btn-info rr-accept disabled ">{{ __('lang.continue') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
