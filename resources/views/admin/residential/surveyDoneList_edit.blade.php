@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('residentialMeterGroundCheckDoneList.show', $data->id) }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body card-body-pb-div">
                <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                            <br/>
                <div class="container-fluid">
                    {!! Form::open(['route' => ['residentialMeterGroundCheckDoneListEdit.update'], 'method' => 'PATCH', 'files' => true]) !!}
                    {!! Form::hidden('form_id', $data->id) !!}
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            {{--  line Type  --}}
                            <div class="form-group">
                                <label for="" class="text-info">
                                    {{ __('lang.phase_type') }}
                                </label>
                                <input type="text" name="phase_type" class="form-control mm" value="၁ သွင် ၂ ကြိုး (single phase)" readonly />
                            </div>
                            {{--  Type  --}}
                            <div class="form-group">
                                <label for="" class="text-info">
                                    {{ __('lang.meter_connect_type') }}
                                </label>
                                <select name="applied_type" class="form-control mm" id="type">
                                    <option value="1" {{ $survey_result->applied_type == 1 ? 'selected' : 'disabled' }}>အသစ်</option>
                                    <option value="2" {{ $survey_result->applied_type == 2 ? 'selected' : 'disabled' }}>တိုးချဲ့</option>
                                    <option value="3" {{ $survey_result->applied_type == 3 ? 'selected' : 'disabled' }}>အမည်ပြောင်း</option>
                                    <option value="4" {{ $survey_result->applied_type == 4 ? 'selected' : 'disabled' }}>ပြန်ဆက်</option>
                                    <option value="5" {{ $survey_result->applied_type == 5 ? 'selected' : 'disabled' }}>မီတာခွဲ</option>
                                    <option value="6" {{ $survey_result->applied_type == 6 ? 'selected' : 'disabled' }}>ယာယီ</option>
                                </select>
                            </div>
                            {{--  Voltage  --}}
                            <div class="form-group">
                                <label for="volt" class="text-info">
                                    {{ __('lang.volt') }} <span class="text-danger f-s-15">&#10039;</span>
                                </label>
                                <input type="text" name="volt" value="{{ $survey_result->volt }}" id="volt" class="form-control" required placeholder="{{ __('lang.kv_format') }}">
                            </div>
                            {{--  Kilowatt  --}}
                            <div class="form-group">
                                <label for="kilowatt" class="text-info">
                                    {{ __('lang.kilowatt') }} <span class="text-danger f-s-15">&#10039;</span>
                                </label>
                                <input type="text" name="kilowatt" value="{{ $survey_result->kilowatt }}" id="kilowatt" class="form-control" required>
                            </div>
                            {{--  Distance  --}}
                            <div class="form-group">
                                <label for="" class="text-info">
                                    {{ __('lang.survey_distance') }} <span class="text-danger f-s-15">&#10039;</span>
                                </label>
                                <input type="text" name="distance" value="{{ $survey_result->distance }}" id="distance" class="form-control" required>
                            </div>

                            {{--  Others Survey  --}}
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="bg-secondary p-10">
                                        <label for="" class="text-info">
                                            {{ __('lang.living_cdt') }} <span class="text-danger f-s-15">&#10039;</span>
                                        </label>
                                        <div class="row m-t-20">
                                            <div class="custom-control custom-radio col align-items-center text-center">
                                                <input type="radio" name="living" value="on" class="custom-control-input" id="living_chkbox1" {{ $survey_result->living ? 'checked' : '' }} required>
                                                <label for="living_chkbox1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                            </div>

                                            <div class="custom-control custom-radio col text-center">
                                                <input type="radio" name="living" value="off" class="custom-control-input" id="living_chkbox2" {{ $survey_result->living ? : 'checked' }} required>
                                                <label for="living_chkbox2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-secondary p-10">
                                        <label for="" class="text-info">
                                            {{ __('lang.residential') }} {{ __('lang.rdy_applied_cdt') }}<span class="text-danger f-s-15">&#10039;</span>
                                        </label>
                                        <div class="row m-t-20">
                                            <div class="custom-control custom-radio col text-center">
                                                <input type="radio" name="meter" value="on" class="custom-control-input" id="living_rad1" {{ $survey_result->meter ? 'checked' : '' }} required>
                                                <label for="living_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                            </div>
                                            <div class="custom-control custom-radio col text-center">
                                                <input type="radio" name="meter" value="off" class="custom-control-input" id="living_rad2" {{ $survey_result->meter ? : 'checked' }} required>
                                                <label for="living_rad2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <div class="bg-secondary p-10">
                                        <label for="" class="text-info">
                                            {{ __('lang.invade_cdt') }}<span class="text-danger f-s-15">&#10039;</span>
                                        </label>
                                        <div class="row m-t-20">
                                        
                                            <div class="custom-control custom-radio col text-center">
                                                <input type="radio" name="invade" value="on" class="custom-control-input" id="invade_rad1" {{ $survey_result->invade ? 'checked' : '' }} required>
                                                <label for="invade_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                            </div>
                                            <div class="custom-control custom-radio col text-center">
                                                <input type="radio" name="invade" value="off" class="custom-control-input" id="invade_rad2" {{ $survey_result->invade ? : 'checked' }} required>
                                                <label for="invade_rad2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-secondary p-10">
                                        <label for="" class="text-info">
                                            {{ __('lang.loaded_cdt') }} <span class="text-danger f-s-15">&#10039;</span>
                                        </label>
                                        <div class="row m-t-20">
                                            <div class="custom-control custom-radio col text-center">
                                                <input type="radio" name="loaded" value="on" class="custom-control-input" id="loaded_rad1" {{ $survey_result->loaded ? 'checked' : '' }} required>
                                                <label for="loaded_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                            </div>
                                            <div class="custom-control custom-radio col text-center">
                                                <input type="radio" name="loaded" value="off" class="custom-control-input" id="loaded_rad2" {{ $survey_result->loaded ? : 'checked' }} required>
                                                <label for="loaded_rad2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-t-20">
                                <label for="" class="text-info">
                                    {{ __('lang.applied_electricpower') }}<span class="text-danger f-s-15">&#10039;</span>
                                </label>
                                <input type="text" name="comsumed_power_amt" value="{{ $survey_result->comsumed_power_amt }}" id="comsumed_power_amt" class="form-control" required >
                            </div>
                            <div class="form-group">
                                <label for="front" class="text-info">
                                    {{ __('lang.applied_electricpower_photo') }}
                                </label>
                                <input type="file" name="front" id="front" class="form-control" accept=".jpg,.jpeg,.png,.pdf" >
                                @if ($survey_result->comsumed_power_file)
                                    <div class="row" style="padding-top: 10px;">
                                        <?php 
                                        $filename = asset('storage/user_attachments/'.$data->id.'/'.$survey_result->comsumed_power_file);
                                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                        ;
                                        ?>
                                        @if($ext != 'pdf')
                                        <div class="col-md-2 text-center">
                                            <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->comsumed_power_file) }}" alt="{{ $survey_result->comsumed_power_file }}" class="img-thumbnail imgViewer">
                                        </div>
                                        @else
                                        <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->comsumed_power_file) }}" target="_blank" class="pdf-block">{{ $survey_result->comsumed_power_file }}</a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            @if ($data->apply_division == 2)
                            <div class="form-group">
                                <label for="allowed_type" class="text-info">
                                    {{ __('ခွင့်ပြုမည့် မီတာအမျိုးအစား') }}
                                </label>
                                <select name="allowed_type" class="form-control mm" id="allowed_type">
                                    @foreach ($allowed_types as $type)
                                    <option value="{{ $type->sub_type }}" {{ $type->sub_type == $data->apply_sub_type ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            {{-- location map --}}
                            <div class="form-group">
                                <label for="remark" class="text-info">
                                    {{ __('lang.location_map_2') }}
                                </label>
                                <input type="file" name="location_map" accept=".jpg,.png,.pdf" class="form-control"/>
                                @if ($survey_result->location_map)
                                    <div class="row" style="padding-top: 10px;">
                                        <?php 
                                        $filename = asset('storage/user_attachments/'.$data->id.'/'.$survey_result->location_map);
                                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                        ;
                                        ?>
                                        @if($ext != 'pdf')
                                        <div class="col-md-2 text-center">
                                            <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->location_map) }}" alt="{{ $survey_result->location_map }}" class="img-thumbnail imgViewer">
                                        </div>
                                        @else
                                        <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->location_map) }}" target="_blank" class="pdf-block">{{ $survey_result->location_map }}</a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            {{-- ဓာတ်အားပေးမည့် ထရန်စဖော်မာအမည် --}}
                            <div class="form-group m-t-20">
                                <label for="power_tranformer" class="text-info">
                                    {{ __('lang.power_tranformer') }}
                                </label>
                                <input type="text" name="power_tranformer" value="{{ $survey_result->power_tranformer }}" id="power_tranformer" class="form-control" >
                            </div>
                            {{-- ကေဗွီအေ --}}
                            <div class="form-group m-t-20">
                                <label for="kva" class="text-info">
                                    {{ __('lang.kva') }}
                                </label>
                                <input type="text" name="kva" value="{{ $survey_result->kva }}" id="kva" class="form-control" >
                            </div>
                            {{-- ဝန်အား --}}
                            <div class="form-group m-t-20">
                                <label for="the_load" class="text-info">
                                    {{ __('lang.the_load') }}
                                </label>
                                <input type="text" name="the_load" value="{{ $survey_result->the_load }}" id="the_load" class="form-control" >
                            </div>
                            <div class="form-group m-t-20">
                                <label for="remark" class="text-info">
                                    {{ __('lang.remark') }} <span class="text-danger f-s-15">&#10039;</span>
                                </label>
                                {!! Form::textarea('remark', $survey_result->remark, ['id' => 'remark', 'class' => 'form-control', 'rows' => '3','required']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('residentialMeterGroundCheckDoneList.show', $data->id) }}" class="btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                        <input type="submit" name="survey_submit" value="{{ __('lang.submit') }}" class="btn btn-rounded btn-info ">
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection