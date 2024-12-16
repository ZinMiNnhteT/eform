@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('commercialPowerMeterGroundCheckDoneList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body card-body-pb-div">
                <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                {!! Form::open(['route' => 'commercialPowerMeterGroundCheckDoneList.update', 'method' => 'PATCH', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                <div class="row justify-content-center mt-3">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="" class="text-info">
                                {{ __('lang.survey_distance') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                            {!! Form::text('distance', $survey_result->distance, ['id' => 'distance', 'class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <label class="text-info">
                                {{ __('lang.survey_prev_meter_no') }} ({{ __('lang.if_have') }})
                            </label>
                                {!! Form::text('prev_meter_no', $survey_result->prev_meter_no, ['id' => 'prev_meter_no', 'class' => 'form-control inner-form']) !!}
                        </div>
                        <div class="form-group">
                            <label for="t_info" class="text-info">
                                {{ __('lang.survey_t_info') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                                <textarea name="t_info" id="t_info" rows="2" class="form-control inner-form">{{ $survey_result->t_info }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="max_load" class="text-info">
                                {{ __('lang.survey_max_load') }} <span class="text-danger f-s-15">&#10039;</span>
                            </label>
                                <textarea name="max_load" id="max_load" rows="2" class="form-control inner-form">{{ $survey_result->max_load }}</textarea>
                        </div>

                        <h5 class="text-info">
                            {{ __('လက်ရှိ ဓာတ်အားခွဲရုံ၊ ဓာတ်အားပေးစက်ရုံ အခြေအနေ') }}
                        </h5>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="curr_transmitter_date" class="text-info">
                                        {{ __('တိုင်းတာသည့် နေ့') }}
                                    </label>
                                    <input type="text" id="curr_transmitter_date" name="curr_transmitter_date" value="{{ $survey_result->curr_transmitter_date != "" ? date('d-m-Y', strtotime($survey_result->curr_transmitter_date)) : null }}" class="form-control mydatepicker">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="curr_transmitter_time" class="text-info">
                                        {{ __('တိုင်းတာသည့် အချိန်') }}
                                    </label>
                                    <input type="text" id="curr_transmitter_time" name="curr_transmitter_time" value="{{ $survey_result->curr_transmitter_date != "" ? date('H:i', strtotime($survey_result->curr_transmitter_date)) : null }}" class="form-control timepicker">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="curr_transmitter_volt" class="text-info">
                                        {{ __('ဗို့အား') }} 
                                    </label>
                                    <input type="number" id="curr_transmitter_volt" name="curr_transmitter_volt" value="{{ $survey_result->curr_transmitter_volt }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <p class="text-info">
                            {{ __('ဝန်အား (Amper)') }}
                        </p>
                        <div class="row mb-2">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="amper_r" class="text-info">
                                        {{ __('R') }}
                                    </label>
                                    <input type="number" id="amper_r" name="amper_r" value="{{ $survey_result->amper_r }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="amper_y" class="text-info">
                                        {{ __('Y') }}
                                    </label>
                                    <input type="number" id="amper_y" name="amper_y" value="{{ $survey_result->amper_y }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="amper_b" class="text-info">
                                        {{ __('B') }}
                                    </label>
                                    <input type="number" id="amper_b" name="amper_b" value="{{ $survey_result->amper_b }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="amper_n" class="text-info">
                                        {{ __('N') }} 
                                    </label>
                                    <input type="number" id="amper_n" name="amper_n" value="{{ $survey_result->amper_n }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <p class="text-info">
                                {{ __('ဓာတ်အားလိုင်း တိုးချဲ့ရန် လို/မလို') }} <span class="text-danger f-s-15">&#10039;</span>
                            </p>
                            <div class="row mt-3">
                                <div class="custom-control custom-radio col-3">
                                    <input type="radio" name="cable_extend" value="on" class="custom-control-input" id="cable_extend_chkbox1" {{ $survey_result->cable_extend ? 'checked' : '' }} required>
                                    <label for="cable_extend_chkbox1" class="custom-control-label p-l-20"><strong>{{ __('လိုပါသည်') }}</strong></label>
                                </div>

                                <div class="custom-control custom-radio col-3">
                                    <input type="radio" name="cable_extend" value="off" class="custom-control-input" id="cable_extend_chkbox2" {{ !$survey_result->cable_extend ? 'checked' : '' }} required>
                                    <label for="cable_extend_chkbox2" class="custom-control-label p-l-20"><strong>{{ __('မလိုပါ') }}</strong></label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <p class="text-info">
                                {{ __('လက်ရှိလျှပ်တာပြောင်းသည် ယခင်က ချို့ယွင်းခဲ့ဖူးခြင်း ရှိ/မရှိ') }} <span class="text-danger f-s-15">&#10039;</span>
                            </p>
                            <div class="row mt-3">
                                <div class="custom-control custom-radio col-3">
                                    <input type="radio" name="transmitter_error" value="on" class="custom-control-input" id="transmitter_error_chkbox1" {{ $survey_result->transmitter_error ? 'checked' : '' }} required>
                                    <label for="transmitter_error_chkbox1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                </div>

                                <div class="custom-control custom-radio col-3">
                                    <input type="radio" name="transmitter_error" value="off" class="custom-control-input" id="transmitter_error_chkbox2" {{ !$survey_result->transmitter_error ? 'checked' : '' }} required>
                                    <label for="transmitter_error_chkbox2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cable_size_type" class="text-info">
                                {{ __('လျှပ်တာပြောင်းမှ ဓာတ်အားသုံးစွဲမည့်နေရာသို့ ဆွဲထားသော လိုင်းကြိုး၊ ကြေးကြိုးအရွယ်အစားနှင့် အရေအတွက်') }} 
                            </label>
                            <input type="text" id="cable_size_type" name="cable_size_type" value="{{ $survey_result->cable_size_type }}" class="form-control">
                        </div>

                        <p class="text-info mb-0">
                            {{ __('နောက်ဆုံး(၆)လအတွင်း စစ်ဆေးရရှိခဲ့သော လျှပ်တာပြောင်း အင်စူလေးရှင်းအခြေအနေနှင့် စစ်ဆေးသောနေ့') }}
                        </p>
                        <div class="form-group">
                            <label for="insulation_date" class="text-info">
                                {{ __('စစ်ဆေးသည့် နေ့') }} 
                            </label>
                            <input type="text" id="insulation_date" name="insulation_date" value="{{ $survey_result->insulation_date != "" ? date('d-m-Y', strtotime($survey_result->insulation_date)) : "" }}" class="form-control mydatepicker">
                        </div>
                        <p class="text-info mb-2">
                            {{ __('အခြေအနေ') }} 
                        </p>
                        <table class="table table-bordered table-sm text-center">
                            <tbody>
                                <tr>
                                    <td colspan="4"><strong>{{ __('Continuity') }}</strong></td>
                                    <td></td>
                                    <td colspan="7"><strong>{{ __('Insulation') }}</strong></td>
                                </tr>
                                <tr>
                                    <td width="8%"></td>
                                    <td width="8%">R-Y</td>
                                    <td width="8%">Y-B</td>
                                    <td width="8%">B-R</td>
                                    <td width="8%"></td>
                                    <td width="8%">R-E</td>
                                    <td width="8%">Y-E</td>
                                    <td width="8%">B-E</td>
                                    <td width="8%">N-E</td>
                                    <td width="8%">R-Y</td>
                                    <td width="8%">H-T-E</td>
                                    <td width="8%">H-T-L-T</td>
                                </tr>
                                <tr>
                                    <td width="8%">H-T</td>
                                    <td width="8%">
                                        <input type="text" name="chtry" value="{{ $survey_result->chtry }}" class="form-control form-control-sm">
                                    </td>
                                    <td width="8%">
                                        <input type="text" name="chtyb" value="{{ $survey_result->chtyb }}" class="form-control form-control-sm">
                                    </td>
                                    <td width="8%">
                                        <input type="text" name="chtbr" value="{{ $survey_result->chtbr }}" class="form-control form-control-sm">
                                    </td>
                                    <td width="8%">H-T</td>
                                    <td width="8%">
                                        <input type="text" name="ihtre" value="{{ $survey_result->ihtre }}" class="form-control form-control-sm">
                                    </td>
                                    <td width="8%">
                                        <input type="text" name="ihtye" value="{{ $survey_result->ihtye }}" class="form-control form-control-sm">
                                    </td>
                                    <td width="8%">
                                        <input type="text" name="ihtbe" value="{{ $survey_result->ihtbe }}" class="form-control form-control-sm">
                                    </td>
                                    <td width="8%">
                                        <input type="text" name="ihtne" value="{{ $survey_result->ihtne }}" class="form-control form-control-sm"> 
                                    </td>
                                    <td width="8%">
                                        <input type="text" name="ihtry" value="{{ $survey_result->ihtry }}" class="form-control form-control-sm">
                                    </td>
                                    <td width="8%">
                                        <input type="text" name="ihthte" value="{{ $survey_result->ihthte }}" class="form-control form-control-sm">
                                    </td>
                                    <td width="8%">
                                        <input type="text" name="ihthtlt" value="{{ $survey_result->ihthtlt }}" class="form-control form-control-sm">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="8%">L-T</td>
                                    <td width="8%">
                                        <input type="text" name="cltry" value="{{ $survey_result->cltry }}" class="form-control form-control-sm">
                                    </td>
                                    <td width="8%">
                                        <input type="text" name="cltyb" value="{{ $survey_result->cltyb }}" class="form-control form-control-sm">
                                    </td>
                                    <td width="8%">
                                        <input type="text" name="cltbr" value="{{ $survey_result->cltbr }}" class="form-control form-control-sm">
                                    </td>
                                    <td width="8%">L-T</td>
                                    <td width="8%">
                                        <input type="text" name="iltre" value="{{ $survey_result->iltre }}" class="form-control form-control-sm">
                                    </td>
                                    <td width="8%">
                                        <input type="text" name="iltye" value="{{ $survey_result->iltye }}" class="form-control form-control-sm">
                                    </td>
                                    <td width="8%">
                                        <input type="text" name="iltbe" value="{{ $survey_result->iltbe }}" class="form-control form-control-sm">
                                    </td>
                                    <td width="8%">
                                        <input type="text" name="iltne" value="{{ $survey_result->iltne }}" class="form-control form-control-sm"> 
                                    </td>
                                    <td width="8%">
                                        <input type="text" name="iltry" value="{{ $survey_result->iltry }}" class="form-control form-control-sm">
                                    </td>
                                    <td width="8%">
                                        <input type="text" name="ilthte" value="{{ $survey_result->ilthte }}" class="form-control form-control-sm">
                                    </td>
                                    <td width="8%">
                                        <input type="text" name="ilthtlt" value="{{ $survey_result->ilthtlt }}" class="form-control form-control-sm">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="bg-secondary p-10">
                                    <label for="">
                                        {{ __('lang.living_cdt') }} <span class="text-danger f-s-15">&#10039;</span>
                                    </label>
                                    <div class="row mt-3">
                                    
                                        <div class="custom-control custom-radio col align-items-center text-center">
                                            <input type="radio" name="living" value="on" class="custom-control-input" id="living_chkbox1" {{ $survey_result->living ? 'checked' : '' }}>
                                            <label for="living_chkbox1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                        </div>

                                        <div class="custom-control custom-radio col text-center">
                                            <input type="radio" name="living" value="off" class="custom-control-input" id="living_chkbox2" {{ !$survey_result->living ? 'checked' : '' }}>
                                            <label for="living_chkbox2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-secondary p-10">
                                    <label for="">
                                        {{ __('lang.residential') }} {{ __('lang.rdy_applied_cdt') }} <span class="text-danger f-s-15">&#10039;</span>
                                    </label>
                                    <div class="row mt-3">
                                        <div class="custom-control custom-radio col text-center">
                                            <input type="radio" name="meter" value="on" class="custom-control-input" id="living_rad1" {{ $survey_result->meter ? 'checked' : '' }}>
                                            <label for="living_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                        </div>
                                        <div class="custom-control custom-radio col text-center">
                                            <input type="radio" name="meter" value="off" class="custom-control-input" id="living_rad2" {{ !$survey_result->meter ? 'checked' : '' }}>
                                            <label for="living_rad2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="bg-secondary p-10">
                                    <label for="">
                                        {{ __('lang.invade_cdt') }} <span class="text-danger f-s-15">&#10039;</span>
                                    </label>
                                    <div class="row mt-3">
                                    
                                        <div class="custom-control custom-radio col text-center">
                                            <input type="radio" name="invade" value="on" class="custom-control-input" id="invade_rad1" {{ $survey_result->invade ? 'checked' : '' }}>
                                            <label for="invade_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                        </div>
                                        <div class="custom-control custom-radio col text-center">
                                            <input type="radio" name="invade" value="off" class="custom-control-input" id="invade_rad2" {{ !$survey_result->invade ? 'checked' : '' }}>
                                            <label for="invade_rad2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-secondary p-10">
                                    <label for="">
                                        {{ __('lang.rpower_loaded_cdt') }} <span class="text-danger f-s-15">&#10039;</span>
                                    </label>
                                    <div class="row mt-3">
                                        <div class="custom-control custom-radio col text-center">
                                            <input type="radio" name="transmit" value="on" class="custom-control-input" id="loaded_rad1" {{ $survey_result->transmit ? 'checked' : '' }}>
                                            <label for="loaded_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                        </div>
                                        <div class="custom-control custom-radio col text-center">
                                            <input type="radio" name="transmit" value="off" class="custom-control-input" id="loaded_rad2" {{ !$survey_result->transmit ? 'checked' : '' }}>
                                            <label for="loaded_rad2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <label for="" class="text-info">
                                {{ __('lang.applied_electricpower') }}
                            </label>
                            <input type="text" name="comsumed_power_amt" value="{{ $survey_result->comsumed_power_amt }}" id="comsumed_power_amt" class="form-control">
                        </div>
                        <div class="form-group mt-4">
                            <label for="" class="text-info">
                                {{ __('lang.applied_electricpower_photo') }}
                            </label>
                            {!! Form::file('front[]',['class' => 'form-control', 'accept' => '.jpg,.png,.pdf', 'multiple']) !!}
                            <p class="px-1 py-1 text-danger text-capitalize mm">ပုံများကို တပြိုင်နက်ထဲ ရွေးချယ်တင်နိုင်ပါသည်။</p>
                            @if ($survey_result->r_power_files)
                                <div class="row" style="margin-top: -10px">
                                    @php
                                        $r_power_files = explode(',', $survey_result->r_power_files);
                                        $i = 1;
                                    @endphp
                                    @foreach ($r_power_files as $foto)
                                    <?php 
                                        $filename = asset('storage/user_attachments/'.$form->id.'/'.$foto);
                                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                        ;
                                    ?>
                                    @if($ext != 'pdf')
                                        <div class="col-md-2 text-center">
                                            <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                        </div>
                                    @else
                                        <a href="{{ asset('storage/user_attachments/'.$form->id.'/'.$foto) }}" target="_blank" class="pdf-block">{{ $foto }}</a>
                                    @endif
                                    @php
                                        $i++;
                                    @endphp
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="form-group mt-4">
                            <label for="" class="text-info">
                                {{ __('အဆောက်အဦ ဓါတ်ပုံ') }}
                            </label>
                            {!! Form::file('building_photos[]',['class' => 'form-control', 'accept' => '.jpg,.png,.pdf', 'multiple']) !!}
                            <p class="px-1 py-1 text-danger text-capitalize mm">ပုံများကို တပြိုင်နက်ထဲ ရွေးချယ်တင်နိုင်ပါသည်။</p>
                            @if ($survey_result->r_building_files)
                                <div class="row" style="margin-top: -10px;">
                                    @php
                                        $r_building_files = explode(',', $survey_result->r_building_files);
                                        $i = 1;
                                    @endphp
                                    @foreach ($r_building_files as $foto)
                                    <?php 
                                        $filename = asset('storage/user_attachments/'.$form->id.'/'.$foto);
                                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                        ;
                                    ?>
                                    @if($ext != 'pdf')
                                        <div class="col-md-2 text-center">
                                            <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                        </div>
                                    @else
                                        <a href="{{ asset('storage/user_attachments/'.$form->id.'/'.$foto) }}" target="_blank" class="pdf-block">{{ $foto }}</a>
                                    @endif
                                    @php
                                        $i++;
                                    @endphp
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="remark" class="text-info">
                                {{ __('lang.location_map_2') }}
                            </label>
                            <input type="file" name="location_map" accept=".jpg,.png,.pdf" class="form-control"/>
                            @if ($survey_result->location_map)
                                <div class="row" style="padding-top: 10px;">
                                    <?php 
                                    $filename = asset('storage/user_attachments/'.$form->id.'/'.$survey_result->location_map);
                                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                    ;
                                    ?>
                                    @if($ext != 'pdf')
                                    <div class="col-md-2 text-center">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$survey_result->location_map) }}" alt="{{ $survey_result->location_map }}" class="img-thumbnail imgViewer">
                                    </div>
                                    @else
                                    <a href="{{ asset('storage/user_attachments/'.$form->id.'/'.$survey_result->location_map) }}" target="_blank">{{ $survey_result->location_map }}</a>
                                    @endif
                                </div>
                            @endif
                        </div>

                        {{-- ဓာတ်အားပေးမည့် ထရန်စဖော်မာ --}}
                        <div class="form-group">
                            <label for="power_tranformer" class="text-info">
                                {{ __('lang.power_tranformer') }}
                            </label>
                            <input type="text" name="power_tranformer"  class="form-control" value="{{ $survey_result->power_tranformer }}"/>
                        </div>

                        {{-- ၄၀၀ဗို့ ဓာတ်အားလိုင်းပြမြေပုံ --}}
                        <div class="form-group">
                            <label for="line_map_400" class="text-info">
                                {{ __('lang.line_map_400') }}
                            </label>
                            <input type="file" name="line_map_400" accept=".jpg,.png,.pdf" class="form-control" />
                            @if ($survey_result->line_map_400)
                                <div class="row" style="padding-top: 10px;">
                                    <?php 
                                    $filename = asset('storage/user_attachments/'.$form->id.'/'.$survey_result->line_map_400);
                                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                    ;
                                    ?>
                                    @if($ext != 'pdf')
                                    <div class="col-md-2 text-center">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$survey_result->line_map_400) }}" alt="{{ $survey_result->line_map_400 }}" class="img-thumbnail imgViewer">
                                    </div>
                                    @else
                                    <a href="{{ asset('storage/user_attachments/'.$form->id.'/'.$survey_result->line_map_400) }}" target="_blank">{{ $survey_result->line_map_400 }}</a>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="form-group mt-4">
                            <label for="allow_p_meter" class="text-info">
                                {{ __('lang.re_choose_p_meter') }}
                            </label>
                            <select name="allow_p_meter" id="allow_p_meter" class="form-control">
                                <option value="">{{ __('lang.choose1') }}</option>
                                @foreach ($pm_list as $pm)
                                <option value="{{ $pm->sub_type }}" {{ $pm->sub_type == $survey_result->allow_p_meter ? 'selected' : '' }}>{{ __('lang.'.$pm->slug) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-4">
                            <label for="remark" class="text-info">
                                {{ __('lang.remark') }}
                            </label>
                            {!! Form::textarea('remark', $survey_result->remark, ['id' => 'remark', 'class' => 'form-control', 'rows' => '3']) !!}
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" name="survey_submit" class="waves-effect waves-light btn btn-rounded btn-info ">{{ __('lang.submit') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection