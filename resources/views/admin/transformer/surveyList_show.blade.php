@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('transformerGroundCheckList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
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
                                                အထက်ပါကိစ္စနှင့်ပတ်သက်၍ {{ address_mm($data->id) }}နေ ကျွန်တော်/ကျွန်မ၏ <b>{{ $data->applied_building_type ? $data->applied_building_type : '<span class="p-l-40"></span>' }}</b> တွင် {{ tsf_type($data->id) }} တပ်ဆင်သုံးစွဲခွင့်ပြုပါရန် လျှောက်ထားအပ်ပါသည်။
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
                                @if ($file->form_10_front)
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
                                @else
                                <h4 class="mt-5 mb-5 text-center text-danger">{{ __('ဓါတ်ပုံတင်ထားခြင်း မရှိပါ') }}</h4>
                                @endif
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
                        @if ($error->count() > 0)
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
                        @if ($pending->count() > 0)
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
                    @if(hasSurveyTsf($data->id))
                        @if (hasPermissions(['transformerGrdChk-create'])) {{--  if login-user is from township  --}}
                            {{--  @if(Auth::user()->id == hasSurveyTsf($data->id)->survey_engineer)   --}}
                    <div class="card mb-1">
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('Technical Data ဖြည့်သွင်းရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => 'transformerGroundCheckList.store', 'files' => true]) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <h5 class="text-primary">{{ __('ဓါတ်အားပေးမည့်ပင်ရင်း Source') }}</h5>
                                    <div class="form-group row">
                                        <label for="pri_tsf_type" class="col-md-5 col-form-label text-info">{{ __('ဓါတ်အားခွဲရုံ') }}</label>
                                        <div class="col-md-7">
                                            <input type="radio" class="check" name="pri_tsf_type" value="230" id="pri_tsf_type_230" data-radio="iradio_square-red" required>
                                            <label for="pri_tsf_type_230">{{ __('230 KV') }}</label>
                                            <input type="radio" class="check" name="pri_tsf_type" value="132" id="pri_tsf_type_132" data-radio="iradio_square-red" required>
                                            <label for="pri_tsf_type_132">{{ __('132 KV') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pri_tsf_name" class="col-md-5 col-form-label text-info">{{ __('ဓါတ်အားခွဲရုံအမည်') }}</label>
                                        <div class="col-md-7">
                                            <input type="text" name="pri_tsf_name" class="form-control" id="pri_tsf_name" placeholder="ဓါတ်အားခွဲရုံအမည်">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pri_capacity" class="col-md-5 col-form-label text-info">{{ __('ဓါတ်အားခွဲရုံ Capacity') }}</label>
                                        <div class="col-md-7">
                                            <input type="text" name="pri_capacity" id="pri_capacity" class="form-control" placeholder="Capacity">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <input type="radio" class="check" name="ct_ratio" value="230" id="ct_ratio_230" data-radio="iradio_square-red" required>
                                            <label for="ct_ratio_230">{{ __('230 KV') }}</label>
                                            <input type="radio" class="check" name="ct_ratio" value="132" id="ct_ratio_132" data-radio="iradio_square-red" required>
                                            <label for="ct_ratio_132">{{ __('132 KV') }}</label>
                                            <label for="ct_ratio_amt" class="col-form-label text-info">{{ __('CT Ratio') }}</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" name="ct_ratio_amt" id="ct_ratio_amt" class="form-control" placeholder="CT Ratio">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <input type="radio" class="check" name="pri_main_ct_ratio" value="66" id="pri_main_ct_ratio_66" data-radio="iradio_square-red" required>
                                            <label for="pri_main_ct_ratio_66">{{ __('66 KV') }}</label>
                                            <input type="radio" class="check" name="pri_main_ct_ratio" value="33" id="pri_main_ct_ratio_33" data-radio="iradio_square-red" required>
                                            <label for="pri_main_ct_ratio_33">{{ __('33 KV') }}</label>
                                            <label for="pri_main_ct_ratio_amt" class="col-form-label text-info">{{ __('Main CT Ratio') }}</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" name="pri_main_ct_ratio_amt" id="pri_main_ct_ratio_amt" class="form-control" placeholder="Main CT Ratio">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <input type="radio" class="check" name="main_feeder_peak_load" value="66" id="main_feeder_peak_load_66" data-radio="iradio_square-red" required>
                                            <label for="main_feeder_peak_load_66">{{ __('66 KV') }}</label>
                                            <input type="radio" class="check" name="main_feeder_peak_load" value="33" id="main_feeder_peak_load_33" data-radio="iradio_square-red" required>
                                            <label for="main_feeder_peak_load_33">{{ __('33 KV') }}</label>
                                            <label for="main_feeder_peak_load_amt" class="col-form-label text-info">{{ __('Main Feeder Peak Load') }}</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" name="main_feeder_peak_load_amt" id="main_feeder_peak_load_amt" class="form-control" placeholder="Main Feeder Peak Load">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <input type="radio" class="check" name="pri_feeder_ct_ratio" value="66" id="pri_feeder_ct_ratio_66" data-radio="iradio_square-red" required>
                                            <label for="pri_feeder_ct_ratio_66">{{ __('66 KV') }}</label>
                                            <input type="radio" class="check" name="pri_feeder_ct_ratio" value="33" id="pri_feeder_ct_ratio_33" data-radio="iradio_square-red" required>
                                            <label for="pri_feeder_ct_ratio_33">{{ __('33 KV') }}</label>
                                            <label for="pri_feeder_ct_ratio_amt" class="col-form-label text-info">{{ __('Feeder CT Ratio') }}</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" name="pri_feeder_ct_ratio_amt" id="pri_feeder_ct_ratio_amt" class="form-control" placeholder="Feeder CT Ratio">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <input type="radio" class="check" name="feeder_peak_load" value="66" id="feeder_peak_load_66" data-radio="iradio_square-red" required>
                                            <label for="feeder_peak_load_66">{{ __('66 KV') }}</label>
                                            <input type="radio" class="check" name="feeder_peak_load" value="33" id="feeder_peak_load_33" data-radio="iradio_square-red" required>
                                            <label for="feeder_peak_load_33">{{ __('33 KV') }}</label>
                                            <label for="feeder_peak_load_amt" class="col-form-label text-info">{{ __('Feeder Peak Load') }}</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" name="feeder_peak_load_amt" id="feeder_peak_load_amt" class="form-control" placeholder="Feeder Peak Load">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-md-8">
                                    <h5 class="text-primary">{{ __('ဓါတ်အားပေးမည့် Secondary Source') }}</h5>
                                    <div class="form-group row">
                                        <label for="pri_tsf_type" class="col-md-5 col-form-label text-info">{{ __('ဓါတ်အားခွဲရုံ') }}</label>
                                        <div class="col-md-7">
                                            <input type="radio" class="check" name="sec_tsf_type" value="66" id="sec_tsf_type_66" data-radio="iradio_square-red" required>
                                            <label for="sec_tsf_type_66">{{ __('66 KV') }}</label>
                                            <input type="radio" class="check" name="sec_tsf_type" value="33" id="sec_tsf_type_33" data-radio="iradio_square-red" required>
                                            <label for="sec_tsf_type_33">{{ __('33 KV') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="sec_tsf_name" class="col-md-5 col-form-label text-info">{{ __('ဓါတ်အားခွဲရုံအမည်') }}</label>
                                        <div class="col-md-7">
                                            <input type="text" name="sec_tsf_name" class="form-control" id="sec_tsf_name" placeholder="ဓါတ်အားခွဲရုံအမည်">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="sec_capacity" class="col-md-5 col-form-label text-info">{{ __('ဓါတ်အားခွဲရုံ Capacity') }}</label>
                                        <div class="col-md-7">
                                            <input type="text" name="sec_capacity" id="sec_capacity" class="form-control" placeholder="Capacity">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <input type="radio" class="check" name="sec_main_ct_ratio" value="66" id="sec_main_ct_ratio_66" data-radio="iradio_square-red" required>
                                            <label for="sec_main_ct_ratio_66">{{ __('66 KV') }}</label>
                                            <input type="radio" class="check" name="sec_main_ct_ratio" value="33" id="sec_main_ct_ratio_33" data-radio="iradio_square-red" required>
                                            <label for="sec_main_ct_ratio_33">{{ __('33 KV') }}</label>
                                            <label for="sec_main_ct_ratio_amt" class="col-form-label text-info">{{ __('Main CT Ratio') }}</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" name="sec_main_ct_ratio_amt" id="sec_main_ct_ratio_amt" class="form-control" placeholder="Main CT Ratio">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="sec_11_main_ct_ratio" class="col-md-5 col-form-label text-info">{{ __('11KV Main CT Ratio') }}</label>
                                        <div class="col-md-7">
                                            <input type="text" name="sec_11_main_ct_ratio" id="sec_11_main_ct_ratio" class="form-control" placeholder="11KV Main CT Ratio">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="sec_11_peak_load_day" class="col-md-5 col-form-label text-info">{{ __('Peak Load (Day)') }}</label>
                                        <div class="col-md-7">
                                            <input type="text" name="sec_11_peak_load_day" id="sec_11_peak_load_day" class="form-control" placeholder="Peak Load (Day)">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="sec_11_peak_load_night" class="col-md-5 col-form-label text-info">{{ __('Peak Load (Night)') }}</label>
                                        <div class="col-md-7">
                                            <input type="text" name="sec_11_peak_load_night" id="sec_11_peak_load_night" class="form-control" placeholder="Peak Load (Night)">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="sec_11_installed_capacity" class="col-md-5 col-form-label text-info">{{ __('Installed Capacity') }}</label>
                                        <div class="col-md-7">
                                            <input type="text" name="sec_11_installed_capacity" id="sec_11_installed_capacity" class="form-control" placeholder="Installed Capacity">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-md-8">
                                    <h5 class="text-primary">{{ __('ဓါတ်အားရယူမည့် Feeder') }}</h5>
                                    <div class="form-group row">
                                        <label for="feeder_name" class="col-md-5 col-form-label text-info">{{ __('ဖီဒါအမည်') }}</label>
                                        <div class="col-md-7">
                                            <input type="text" name="feeder_name" class="form-control" id="feeder_name" placeholder="ဖီဒါအမည်">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="feeder_ct_ratio" class="col-md-5 col-form-label text-info">{{ __('Feeder CT Ratio') }}</label>
                                        <div class="col-md-7">
                                            <input type="text" name="feeder_ct_ratio" class="form-control" id="feeder_ct_ratio" placeholder="Feeder CT Ratio">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="feeder_peak_load_day" class="col-md-5 col-form-label text-info">{{ __('Feeder Peak Load (Day)') }}</label>
                                        <div class="col-md-7">
                                            <input type="text" name="feeder_peak_load_day" class="form-control" id="feeder_peak_load_day" placeholder="Feeder Peak Load (Day)">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="feeder_peak_load_night" class="col-md-5 col-form-label text-info">{{ __('Feeder Peak Load (Night)') }}</label>
                                        <div class="col-md-7">
                                            <input type="text" name="feeder_peak_load_night" class="form-control" id="feeder_peak_load_night" placeholder="Feeder Peak Load (Night)">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-md-8">
                                    <h5 class="text-primary">{{ __('ဓါတ်အားရယူမည့် လိုင်းတစ်လျှောက်ရှိ') }}</h5>
                                    <div class="form-group row">
                                        <label for="online_installed_capacity" class="col-md-5 col-form-label text-info">{{ __('Installed Capacity') }}</label>
                                        <div class="col-md-7">
                                            <input type="text" name="online_installed_capacity" class="form-control" id="online_installed_capacity" placeholder="Installed Capacity">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="total_line_length" class="col-md-5 col-form-label text-info">{{ __('ဓါတ်အားလိုင်းအရှည် (ပေ/မိုင်) (စုစုပေါင်း)') }}</label>
                                        <div class="col-md-7">
                                            <input type="text" name="total_line_length" class="form-control" id="total_line_length" placeholder="ဓါတ်အားလိုင်းအရှည်">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="request_line_length" class="col-md-5 col-form-label text-info">{{ __('ဓါတ်အားလိုင်းအရှည် (ပေ/မိုင်) (အဆိုပြုအထိ)') }}</label>
                                        <div class="col-md-7">
                                            <input type="text" name="request_line_length" class="form-control" id="request_line_length" placeholder="ဓါတ်အားလိုင်းအရှည်">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="conductor" class="col-md-5 col-form-label text-info">{{ __('Conductor Type and Size') }}</label>
                                        <div class="col-md-7">
                                            <textarea name="conductor" id="conductor" class="form-control" rows="3" placeholder="{{ __('lang.line_size_length_placeholder') }}"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="string_change" class="col-md-5 col-form-label text-info">{{ __('လိုင်းကြိုးလဲရန် လို/မလို') }}</label>
                                        <div class="col-md-7">
                                            <input type="radio" class="check" name="string_change" value="yes" id="string_change_yes" data-radio="iradio_square-red" required>
                                            <label for="string_change_yes">{{ __('လိုပါသည်') }}</label>
                                            <input type="radio" class="check" name="string_change" value="no" id="string_change_no" data-radio="iradio_square-red" required>
                                            <label for="string_change_no">{{ __('မလိုပါ') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="string_change_type_length" class="col-md-5 col-form-label text-info">{{ __('လိုအပ်ပါက လိုင်းကြိုးအမျိုးအစားနှင့် အရှည်') }}</label>
                                        <div class="col-md-7">
                                            <input type="text" name="string_change_type_length" class="form-control" id="string_change_type_length" placeholder="လိုင်းကြိုးအမျိုးအစားနှင့် အရှည်" disabled>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="power_station_recomm" class="text-info">{{ __('ဓါတ်အားခွဲရုံမှူး၏ ထောက်ခံချက်') }}</label>
                                        <div class="bg-secondary p-20">
                                            <input type="file" name="power_station_recomm" id="power_station_recomm" accept=".jpg,.png"/>
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="one_line_diagram" class="text-info">{{ __('lang.one_line_diagram') }}</label>
                                        <div class="bg-secondary p-20">
                                            <input type="file" name="one_line_diagram" id="one_line_diagram" accept=".jpg,.png"/>
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="location_map" class="text-info">{{ __('lang.location_map') }}</label>
                                        <div class="bg-secondary p-20">
                                            <input type="file" name="location_map" id="location_map" accept=".jpg,.png"/>
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="google_map" class="text-info">{{ __('ထရန်စဖော်မာ တည်နေရာ') }}</label>
                                        <div class="bg-secondary p-20">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="longitude">{{ 'လောင်ဂျီကျူ' }}</label>
                                                    <input type="text" name="longitude" class="form-control" id="longitude"/>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="latitude">{{ 'လက်တီကျူ' }}</label>
                                                    <input type="text" name="latitude" class="form-control" id="latitude"/>
                                                </div>
                                                <div class="col-md-12 pt-3">
                                                    <input type="file" name="google_map" id="google_map" accept=".jpg,.png"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="comsumed_power_list" class="text-info">{{ __('အသုံးပြုမည့် ဝန်အားအချက်အလက်') }}</label>
                                        <div class="bg-secondary p-20">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="comsumed_power_amt">{{ __('စုစုပေါင်း အသုံးပြုမည့်ဝန်အား') }}</label>
                                                    <input type="text" name="comsumed_power_amt" id="comsumed_power_amt" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="comsumed_power_list">{{ __('ပူးတွဲပါ ဝန်အားစာရင်း') }}</label>
                                                    <input type="file" name="comsumed_power_list" id="comsumed_power_list" accept=".jpg,.png"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="allowed_tsf" class="text-info">{{ __('ခွင့်ပြုသည့် ထရန်စဖော်မာအမျိုးအစား (KVA)') }}</label>
                                        <div class="bg-secondary p-20">
                                            <select name="allowed_tsf" id="allowed_tsf" class="form-control">
                                                <option value="">{{ __('lang.choose1') }}</option>
                                                @foreach ($kva as $item)
                                                <option value="{{ $item->sub_type }}" {{ $item->sub_type == $data->apply_sub_type ? 'selected' : '' }}>{{ $item->name.' KVA' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {!! Form::hidden('original_tsf', $data->apply_sub_type) !!}
                                    </div>
                                </div>
        
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="survey_remark" class="text-info">{{ __('မှတ်ချက်') }}</label>
                                        <textarea name="survey_remark" class="form-control" id="survey_remark" rows="3" placeholder="မှတ်ချက်"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                {{-- <a href="{{ route('transformerGroundCheckList.index') }}" class="btn btn-rounded btn-secondary ">{{ __('lang.cancel') }}</a> --}}
                                <input type="submit" name="survey_submit" value="{{ __('lang.submit') }}" class="btn btn-rounded btn-info ">
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                            {{--  @endif  --}}
                        @endif
                    @else
                        @if (chk_userForm($data->id)['to_survey'])
                            @if (hasPermissions(['transformerGrdChk-create'])) {{--  if login-user is from township  --}}
                    <div class="card mb-1">
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('lang.choose_engineer') }}</h5>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => 'transformerGroundCheckChoose.store']) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="form-group p-20">
                                        <label for="engineer_id" class="text-info">
                                            {{ __('lang.eng_choose') }}
                                        </label>
                                        <select name="engineer_id" id="engineer_name" class="form-control inner-form {{ checkMM() }}" required>
                                                <option value="">{{ __('lang.choose1') }}</option>
                                                @isset($engineerLists)
                                                 @foreach ($engineerLists as $list) 
                                                 @if($list->hasRole('Junior Engineer'))
                                                 <option value="{{ $list->id }}">{{ checkMM() == 'mm' ? $list->name : $list->name }}</option> 
                                                 @endif 
                                                 @endforeach
                                                @endisset
                                                {{-- <option value="4">{{ 'အင်ယာ၁' }}</option>
                                                <option value="5">{{ 'အင်ယာ၂' }}</option>
                                                <option value="6">{{ 'အင်ယာ၃' }}</option> --}}
                                            </select>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="text-center">
                                {{--  <a href="{{ route('transformerGroundCheckList.index') }}" class="btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>  --}}
                                <input type="submit" name="survey_submit" value="{{ __('lang.choose') }}" class="btn btn-rounded btn-info">
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
