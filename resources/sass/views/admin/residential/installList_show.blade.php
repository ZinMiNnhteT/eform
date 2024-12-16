@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('residentialMeterCheckInstallList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body card-body-pb-div">

                @include('layouts.form-progressbar')

                <div class="container-fluid">
                    <div id="app_show" class="accordion" role="tablist" aria-multiselectable="true">

                        @include('layouts.user_apply_form')
                        
                    </div>
                    <div class="card mb-1">
                        @if (chk_userForm($data->id)['to_chk_install'])
                            @if (hasPermissions(['residentialChkInstall-create']))
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('မီတာတပ်ဆင်ရန်') }}</h5>
                        </div>
                        <div class="card-body mt-3">
                            <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5><br/>
                            {!! Form::open(['route' => 'residentialMeterCheckInstallList.store']) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            {{--  <div class="container">
                                <div class="row form-group mb-1">
                                    <label for="form_send_date" class="control-label l-h-35 text-md-right col-md-3">လျှောက်လွှာပေးပို့သည့်နေ့စွဲ</label>
                                    <div class="col-md-8">
                                        {!! Form::text('form_send_date', date('Y-m-d', strtotime($data->date)), ['id' => 'form_send_date', 'class' => 'form-control inner-form', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="form_get_date" class="control-label l-h-35 text-md-right col-md-3">လျှောက်လွှာရသည့်နေ့စွဲ</label>
                                    <div class="col-md-8">
                                        {!! Form::text('form_get_date', date('Y-m-d', strtotime($data->date)), ['id' => 'form_get_date', 'class' => 'form-control inner-form', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="date" class="control-label l-h-35 text-md-right col-md-3">နေ့စွဲ</label>
                                    <div class="col-md-8">
                                        {!! Form::text('date', null, ['id' => 'date', 'class' => 'form-control inner-form mydatepicker']) !!}
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
    
                            </div>  --}}
                            {{-- <h5 class="text-center text-info">မီတာတပ်ဆင်ပြီးပါပြီ</h5> --}}
                            <div class="row justify-content-center">
                                <div class="col-md-8 form-group mm">
                                    <label>မီတာတပ်ဆင်ပြီးသည့် နေ့  <span class="text-danger f-s-15">&#10039;</span></label>
                                    <input type="text" name="accept_date" class="form-control mydatepicker" placeholder="မီတာတပ်ဆင်ပြီးသည့် နေ့ ဖြည့်သွင်းရန်" required>
                                </div>
                            </div>
                            <div class="text-center mt-5">
                                <button type="submit" name="form138_submit" class="waves-effect waves-light btn btn-rounded btn-info">{{ __('lang.submit') }}</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
