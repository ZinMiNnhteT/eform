@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('contractorMeterGroundCheckDoneList.show',$form->id) }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            
            <div class="card-body">
                <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                {!! Form::open(['route' => 'contractorMeterGroundCheckList.update', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                <div class="row justify-content-center m-t-20">
                    <div class="col-md-8">
                        {{--  Meter Type  --}}
                        <div class="form-group">
                            <label for="" class="text-info">
                                {{__('lang.confirm_meter_list')}}
                            </label>
                            <div class="bg-secondary p-20">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="hidden" name="room" id="roomCount" value="{{$c_form->room_count}}" />
                                        <label for="">10/60 HHU</label>
                                        <input type="number" name="meter_count" class="form-control" value="{{ $survey_result->meter_count }}" min="0" id="surveyMeter" readonly/>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">10 KW</label>
                                        <input type="number" name="pMeter10_count" value="{{ $survey_result->pMeter10 }}" class="form-control" id="surveyPmeter10" min="0" />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">20 KW</label>
                                        <input type="number" name="pMeter20_count" value="{{ $survey_result->pMeter20 }}" class="form-control" id="surveyPmeter20" min="0" />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">30 KW</label>
                                        <input type="number" name="pMeter30_count" value="{{ $survey_result->pMeter30 }}" class="form-control" id="surveyPmeter30" min="0" />
                                    </div>
                                    <div class="col-md-6 m-t-20">
                                        <label for="">Water Pump (10/60 HHU)</label>
                                        <input type="number" name="water_meter_count" value="{{ $survey_result->water_meter_count }}" class="form-control" min="0" />
                                    </div>
                                    <div class="col-md-6 m-t-20">
                                        <label>Meter Type</label><br/>
                                        <?php if ($survey_result->water_meter_type == 1060): ?>
                                            <input type="radio" class="check" name="water_meter_type" value="1060" id="square-radio-1" data-radio="iradio_square-red" checked>
                                            <label for="square-radio-1">10/60 HHU</label>
                                            <input type="radio" class="check" name="water_meter_type" value="530" id="square-radio-1" data-radio="iradio_square-red">
                                            <label for="square-radio-1">5/30 HHU</label>
                                        <?php else: ?>
                                            <input type="radio" class="check" name="water_meter_type" value="1060" id="square-radio-1" data-radio="iradio_square-red">
                                            <label for="square-radio-1">10/60 HHU</label>
                                            <input type="radio" class="check" name="water_meter_type" value="530" id="square-radio-1" data-radio="iradio_square-red" checked>
                                            <label for="square-radio-1">5/30 HHU</label>
                                        <?php endif ?>
                                            
                                    </div>
                                    <div class="col-md-6 m-t-20">
                                        <label for="">Elevator</label>
                                        <input type="number" name="elevator_meter_count" value="{{ $survey_result->elevator_meter_count }}" class="form-control" min="0" />
                                    </div>
                                    <div class="col-md-6 m-t-20">
                                        <label>Meter Type</label><br/>
                                        <?php if ($survey_result->elevator_meter_type == 10): ?>
                                            <input type="radio" class="check" id="elevatorType-1" name="elevator_meter_type" value="10" data-radio="iradio_square-red" checked>
                                            <label for="elevatorType-1">10-KW</label>
                                            <input type="radio" class="check" id="elevatorType-2" name="elevator_meter_type" value="20" data-radio="iradio_square-red">
                                            <label for="elevatorType-2">20-KW</label>
                                            <input type="radio" class="check" id="elevatorType-3" name="elevator_meter_type" value="30" data-radio="iradio_square-red">
                                            <label for="elevatorType-3">30-KW</label>
                                        <?php elseif ($survey_result->elevator_meter_type == 20): ?>
                                            <input type="radio" class="check" id="elevatorType-1" name="elevator_meter_type" value="10" data-radio="iradio_square-red">
                                            <label for="elevatorType-1">10-KW</label>
                                            <input type="radio" class="check" id="elevatorType-2" name="elevator_meter_type" value="20" data-radio="iradio_square-red" checked>
                                            <label for="elevatorType-2">20-KW</label>
                                            <input type="radio" class="check" id="elevatorType-3" name="elevator_meter_type" value="30" data-radio="iradio_square-red">
                                            <label for="elevatorType-3">30-KW</label>
                                        <?php else: ?>
                                            <input type="radio" class="check" id="elevatorType-1" name="elevator_meter_type" value="10" data-radio="iradio_square-red">
                                            <label for="elevatorType-1">10-KW</label>
                                            <input type="radio" class="check" id="elevatorType-2" name="elevator_meter_type" value="20" data-radio="iradio_square-red">
                                            <label for="elevatorType-2">20-KW</label>
                                            <input type="radio" class="check" id="elevatorType-3" name="elevator_meter_type" value="30" data-radio="iradio_square-red" checked>
                                            <label for="elevatorType-3">30-KW</label>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--  ဓါတ်အားပေးနိုင်မည့် အကွာအဝေး  --}}
                        <div class="form-group">
                            <label class="text-info">{{ __('lang.tsf_transmit_distance') }}</label>
                            <div class="bg-secondary p-20">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">{{ __('lang.feet') }} (FT) <span class="text-danger f-s-15">&#10039;</span></label>
                                        <input type="number" value="<?php echo $survey_result->tsf_transmit_distance_feet ?>" name="tsf_transmit_distance_feet" class="form-control inner-form" id="tsf_transmit_distance" min="0" required/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">{{ __('lang.kv') }} (KV) <span class="text-danger f-s-15">&#10039;</span></label>
                                        <input type="text" value="<?php echo $survey_result->tsf_transmit_distance_kv ?>" name="tsf_transmit_distance_kv" class="form-control" id="tsf_transmit_distance" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--  ဓါတ်အားရယူမည့် ထရန်စဖေါ်မာ  --}}
                        <div class="form-group">
                            <label for="exist_transformer" class="text-info">{{ __('lang.exist_transformer') }} <span class="text-danger f-s-15">&#10039;</span></label>
                            <textarea name="exist_transformer" class="form-control" id="exist_transformer" rows="3" required><?php echo $survey_result->exist_transformer ?></textarea>
                        </div>

                        {{--  under 18 Rooms  --}}
                        @if ($form->apply_division == 1)
                            @if ($form->apply_sub_type == 1)
                        <div class="form-group m-b-20">
                            <label class="text-info">
                                {{ __('lang.loaded_cdt') }}
                            </label>
                            <div class="bg-secondary p-20">
                                <div class="row">
                                    <div class="col-md-6 m-b-20">
                                        <label for="">Amp / ရာခိုင်နှုန်း (%) ဖြင့်ဖေါ်ပြပေးရန် </label>
                                        <input type="text" value="<?php echo $survey_result->amp ?>" name="amp" class="form-control" placeholder="{{ __('lang.load_percent_format') }}" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">ဝန်အားနိုင်နင်းမှု ရွေးချယ်ပေးရန်</label>
                                        <?php if ($survey_result->loaded == true): ?>
                                            <input type="radio" class="check" name="loaded" value="on" id="square-radio-1" data-radio="iradio_square-red" checked>
                                            <label for="square-radio-1">နိုင်နင်းမှု ရှိသည်</label>
                                            <input type="radio" class="check" name="loaded" value="off" id="square-radio-1" data-radio="iradio_square-red" >
                                            <label for="square-radio-1">နိုင်နင်းမှု မရှိပါ</label>
                                        <?php else: ?>
                                            <input type="radio" class="check" name="loaded" value="on" id="square-radio-1" data-radio="iradio_square-red" >
                                            <label for="square-radio-1">နိုင်နင်းမှု ရှိသည်</label>
                                            <input type="radio" class="check" name="loaded" value="off" id="square-radio-1" data-radio="iradio_square-red" checked>
                                            <label for="square-radio-1">နိုင်နင်းမှု မရှိပါ</label>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                            @else
                        <div class="form-group m-b-20">
                            <label class="text-info">
                                {{ __('lang.loaded_cdt') }}
                            </label>
                            <div class="bg-secondary p-20">
                                <div class="row">
                                    <div class="col-md-6 m-b-20">
                                        <label for="">Amp / ရာခိုင်နှုန်း (%) ဖြင့်ဖေါ်ပြပေးရန် </label>
                                        <input type="text" name="amp" class="form-control" placeholder="{{ __('lang.load_percent_format') }}" value="<?php echo $survey_result->amp ?>"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">ဝန်အားနိုင်နင်းမှု ရွေးချယ်ပေးရန်</label>
                                        <?php if ($survey_result->loaded == true): ?>
                                            <input type="radio" class="check" name="loaded" value="on" id="square-radio-1" data-radio="iradio_square-red" checked>
                                            <label for="square-radio-1">နိုင်နင်းမှု ရှိသည်</label>
                                            <input type="radio" class="check" name="loaded" value="off" id="square-radio-1" data-radio="iradio_square-red" >
                                            <label for="square-radio-1">နိုင်နင်းမှု မရှိပါ</label>
                                        <?php else: ?>
                                            <input type="radio" class="check" name="loaded" value="on" id="square-radio-1" data-radio="iradio_square-red" >
                                            <label for="square-radio-1">နိုင်နင်းမှု ရှိသည်</label>
                                            <input type="radio" class="check" name="loaded" value="off" id="square-radio-1" data-radio="iradio_square-red" checked>
                                            <label for="square-radio-1">နိုင်နင်းမှု မရှိပါ</label>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                            @endif
                        @elseif ($form->apply_division == 2)
                        <div class="form-group m-b-20">
                            <label class="text-info">
                                {{ __('lang.loaded_cdt') }}
                            </label>
                            <div class="bg-secondary p-20">
                                <div class="row">
                                    <div class="col-md-6 m-b-20">
                                        <label for="">Amp / ရာခိုင်နှုန်း (%) ဖြင့်ဖေါ်ပြပေးရန် </label>
                                        <input type="text" name="amp" class="form-control" placeholder="{{ __('lang.load_percent_format') }}" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block">ဝန်အားနိုင်နင်းမှု ရွေးချယ်ပေးရန်</label>
                                        <?php if ($survey_result->loaded == true): ?>
                                            <input type="radio" class="check" name="loaded" value="on" id="square-radio-1" data-radio="iradio_square-red" disabled>
                                            <label for="square-radio-1">နိုင်နင်းမှု ရှိသည်</label>
                                            <input type="radio" class="check" name="loaded" value="off" id="square-radio-1" data-radio="iradio_square-red" checked>
                                            <label for="square-radio-1">နိုင်နင်းမှု မရှိပါ</label>
                                        <?php else: ?>
                                            <input type="radio" class="check" name="loaded" value="on" id="square-radio-1" data-radio="iradio_square-red" disabled>
                                            <label for="square-radio-1">နိုင်နင်းမှု ရှိသည်</label>
                                            <input type="radio" class="check" name="loaded" value="off" id="square-radio-1" data-radio="iradio_square-red" checked>
                                            <label for="square-radio-1">နိုင်နင်းမှု မရှိပါ</label>
                                        <?php endif ?>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="location_map" class="text-info">
                                {{ __('lang.location_map_2') }}
                            </label>
                            <input type="file" name="location_map" accept=".jpg,.png,.pdf" class="form-control"/>
                            <div>
                                @if ($survey_result->location_map)
                                    <?php 
                                        $foto = $survey_result->location_map;
                                        $filename = asset('storage/user_attachments/'.$form->id.'/'.$foto);
                                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                        ;
                                    ?>
                                    <div style="padding-top: 10px;">
                                        @if($ext != 'pdf')
                                            <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                        @else
                                            <a href="{{ asset('storage/user_attachments/'.$form->id.'/'.$foto) }}" target="_blank" class="pdf-block">{{ $foto }}</a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="remark" class="text-info">
                                {{ __('lang.remark') }}
                            </label>
                                {!! Form::textarea('remark', $survey_result->remark, ['id' => 'remark', 'class' => 'form-control', 'rows' => '3']) !!}
                        </div>
                                
                    </div>
                        {{-- ============================== If No Loaded Power ============================== --}}
                </div>
                <div class="text-center">
                    <a href="{{ route('contractorMeterGroundCheckDoneList.show',$form->id) }}" class="btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                    <input type="submit" name="survey_request" value="{{ __('lang.submit') }}" class="btn btn-rounded btn-info">                    
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection