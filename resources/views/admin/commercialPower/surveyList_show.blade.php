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
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#info" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.user_info') }}</a>
                                </h5>
                            </div>
                            <div id="info" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="card-body mm">
                                        <h5 class="text-center"><b>စက်မှုသုံးပါ၀ါမီတာလျှောက်လွှာပုံစံ</b></h5>
                                        <h6 class="text-right">အမှတ်စဥ် - <b>{{ $data->serial_code }}</b></h6>
                                        <div class="p-t-10 p-b-10">
                                            <h6>သို့</h6>
                                            <h6 class="p-l-30 p-t-10">မြို့နယ်လျှပ်စစ်မှူး/မြို့နယ်လျှပ်စစ်အင်ဂျင်နီယာ</h6>
                                            <h6 class="p-l-30 p-t-10">လျှပ်စစ်ဓာတ်အားဖြန့်ဖြူးရေးလုပ်ငန်း</h6>
                                            <h6 class="p-l-30 p-t-10">{{ township_mm($data->township_id) }}</h6>
                                        </div>
                                        <div class="text-right p-t-10">
                                            <h6>ရက်စွဲ။<span class="p-l-20">။</span> {{ mmNum(date('d-m-Y', strtotime($data->date))) }}</h6>
                                        </div>
                                        <div class="p-t-10">
                                            <h6>အကြောင်းအရာ။<span class="p-l-40">။</span> <b>စက်မှုသုံးပါ၀ါမီတာ တပ်ဆင်ခွင့်ပြုပါရန် လျှောက်ထားခြင်း။</b></h6>
                                        </div>
                                        <div class="p-t-10">
                                            <h6 class="l-h-35">
                                                <span class="p-l-40"></span><span class="p-l-40"></span>
                                                အထက်ပါကိစ္စနှင့်ပတ်သက်၍ {{ address_mm($data->id) }}နေ ကျွန်တော်/ကျွန်မ၏ <b>{{ $data->applied_building_type ? $data->applied_building_type : '<span class="p-l-40"></span>' }}</b> တွင် {{ cpower_meter_type($data->id) }} တပ်ဆင်သုံးစွဲခွင့်ပြုပါရန် လျှောက်ထားအပ်ပါသည်။
                                            </h6>
                                            <h6 class="l-h-35">
                                                <span class="p-l-40"></span><span class="p-l-40"></span> တပ်ဆင်သုံးစွဲခွင့်ပြုပါက လျှပ်စစ်ဓာတ်အားဖြန့်ဖြူးရေးလုပ်ငန်းမှ သတ်မှတ်ထားသော အခွန်အခများကို အကြေပေးဆောင်မည့်အပြင် တည်ဆဲဥပဒေများအတိုင်း လိုက်နာဆောင်ရွက်မည်ဖြစ်ပါကြောင်းနှင့် အိမ်တွင်းဝါယာသွယ်တန်းခြင်းလုပ်ငန်းများကို လျှပ်စစ်ကျွမ်းကျင်လက်မှတ်ရှိသူများနှင့်သာ ဆောင်ရွက်မည်ဖြစ်ကြောင်း ဝန်ခံကတိပြုလျှောက်ထားအပ်ပါသည်။
                                            </h6>
                                        </div>
                                        <div class="row justify-content-start m-t-30">
                                            <div class="col-md-4">
                                                <h6 class="l-h-35"><b>တပ်ဆင်သုံးစွဲလိုသည့် လိပ်စာ</b></h6>
                                                <h6 class="l-h-35">
                                                    {{ address_mm($data->id) }}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="row justify-content-around m-t-30">
                                            <div class="col-md-6 offset-md-6">
                                                <h6><b>လေးစားစွာဖြင့်</b></h6>
                                                <h6 style="padding-left: 90px; line-height: 35px;">
                                                    <p class="mb-0">{{ $data->fullname }}</p>
                                                    <p class="mb-0">{{ $data->nrc }}</p>
                                                    <p class="mb-0">{{ $data->applied_phone }}</p>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#typeOfMeter" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.applied_plan') }}</a>
                                </h5>
                            </div>
                            <div id="typeOfMeter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="table-responsive p-20">
                                        <table class="table">
                                            <thead>
                                                <tr class="text-center">
                                                    <th rowspan="2" class="align-middle">{{ __('lang.descriptions') }}</th>
                                                    <th colspan="3">{{ __('lang.initial_cost') }}</th>
                                                </tr>
                                                <tr class="text-center">
                                                    @foreach ($fee_names as $item)
                                                    
                                                    <th>{{ __('lang.'.$item->slug) }}</th>
                                                    
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $total = 0; @endphp
                                                @foreach ($tbl_col_name as $col_name)
                                                @if ($col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'service_fee' && $col_name != 'incheck_fee' && $col_name != 'sub_type')
                                                <tr>
                                                    <td>{{ __('lang.'.$col_name) }}</td>
                                                    @foreach ($fee_names as $fee)
                                                    <td class="text-center">{{ checkMM() === 'mm' ? mmNum(number_format($fee->$col_name)) : number_format($fee->$col_name) }}</td>
                                                    @php $total += $fee->$col_name; @endphp
                                                    @endforeach

                                                </tr>
                                                @endif
                                                @endforeach
                                                <tr class="text-center">
                                                    <td>{{ __('lang.total') }}</td>
                                                    <td class="text-center"><b>{{ checkMM() == 'mm' ? mmNum(number_format($total)): number_format($total) }}</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#nrc" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.nrc') }}</a>
                                </h5>
                            </div>
                            <div id="nrc" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->nrc_copy_front) }}" alt="{{ $file->nrc_copy_front }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.nrc_front') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->nrc_copy_back) }}" alt="{{ $file->nrc_copy_back }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.nrc_back') }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#form10" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.form10') }}</a>
                                </h5>
                            </div>
                            <div id="form10" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->form_10_front) }}" alt="{{ $file->form_10_front }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.form10_front') }}</p>
                                    </div>
                                    @if ($file->form_10_back)
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->form_10_back) }}" alt="{{ $file->form_10_back }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.form10_back') }}</p>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#recommanded_letter" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.recomm') }}</a>
                                </h5>
                            </div>
                            <div id="recommanded_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->occupy_letter) }}" alt="{{ $file->occupy_letter }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.occupy_letter') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->no_invade_letter) }}" alt="{{ $file->no_invade_letter }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.noinvade_letter') }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#owner_letter" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.owner') }}</a>
                                </h5>
                            </div>
                            <div id="owner_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                <div class="row text-center mt-2">
                                    @php
                                        $owner_foto = explode(',', $file->ownership);
                                        $i = 1;
                                    @endphp
                                    @foreach ($owner_foto as $foto)
                                    <div class="col-md-6 text-center">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.owner_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                                    </div>
                                    @php
                                        $i++;
                                    @endphp
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#transaction_letter" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.applied_transactionlicence_photo') }}</a>
                                </h5>
                            </div>
                            <div id="transaction_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                <div class="row text-center mt-2">
                                    @php
                                        $power_foto = explode(',', $file->transaction_licence);
                                        $i = 1;
                                    @endphp
                                    @foreach ($power_foto as $foto)
                                    <div class="col-md-6 text-center">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.transactionlicence_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                                    </div>
                                    @php
                                        $i++;
                                    @endphp
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @if ($error && $error->count() > 0)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#form_resend" aria-expanded="true" aria-controls="collapseOne">{{ __('လျှောက်လွှာပြန်လည်ပြင်ဆင်ချက်များ') }}</a>
                                </h5>
                            </div>
                            <div id="form_resend" class="card-body collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th width="30%"><strong>{{ __('lang.office_send_date') }}</strong></th>
                                                <th><strong>{{ __('lang.office_send_remark') }}</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($error as $e_remark)
                                            <tr>
                                                <td>
                                                    <strong>
                                                        @if (checkMM() == 'mm')
                                                        {{ $e_remark->created_at ? mmNum(date('d-m-Y', strtotime($e_remark->created_at))) : '-' }}
                                                        @else
                                                        {{ $e_remark->created_at ? date('d-m-Y', strtotime($e_remark->created_at)) : '-' }}
                                                        @endif
                                                    </strong>
                                                </td>
                                                <td>@php echo $e_remark->error_remark ? $e_remark->error_remark : '-'; @endphp</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ($pending && $pending->count() > 0)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#pending" aria-expanded="true" aria-controls="collapseOne">{{ __('စောင့်ဆိုင်းရခြင်းအကြောင်းအရာများ') }}</a>
                                </h5>
                            </div>
                            <div id="pending" class="card-body collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th><strong>{{ __('lang.office_send_date') }}</strong></th>
                                                <th><strong>{{ __('lang.office_send_remark') }}</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pending as $pending_case)
                                            <tr>
                                                <td>
                                                    <strong>
                                                        @if (checkMM() == 'mm')
                                                        {{ $pending_case->created_at ? mmNum(date('d-m-Y၊ H:i နာရီ', strtotime($pending_case->created_at))) : '-' }}
                                                        @else
                                                        {{ $pending_case->created_at ? date('d-m-Y/ H:i A', strtotime($pending_case->created_at)) : '-' }}
                                                        @endif
                                                    </strong>
                                                </td>
                                                <td>@php echo $pending_case->pending_remark ? $pending_case->pending_remark : '-'; @endphp</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="card mb-1">
                    @if(hasSurvey($data->id))
                        @if (hasPermissions(['commercialPowerGrdChk-create']))
                            {{--  @if (admin()->id == hasSurvey($data->id)->survey_engineer)  --}}
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('Technical Data ဖြည့်သွင်းရန်') }}</h5>
                        </div>
                        <div class="card-body">
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
                                            {{ __('lang.applied_electricpower') }}
                                        </label>
                                        <input type="text" name="comsumed_power_amt" id="comsumed_power_amt" class="form-control" required>
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="" class="text-info">
                                            {{ __('lang.applied_electricpower_photo') }}
                                        </label>
                                            {!! Form::file('front[]',['class' => 'form-control', 'accept' => '.jpg,.png,.pdf', 'multiple']) !!}
                                            <p class="px-1 py-1 text-danger text-capitalize mm">ပုံများကို တပြိုင်နက်ထဲ ရွေးချယ်တင်နိုင်ပါသည်။</p>
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="allow_p_meter" class="text-info">
                                            {{ __('lang.re_choose_p_meter') }}
                                        </label>
                                        <select name="allow_p_meter" id="allow_p_meter" class="form-control">
                                            <option value="">{{ __('lang.choose1') }}</option>
                                            @foreach ($pm_list as $pm)
                                            <option value="{{ $pm->sub_type }}">{{ __('lang.'.$pm->slug) }}</option>
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
                            {!! Form::open(['route' => 'commercialPowerMeterGroundCheckChoose.store']) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="form-group p-20">
                                        <label for="engineer_id" class="text-info">
                                            {{ __('lang.eng_choose') }}
                                        </label>
                                        <select required name="engineer_id" id="engineer_name" class="form-control inner-form {{ checkMM() }}" required>
                                                <option value="">{{ __('lang.choose1') }}</option>
                                                 @foreach ($engineerLists as $list) 
                                                 @if($list->hasRole('Junior Engineer'))
                                                 <option value="{{ $list->id }}">{{ checkMM() == 'mm' ? $list->name : $list->name }}</option> 
                                                 @endif 
                                                 @endforeach 
                                                {{-- <option value="4">{{ 'အင်ယာ၁' }}</option>
                                                <option value="5">{{ 'အင်ယာ၂' }}</option>
                                                <option value="6">{{ 'အင်ယာ၃' }}</option> --}}
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
