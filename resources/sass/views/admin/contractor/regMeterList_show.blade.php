@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('contractorMeterRegisterMeterList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body card-body-pb-div">

                @include('layouts.form-progressbar')

                <div class="container-fluid">
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
                                        <h5 class="text-center"><b>ကန်ထရိုက်တိုက် မီတာ လျှောက်လွှာပုံစံ</b></h5>
                                        <h6 class="text-right">အမှတ်စဥ် - <b>{{ $data->serial_code }}</b></h6>
                                        @if ($data->div_state_id == 2)
                                        <div class="p-t-10 p-b-10">
                                            <h6>သို့</h6>
                                            <h6 class="p-l-30 p-t-10">မြို့နယ်လျှပ်စစ်မန်နေဂျာ</h6>
                                            <h6 class="p-l-30 p-t-10">ရန်ကုန်လျှပ်စစ်ဓာတ်အားပေးရေးကော်ပိုရေးရှင်း</h6>
                                            <h6 class="p-l-30 p-t-10">{{ township_mm($data->township_id) }}</h6>
                                        </div>
                                        @elseif ($data->div_state_id == 3)
                                        <div class="p-t-10 p-b-10">
                                            <h6>သို့</h6>
                                            <h6 class="p-l-30 p-t-10">မြို့နယ်လျှပ်စစ်မန်နေဂျာ</h6>
                                            <h6 class="p-l-30 p-t-10">မန္တလေးလျှပ်စစ်ဓာတ်အားပေးရေးကော်ပိုရေးရှင်း</h6>
                                            <h6 class="p-l-30 p-t-10">{{ township_mm($data->township_id) }}</h6>
                                        </div>
                                        @else
                                        <div class="p-t-10 p-b-10">
                                            <h6>သို့</h6>
                                            <h6 class="p-l-30 p-t-10">မြို့နယ်လျှပ်စစ်မှူး/မြို့နယ်လျှပ်စစ်အင်ဂျင်နီယာ</h6>
                                            <h6 class="p-l-30 p-t-10">လျှပ်စစ်ဓာတ်အားဖြန့်ဖြူးရေးလုပ်ငန်း</h6>
                                            <h6 class="p-l-30 p-t-10">{{ township_mm($data->township_id) }}</h6>
                                        </div>
                                        @endif
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
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->nrc_copy_front) }}" alt="{{ $file->nrc_copy_front }}" class="img-thumbnail imgViewer" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.nrc_front') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->nrc_copy_back) }}" alt="{{ $file->nrc_copy_back }}" class="img-thumbnail imgViewer" width="150" height="150">
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
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->form_10_front) }}" alt="{{ $file->form_10_front }}" class="img-thumbnail imgViewer" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.form10_front') }}</p>
                                    </div>
                                    @if ($file->form_10_back)
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->form_10_back) }}" alt="{{ $file->form_10_back }}" class="img-thumbnail imgViewer" width="150" height="150">
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
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->occupy_letter) }}" alt="{{ $file->occupy_letter }}" class="img-thumbnail imgViewer" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.occupy_letter') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->no_invade_letter) }}" alt="{{ $file->no_invade_letter }}" class="img-thumbnail imgViewer" width="150" height="150">
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
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
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
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->building_permit) }}" alt="{{ $file->building_permit }}" class="img-thumbnail imgViewer" width="150" height="150">
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
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->bcc) }}" alt="{{ $file->bcc }}" class="img-thumbnail imgViewer" width="150" height="150">

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
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->dc_recomm) }}" alt="{{ $file->dc_recomm }}" class="img-thumbnail imgViewer" width="150" height="150">

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
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->prev_bill) }}" alt="{{ $file->prev_bill }}" class="img-thumbnail imgViewer" width="150" height="150">

                                        <p class="m-t-10 m-b-10">{{ __('lang.applied_bill_photo') }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
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
                                                    <td>{{ who($survey_result->survey_engineer)->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('lang.name') }}</td>
                                                    <td>{{ who($survey_result->survey_engineer)->name }}</td>
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
                                                @if ($survey_result->remark_tsp)
                                                <tr>
                                                    <td>{{ __('မြို့နယ်အဆင့် ') }}{{ __('lang.remark') }}</td>
                                                    <td>
                                                        {{ $survey_result->remark_tsp }}
                                                    </td>
                                                </tr>
                                                @endif
                                                @if ($survey_result->tsp_recomm)
                                                <?php 
                                                    $foto = $survey_result->tsp_recomm;
                                                    $filename = asset('storage/user_attachments/'.$data->id.'/'.$foto);
                                                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                                    ;
                                                ?>
                                                <tr>
                                                    <td>{{ __('မြို့နယ်အဆင့် ထောက်ခံချက်') }}</td>
                                                    <td>
                                                        @if($ext != 'pdf')
                                                        <div class="col-md-3 text-center">
                                                            <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                                        </div>
                                                        @else
                                                            <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" target="_blank" class="pdf-block">{{ $foto }}</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endif
                                                @if ($survey_result->remark_dist)
                                                <tr>
                                                    <td>{{ __('ခရိုင်အဆင့် ') }}{{ __('lang.remark') }}</td>
                                                    <td>
                                                        {{ $survey_result->remark_dist }}
                                                    </td>
                                                </tr>
                                                @endif
                                                @if ($survey_result->dist_recomm)
                                                <?php 
                                                    $foto = $survey_result->dist_recomm;
                                                    $filename = asset('storage/user_attachments/'.$data->id.'/'.$foto);
                                                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                                    ;
                                                ?>
                                                <tr>
                                                    <td>{{ __('ခရိုင်အဆင့် ထောက်ခံချက်') }}</td>
                                                    <td>
                                                        @if($ext != 'pdf')
                                                        <div class="col-md-3 text-center">
                                                            <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                                        </div>
                                                        @else
                                                            <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" target="_blank" class="pdf-block">{{ $foto }}</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endif
                                                @if ($survey_result->div_state_recomm)
                                                <tr>
                                                    <td>{{ __('ရုံးချုပ်အဆင့် ') }}{{ __('lang.remark') }}</td>
                                                    <td>
                                                        {{ $survey_result->div_state_recomm }}
                                                    </td>
                                                </tr>
                                                @endif
                                                
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
                                                            <?php 
                                                                $filename = asset('storage/user_attachments/'.$data->id.'/'.$foto);
                                                                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                                            ;
                                                            ?>
                                                            @if($ext != 'pdf')
                                                            <div class="col-md-3 text-center">
                                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer">
                                                            </div>
                                                            @else
                                                            <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" target="_blank" class="pdf-block">{{ $foto }}</a>
                                                            @endif
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
                                                                <?php 
                                                                    $filename = asset('storage/user_attachments/'.$data->id.'/'.$foto);
                                                                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                                                ;
                                                                ?>
                                                                @if($ext != 'pdf')
                                                                <div class="col-md-3 text-center">
                                                                    <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer">
                                                                </div>
                                                                @else
                                                                <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" target="_blank" class="pdf-block">{{ $foto }}</a>
                                                                @endif
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
                                                                <?php 
                                                                    $filename = asset('storage/user_attachments/'.$data->id.'/'.$foto);
                                                                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                                                ;
                                                                ?>
                                                                @if($ext != 'pdf')
                                                                <div class="col-md-3 text-center">
                                                                    <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer">
                                                                </div>
                                                                @else
                                                                <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" target="_blank" class="pdf-block">{{ $foto }}</a>
                                                                @endif
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
                                                                <?php 
                                                                    $filename = asset('storage/user_attachments/'.$data->id.'/'.$foto);
                                                                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                                                ;
                                                                ?>
                                                                @if($ext != 'pdf')
                                                                <div class="col-md-3 text-center">
                                                                    <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer">
                                                                </div>
                                                                @else
                                                                <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" target="_blank" class="pdf-block">{{ $foto }}</a>
                                                                @endif
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
                    @if (chk_userForm($data->id)['to_register'])
                        @if (hasPermissions(['contractorRegisteredMeter-create']))
                    <div class="card mb-1">
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('မီတာမှတ်ပုံတင်ရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                            {!! Form::open(['route' => 'contractorMeterRegisterMeterList.store']) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <div class="container-fluid">
                                <div class="row form-group mb-1">
                                    <label for="serial" class="control-label l-h-35 text-md-right text-primary col-md-4"><strong>အခန်း({{ checkMM() == 'mm' ? mmNum($c_form->room_count) : $c_form->room_count }})ခန်းအတွက် မီတာအမှတ်များ ဖြည့်သွင်းရန် -</strong></label>
                                </div>

                                @for ($n = 1; $n <= $c_form->room_count; $n++)
                                    <div class="row form-group mb-20 justify-content-center">
                                        <div class="col-2">
                                            <label class="control-label text-info">အခန်းအမှတ် <span class="text-danger f-s-15">&#10039;</span></label> 
                                            {!! Form::text('room_no[]', null, ['class' => 'form-control inner-form','required']) !!}
                                        </div>
                                        <div class="col-2">
                                            <label class="control-label text-info">မီတာအမှတ် <span class="text-danger f-s-15">&#10039;</span></label>
                                            {!! Form::text('meter_no[]', null, ['class' => 'form-control inner-form','required']) !!}
                                        </div>
                                        <div class="col-2">
                                            <label class="control-label text-info">မီတာစီးအမှတ် <span class="text-danger f-s-15">&#10039;</span></label>
                                            {!! Form::text('meter_seal_no[]', null, ['class' => 'form-control inner-form','required']) !!}
                                        </div>
                                        <div class="col-2">
                                            <label class="control-label text-info">မီတာလုပ်သူ <span class="text-danger f-s-15">&#10039;</span></label>
                                            {!! Form::text('who_made_meter[]', null, ['class' => 'form-control inner-form','required']) !!}
                                        </div>
                                        <div class="col-2">
                                            <label class="control-label text-info">အမ်ပီယာ</label>
                                            {!! Form::text('ampere[]', null, ['class' => 'form-control inner-form']) !!}
                                        </div>
                                    </div>
                                @endfor

                                @for ($nn = 1; $nn <= $c_form->water_meter; $nn++)
                                    <div class="row form-group mb-20 justify-content-center">
                                        <div class="col-3">
                                            <label class="control-label text-md-right text-info">ရေစက်မီတာအမှတ်</label>
                                            {!! Form::text('water_meter_no[]', null, ['class' => 'form-control inner-form']) !!}
                                        </div>
                                        <div class="col-3">
                                            <label class="control-label text-md-right text-info">မီတာစီးအမှတ်</label>
                                            {!! Form::text('water_meter_seal_no[]', null, ['class' => 'form-control inner-form']) !!}
                                        </div>
                                        <div class="col-3">
                                            <label class="control-label text-info">မီတာလုပ်သူ</label>
                                            {!! Form::text('water_who_made_meter[]', null, ['class' => 'form-control inner-form']) !!}
                                        </div>
                                        <div class="col-3">
                                            <label class="control-label text-info">အမ်ပီယာ</label>
                                            {!! Form::text('water_ampere[]', null, ['class' => 'form-control inner-form']) !!}
                                        </div>
                                    </div>
                                @endfor

                                @for ($nnn = 1; $nnn <= $c_form->elevator_meter; $nnn++)
                                    <div class="row form-group mb-20 justify-content-center">
                                        <div class="col-3">
                                            <label class="control-label text-md-right text-info">ပါဝါမီတာအမှတ်</label>
                                            {!! Form::text('elevator_meter_no[]', null, ['class' => 'form-control inner-form']) !!}
                                        </div>
                                        <div class="col-3">
                                            <label class="control-label text-md-right text-info">မီတာစီးအမှတ်</label>
                                            {!! Form::text('elevator_meter_seal_no[]', null, ['class' => 'form-control inner-form']) !!}
                                        </div>
                                        <div class="col-3">
                                            <label class="control-label text-info">မီတာလုပ်သူ</label>
                                            {!! Form::text('elevator_who_made_meter[]', null, ['class' => 'form-control inner-form']) !!}
                                        </div>
                                        <div class="col-3">
                                            <label class="control-label text-info">အမ်ပီယာ</label>
                                            {!! Form::text('elevator_ampere[]', null, ['class' => 'form-control inner-form']) !!}
                                        </div>
                                    </div>
                                @endfor
                                <br/>

                                <div class="row form-group mb-1">
                                    <label for="meter_get_date" class="control-label l-h-35 text-md-right col-md-3">ဌာနချုပ်မှရသောနေ့</label>
                                    <div class="col-md-7">
                                        {!! Form::text('meter_get_date', null, ['id' => 'meter_get_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="pay_date" class="control-label l-h-35 text-md-right col-md-3">ထုတ်ပေးသောနေ့</label>
                                    <div class="col-md-7">
                                        {!! Form::text('pay_date', null, ['id' => 'pay_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="mark_user_no" class="control-label l-h-35 text-md-right col-md-3">အမှတ်အသားနှင့် သုံးစွဲသူအမှတ်</label>
                                    <div class="col-md-7">
                                        {!! Form::text('mark_user_no', null, ['id' => 'mark_user_no', 'class' => 'form-control inner-form']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="budget" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.budget') }}</label>
                                    <div class="col-md-7">
                                        {!! Form::text('budget', null, ['id' => 'budget', 'class' => 'form-control inner-form']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="move_date" class="control-label l-h-35 text-md-right col-md-3">ရွှေ့ပြောင်းရက်စွဲ</label>
                                    <div class="col-md-7">
                                        {!! Form::text('move_date', null, ['id' => 'move_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="move_budget" class="control-label l-h-35 text-md-right col-md-3">ရွှေ့ပြောင်းဘတ်ဂျက်</label>
                                    <div class="col-md-7">
                                        {!! Form::text('move_budget', null, ['id' => 'move_budget', 'class' => 'form-control inner-form']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="move_order" class="control-label l-h-35 text-md-right col-md-3">ရွှေ့ပြောင်းခြင်းရာအမိန့်</label>
                                    <div class="col-md-7">
                                        {!! Form::text('move_order', null, ['id' => 'move_order', 'class' => 'form-control inner-form']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="test_date" class="control-label l-h-35 text-md-right col-md-3">စမ်းသပ်သောနေ့</label>
                                    <div class="col-md-7">
                                        {!! Form::text('test_date', null, ['id' => 'test_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="test_no" class="control-label l-h-35 text-md-right col-md-3">စမ်းသပ်ချက်မှတ်တမ်းအမှတ်</label>
                                    <div class="col-md-7">
                                        {!! Form::text('test_no', null, ['id' => 'test_no', 'class' => 'form-control inner-form']) !!}
                                    </div>
                                </div>
                                <div class="row form-group mb-1">
                                    <label for="remark" class="control-label l-h-35 text-md-right col-md-3">မှတ်ချက်</label>
                                    <div class="col-md-7">
                                        {!! Form::text('remark', null, ['id' => 'remark', 'class' => 'form-control inner-form']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-5">
                                <input type="submit" name="form66_submit" value="{{ __('lang.submit') }}" class="btn btn-rounded btn-info">
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
