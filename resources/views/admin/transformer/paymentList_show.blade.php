@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('transformerPaymentList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body card-body-pb-div">

                @include('layouts.form-progressbar')

                <div class="container-fluid">
                    <div id="app_show" class="accordion" role="tablist" aria-multiselectable="true">
                        
                        @include('layouts.user_apply_form')

                    </div>
                    @if (chk_userForm($data->id)['to_confirm_pay'])
                        @if (hasPermissions(['transformerConfirmPayment-create']))
                    <div class="card mb-1">
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('ငွေသွင်းလက်ခံရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center mm">
                                <div class="col-8">
                                    <div class="form-group row mb-1">
                                        <label class="control-label col-md-3">{{ __('lang.assign_fee') }}</label>
                                        <div class="col-md-6">
                                            <p>{{ checkMM() === 'mm' ? mmNum(number_format($sub_type->assign_fee)) : number_format($sub_type->assign_fee) }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-1">
                                        <label class="control-label col-md-3">{{ __('lang.deposit_fee') }}</label>
                                        <div class="col-md-6">
                                            <p>{{ checkMM() === 'mm' ? mmNum(number_format($sub_type->deposit_fee)) : number_format($sub_type->deposit_fee) }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-1">
                                        <label class="control-label col-md-3">{{ __('lang.registration_fee') }}</label>
                                        <div class="col-md-6">
                                            <p>{{ checkMM() === 'mm' ? mmNum(number_format($sub_type->registration_fee)) : number_format($sub_type->registration_fee) }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-1">
                                        <label class="control-label col-md-3">{{ __('lang.string_fee') }}</label>
                                        <div class="col-md-6">
                                            <p>{{ checkMM() === 'mm' ? mmNum(number_format($sub_type->string_fee)) : number_format($sub_type->string_fee) }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-1">
                                        <label class="control-label col-md-3">{{ __('lang.service_fee') }}</label>
                                        <div class="col-md-6">
                                            <p>{{ checkMM() === 'mm' ? mmNum(number_format($sub_type->service_fee)) : number_format($sub_type->service_fee) }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-1">
                                        <label class="control-label col-md-3">{{ __('lang.service_charges') }}</label>
                                        <div class="col-md-6">
                                            {{--  <p>{{ checkMM() === 'mm' ? mmNum(number_format()) : number_format() }}</p>  --}}
                                            <p>-</p>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-1">
                                        <label class="control-label col-md-3">{{ __('lang.total') }}</label>
                                        <div class="col-md-6">
                                            @php $total = $sub_type->assign_fee + $sub_type->deposit_fee + $sub_type->registration_fee + $sub_type->string_fee + $sub_type->service_fee + $sub_type->incheck_fee;  @endphp
                                            <p>{{ checkMM() === 'mm' ? mmNum(number_format($total)) : number_format($total) }}</p>
                                        </div>
                                    </div>

                                    <hr/>

                                </div>
                            </div>
                            <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5><br/>
                            {!! Form::open(['route' => 'transformerPaymentList.store', 'files' => true]) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <div class="row justify-content-center">
                                <div class="col-md-8 form-group mm">
                                    <label>ငွေသွင်းလက်ခံသည့် နေ့ <span class="text-danger f-s-15">&#10039;</span></label>
                                    <input required type="text" name="accept_date" class="form-control mydatepicker" placeholder="ငွေသွင်းလက်ခံသည့် နေ့ ဖြည့်သွင်းရန်">
                                </div>

                                <div class="col-md-8 form-group mm">
                                    <label>ပြေစာအမှတ်<span class="text-danger f-s-15">&#10039;</span></label>
                                    <input required type="text" name="payment_accepted_slip_nos" class="form-control" placeholder="ပြေစာအမှတ်">
                                </div>

                                <div class="col-md-8 form-group mm">
                                    <div class="form-group">
                                        <label for="payment_accepted_slips" class="text-info">{{ __('ပြေစာဖြတ်ပိုင်းများတွဲရန်') }}</label><br>
                                        <input type="file" name="payment_accepted_slips[]" id="payment_accepted_slips" accept=".jpg,.png,.pdf" multiple/>
                                        <p class="px-1 py-1 text-danger text-capitalize mm">ပုံများကို တပြိုင်နက်ထဲ ရွေးချယ်တင်နိုင်ပါသည်။</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-8 text-center">
                                    <input type="submit" name="confirm_pay_submit" value="{{ __('lang.approve') }}" class="btn btn-rounded btn-info">
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
