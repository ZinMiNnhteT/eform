@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('commercialPowerMeterGroundCheckList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body card-body-pb-div">

                @include('layouts.form-progressbar')

                <div class="container-fluid">
                    <div id="app_show" class="accordion" role="tablist" aria-multiselectable="true">
                        
                        @include('layouts.user_apply_form')

                    </div>
                    <div class="card mb-1">
                    @if(hasSurvey($data->id))
                        @if (hasPermissions(['commercialPowerGrdChk-create']))
                            {{--  @if (admin()->id == hasSurvey($data->id)->survey_engineer)  --}}
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('Technical Data ဖြည့်သွင်းရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                            <br/>
                            {!! Form::open(['route' => 'commercialPowerMeterGroundCheckList.store', 'files' => true]) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <div class="row justify-content-center mt-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="" class="text-info">
                                            {{ __('lang.survey_distance') }} <span class="text-danger f-s-15">&#10039;</span>
                                        </label>
                                        {!! Form::text('distance', null, ['id' => 'distance', 'class' => 'form-control' , 'required']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label class="text-info">
                                            {{ __('lang.survey_prev_meter_no') }} ({{ __('lang.if_have') }})
                                        </label>
                                            {!! Form::text('prev_meter_no', null, ['id' => 'prev_meter_no', 'class' => 'form-control inner-form']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="t_info" class="text-info">
                                            {{ __('lang.survey_t_info') }} <span class="text-danger f-s-15">&#10039;</span>
                                        </label>
                                            <textarea name="t_info" id="t_info" rows="2" class="form-control inner-form" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="max_load" class="text-info">
                                            {{ __('lang.survey_max_load') }} <span class="text-danger f-s-15">&#10039;</span>
                                        </label>
                                            <textarea name="max_load" id="max_load" rows="2" class="form-control inner-form" required></textarea>
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
                                                <input type="text" id="curr_transmitter_date" name="curr_transmitter_date" class="form-control mydatepicker">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="curr_transmitter_time" class="text-info">
                                                    {{ __('တိုင်းတာသည့် အချိန်') }} 
                                                </label>
                                                <input type="text" id="curr_transmitter_time" name="curr_transmitter_time" class="form-control timepicker">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="curr_transmitter_volt" class="text-info">
                                                    {{ __('ဗို့အား') }}
                                                </label>
                                                <input type="number" id="curr_transmitter_volt" name="curr_transmitter_volt" class="form-control">
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
                                                <input type="number" id="amper_r" name="amper_r" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="amper_y" class="text-info">
                                                    {{ __('Y') }}
                                                </label>
                                                <input type="number" id="amper_y" name="amper_y" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="amper_b" class="text-info">
                                                    {{ __('B') }}
                                                </label>
                                                <input type="number" id="amper_b" name="amper_b" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="amper_n" class="text-info">
                                                    {{ __('N') }}
                                                </label>
                                                <input type="number" id="amper_n" name="amper_n" class="form-control">
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="mb-2">
                                        <p class="text-info">
                                            {{ __('ဓာတ်အားလိုင်း တိုးချဲ့ရန် လို/မလို') }} <span class="text-danger f-s-15">&#10039;</span>
                                        </p>
                                        <div class="row mt-3">
                                            <div class="custom-control custom-radio col-3" required>
                                                <input type="radio" name="cable_extend" value="on" class="custom-control-input" id="cable_extend_chkbox1">
                                                <label for="cable_extend_chkbox1" class="custom-control-label p-l-20"><strong>{{ __('လိုပါသည်') }}</strong></label>
                                            </div>

                                            <div class="custom-control custom-radio col-3">
                                                <input type="radio" name="cable_extend" value="off" class="custom-control-input" id="cable_extend_chkbox2" required>
                                                <label for="cable_extend_chkbox2" class="custom-control-label p-l-20"><strong>{{ __('မလိုပါ') }}</strong></label>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="mb-2">
                                        <p class="text-info">
                                            {{ __('လက်ရှိလျှပ်တာပြောင်းသည် ယခင်က ချို့ယွင်းခဲ့ဖူးခြင်း ရှိ/မရှိ') }} <span class="text-danger f-s-15">&#10039;</span>
                                        </p>
                                        <div class="row mt-3">
                                            <div class="custom-control custom-radio col-3" required>
                                                <input type="radio" name="transmitter_error" value="on" class="custom-control-input" id="transmitter_error_chkbox1">
                                                <label for="transmitter_error_chkbox1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                            </div>

                                            <div class="custom-control custom-radio col-3">
                                                <input type="radio" name="transmitter_error" value="off" class="custom-control-input" id="transmitter_error_chkbox2" required>
                                                <label for="transmitter_error_chkbox2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="form-group">
                                        <label for="cable_size_type" class="text-info">
                                            {{ __('လျှပ်တာပြောင်းမှ ဓာတ်အားသုံးစွဲမည့်နေရာသို့ ဆွဲထားသော လိုင်းကြိုး၊ ကြေးကြိုးအရွယ်အစားနှင့် အရေအတွက်') }}
                                        </label>
                                        <input type="text" id="cable_size_type" name="cable_size_type" class="form-control">
                                    </div>
    
                                    <p class="text-info mb-0">
                                        {{ __('နောက်ဆုံး(၆)လအတွင်း စစ်ဆေးရရှိခဲ့သော လျှပ်တာပြောင်း အင်စူလေးရှင်းအခြေအနေနှင့် စစ်ဆေးသောနေ့') }}
                                    </p>
                                    <div class="form-group">
                                        <label for="insulation_date" class="text-info">
                                            {{ __('စစ်ဆေးသည့် နေ့') }} 
                                        </label>
                                        <input type="text" id="insulation_date" name="insulation_date" class="form-control mydatepicker">
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
                                                    <input type="text" name="chtry" class="form-control form-control-sm">
                                                </td>
                                                <td width="8%">
                                                    <input type="text" name="chtyb" class="form-control form-control-sm">
                                                </td>
                                                <td width="8%">
                                                    <input type="text" name="chtbr" class="form-control form-control-sm">
                                                </td>
                                                <td width="8%">H-T</td>
                                                <td width="8%">
                                                    <input type="text" name="ihtre" class="form-control form-control-sm">
                                                </td>
                                                <td width="8%">
                                                    <input type="text" name="ihtye" class="form-control form-control-sm">
                                                </td>
                                                <td width="8%">
                                                    <input type="text" name="ihtbe" class="form-control form-control-sm">
                                                </td>
                                                <td width="8%">
                                                    <input type="text" name="ihtne" class="form-control form-control-sm"> 
                                                </td>
                                                <td width="8%">
                                                    <input type="text" name="ihtry" class="form-control form-control-sm">
                                                </td>
                                                <td width="8%">
                                                    <input type="text" name="ihthte" class="form-control form-control-sm">
                                                </td>
                                                <td width="8%">
                                                    <input type="text" name="ihthtlt" class="form-control form-control-sm">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="8%">L-T</td>
                                                <td width="8%">
                                                    <input type="text" name="cltry" class="form-control form-control-sm">
                                                </td>
                                                <td width="8%">
                                                    <input type="text" name="cltyb" class="form-control form-control-sm">
                                                </td>
                                                <td width="8%">
                                                    <input type="text" name="cltbr" class="form-control form-control-sm">
                                                </td>
                                                <td width="8%">L-T</td>
                                                <td width="8%">
                                                    <input type="text" name="iltre" class="form-control form-control-sm">
                                                </td>
                                                <td width="8%">
                                                    <input type="text" name="iltye" class="form-control form-control-sm">
                                                </td>
                                                <td width="8%">
                                                    <input type="text" name="iltbe" class="form-control form-control-sm">
                                                </td>
                                                <td width="8%">
                                                    <input type="text" name="iltne" class="form-control form-control-sm"> 
                                                </td>
                                                <td width="8%">
                                                    <input type="text" name="iltry" class="form-control form-control-sm">
                                                </td>
                                                <td width="8%">
                                                    <input type="text" name="ilthte" class="form-control form-control-sm">
                                                </td>
                                                <td width="8%">
                                                    <input type="text" name="ilthtlt" class="form-control form-control-sm">
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
                                                
                                                    <div class="custom-control custom-radio col align-items-center text-center" required>
                                                        <input type="radio" name="living" value="on" class="custom-control-input" id="living_chkbox1">
                                                        <label for="living_chkbox1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                                    </div>

                                                    <div class="custom-control custom-radio col text-center">
                                                        <input type="radio" name="living" value="off" class="custom-control-input" id="living_chkbox2" required>
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
                                                        <input type="radio" name="meter" value="on" class="custom-control-input" id="living_rad1" required>
                                                        <label for="living_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                                    </div>
                                                    <div class="custom-control custom-radio col text-center">
                                                        <input type="radio" name="meter" value="off" class="custom-control-input" id="living_rad2" required>
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
                                                        <input type="radio" name="invade" value="on" class="custom-control-input" id="invade_rad1" required>
                                                        <label for="invade_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                                    </div>
                                                    <div class="custom-control custom-radio col text-center">
                                                        <input type="radio" name="invade" value="off" class="custom-control-input" id="invade_rad2" required>
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
                                                        <input type="radio" name="transmit" value="on" class="custom-control-input" id="loaded_rad1" required>
                                                        <label for="loaded_rad1" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_yes') }}</strong></label>
                                                    </div>
                                                    <div class="custom-control custom-radio col text-center">
                                                        <input type="radio" name="transmit" value="off" class="custom-control-input" id="loaded_rad2" required>
                                                        <label for="loaded_rad2" class="custom-control-label p-l-20"><strong>{{ __('lang.radio_no') }}</strong></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="" class="text-info">
                                            {{ __('lang.applied_electricpower') }} <span class="text-danger f-s-15">&#10039;</span>
                                        </label>
                                        <input type="text" name="comsumed_power_amt" id="comsumed_power_amt" class="form-control" required>
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="" class="text-info">
                                            {{ __('lang.applied_electricpower_photo') }} <span class="text-danger f-s-15">&#10039;</span>
                                        </label>
                                        {!! Form::file('front[]',['class' => 'form-control', 'accept' => '.jpg,.png,.pdf', 'multiple',"required"]) !!}
                                        <p class="px-1 py-1 text-danger text-capitalize mm">ပုံများကို တပြိုင်နက်ထဲ ရွေးချယ်တင်နိုင်ပါသည်။</p>
                                    </div>
                                    
                                    <div class="form-group mt-4">
                                        <label for="" class="text-info">
                                            {{ __('အဆောက်အဦ ဓါတ်ပုံ') }}
                                        </label>
                                        {!! Form::file('building_photos[]',['class' => 'form-control', 'accept' => '.jpg,.png,.pdf', 'multiple']) !!}
                                        <p class="px-1 py-1 text-danger text-capitalize mm">ပုံများကို တပြိုင်နက်ထဲ ရွေးချယ်တင်နိုင်ပါသည်။</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="location_map" class="text-info">
                                            {{ __('lang.location_map_2') }}
                                        </label>
                                        <input type="file" name="location_map" accept=".jpg,.png,.pdf" class="form-control"/>
                                    </div>

                                    {{-- ဓာတ်အားပေးမည့် ထရန်စဖော်မာ --}}
                                    <div class="form-group">
                                        <label for="power_tranformer" class="text-info">
                                            {{ __('lang.power_tranformer') }}
                                        </label>
                                        <input type="text" name="power_tranformer"  class="form-control"/>
                                    </div>

                                    {{-- ၄၀၀ဗို့ ဓာတ်အားလိုင်းပြမြေပုံ --}}
                                    <div class="form-group">
                                        <label for="line_map_400" class="text-info">
                                            {{ __('lang.line_map_400') }}
                                        </label>
                                        <input type="file" name="line_map_400" accept=".jpg,.png,.pdf" class="form-control"/>
                                    </div>

                                    <div class="form-group mt-4">
                                        <label for="allow_p_meter" class="text-info">
                                            {{ __('lang.re_choose_p_meter') }}
                                        </label>
                                        <select name="allow_p_meter" id="allow_p_meter" class="form-control">
                                            <option value="">{{ __('lang.choose1') }}</option>
                                            @foreach ($pm_list as $pm)
                                            <option value="{{ $pm->sub_type }}"{{ $pm->sub_type == $data->apply_sub_type ? ' selected' : '' }}>{{ __('lang.'.$pm->slug) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="remark" class="text-info">
                                            {{ __('lang.remark') }}
                                        </label>
                                        {!! Form::textarea('remark', null, ['id' => 'remark', 'class' => 'form-control', 'rows' => '3']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="survey_submit" class="waves-effect waves-light btn btn-rounded btn-info ">{{ __('lang.submit') }}</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                            {{--  @endif  --}}
                        @endif
                    @else
                        @if (chk_userForm($data->id)['to_survey'])
                            @if (hasPermissions(['commercialPowerGrdChk-create']))
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('lang.choose_engineer') }}</h5>
                        </div>
                        <div class="card-body">
                            <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                            <br/>
                            {!! Form::open(['route' => 'commercialPowerMeterGroundCheckChoose.store']) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="form-group p-20">
                                        <label for="engineer_id" class="text-info">
                                            {{ __('lang.eng_choose') }} <span class="text-danger f-s-15">&#10039;</span>
                                        </label>
                                        <select required name="engineer_id" id="engineer_name" class="form-control inner-form" required>
                                            <option value="">{{ __('lang.choose1') }}</option>
                                            @isset($engineerLists)
                                            @foreach ($engineerLists as $list) 
                                            @if($list->hasRole('အငယ်တန်းအင်ဂျင်နီယာ'))
                                            <option value="{{ $list->id }}">{{ checkMM() == 'mm' ? $list->name : $list->name }}</option> 
                                            @endif 
                                            @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="text-center">
                                <input type="submit" name="survey_submit" value="{{ __('lang.choose') }}" class="btn btn-rounded btn-info">
                            </div>
                            {!! Form::close() !!}
                        </div>
                            @endif
                        @endif
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
