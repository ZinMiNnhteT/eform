@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('transformerPaymentList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body">
                <h4 class="text-center mm">လျှပ်စစ်စွမ်းအားဝန်ကြီးဌာန</h4>
                <h4 class="text-center mm">လျှပ်စစ်ဓါတ်အားဖြန့်ဖြူးရေးလုပ်ငန်း</h4>
                <p class="text-right p-r-40 mm">နေ့စွဲ။ {{ mmNum(date('d - m - Y')) }}</p>

                <div class="row justify-content-center mm">
                    <div class="col-8">
                        <h5 class="text-center"><b>ထရန်စဖော်မာ လျှောက်ထားခြင်းအတွက် ကျသင့်ငွေကောက်ခံခြင်း</b></h5>
                        <hr/>
                        <div class="form-group row mb-1">
                            <label class="control-label col-md-3">{{ __('lang.name') }}</label>
                            <div class="col-md-6">
                                <p>{{ $form->fullname }}</p>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label class="control-label col-md-3">{{ __('lang.nrc') }}</label>
                            <div class="col-md-6">
                                <p>{{ $form->nrc }}</p>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label class="control-label col-md-3">{{ __('lang.address') }}</label>
                            <div class="col-md-6">
                                <p>{{ address($form->id) }}</p>
                            </div>
                        </div>
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
                {!! Form::open(['route' => 'transformerPaymentList.store', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                <div class="text-center mb-3 mt-3 mm">
                    @if ($user_pay->payment_type == 1)
                    <p>{{ "Bank Receipt" }}</p>
                    <img src="{{ asset('storage/user_attachments/'.$form->id.'_'.$form->serial_code.'/'.$user_pay->files) }}" alt="{{ $user_pay->files }}" class="img-thumbnail">
                    @elseif ($user_pay->payment_type == 2)
                    {{ 'Online Payment' }}
                    @endif
                </div>
                <hr/>
                <div class="text-center">
                    <a href="{{ route('transformerPaymentList.index') }}" class="btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                    <input type="submit" name="confirm_pay_submit" value="{{ __('lang.approve') }}" class="btn btn-rounded btn-info">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection