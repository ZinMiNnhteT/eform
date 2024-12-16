@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('transformerCheckInstallList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>

            <div class="card-body mm">
                <p class="text-muted">လျှပ်စစ်ပုံစံ (၁၃၈)</p>
                <div class="container">
                    <h4 class="text-center">လျှပ်စစ်ဓာတ်အားဖြန့်ဖြူးရေးလုပ်ငန်း</h4>
                    <p class="text-center"><b>{{ township_mm($form->township_id) }}</b></p>
                    <p class="text-center"><b>လုပ်ငန်းကုန်ကျစရိတ်တွက်ခြင်းနှင့် လုပ်ငန်းဆောင်ရွက်ရန် ညွှန်ကြားခြင်း</b></p>
                </div>
                {!! Form::open(['route' => 'transformerCheckInstallList.store']) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                <div class="container">

                    <div class="row form-group mb-1">
                        <label for="date" class="control-label l-h-35 text-md-right col-md-3">နေ့စွဲ</label>
                        <div class="col-md-8">
                            {!! Form::text('date', null, ['id' => 'date', 'class' => 'form-control inner-form mydatepicker']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="serial" class="control-label l-h-35 text-md-right col-md-3">လျှောက်လွှာအမှတ်</label>
                        <div class="col-md-8">
                            {!! Form::text('serial', $form->serial_code, ['id' => 'serial', 'class' => 'form-control inner-form', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="fullname" class="control-label l-h-35 text-md-right col-md-3">သုံးစွဲသူအမည်/အဖွဲ့အစည်း</label>
                        <div class="col-md-8">
                            {!! Form::text('fullname', $form->fullname, ['id' => 'fullname', 'class' => 'form-control inner-form', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="applied_address" class="control-label l-h-35 text-md-right col-md-3">လျှပ်စစ်ဓါတ်အားဆက်သွယ်မည့်နေရာ</label>
                        <div class="col-md-8">
                            {!! Form::textarea('applied_address', address($form->id), ['id' => 'applied_address', 'class' => 'form-control inner-form', 'rows' => '3', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="form_send_date" class="control-label l-h-35 text-md-right col-md-3">လျှောက်လွှာပေးပို့သည့်နေ့စွဲ</label>
                        <div class="col-md-8">
                            {!! Form::text('form_send_date', date('Y-m-d', strtotime($form->date)), ['id' => 'form_send_date', 'class' => 'form-control inner-form', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="form_get_date" class="control-label l-h-35 text-md-right col-md-3">လျှောက်လွှာရသည့်နေ့စွဲ</label>
                        <div class="col-md-8">
                            {!! Form::text('form_get_date', date('Y-m-d', strtotime($form->date)), ['id' => 'form_get_date', 'class' => 'form-control inner-form', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="description" class="control-label l-h-35 text-md-right col-md-3">အကြောင်းအရာ</label>
                        <div class="col-md-8">
                            {!! Form::textarea('description', null, ['id' => 'description', 'class' => 'form-control inner-form', 'rows' => '2']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="cash_kyat" class="control-label l-h-35 text-md-right col-md-3">တောင်းသင့်ငွေ</label>
                        <div class="col-md-8">
                            {!! Form::number('cash_kyat', null, ['id' => 'cash_kyat', 'class' => 'form-control inner-form', 'placeholder' => __('lang.by_english')]) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="calculator" class="control-label l-h-35 text-md-right col-md-3">တွက်ချက်သူ</label>
                        <div class="col-md-8">
                            {!! Form::text('calculator', null, ['id' => 'calculator', 'class' => 'form-control inner-form']) !!}
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="calcu_date" class="control-label l-h-35 text-md-right col-md-3">နေ့စွဲ</label>
                        <div class="col-md-8">
                            {!! Form::text('calcu_date', null, ['id' => 'calcu_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="payment_form_no" class="control-label l-h-35 text-md-right col-md-3">ငွေသွင်းရန်အကြောင်းကြားစာအမှတ်</label>
                        <div class="col-md-8">
                            {!! Form::text('payment_form_no', null, ['id' => 'payment_form_no', 'class' => 'form-control inner-form']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="payment_form_date" class="control-label l-h-35 text-md-right col-md-3">နေ့စွဲ</label>
                        <div class="col-md-8">
                            {!! Form::text('payment_form_date', null, ['id' => 'payment_form_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="deposite_form_no" class="control-label l-h-35 text-md-right col-md-3">အာမခံစဘော်ငွေပြေစာအမှတ်</label>
                        <div class="col-md-8">
                            {!! Form::text('deposite_form_no', null, ['id' => 'deposite_form_no', 'class' => 'form-control inner-form']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="deposite_form_date" class="control-label l-h-35 text-md-right col-md-3">နေ့စွဲ</label>
                        <div class="col-md-8">
                            {!! Form::text('deposite_form_date', null, ['id' => 'deposite_form_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="somewhat" class="control-label l-h-35 text-md-right col-md-3">၎င်း</label>
                        <div class="col-md-8">
                            {!! Form::text('somewhat', null, ['id' => 'somewhat', 'class' => 'form-control inner-form']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="somewhat_form_date" class="control-label l-h-35 text-md-right col-md-3">နေ့စွဲ</label>
                        <div class="col-md-8">
                            {!! Form::text('somewhat_form_date', null, ['id' => 'somewhat_form_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="string_form_no" class="control-label l-h-35 text-md-right col-md-3">ကြိုးသွယ်ခနှင့် ဆက်ခပြေစာအမှတ်</label>
                        <div class="col-md-8">
                            {!! Form::text('string_form_no', null, ['id' => 'string_form_no', 'class' => 'form-control inner-form']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="string_form_date" class="control-label l-h-35 text-md-right col-md-3">နေ့စွဲ</label>
                        <div class="col-md-8">
                            {!! Form::text('string_form_date', null, ['id' => 'string_form_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="service_string_form_date" class="control-label text-md-right col-md-3">လျှပ်စစ်ဓါတ်ကြိုးတပ်ဆင်ခနှင့် ကြီးကြပ်ခပေးဆောင်သည့် နေ့စွဲ</label>
                        <div class="col-md-8">
                            {!! Form::text('service_string_form_date', null, ['id' => 'service_string_form_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                        </div>
                    </div>

                </div>
                <div class="text-center mt-5">
                    <a href="{{ route('transformerCheckInstallList.index') }}" class="btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                    <input type="submit" name="form138_submit" value="{{ __('lang.submit') }}" class="btn btn-rounded btn-info">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection