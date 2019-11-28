@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('contractorMeterGroundCheckDoneListByDistrict.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body">
                <h3 class="text-center">{{ __('lang.residentSurvey') }} ({{ div_state($form->div_state_id) }}{{ checkMM() == 'mm' ? '၊' : ',' }} {{ district($form->district_id) }})</h3>

                {!! Form::model($survey_result, ['route' => 'contractorMeterGroundCheckDoneListByDistrict.store', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                
                <div class="row justify-content-center mt-5">

                    <div class="col-md-10">
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
                                        <td>{{ __('lang.serial') }}</td>
                                        <td>{{ $form->serial_code }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.fullname') }}</td>
                                        <td>{{ $form->fullname }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.applied_address') }}</td>
                                        <td>{{ address($form->id) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.meter_count') }}</td>
                                        <td>{{ contrator_meter_count($form->id) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.tsf_transmit_distance') }}</td>
                                        <td>
                                            {{ checkMM() == 'mm' ? mmNum($survey_result->tsf_transmit_distance_feet) : $survey_result->tsf_transmit_distance_feet }} {{ __('lang.feet') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.tsf_transmit_distance') }} ({{ __('lang.kv') }})</td>
                                        <td>
                                            {{ checkMM() == 'mm' ? mmNum($survey_result->tsf_transmit_distance_kv) : $survey_result->tsf_transmit_distance_kv }} {{ __('lang.kv') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.exist_transformer') }}</td>
                                        <td>{{ $survey_result->exist_transformer }}</td>
                                    </tr>
                                    @if ($form->apply_sub_type == 1)
                                    <tr>
                                        <td>{{ __('lang.loaded_cdt') }}</td>
                                        <td>
                                            @if ($survey_result->loaded) {{ __('lang.radio_yes') }} @else {{ __('lang.radio_no') }} @endif
                                        </td>
                                    </tr>
                                    @endif
                                    @if(!$survey_result->loaded)
                                    <tr>
                                        <td>{{ __('lang.new_tsf_name') }}</td>
                                        <td>{{ $survey_result->new_tsf_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.new_line_type') }} ({{ __('lang.kv') }})</td>
                                        <td>
                                            {{ $survey_result->new_line_type }} {{ __('lang.kv') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.new_tsf_distance') }} ({{ __('lang.feet') }})</td>
                                        <td>
                                            {{ checkMM() == 'mm' ? mmNum($survey_result->new_tsf_distance) : $survey_result->new_tsf_distance }} {{ __('lang.feet') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.distance_04') }} ({{ __('lang.feet') }})</td>
                                        <td>
                                            {{ checkMM() == 'mm' ? mmNum($survey_result->distance_04) : $survey_result->distance_04 }} {{ __('lang.feet') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.new_tsf_info') }} {{ __('lang.volt') }} ({{ __('lang.one') }})</td>
                                        <td>
                                            {{ __('lang.'.$survey_result->new_tsf_info_volt) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.new_tsf_info') }} {{ __('lang.kva') }} ({{ __('lang.one') }})</td>
                                        <td>
                                            {{ checkMM() == 'mm' ? mmNum($survey_result->new_tsf_info_kv) : $survey_result->new_tsf_info_kv }} {{ __('lang.kva') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.new_tsf_info') }} {{ __('lang.volt') }} ({{ __('lang.two') }})</td>
                                        <td>
                                            {{ __('lang.'.$survey_result->new_tsf_info_volt_two) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.new_tsf_info') }} {{ __('lang.kva') }} ({{ __('lang.two') }})</td>
                                        <td>
                                            {{ checkMM() == 'mm' ? mmNum($survey_result->new_tsf_info_kv_two) : $survey_result->new_tsf_info_kv_two }} {{ __('lang.kva') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.bq_cost') }} ({{ __('lang.request') }})</td>
                                        <td>
                                            {{ checkMM() == 'mm' ? mmNum(number_format($survey_result->bq_cost)) : number_format($survey_result->bq_cost) }} {{ __('lang.kyat') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.bq_cost') }} ({{ __('lang.attach_files') }})</td>
                                        <td>
                                            @if ($survey_result->bq_cost_files)
                                            @php
                                                $bq_foto = explode(',', $survey_result->bq_cost_files);
                                            @endphp
                                            <div class="row">
                                                @foreach ($bq_foto as $foto)
                                                <div class="col-md-3 text-center">
                                                    <img src="{{ asset('storage/app/public/user_attachments/'.$form->id.'_'.$form->serial_code.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail">
                                                </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        </td>
                                    </tr>
                                    @if ($form->apply_sub_type == 1)
                                    <tr>
                                        <td>{{ __('lang.budget_name') }}</td>
                                        <td>
                                            {{ $survey_result->budget_name }}
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>Location on Map</td>
                                        <td>{{ $survey_result->latitude }} {{ $survey_result->longitude ? ',' : '' }} {{ $survey_result->longitude }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.attach_file_location_show') }}</td>
                                        <td>
                                             @if ($survey_result->location_files)
                                                @php
                                                    $location_foto = explode(',', $survey_result->location_files);
                                                @endphp
                                                <div class="row">
                                                    @foreach ($location_foto as $foto)
                                                    <div class="col-md-3 text-center">
                                                        <img src="{{ asset('storage/app/public/user_attachments/'.$form->id.'_'.$form->serial_code.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail">
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>{{ __('lang.remark') }}</td>
                                        <td>{{ $survey_result->remark }}</td>
                                    </tr>
                                    @if ($survey_result->remark_tsp)
                                    <tr>
                                        <td></td>
                                        <td>{{ $survey_result->remark_tsp }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if(!$survey_result->loaded)
                    <div class="col-md-6 m-t-20">
                        <div class="form-group">
                            <label for="bq_cost_dist" class="text-info">
                                {{ __('lang.bq_cost') }} ({{ __('lang.kyat') }}) {{ __('lang.bq_confirm') }}
                            </label>
                            <input type="number" name="bq_cost_dist" value="{{ $survey_result->bq_cost }}" class="form-control" id="bq_cost" min="0" />
                        </div>
                        <div class="form-group">
                            <label for="bq_files" class="text-info">{{ __('lang.bq_cost') }} ({{ __('lang.attach_files') }})</label>
                            <div class="bg-secondary p-20">
                                <input type="file" name="bq_files[]" accept=".jpg,.png,.pdf" multiple="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="districtRemark" class="text-info">မှတ်ချက်</label>
                            <textarea name="remark_dist" class="form-control" placeholder="မှတ်ချက်ပေးရန်"></textarea>
                        </div>
                    </div>
                    @endif
                   
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

                <hr/>
                <div class="text-center">
                    <a href="{{ route('contractorMeterGroundCheckDoneListByDistrict.index') }}" class="btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                    {{--  <input type="submit" name="survey_submit_district" value="{{ __('lang.send_tsp') }}" class="btn btn-rounded btn-info">  --}}
                    <input type="submit" name="survey_submit_district" value="{{ __('lang.send_div_state') }}" class="btn btn-rounded btn-info">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection