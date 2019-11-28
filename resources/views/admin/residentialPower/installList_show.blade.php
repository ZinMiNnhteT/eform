@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('residentialPowerMeterCheckInstallList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
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
                                        <h5 class="text-center"><b>အိမ်သုံးပါ၀ါမီတာလျှောက်လွှာပုံစံ</b></h5>
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
                                            <h6>အကြောင်းအရာ။<span class="p-l-40">။</span> <b>အိမ်သုံးပါ၀ါမီတာ တပ်ဆင်ခွင့်ပြုပါရန် လျှောက်ထားခြင်း။</b></h6>
                                        </div>
                                        <div class="p-t-10">
                                            <h6 class="l-h-35">
                                                <span class="p-l-40"></span><span class="p-l-40"></span>
                                                အထက်ပါကိစ္စနှင့်ပတ်သက်၍ {{ address_mm($data->id) }}နေ ကျွန်တော်/ကျွန်မ၏ <b>{{ $data->applied_building_type ? $data->applied_building_type : '<span class="p-l-40"></span>' }}</b> တွင် {{ power_meter_type($data->id) }} တပ်ဆင်သုံးစွဲခွင့်ပြုပါရန် လျှောက်ထားအပ်ပါသည်။
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
                        @if ($survey_result && $survey_result->count() > 0)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#technical" aria-expanded="true" aria-controls="collapseOne">{{ __('မြေပြင်စစ်ဆေးချက်') }}</a>
                                </h5>
                            </div>
                            <div id="technical" class="card-body collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-small-padding">
                                                <tbody>
                                                    <tr class="bg-primary text-white">
                                                        <td class="text-center" colspan="2"><strong>{{ __('lang.chk_person') }}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('lang.account') }} {{ __('lang.name') }}</td>
                                                        <td>{{ who($survey_result->survey_engineer)->username }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('lang.name') }}</td>
                                                        <td>{{ who($survey_result->survey_engineer)->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('lang.position') }}</td>
                                                        <td>{{ who($survey_result->survey_engineer)->position }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('lang.phone') }}</td>
                                                        <td>{{ who($survey_result->survey_engineer)->phone }}</td>
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
                                <div class="container">
                                    <div class="table-responsive">
                                        <table class="table no-border table-md-padding">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 300px">{{ __('lang.survey_date') }}</td>
                                                    <td>{{ survey_accepted_date($data->id) }}</td>
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
                                                    <td>{{ __('lang.survey_prev_meter_no') }}</td>
                                                    <td>
                                                        @if ($survey_result->prev_meter_no)
                                                        {{ checkMM() == 'mm' ? mmNum($survey_result->prev_meter_no) : $survey_result->prev_meter_no }}
                                                        @else
                                                        -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.survey_t_info') }}</td>
                                                    <td>
                                                        @if ($survey_result->t_info)
                                                        {{ checkMM() == 'mm' ? mmNum($survey_result->t_info) : $survey_result->t_info }}
                                                        @else
                                                        -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.survey_max_load') }}</td>
                                                    <td>
                                                        @if ($survey_result->max_load)
                                                        {{ checkMM() == 'mm' ? mmNum($survey_result->max_load) : $survey_result->max_load }}
                                                        @else
                                                        -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.living_cdt') }}</td>
                                                    <td>
                                                        @if ($survey_result->living)
                                                        <p>{{ __('lang.radio_yes') }}</p>
                                                        @elseif (!$survey_result->living)
                                                        <p>{{ __('lang.radio_no') }}</p>
                                                        @else
                                                        -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.residential') }} {{ __('lang.rdy_applied_cdt') }}</td>
                                                    <td>
                                                        @if ($survey_result->meter)
                                                        <p>{{ __('lang.radio_yes') }}</p>
                                                        @elseif (!$survey_result->meter)
                                                        <p>{{ __('lang.radio_no') }}</p>
                                                        @else
                                                        -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.invade_cdt') }}</td>
                                                    <td>
                                                        @if ($survey_result->invade)
                                                            <p>{{ __('lang.radio_yes') }}</p>
                                                        @elseif (!$survey_result->invade)
                                                            <p>{{ __('lang.radio_no') }}</p>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.rpower_loaded_cdt') }}</td>
                                                    <td>
                                                        @if ($survey_result->transmit)
                                                            <p>{{ __('lang.radio_yes') }}</p>
                                                        @elseif (!$survey_result->transmit)
                                                            <p>{{ __('lang.radio_no') }}</p>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.applied_electricpower') }}</td>
                                                    <td>
                                                        @if ($survey_result->comsumed_power_amt)
                                                            <p>{{ $survey_result->comsumed_power_amt }}</p>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.applied_electricpower_photo') }}</td>
                                                    <td>
                                                        @if ($survey_result->r_power_files)
                                                        @php
                                                            $r_power_files = explode(',', $survey_result->r_power_files);
                                                            $i = 1;
                                                        @endphp
                                                        @foreach ($r_power_files as $foto)
                                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
                                                        @php
                                                            $i++;
                                                        @endphp
                                                        @endforeach
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.origin_p_meter') }}</td>
                                                    <td>
                                                        {{ $survey_result->origin_p_meter ? p_meter($survey_result->origin_p_meter) : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.re_choose_p_meter') }}</td>
                                                    <td>
                                                        {{ $survey_result->allow_p_meter ? p_meter($survey_result->allow_p_meter) : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.remark') }}</td>
                                                    <td>
                                                        {{ $survey_result->remark ? $survey_result->remark : '-' }}
                                                    </td>
                                                </tr>
                                                @if($survey_result->remark_tsp)
                                                <tr>
                                                    <td>{{ __('မြို့နယ်ရုံး ') }}{{ __('lang.remark') }}</td>
                                                    <td>
                                                        {{ $survey_result->remark_tsp ? $survey_result->remark_tsp : '-' }}
                                                    </td>
                                                </tr>
                                                @endif
                                                @if($survey_result->remark_dist)
                                                <tr>
                                                    <td>{{ __('ခရိုင်ရုံး ') }}{{ __('lang.remark') }}</td>
                                                    <td>
                                                        {{ $survey_result->remark_dist ? $survey_result->remark_dist : '-' }}
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="card mb-1">
                        @if (chk_userForm($data->id)['to_chk_install'])
                            @if (hasPermissions(['residentialPowerChkInstall-create']))
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('မီတာတပ်ဆင်ရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => 'residentialPowerMeterCheckInstallList.store']) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <div class="container">
                                <div class="row form-group mb-1">
                                    <label for="form_send_date" class="control-label l-h-35 text-md-right col-md-3">လျှောက်လွှာပေးပို့သည့်နေ့စွဲ</label>
                                    <div class="col-md-8">
                                        {!! Form::text('form_send_date', date('Y-m-d', strtotime($data->date)), ['id' => 'form_send_date', 'class' => 'form-control inner-form', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="form_get_date" class="control-label l-h-35 text-md-right col-md-3">လျှောက်လွှာရသည့်နေ့စွဲ</label>
                                    <div class="col-md-8">
                                        {!! Form::text('form_get_date', date('Y-m-d', strtotime($data->date)), ['id' => 'form_get_date', 'class' => 'form-control inner-form', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="date" class="control-label l-h-35 text-md-right col-md-3">နေ့စွဲ</label>
                                    <div class="col-md-8">
                                        {!! Form::text('date', null, ['id' => 'date', 'class' => 'form-control inner-form mydatepicker']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="description" class="control-label l-h-35 text-md-right col-md-3">အကြောင်းအရာ</label>
                                    <div class="col-md-8">
                                        {!! Form::textarea('description', null, ['id' => 'description', 'class' => 'form-control inner-form', 'rows' => '2']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="cash_kyat" class="control-label l-h-35 text-md-right col-md-3">တောင်းသင့်ငွေ</label>
                                    <div class="col-md-8">
                                        {!! Form::number('cash_kyat', null, ['id' => 'cash_kyat', 'class' => 'form-control inner-form', 'placeholder' => __('lang.by_english')]) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="calculator" class="control-label l-h-35 text-md-right col-md-3">တွက်ချက်သူ</label>
                                    <div class="col-md-8">
                                        {!! Form::text('calculator', null, ['id' => 'calculator', 'class' => 'form-control inner-form']) !!}
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="calcu_date" class="control-label l-h-35 text-md-right col-md-3">နေ့စွဲ</label>
                                    <div class="col-md-8">
                                        {!! Form::text('calcu_date', null, ['id' => 'calcu_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="payment_form_no" class="control-label l-h-35 text-md-right col-md-3">ငွေသွင်းရန်အကြောင်းကြားစာအမှတ်</label>
                                    <div class="col-md-8">
                                        {!! Form::text('payment_form_no', null, ['id' => 'payment_form_no', 'class' => 'form-control inner-form']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="payment_form_date" class="control-label l-h-35 text-md-right col-md-3">နေ့စွဲ</label>
                                    <div class="col-md-8">
                                        {!! Form::text('payment_form_date', null, ['id' => 'payment_form_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="deposite_form_no" class="control-label l-h-35 text-md-right col-md-3">အာမခံစဘော်ငွေပြေစာအမှတ်</label>
                                    <div class="col-md-8">
                                        {!! Form::text('deposite_form_no', null, ['id' => 'deposite_form_no', 'class' => 'form-control inner-form']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="deposite_form_date" class="control-label l-h-35 text-md-right col-md-3">နေ့စွဲ</label>
                                    <div class="col-md-8">
                                        {!! Form::text('deposite_form_date', null, ['id' => 'deposite_form_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="somewhat" class="control-label l-h-35 text-md-right col-md-3">၎င်း</label>
                                    <div class="col-md-8">
                                        {!! Form::text('somewhat', null, ['id' => 'somewhat', 'class' => 'form-control inner-form']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="somewhat_form_date" class="control-label l-h-35 text-md-right col-md-3">နေ့စွဲ</label>
                                    <div class="col-md-8">
                                        {!! Form::text('somewhat_form_date', null, ['id' => 'somewhat_form_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="string_form_no" class="control-label l-h-35 text-md-right col-md-3">ကြိုးသွယ်ခနှင့် ဆက်ခပြေစာအမှတ်</label>
                                    <div class="col-md-8">
                                        {!! Form::text('string_form_no', null, ['id' => 'string_form_no', 'class' => 'form-control inner-form']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="string_form_date" class="control-label l-h-35 text-md-right col-md-3">နေ့စွဲ</label>
                                    <div class="col-md-8">
                                        {!! Form::text('string_form_date', null, ['id' => 'string_form_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="service_string_form_date" class="control-label text-md-right col-md-3">လျှပ်စစ်ဓါတ်ကြိုးတပ်ဆင်ခနှင့် ကြီးကြပ်ခပေးဆောင်သည့် နေ့စွဲ</label>
                                    <div class="col-md-8">
                                        {!! Form::text('service_string_form_date', null, ['id' => 'service_string_form_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                                    </div>
                                </div>
    
                            </div>
                            <div class="text-center mt-5">
                                <button type="submit" name="form138_submit" class="waves-effect waves-light btn btn-rounded btn-info">{{ __('lang.submit') }}</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
