@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('transformerCheckInstallList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
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
                                        <h5 class="text-center"><b>ထရန်စဖော်မာ လျှောက်လွှာပုံစံ</b></h5>
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
                                            <h6>အကြောင်းအရာ။<span class="p-l-40">။</span> <b>{{ tsf_type($data->id) }}  တည်ဆောက် တပ်ဆင် ခွင့်ပြုပါရန် လျှောက်ထားခြင်း။</b></h6>
                                        </div>
                                        <div class="p-t-10">
                                            <h6 class="l-h-35">
                                                <span class="p-l-40"></span><span class="p-l-40"></span>
                                                အထက်ပါကိစ္စနှင့်ပတ်သက်၍ {{ address_mm($data->id) }}နေ ကျွန်တော်/ကျွန်မ၏ <b>{{ $data->applied_building_type ? $data->applied_building_type : '<span class="p-l-40"></span>' }}</b> တွင် ထရန်စဖော်မာတစ်လုံး တပ်ဆင်သုံးစွဲခွင့်ပြုပါရန် လျှောက်ထားအပ်ပါသည်။
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
                                    <a data-toggle="collapse" data-parent="#app_show" href="#typeOfMeter" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.applied_plan_tsf') }}</a>
                                </h5>
                            </div>
                            <div id="typeOfMeter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="talbe-responsive p-20">
                                        <table class="table">
                                            <thead>
                                                <tr class="text-center">
                                                    <th rowspan="2" class="align-middle ">{{ __('lang.descriptions') }}</th>
                                                    <th colspan="3">{{ __('lang.initial_cost') }}</th>
                                                </tr>
                                                <tr class="text-center">
                                                    <th>{{ checkMM() === 'mm' ? mmNum(number_format($fee_names->name)) : number_format($fee_names->name) }} {{ __('lang.kva') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $total = 0; @endphp
                                                @foreach ($tbl_col_name as $col_name)
                                                @if ($col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'composit_box' && $col_name != 'sub_type' && $col_name != 'incheck_fee')
                                                <tr>
                                                    <td>{{ __('lang.'.$col_name) }}</td>
                                                    <td class="text-center">{{ checkMM() === 'mm' ? mmNum(number_format($fee_names->$col_name)) : number_format($fee_names->$col_name) }}</td>
                                                    @php $total += $fee_names->$col_name; @endphp

                                                </tr>
                                                @endif
                                                @endforeach
                                                <tr class="text-center">
                                                    <td>{{ __('lang.total') }}</td>
                                                    <td class="text-center "><b>{{ checkMM() == 'mm' ? mmNum(number_format($total)): number_format($total) }}</b></td>
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
                                    <a data-toggle="collapse" data-parent="#app_show" href="#transaction_licence" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.applied_transactionlicence_photo') }}</a>
                                </h5>
                            </div>
                            <div id="transaction_licence" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                    @if  ($file->transaction_licence)
                                <div class="row text-center mt-2">
                                    @php
                                        $transaction_licence = explode(',', $file->transaction_licence);
                                        $i = 1;
                                    @endphp
                                    @foreach ($transaction_licence as $foto)
                                    <div class="col-md-6 text-center">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.transactionlicence_photo') }} ({{ checkMM() =='mm'?mmNum($i):$i }})</p>
                                    </div>
                                    @php
                                        $i++;
                                    @endphp
                                    @endforeach
                                </div>
                                    @else
                                    <h4 class="mt-5 mb-5 text-center text-danger">{{ __('ဓါတ်ပုံတင်ထားခြင်း မရှိပါ') }}</h4>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#electricpower_letter" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.applied_dc_recomm_photo') }}</a>
                                </h5>
                            </div>
                            <div id="electricpower_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                    @if ($file->dc_recomm)
                                <div class="row text-center mt-2">
                                    @php
                                        $electricpower_foto = explode(',', $file->dc_recomm);
                                        $i = 1;
                                    @endphp
                                    @foreach ($electricpower_foto as $foto)
                                    <div class="col-md-6 text-center">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.applied_dc_recomm_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                                    </div>
                                    @php
                                        $i++;
                                    @endphp
                                    @endforeach
                                </div>
                                    @endif
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
                                                <th><strong>{{ __('lang.office_send_date') }}</strong></th>
                                                <th><strong>{{ __('lang.office_send_remark') }}</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($error as $e_remark)
                                            <tr>
                                                <td>
                                                    <strong>
                                                        @if (checkMM() == 'mm')
                                                        {{ $e_remark->created_at ? mmNum(date('d-m-Y၊ H:i နာရီ', strtotime($e_remark->created_at))) : '-' }}
                                                        @else
                                                        {{ $e_remark->created_at ? date('d-m-Y/ H:i A', strtotime($e_remark->created_at)) : '-' }}
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
                                    <a data-toggle="collapse" data-parent="#app_show" href="#form_pending" aria-expanded="true" aria-controls="collapseOne">{{ __('စောင့်ဆိုင်းရခြင်းအကြောင်းအရာများ') }}</a>
                                </h5>
                            </div>
                            <div id="form_pending" class="card-body collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th><strong>{{ __('lang.date') }}</strong></th>
                                                <th><strong>{{ __('အကြောင်းအရာ') }}</strong></th>
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
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#technical" aria-expanded="true" aria-controls="collapseOne">{{ __('Technical Data') }}</a>
                                </h5>
                            </div>
                            <div id="technical" class="card-body collapse" role="tabpanel" aria-labelledby="headingOne">
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
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="table-responsive">
                                            <table class="table no-border table-md-padding">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 300px">{{ __('lang.survey_date') }}</td>
                                                        <td>{{ survey_accepted_date($data->id) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ __('ဓါတ်အားပေးမည့်ပင်ရင်း Source') }}</th>
                                                        <td>
                                                            @if ($survey_result->pri_tsf_name)
                                                            {{ $survey_result->pri_tsf_type.' KV' }} {{ '/' }} {{ $survey_result->pri_main_ct_ratio.' KV' }} {{ $survey_result->pri_tsf_name }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $survey_result->ct_ratio.' KV CT Ratio' }}</td>
                                                        <td>
                                                            @if ($survey_result->ct_ratio_amt)
                                                                {{ $survey_result->ct_ratio_amt }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $survey_result->pri_main_ct_ratio.' KV Main CT Ratio' }}</td>
                                                        <td>
                                                            @if ($survey_result->pri_main_ct_ratio_amt)
                                                                {{ $survey_result->pri_main_ct_ratio_amt }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'ဓါတ်အားခွဲရုံ Capacity' }}</td>
                                                        <td>
                                                            @if ($survey_result->pri_capacity)
                                                                {{ $survey_result->pri_capacity }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $survey_result->main_feeder_peak_load.' KV Main Feeder Peak Load' }}</td>
                                                        <td>
                                                            @if ($survey_result->main_feeder_peak_load_amt)
                                                                {{ $survey_result->main_feeder_peak_load_amt }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $survey_result->pri_feeder_ct_ratio.' KV Feeder CT Ratio' }}</td>
                                                        <td>
                                                            @if ($survey_result->pri_feeder_ct_ratio_amt)
                                                                {{ $survey_result->pri_feeder_ct_ratio_amt }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $survey_result->feeder_peak_load.' KV Feeder Peak Load' }}</td>
                                                        <td>
                                                            @if ($survey_result->feeder_peak_load_amt)
                                                                {{ $survey_result->feeder_peak_load_amt }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                
                                                    <tr>
                                                        <th>{{ __('ဓါတ်အားပေးမည့် Secondary Source') }}</th>
                                                        <td>
                                                            @if ($survey_result->sec_tsf_name)
                                                            {{ $survey_result->sec_tsf_type.' KV' }} {{ '/ 11 KV' }} {{ $survey_result->sec_tsf_name }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $survey_result->sec_main_ct_ratio.' KV Main CT Ratio' }}</td>
                                                        <td>
                                                            @if ($survey_result->sec_main_ct_ratio_amt)
                                                                {{ $survey_result->sec_main_ct_ratio_amt }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ '11 KV Main CT Ratio' }}</td>
                                                        <td>
                                                            @if ($survey_result->sec_11_main_ct_ratio)
                                                                {{ $survey_result->sec_11_main_ct_ratio }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'ဓါတ်အားခွဲရုံ Capacity' }}</td>
                                                        <td>
                                                            @if ($survey_result->sec_capacity)
                                                                {{ $survey_result->sec_capacity }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'Peak Load (Day)' }}</td>
                                                        <td>
                                                            @if ($survey_result->sec_11_peak_load_day)
                                                                {{ $survey_result->sec_11_peak_load_day }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'Peak Load (Night)' }}</td>
                                                        <td>
                                                            @if ($survey_result->sec_11_peak_load_night)
                                                                {{ $survey_result->sec_11_peak_load_night }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'Installed Capacity' }}</td>
                                                        <td>
                                                            @if ($survey_result->sec_11_installed_capacity)
                                                                {{ $survey_result->sec_11_installed_capacity }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <th>{{ __('ဓါတ်အားရယူမည့် Feeder') }}</th>
                                                        <td>
                                                            @if ($survey_result->feeder_name)
                                                            {{ $survey_result->feeder_name }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'CT Ratio' }}</td>
                                                        <td>
                                                            @if ($survey_result->feeder_ct_ratio)
                                                                {{ $survey_result->feeder_ct_ratio }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'Peak Load (Day)' }}</td>
                                                        <td>
                                                            @if ($survey_result->feeder_peak_load_day)
                                                                {{ $survey_result->feeder_peak_load_day }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'Peak Load (Night)' }}</td>
                                                        <td>
                                                            @if ($survey_result->feeder_peak_load_night)
                                                                {{ $survey_result->feeder_peak_load_night }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <th>{{ __('ဓါတ်အားရယူမည့် လိုင်းတစ်လျှောက်ရှိ') }}</th>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('Installed Capacity') }}</td>
                                                        <td>
                                                            @if ($survey_result->online_installed_capacity)
                                                            {{ $survey_result->online_installed_capacity }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'ဓါတ်အားလိုင်းအရှည် (ပေ/မိုင်) (စုစုပေါင်း)' }}</td>
                                                        <td>
                                                            @if ($survey_result->total_line_length)
                                                                {{ $survey_result->total_line_length }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'ဓါတ်အားလိုင်းအရှည် (ပေ/မိုင်) (အဆိုပြုအထိ)' }}</td>
                                                        <td>
                                                            @if ($survey_result->request_line_length)
                                                                {{ $survey_result->request_line_length }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'Conductor Type and Size' }}</td>
                                                        <td>
                                                            @if ($survey_result->conductor)
                                                                {{ $survey_result->conductor }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'လိုင်းကြိုးလဲရန် လို/မလို' }}</td>
                                                        <td>
                                                            @if ($survey_result->string_change == 'yes')
                                                                {{ 'လိုပါသည်' }}
                                                            @else
                                                                {{ 'မလိုပါ' }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'လိုင်းကြိုးအမျိုးအစားနှင့် အရှည်' }}</td>
                                                        <td>
                                                            @if ($survey_result->string_change == 'yes')
                                                                {{ $survey_result->string_change_type_length }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                
                                                    <tr>
                                                        <td>{{ __('ဓါတ်အားခွဲရုံမှူး၏ ထောက်ခံချက်') }}</td>
                                                        <td>
                                                            @if ($survey_result->power_station_recomm)
                                                            <div class="col-md-3 text-center">
                                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->power_station_recomm) }}" alt="{{ $survey_result->power_station_recomm }}" class="img-thumbnail" width="150" height="150">
                                                            </div>
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
                                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->one_line_diagram) }}" alt="{{ $survey_result->one_line_diagram }}" class="img-thumbnail" width="150" height="150">
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
                                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->location_map) }}" alt="{{ $survey_result->location_map }}" class="img-thumbnail" width="150" height="150">
                                                            </div>
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('Google Map') }}</td>
                                                        <td>
                                                            @if ($survey_result->google_map)
                                                            <div class="col-md-3 text-center">
                                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->google_map) }}" alt="{{ $survey_result->google_map }}" class="img-thumbnail" width="150" height="150">
                                                            </div>
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('အသုံးပြုမည့် ဝန်အားစာရင်း') }}</td>
                                                        <td>
                                                            @if ($survey_result->comsumed_power_list)
                                                            <div class="col-md-3 text-center">
                                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->comsumed_power_list) }}" alt="{{ $survey_result->comsumed_power_list }}" class="img-thumbnail" width="150" height="150">
                                                            </div>
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'အင်ဂျင်နီယာမှတ်ချက်' }}</td>
                                                        <td>
                                                            @if ($survey_result->survey_remark)
                                                                {{ $survey_result->survey_remark }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @if ($survey_result->tsp_remark)
                                                    <tr>
                                                        <td>{{ 'မြိုနယ်ရုံးမှတ်ချက်' }}</td>
                                                        <td>
                                                            @if ($survey_result->tsp_remark)
                                                                {{ $survey_result->tsp_remark }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @if ($survey_result->dist_remark)
                                                    <tr>
                                                        <td>{{ 'ခရိုင်ရုံးမှတ်ချက်' }}</td>
                                                        <td>
                                                            @if ($survey_result->dist_remark)
                                                                {{ $survey_result->dist_remark }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @if ($survey_result->capacitor_bank)
                                                    <tr>
                                                        <td>{{ 'Capacitor Bank လို/မလို' }}</td>
                                                        <td>
                                                            @if ($survey_result->capacitor_bank == 'yes')
                                                                {{ 'လိုပါသည်' }}
                                                            @else
                                                                {{ 'မလိုပါ' }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @if ($survey_result->capacitor_bank == 'yes')
                                                    <tr>
                                                        <td>{{ 'Capacitor Bank အမျိုးအစား' }}</td>
                                                        <td>
                                                            @if ($survey_result->capacitor_bank_amt)
                                                                {{ $survey_result->capacitor_bank_amt }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @if ($survey_result->div_state_remark)
                                                    <tr>
                                                        <td>{{ 'တိုင်းဒေသကြီး/ပြည်နယ်ရုံးမှတ်ချက်' }}</td>
                                                        <td>
                                                            @if ($survey_result->div_state_remark)
                                                                {{ $survey_result->div_state_remark }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @if ($survey_result->head_office_remark)
                                                    <tr>
                                                        <td>{{ 'ရုံးချုပ် မှတ်ချက်' }}</td>
                                                        <td>
                                                            @if ($survey_result->head_office_remark)
                                                                {{ $survey_result->head_office_remark }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (chk_userForm($data->id)['to_chk_install'])
                        @if (hasPermissions(['transformerChkInstall-create']))
                    <div class="card mb-1">
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('လုပ်ငန်းကုန်ကျစရိတ် တွက်ရန်နှင့် လုပ်ငန်းဆောင်ရွက်ချက် ညွှန်ကြားရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            {!! Form::open(['route' => 'transformerCheckInstallList.store']) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <div class="container">

                                <div class="row form-group mb-1">
                                    <label for="date" class="control-label l-h-35 text-md-right col-md-3">နေ့စွဲ</label>
                                    <div class="col-md-8">
                                        {!! Form::text('date', null, ['id' => 'date', 'class' => 'form-control inner-form mydatepicker ']) !!}
                                    </div>
                                </div>
                                {{-- <div class="row form-group mb-1">
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
                                </div> --}}
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
                                {{-- <a href="{{ route('transformerCheckInstallList.index') }}" class="btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a> --}}
                                <input type="submit" name="form138_submit" value="{{ __('lang.submit') }}" class="btn btn-rounded btn-info">
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
