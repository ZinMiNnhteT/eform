@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('transformerGroundCheckDoneList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>

            <div class="card-body">
            
                <h3 class="text-center">{{ __('lang.residentSurvey') }} ({{ div_state($form->div_state_id) }}{{ checkMM() == 'mm' ? '၊' : ',' }} {{ district($form->district_id) }})</h3>

                <div class="row justify-content-center m-t-20">
                    <div class="survey-info bg-secondary col-md-8">
                        <div class="table-responsive">
                        <table class="table no-border table-md-padding">
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
                                    <td>{{ __('lang.tsf_capacity') }}</td>
                                    <td>
                                        @if ($survey_result->tsf_capacity)
                                        {{ $survey_result->tsf_capacity }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.type_of_where') }}</td>
                                    <td>
                                        @if ($survey_result->type_of_where)
                                        {{ $survey_result->type_of_where }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.loaded') }}</td>
                                    <td>
                                        @if ($survey_result->loaded)
                                        {{ $survey_result->loaded }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.given_feeder_name') }}</td>
                                    <td>
                                        @if ($survey_result->given_feeder_name)
                                        {{ $survey_result->given_feeder_name }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.tsf_mva') }}</td>
                                    <td>
                                        @if ($survey_result->tsf_mva)
                                        {{ $survey_result->tsf_mva }} MW
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.ct_ratio_66kv') }}</td>
                                    <td>
                                        @if ($survey_result->ct_ratio_66kv)
                                        {{ $survey_result->ct_ratio_66kv }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.ct_ratio_11_66kv') }}</td>
                                    <td>
                                        @if ($survey_result->ct_ratio_11_66kv)
                                        {{ $survey_result->ct_ratio_11_66kv }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.highest_power_amp') }}</td>
                                    <td>
                                        @if ($survey_result->highest_power_amp)
                                        {{ $survey_result->highest_power_amp }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.highest_power_mw') }}</td>
                                    <td>
                                        @if ($survey_result->highest_power_mw)
                                        {{ $survey_result->highest_power_mw }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.total_feeder') }}</td>
                                    <td>
                                        @if ($survey_result->total_feeder)
                                        {{ $survey_result->total_feeder }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.loaded_mva_amp_on_feeder') }}</td>
                                    <td>
                                        @if ($survey_result->loaded_one)
                                        {{ $survey_result->loaded_one }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                @if ($survey_result->loaded_two)
                                <tr>
                                    <td></td>
                                    <td>
                                        {{ $survey_result->loaded_two }}
                                    </td>
                                </tr>
                                @endif
                                @if ($survey_result->loaded_three)
                                <tr>
                                    <td></td>
                                    <td>
                                        {{ $survey_result->loaded_three }}
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td>{{ __('lang.feeder_name') }}</td>
                                    <td>
                                        @if ($survey_result->feeder_name)
                                        {{ $survey_result->feeder_name }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.switch_gear') }}</td>
                                    <td>
                                        @if ($survey_result->switch_gear)
                                        {{ $survey_result->switch_gear }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.ct_ration_protect_cond') }}</td>
                                    <td>
                                        @if ($survey_result->ct_ration_protect_cond)
                                        {{ $survey_result->ct_ration_protect_cond }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.line_size_length') }}</td>
                                    <td>
                                        @if ($survey_result->line_size_length)
                                        {{ $survey_result->line_size_length }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.to_connect_distance') }}</td>
                                    <td>
                                        @if ($survey_result->to_connect_distance)
                                        {{ $survey_result->to_connect_distance }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.to_connect_volt') }}</td>
                                    <td>
                                        @if ($survey_result->to_connect_volt)
                                        {{ $survey_result->to_connect_volt }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.new_line_info') }}</td>
                                    <td>
                                        @if ($survey_result->new_line_info)
                                        {{ $survey_result->new_line_info }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.pole_plinth') }}</td>
                                    <td>
                                        @if ($survey_result->pole_plinth)
                                            @if ($survey_result->pole_plinth == 1)
                                        {{ __('lang.pole') }}
                                            @else
                                        {{ __('lang.plinth') }}
                                            @endif
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.type_substation_location') }}</td>
                                    <td>
                                        @if ($survey_result->type_substation_location)
                                            @if ($survey_result->type_substation_location == 1)
                                        {{ __('lang.cdc_grd') }}
                                            @else
                                        {{ __('lang.own_grd') }}
                                            @endif
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.special_requirement') }}</td>
                                    <td>
                                        @if ($survey_result->special_requirement)
                                        {{ $survey_result->special_requirement }}
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

                {!! Form::open(['route' => 'transformerGroundCheckDoneList.store']) !!}
                {!! Form::hidden('form_id', $form->id) !!}

                <div class="row justify-content-center m-t-20">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="tsp_remark" class="text-info">မှတ်ချက်</label>
                            <textarea name="tsp_remark" rows="5" class="form-control" id="tsp_remark" placeholder="မှတ်ချက်ပေးရန်"></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('transformerGroundCheckDoneList.index') }}" class="btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                    <input type="submit" name="survey_submit" value="{{ __('lang.confirm_survey') }}" class="btn btn-rounded btn-info">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection