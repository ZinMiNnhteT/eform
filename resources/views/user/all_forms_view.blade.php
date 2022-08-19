@extends('layouts.app')

@section('content')

    <div class="card-deck mb-5">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="card-title text-center text-white m-0">{{ __('lang.ygn_meter_apply') }}</h4>
            </div>
            <div class="card-body">
                {{--  <p class="text-danger text-center"><i class="fa fa-exclamation-circle fa-fw"></i> {{ 'Coming Soon!' }}</p>  --}}
                <ul class="list-unstyled ygn-meter-list">
                    <a href="{{ route('resident_rule_regulation_ygn') }}"><li class="meter-list-item">
                        <i class="fa fa-home m-r-20 text-primary"></i> {{ __('lang.residential_meter_apply') }}
                        <span class="mytooltip tooltip-effect-4 m-l-20"> <span class="tooltip-item"><i class="fa fa-info text-danger"></i></span> <span class="tooltip-content clearfix"> <span class="tooltip-text bg-secondary text-dark">
                            <ul><span class="text-primary">{{__('lang.residential_meter_requirement')}}</span>
                                <li>{{__('lang.nrc_card')}}</li>
                                <li>{{__('lang.form10')}}</li>
                                <li>{{__('lang.owner')}}</li>
                                <li>{{__('lang.noinvade_letter')}}</li>
                                <li>{{__('lang.occupy_letter')}}</li>
                                <li>{{__('lang.farmland_permit')}}</li>
                                <li>{{__('lang.building_photo')}}</li>
                                <li>{{__('lang.applied_electricpower_photo')}}</li>
                            </ul>
                            </span> </span> </span>
                    </li></a>
                    <a href="{{route('resident_power_rule_regulation_ygn')}}"><li class="meter-list-item">
                        <i class="fa fa-building-o m-r-20 text-primary"></i> {{ __('lang.residential_power_meter_apply') }}
                        <span class="mytooltip tooltip-effect-4 m-l-20"> <span class="tooltip-item"><i class="fa fa-info text-danger"></i></span> <span class="tooltip-content clearfix"> <span class="tooltip-text bg-secondary text-dark">
                            <ul><span class="text-primary">{{__('lang.residential_pmeter_requirement')}}</span>
                                <li>{{__('lang.nrc_card')}}</li>
                                <li>{{__('lang.form10')}}</li>
                                <li>{{__('lang.owner')}}</li>
                                <li>{{__('lang.noinvade_letter')}}</li>
                                <li>{{__('lang.occupy_letter')}}</li>
                                <li>{{__('lang.applied_electricpower_photo')}}</li>
                                <li>{{__('lang.prev_bill2')}}</li>
                                <li>{{__('lang.farmland_permit')}}</li>
                                <li>{{__('lang.building_photo')}}</li>
                            </ul>
                            </span> </span> </span>
                    </li></a>
                    <a href="{{route('commercial_rule_regulation_ygn')}}"><li class="meter-list-item">
                        <i class="fa fa-industry m-r-20 text-primary"></i> {{ __('lang.commercial_power_meter_apply') }}
                        <span class="mytooltip tooltip-effect-4 m-l-20"> <span class="tooltip-item"><i class="fa fa-info text-danger"></i></span> <span class="tooltip-content clearfix"> <span class="tooltip-text bg-secondary text-dark">
                            <ul><span class="text-primary">{{__('lang.commercial_pmeter_requirement')}}</span>
                                <li>{{__('lang.nrc_card')}}</li>
                                <li>{{__('lang.form10')}}</li>
                                <li>{{__('lang.owner')}}</li>
                                <li>{{__('lang.noinvade_letter')}}</li>
                                <li>{{__('lang.occupy_letter')}}</li>
                                <li>{{__('lang.applied_transactionlicence_photo')}}</li>
                                <li>{{__('lang.applied_electricpower_photo')}}</li>
                                <li>{{__('lang.prev_bill2')}}</li>
                                <li>{{__('lang.farmland_permit')}}</li>
                                <li>{{__('lang.building_photo')}}</li>
                            </ul>
                            </span> </span> </span>
                    </li></a>
                    <a href="{{ route('contract_rule_regulation_ygn') }}"><li class="meter-list-item">
                        <i class="fa fa-building m-r-20 text-primary"></i> {{ __('lang.contractor_meter_apply') }}
                        <span class="mytooltip tooltip-effect-4 m-l-20"> <span class="tooltip-item"><i class="fa fa-info text-danger"></i></span> <span class="tooltip-content clearfix"> <span class="tooltip-text bg-secondary text-dark">
                            <ul><span class="text-primary">{{__('lang.contractor_meter_requirement')}}</span>
                                <li>{{__('lang.nrc_card')}}</li>
                                <li>{{__('lang.form10')}}</li>
                                <li>{{__('lang.owner')}}</li>
                                <li>{{__('lang.noinvade_letter')}}</li>
                                <li>{{__('lang.occupy_letter')}}</li>
                                <li>{{__('lang.permit')}}</li>
                                <li>{{__('lang.bcc')}}</li>
                                <li>{{__('lang.dc_recomm')}}</li>
                                <li>{{__('lang.prev_bill')}}</li>
                                <li>{{__('lang.farmland_permit')}}</li>
                                <li>{{__('lang.building_photo')}}</li>
                                <li>{{__('lang.bq_photo')}}</li>
                                <li>{{__('lang.drawing_photo')}}</li>
                                <li>{{__('lang.map_photo')}}</li>
                            </ul>
                            <p class="m-t-10">
                            ကန်ထရိုက်တိုက်မီတာလျှောက်ထားရာတွင် (၄) ခန်း မှ (၁၇) ခန်းအတွင်း ဖြစ်ပါက
                            မီတာတစ်လုံးစီအတွက် မီတာကြေး <span class="text-danger">(၉၀,၀၀၀ ကျပ်)</span> နှင့် သက်မှတ်ကြေး <span class="text-danger">(၅၅၀,၀၀၀ ကျပ်)</span> ပေးဆောင်ရမည် ဖြစ်ပါသည်။
                            </p>
                            <p>
                            ကန်ထရိုက်တိုက်မီတာလျှောက်ထားရာတွင် (၁၈) ခန်းနှင့်အထက် ဖြစ်ပါက ကိုယ်ပိုင်ထရန်စဖေါ်မာ တည်ဆောက်ရန်လိုအပ်ပြီး၊               မီတာတစ်လုံးစီအတွက် မီတာကြေး <span class="text-danger">(၉၀,၀၀၀ ကျပ်)</span> ပေးဆောင်ရမည် ဖြစ်ပါသည်။
                            </p>
                            </span> </span> </span>
                    </li></a>
                    <a href="{{ route('tsf_rule_regulation_ygn') }}"><li class="meter-list-item">
                        <i class="fa fa-bolt m-r-20 text-primary"></i> {{ __('lang.home_transformer_apply') }}
                        <span class="mytooltip tooltip-effect-4 m-l-20"> <span class="tooltip-item"><i class="fa fa-info text-danger"></i></span> <span class="tooltip-content clearfix"> <span class="tooltip-text bg-secondary text-dark">
                            <ul><span class="text-primary">{{__('lang.transformer_requirement')}}</span>
                                <li>{{__('lang.nrc_card')}}</li>
                                <li>{{__('lang.form10')}}</li>
                                <li>{{__('lang.owner')}}</li>
                                <li>{{__('lang.noinvade_letter')}}</li>
                                <li>{{__('lang.occupy_letter')}}</li>
                                <li>{{__('lang.applied_electricpower_photo')}}</li>
                                {{-- <li>{{ __('lang.if_for_commercial') }} {{__('lang.applied_transactionlicence_photo')}}</li> --}}
                                <li>{{__('lang.dc_recomm')}}</li>
                                <li>{{__('lang.farmland_permit')}}</li>
                                <li>{{__('lang.industry_zone')}}</li>
                            </ul>
                            </span> </span> </span>
                    </li></a>
                    {{-- *** လုပ်ငန်းသုံး transformer --}}
                    <a href="{{ route('commercial_tsf_rule_regulation_ygn') }}"><li class="meter-list-item">
                        <i class="fa fa-bolt m-r-20 text-primary"></i> {{ __('lang.commercial_transformer_apply') }}
                        <span class="mytooltip tooltip-effect-4 m-l-20"> <span class="tooltip-item"><i class="fa fa-info text-danger"></i></span> <span class="tooltip-content clearfix"> <span class="tooltip-text bg-secondary text-dark">
                            <ul><span class="text-primary">{{__('lang.transformer_requirement')}}</span>
                                <li>{{__('lang.nrc_card')}}</li>
                                <li>{{__('lang.form10')}}</li>
                                <li>{{__('lang.owner')}}</li>
                                <li>{{__('lang.noinvade_letter')}}</li>
                                <li>{{__('lang.occupy_letter')}}</li>
                                <li>{{__('lang.applied_electricpower_photo')}}</li>
                                <li>{{__('lang.applied_transactionlicence_photo')}}</li>
                                <li>{{__('lang.dc_recomm')}}</li>
                                <li>{{__('lang.farmland_permit')}}</li>
                                <li>{{__('lang.industry_zone')}}</li>
                            </ul>
                            </span> </span> </span>
                    </li></a>
                    <a href="#"><li class="meter-list-item">
                        <i class="fa fa-superpowers m-r-20 text-primary"></i> {{ __('lang.village_meter_apply') }}
                        <span class="mytooltip tooltip-effect-4 m-l-20"> <span class="tooltip-item"><i class="fa fa-info text-danger"></i></span> <span class="tooltip-content clearfix"> <span class="tooltip-text bg-secondary text-dark">
                            <ul><span class="text-primary">{{__('lang.village_requirement')}}</span>
                                <li>{{__('lang.nrc_card')}}</li>
                                <li>{{__('lang.form10')}}</li>
                                <li>{{__('lang.owner')}}</li>
                                <li>{{__('lang.noinvade_letter')}}</li>
                                <li>{{__('lang.occupy_letter')}}</li>
                                <li>{{__('lang.applied_electricpower_photo')}}</li>
                                <li>{{__('lang.applied_transactionlicence_photo')}}</li>
                            </ul>
                            </span> </span> </span>
                    </li></a>
                </ul>
                {{-- <div class="text-center">
                    <a href="{{ route('resident_app_ygn') }}" class="btn waves-effect waves-light btn-rounded btn-primary text-white">{{ __('lang.apply') }}</a>
                </div> --}}
            </div>
        </div>
        {{-- <div class="card">
            <div class="card-header bg-primary">
                <h4 class="card-title text-center text-white">{{ __('lang.mdy_meter_apply') }}</h4>
            </div>
            <div class="card-body">
                <p class="text-danger text-center"><i class="fa fa-exclamation-circle fa-fw"></i> {{ 'Coming Soon!' }}</p>
                <div class="text-center">
                    <a href="" class="btn waves-effect waves-light btn-rounded btn-primary text-white disabled">{{ __('lang.apply') }}</a>
                </div>
            </div>
        </div> --}}
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="card-title text-center text-white m-0">{{ __('lang.mdy_meter_apply') }}</h4>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mdy-meter-list">
                    <a href="{{ route('resident_rule_regulation_mdy') }}"><li class="meter-list-item">
                    <i class="fa fa-home m-r-20 text-info"></i> {{ __('lang.residential_meter_apply') }}
                    <span class="mytooltip tooltip-effect-4 m-l-20"> <span class="tooltip-item"><i class="fa fa-info text-danger"></i></span> <span class="tooltip-content clearfix"> <span class="tooltip-text bg-secondary text-dark">
                            <ul><span class="text-primary">{{__('lang.residential_meter_requirement')}}</span>
                                <li>{{__('lang.nrc_card')}}</li>
                                <li>{{__('lang.form10')}}</li>
                                <li>{{__('lang.owner')}}</li>
                                <li>{{__('lang.noinvade_letter')}}</li>
                                <li>{{__('lang.occupy_letter')}}</li>
                            </ul>
                            </span> </span> </span>
                    </li></a>
                    <a href="{{ route('resident_power_rule_regulation_mdy') }}"><li class="meter-list-item">
                        <i class="fa fa-building-o m-r-20 text-info"></i> {{ __('lang.residential_power_meter_apply') }}
                        <span class="mytooltip tooltip-effect-4 m-l-20"> <span class="tooltip-item"><i class="fa fa-info text-danger"></i></span> <span class="tooltip-content clearfix"> <span class="tooltip-text bg-secondary text-dark">
                            <ul><span class="text-primary">{{__('lang.residential_pmeter_requirement')}}</span>
                                <li>{{__('lang.nrc_card')}}</li>
                                <li>{{__('lang.form10')}}</li>
                                <li>{{__('lang.owner')}}</li>
                                <li>{{__('lang.noinvade_letter')}}</li>
                                <li>{{__('lang.occupy_letter')}}</li>
                                {{-- <li>{{__('lang.applied_electricpower_photo')}}</li> --}}
                            </ul>
                            </span> </span> </span>
                    </li></a>
                    <a href="{{ route('commercial_rule_regulation_mdy') }}"><li class="meter-list-item">
                        <i class="fa fa-industry m-r-20 text-info"></i> {{ __('lang.commercial_power_meter_apply') }}
                        <span class="mytooltip tooltip-effect-4 m-l-20"> <span class="tooltip-item"><i class="fa fa-info text-danger"></i></span> <span class="tooltip-content clearfix"> <span class="tooltip-text bg-secondary text-dark">
                            <ul><span class="text-primary">{{__('lang.commercial_pmeter_requirement')}}</span>
                                <li>{{__('lang.nrc_card')}}</li>
                                <li>{{__('lang.form10')}}</li>
                                <li>{{__('lang.owner')}}</li>
                                <li>{{__('lang.noinvade_letter')}}</li>
                                <li>{{__('lang.occupy_letter')}}</li>
                                <li>{{__('lang.applied_transactionlicence_photo')}}</li>
                                <li>{{__('lang.city_license')}}</li>
                                <li>{{__('lang.ministry_permit')}}</li>
                            </ul>
                            </span> </span> </span>
                    </li></a>
                    <a href="{{ route('contract_rule_regulation_mdy') }}"><li class="meter-list-item">
                        <i class="fa fa-building m-r-20 text-info"></i> {{ __('lang.contractor_meter_apply') }}
                        <span class="mytooltip tooltip-effect-4 m-l-20"> <span class="tooltip-item"><i class="fa fa-info text-danger"></i></span> <span class="tooltip-content clearfix"> <span class="tooltip-text bg-secondary text-dark">
                            <ul><span class="text-primary">{{__('lang.contractor_meter_requirement')}}</span>
                                <li>{{__('lang.nrc_card')}}</li>
                                <li>{{__('lang.form10')}}</li>
                                <li>{{__('lang.owner')}}</li>
                                <li>{{__('lang.noinvade_letter')}}</li>
                                <li>{{__('lang.occupy_letter')}}</li>
                                <li>{{__('lang.permit')}}</li>
                                <li>{{__('lang.bcc')}}</li>
                                <li>{{__('lang.dc_recomm_photo')}}</li>
                                <li>{{__('lang.prev_bill_photo')}}</li>
                            </ul>
                            <p>
                            ကန်ထရိုက်တိုက်မီတာလျှောက်ထားရာတွင် ထရန်စဖေါ်မာတည်ဆောက်ရန် လိုအပ်ပါက ကန်ထရိုက်တာ (သို့) အိမ်ပိုင်ရှင်မှ တည်ဆောက်ပေးရမည် ဖြစ်ပါသည်။
                            </p>
                            </span> </span> </span>
                    </li></a>
                    <a href="{{ route('tsf_rule_regulation_mdy') }}"><li class="meter-list-item">
                        <i class="fa fa-bolt m-r-20 text-info"></i> {{ __('lang.transformer_apply') }}
                        <span class="mytooltip tooltip-effect-4 m-l-20"> <span class="tooltip-item"><i class="fa fa-info text-danger"></i></span> <span class="tooltip-content clearfix"> <span class="tooltip-text bg-secondary text-dark">
                            <ul><span class="text-primary">{{__('lang.transformer_requirement')}}</span>
                                <li>{{__('lang.nrc_card')}}</li>
                                <li>{{__('lang.form10')}}</li>
                                <li>{{__('lang.owner')}}</li>
                                <li>{{__('lang.noinvade_letter')}}</li>
                                <li>{{__('lang.occupy_letter')}}</li>
                                {{-- <li>{{__('lang.applied_electricpower_photo')}}</li> --}}
                                <li> {{__('lang.if_for_commercial')}} {{__('lang.applied_transactionlicence_photo')}}</li>
                            </ul>
                            </span> </span> </span>
                    </li></a>
                    <a href="#"><li class="meter-list-item">
                        <i class="fa fa-superpowers m-r-20 text-info"></i> {{ __('lang.village_meter_apply') }}
                        <span class="mytooltip tooltip-effect-4 m-l-20"> <span class="tooltip-item"><i class="fa fa-info text-danger"></i></span> <span class="tooltip-content clearfix"> <span class="tooltip-text bg-secondary text-dark">
                            <ul><span class="text-primary">{{__('lang.village_requirement')}}</span>
                                <li>{{__('lang.nrc_card')}}</li>
                                <li>{{__('lang.form10')}}</li>
                                <li>{{__('lang.owner')}}</li>
                                <li>{{__('lang.noinvade_letter')}}</li>
                                <li>{{__('lang.occupy_letter')}}</li>
                                <li>{{__('lang.applied_electricpower_photo')}}</li>
                                <li>{{__('lang.applied_transactionlicence_photo')}}</li>
                            </ul>
                            </span> </span> </span>
                    </li></a>
                </ul>
                {{--  <p class="text-danger text-center"><i class="fa fa-exclamation-circle fa-fw"></i> {{ 'Coming Soon!' }}</p>  --}}
                {{-- <div class="text-center">
                    <a href="{{ route('resident_app') }}" class="btn waves-effect waves-light btn-rounded btn-primary text-white">{{ __('lang.apply') }}</a>
                </div> --}}
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-success">
                <h4 class="card-title text-center text-white m-0">{{ __('lang.other_meter_apply') }}</h4>
            </div>
            <div class="card-body">
                <ul class="list-unstyled other-meter-list">
                    <a href="{{ route('resident_rule_regulation') }}"><li class="meter-list-item">
                    <i class="fa fa-home m-r-20 text-success"></i> {{ __('lang.residential_meter_apply') }}
                    <span class="mytooltip tooltip-effect-4 m-l-20"> <span class="tooltip-item"><i class="fa fa-info text-danger"></i></span> <span class="tooltip-content clearfix"> <span class="tooltip-text bg-secondary text-dark">
                            <ul><span class="text-primary">{{__('lang.residential_meter_requirement')}}</span>
                                <li>{{__('lang.nrc_card')}}</li>
                                <li>{{__('lang.form10')}}</li>
                                <li>{{__('lang.owner')}}</li>
                                <li>{{__('lang.noinvade_letter')}}</li>
                                <li>{{__('lang.occupy_letter')}}</li>
                            </ul>
                            </span> </span> </span>
                    </li></a>
                    <a href="{{ route('resident_power_rule_regulation') }}"><li class="meter-list-item">
                        <i class="fa fa-building-o m-r-20 text-success"></i> {{ __('lang.residential_power_meter_apply') }}
                        <span class="mytooltip tooltip-effect-4 m-l-20"> <span class="tooltip-item"><i class="fa fa-info text-danger"></i></span> <span class="tooltip-content clearfix"> <span class="tooltip-text bg-secondary text-dark">
                            <ul><span class="text-primary">{{__('lang.residential_pmeter_requirement')}}</span>
                                <li>{{__('lang.nrc_card')}}</li>
                                <li>{{__('lang.form10')}}</li>
                                <li>{{__('lang.owner')}}</li>
                                <li>{{__('lang.noinvade_letter')}}</li>
                                <li>{{__('lang.occupy_letter')}}</li>
                                <li>{{__('lang.applied_electricpower_photo')}}</li>
                            </ul>
                            </span> </span> </span>
                    </li></a>
                    <a href="{{ route('commercial_rule_regulation') }}"><li class="meter-list-item">
                        <i class="fa fa-industry m-r-20 text-success"></i> {{ __('lang.commercial_power_meter_apply') }}
                        <span class="mytooltip tooltip-effect-4 m-l-20"> <span class="tooltip-item"><i class="fa fa-info text-danger"></i></span> <span class="tooltip-content clearfix"> <span class="tooltip-text bg-secondary text-dark">
                            <ul><span class="text-primary">{{__('lang.commercial_pmeter_requirement')}}</span>
                                <li>{{__('lang.nrc_card')}}</li>
                                <li>{{__('lang.form10')}}</li>
                                <li>{{__('lang.owner')}}</li>
                                <li>{{__('lang.noinvade_letter')}}</li>
                                <li>{{__('lang.occupy_letter')}}</li>
                                {{-- <li>{{__('lang.applied_electricpower_photo')}}</li> --}}
                                <li>{{__('lang.applied_transactionlicence_photo')}}</li>
                            </ul>
                            </span> </span> </span>
                    </li></a>
                    <a href="{{ route('contract_rule_regulation') }}"><li class="meter-list-item">
                        <i class="fa fa-building m-r-20 text-success"></i> {{ __('lang.contractor_meter_apply') }}
                        <span class="mytooltip tooltip-effect-4 m-l-20"> <span class="tooltip-item"><i class="fa fa-info text-danger"></i></span> <span class="tooltip-content clearfix"> <span class="tooltip-text bg-secondary text-dark">
                            <ul><span class="text-primary">{{__('lang.contractor_meter_requirement')}}</span>
                                <li>{{__('lang.nrc_card')}}</li>
                                <li>{{__('lang.form10')}}</li>
                                <li>{{__('lang.owner')}}</li>
                                <li>{{__('lang.noinvade_letter')}}</li>
                                <li>{{__('lang.occupy_letter')}}</li>
                                <li>{{__('lang.permit')}}</li>
                                <li>{{__('lang.bcc')}}</li>
                                <li>{{__('lang.dc_recomm')}}</li>
                                <li>{{__('lang.prev_bill')}}</li>
                            </ul>
                            <p>
                            ကန်ထရိုက်တိုက်မီတာလျှောက်ထားရာတွင် ထရန်စဖေါ်မာတည်ဆောက်ရန် လိုအပ်ပါက ကန်ထရိုက်တာ (သို့) အိမ်ပိုင်ရှင်မှ တည်ဆောက်ပေးရမည် ဖြစ်ပါသည်။
                            </p>
                            </span> </span> </span>
                    </li></a>
                    <a href="{{ route('tsf_rule_regulation') }}"><li class="meter-list-item">
                        <i class="fa fa-bolt m-r-20 text-success"></i> {{ __('lang.transformer_apply') }}
                        <span class="mytooltip tooltip-effect-4 m-l-20"> <span class="tooltip-item"><i class="fa fa-info text-danger"></i></span> <span class="tooltip-content clearfix"> <span class="tooltip-text bg-secondary text-dark">
                            <ul><span class="text-primary">{{__('lang.transformer_requirement')}}</span>
                                <li>{{__('lang.nrc_card')}}</li>
                                <li>{{__('lang.form10')}}</li>
                                <li>{{__('lang.owner')}}</li>
                                <li>{{__('lang.noinvade_letter')}}</li>
                                <li>{{__('lang.occupy_letter')}}</li>
                                {{-- <li>{{__('lang.applied_electricpower_photo')}}</li> --}}
                                <li> {{__('lang.if_for_commercial')}} {{__('lang.applied_transactionlicence_photo')}}</li>
                                <li>{{__('lang.dc_recomm')}}</li>
                            </ul>
                            </span> </span> </span>
                    </li></a>
                    <a href="#"><li class="meter-list-item">
                        <i class="fa fa-superpowers m-r-20 text-success"></i> {{ __('lang.village_meter_apply') }}
                        <span class="mytooltip tooltip-effect-4 m-l-20"> <span class="tooltip-item"><i class="fa fa-info text-danger"></i></span> <span class="tooltip-content clearfix"> <span class="tooltip-text bg-secondary text-dark">
                            <ul><span class="text-primary">{{__('lang.village_requirement')}}</span>
                                <li>{{__('lang.nrc_card')}}</li>
                                <li>{{__('lang.form10')}}</li>
                                <li>{{__('lang.owner')}}</li>
                                <li>{{__('lang.noinvade_letter')}}</li>
                                <li>{{__('lang.occupy_letter')}}</li>
                                <li>{{__('lang.applied_electricpower_photo')}}</li>
                                <li>{{__('lang.applied_transactionlicence_photo')}}</li>
                            </ul>
                            </span> </span> </span>
                    </li></a>
                </ul>
                {{--  <p class="text-danger text-center"><i class="fa fa-exclamation-circle fa-fw"></i> {{ 'Coming Soon!' }}</p>  --}}
                {{-- <div class="text-center">
                    <a href="{{ route('resident_app') }}" class="btn waves-effect waves-light btn-rounded btn-primary text-white">{{ __('lang.apply') }}</a>
                </div> --}}
            </div>
        </div>
    </div>
</div>

@endsection