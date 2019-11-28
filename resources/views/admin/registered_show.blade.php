@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('registered_form.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body card-body-pb-div">
                <div class="container-fluid">
                    {{-- @if(count($meter_infos) > 0)
                    <div class="row justify-content-center mt-5 mb-5">
                        <div class="col-md-12">
                            <div class="table-responsive bg-secondary">
                                <table class="table no-border">
                                    <thead>
                                        <tr>
                                            <th colspan="13" class="text-center text-dark">
                                                <h4>{{__('lang.registered_meter_info')}}</h4>
                                            </th>
                                        </tr>
                                        <tr class="bg-primary text-white table-bordered">
                                            <th>{{__('lang.meter_no')}}</th>
                                            <th>{{__('lang.meter_seal_no')}}</th>
                                            <th>{{__('lang.meter_get_date')}}</th>
                                            <th>{{__('lang.who_made_meter')}}</th>
                                            <th>{{__('lang.ampere')}}</th>
                                            <th>{{__('lang.pay_date')}}</th>
                                            <th>{{__('lang.mark_user_no')}}</th>
                                            <th>{{__('lang.budget')}}</th>
                                            <th>{{__('lang.move_date')}}</th>
                                            <th>{{__('lang.move_budget')}}</th>
                                            <th>{{__('lang.move_order')}}</th>
                                            <th>{{__('lang.test_date')}}</th>
                                            <th>{{__('lang.test_no')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($meter_infos as $info)
                                        <tr>
                                            <td>{{$info->meter_no}}</td>
                                            <td>{{$info->meter_seal_no}}</td>
                                            <td>{{$info->meter_get_date}}</td>
                                            <td>{{$info->who_made_meter}}</td>
                                            <td>{{$info->ampere}}</td>
                                            <td>{{$info->pay_date}}</td>
                                            <td>{{$info->mark_user_no}}</td>
                                            <td>{{$info->budget}}</td>
                                            <td>{{$info->move_date}}</td>
                                            <td>{{$info->move_budget}}</td>
                                            <td>{{$info->move_order}}</td>
                                            <td>{{$info->test_date}}</td>
                                            <td>{{$info->test_no}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> 
                    @endif --}}
                    {{-- <div class="row justify-content-center mt-5">
                        <div class="col-md-10">
                            <div class="table-responsive bg-secondary">
                                <table class="table no-border">
                                    <thead>
                                        <tr>
                                            <th colspan="2" class="text-center text-dark">
                                                <h4>စစ်ဆေးခြင်း</h4>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="2"><b>{{__('lang.accept_title')}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>{{__('lang.form_accepted_date')}}</td>
                                            <td>{{accepted_date($data->id)}}</td>
                                        </tr>

                                         <tr>
                                            <td colspan="2"><b>{{__('lang.residentSurvey')}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>{{__('lang.survey_date')}}</td>
                                            <td>{{survey_accepted_date($data->id)}}</td>
                                        </tr>
                                        @if($data->apply_type == 5)
                                        <tr>
                                            <td colspan="2"><b>{{__('lang.survey_confirm_to_dist_by_tsp')}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>{{__('lang.chk_survey_date')}}</td>
                                            <td>{{survey_confirmed_date($data->id)}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('lang.chk_person')}}</td>
                                            <td>{{ who($survey_result->survey_engineer) }}</td>
                                        </tr>
                                        @else
                                         <tr>
                                            <td colspan="2"><b>{{__('lang.residentSurveyDone')}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>{{__('lang.chk_survey_date')}}</td>
                                            <td>{{survey_confirmed_date($data->id)}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('lang.chk_person')}}</td>
                                            <td>{{ who($survey_result->survey_engineer) }}</td>
                                        </tr>
                                        @endif
                                         <tr>
                                            <td colspan="2"><b>{{__('lang.announce')}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>{{__('lang.announced_date')}}</td>
                                            <td>{{announced_date($data->id)}}</td>
                                        </tr>

                                         <tr>
                                            <td colspan="2"><b>{{__('lang.confirm_payment')}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>{{__('lang.form_accepted_date')}}</td>
                                            <td>{{payment_accepted_date($data->id)}}</td>
                                        </tr>

                                         <tr>
                                            <td colspan="2"><b>{{__('lang.check_to_install')}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>{{__('lang.install_date')}}</td>
                                            <td>{{install_accepted_date($data->id)}}</td>
                                        </tr>

                                         <tr>
                                            <td colspan="2"><b>{{__('lang.to_register')}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>{{__('lang.register_date')}}</td>
                                            <td>{{registered_meter_date($data->id)}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><br> --}}
                    @if($data->apply_type == 1)
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
                                        <h5 class="text-center"><b>အိမ်သုံးမီတာလျှောက်လွှာပုံစံ</b></h5>
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
                                            <h6>အကြောင်းအရာ။<span class="p-l-40">။</span> <b>အိမ်သုံးမီတာ တပ်ဆင်ခွင့်ပြုပါရန် လျှောက်ထားခြင်း။</b></h6>
                                        </div>
                                        <div class="p-t-10">
                                            <h6 class="l-h-35">
                                                <span class="p-l-40"></span><span class="p-l-40"></span>
                                                အထက်ပါကိစ္စနှင့်ပတ်သက်၍ {{ address_mm($data->id) }}နေ ကျွန်တော်/ကျွန်မ၏ <b>{{ $data->applied_building_type ? $data->applied_building_type : '<span class="p-l-40"></span>' }}</b> တွင် (အိမ်သုံး) မီတာတစ်လုံး တပ်ဆင်သုံးစွဲခွင့်ပြုပါရန် လျှောက်ထားအပ်ပါသည်။
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
                                    <div class="talbe-responsive p-20">
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
                                                @if ($col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'composit_box' && $col_name != 'sub_type')
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->nrc_copy_front) }}" alt="{{ $file->nrc_copy_front }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.nrc_front') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->nrc_copy_back) }}" alt="{{ $file->nrc_copy_back }}" class="img-thumbnail" width="150" height="150">
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->form_10_front) }}" alt="{{ $file->form_10_front }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.form10_front') }}</p>
                                    </div>
                                    @if ($file->form_10_back)
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->form_10_back) }}" alt="{{ $file->form_10_back }}" class="img-thumbnail" width="150" height="150">
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->occupy_letter) }}" alt="{{ $file->occupy_letter }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.occupy_letter') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->no_invade_letter) }}" alt="{{ $file->no_invade_letter }}" class="img-thumbnail" width="150" height="150">
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
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
                                    <a data-toggle="collapse" data-parent="#app_show" href="#form_pending" aria-expanded="true" aria-controls="collapseOne">{{ __('စောင့်ဆိုင်းရခြင်းအကြောင်းအရာများ') }}</a>
                                </h5>
                            </div>
                            <div id="form_pending" class="card-body collapse" role="tabpanel" aria-labelledby="headingOne">
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
                                <div class="container">
                                    <div class="table-responsive">
                                        <table class="table no-border table-md-padding">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 300px">{{ __('lang.survey_date') }}</td>
                                                    <td>{{ survey_accepted_date($data->id) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.volt') }}</td>
                                                    <td>
                                                        @if ($survey_result->volt)
                                                        {{ checkMM() == 'mm' ? mmNum($survey_result->volt) : $survey_result->volt }}
                                                        @else
                                                        -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.kilowatt') }}</td>
                                                    <td>
                                                        @if ($survey_result->kilowatt)
                                                        {{ checkMM() == 'mm' ? mmNum($survey_result->kilowatt) : $survey_result->kilowatt }}
                                                        @else
                                                        -
                                                        @endif
                                                    </td>
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
                                                    <td>{{ __('lang.living_cdt') }}</td>
                                                    <td>
                                                        @if ($survey_result->living == null)
                                                            -
                                                        @elseif ($survey_result->living)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_yes') }}</p>
                                                        @elseif (!$survey_result->living)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_no') }}</p>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.residential') }} {{ __('lang.rdy_applied_cdt') }}</td>
                                                    <td>
                                                        @if ($survey_result->meter == true)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_yes') }}</p>
                                                        @elseif ($survey_result->meter == false)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_no') }}</p>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.invade_cdt') }}</td>
                                                    <td>
                                                        @if ($survey_result->invade == true)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_yes') }}</p>
                                                        @elseif ($survey_result->invade == false)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_no') }}</p>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.loaded_cdt') }}</td>
                                                    <td>
                                                        @if ($survey_result->loaded == true)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_yes') }}</p>
                                                        @elseif ($survey_result->loaded == false)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_no') }}</p>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.applied_electricpower') }}</td>
                                                    <td>
                                                        {{ $survey_result->comsumed_power_amt ? $survey_result->comsumed_power_amt : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.applied_electricpower_photo') }}</td>
                                                    <td>
                                                        @if ($survey_result->comsumed_power_file)
                                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$survey_result->comsumed_power_file) }}" alt="{{ $survey_result->comsumed_power_file }}" class="img-thumbnail" width="150" height="150">
                                                        @else
                                                        -
                                                        @endif
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
                                                    <td>{{ __('မြို့နယ်ရုံး မှတ်ချက်') }}</td>
                                                    <td>
                                                        {{ $survey_result->remark_tsp ? $survey_result->remark_tsp : '-' }}
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
                        @if ($install && $install->count() > 0)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#form_install" aria-expanded="true" aria-controls="collapseOne">{{ __('တပ်ဆင်ခြင်း') }}</a>
                                </h5>
                            </div>
                            <div id="form_install" class="card-body collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="row justify-content-center m-t-20">
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table no-border table-md-padding">
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->form_send_date ? mmNum(date('d-m-Y', strtotime($install->form_send_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('အကြောင်းအရာ')}}</td>
                                                   <td>{{$install->description}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('တောင်းသင့်ငွေ')}}</td>
                                                   <td>{{$install->cash_kyat}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('တွက်ချက်သူ')}}</td>
                                                   <td>{{$install->calculator}}</td>
                                               </tr>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->calcu_date ? mmNum(date('d-m-Y', strtotime($install->calcu_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('ငွေသွင်းရန်အကြောင်းကြားစာအမှတ်')}}</td>
                                                   <td>{{$install->payment_form_no}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->payment_form_date ? mmNum(date('d-m-Y', strtotime($install->payment_form_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('အာမခံစဘော်ငွေပြေစာအမှတ်')}}</td>
                                                   <td>{{$install->deposite_form_no}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->deposite_form_date ? mmNum(date('d-m-Y', strtotime($install->deposite_form_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('၎င်း')}}</td>
                                                   <td>{{$install->somewhat}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->somewhat_form_date ? mmNum(date('d-m-Y', strtotime($install->somewhat_form_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('ကြိုးသွယ်ခနှင့် ဆက်ခပြေစာအမှတ်')}}</td>
                                                   <td>{{$install->string_form_no}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->string_form_date ? mmNum(date('d-m-Y', strtotime($install->string_form_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('လျှပ်စစ်ဓါတ်ကြိုးတပ်ဆင်ခနှင့် ကြီးကြပ်ခပေးဆောင်သည့် နေ့စွဲ')}}</td>
                                                   <td>{{ $install->service_string_form_date ? mmNum(date('d-m-Y', strtotime($install->service_string_form_date))) : '-' }}</td>
                                               </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($meter_infos && $meter_infos->count() > 0)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#registered" aria-expanded="true" aria-controls="collapseOne">{{__('lang.registered_meter_info')}}</a>
                                </h5>
                            </div>
                            <div id="registered" class="card-body collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <table class="table no-border table-small-padding">
                                            <tbody>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.meter_no')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_no ? $meter_infos->meter_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.meter_seal_no')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_seal_no ? $meter_infos->meter_seal_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.meter_get_date')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_get_date ? mmNum(date('d-m-Y', strtotime($meter_infos->meter_get_date))) : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.who_made_meter')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->who_made_meter ? $meter_infos->who_made_meter : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.ampere')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->ampere ? $meter_infos->ampere : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.pay_date')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->pay_date ? mmNum(date('d-m-Y', strtotime($meter_infos->pay_date))) : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.mark_user_no')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->mark_user_no ? $meter_infos->mark_user_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.budget')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->budget ? $meter_infos->budget : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.move_date')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->move_date ? mmNum(date('d-m-Y', strtotime($meter_infos->move_date))) : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.move_budget')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->move_budget ? $meter_infos->move_budget : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.move_order')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->move_order ? $meter_infos->move_order : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.test_date')}}
                                                    </td>
                                                    <td>
                                                        {{ $meter_infos->test_date ? mmNum(date('d-m-Y', strtotime($meter_infos->test_date))) : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.test_no')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->test_no ? $meter_infos->test_no : '-'}}
                                                    </td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @elseif($data->apply_type == 2)
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->nrc_copy_front) }}" alt="{{ $file->nrc_copy_front }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.nrc_front') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->nrc_copy_back) }}" alt="{{ $file->nrc_copy_back }}" class="img-thumbnail" width="150" height="150">
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->form_10_front) }}" alt="{{ $file->form_10_front }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.form10_front') }}</p>
                                    </div>
                                    @if ($file->form_10_back)
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->form_10_back) }}" alt="{{ $file->form_10_back }}" class="img-thumbnail" width="150" height="150">
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->occupy_letter) }}" alt="{{ $file->occupy_letter }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.occupy_letter') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->no_invade_letter) }}" alt="{{ $file->no_invade_letter }}" class="img-thumbnail" width="150" height="150">
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
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
                                                        @if ($survey_result->living == null)
                                                            -
                                                        @elseif ($survey_result->living)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_yes') }}</p>
                                                        @elseif (!$survey_result->living)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_no') }}</p>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.residential') }} {{ __('lang.rdy_applied_cdt') }}</td>
                                                    <td>
                                                        @if ($survey_result->meter == true)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_yes') }}</p>
                                                        @elseif ($survey_result->meter == false)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_no') }}</p>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.invade_cdt') }}</td>
                                                    <td>
                                                        @if ($survey_result->invade == true)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_yes') }}</p>
                                                        @elseif ($survey_result->invade == false)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_no') }}</p>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.loaded_cdt') }}</td>
                                                    <td>
                                                        @if ($survey_result->loaded == true)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_yes') }}</p>
                                                        @elseif ($survey_result->loaded == false)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_no') }}</p>
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
                                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
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
                                                    <td>{{ __('lang.remark') }}</td>
                                                    <td>
                                                        {{ $survey_result->remark ? $survey_result->remark : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('မြို့နယ်အဆင့် ') }}{{ __('lang.remark') }}</td>
                                                    <td>
                                                        {{ $survey_result->remark_tsp ? $survey_result->remark_tsp : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('ခရိုင်အဆင့် ') }}{{ __('lang.remark') }}</td>
                                                    <td>
                                                        {{ $survey_result->remark_dist ? $survey_result->remark_dist : '-' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ($install && $install->count() > 0)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#form_install" aria-expanded="true" aria-controls="collapseOne">{{ __('တပ်ဆင်ခြင်း') }}</a>
                                </h5>
                            </div>
                            <div id="form_install" class="card-body collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="row justify-content-center m-t-20">
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table no-border table-md-padding">
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->form_send_date ? mmNum(date('d-m-Y', strtotime($install->form_send_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('အကြောင်းအရာ')}}</td>
                                                   <td>{{$install->description}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('တောင်းသင့်ငွေ')}}</td>
                                                   <td>{{$install->cash_kyat}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('တွက်ချက်သူ')}}</td>
                                                   <td>{{$install->calculator}}</td>
                                               </tr>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->calcu_date ? mmNum(date('d-m-Y', strtotime($install->calcu_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('ငွေသွင်းရန်အကြောင်းကြားစာအမှတ်')}}</td>
                                                   <td>{{$install->payment_form_no}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->payment_form_date ? mmNum(date('d-m-Y', strtotime($install->payment_form_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('အာမခံစဘော်ငွေပြေစာအမှတ်')}}</td>
                                                   <td>{{$install->deposite_form_no}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->deposite_form_date ? mmNum(date('d-m-Y', strtotime($install->deposite_form_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('၎င်း')}}</td>
                                                   <td>{{$install->somewhat}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->somewhat_form_date ? mmNum(date('d-m-Y', strtotime($install->somewhat_form_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('ကြိုးသွယ်ခနှင့် ဆက်ခပြေစာအမှတ်')}}</td>
                                                   <td>{{$install->string_form_no}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->string_form_date ? mmNum(date('d-m-Y', strtotime($install->string_form_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('လျှပ်စစ်ဓါတ်ကြိုးတပ်ဆင်ခနှင့် ကြီးကြပ်ခပေးဆောင်သည့် နေ့စွဲ')}}</td>
                                                   <td>{{ $install->service_string_form_date ? mmNum(date('d-m-Y', strtotime($install->service_string_form_date))) : '-' }}</td>
                                               </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($meter_infos && $meter_infos->count() > 0)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#registered" aria-expanded="true" aria-controls="collapseOne">{{__('lang.registered_meter_info')}}</a>
                                </h5>
                            </div>
                            <div id="registered" class="card-body collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <table class="table no-border table-small-padding">
                                            <tbody>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.meter_no')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_no ? $meter_infos->meter_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.meter_seal_no')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_seal_no ? $meter_infos->meter_seal_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.meter_get_date')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_get_date ? mmNum(date('d-m-Y', strtotime($meter_infos->meter_get_date))) : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.who_made_meter')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->who_made_meter ? $meter_infos->who_made_meter : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.ampere')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->ampere ? $meter_infos->ampere : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.pay_date')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->pay_date ? mmNum(date('d-m-Y', strtotime($meter_infos->pay_date))) : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.mark_user_no')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->mark_user_no ? $meter_infos->mark_user_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.budget')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->budget ? $meter_infos->budget : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.move_date')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->move_date ? mmNum(date('d-m-Y', strtotime($meter_infos->move_date))) : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.move_budget')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->move_budget ? $meter_infos->move_budget : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.move_order')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->move_order ? $meter_infos->move_order : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.test_date')}}
                                                    </td>
                                                    <td>
                                                        {{ $meter_infos->test_date ? mmNum(date('d-m-Y', strtotime($meter_infos->test_date))) : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.test_no')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->test_no ? $meter_infos->test_no : '-'}}
                                                    </td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @elseif($data->apply_type == 3)
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->nrc_copy_front) }}" alt="{{ $file->nrc_copy_front }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.nrc_front') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->nrc_copy_back) }}" alt="{{ $file->nrc_copy_back }}" class="img-thumbnail" width="150" height="150">
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->form_10_front) }}" alt="{{ $file->form_10_front }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.form10_front') }}</p>
                                    </div>
                                    @if ($file->form_10_back)
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->form_10_back) }}" alt="{{ $file->form_10_back }}" class="img-thumbnail" width="150" height="150">
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->occupy_letter) }}" alt="{{ $file->occupy_letter }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.occupy_letter') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->no_invade_letter) }}" alt="{{ $file->no_invade_letter }}" class="img-thumbnail" width="150" height="150">
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
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
                                                        @if ($survey_result->living == null)
                                                            -
                                                        @elseif ($survey_result->living)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_yes') }}</p>
                                                        @elseif (!$survey_result->living)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_no') }}</p>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.residential') }} {{ __('lang.rdy_applied_cdt') }}</td>
                                                    <td>
                                                        @if ($survey_result->meter == true)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_yes') }}</p>
                                                        @elseif ($survey_result->meter == false)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_no') }}</p>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.invade_cdt') }}</td>
                                                    <td>
                                                        @if ($survey_result->invade == true)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_yes') }}</p>
                                                        @elseif ($survey_result->invade == false)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_no') }}</p>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.loaded_cdt') }}</td>
                                                    <td>
                                                        @if ($survey_result->loaded == true)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_yes') }}</p>
                                                        @elseif ($survey_result->loaded == false)
                                                            <p class="{{ lang() }}">{{ __('lang.radio_no') }}</p>
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
                                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
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
                        @if ($install && $install->count() > 0)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#form_install" aria-expanded="true" aria-controls="collapseOne">{{ __('တပ်ဆင်ခြင်း') }}</a>
                                </h5>
                            </div>
                            <div id="form_install" class="card-body collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="row justify-content-center m-t-20">
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table no-border table-md-padding">
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->form_send_date ? mmNum(date('d-m-Y', strtotime($install->form_send_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('အကြောင်းအရာ')}}</td>
                                                   <td>{{$install->description}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('တောင်းသင့်ငွေ')}}</td>
                                                   <td>{{$install->cash_kyat}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('တွက်ချက်သူ')}}</td>
                                                   <td>{{$install->calculator}}</td>
                                               </tr>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->calcu_date ? mmNum(date('d-m-Y', strtotime($install->calcu_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('ငွေသွင်းရန်အကြောင်းကြားစာအမှတ်')}}</td>
                                                   <td>{{$install->payment_form_no}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->payment_form_date ? mmNum(date('d-m-Y', strtotime($install->payment_form_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('အာမခံစဘော်ငွေပြေစာအမှတ်')}}</td>
                                                   <td>{{$install->deposite_form_no}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->deposite_form_date ? mmNum(date('d-m-Y', strtotime($install->deposite_form_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('၎င်း')}}</td>
                                                   <td>{{$install->somewhat}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->somewhat_form_date ? mmNum(date('d-m-Y', strtotime($install->somewhat_form_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('ကြိုးသွယ်ခနှင့် ဆက်ခပြေစာအမှတ်')}}</td>
                                                   <td>{{$install->string_form_no}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->string_form_date ? mmNum(date('d-m-Y', strtotime($install->string_form_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('လျှပ်စစ်ဓါတ်ကြိုးတပ်ဆင်ခနှင့် ကြီးကြပ်ခပေးဆောင်သည့် နေ့စွဲ')}}</td>
                                                   <td>{{ $install->service_string_form_date ? mmNum(date('d-m-Y', strtotime($install->service_string_form_date))) : '-' }}</td>
                                               </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($meter_infos && $meter_infos->count() > 0)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#registered" aria-expanded="true" aria-controls="collapseOne">{{__('lang.registered_meter_info')}}</a>
                                </h5>
                            </div>
                            <div id="registered" class="card-body collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <table class="table no-border table-small-padding">
                                            <tbody>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.meter_no')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_no ? $meter_infos->meter_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.meter_seal_no')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_seal_no ? $meter_infos->meter_seal_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.meter_get_date')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_get_date ? mmNum(date('d-m-Y', strtotime($meter_infos->meter_get_date))) : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.who_made_meter')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->who_made_meter ? $meter_infos->who_made_meter : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.ampere')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->ampere ? $meter_infos->ampere : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.pay_date')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->pay_date ? mmNum(date('d-m-Y', strtotime($meter_infos->pay_date))) : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.mark_user_no')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->mark_user_no ? $meter_infos->mark_user_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.budget')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->budget ? $meter_infos->budget : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.move_date')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->move_date ? mmNum(date('d-m-Y', strtotime($meter_infos->move_date))) : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.move_budget')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->move_budget ? $meter_infos->move_budget : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.move_order')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->move_order ? $meter_infos->move_order : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.test_date')}}
                                                    </td>
                                                    <td>
                                                        {{ $meter_infos->test_date ? mmNum(date('d-m-Y', strtotime($meter_infos->test_date))) : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.test_no')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->test_no ? $meter_infos->test_no : '-'}}
                                                    </td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @elseif($data->apply_type == 4)
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
                                                    <th>{{ checkMM() === 'mm' ? mmNum(number_format($fee_names_trf->name)) : number_format($fee_names_trf->name) }} {{ __('lang.kva') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $total = 0; @endphp
                                                @foreach ($tbl_col_name as $col_name)
                                                @if ($col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'composit_box' && $col_name != 'sub_type' && $col_name != 'incheck_fee')
                                                <tr>
                                                    <td>{{ __('lang.'.$col_name) }}</td>
                                                    <td class="text-center">{{ checkMM() === 'mm' ? mmNum(number_format($fee_names_trf->$col_name)) : number_format($fee_names_trf->$col_name) }}</td>
                                                    @php $total += $fee_names_trf->$col_name; @endphp

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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->nrc_copy_front) }}" alt="{{ $file->nrc_copy_front }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.nrc_front') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->nrc_copy_back) }}" alt="{{ $file->nrc_copy_back }}" class="img-thumbnail" width="150" height="150">
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->form_10_front) }}" alt="{{ $file->form_10_front }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.form10_front') }}</p>
                                    </div>
                                    @if ($file->form_10_back)
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->form_10_back) }}" alt="{{ $file->form_10_back }}" class="img-thumbnail" width="150" height="150">
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->occupy_letter) }}" alt="{{ $file->occupy_letter }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.occupy_letter') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->no_invade_letter) }}" alt="{{ $file->no_invade_letter }}" class="img-thumbnail" width="150" height="150">
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
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
                                    @if ($file->electric_power)
                                <div class="row text-center mt-2">
                                    @php
                                        $electricpower_foto = explode(',', $file->electric_power);
                                        $i = 1;
                                    @endphp
                                    @foreach ($electricpower_foto as $foto)
                                    <div class="col-md-6 text-center">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
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
                        @if ($survey_result_transfor && $survey_result_transfor->count() > 0)
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
                                                        <td>{{ who($survey_result_transfor->survey_engineer) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('lang.name') }}</td>
                                                        <td>{{ who($survey_result_transfor->survey_engineer) }}</td>
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
                                                            @if ($survey_result_transfor->pri_tsf_name)
                                                            {{ $survey_result_transfor->pri_tsf_type.' KV' }} {{ '/' }} {{ $survey_result_transfor->pri_main_ct_ratio.' KV' }} {{ $survey_result_transfor->pri_tsf_name }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $survey_result_transfor->ct_ratio.' KV CT Ratio' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->ct_ratio_amt)
                                                                {{ $survey_result_transfor->ct_ratio_amt }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $survey_result_transfor->pri_main_ct_ratio.' KV Main CT Ratio' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->pri_main_ct_ratio_amt)
                                                                {{ $survey_result_transfor->pri_main_ct_ratio_amt }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'ဓါတ်အားခွဲရုံ Capacity' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->pri_capacity)
                                                                {{ $survey_result_transfor->pri_capacity }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $survey_result_transfor->main_feeder_peak_load.' KV Main Feeder Peak Load' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->main_feeder_peak_load_amt)
                                                                {{ $survey_result_transfor->main_feeder_peak_load_amt }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $survey_result_transfor->pri_feeder_ct_ratio.' KV Feeder CT Ratio' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->pri_feeder_ct_ratio_amt)
                                                                {{ $survey_result_transfor->pri_feeder_ct_ratio_amt }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $survey_result_transfor->feeder_peak_load.' KV Feeder Peak Load' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->feeder_peak_load_amt)
                                                                {{ $survey_result_transfor->feeder_peak_load_amt }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                
                                                    <tr>
                                                        <th>{{ __('ဓါတ်အားပေးမည့် Secondary Source') }}</th>
                                                        <td>
                                                            @if ($survey_result_transfor->sec_tsf_name)
                                                            {{ $survey_result_transfor->sec_tsf_type.' KV' }} {{ '/ 11 KV' }} {{ $survey_result_transfor->sec_tsf_name }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $survey_result_transfor->sec_main_ct_ratio.' KV Main CT Ratio' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->sec_main_ct_ratio_amt)
                                                                {{ $survey_result_transfor->sec_main_ct_ratio_amt }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ '11 KV Main CT Ratio' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->sec_11_main_ct_ratio)
                                                                {{ $survey_result_transfor->sec_11_main_ct_ratio }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'ဓါတ်အားခွဲရုံ Capacity' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->sec_capacity)
                                                                {{ $survey_result_transfor->sec_capacity }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'Peak Load (Day)' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->sec_11_peak_load_day)
                                                                {{ $survey_result_transfor->sec_11_peak_load_day }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'Peak Load (Night)' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->sec_11_peak_load_night)
                                                                {{ $survey_result_transfor->sec_11_peak_load_night }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'Installed Capacity' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->sec_11_installed_capacity)
                                                                {{ $survey_result_transfor->sec_11_installed_capacity }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <th>{{ __('ဓါတ်အားရယူမည့် Feeder') }}</th>
                                                        <td>
                                                            @if ($survey_result_transfor->feeder_name)
                                                            {{ $survey_result_transfor->feeder_name }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'CT Ratio' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->feeder_ct_ratio)
                                                                {{ $survey_result_transfor->feeder_ct_ratio }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'Peak Load (Day)' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->feeder_peak_load_day)
                                                                {{ $survey_result_transfor->feeder_peak_load_day }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'Peak Load (Night)' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->feeder_peak_load_night)
                                                                {{ $survey_result_transfor->feeder_peak_load_night }}
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
                                                            @if ($survey_result_transfor->online_installed_capacity)
                                                            {{ $survey_result_transfor->online_installed_capacity }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'ဓါတ်အားလိုင်းအရှည် (ပေ/မိုင်) (စုစုပေါင်း)' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->total_line_length)
                                                                {{ $survey_result_transfor->total_line_length }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'ဓါတ်အားလိုင်းအရှည် (ပေ/မိုင်) (အဆိုပြုအထိ)' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->request_line_length)
                                                                {{ $survey_result_transfor->request_line_length }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'Conductor Type and Size' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->conductor)
                                                                {{ $survey_result_transfor->conductor }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'လိုင်းကြိုးလဲရန် လို/မလို' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->string_change == 'yes')
                                                                {{ 'လိုပါသည်' }}
                                                            @else
                                                                {{ 'မလိုပါ' }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'လိုင်းကြိုးအမျိုးအစားနှင့် အရှည်' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->string_change == 'yes')
                                                                {{ $survey_result_transfor->string_change_type_length }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                
                                                    <tr>
                                                        <td>{{ __('ဓါတ်အားခွဲရုံမှူး၏ ထောက်ခံချက်') }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->power_station_recomm)
                                                            <div class="col-md-3 text-center">
                                                                <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$survey_result_transfor->power_station_recomm) }}" alt="{{ $survey_result_transfor->power_station_recomm }}" class="img-thumbnail">
                                                            </div>
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('lang.one_line_diagram') }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->one_line_diagram)
                                                            <div class="col-md-3 text-center">
                                                                <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$survey_result_transfor->one_line_diagram) }}" alt="{{ $survey_result_transfor->one_line_diagram }}" class="img-thumbnail">
                                                            </div>
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('lang.location_map') }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->location_map)
                                                            <div class="col-md-3 text-center">
                                                                <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$survey_result_transfor->location_map) }}" alt="{{ $survey_result_transfor->location_map }}" class="img-thumbnail">
                                                            </div>
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('Google Map') }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->google_map)
                                                            <div class="col-md-3 text-center">
                                                                <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$survey_result_transfor->google_map) }}" alt="{{ $survey_result_transfor->google_map }}" class="img-thumbnail">
                                                            </div>
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('အသုံးပြုမည့် ဝန်အားစာရင်း') }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->comsumed_power_list)
                                                            <div class="col-md-3 text-center">
                                                                <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$survey_result_transfor->comsumed_power_list) }}" alt="{{ $survey_result_transfor->comsumed_power_list }}" class="img-thumbnail">
                                                            </div>
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ 'အင်ဂျင်နီယာမှတ်ချက်' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->survey_remark)
                                                                {{ $survey_result_transfor->survey_remark }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @if ($survey_result_transfor->tsp_remark)
                                                    <tr>
                                                        <td>{{ 'မြိုနယ်ရုံးမှတ်ချက်' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->tsp_remark)
                                                                {{ $survey_result_transfor->tsp_remark }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @if ($survey_result_transfor->dist_remark)
                                                    <tr>
                                                        <td>{{ 'ခရိုင်ရုံးမှတ်ချက်' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->dist_remark)
                                                                {{ $survey_result_transfor->dist_remark }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @if ($survey_result_transfor->capacitor_bank)
                                                    <tr>
                                                        <td>{{ 'Capacitor Bank လို/မလို' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->capacitor_bank == 'yes')
                                                                {{ 'လိုပါသည်' }}
                                                            @else
                                                                {{ 'မလိုပါ' }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @if ($survey_result_transfor->capacitor_bank == 'yes')
                                                    <tr>
                                                        <td>{{ 'Capacitor Bank အမျိုးအစား' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->capacitor_bank_amt)
                                                                {{ $survey_result_transfor->capacitor_bank_amt }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @if ($survey_result_transfor->div_state_remark)
                                                    <tr>
                                                        <td>{{ 'တိုင်းဒေသကြီး/ပြည်နယ်ရုံးမှတ်ချက်' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->div_state_remark)
                                                                {{ $survey_result_transfor->div_state_remark }}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @if ($survey_result_transfor->head_office_remark)
                                                    <tr>
                                                        <td>{{ 'ရုံးချုပ် မှတ်ချက်' }}</td>
                                                        <td>
                                                            @if ($survey_result_transfor->head_office_remark)
                                                                {{ $survey_result_transfor->head_office_remark }}
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
                        @endif
                        @if ($install && $install->count() > 0)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#form_install" aria-expanded="true" aria-controls="collapseOne">{{ __('တပ်ဆင်ခြင်း') }}</a>
                                </h5>
                            </div>
                            <div id="form_install" class="card-body collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="row justify-content-center m-t-20">
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table no-border table-md-padding">
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->form_send_date ? mmNum(date('d-m-Y', strtotime($install->form_send_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('အကြောင်းအရာ')}}</td>
                                                   <td>{{$install->description}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('တောင်းသင့်ငွေ')}}</td>
                                                   <td>{{$install->cash_kyat}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('တွက်ချက်သူ')}}</td>
                                                   <td>{{$install->calculator}}</td>
                                               </tr>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->calcu_date ? mmNum(date('d-m-Y', strtotime($install->calcu_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('ငွေသွင်းရန်အကြောင်းကြားစာအမှတ်')}}</td>
                                                   <td>{{$install->payment_form_no}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->payment_form_date ? mmNum(date('d-m-Y', strtotime($install->payment_form_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('အာမခံစဘော်ငွေပြေစာအမှတ်')}}</td>
                                                   <td>{{$install->deposite_form_no}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->deposite_form_date ? mmNum(date('d-m-Y', strtotime($install->deposite_form_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('၎င်း')}}</td>
                                                   <td>{{$install->somewhat}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->somewhat_form_date ? mmNum(date('d-m-Y', strtotime($install->somewhat_form_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('ကြိုးသွယ်ခနှင့် ဆက်ခပြေစာအမှတ်')}}</td>
                                                   <td>{{$install->string_form_no}}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('နေ့စွဲ')}}</td>
                                                   <td>{{ $install->string_form_date ? mmNum(date('d-m-Y', strtotime($install->string_form_date))) : '-' }}</td>
                                               </tr>
                                               <tr>
                                                   <td>{{__('လျှပ်စစ်ဓါတ်ကြိုးတပ်ဆင်ခနှင့် ကြီးကြပ်ခပေးဆောင်သည့် နေ့စွဲ')}}</td>
                                                   <td>{{ $install->service_string_form_date ? mmNum(date('d-m-Y', strtotime($install->service_string_form_date))) : '-' }}</td>
                                               </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ($ei_data && $ei_data->count() > 0)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#ei_chk" aria-expanded="true" aria-controls="collapseOne">{{ __('EI စစ်ဆေးချက်') }}</a>
                                </h5>
                            </div>
                            <div id="ei_chk" class="card-body collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <table class="table no-border table-small-padding">
                                            <tbody>
                                                <tr>
                                                    <td width="30%">
                                                        {{ __('မှတ်ချက်') }}
                                                    </td>
                                                    <td>
                                                        @if ($ei_data->ei_remark)
                                                        {{ $ei_data->ei_remark }}
                                                        @else
                                                        -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        {{ __('ပူးတွဲတင်ပြချက်များ') }}
                                                    </td>
                                                    <td>
                                                        @if ($ei_data->ei_files)
                                                        @php
                                                            $ei = explode(',', $ei_data->ei_files);
                                                            $i = 1;
                                                        @endphp
                                                        @foreach ($ei as $foto)
                                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
                                                        @php
                                                            $i++;
                                                        @endphp
                                                        @endforeach
                                                        @else
                                                        -
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($meter_infos && $meter_infos->count() > 0)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#registered" aria-expanded="true" aria-controls="collapseOne">{{__('lang.registered_meter_info')}}</a>
                                </h5>
                            </div>
                            <div id="registered" class="card-body collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <table class="table no-border table-small-padding">
                                            <tbody>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.meter_no')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_no ? $meter_infos->meter_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.meter_seal_no')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_seal_no ? $meter_infos->meter_seal_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.meter_get_date')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_get_date ? mmNum(date('d-m-Y', strtotime($meter_infos->meter_get_date))) : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.who_made_meter')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->who_made_meter ? $meter_infos->who_made_meter : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.ampere')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->ampere ? $meter_infos->ampere : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.pay_date')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->pay_date ? mmNum(date('d-m-Y', strtotime($meter_infos->pay_date))) : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.mark_user_no')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->mark_user_no ? $meter_infos->mark_user_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.budget')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->budget ? $meter_infos->budget : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.move_date')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->move_date ? mmNum(date('d-m-Y', strtotime($meter_infos->move_date))) : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.move_budget')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->move_budget ? $meter_infos->move_budget : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.move_order')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->move_order ? $meter_infos->move_order : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.test_date')}}
                                                    </td>
                                                    <td>
                                                        {{ $meter_infos->test_date ? mmNum(date('d-m-Y', strtotime($meter_infos->test_date))) : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{__('lang.test_no')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->test_no ? $meter_infos->test_no : '-'}}
                                                    </td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @elseif($data->apply_type == 5)
                    <div id="app_show" class="accordion" role="tablist" aria-multiselectable="true">
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#info" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.user_info') }}
                                    </a>
                                </h5>
                            </div>
                            <div id="info" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="card-body mm">
                                        <h5 class="text-center"><b>ကန်ထရိုက်တိုက် အိမ်သုံးမီတာ လျှောက်လွှာပုံစံ</b></h5>
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
                                            <h6>အကြောင်းအရာ။<span class="p-l-40">။</span> <b>ကန်ထရိုက်တိုက် အိမ်သုံးမီတာ တပ်ဆင်ခွင့်ပြုပါရန် လျှောက်ထားခြင်း။</b></h6>
                                        </div>
                                        <div class="p-t-10">
                                            <h6 class="l-h-35">
                                                <span class="p-l-40"></span><span class="p-l-40"></span>
                                                အထက်ပါကိစ္စနှင့်ပတ်သက်၍ {{ address_mm($data->id) }}တွင် <b>{{ 'ကန်ထရိုက်တိုက်' }}</b> အတွက် <b>{{ contrator_meter_count($data->id) }}</b> တပ်ဆင်သုံးစွဲခွင့်ပြုပါရန် လျှောက်ထားအပ်ပါသည်။
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
                                    <a data-toggle="collapse" data-parent="#app_show" href="#nrc" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.nrc') }}</a>
                                </h5>
                            </div>
                            <div id="nrc" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->nrc_copy_front) }}" alt="{{ $file->nrc_copy_front }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.nrc_front') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->nrc_copy_back) }}" alt="{{ $file->nrc_copy_back }}" class="img-thumbnail" width="150" height="150">
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->form_10_front) }}" alt="{{ $file->form_10_front }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.form10_front') }}</p>
                                    </div>
                                    @if ($file->form_10_back)
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->form_10_back) }}" alt="{{ $file->form_10_back }}" class="img-thumbnail" width="150" height="150">
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->occupy_letter) }}" alt="{{ $file->occupy_letter }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.occupy_letter') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->no_invade_letter) }}" alt="{{ $file->no_invade_letter }}" class="img-thumbnail" width="150" height="150">
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
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
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
                                    <a data-toggle="collapse" data-parent="#app_show" href="#permit_letter" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.permit') }}
                                    </a>
                                </h5>
                            </div>
                            <div id="permit_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->building_permit) }}" alt="{{ $file->building_permit }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.applied_permit_photo') }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#bcc_letter" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.bcc') }}
                                    </a>
                                </h5>
                            </div>
                            <div id="bcc_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->bcc) }}" alt="{{ $file->bcc }}" class="img-thumbnail" width="150" height="150">

                                        <p class="m-t-10 m-b-10">{{ __('lang.applied_bcc_photo') }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#dc_recomm_letter" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.dc_recomm') }}
                                    </a>
                                </h5>
                            </div>
                            <div id="dc_recomm_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->dc_recomm) }}" alt="{{ $file->dc_recomm }}" class="img-thumbnail" width="150" height="150">

                                        <p class="m-t-10 m-b-10">{{ __('lang.applied_dc_recomm_photo') }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#prev_bill_letter" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.prev_bill') }}
                                    </a>
                                </h5>
                            </div>
                            <div id="prev_bill_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$file->prev_bill) }}" alt="{{ $file->prev_bill }}" class="img-thumbnail" width="150" height="150">

                                        <p class="m-t-10 m-b-10">{{ __('lang.applied_bill_photo') }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
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
                    <div class="card mb-1">
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0">
                                <a data-toggle="collapse" data-parent="#app_show" href="#technical" aria-expanded="true" aria-controls="collapseOne">{{ __('
                                မြေပြင်စစ်ဆေးချက်များ') }}</a>
                            </h5>
                            @if (chk_userForm($data->id)['to_confirm_survey'])
                                @if (hasPermissionsAndGroupLvl(['residentialChkGrdDone-create'], admin()->group_lvl))
                                <div class="ml-auto">
                                    <a href="{{ route('contractorMeterGroundCheckList.edit', $data->id) }}" class="btn-edit text-danger ">{{ __('lang.edit') }}</a>
                                </div>
                                @endif
                            @endif
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
                                                    <td>{{ __('lang.tsf_transmit_distance') }} ({{ __('lang.feet') }})</td>
                                                    <td>
                                                        @if ($survey_result->tsf_transmit_distance_feet)
                                                            {{ checkMM() == 'mm' ? mmNum($survey_result->tsf_transmit_distance_feet) : $survey_result->tsf_transmit_distance_feet }} {{ __('lang.feet') }}
                                                        @else
                                                        -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.tsf_transmit_distance') }} ({{ __('lang.kv') }})</td>
                                                    <td>
                                                        @if ($survey_result->tsf_transmit_distance_kv)
                                                            {{ checkMM() == 'mm' ? mmNum($survey_result->tsf_transmit_distance_kv) : $survey_result->tsf_transmit_distance_kv }} {{ __('lang.kv') }}
                                                        @else
                                                        -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.exist_transformer') }}</td>
                                                    <td>
                                                        @if ($survey_result->exist_transformer)
                                                            {{ $survey_result->exist_transformer }}
                                                        @else
                                                        -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.loaded_cdt') }}</td>
                                                    <td>@if ($survey_result->loaded) {{ __('lang.radio_yes') }} @else {{ __('lang.radio_no') }} @endif</td>
                                                </tr>
                                                <tr>
                                                    <td>အင်ဂျင်နီယာ {{ __('lang.remark') }}</td>
                                                    <td>
                                                        @if ($survey_result->remark)
                                                            {{ $survey_result->remark }}
                                                        @else
                                                        -
                                                        @endif
                                                    </td>
                                                </tr>
                                                
                                                @if($survey_result->new_tsf_info_volt != '')
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
                                                                <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    </td>
                                                </tr>
                                                @if ($data->apply_sub_type == 1)
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
                                                                    <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @else
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
                                                @endif
                                                @endif

                                                @if($survey_result->bq_cost_dist)
                                                <tr>
                                                    <th colspan="2" class="text-center text-dark">
                                                        <h4>ခရိုင်အဆင့် စစ်ဆေးခြင်း</h4>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.bq_cost') }} ({{ __('lang.request') }})</td>
                                                    <td>
                                                        {{ checkMM() == 'mm' ? mmNum(number_format($survey_result->bq_cost_dist)) : number_format($survey_result->bq_cost_dist) }} {{ __('lang.kyat') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.bq_cost') }} ({{ __('lang.attach_files') }})</td>
                                                    <td>
                                                        @if ($survey_result->bq_cost_dist_files)
                                                            @php
                                                                $bq_cost_dist_foto = explode(',', $survey_result->bq_cost_dist_files);
                                                            @endphp
                                                            <div class="row">
                                                                @foreach ($bq_cost_dist_foto as $foto)
                                                                <div class="col-md-3 text-center">
                                                                    <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.remark') }}</td>
                                                    <td>{{ $survey_result->remark_dist }}</td>
                                                </tr>

                                                @endif

                                                @if($survey_result->bq_cost_div_state)
                                                <tr>
                                                    <th colspan="2" class="text-center text-dark">
                                                        <h4>တိုင်းအဆင့် စစ်ဆေးခြင်း</h4>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.bq_cost') }} ({{ __('lang.request') }})</td>
                                                    <td>
                                                        {{ checkMM() == 'mm' ? mmNum(number_format($survey_result->bq_cost_div_state)) : number_format($survey_result->bq_cost_div_state) }} {{ __('lang.kyat') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.bq_cost') }} ({{ __('lang.attach_files') }})</td>
                                                    <td>
                                                        @if ($survey_result->bq_cost_div_state_files)
                                                            @php
                                                                $bq_cost_dist_foto = explode(',', $survey_result->bq_cost_div_state_files);
                                                            @endphp
                                                            <div class="row">
                                                                @foreach ($bq_cost_dist_foto as $foto)
                                                                <div class="col-md-3 text-center">
                                                                    <img src="{{ asset('storage/app/public/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
                                                                </div>
                                                                @endforeach
                                                            </div>
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
                    @endif

                   
                    <div id="app_show" class="accordion m-t-30" role="tablist" aria-multiselectable="true">
                        @if($adminActionData->form_accept)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#appForm" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.accept_title') }}</a>
                                </h5>
                            </div>
                            <div id="appForm" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="card-body mm">
                                        <table class="table">
                                            <tr>
                                                <th width="50%">{{__('lang.form')}} {{__('lang.form_accepted_date')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{$formActionData->accepted_date}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.form')}} {{__('lang.form_accepted_name')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->form_accept)->name}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.phone')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->form_accept)->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.group')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{group(admin_info($adminActionData->form_accept)->group_lvl)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.township')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{township(admin_info($adminActionData->form_accept)->township)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.district')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{district(admin_info($adminActionData->form_accept)->district)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.div_state')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{div_state(admin_info($adminActionData->form_accept)->div_state)}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($data->apply_type == 4)
                        @if($adminActionData->survey_accept)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#residentSurvey" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.ground') }} {{ __('lang.to_survey') }}</a>
                                </h5>
                            </div>
                            <div id="residentSurvey" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="talbe-responsive p-20">
                                        <table class="table">
                                            <tr>
                                                <th width="50%">{{__('lang.ground')}} {{__('lang.survey_date')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{$formActionData->survey_accepted_date}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.residentSurvey')}} {{__('lang.director')}} </th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->survey_accept)->name}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.ground')}} {{__('lang.survey_name')}} </th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($transformerformSurveyData->survey_engineer)->name}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.phone')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($transformerformSurveyData->survey_engineer)->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.group')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{group(admin_info($transformerformSurveyData->survey_engineer)->group_lvl)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.township')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{township(admin_info($transformerformSurveyData->survey_engineer)->township)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.district')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{district(admin_info($transformerformSurveyData->survey_engineer)->district)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.div_state')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{div_state(admin_info($transformerformSurveyData->survey_engineer)->div_state)}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @else
                        @if($adminActionData->survey_accept)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#residentSurvey" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.ground') }} {{ __('lang.to_survey') }}</a>
                                </h5>
                            </div>
                            <div id="residentSurvey" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="talbe-responsive p-20">
                                        <table class="table">
                                            <tr>
                                                <th width="50%">{{__('lang.ground')}} {{__('lang.survey_date')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{$formActionData->survey_accepted_date}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.residentSurvey')}} {{__('lang.director')}} </th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->survey_accept)->name}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.ground')}} {{__('lang.survey_name')}} </th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($formSurveyData->survey_engineer)->name}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.phone')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($formSurveyData->survey_engineer)->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.group')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{group(admin_info($formSurveyData->survey_engineer)->group_lvl)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.township')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{township(admin_info($formSurveyData->survey_engineer)->township)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.district')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{district(admin_info($formSurveyData->survey_engineer)->district)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.div_state')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{div_state(admin_info($formSurveyData->survey_engineer)->div_state)}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endif

                        @if($adminActionData->survey_confirm)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#residentSurveyTown" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.residentSurveyDoneTsp') }} </a>
                                </h5>
                            </div>
                            <div id="residentSurveyTown" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="talbe-responsive p-20">
                                        <table class="table">
                                            <tr>
                                                <th width="50%">{{__('lang.survey_date')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{$formActionData->survey_confirmed_date}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.survey_name')}} </th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->survey_confirm)->name}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.phone')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->survey_confirm)->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.group')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{group(admin_info($adminActionData->survey_confirm)->group_lvl)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.township')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{township(admin_info($adminActionData->survey_confirm)->township)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.district')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{district(admin_info($adminActionData->survey_confirm)->district)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.div_state')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{div_state(admin_info($adminActionData->survey_confirm)->div_state)}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($adminActionData->survey_confirm_dist)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#residentSurveyDis" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.residentSurveyDoneDist') }} </a>
                                </h5>
                            </div>
                            <div id="residentSurveyDis" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="talbe-responsive p-20">
                                        <table class="table">
                                            <tr>
                                                <th width="50%">{{__('lang.survey_date')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{$formActionData->survey_confirmed_dist_date}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.survey_name')}} </th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->survey_confirm_dist)->name}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.phone')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->survey_confirm_dist)->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.group')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{group(admin_info($adminActionData->survey_confirm_dist)->group_lvl)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.township')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{township(admin_info($adminActionData->survey_confirm_dist)->township)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.district')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{district(admin_info($adminActionData->survey_confirm_dist)->district)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.div_state')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{div_state(admin_info($adminActionData->survey_confirm_dist)->div_state)}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($adminActionData->survey_confirm_div_state)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#residentSurveyDiv" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.residentSurveyDoneDivstate') }} </a>
                                </h5>
                            </div>
                            <div id="residentSurveyDiv" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="talbe-responsive p-20">
                                        <table class="table">
                                            <tr>
                                                <th width="50%">{{__('lang.survey_date')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{$formActionData->survey_confirmed_div_state_date}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.survey_name')}} </th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->survey_confirm_div_state)->name}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.phone')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->survey_confirm_div_state)->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.group')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{group(admin_info($adminActionData->survey_confirm_div_state)->group_lvl)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.township')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{township(admin_info($adminActionData->survey_confirm_div_state)->township)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.district')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{district(admin_info($adminActionData->survey_confirm_div_state)->district)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.div_state')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{div_state(admin_info($adminActionData->survey_confirm_div_state)->div_state)}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($adminActionData->announce)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#announce" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.announce') }}</a>
                                </h5>
                            </div>
                            <div id="announce" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="card-body mm">
                                        <table class="table">
                                            <tr>
                                                <th width="50%"> {{__('lang.announced_date')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{$formActionData->announced_date}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.announced_name')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->announce)->name}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.phone')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->announce)->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.group')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{group(admin_info($adminActionData->announce)->group_lvl)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.township')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{township(admin_info($adminActionData->announce)->township)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.district')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{district(admin_info($adminActionData->announce)->district)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.div_state')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{div_state(admin_info($adminActionData->announce)->div_state)}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($adminActionData->payment_accept)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#ConfrimPayment" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.confirm_payment') }}</a>
                                </h5>
                             
                            </div>
                            <div id="ConfrimPayment" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="card-body mm">
                                        <table class="table">
                                            <tr>
                                                <th width="50%"> {{__('lang.payment_accept_date')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{$formActionData->payment_accepted_date}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.payment_accept_name')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->payment_accept)->name}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.phone')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->payment_accept)->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.group')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{group(admin_info($adminActionData->payment_accept)->group_lvl)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.township')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{township(admin_info($adminActionData->payment_accept)->township)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.district')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{district(admin_info($adminActionData->payment_accept)->district)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.div_state')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{div_state(admin_info($adminActionData->payment_accept)->div_state)}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($adminActionData->install_accept)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#install" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.check_to_install') }}</a>
                                </h5>
                            </div>
                            <div id="install" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="card-body mm">
                                        <table class="table">
                                            <tr>
                                                <th width="50%"> {{__('lang.install_date')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{$formActionData->install_accepted_date}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.install_name')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->install_accept)->name}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.phone')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->install_accept)->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.group')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{group(admin_info($adminActionData->install_accept)->group_lvl)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.township')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{township(admin_info($adminActionData->install_accept)->township)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.district')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{district(admin_info($adminActionData->install_accept)->district)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.div_state')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{div_state(admin_info($adminActionData->install_accept)->div_state)}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($adminActionData->install_confirm)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#ei" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.to_ei_confirm_div_state') }}</a>
                                </h5>
                            </div>
                            <div id="ei" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="card-body mm">
                                        <table class="table">
                                            <tr>
                                                <th width="50%"> {{__('lang.survey_date')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{$formActionData->install_confirmed_date}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.survey_name')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->install_confirm)->name}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.phone')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->install_confirm)->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.group')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{group(admin_info($adminActionData->install_confirm)->group_lvl)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.township')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{township(admin_info($adminActionData->install_confirm)->township)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.district')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{district(admin_info($adminActionData->install_confirm)->district)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.div_state')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{div_state(admin_info($adminActionData->install_confirm)->div_state)}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($adminActionData->register_meter)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#reg_meter" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.to_register') }}</a>
                                </h5>
                            </div>
                            <div id="reg_meter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="card-body mm">
                                        <table class="table">
                                            <tr>
                                                <th width="50%"> {{__('lang.register_date')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{$formActionData->registered_meter_date}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.register_name')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->register_meter)->name}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.phone')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{admin_info($adminActionData->register_meter)->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.group')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{group(admin_info($adminActionData->register_meter)->group_lvl)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.township')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{township(admin_info($adminActionData->register_meter)->township)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.district')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{district(admin_info($adminActionData->register_meter)->district)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%">{{__('lang.div_state')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{div_state(admin_info($adminActionData->register_meter)->div_state)}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
