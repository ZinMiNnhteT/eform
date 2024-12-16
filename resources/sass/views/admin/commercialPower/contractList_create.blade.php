@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title m-0 {{ lang() }}">{{ __('lang.'.$heading) }}</h5>
            </div>

            <div class="card-body mm">
                
                <p class="text-muted">လျှပ်စစ်ပုံစံ (၁၆)</p>
                <div class="container">
                    <h4 class="text-center">လျှပ်စစ်ဓာတ်အားဖြန့်ဖြူးရေးလုပ်ငန်း</h4>
                    <p class="text-center"><b>{{ township_mm($form->township_id) }}</b></p>
                    <p class="text-center"><b>လျှပ်စစ်ဓာတ်အားဆက်သွယ်ရန် လျှောက်လွှာနှင့် စာချုပ်ပုံစံ</b></p>
                    <div class="l-h-35">
                        <span class="p-l-40"></span><span class="p-l-40"></span>လျှပ်စစ်ဓာတ်အားဆက်သွယ်လိုပါ၍ လျှပ်စစ်ဓာတ်အားဖြန့်ဖြုးရေးလုပ်ငန်း၏ စည်းကမ်းများ၊ မြန်မာနိုင်ငံ တည်ဆဲလျှပ်စစ်ဥပဒေများအတိုင်း လိုက်နာကျင့်သုံးရန်နှင့် ဤလုပ်ငန်းသို့ ပေးရန်ရှိသောငွေများကို သတ်မှတ်ထားသော ရက်အတွင်း ပေးချေရန် လုံးဝတာဝန်ယူပါသည်။ အကယ်၍ ပျက်ကွက်ခဲ့ပါက ဤလုပ်ငန်း၏ ညွှန်ကြားချက်အတိုင်း လိုက်နာပါမည်။
                    </div>
                </div>

                {!! Form::open(['route' => 'commercialPowerMeterContractList.store']) !!}
                <div class="row mt-5">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fullname" class="mm">သုံးစွဲသူအမည်/အဖွဲ့အစည်း</label>
                            {!! Form::text('fullname', $form->fullname, ['id' => 'fullname', 'class' => 'form-control inner-form', 'readonly']) !!}
                        </div>
                        
                        <div class="form-group">
                            <label for="building_type" class="mm">အဆောက်အအုံ</label>
                            {!! Form::text('building_type', building_type($form->applied_building_type), ['id' => 'building_type', 'class' => 'form-control inner-form', 'readonly']) !!}
                        </div>
                        
                        <div class="form-group">
                            <label for="applied_address_16" class="mm">လျှပ်စစ်ဓါတ်အားဆက်သွယ်မည့်နေရာ</label>
                            {!! Form::textarea('applied_address', address_mm($form->id), ['id' => 'applied_address_16', 'class' => 'form-control inner-form', 'rows' => '4', 'readonly']) !!}
                        </div>
                        
                        <div class="form-group">
                            <label for="payment_address_16" class="mm">ငွေတောင်းခံလွှာပေးပို့ရမည့်နေရာ</label>
                            {!! Form::textarea('payment_address', payment_address_mm($form->id), ['id' => 'payment_address_16', 'class' => 'form-control inner-form', 'rows' => '4', 'readonly']) !!}
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="applied_type" class="mm">လျှပ်စစ်ဓါတ်အားဆက်သွယ်လိုသည့်ကိစ္စ အမျိုးအစား</label>
                            <select name="applied_type" class="form-control mm" id="type">
                                <option value="">ရွေးချယ်ရန်</option>
                                <option value="1">အသစ်</option>
                                <option value="2">တိုးချဲ့</option>
                                <option value="3">အမည်ပြောင်း</option>
                                <option value="4">ပြန်ဆက်</option>
                                <option value="5">မီတာခွဲ</option>
                                <option value="6">ယာယီ</option>
                            </select>
                        </div>

                        <div class="row date_type d-none">
                            <div class="form-group col-6">
                                <label for="from">မှ</label>
                                <input type="text" name="date_from" id="from" class="form-control mydatepicker" placeholder="yyyy-mm-dd">
                            </div>
                            <div class="form-group col-6">
                                <label for="to">ထိ</label>
                                <input type="text" name="date_to" id="to" class="form-control mydatepicker" placeholder="yyyy-mm-dd">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="elec_type" class="mm">လျှပ်စစ်ဓါတ်အားအမျိုးအစား</label>
                            <select name="elec_type" class="form-control mm">
                                <option value="">ရွေးချယ်ရန်</option>
                                <option value="1">၁ သွင် ၂ ကြိုး (single phase)</option>
                                <option value="2">၃ သွင် ၄ ကြိုး (three phase)</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="volt" class="mm">ဗို့</label>
                            {!! Form::text('volt', null, ['id' => 'volt', 'class' => 'form-control inner-form']) !!}
                        </div>
                        
                        <div class="form-group">
                            <label for="kilowatt" class="mm">ကီလိုဝပ်</label>
                            {!! Form::text('kilowatt', null, ['id' => 'kilowatt', 'class' => 'form-control inner-form']) !!}
                        </div>
                        
                        <div class="form-group">
                            <label for="why_to_use" class="mm">မည့်သည့်အတွက် သုံးစွဲလိုသည်</label>
                            {!! Form::textarea('why_to_use', null, ['id' => 'why_to_use', 'class' => 'form-control inner-form', 'rows' => '3']) !!}
                        </div>

                        <label><strong>အသစ်နှင့် ယာယီဆက်သွယ်ခြင်းအတွက် အနီး၌တဆင့်သွယ်နိုင်သည့် မီတာရှိပါက -</strong></label>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="temp_name" class="mm">၎င်းမီတာသုံးစွဲသူအမည်</label>
                                {!! Form::text('temp_name', null, ['id' => 'temp_name', 'class' => 'form-control inner-form']) !!}
                            </div>
                            <div class="form-group col-6">
                                <label for="temp_meter_no" class="mm">မီတာအမှတ်</label>
                                {!! Form::text('temp_meter_no', null, ['id' => 'temp_meter_no', 'class' => 'form-control inner-form']) !!}
                            </div>
                        </div>

                        <label><strong>အခြားကိစ္စများအတွက် -</strong></label>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="other_name" class="mm">ယခင်/ယခု သုံးစွဲသူအမည်</label>
                                {!! Form::text('other_name', null, ['id' => 'other_name', 'class' => 'form-control inner-form']) !!}
                            </div>
                            <div class="form-group col-6">
                                <label for="other_meter_no" class="mm">မီတာအမှတ်</label>
                                {!! Form::text('other_meter_no', null, ['id' => 'other_meter_no', 'class' => 'form-control inner-form']) !!}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="finance_no" class="mm">ငွေစာရင်းအမှတ်</label>
                            {!! Form::text('finance_no', null, ['id' => 'finance_no', 'class' => 'form-control inner-form']) !!}
                        </div>
                    </div>

                </div>

                <div class="row justify-content-between">
                    <div class="col-md-3 p-5 offset-md-2 text-center">
                        <div class="p-5 seal_div">
                            အဖွဲ့အစည်းတံဆိပ်
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row mb-2">
                            <label class="control-label l-h-35 text-md-right col-md-3 {{ lang() }}">လက်မှတ်</label>
                            <div class="col-md-9">
                                
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="name" class="control-label l-h-35 text-md-right col-md-3 {{ lang() }}">အမည်</label>
                            <div class="col-md-9">
                                {!! Form::text('name', null, ['id' => 'name', 'class' => 'form-control inner-form']) !!}
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="job" class="control-label l-h-35 text-md-right col-md-3 {{ lang() }}">ရာထူး/အလုပ်အကိုင်</label>
                            <div class="col-md-9">
                                {!! Form::text('job', null, ['id' => 'job', 'class' => 'form-control inner-form']) !!}
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="nrc" class="control-label l-h-35 text-md-right col-md-3 {{ lang() }}">အမျိုးသားမှတ်ပုံတင်အမှတ်</label>
                            <div class="col-md-9">
                                {!! Form::text('nrc', null, ['id' => 'nrc', 'class' => 'form-control inner-form']) !!}
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="date" class="control-label l-h-35 text-md-right col-md-3 {{ lang() }}">နေ့စွဲ</label>
                            <div class="col-md-9">
                                {!! Form::text('date', null, ['id' => 'date', 'class' => 'form-control inner-form mydatepicker']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row justify-content-center m-t-20 m-b-10">
                    <div class="col-3">
                        <a href="{{ url('commercialPowerMeterContractList') }}" class="btn btn-block btn-rounded btn-secondary {{ lang() }}">@lang('lang.cancel')</a>
                    </div>
                    <div class="col-3">
                        {!! Form::hidden('form_id', $form->id) !!}
                        <input type="submit" name="form_16_submit" value="@lang('lang.submit')" class="btn btn-block btn-rounded btn-info {{ lang() }}">
                    </div>
                </div>
                {!! Form::close() !!}
                    
            </div>
        </div>
    </div>
</div>

@endsection