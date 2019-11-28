@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0 l-h-33">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('transformerGroundCheckList.create', $form->id) }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5 "><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>

            <div class="card-body">
                <h3 class="text-center ">{{ __('lang.residentSurvey') }} ({{ div_state($form->div_state_id) }}{{ checkMM() == 'mm' ? '၊' : ',' }} {{ district($form->district_id) }})</h3>

                {!! Form::open(['route' => 'transformerInformation.store']) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="form-info bg-secondary p-20">
                            <table class="table no-border">
                                <tbody>
                                    <tr>
                                        <td><strong>{{ __('lang.serial') }}</strong></td>
                                        <td>{{$form->serial_code}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('lang.fullname') }}</strong></td>
                                        <td>{{$form->fullname}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('lang.applied_address') }}</strong></td>
                                        <td>{{address($form->id)}}</td>
                                    </tr>
                                </tbod>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8 mt-5 mb-3">
                        <h5 class="text-primary">{{ __('lang.given_feeder_name') }}</h5>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <ul style="list-style-type: none">
                                <li>
                                    <label for="main_source" class="text-info">
                                        <input type="radio" class="check" name="tsf_type" value="main_source" id="main_source" data-radio="iradio_square-red" required>
                                        {{ __('ပင်မဓါတ်အားခွဲရုံ') }}
                                    </label>
                                </li>
                                <li>
                                    <label for="sub_source" class="text-info">
                                        <input type="radio" class="check" name="tsf_type" value="sub_source" id="sub_source" data-radio="iradio_square-red" required>
                                        {{ __('ဓါတ်အားခွဲရုံ') }}
                                    </label>
                                </li>
                                <li>
                                    <label for="feeder" class="text-info">
                                        <input type="radio" class="check" name="tsf_type" value="feeder" id="feeder" data-radio="iradio_square-red" required>
                                        {{ __('ဖီဒါ') }}
                                    </label>
                                </li>
                                <li>
                                    <label for="new_tsf" class="text-info">
                                        <input type="radio" class="check" name="tsf_type" value="new_tsf" id="new_tsf" data-radio="iradio_square-red" required>
                                        {{ __('ဓါတ်အားရယူမည့် ထရန်စဖော်မာ') }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="tsf_ht_kv" class="text-info">{{ __('lang.tsf_ht_kv') }}</label>
                                    <input type="text" name="tsf_ht_kv" class="form-control" id="tsf_ht_kv" placeholder="eg. 33 KV">
                                </div>
                                <div class="col-md-3">
                                    <label for="tsf_lt_kv" class="text-info">{{ __('lang.tsf_lt_kv') }}</label>
                                    <input type="text" name="tsf_lt_kv" class="form-control" id="tsf_ht_kv" placeholder="eg. 11 KV">
                                </div>
                                <div class="col-md-6">
                                    <label for="tsf_name" class="text-info">{{ __('lang.tsf_name') }}</label>
                                    <input type="text" name="tsf_name" class="form-control" id="tsf_name">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="ct_ratio_ht" class="text-info"><span id="ht_kv_show"></span> {{ __('lang.ct_ratio_ht') }}</label>
                                    <input type="text" name="ct_ratio_ht" class="form-control" id="ct_ratio_ht">
                                </div>
                                <div class="col-md-6">
                                    <label for="ct_ratio_lt" class="text-info"><span id="lt_kv_show"></span> {{ __('lang.ct_ratio_lt') }}</label>
                                    <input type="text" name="ct_ratio_lt" class="form-control" id="ct_ratio_lt">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="switch_gear" class="text-info">{{ __('lang.switch_gear') }}</label>
                            <input type="text" name="switch_gear" class="form-control" id="switch_gear" placeholder="">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="install_cap" class="text-info">{{ __('lang.install_cap') }}</label>
                            <input type="text" name="install_cap" class="form-control" id="install_cap" placeholder="eg. 10 MW (or) 10 KVA (or) 10000 KVA, 100 Nos">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="request_cap" class="text-info">{{ __('lang.request_cap') }}</label>
                            <input type="text" name="request_cap" class="form-control" id="request_cap" placeholder="eg. 10 MW (or) 10 KVA (or) 10000 KVA, 100 Nos">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="tsf_mva" class="text-info">{{ __('lang.tsf_mva') }}</label>
                            <input type="text" name="tsf_mva" class="form-control" id="tsf_mva" placeholder="eg. 10 MW (or) 10 KVA">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="highest_power_amp" class="text-info"><span id="ht_kv_show"></span> {{ __('lang.highest_power_amp') }}</label>
                            <input type="text" name="highest_power_amp" class="form-control" id="highest_power_amp" placeholder="eg. 500 A">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="highest_power_day" class="text-info"><span id="lt_kv_show"></span> {{ __('lang.highest_power_day') }}</label>
                                    <input type="text" name="highest_power_day" class="form-control" id="highest_power_day" placeholder="">
                                </div>
                                <div class="col-md-6">
                                    <label for="highest_power_night" class="text-info"><span id="lt_kv_show"></span> {{ __('lang.highest_power_night') }}</label>
                                    <input type="text" name="highest_power_night" class="form-control" id="highest_power_night" placeholder="နေ့/ည မရှိပါက ဖြည့်သွင်းရန် မလိုပါ။">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="tsf_load_percent" class="text-info"><span id="ht_kv_show"></span> {{ __('lang.tsf_load_percent') }}</label>
                            <input type="text" name="tsf_load_percent" class="form-control" id="tsf_load_percent" placeholder="eg. 50 %">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="line_size_length" class="text-info">{{ __('lang.line_size_length') }}</label>
                            {{-- <input type="text" name="line_size_length" class="form-control" id="line_size_length"> --}}
                            <textarea name="line_size_length" id="line_size_length" cols="30" rows="5" class="form-control" placeholder="{{ __('lang.line_size_length_placeholder') }}"></textarea>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="tsf_line_ft_mile_total" class="text-info">{{ __('lang.tsf_line_ft_mile_total') }}</label>
                                    <input type="text" name="tsf_line_ft_mile_total" class="form-control" id="tsf_line_ft_mile_total" placeholder="eg. 5280 ft (or) 1 mile">
                                </div>
                                <div class="col-md-6">
                                    <label for="tsf_line_ft_mile_req" class="text-info">{{ __('lang.tsf_line_ft_mile_req') }}</label>
                                    <input type="text" name="tsf_line_ft_mile_req" class="form-control" id="tsf_line_ft_mile_req" placeholder="eg. 5280 ft (or) 1 mile">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="text-center">
                    <a href="{{ route('transformerGroundCheckList.create', $form->id) }}" class="btn btn-rounded btn-secondary ">{{ __('lang.cancel') }}</a>
                    <input type="submit" name="survey_submit" value="{{ __('lang.submit') }}" class="btn btn-rounded btn-info ">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
