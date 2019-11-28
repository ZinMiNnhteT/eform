@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('transformerGroundCheckDoneListByDivisionState.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>

            <div class="card-body">
                <h3 class="text-center">{{ __('lang.residentSurvey') }} ({{ div_state($form->div_state_id) }}{{ checkMM() == 'mm' ? '၊' : ',' }} {{ district($form->district_id) }})</h3>
                
                <div class="row justify-content-center mt-5">

                    <div class="col-md-8">
                        <div class="table-responsive bg-secondary">
                            <table class="table no-border">
                                <thead>
                                    <tr>
                                        <th class="text-center text-dark" colspan="2">
                                            <h4>မြို့နယ်အဆင့် စစ်ဆေးခြင်း</h4>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width: 300px">{{ __('lang.survey_date') }}</td>
                                        <td>{{ survey_accepted_date($form->id) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.serial') }}</td>
                                        <td>{{ ($form->serial_code) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.fullname') }}</td>
                                        <td>{{ ($form->fullname) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.applied_address') }}</td>
                                        <td>{{ address($form->id) }}</td>
                                    </tr>

                                    <tr>
                                        <th>{{ __('ဓါတ်အားပေးမည့်ပင်ရင်း Source') }}</th>
                                        <td>
                                            @if ($survey_result->pri_tsf_name)
                                            {{ $survey_result->pri_tsf_type.' KV' }} {{ '/' }} {{ $survey_result->pri_main_ct_ratio.' KV' }} {{ $survey_result->pri_tsf_name }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ $survey_result->ct_ratio.' KV CT Ratio' }}</td>
                                        <td>
                                            @if ($survey_result->ct_ratio_amt)
                                                {{ $survey_result->ct_ratio_amt }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ $survey_result->pri_main_ct_ratio.' KV Main CT Ratio' }}</td>
                                        <td>
                                            @if ($survey_result->pri_main_ct_ratio_amt)
                                                {{ $survey_result->pri_main_ct_ratio_amt }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ 'ဓါတ်အားခွဲရုံ Capacity' }}</td>
                                        <td>
                                            @if ($survey_result->pri_capacity)
                                                {{ $survey_result->pri_capacity }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ $survey_result->main_feeder_peak_load.' KV Main Feeder Peak Load' }}</td>
                                        <td>
                                            @if ($survey_result->main_feeder_peak_load_amt)
                                                {{ $survey_result->main_feeder_peak_load_amt }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ $survey_result->pri_feeder_ct_ratio.' KV Feeder CT Ratio' }}</td>
                                        <td>
                                            @if ($survey_result->pri_feeder_ct_ratio_amt)
                                                {{ $survey_result->pri_feeder_ct_ratio_amt }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ $survey_result->feeder_peak_load.' KV Feeder Peak Load' }}</td>
                                        <td>
                                            @if ($survey_result->feeder_peak_load_amt)
                                                {{ $survey_result->feeder_peak_load_amt }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>{{ __('ဓါတ်အားပေးမည့် Secondary Source') }}</th>
                                        <td>
                                            @if ($survey_result->sec_tsf_name)
                                            {{ $survey_result->sec_tsf_type.' KV' }} {{ '/ 11 KV' }} {{ $survey_result->sec_tsf_name }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ $survey_result->sec_main_ct_ratio.' KV Main CT Ratio' }}</td>
                                        <td>
                                            @if ($survey_result->sec_main_ct_ratio_amt)
                                                {{ $survey_result->sec_main_ct_ratio_amt }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ '11 KV Main CT Ratio' }}</td>
                                        <td>
                                            @if ($survey_result->sec_11_main_ct_ratio)
                                                {{ $survey_result->sec_11_main_ct_ratio }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ 'ဓါတ်အားခွဲရုံ Capacity' }}</td>
                                        <td>
                                            @if ($survey_result->sec_capacity)
                                                {{ $survey_result->sec_capacity }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ 'Peak Load (Day)' }}</td>
                                        <td>
                                            @if ($survey_result->sec_11_peak_load_day)
                                                {{ $survey_result->sec_11_peak_load_day }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ 'Peak Load (Night)' }}</td>
                                        <td>
                                            @if ($survey_result->sec_11_peak_load_night)
                                                {{ $survey_result->sec_11_peak_load_night }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ 'Installed Capacity' }}</td>
                                        <td>
                                            @if ($survey_result->sec_11_installed_capacity)
                                                {{ $survey_result->sec_11_installed_capacity }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <th>{{ __('ဓါတ်အားရယူမည့် Feeder') }}</th>
                                        <td>
                                            @if ($survey_result->feeder_name)
                                            {{ $survey_result->feeder_name }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ 'CT Ratio' }}</td>
                                        <td>
                                            @if ($survey_result->feeder_ct_ratio)
                                                {{ $survey_result->feeder_ct_ratio }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ 'Peak Load (Day)' }}</td>
                                        <td>
                                            @if ($survey_result->feeder_peak_load_day)
                                                {{ $survey_result->feeder_peak_load_day }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ 'Peak Load (Night)' }}</td>
                                        <td>
                                            @if ($survey_result->feeder_peak_load_night)
                                                {{ $survey_result->feeder_peak_load_night }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <th>{{ __('ဓါတ်အားရယူမည့် လိုင်းတစ်လျှောက်ရှိ') }}</th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Installed Capacity') }}</td>
                                        <td>
                                            @if ($survey_result->online_installed_capacity)
                                            {{ $survey_result->online_installed_capacity }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ 'ဓါတ်အားလိုင်းအရှည် (ပေ/မိုင်) (စုစုပေါင်း)' }}</td>
                                        <td>
                                            @if ($survey_result->total_line_length)
                                                {{ $survey_result->total_line_length }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ 'ဓါတ်အားလိုင်းအရှည် (ပေ/မိုင်) (အဆိုပြုအထိ)' }}</td>
                                        <td>
                                            @if ($survey_result->request_line_length)
                                                {{ $survey_result->request_line_length }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ 'Conductor Type and Size' }}</td>
                                        <td>
                                            @if ($survey_result->conductor)
                                                {{ $survey_result->conductor }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ 'လိုင်းကြိုးလဲရန် လို/မလို' }}</td>
                                        <td>
                                            @if ($survey_result->string_change == 'yes')
                                                {{ 'လိုပါသည်' }}
                                            @else
                                                {{ 'မလိုပါ' }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ 'လိုင်းကြိုးအမျိုးအစားနှင့် အရှည်' }}</td>
                                        <td>
                                            @if ($survey_result->string_change == 'yes')
                                                {{ $survey_result->string_change_type_length }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>{{ __('ဓါတ်အားခွဲရုံမှူး၏ ထောက်ခံချက်') }}</td>
                                        <td>
                                            @if ($survey_result->power_station_recomm)
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/app/public/user_attachments/'.$form->id.'_'.$form->serial_code.'/'.$survey_result->power_station_recomm) }}" alt="{{ $survey_result->power_station_recomm }}" class="img-thumbnail">
                                            </div>
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.one_line_diagram') }}</td>
                                        <td>
                                            @if ($survey_result->one_line_diagram)
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/app/public/user_attachments/'.$form->id.'_'.$form->serial_code.'/'.$survey_result->one_line_diagram) }}" alt="{{ $survey_result->one_line_diagram }}" class="img-thumbnail">
                                            </div>
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.location_map') }}</td>
                                        <td>
                                            @if ($survey_result->location_map)
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/app/public/user_attachments/'.$form->id.'_'.$form->serial_code.'/'.$survey_result->location_map) }}" alt="{{ $survey_result->location_map }}" class="img-thumbnail">
                                            </div>
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Google Map') }}</td>
                                        <td>
                                            @if ($survey_result->google_map)
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/app/public/user_attachments/'.$form->id.'_'.$form->serial_code.'/'.$survey_result->google_map) }}" alt="{{ $survey_result->google_map }}" class="img-thumbnail">
                                            </div>
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('အသုံးပြုမည့် ဝန်အားစာရင်း') }}</td>
                                        <td>
                                            @if ($survey_result->comsumed_power_list)
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/app/public/user_attachments/'.$form->id.'_'.$form->serial_code.'/'.$survey_result->comsumed_power_list) }}" alt="{{ $survey_result->comsumed_power_list }}" class="img-thumbnail">
                                            </div>
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ 'အင်ဂျင်နီယာမှတ်ချက်' }}</td>
                                        <td>
                                            @if ($survey_result->survey_remark)
                                                {{ $survey_result->survey_remark }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ 'မြိုနယ်ရုံးမှတ်ချက်' }}</td>
                                        <td>
                                            @if ($survey_result->tsp_remark)
                                                {{ $survey_result->tsp_remark }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ 'ခရိုင်ရုံးမှတ်ချက်' }}</td>
                                        <td>
                                            @if ($survey_result->tsp_remark)
                                                {{ $survey_result->tsp_remark }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                   
                </div>

                <div class="row justify-content-center m-t-20">
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-bordered table-small-padding">
                                <tbody>
                                    <tr class="bg-primary text-white">
                                        <td class="text-center" colspan="2"><strong>{{ __('lang.chk_person') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.account') }}</td>
                                        <td>{{ who($survey_result->survey_engineer) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.name') }}</td>
                                        <td>{{ who($survey_result->survey_engineer) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.position') }}</td>
                                        <td>{{ 'အငယ်တန်းအင်ဂျင်နီယာ' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.phone') }}</td>
                                        <td>{{ '၀၉၂၃၄၂၃၄၂၃၄' }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.location') }}</td>
                                        <td>{{ '19.5804378,96.0153078' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {!! Form::open(['route' => 'transformerGroundCheckDoneListByDivisionState.store', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                <div class="row justify-content-center m-t-20">
                    <div class="col-md-8">
                        <div class="form-group row">
                            <label for="capacitor_bank" class="col-md-5 col-form-label text-info">{{ __('Capacitor Bank လို/မလို') }}</label>
                            <div class="col-md-7">
                                <input type="radio" class="check" name="capacitor_bank" value="yes" id="capacitor_bank_yes" data-radio="iradio_square-red" required>
                                <label for="capacitor_bank_yes">{{ __('လိုပါသည်') }}</label>
                                <input type="radio" class="check" name="capacitor_bank" value="no" id="capacitor_bank_no" data-radio="iradio_square-red" required>
                                <label for="capacitor_bank_no">{{ __('မလိုပါ') }}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="capacitor_bank_amt" class="col-md-5 col-form-label text-info">{{ __('လိုအပ်သော KVAr') }}</label>
                            <div class="col-md-7">
                                <input type="text" name="capacitor_bank_amt" class="form-control" id="capacitor_bank_amt" placeholder="လိုအပ်သော KVAr" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="div_state_remark" class="text-info">မှတ်ချက်</label>
                            <textarea name="div_state_remark" rows="5" class="form-control" id="div_state_remark" placeholder="မှတ်ချက်ပေးရန်"></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('transformerGroundCheckDoneListByDivisionState.index') }}" class="btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                    <input type="submit" name="survey_confirm_by_divstate" value="{{ __('lang.send_dist_tsp') }}" class="btn btn-rounded btn-info">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection