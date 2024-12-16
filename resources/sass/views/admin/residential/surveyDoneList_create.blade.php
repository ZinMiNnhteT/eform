@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0 {{ lang() }}">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('residentialMeterGroundCheckDoneList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5 {{ lang() }}"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>

            <div class="card-body">
            
                <h3 class="text-center {{ lang() }}">{{ __('lang.residentSurvey') }} ({{ div_state($form->div_state_id) }}{{ checkMM() == 'mm' ? '၊' : ',' }} {{ district($form->district_id) }})</h3>

                {!! Form::open(['route' => 'residentialMeterGroundCheckDoneList.store']) !!}
                {!! Form::hidden('form_id', $form->id) !!}

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
                                        <td>{{ __('lang.survey_distance') }}</td>
                                        <td>
                                            @if ($survey_result->distance)
                                            {{ checkMM() == 'mm' ? mmNum($survey_result->distance) : $survey_result->distance }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.living_cdt') }}</td>
                                        <td>
                                            @if ($survey_result->living == null)
                                                -
                                            @elseif ($survey_result->living)
                                                <p class="{{ lang() }}">{{ __('lang.radio_yes') }}</p>
                                            @elseif (!$survey_result->living)
                                                <p class="{{ lang() }}">{{ __('lang.radio_no') }}</p>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.residential') }} {{ __('lang.rdy_applied_cdt') }}</td>
                                        <td>
                                            @if ($survey_result->meter == true)
                                                <p class="{{ lang() }}">{{ __('lang.radio_yes') }}</p>
                                            @elseif ($survey_result->meter == false)
                                                <p class="{{ lang() }}">{{ __('lang.radio_no') }}</p>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.invade_cdt') }}</td>
                                        <td>
                                            @if ($survey_result->invade == true)
                                                <p class="{{ lang() }}">{{ __('lang.radio_yes') }}</p>
                                            @elseif ($survey_result->invade == false)
                                                <p class="{{ lang() }}">{{ __('lang.radio_no') }}</p>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.loaded_cdt') }}</td>
                                        <td>
                                            @if ($survey_result->loaded == true)
                                                <p class="{{ lang() }}">{{ __('lang.radio_yes') }}</p>
                                            @elseif ($survey_result->loaded == false)
                                                <p class="{{ lang() }}">{{ __('lang.radio_no') }}</p>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.remark') }}</td>
                                        <td>
                                            {{ $survey_result->remark ? $survey_result->remark : '-' }}
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
                <div class="text-center">
                    <a href="{{ route('residentialMeterGroundCheckDoneList.index') }}" class="btn btn-rounded btn-secondary {{ lang() }}">{{ __('lang.cancel') }}</a>
                    <input type="submit" name="survey_submit" value="{{ __('lang.confirm_survey') }}" class="btn btn-rounded btn-info {{ lang() }}">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection