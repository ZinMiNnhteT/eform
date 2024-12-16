@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0 l-h-33">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('transformerGroundCheckList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5 "><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>

            <div class="card-body">
                <h3 class="text-center ">{{ __('lang.residentSurvey') }} ({{ div_state($form->div_state_id) }}{{ checkMM() == 'mm' ? '၊' : ',' }} {{ district($form->district_id) }})</h3>

                {!! Form::open(['route' => 'transformerGroundCheckList.store', 'files' => true]) !!}
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
                    
                    <div class="col-md-8 mt-5">
                        <h5 class="text-primary">{{ __('ဓါတ်အားပေးမည့်ပင်ရင်း Source') }}</h5>
                        <div class="form-group row">
                            <label for="pri_tsf_type" class="col-md-5 col-form-label text-info">{{ __('ဓါတ်အားခွဲရုံ') }}</label>
                            <div class="col-md-7">
                                <input type="radio" class="check" name="pri_tsf_type" value="230" id="pri_tsf_type_230" data-radio="iradio_square-red" required>
                                <label for="pri_tsf_type_230">{{ __('230 KV') }}</label>
                                <input type="radio" class="check" name="pri_tsf_type" value="132" id="pri_tsf_type_132" data-radio="iradio_square-red" required>
                                <label for="pri_tsf_type_132">{{ __('132 KV') }}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pri_tsf_name" class="col-md-5 col-form-label text-info">{{ __('ဓါတ်အားခွဲရုံအမည်') }}</label>
                            <div class="col-md-7">
                                <input type="text" name="pri_tsf_name" class="form-control" id="pri_tsf_name" placeholder="ဓါတ်အားခွဲရုံအမည်">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pri_capacity" class="col-md-5 col-form-label text-info">{{ __('ဓါတ်အားခွဲရုံ Capacity') }}</label>
                            <div class="col-md-7">
                                <input type="text" name="pri_capacity" id="pri_capacity" class="form-control" placeholder="Capacity">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <input type="radio" class="check" name="ct_ratio" value="230" id="ct_ratio_230" data-radio="iradio_square-red" required>
                                <label for="ct_ratio_230">{{ __('230 KV') }}</label>
                                <input type="radio" class="check" name="ct_ratio" value="132" id="ct_ratio_132" data-radio="iradio_square-red" required>
                                <label for="ct_ratio_132">{{ __('132 KV') }}</label>
                                <label for="ct_ratio_amt" class="col-form-label text-info">{{ __('CT Ratio') }}</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="ct_ratio_amt" id="ct_ratio_amt" class="form-control" placeholder="CT Ratio">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <input type="radio" class="check" name="pri_main_ct_ratio" value="66" id="pri_main_ct_ratio_66" data-radio="iradio_square-red" required>
                                <label for="pri_main_ct_ratio_66">{{ __('66 KV') }}</label>
                                <input type="radio" class="check" name="pri_main_ct_ratio" value="33" id="pri_main_ct_ratio_33" data-radio="iradio_square-red" required>
                                <label for="pri_main_ct_ratio_33">{{ __('33 KV') }}</label>
                                <label for="pri_main_ct_ratio_amt" class="col-form-label text-info">{{ __('Main CT Ratio') }}</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="pri_main_ct_ratio_amt" id="pri_main_ct_ratio_amt" class="form-control" placeholder="Main CT Ratio">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <input type="radio" class="check" name="main_feeder_peak_load" value="66" id="main_feeder_peak_load_66" data-radio="iradio_square-red" required>
                                <label for="main_feeder_peak_load_66">{{ __('66 KV') }}</label>
                                <input type="radio" class="check" name="main_feeder_peak_load" value="33" id="main_feeder_peak_load_33" data-radio="iradio_square-red" required>
                                <label for="main_feeder_peak_load_33">{{ __('33 KV') }}</label>
                                <label for="main_feeder_peak_load_amt" class="col-form-label text-info">{{ __('Main Feeder Peak Load') }}</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="main_feeder_peak_load_amt" id="main_feeder_peak_load_amt" class="form-control" placeholder="Main Feeder Peak Load">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <input type="radio" class="check" name="pri_feeder_ct_ratio" value="66" id="pri_feeder_ct_ratio_66" data-radio="iradio_square-red" required>
                                <label for="pri_feeder_ct_ratio_66">{{ __('66 KV') }}</label>
                                <input type="radio" class="check" name="pri_feeder_ct_ratio" value="33" id="pri_feeder_ct_ratio_33" data-radio="iradio_square-red" required>
                                <label for="pri_feeder_ct_ratio_33">{{ __('33 KV') }}</label>
                                <label for="pri_feeder_ct_ratio_amt" class="col-form-label text-info">{{ __('Feeder CT Ratio') }}</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="pri_feeder_ct_ratio_amt" id="pri_feeder_ct_ratio_amt" class="form-control" placeholder="Feeder Peak Load">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <input type="radio" class="check" name="feeder_peak_load" value="66" id="feeder_peak_load_66" data-radio="iradio_square-red" required>
                                <label for="feeder_peak_load_66">{{ __('66 KV') }}</label>
                                <input type="radio" class="check" name="feeder_peak_load" value="33" id="feeder_peak_load_33" data-radio="iradio_square-red" required>
                                <label for="feeder_peak_load_33">{{ __('33 KV') }}</label>
                                <label for="feeder_peak_load_amt" class="col-form-label text-info">{{ __('Feeder Peak Load') }}</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="feeder_peak_load_amt" id="feeder_peak_load_amt" class="form-control" placeholder="Feeder Peak Load">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 mt-5">
                        <h5 class="text-primary">{{ __('ဓါတ်အားပေးမည့် Secondary Source') }}</h5>
                        <div class="form-group row">
                            <label for="pri_tsf_type" class="col-md-5 col-form-label text-info">{{ __('ဓါတ်အားခွဲရုံ') }}</label>
                            <div class="col-md-7">
                                <input type="radio" class="check" name="sec_tsf_type" value="66" id="sec_tsf_type_66" data-radio="iradio_square-red" required>
                                <label for="sec_tsf_type_66">{{ __('66 KV') }}</label>
                                <input type="radio" class="check" name="sec_tsf_type" value="33" id="sec_tsf_type_33" data-radio="iradio_square-red" required>
                                <label for="sec_tsf_type_33">{{ __('33 KV') }}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sec_tsf_name" class="col-md-5 col-form-label text-info">{{ __('ဓါတ်အားခွဲရုံအမည်') }}</label>
                            <div class="col-md-7">
                                <input type="text" name="sec_tsf_name" class="form-control" id="sec_tsf_name" placeholder="ဓါတ်အားခွဲရုံအမည်">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sec_capacity" class="col-md-5 col-form-label text-info">{{ __('ဓါတ်အားခွဲရုံ Capacity') }}</label>
                            <div class="col-md-7">
                                <input type="text" name="sec_capacity" id="sec_capacity" class="form-control" placeholder="Capacity">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5">
                                <input type="radio" class="check" name="sec_main_ct_ratio" value="66" id="sec_main_ct_ratio_66" data-radio="iradio_square-red" required>
                                <label for="sec_main_ct_ratio_66">{{ __('66 KV') }}</label>
                                <input type="radio" class="check" name="sec_main_ct_ratio" value="33" id="sec_main_ct_ratio_33" data-radio="iradio_square-red" required>
                                <label for="sec_main_ct_ratio_33">{{ __('33 KV') }}</label>
                                <label for="sec_main_ct_ratio_amt" class="col-form-label text-info">{{ __('Main CT Ratio') }}</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="sec_main_ct_ratio_amt" id="sec_main_ct_ratio_amt" class="form-control" placeholder="Main CT Ratio">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sec_11_main_ct_ratio" class="col-md-5 col-form-label text-info">{{ __('11KV Main CT Ratio') }}</label>
                            <div class="col-md-7">
                                <input type="text" name="sec_11_main_ct_ratio" id="sec_11_main_ct_ratio" class="form-control" placeholder="11KV Main CT Ratio">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sec_11_peak_load_day" class="col-md-5 col-form-label text-info">{{ __('Peak Load (Day)') }}</label>
                            <div class="col-md-7">
                                <input type="text" name="sec_11_peak_load_day" id="sec_11_peak_load_day" class="form-control" placeholder="Peak Load (Day)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sec_11_peak_load_night" class="col-md-5 col-form-label text-info">{{ __('Peak Load (Night)') }}</label>
                            <div class="col-md-7">
                                <input type="text" name="sec_11_peak_load_night" id="sec_11_peak_load_night" class="form-control" placeholder="Peak Load (Night)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sec_11_installed_capacity" class="col-md-5 col-form-label text-info">{{ __('Installed Capacity') }}</label>
                            <div class="col-md-7">
                                <input type="text" name="sec_11_installed_capacity" id="sec_11_installed_capacity" class="form-control" placeholder="Installed Capacity">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 mt-5">
                        <h5 class="text-primary">{{ __('ဓါတ်အားရယူမည့် Feeder') }}</h5>
                        <div class="form-group row">
                            <label for="feeder_name" class="col-md-5 col-form-label text-info">{{ __('ဖီဒါအမည်') }}</label>
                            <div class="col-md-7">
                                <input type="text" name="feeder_name" class="form-control" id="feeder_name" placeholder="ဖီဒါအမည်">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="feeder_ct_ratio" class="col-md-5 col-form-label text-info">{{ __('Feeder CT Ratio') }}</label>
                            <div class="col-md-7">
                                <input type="text" name="feeder_ct_ratio" class="form-control" id="feeder_ct_ratio" placeholder="Feeder CT Ratio">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="feeder_peak_load_day" class="col-md-5 col-form-label text-info">{{ __('Feeder Peak Load (Day)') }}</label>
                            <div class="col-md-7">
                                <input type="text" name="feeder_peak_load_day" class="form-control" id="feeder_peak_load_day" placeholder="Feeder Peak Load (Day)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="feeder_peak_load_night" class="col-md-5 col-form-label text-info">{{ __('Feeder Peak Load (Night)') }}</label>
                            <div class="col-md-7">
                                <input type="text" name="feeder_peak_load_night" class="form-control" id="feeder_peak_load_night" placeholder="Feeder Peak Load (Night)">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 mt-5">
                        <h5 class="text-primary">{{ __('ဓါတ်အားရယူမည့် လိုင်းတစ်လျှောက်ရှိ') }}</h5>
                        <div class="form-group row">
                            <label for="online_installed_capacity" class="col-md-5 col-form-label text-info">{{ __('Installed Capacity') }}</label>
                            <div class="col-md-7">
                                <input type="text" name="online_installed_capacity" class="form-control" id="online_installed_capacity" placeholder="Installed Capacity">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="total_line_length" class="col-md-5 col-form-label text-info">{{ __('ဓါတ်အားလိုင်းအရှည် (ပေ/မိုင်) (စုစုပေါင်း)') }}</label>
                            <div class="col-md-7">
                                <input type="text" name="total_line_length" class="form-control" id="total_line_length" placeholder="ဓါတ်အားလိုင်းအရှည်">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="request_line_length" class="col-md-5 col-form-label text-info">{{ __('ဓါတ်အားလိုင်းအရှည် (ပေ/မိုင်) (အဆိုပြုအထိ)') }}</label>
                            <div class="col-md-7">
                                <input type="text" name="request_line_length" class="form-control" id="request_line_length" placeholder="ဓါတ်အားလိုင်းအရှည်">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="conductor" class="col-md-5 col-form-label text-info">{{ __('Conductor Type and Size') }}</label>
                            <div class="col-md-7">
                                <textarea name="conductor" id="conductor" class="form-control" rows="3" placeholder="{{ __('lang.line_size_length_placeholder') }}"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="string_change" class="col-md-5 col-form-label text-info">{{ __('လိုင်းကြိုးလဲရန် လို/မလို') }}</label>
                            <div class="col-md-7">
                                <input type="radio" class="check" name="string_change" value="yes" id="string_change_yes" data-radio="iradio_square-red" required>
                                <label for="string_change_yes">{{ __('လိုပါသည်') }}</label>
                                <input type="radio" class="check" name="string_change" value="no" id="string_change_no" data-radio="iradio_square-red" required>
                                <label for="string_change_no">{{ __('မလိုပါ') }}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="string_change_type_length" class="col-md-5 col-form-label text-info">{{ __('လိုအပ်ပါက လိုင်းကြိုးအမျိုးအစားနှင့် အရှည်') }}</label>
                            <div class="col-md-7">
                                <input type="text" name="string_change_type_length" class="form-control" id="string_change_type_length" placeholder="လိုင်းကြိုးအမျိုးအစားနှင့် အရှည်" disabled>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="power_station_recomm" class="text-info">{{ __('ဓါတ်အားခွဲရုံမှူး၏ ထောက်ခံချက်') }}</label>
                            <div class="bg-secondary p-20">
                                <input type="file" name="power_station_recomm" id="power_station_recomm" accept=".jpg,.png"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="one_line_diagram" class="text-info">{{ __('lang.one_line_diagram') }}</label>
                            <div class="bg-secondary p-20">
                                <input type="file" name="one_line_diagram" id="one_line_diagram" accept=".jpg,.png"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="location_map" class="text-info">{{ __('lang.location_map') }}</label>
                            <div class="bg-secondary p-20">
                                <input type="file" name="location_map" id="location_map" accept=".jpg,.png"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="google_map" class="text-info">{{ __('Google Map') }}</label>
                            <div class="bg-secondary p-20">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="longitude" class="text-info">{{ 'လောင်ဂျီကျူ' }}</label>
                                        <input type="text" name="longitude" class="form-control" id="longitude"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="latitude" class="text-info">{{ 'လက်တီကျူ' }}</label>
                                        <input type="text" name="latitude" class="form-control" id="latitude"/>
                                    </div>
                                    <div class="col-md-12 pt-3">
                                        <input type="file" name="google_map" id="google_map" accept=".jpg,.png"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="comsumed_power_list" class="text-info">{{ __('အသုံးပြုမည့် ဝန်အားစာရင်း') }}</label>
                            <div class="bg-secondary p-20">
                                <input type="file" name="comsumed_power_list" id="comsumed_power_list" accept=".jpg,.png"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="survey_remark" class="text-info">{{ __('မှတ်ချက်') }}</label>
                            <textarea name="survey_remark" class="form-control" id="survey_remark" rows="3" placeholder="မှတ်ချက်"></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('transformerGroundCheckList.index') }}" class="btn btn-rounded btn-secondary ">{{ __('lang.cancel') }}</a>
                    <input type="submit" name="survey_submit" value="{{ __('lang.submit') }}" class="btn btn-rounded btn-info ">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection