@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <h4 class="text-center mm">လျှပ်စစ်စွမ်းအားဝန်ကြီးဌာန</h4>
                <h4 class="text-center mm">လျှပ်စစ်ဓါတ်အားဖြန့်ဖြူးရေးလုပ်ငန်း</h4>
                <p class="text-right p-r-40 mm">နေ့စွဲ။ {{ mmNum(date('d - m - Y')) }}</p>

                <div class="row justify-content-center mm">
                    <div class="col-8">
                        @if ($form->apply_type == 1)
                        <h5 class="text-center"><b>အိမ်သုံးမီတာ လျှောက်ထားခြင်းအတွက် ကျသင့်ငွေကောက်ခံခြင်း</b></h5>
                        @elseif ($form->apply_type == 2)
                        <h5 class="text-center"><b>အိမ်သုံးပါဝါမီတာ လျှောက်ထားခြင်းအတွက် ကျသင့်ငွေကောက်ခံခြင်း</b></h5>
                        @elseif ($form->apply_type == 3)
                        <h5 class="text-center"><b>လုပ်ငန်းသုံးမီတာ လျှောက်ထားခြင်းအတွက် ကျသင့်ငွေကောက်ခံခြင်း</b></h5>
                        @elseif ($form->apply_type == 4)
                        <h5 class="text-center"><b>ထရန်စဖော်မာ လျှောက်ထားခြင်းအတွက် ကျသင့်ငွေကောက်ခံခြင်း</b></h5>
                        @elseif ($form->apply_type == 5)
                        <h5 class="text-center"><b>ကန်ထရိုက်တိုက် မီတာလျှောက်ထားခြင်းအတွက် ကျသင့်ငွေကောက်ခံခြင်း</b></h5>
                        @endif
                        
                        <div class="user-info table-responsive bg-secondary m-b-20">
                            <table class="table no-border">
                                <tbody>
                                    <tr>
                                        <td>{{ __('lang.name') }}</td>
                                        <td>{{ $form->fullname }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.nrc') }}</td>
                                        <td>{{ $form->nrc }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.address') }}</td>
                                        <td>{{ address($form->id) }}</td>
                                    </tr>
                                    @if ($form->apply_type == 5)
                                    <tr>
                                        <td>{{ __('lang.meter_count') }}</td>
                                        <td>{{ confirm_contractor_meter_count($form->id) }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if ($form->apply_type == 1)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td>{{ __('lang.assign_fee') }}</td>
                                            <td class="text-right">{{ checkMM() === 'mm' ? mmNum(number_format($sub_type->assign_fee)) : number_format($sub_type->assign_fee) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('lang.deposit_fee') }}</td>
                                            <td class="text-right">
                                                {{ checkMM() === 'mm' ? mmNum(number_format($sub_type->deposit_fee)) : number_format($sub_type->deposit_fee) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('lang.registration_fee') }}</td>
                                            <td class="text-right">
                                                {{ checkMM() === 'mm' ? mmNum(number_format($sub_type->registration_fee)) : number_format($sub_type->registration_fee) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('lang.string_fee') }}</td>
                                            <td class="text-right">
                                                {{ checkMM() === 'mm' ? mmNum(number_format($sub_type->string_fee)) : number_format($sub_type->string_fee) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('lang.service_fee') }}</td>
                                            <td class="text-right">
                                                {{ checkMM() === 'mm' ? mmNum(number_format($sub_type->service_fee)) : number_format($sub_type->service_fee) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('lang.incheck_fee') }}</td>
                                            <td class="text-right">
                                                {{ checkMM() === 'mm' ? mmNum(number_format($sub_type->incheck_fee)) : number_format($sub_type->incheck_fee) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('lang.service_charges') }}</td>
                                            <td class="text-right">-</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{ __('lang.total') }}</strong></td>
                                            <td class="text-right">
                                                <strong>
                                                    @php $total = $sub_type->assign_fee + $sub_type->deposit_fee + $sub_type->registration_fee + $sub_type->string_fee + $sub_type->service_fee + $sub_type->incheck_fee;  @endphp
                                                    <p>{{ checkMM() === 'mm' ? mmNum(number_format($total)) : number_format($total) }}
                                                </strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @elseif ($form->apply_type == 2 || $form->apply_type == 3)
                            <div class="table-responsive">
                                <table class="table no-border">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-dark" colspan="2">
                                                <h4>ငွေတောင်းခံလွှာ</h4>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ __('lang.assign_fee') }}</td>
                                            <td class="text-right">{{ checkMM() === 'mm' ? mmNum(number_format($sub_type->assign_fee)) : number_format($sub_type->assign_fee) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('lang.deposit_fee') }}</td>
                                            <td class="text-right">{{ checkMM() === 'mm' ? mmNum(number_format($sub_type->deposit_fee)) : number_format($sub_type->deposit_fee) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('lang.registration_fee') }}</td>
                                            <td class="text-right">{{ checkMM() === 'mm' ? mmNum(number_format($sub_type->registration_fee)) : number_format($sub_type->registration_fee) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('lang.string_fee') }}</td>
                                            <td class="text-right">{{ checkMM() === 'mm' ? mmNum(number_format($sub_type->string_fee)) : number_format($sub_type->string_fee) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('lang.composit_box') }}</td>
                                            <td class="text-right">{{ checkMM() === 'mm' ? mmNum(number_format($sub_type->composit_box)) : number_format($sub_type->composit_box) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('lang.service_charges') }}</td>
                                            <td class="text-right">-</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{ __('lang.total') }}</strong></td>
                                            <td class="text-right">
                                                @php $total = $sub_type->assign_fee + $sub_type->deposit_fee + $sub_type->registration_fee + $sub_type->string_fee + $sub_type->composit_box;  @endphp
                                                <strong>
                                                {{ checkMM() === 'mm' ? mmNum(number_format($total)) : number_format($total) }}
                                                </strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @elseif ($form->apply_type == 4)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td>{{ __('lang.assign_fee') }}</td>
                                            <td class="text-right">{{ checkMM() === 'mm' ? mmNum(number_format($sub_type->assign_fee)) : number_format($sub_type->assign_fee) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('lang.deposit_fee') }}</td>
                                            <td class="text-right">
                                                {{ checkMM() === 'mm' ? mmNum(number_format($sub_type->deposit_fee)) : number_format($sub_type->deposit_fee) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('lang.registration_fee') }}</td>
                                            <td class="text-right">
                                                {{ checkMM() === 'mm' ? mmNum(number_format($sub_type->registration_fee)) : number_format($sub_type->registration_fee) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('lang.string_fee') }}</td>
                                            <td class="text-right">
                                                {{ checkMM() === 'mm' ? mmNum(number_format($sub_type->string_fee)) : number_format($sub_type->string_fee) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('lang.service_fee') }}</td>
                                            <td class="text-right">
                                                {{ checkMM() === 'mm' ? mmNum(number_format($sub_type->service_fee)) : number_format($sub_type->service_fee) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('lang.service_charges') }}</td>
                                            <td class="text-right">-</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{ __('lang.total') }}</strong></td>
                                            <td class="text-right">
                                                <strong>
                                                    @php $total = $sub_type->assign_fee + $sub_type->deposit_fee + $sub_type->registration_fee + $sub_type->string_fee + $sub_type->service_fee + $sub_type->incheck_fee;  @endphp
                                                    <p>{{ checkMM() === 'mm' ? mmNum(number_format($total)) : number_format($total) }}
                                                </strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @elseif ($form->apply_type == 5)
                            @php
                            $assign_sub_total = 550000 * $c_form->room_count;
                            $residential_sub_total = ($c_form->meter * 90000);
                            $power10_sub_total = ($c_form->pMeter10 * 846000);
                            $power20_sub_total = ($c_form->pMeter20 * 1046000);
                            $power30_sub_total = ($c_form->pMeter30 * 1246000);
                            $power_sub_total = (($c_form->pMeter10 * 846000) + ($c_form->pMeter20 * 1046000) + ($c_form->pMeter30 * 1246000));
                            $water_meter = $c_form->water_meter * 90000;
                            $elevator_meter = $c_form->elevator_meter * 846000;
                            $total = $assign_sub_total + $residential_sub_total + $power_sub_total + $water_meter + $elevator_meter;
                            @endphp
                            <div class="table-responsive">
                                <table class="table table-active">
                                    <thead>
                                        <tr>
                                            <th colspan="5" class="text-center"><strong>ငွေတောင်းခံလွှာ</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($c_form->room_count < 18)
                                        <tr>
                                            <td>{{ __('lang.c_deposit') }}</td>
                                            <td>{{ checkMM() === 'mm' ? mmNum(number_format(550000)).'/-' : number_format(550000).'MMK' }}</td>
                                            <td>&times;</td>
                                            <td> {{ checkMM() === 'mm' ? mmNum(number_format($c_form->room_count)) : number_format($c_form->room_count) }}</td>
                                            <td class="text-right">{{ checkMM() === 'mm' ? mmNum(number_format($assign_sub_total)).'/-' : number_format($assign_sub_total).'MMK' }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td>{{ __('lang.c_assign_fee') }}</td>
                                            <td>{{ checkMM() === 'mm' ? mmNum(number_format(90000)).'/-' : number_format(90000).'MMK' }}</td>
                                            <td>&times;</td>
                                            <td> {{ checkMM() === 'mm' ? mmNum(number_format($c_form->meter)) : number_format($c_form->meter) }}</td>
                                            <td class="text-right">{{ checkMM() === 'mm' ? mmNum(number_format($residential_sub_total)).'/-' : number_format($residential_sub_total).'MMK' }}</td>
                                        </tr>
                                        @if ($c_form->pMeter10 || $c_form->pMeter20 || $c_form->pMeter30)
                                            @if ($c_form->pMeter10)
                                        <tr>
                                            <td>{{ __('lang.c_assign_power_fee') }} ({{ __('lang.10kw') }})</td>
                                            <td>{{ checkMM() === 'mm' ? mmNum(number_format(846000)).'/-' : number_format(846000).'MMK' }}</td>
                                            <td>&times;</td>
                                            <td> {{ checkMM() === 'mm' ? mmNum(number_format($c_form->pMeter10)) : number_format($c_form->pMeter10) }}</td>
                                            <td class="text-right">{{ checkMM() === 'mm' ? mmNum(number_format($power10_sub_total)).'/-' : number_format($power10_sub_total).'MMK' }}</td>
                                        </tr>
                                            @elseif ($c_form->pMeter20)
                                        <tr>
                                            <td>{{ __('lang.c_assign_power_fee') }} ({{ __('lang.20kw') }})</td>
                                            <td>{{ checkMM() === 'mm' ? mmNum(number_format(846000)).'/-' : number_format(846000).'MMK' }}</td>
                                            <td>&times;</td>
                                            <td> {{ checkMM() === 'mm' ? mmNum(number_format($c_form->pMeter20)) : number_format($c_form->pMeter20) }}</td>
                                            <td class="text-right">{{ checkMM() === 'mm' ? mmNum(number_format($power20_sub_total)).'/-' : number_format($power20_sub_total).'MMK' }}</td>
                                        </tr>
                                            @elseif ($c_form->pMeter30)
                                        <tr>
                                            <td>{{ __('lang.c_assign_power_fee') }} ({{ __('lang.30kw') }})</td>
                                            <td>{{ checkMM() === 'mm' ? mmNum(number_format(846000)).'/-' : number_format(846000).'MMK' }}</td>
                                            <td>&times;</td>
                                            <td> {{ checkMM() === 'mm' ? mmNum(number_format($c_form->pMeter30)) : number_format($c_form->pMeter30) }}</td>
                                            <td class="text-right">{{ checkMM() === 'mm' ? mmNum(number_format($power30_sub_total)).'/-' : number_format($power30_sub_total).'MMK' }}</td>
                                        </tr>
                                            @endif
                                        @endif
                                        @if ($c_form->water_meter)
                                        <tr>
                                            <td>{{ __('ရေစက်မီတာ') }}</td>
                                            <td>{{ checkMM() === 'mm' ? mmNum(number_format(90000)).'/-' : number_format(90000).'MMK' }}</td>
                                            <td>&times;</td>
                                            <td> {{ checkMM() === 'mm' ? mmNum(number_format($c_form->water_meter)) : number_format($c_form->water_meter) }}</td>
                                            <td class="text-right">{{ checkMM() === 'mm' ? mmNum(number_format($water_meter)).'/-' : number_format($water_meter).'MMK' }}</td>
                                        </tr>
                                        @endif
                                        @if ($c_form->elevator_meter)
                                        <tr>
                                            <td>{{ __('ပါဝါမီတာ(ဓါတ်လှေကားအသုံးပြုရန်)') }}</td>
                                            <td>{{ checkMM() === 'mm' ? mmNum(number_format(846000)).'/-' : number_format(846000).'MMK' }}</td>
                                            <td>&times;</td>
                                            <td> {{ checkMM() === 'mm' ? mmNum(number_format($c_form->elevator_meter)) : number_format($c_form->elevator_meter) }}</td>
                                            <td class="text-right"> {{ checkMM() === 'mm' ? mmNum(number_format($elevator_meter)).'/-' : number_format($elevator_meter).'MMK' }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td colspan="4">{{ __('lang.service_charges') }}</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">{{ __('lang.total') }}</td>
                                            <td class="text-right"> {{ checkMM() === 'mm' ? mmNum(number_format($total)).'/-' : number_format($total).'MMK' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                
                {!! Form::open(['route' => 'user_pay_form.store', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                <div class="row justify-content-center mb-3 mt-3 mm">
                    <div class="col-md-6">
                        <div class="card border-primary">
                            <div class="card-header bg-primary">
                                <h4 class="m-b-0 text-white">{{ __('lang.online_alert_msg') }}</h4></div>
                            <div class="card-body">
                                <div class="chk-online-box">
                                    <div class="form-group row">
                                        <label for="cardnumber" class="control-label l-h-35 text-md-right col-md-3">
                                            Card Number
                                        </label>
                                        <div class="col-md-9">
                                            {!! Form::text('cardnumber', null, ['id' => 'cardnumber', 'class' => 'form-control inner-form','data-encrypt'=>'cardnumber','maxlength'=>'16','placeholder'=>'Credit Card Number']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cardinfo" class="control-label l-h-35 text-md-right col-md-3">
                                            Card Information
                                        </label>
                                        <div class="col-md-4">
                                            {!! Form::text('month', null, ['id' => 'cardinfo', 'class' => 'form-control inner-form','data-encrypt'=>'month','maxlength'=>'2','placeholder'=>'MM']) !!}
                                        </div>
                                        <div class="col-md-4">
                                            {!! Form::text('year', null, ['id' => 'cardinfo', 'class' => 'form-control inner-form','data-encrypt'=>'year','maxlength'=>'4','placeholder'=>'YYYY']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cardnumber" class="control-label l-h-35 text-md-right col-md-3">
                                            CVV2/CVC2
                                        </label>
                                        <div class="col-md-9">
                                            {!! Form::text('cardnumber', null, ['id' => 'cardnumber', 'class' => 'form-control inner-form','data-encrypt'=>'cvv','maxlength'=>'4','placeholder'=>'CVV2/CVC2','autocomplete'=>'off']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--  <div class="col-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="office_payment" class="custom-control-input" id="office_pay_chkbox">
                            <label for="office_pay_chkbox" class="custom-control-label p-l-20 custom-office"><strong>{{ __('lang.click_bank_payment') }}</strong></label>
                        </div>
                        <div class="form-group chk-office-box d-none">
                            <label for="office_pay_text">{{ __('lang.bank_receipt') }}</label>
                            <input type="file" name="office_pay" class="form-control" id="office_pay_text" accept=".jpg,.png">
                            <p class="text-danger f-s-10 mb-2">{{ __('lang.bank_receipt_alert_msg') }}</p>
                        </div>
                    </div>  --}}
                    {{--  <div class="col-4">  --}}
                        {{--  <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="online_payment" class="custom-control-input" id="online_pay_chkbox">
                            <label for="online_pay_chkbox" class="custom-control-label p-l-20 custom-online"><strong>{{ __('lang.click_online_payment') }}</strong></label>
                        </div>  --}}
                        
                    {{--  </div>  --}}
                </div>
                <hr/>
                <div class="text-center">
                    <input type="submit" name="survey_submit" value="{{ __('lang.do_payment') }}" class="btn btn-rounded btn-primary">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection