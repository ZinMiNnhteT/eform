@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('contractorMeterPaymentList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body">
                <h4 class="text-center mm">လျှပ်စစ်စွမ်းအားဝန်ကြီးဌာန</h4>
                <h4 class="text-center mm">လျှပ်စစ်ဓါတ်အားဖြန့်ဖြူးရေးလုပ်ငန်း</h4>
                <p class="text-right p-r-40 mm">နေ့စွဲ။ {{ mmNum(date('d - m - Y')) }}</p>

                <div class="row justify-content-center mm">
                    <div class="col-8">
                        <h5 class="text-center"><b>ကန်ထရိုက်တိုက် မီတာလျှောက်ထားခြင်းအတွက် ကျသင့်ငွေကောက်ခံခြင်း</b></h5>
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
                        @if (isset($sub_type) && $sub_type->count() > 0)
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
                                <label class="control-label col-md-3">{{ __('lang.incheck_fee') }}</label>
                                <div class="col-md-6">
                                    <p>{{ checkMM() === 'mm' ? mmNum(number_format($sub_type->incheck_fee)) : number_format($sub_type->incheck_fee) }}</p>
                                </div>
                            </div>
                            <div class="form-group row mb-1">
                                <label class="control-label col-md-3">{{ __('lang.total') }}</label>
                                <div class="col-md-6">
                                    @php $total = $sub_type->assign_fee + $sub_type->deposit_fee + $sub_type->registration_fee + $sub_type->string_fee + $sub_type->service_fee + $sub_type->incheck_fee;  @endphp
                                    <p>{{ checkMM() === 'mm' ? mmNum(number_format($total)) : number_format($total) }}</p>
                                </div>
                            </div>
                            <div class="form-group row mb-1">
                                <label class="control-label col-md-3">{{ __('lang.service_charges') }}</label>
                                <div class="col-md-6">
                                    <p></p>
                                </div>
                            </div>
                        @elseif (isset($c_417) && $c_417)
                            @php
                                $assign_sub_total = 550000 * $c_form->room_count;
                                $residential_sub_total = ($c_form->meter * 90000);
                                $power_sub_total = (($c_form->pMeter10 * 846000) + ($c_form->pMeter20 * 1046000) + ($c_form->pMeter30 * 1246000));
                                $water_meter = $c_form->water_meter * 90000;
                                $elevator_meter = $c_form->elevator_meter * 846000;
                                $total = $assign_sub_total + $residential_sub_total + $power_sub_total + $water_meter + $elevator_meter;
                            @endphp
                            <div class="form-group row mb-1">
                                <label class="control-label col-md-3">{{ __('lang.room_count') }}</label>
                                <div class="col-md-6">
                                    <p>{{ contrator_meter_count($form->id) }}</p>
                                </div>
                            </div>

                            <div class="row justify-content-center mt-3">
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        <table class="table table-active">
                                            <tbody>
                                                <tr>
                                                    <td>{{ __('lang.c_deposit') }}</td>
                                                    <td>{{ checkMM() === 'mm' ? mmNum(number_format(550000)).'/-' : number_format(550000).'MMK' }}</td>
                                                    <td>&times; {{ checkMM() === 'mm' ? mmNum(number_format($c_form->room_count)) : number_format($c_form->room_count) }}</td>
                                                    <td>= {{ checkMM() === 'mm' ? mmNum(number_format($assign_sub_total)).'/-' : number_format($assign_sub_total).'MMK' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.c_assign_fee') }}</td>
                                                    <td>{{ checkMM() === 'mm' ? mmNum(number_format(90000)).'/-' : number_format(90000).'MMK' }}</td>
                                                    <td>&times; {{ checkMM() === 'mm' ? mmNum(number_format($c_form->meter)) : number_format($c_form->meter) }}</td>
                                                    <td>= {{ checkMM() === 'mm' ? mmNum(number_format($residential_sub_total)).'/-' : number_format($residential_sub_total).'MMK' }}</td>
                                                </tr>
                                                @if ($c_form->pMeter10 || $c_form->pMeter20 || $c_form->pMeter30)
                                                <tr>
                                                    <td>{{ __('lang.c_assign_power_fee') }}</td>
                                                    <td>{{ checkMM() === 'mm' ? mmNum(number_format(846000)).'/-' : number_format(846000).'MMK' }}</td>
                                                    <td>&times; {{ checkMM() === 'mm' ? mmNum(number_format($c_form->pMeter10 + $c_form->pMeter20 + $c_form->pMeter30)) : number_format($c_form->pMeter10 + $c_form->pMeter20 + $c_form->pMeter30) }}</td>
                                                    <td>= {{ checkMM() === 'mm' ? mmNum(number_format($power_sub_total)).'/-' : number_format($power_sub_total).'MMK' }}</td>
                                                </tr>
                                                @endif
                                                @if ($c_form->water_meter)
                                                <tr>
                                                    <td>{{ __('ရေစက်မီတာ') }}</td>
                                                    <td>{{ checkMM() === 'mm' ? mmNum(number_format(90000)).'/-' : number_format(90000).'MMK' }}</td>
                                                    <td>&times; {{ checkMM() === 'mm' ? mmNum(number_format($c_form->water_meter)) : number_format($c_form->water_meter) }}</td>
                                                    <td>= {{ checkMM() === 'mm' ? mmNum(number_format($water_meter)).'/-' : number_format($water_meter).'MMK' }}</td>
                                                </tr>
                                                @endif
                                                @if ($c_form->elevator_meter)
                                                <tr>
                                                    <td>{{ __('ပါဝါမီတာ') }}</td>
                                                    <td>{{ checkMM() === 'mm' ? mmNum(number_format(846000)).'/-' : number_format(846000).'MMK' }}</td>
                                                    <td>&times; {{ checkMM() === 'mm' ? mmNum(number_format($c_form->elevator_meter)) : number_format($c_form->elevator_meter) }}</td>
                                                    <td>= {{ checkMM() === 'mm' ? mmNum(number_format($elevator_meter)).'/-' : number_format($elevator_meter).'MMK' }}</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="3">{{ __('lang.service_charges') }}</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">{{ __('lang.total') }}</td>
                                                    <td>= {{ checkMM() === 'mm' ? mmNum(number_format($total)).'/-' : number_format($total).'MMK' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        @elseif (isset($c_18over) && $c_18over)
                            @php
                                $residential_sub_total = ($c_form->meter * 90000);
                                $power_sub_total = (($c_form->pMeter10 * 846000) + ($c_form->pMeter20 * 1046000) + ($c_form->pMeter30 * 1246000));
                                $water_meter = $c_form->water_meter * 90000;
                                $elevator_meter = $c_form->elevator_meter * 846000;
                                $total = $residential_sub_total + $power_sub_total + $water_meter + $elevator_meter;
                            @endphp
                            <div class="form-group row mb-1">
                                <label class="control-label col-md-3">{{ __('lang.room_count') }}</label>
                                <div class="col-md-6">
                                    <p>{{ contrator_meter_count($form->id) }}</p>
                                </div>
                            </div>

                            <div class="row justify-content-center mt-3">
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        <table class="table table-active">
                                            <tbody>
                                                <tr>
                                                    <td>{{ __('lang.c_assign_fee') }}</td>
                                                    <td>{{ checkMM() === 'mm' ? mmNum(number_format(90000)).'/-' : number_format(90000).'MMK' }}</td>
                                                    <td>&times; {{ checkMM() === 'mm' ? mmNum(number_format($c_form->meter)) : number_format($c_form->meter) }}</td>
                                                    <td>= {{ checkMM() === 'mm' ? mmNum(number_format($residential_sub_total)).'/-' : number_format($residential_sub_total).'MMK' }}</td>
                                                </tr>
                                                @if ($c_form->pMeter10 || $c_form->pMeter20 || $c_form->pMeter30)
                                                <tr>
                                                    <td>{{ __('lang.c_assign_power_fee') }}</td>
                                                    <td>{{ checkMM() === 'mm' ? mmNum(number_format(846000)).'/-' : number_format(846000).'MMK' }}</td>
                                                    <td>&times; {{ checkMM() === 'mm' ? mmNum(number_format($c_form->pMeter10 + $c_form->pMeter20 + $c_form->pMeter30)) : number_format($c_form->pMeter10 + $c_form->pMeter20 + $c_form->pMeter30) }}</td>
                                                    <td>= {{ checkMM() === 'mm' ? mmNum(number_format($power_sub_total)).'/-' : number_format($power_sub_total).'MMK' }}</td>
                                                </tr>
                                                @endif
                                                @if ($c_form->water_meter)
                                                <tr>
                                                    <td>{{ __('ရေစက်မီတာ') }}</td>
                                                    <td>{{ checkMM() === 'mm' ? mmNum(number_format(90000)).'/-' : number_format(90000).'MMK' }}</td>
                                                    <td>&times; {{ checkMM() === 'mm' ? mmNum(number_format($c_form->water_meter)) : number_format($c_form->water_meter) }}</td>
                                                    <td>= {{ checkMM() === 'mm' ? mmNum(number_format($water_meter)).'/-' : number_format($water_meter).'MMK' }}</td>
                                                </tr>
                                                @endif
                                                @if ($c_form->elevator_meter)
                                                <tr>
                                                    <td>{{ __('ပါဝါမီတာ') }}</td>
                                                    <td>{{ checkMM() === 'mm' ? mmNum(number_format(846000)).'/-' : number_format(846000).'MMK' }}</td>
                                                    <td>&times; {{ checkMM() === 'mm' ? mmNum(number_format($c_form->elevator_meter)) : number_format($c_form->elevator_meter) }}</td>
                                                    <td>= {{ checkMM() === 'mm' ? mmNum(number_format($elevator_meter)).'/-' : number_format($elevator_meter).'MMK' }}</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="3">{{ __('lang.service_charges') }}</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">{{ __('lang.total') }}</td>
                                                    <td>= {{ checkMM() === 'mm' ? mmNum(number_format($total)).'/-' : number_format($total).'MMK' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <hr/>

                    </div>
                </div>
                {!! Form::open(['route' => 'contractorMeterPaymentList.store', 'files' => true]) !!}
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
                    <a href="{{ route('contractorMeterPaymentList.index') }}" class="btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                    <input type="submit" name="confirm_pay_submit" value="{{ __('lang.submit') }}" class="btn btn-rounded btn-info">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection