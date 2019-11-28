@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('contractorMeterGroundCheckList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>

            <div class="card-body">
                <h3 class="text-center">{{ __('lang.residentSurvey') }} ({{ div_state($form->div_state_id) }}{{ checkMM() == 'mm' ? '၊' : ',' }} {{ district($form->district_id) }})</h3>

                {!! Form::open(['route' => 'contractorMeterGroundCheckDoneList.store', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                <div class="row justify-content-center mt-5">
                    <div class="col-md-8">
                        <div class="table-responsive bg-secondary">
                            <table class="table no-border">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="text-center text-dark">
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
                                        <td>{{ __('lang.tsf_transmit_distance') }} ({{ __('lang.feet') }})</td>
                                        <td>{{ checkMM() == 'mm' ? mmNum($survey_result->tsf_transmit_distance_feet) : $survey_result->tsf_transmit_distance_feet }} {{ __('lang.feet') }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.tsf_transmit_distance') }} ({{ __('lang.kv') }})</td>
                                        <td>{{ checkMM() == 'mm' ? mmNum($survey_result->tsf_transmit_distance_kv) : $survey_result->tsf_transmit_distance_kv }} {{ __('lang.kv') }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('lang.exist_transformer') }}</td>
                                        <td>{{ $survey_result->exist_transformer }}</td>
                                    </tr>
                                    @if ($form->apply_sub_type == 1)
                                    <tr>
                                        <td>{{ __('lang.loaded_cdt') }}</td>
                                        <td>@if ($survey_result->loaded) {{ __('lang.radio_yes') }} @else {{ __('lang.radio_no') }} @endif</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>{{ __('lang.remark') }}</td>
                                        <td>{{ $survey_result->remark }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- ============================== If No Loaded Power ============================== --}}
                    <div class="col-md-8 mt-3">
                        
                        @php
                            $chk_none = '';
                            if ($survey_result->loaded) {
                                $chk_none = 'd-none';
                            }
                        @endphp
                        {{--  <div class="new_tsf {{ $chk_none }}">
                            <div class="form-group row">
                                <label for="new_tsf_name" class="control-label text-md-right col-md-4">
                                    {{ __('lang.new_tsf_name') }}
                                </label>
                                <div class="col-md-8">
                                    <p>{{ $survey_result->new_tsf_name }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="new_tsf_distance" class="control-label text-md-right col-md-4">
                                    {{ __('lang.new_tsf_distance') }} ({{ __('lang.feet') }})
                                </label>
                                <div class="col-md-8">
                                    <p>{{ checkMM() == 'mm' ? mmNum($survey_result->new_tsf_distance) : $survey_result->new_tsf_distance }} {{ __('lang.feet') }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="distance_04" class="control-label text-md-right col-md-4">
                                    {{ __('lang.distance_04') }} ({{ __('lang.feet') }})
                                </label>
                                <div class="col-md-8">
                                    <p>{{ checkMM() == 'mm' ? mmNum($survey_result->distance_04) : $survey_result->distance_04 }} {{ __('lang.feet') }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="new_tsf_info" class="control-label text-md-right col-md-4">
                                    {{ __('lang.new_tsf_info') }} {{ __('lang.volt') }}
                                </label>
                                <div class="col-md-8">
                                    <p>@if ($survey_result->new_tsf_info_volt == 1) {{ __('lang.11_0.4') }} @else {{ __('lang.33_0.4') }} @endif</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="new_tsf_info" class="control-label text-md-right col-md-4">
                                    {{ __('lang.new_tsf_info') }} {{ __('lang.kva') }}
                                </label>
                                <div class="col-md-8">
                                    <p>{{ checkMM() == 'mm' ? mmNum($survey_result->new_tsf_info_kv) : $survey_result->new_tsf_info_kv }} {{ __('lang.kva') }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bq_cost" class="control-label text-md-right col-md-4">
                                    {{ __('lang.bq_cost') }} ({{ __('lang.request') }})
                                </label>
                                <div class="col-md-8">
                                    <p>{{ checkMM() == 'mm' ? mmNum(number_format($survey_result->bq_cost)) : number_format($survey_result->bq_cost) }} {{ __('lang.kyat') }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bq_cost" class="control-label text-md-right col-md-4">
                                    {{ __('lang.bq_cost') }} ({{ __('lang.attach_files') }})
                                </label>
                                <div class="col-md-8">
                                    @if ($survey_result->bq_cost_files)
                                        @php
                                            $bq_foto = explode(',', $survey_result->bq_cost_files);
                                        @endphp
                                        <div class="row">
                                            @foreach ($bq_foto as $foto)
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/user_attachments/'.$form->id.'_'.$form->serial_code.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail">
                                            </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if ($form->apply_sub_type == 1)
                            <div class="form-group row">
                                <label for="budget_name" class="control-label text-md-right col-md-4">
                                    {{ __('lang.budget_name') }}
                                </label>
                                <div class="col-md-8">
                                    <p>{{ $survey_result->budget_name }}</p>
                                </div>
                            </div>
                            @endif

                            <div class="form-group row">
                                <label for="location" class="control-label text-md-right col-md-4">
                                    {{ 'Longitude' }}
                                </label>
                                <div class="col-md-8">
                                    <p>{{ $survey_result->longitude }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="location" class="control-label text-md-right col-md-4">
                                    {{ 'Latitude' }}
                                </label>
                                <div class="col-md-8">
                                    <p>{{ $survey_result->latitude }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bq_cost" class="control-label text-md-right col-md-4">
                                    {{ __('lang.attach_file_location') }}
                                </label>
                                <div class="col-md-8">
                                    @if ($survey_result->location_files)
                                        @php
                                            $location_foto = explode(',', $survey_result->location_files);
                                        @endphp
                                        <div class="row">
                                            @foreach ($location_foto as $foto)
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/user_attachments/'.$form->id.'_'.$form->serial_code.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail">
                                            </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>  --}}
                        @if (!$survey_result->loaded)
                        <h4 class="text-center p-20">ထရန်စဖေါ်မာအသစ် တည်ဆောက်ရန်</h4>
                        <div class="form-group">
                            <label for="new_tsf_name" class="text-info">
                                {{ __('lang.new_tsf_name') }}
                            </label>
                            <textarea name="new_tsf_name" class="form-control" id="new_tsf_name" rows="4"></textarea>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="new_tsf_distance" class="text-info">
                                        {{ __('lang.new_tsf_distance') }} ({{ __('lang.feet') }})
                                    </label>
                                    <input type="number" name="new_tsf_distance" class="form-control" id="new_tsf_distance" min="0" />
                                </div>
                                <div class="col-md-4">
                                    <label for="distance_04" class="text-info">
                                        {{ __('lang.distance_04') }} ({{ __('lang.feet') }})
                                    </label>
                                    <input type="number" name="distance_04" class="form-control" id="distance_04" min="0" />
                                </div>  
                                <div class="col-md-4">
                                    <label class="text-info">{{ __('lang.new_line_type') }} {{ __('lang.kv') }}</label><br/>
                                    <input type="radio" class="check" name="new_line_type" value="11" id="square-radio-1" data-radio="iradio_square-red" checked>
                                    <label for="square-radio-1">11 KV</label>
                                    <input type="radio" class="check" name="new_line_type" value="33" id="square-radio-1" data-radio="iradio_square-red">
                                    <label for="square-radio-1">33 KV</label>
                                    <input type="radio" class="check" name="new_line_type" value="66" id="square-radio-1" data-radio="iradio_square-red">
                                    <label for="square-radio-1">66 KV</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_tsf_info" class="text-info">
                                {{ __('lang.new_tsf_info') }}
                            </label>
                            <div class="bg-secondary p-20">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">(Transformer 1) {{ __('lang.volt') }}</label>
                                        <select name="new_tsf_info_volt" class="form-control" id="new_tsf_info_volt">
                                            <option value="11_0.4">{{ __('lang.11_0.4') }}</option>
                                            <option value="33_0.4">{{ __('lang.33_0.4') }}</option>
                                            <option value="66_0.4">{{ __('lang.66_0.4') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">(Transformer 1) {{ __('lang.kva') }}</label>
                                        <input type="number" name="new_tsf_info_kv" class="form-control" id="new_tsf_info_kv" min="0" />
                                    </div>
                                </div>

                                <div class="row m-t-10">
                                    <div class="col-md-6">
                                        <label for="">(Transformer 2) {{ __('lang.volt') }}</label>
                                        <select name="new_tsf_info_volt_two" class="form-control" id="new_tsf_info_volt_two">
                                            <option value="11_0.4">{{ __('lang.11_0.4') }}</option>
                                            <option value="33_0.4">{{ __('lang.33_0.4') }}</option>
                                            <option value="66_0.4">{{ __('lang.66_0.4') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">(Transformer 2) {{ __('lang.kva') }}</label>
                                        <input type="number" name="new_tsf_info_kv_two" class="form-control" id="new_tsf_info_kv_two" min="0" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="text-info">{{ __('lang.bq_cost') }} ({{ __('lang.kyat') }})</label>
                            <div class="bg-secondary p-20">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">{{ __('lang.request') }}</label>
                                        <input type="number" name="bq_cost" class="form-control inner-form" id="bq_cost" min="0" />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">{{ __('lang.attach_files') }}</label>
                                        <input type="file" name="bq_files[]" class="btn btn-info" id="bq_files" accept=".jpg,.png,.pdf" multiple="" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($form->apply_sub_type == 1)
                        <div class="form-group">
                            <label for="budget_name" class="text-info">
                                {{ __('lang.budget_name') }}
                            </label>
                            <input type="text" name="budget_name" class="form-control" id="budget_name" />
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="location" class="text-info">
                                {{ __('lang.location') }}
                            </label>
                            <div class="bg-secondary p-20">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">{{ 'Latitude' }}</label>
                                        <input type="number" name="latitude" id="latitude" class="form-control" min="0" />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">{{ 'Longitude' }}</label>
                                        <input type="number" name="longitude" id="longitude" class="form-control" min="0" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="location" class="text-info">
                                {{ __('lang.attach_file_location') }}
                            </label>
                            <div class="bg-secondary p-20">
                                <input type="file" name="location_files[]" class="d-block" id="location_files" accept=".jpg,.png,.pdf" multiple="" />
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="remark_tsp" class="text-info">
                                {{ __('lang.remark') }}
                            </label>
                            <textarea name="remark_tsp" class="form-control" id="remark_tsp" rows="4"></textarea>
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
                    <a href="{{ route('contractorMeterGroundCheckList.index') }}" class="btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                    <input type="submit" name="survey_submit_district" value="{{ __('lang.send_district') }}" class="btn btn-rounded btn-info">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection