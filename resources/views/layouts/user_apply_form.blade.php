@if ($data->apply_type == 1) {{-- residential meter --}}
    {{--  user profile  --}}
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
    {{--  meter type  --}}
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

                                @if($data->apply_division != 3 && ($item->slug == 'type_one' || $item->slug == 'type_two' || $item->slug == 'type_three'))
                                    <th>{{ __('lang.'.$item->slug.'_org') }}</th>
                                @else
                                    <th>{{ __('lang.'.$item->slug) }}</th>
                                @endif
                                
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach ($tbl_col_name as $col_name)
                            @if ($col_name != 'building_fee' && $col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'composit_box' && $col_name != 'sub_type')
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
    {{--  nrc  --}}
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
    {{--  form 10  --}}
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
                    @php
                        $fotos = explode(',', $file->form_10_front);
                        $i = 1;
                    @endphp
                    @foreach ($fotos as $foto)
                        <div class="col-md-6 text-center">
                            <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                            <p class="m-t-10 m-b-10">{{ __('lang.form10_front') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                        </div>
                    @php
                        $i++;
                    @endphp
                    @endforeach
                </div>
                @if ($file->form_10_back)
                <div class="col-md-6">
                    @php
                        $fotos = explode(',', $file->form_10_back);
                        $i = 1;
                    @endphp
                    @foreach ($fotos as $foto)
                        <div class="col-md-6 text-center">
                            <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                            <p class="m-t-10 m-b-10">{{ __('lang.form10_back') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                        </div>
                    @php
                        $i++;
                    @endphp
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    {{--  recommanded letter  --}}
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
    {{--  ownership  --}}
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

    {{-- if yangon --}}
    @if($data->apply_division == 1)
        {{--  farmland  --}}
        <div class="card mb-1">
            <div class="card-header d-flex" role="tab" id="headingOne">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-parent="#app_show" href="#farmland" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.farmland_permit') }}</a>
                </h5>
            </div>
            <div id="farmland" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                @foreach ($files as $file)
                @if($file->farmland != '')
                    <div class="row text-center mt-2">
                        @php
                            $farmlands = explode(',', $file->farmland);
                            $i = 1;
                        @endphp
                        @foreach ($farmlands as $foto)
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                <p class="m-t-10 m-b-10">{{ __('lang.farmland_permit') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                            </div>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </div>
                @else
                    <h4 class="mt-5 mb-5 text-center text-danger">ဓါတ်ပုံတင်ထားခြင်း မရှိပါ</h4>
                @endif
                @endforeach
            </div>
        </div>
        {{--  building_photo  --}}
        <div class="card mb-1">
            <div class="card-header d-flex" role="tab" id="headingOne">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-parent="#app_show" href="#building" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.building_photo') }}</a>
                </h5>
            </div>
            <div id="building" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                @foreach ($files as $file)
                @if($file->building != '')
                    <div class="row text-center mt-2">
                        @php
                            $buildings = explode(',', $file->building);
                            $i = 1;
                        @endphp
                        @foreach ($buildings as $foto)
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                <p class="m-t-10 m-b-10">{{ __('lang.building_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                            </div>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </div>
                @else
                    <h4 class="mt-5 mb-5 text-center text-danger">ဓါတ်ပုံတင်ထားခြင်း မရှိပါ</h4>
                @endif
                @endforeach
            </div>
        </div>
        {{--  power list  --}}
        <div class="card mb-1">
            <div class="card-header d-flex" role="tab" id="headingOne">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-parent="#app_show" href="#electric_power" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.applied_electricpower_photo') }} </a>
                </h5>
            </div>
            <div id="electric_power" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                @foreach ($files as $file)
                @if($file->electric_power != '')
                    <div class="row text-center mt-2">
                        @php
                            $fotos = explode(',', $file->electric_power);
                            $i = 1;
                        @endphp
                        @foreach ($fotos as $foto)
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                <p class="m-t-10 m-b-10">{{ __('lang.applied_electricpower_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                            </div>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </div>
                @else
                    <h4 class="mt-5 mb-5 text-center text-danger">ဓါတ်ပုံတင်ထားခြင်း မရှိပါ</h4>
                @endif
                @endforeach
            </div>
        </div>
    @endif


    {{--  neighbour metered bill  --}}
    <!--@if ($data->apply_division == 2)-->
    <!--<div class="card mb-1">-->
    <!--    <div class="card-header d-flex" role="tab" id="headingOne">-->
    <!--        <h5 class="mb-0">-->
    <!--            <a data-toggle="collapse" data-parent="#app_show" href="#neighbour_bill" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.neighbour_bill') }}</a>-->
    <!--        </h5>-->
    <!--    </div>-->
    <!--    <div id="neighbour_bill" class="collapse" role="tabpanel" aria-labelledby="headingOne">-->
    <!--        @foreach ($files as $file)-->
    <!--        <div class="row text-center mt-2">-->
    <!--            <div class="col-md-6 text-center">-->
    <!--                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->prev_bill) }}" alt="{{ $file->prev_bill }}" class="img-thumbnail imgViewer" width="150" height="150">-->
    <!--                <p class="m-t-10 m-b-10">{{ __('lang.neighbour_bill') }}</p>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--        @endforeach-->
    <!--    </div>-->
    <!--</div>-->
    <!--@endif-->
    {{-- error --}}
    @if (isset($error) && $error->count() > 0)
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
    {{-- pending --}}
    @if (isset($pending) && $pending->count() > 0)
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
    {{-- survey results --}}
    @if (isset($survey_result) && $survey_result->count() > 0)
    <div class="card mb-1">
        <div class="card-header d-flex" role="tab" id="headingOne">
            <h5 class="mb-0">
                <a data-toggle="collapse" data-parent="#app_show" href="#technical" aria-expanded="true" aria-controls="collapseOne">{{ __('မြေပြင်စစ်ဆေးချက်') }}</a>
            </h5>
        @if (chk_userForm($data->id)['to_confirm_survey'])
            @if (hasPermissions(['residentialChkGrdTownship-edit']))
            <div class="ml-auto">
                <a href="{{ route('residentialMeterGroundCheckDoneListEdit.edit', $data->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
            </div>
            @endif
        @endif
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
                                <td>{{ __('lang.volt') }}</td>
                                <td>
                                    @if ($survey_result->volt)
                                    {{ checkMM() == 'mm' ? mmNum($survey_result->volt).' ဗို့' : $survey_result->volt.' Volts' }}
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('lang.kilowatt') }}</td>
                                <td>
                                    @if ($survey_result->kilowatt)
                                    {{ checkMM() == 'mm' ? mmNum($survey_result->kilowatt).' ကီလိုဝပ်' : $survey_result->kilowatt.' KiloWatts' }}
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('lang.survey_distance') }}</td>
                                <td>
                                    @if ($survey_result->distance)
                                    {{ checkMM() == 'mm' ? mmNum($survey_result->distance).' ပေ' : $survey_result->distance.' ft' }}
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
                                        <p>{{ __('lang.radio_yes') }}</p>
                                    @elseif (!$survey_result->living)
                                        <p>{{ __('lang.radio_no') }}</p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('lang.residential') }} {{ __('lang.rdy_applied_cdt') }}</td>
                                <td>
                                    @if ($survey_result->meter == true)
                                        <p>{{ __('lang.radio_yes') }}</p>
                                    @elseif ($survey_result->meter == false)
                                        <p>{{ __('lang.radio_no') }}</p>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('lang.invade_cdt') }}</td>
                                <td>
                                    @if ($survey_result->invade == true)
                                        <p>{{ __('lang.radio_yes') }}</p>
                                    @elseif ($survey_result->invade == false)
                                        <p>{{ __('lang.radio_no') }}</p>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('lang.loaded_cdt') }}</td>
                                <td>
                                    @if ($survey_result->transmit == true)
                                        <p>{{ __('lang.radio_yes') }}</p>
                                    @elseif ($survey_result->transmit == false)
                                        <p>{{ __('lang.radio_no') }}</p>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('lang.applied_electricpower') }} ({{ __('lang.kilowatt') }})</td>
                                <td>
                                    @if ($survey_result->comsumed_power_amt)
                                    {{ checkMM() == 'mm' ? mmNum($survey_result->comsumed_power_amt).' ကီလိုဝပ်' : $survey_result->comsumed_power_amt.' KiloWatts' }}
                                    @endif
                                </td>
                            </tr>

                            {{-- ခွင့်ပြုပေးမည့် ဝန်အားစာရင်း 540--}}
                            <tr>
                                <td>{{ __('lang.applied_load_list') }} </td>
                                <td>
                                    @foreach ($files as $file)
                                        @if($file->electric_power != '')
                                            <div class="row text-center mt-2">
                                                @php
                                                    $fotos = explode(',', $file->electric_power);
                                                    $i = 1;
                                                @endphp
                                                @foreach ($fotos as $foto)
                                                    <div class="col-md-3 text-center">
                                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                                    </div>
                                                @php
                                                    $i++;
                                                @endphp
                                                @endforeach
                                            </div>
                                        @else
                                           -
                                        @endif
                                    @endforeach
                                </td>
                            </tr>

                            {{-- ခွင့်ပြုပေးမည့် ဝန်အားစာရင်း --}}
                            <tr>
                                <td>{{ __('lang.allowed_load_list') }} </td>
                                <td>
                                    @if ($survey_result->comsumed_power_file)
                                    <?php 
                                        $foto = $survey_result->comsumed_power_file;
                                        $filename = asset('storage/user_attachments/'.$data->id.'/'.$foto);
                                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                        ;
                                    ?>
                                    @if($ext != 'pdf')
                                    <div class="col-md-3 text-center">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                    </div>
                                    @else
                                        <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" target="_blank" class="pdf-block">{{ $foto }}</a>
                                    @endif
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>

                            @if($survey_result->r_building_files != "")
                            <tr>
                                <td>{{ __('အဆောက်အဦ ဓါတ်ပုံ') }}</td>
                                <td>
                                    @if ($survey_result->r_building_files)
                                    <div class="row">
                                        @php
                                            $r_building_files = explode(',', $survey_result->r_building_files);
                                            $i = 1;
                                        @endphp
                                        @foreach ($r_building_files as $foto)
                                        <?php 
                                            $filename = asset('storage/user_attachments/'.$data->id.'/'.$foto);
                                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                            ;
                                        ?>
                                        @if($ext != 'pdf')
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                            </div>
                                        @else
                                            <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" target="_blank" class="pdf-block">{{ $foto }}</a>
                                        @endif
                                        @php
                                            $i++;
                                        @endphp
                                        @endforeach
                                    </div>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @if ($data->apply_division == 2)
                            <tr>
                                <td>{{ __('တပ်ဆင်လိုသည့် မီတာအမျိုးအစား') }}</td>
                                <td>
                                    {{ $survey_result->origin_p_meter ? r_meter($survey_result->origin_p_meter) : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('တပ်ဆင်ခွင့်ပြုသည့် မီတာအမျိုးအစား') }}</td>
                                <td>
                                    {{ $survey_result->allow_p_meter ? r_meter($survey_result->allow_p_meter) : '-' }}
                                </td>
                            </tr>
                            @endif
                            {{-- // ဓါတ်အားလိုင်းပြမြေပုံ / location map in show form  --}}
                            <tr>
                                <td>{{ __('lang.location_map_2') }}</td>
                                <td>
                                    @if ($survey_result->location_map)
                                        <?php 
                                        $filename = asset('storage/user_attachments/'.$data->id.'/'.$survey_result->location_map);
                                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                        ;
                                        ?>
                                        @if($ext != 'pdf')
                                        <div class="col-md-3 text-center">
                                            <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->location_map) }}" alt="{{ $survey_result->location_map }}" class="img-thumbnail imgViewer">
                                        </div>
                                        @else
                                        <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->location_map) }}" target="_blank">{{ $survey_result->location_map }}</a>
                                        @endif
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('lang.power_tranformer') }}</td>
                                <td>
                                    {{ $survey_result->power_tranformer ? $survey_result->power_tranformer : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('lang.kva') }}</td>
                                <td>
                                    {{ $survey_result->kva ? $survey_result->kva : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('lang.the_load') }}</td>
                                <td>
                                    {{ $survey_result->the_load ? $survey_result->the_load : '-' }}
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
                            @if($survey_result->tsp_recomm)
                            <?php 
                                $filename = asset('storage/user_attachments/'.$data->id.'/'.$survey_result->tsp_recomm);
                                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                ;
                            ?>
                            <tr>
                                <td>{{ __('မြို့နယ်ရုံး ထောက်ခံချက်') }}</td>
                                <td>
                                    @if($ext != 'pdf')
                                    <div class="col-md-3 text-center">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->tsp_recomm) }}" alt="{{ $survey_result->tsp_recomm }}" class="img-thumbnail imgViewer" width="150" height="150">
                                    </div>
                                    @else
                                        <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->tsp_recomm) }}" target="_blank" class="pdf-block">{{ $survey_result->tsp_recomm }}</a>
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
    @endif
    {{-- installed --}}
    @if (isset($install) && $install->count() > 0)
    <div class="card mb-1">
        <div class="card-header d-flex" role="tab" id="headingOne">
            <h5 class="mb-0">
                <a data-toggle="collapse" data-parent="#app_show" href="#form_install" aria-expanded="true" aria-controls="collapseOne">{{ __('တပ်ဆင်ခြင်း') }}</a>
            </h5>
        </div>
        <div id="form_install" class="card-body collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="row justify-content-center m-t-20">
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table no-border table-md-padding">
                        <tr>
                            <td width="30%">{{__('တပ်ဆင်ပြီးသည့် နေ့စွဲ')}}</td>
                            <td>{{ mmMonth(date('m', strtotime($install_date))).' '.mmNum(date('d', strtotime($install_date))).', '.mmNum(date('Y', strtotime($install_date))) }}</td>
                        </tr>
                        {{-- <tr>
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
                        </tr> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@elseif ($data->apply_type == 2) {{-- residential power meter --}}
    <!--@if (chk_userForm($data->id)['to_confirm_dist'])-->
    <!--<div class="card mb-1">-->
    <!--        <div class="card-header d-flex" role="tab" id="headingOne">-->
    <!--            <h5 class="mb-0">-->
    <!--                <a data-toggle="collapse" data-parent="#app_show" href="#heading_letter" aria-expanded="true" aria-controls="collapseOne">{{ __('မြို့နယ်ရုံးမှ ခရိုင်ရုံးသို့ လျှောက်လွှာတင်ပြခြင်း') }}</a>-->
    <!--            </h5>-->
    <!--        </div>-->
    <!--        <div id="heading_letter" class="collapse show" role="tabpanel" aria-labelledby="headingOne">-->
    <!--            <div class="container">-->
    <!--                <div class="card-body mm">-->
    <!--                    @if ($data->div_state_id == 2)-->
    <!--                    <div class="p-t-10 p-b-10">-->
    <!--                        <h6>သို့</h6>-->
    <!--                        <h6 class="p-l-30 p-t-10">မြို့နယ်လျှပ်စစ်မန်နေဂျာ</h6>-->
    <!--                        <h6 class="p-l-30 p-t-10">ရန်ကုန်လျှပ်စစ်ဓာတ်အားပေးရေးကော်ပိုရေးရှင်း</h6>-->
    <!--                        <h6 class="p-l-30 p-t-10">{{ township_mm($data->township_id) }}</h6>-->
    <!--                    </div>-->
    <!--                    @elseif ($data->div_state_id == 3)-->
    <!--                    <div class="p-t-10 p-b-10">-->
    <!--                        <h6>သို့</h6>-->
    <!--                        <h6 class="p-l-30 p-t-10">မြို့နယ်လျှပ်စစ်မန်နေဂျာ</h6>-->
    <!--                        <h6 class="p-l-30 p-t-10">မန္တလေးလျှပ်စစ်ဓာတ်အားပေးရေးကော်ပိုရေးရှင်း</h6>-->
    <!--                        <h6 class="p-l-30 p-t-10">{{ township_mm($data->township_id) }}</h6>-->
    <!--                    </div>-->
    <!--                    @else-->
    <!--                    <div class="p-t-10 p-b-10">-->
    <!--                        <h6>သို့</h6>-->
    <!--                        <h6 class="p-l-30 p-t-10">မြို့နယ်လျှပ်စစ်မှူး/မြို့နယ်လျှပ်စစ်အင်ဂျင်နီယာ</h6>-->
    <!--                        <h6 class="p-l-30 p-t-10">လျှပ်စစ်ဓာတ်အားဖြန့်ဖြူးရေးလုပ်ငန်း</h6>-->
    <!--                        <h6 class="p-l-30 p-t-10">{{ township_mm($data->township_id) }}</h6>-->
    <!--                    </div>-->
    <!--                    @endif-->
    <!--                    <div class="text-right p-t-10">-->
    <!--                        <h6>ရက်စွဲ။<span class="p-l-20">။</span> {{ mmNum(date('d-m-Y', strtotime($data->date))) }}</h6>-->
    <!--                    </div>-->
    <!--                    <div class="p-t-10">-->
    <!--                        <h6>အကြောင်းအရာ။<span class="p-l-40">။</span> <b>အိမ်သုံးပါ၀ါမီတာ တပ်ဆင်ခွင့်ပြုပါရန် လျှောက်ထားခြင်း။</b></h6>-->
    <!--                    </div>-->
    <!--                    <div class="p-t-10">-->
    <!--                        <p class="l-h-35">-->
    <!--                            ၁။<span class="p-l-30"></span><span class="p-l-30"></span>-->
    <!--                            {{ address_mm($data->id) }}ရှိ {{ $data->fullname }}({{ $data->nrc }})၏ နေအိမ်တွင် 'အလင်းရောင်'သုံးစွဲရန် ၃သွင်၊ ၄ကြိုး {{ power_meter_type($data->id) }} ပါဝါမီတာ(၁)လုံး တပ်ဆင်သုံးစွဲခွင့်ပြုပါရန် လျှောက်ထားလာပါသည်။-->
    <!--                        </p>-->
    <!--                        <p class="l-h-35">-->
    <!--                            ၂။<span class="p-l-30"></span><span class="p-l-30"></span>-->
    <!--                            အဆိုပါ {{ address_mm($data->id) }}ရှိ {{ $data->fullname }}({{ $data->nrc }})၏ နေအိမ်တွင် 'အလင်းရောင်သုံး' ဓာတ်အားရရှိရေးအတွက် {{ $survey_result->t_info }}မှ ဓာတ်အားပေးရမည် ဖြစ်ပါသည်။ ၎င်း၏ လက်ရှိ (၄၀၀)ဗို့ ဓာတ်အားလိုင်းမှာ {{ $survey_result->cable_size_type }}ဖြင့် တည်ဆောက်ထား၍ နေအိမ်အဆောက်အအုံနှင့် (၄၀၀)ဗို့ဓာတ်အားလိုင်းမှာ ({{ mmNum($survey_result->distance) }})ပေခန့် ကွာဝေးပါသည်။-->
    <!--                        </p>-->
    <!--                        <p class="l-h-35">-->
    <!--                            ၃။<span class="p-l-30"></span><span class="p-l-30"></span>-->
    <!--                            သို့ဖြစ်ပါ၍ {{ address_mm($data->id) }}ရှိ {{ $data->fullname }}({{ $data->nrc }})၏ နေအိမ်တွင် 'အလင်းရောင်သုံး' သုံးစွဲရန်အတွက် ၃သွင်၊ ၄ကြိုး {{ power_meter_type($data->id) }} ပါဝါမီတာ လျှောက်ထားခြင်းအား လိုအပ်သလို ဆောင်ရွက်နိုင်ပါရန် စိစစ်တင်ပြအပ်ပါသည်။-->
    <!--                        </p>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--@endif-->
    {{--  user profile  --}}
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
    {{--  meter type  --}}
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
                            @if ($col_name != 'building_fee' && $col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && ($data->apply_division == 1 || $col_name != 'service_fee') && $col_name != 'incheck_fee' && $col_name != 'sub_type')
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
    {{--  nrc  --}}
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
    {{--  form 10  --}}
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
    {{--  recommanded letter  --}}
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
    {{--  ownership  --}}
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
    {{-- if yangon --}}
    @if($data->apply_division == 1)
        {{--  power list  --}}
        <div class="card mb-1">
            <div class="card-header d-flex" role="tab" id="headingOne">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-parent="#app_show" href="#electric_power" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.applied_electricpower_photo') }}</a>
                </h5>
            </div>
            <div id="electric_power" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                @foreach ($files as $file)
                @if($file->electric_power != '')
                    <div class="row text-center mt-2">
                        @php
                            $fotos = explode(',', $file->electric_power);
                            $i = 1;
                        @endphp
                        @foreach ($fotos as $foto)
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                <p class="m-t-10 m-b-10">{{ __('lang.applied_electricpower_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                            </div>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </div>
                @else
                    <h4 class="mt-5 mb-5 text-center text-danger">ဓါတ်ပုံတင်ထားခြင်း မရှိပါ</h4>
                @endif
                @endforeach
            </div>
        </div>
        {{--  prev bill  --}}
        <div class="card mb-1">
            <div class="card-header d-flex" role="tab" id="headingOne">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-parent="#app_show" href="#prev_bill" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.prev_bill2') }}</a>
                </h5>
            </div>
            <div id="prev_bill" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                @foreach ($files as $file)
                @if($file->prev_bill != '')
                    <div class="row text-center mt-2">
                        @php
                            $fotos = explode(',', $file->prev_bill);
                            $i = 1;
                        @endphp
                        @foreach ($fotos as $foto)
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                <p class="m-t-10 m-b-10">{{ __('lang.prev_bill2') }}</p>
                            </div>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </div>
                @else
                    <h4 class="mt-5 mb-5 text-center text-danger">ဓါတ်ပုံတင်ထားခြင်း မရှိပါ</h4>
                @endif
                @endforeach
            </div>
        </div>
        {{--  farmland  --}}
        <div class="card mb-1">
            <div class="card-header d-flex" role="tab" id="headingOne">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-parent="#app_show" href="#farmland" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.farmland_permit') }}</a>
                </h5>
            </div>
            <div id="farmland" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                @foreach ($files as $file)
                @if($file->farmland != '')
                    <div class="row text-center mt-2">
                        @php
                            $farmlands = explode(',', $file->farmland);
                            $i = 1;
                        @endphp
                        @foreach ($farmlands as $foto)
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                <p class="m-t-10 m-b-10">{{ __('lang.farmland_permit') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                            </div>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </div>
                @else
                    <h4 class="mt-5 mb-5 text-center text-danger">ဓါတ်ပုံတင်ထားခြင်း မရှိပါ</h4>
                @endif
                @endforeach
            </div>
        </div>
        {{--  building_photo  --}}
        <div class="card mb-1">
            <div class="card-header d-flex" role="tab" id="headingOne">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-parent="#app_show" href="#building" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.building_photo') }}</a>
                </h5>
            </div>
            <div id="building" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                @foreach ($files as $file)
                @if($file->building != '')
                    <div class="row text-center mt-2">
                        @php
                            $buildings = explode(',', $file->building);
                            $i = 1;
                        @endphp
                        @foreach ($buildings as $foto)
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                <p class="m-t-10 m-b-10">{{ __('lang.building_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                            </div>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </div>
                @else
                    <h4 class="mt-5 mb-5 text-center text-danger">ဓါတ်ပုံတင်ထားခြင်း မရှိပါ</h4>
                @endif
                @endforeach
            </div>
        </div>
    @endif
    @if (isset($error) && $error->count() > 0)
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
    @if (isset($pending) && $pending->count() > 0)
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
    @if (isset($survey_result) && $survey_result->count() > 0)
    <div class="card mb-1">
        <div class="card-header d-flex" role="tab" id="headingOne">
            <h5 class="mb-0">
                <a data-toggle="collapse" data-parent="#app_show" href="#technical" aria-expanded="true" aria-controls="collapseOne">{{ __('မြေပြင်စစ်ဆေးချက်') }}</a>
            </h5>
            @if (chk_userForm($data->id)['to_confirm_survey'])
                @if (hasPermissions(['residentialPowerTownshipChkGrd-edit']))
                <div class="ml-auto">
                    <a href="{{ route('residentialPowerMeterGroundCheckDoneList.edit', $data->id) }}" class="btn-edit text-danger ">{{ __('lang.edit') }}</a>
                </div>
                @endif
            @endif
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
                                    {{ $survey_result->t_info }}
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
                                <td>{{ __('လက်ရှိ ဓာတ်အားခွဲရုံ၊ ဓာတ်အားပေးစက်ရုံ အခြေအနေ') }}</td>
                                <td>
                                    <table class="text-center">
                                        <tbody>
                                            <tr>
                                                <td style="border: 1px solid black; vertical-align: middle;" rowspan="2">တိုင်းတာသည့်နေ့</td>
                                                <td style="border: 1px solid black; vertical-align: middle;" rowspan="2">တိုင်းတာသည့်အချိန်</td>
                                                <td style="border: 1px solid black; vertical-align: middle;" rowspan="2">ဗို့</td>
                                                <td style="border: 1px solid black;" colspan="4">ဝန်အား(Amper)</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;">R</td>
                                                <td style="border: 1px solid black;">Y</td>
                                                <td style="border: 1px solid black;">B</td>
                                                <td style="border: 1px solid black;">N</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;">
                                                    @if ($survey_result->curr_transmitter_date)
                                                    {{ checkMM() == 'mm' ? mmMonth(date('m', strtotime($survey_result->curr_transmitter_date))).' '.mmNum(date('d', strtotime($survey_result->curr_transmitter_date))).', '.mmNum(date('Y', strtotime($survey_result->curr_transmitter_date))) : date('M d, Y', strtotime($survey_result->curr_transmitter_date)) }}
                                                    @else
                                                    -
                                                    @endif
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    @if ($survey_result->curr_transmitter_date)
                                                    {{ checkMM() == 'mm' ? mmNum(date('H:i', strtotime($survey_result->curr_transmitter_date))) : date('H:i', strtotime($survey_result->curr_transmitter_date)) }}
                                                    @else
                                                    -
                                                    @endif
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    @if ($survey_result->curr_transmitter_volt)
                                                    {{ checkMM() ? mmNum($survey_result->curr_transmitter_volt) : $survey_result->curr_transmitter_volt }}
                                                    @endif
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    @if ($survey_result->amper_r)
                                                    {{ checkMM() ? mmNum($survey_result->amper_r) : $survey_result->amper_r }}
                                                    @endif
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    @if ($survey_result->amper_y)
                                                    {{ checkMM() ? mmNum($survey_result->amper_y) : $survey_result->amper_y }}
                                                    @endif
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    @if ($survey_result->amper_b)
                                                    {{ checkMM() ? mmNum($survey_result->amper_b) : $survey_result->amper_b }}
                                                    @endif
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    @if ($survey_result->amper_n)
                                                    {{ checkMM() ? mmNum($survey_result->amper_n) : $survey_result->amper_n }}
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('ဓာတ်အားလိုင်း တိုးချဲ့ရန် လို/မလို') }}</td>
                                <td>
                                    @if ($survey_result->cable_extend == true)
                                        <p>{{ __('လိုပါသည်') }}</p>
                                    @elseif ($survey_result->cable_extend == false)
                                        <p>{{ __('မလိုပါ') }}</p>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('လက်ရှိလျှပ်တာပြောင်းသည် ယခင်က ချို့ယွင်းခဲ့ဖူးခြင်း ရှိ/မရှိ') }}</td>
                                <td>
                                    @if ($survey_result->transmitter_error == true)
                                        <p>{{ __('lang.radio_yes') }}</p>
                                    @elseif ($survey_result->transmitter_error == false)
                                        <p>{{ __('lang.radio_no') }}</p>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('လျှပ်တာပြောင်းမှ ဓာတ်အားသုံးစွဲမည့်နေရာသို့ ဆွဲထားသော လိုင်းကြိုး၊ ကြေးကြိုးအရွယ်အစားနှင့် အရေအတွက်') }}</td>
                                <td>
                                    @if ($survey_result->cable_size_type)
                                    {{ $survey_result->cable_size_type }}
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('နောက်ဆုံး(၆)လအတွင်း စစ်ဆေးရရှိခဲ့သော လျှပ်တာပြောင်း အင်စူလေးရှင်းအခြေအနေနှင့် စစ်ဆေးသောနေ့') }}</td>
                                <td>
                                    @if ($survey_result->insulation_date)
                                    {{ checkMM() == 'mm' ? mmMonth(date('m', strtotime($survey_result->insulation_date))).' '.mmNum(date('d', strtotime($survey_result->insulation_date))).', '.mmNum(date('Y', strtotime($survey_result->insulation_date))) : date('M d, Y', strtotime($survey_result->insulation_date)) }}
                                    <br>
                                    <table class="text-center">
                                        <tbody>
                                            <tr>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;" colspan="4">Continuity</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;" colspan="12">Insulation</td>
                                            </tr>
                                            <tr>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;"></td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">R-Y</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">Y-B</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">B-R</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;"></td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">R-E</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">Y-E</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">B-E</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">N-E</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">R-Y</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">H-T-E</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">H-T-L-T</td>
                                            </tr>
                                            <tr>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">H-T</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->chtry }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->chtyb }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->chtbr }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">H-T</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->ihtre }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->ihtye }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->ihtbe }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->ihtne }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->ihtry }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->ihthte }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->ihthtlt }}</td>
                                            </tr>
                                            <tr>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">L-T</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->cltry }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->cltyb }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->cltbr }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">L-T</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->iltre }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->iltye }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->iltbe }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->iltne }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->iltry }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->ilthte }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->ilthtlt }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                                        <p>{{ __('lang.radio_yes') }}</p>
                                    @elseif (!$survey_result->living)
                                        <p>{{ __('lang.radio_no') }}</p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('lang.residential') }} {{ __('lang.rdy_applied_cdt') }}</td>
                                <td>
                                    @if ($survey_result->meter == true)
                                        <p>{{ __('lang.radio_yes') }}</p>
                                    @elseif ($survey_result->meter == false)
                                        <p>{{ __('lang.radio_no') }}</p>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('lang.invade_cdt') }}</td>
                                <td>
                                    @if ($survey_result->invade == true)
                                        <p>{{ __('lang.radio_yes') }}</p>
                                    @elseif ($survey_result->invade == false)
                                        <p>{{ __('lang.radio_no') }}</p>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('lang.loaded_cdt') }}</td>
                                <td>
                                    @if ($survey_result->transmit == true)
                                        <p>{{ __('lang.radio_yes') }}</p>
                                    @elseif ($survey_result->transmit == false)
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

                            {{-- လျှောက်ထားသည့် ဝန်အားစာရင်း --}}
                            <tr>
                                <td>{{ __('lang.applied_load_list') }}</td>
                                <td>
                                    @foreach ($files as $file)
                                        @if($file->electric_power != '')
                                            <div class="row text-center mt-2">
                                                @php
                                                    $fotos = explode(',', $file->electric_power);
                                                    $i = 1;
                                                @endphp
                                                @foreach ($fotos as $foto)
                                                    <div class="col-md-3 text-center">
                                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                                    </div>
                                                @php
                                                    $i++;
                                                @endphp
                                                @endforeach
                                            </div>
                                        @else
                                            -
                                        @endif
                                    @endforeach
                                </td>
                            </tr>

                            {{-- ခွင့်ပြုပေးမည့် ဝန်အားစာရင်း --}}
                            <tr>
                                <td>{{ __('lang.allowed_load_list') }}</td>
                                <td>
                                    @if ($survey_result->r_power_files)
                                    <div class="row">
                                        @php
                                            $r_power_files = explode(',', $survey_result->r_power_files);
                                            $i = 1;
                                        @endphp
                                        @foreach ($r_power_files as $foto)
                                        <?php 
                                            $filename = asset('storage/user_attachments/'.$data->id.'/'.$foto);
                                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                            ;
                                        ?>
                                        @if($ext != 'pdf')
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                            </div>
                                        @else
                                            <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" target="_blank" class="pdf-block">{{ $foto }}</a>
                                        @endif
                                        @php
                                            $i++;
                                        @endphp
                                        @endforeach
                                    </div>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            
                            @if($survey_result->r_building_files != "")
                            <tr>
                                <td>{{ __('အဆောက်အဦ ဓါတ်ပုံ') }}</td>
                                <td>
                                    @if ($survey_result->r_building_files)
                                    <div class="row">
                                        @php
                                            $r_building_files = explode(',', $survey_result->r_building_files);
                                            $i = 1;
                                        @endphp
                                        @foreach ($r_building_files as $foto)
                                        <?php 
                                            $filename = asset('storage/user_attachments/'.$data->id.'/'.$foto);
                                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                            ;
                                        ?>
                                        @if($ext != 'pdf')
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                            </div>
                                        @else
                                            <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" target="_blank" class="pdf-block">{{ $foto }}</a>
                                        @endif
                                        @php
                                            $i++;
                                        @endphp
                                        @endforeach
                                    </div>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td>{{ __('lang.location_map_2') }}</td>
                                <td>
                                    @if ($survey_result->location_map)
                                        <?php 
                                        $filename = asset('storage/user_attachments/'.$data->id.'/'.$survey_result->location_map);
                                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                        ;
                                        ?>
                                        @if($ext != 'pdf')
                                        <div class="col-md-3 text-center">
                                            <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->location_map) }}" alt="{{ $survey_result->location_map }}" class="img-thumbnail imgViewer">
                                        </div>
                                        @else
                                        <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->location_map) }}" target="_blank">{{ $survey_result->location_map }}</a>
                                        @endif
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>

                            {{-- ဓာတ်အားပေးမည့် ထရန်စဖော်မာအမည် --}}
                            <tr>
                                <td>{{ __('lang.power_tranformer') }}</td>
                                <td>
                                    {{ $survey_result->power_tranformer ? $survey_result->power_tranformer : '-' }}
                                </td>
                            </tr>

                            {{-- ၄၀၀ဗို့ ဓာတ်အားလိုင်းပြမြေပုံ --}}
                            <tr>
                                <td>{{ __('lang.line_map_400') }}</td>
                                <td>
                                    @if ($survey_result->line_map_400)
                                        <?php 
                                        $filename = asset('storage/user_attachments/'.$data->id.'/'.$survey_result->line_map_400);
                                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                        ;
                                        ?>
                                        @if($ext != 'pdf')
                                        <div class="col-md-3 text-center">
                                            <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->line_map_400) }}" alt="{{ $survey_result->line_map_400 }}" class="img-thumbnail imgViewer">
                                        </div>
                                        @else
                                        <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->line_map_400) }}" target="_blank">{{ $survey_result->line_map_400 }}</a>
                                        @endif
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td>{{ __('တပ်ဆင်ခွင့်ပြုသည့် မီတာအမျိုးအစား') }}</td>
                                <td>
                                    {{ checkMM() == 'mm' ? mmNum(p_meter($survey_result->allow_p_meter)).' ကီလိုဝပ်' : p_meter($survey_result->allow_p_meter).' KW' }}
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('lang.remark') }}</td>
                                <td>
                                    {{ $survey_result->remark ? $survey_result->remark : '-' }}
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if (isset($install) && $install->count() > 0)
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
                                <td width="30%">{{__('တပ်ဆင်ပြီးသည့် နေ့စွဲ')}}</td>
                                <td>{{ mmMonth(date('m', strtotime($install_date))).' '.mmNum(date('d', strtotime($install_date))).', '.mmNum(date('Y', strtotime($install_date))) }}</td>
                            </tr>
                            {{-- <tr>
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
                            </tr> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- install residential power meter --}}
    @if (isset($ei_data) && $ei_data->count() > 0)
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
                                    <div class="row">
                                        @foreach ($ei as $foto)
                                            @if ($foto)
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
                                            @else
                                            -
                                            @endif
                                        @php
                                            $i++;
                                        @endphp
                                        @endforeach
                                    </div>
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

@elseif ($data->apply_type == 3) {{-- commercial power meter --}}
    <!--@if (chk_userForm($data->id)['to_confirm_dist'])-->
    <!--<div class="card mb-1">-->
    <!--        <div class="card-header d-flex" role="tab" id="headingOne">-->
    <!--            <h5 class="mb-0">-->
    <!--                <a data-toggle="collapse" data-parent="#app_show" href="#heading_letter" aria-expanded="true" aria-controls="collapseOne">{{ __('မြို့နယ်ရုံးမှ ခရိုင်ရုံးသို့ လျှောက်လွှာတင်ပြခြင်း') }}</a>-->
    <!--            </h5>-->
    <!--        </div>-->
    <!--        <div id="heading_letter" class="collapse show" role="tabpanel" aria-labelledby="headingOne">-->
    <!--            <div class="container">-->
    <!--                <div class="card-body mm">-->
    <!--                    @if ($data->div_state_id == 2)-->
    <!--                    <div class="p-t-10 p-b-10">-->
    <!--                        <h6>သို့</h6>-->
    <!--                        <h6 class="p-l-30 p-t-10">မြို့နယ်လျှပ်စစ်မန်နေဂျာ</h6>-->
    <!--                        <h6 class="p-l-30 p-t-10">ရန်ကုန်လျှပ်စစ်ဓာတ်အားပေးရေးကော်ပိုရေးရှင်း</h6>-->
    <!--                        <h6 class="p-l-30 p-t-10">{{ township_mm($data->township_id) }}</h6>-->
    <!--                    </div>-->
    <!--                    @elseif ($data->div_state_id == 3)-->
    <!--                    <div class="p-t-10 p-b-10">-->
    <!--                        <h6>သို့</h6>-->
    <!--                        <h6 class="p-l-30 p-t-10">မြို့နယ်လျှပ်စစ်မန်နေဂျာ</h6>-->
    <!--                        <h6 class="p-l-30 p-t-10">မန္တလေးလျှပ်စစ်ဓာတ်အားပေးရေးကော်ပိုရေးရှင်း</h6>-->
    <!--                        <h6 class="p-l-30 p-t-10">{{ township_mm($data->township_id) }}</h6>-->
    <!--                    </div>-->
    <!--                    @else-->
    <!--                    <div class="p-t-10 p-b-10">-->
    <!--                        <h6>သို့</h6>-->
    <!--                        <h6 class="p-l-30 p-t-10">မြို့နယ်လျှပ်စစ်မှူး/မြို့နယ်လျှပ်စစ်အင်ဂျင်နီယာ</h6>-->
    <!--                        <h6 class="p-l-30 p-t-10">လျှပ်စစ်ဓာတ်အားဖြန့်ဖြူးရေးလုပ်ငန်း</h6>-->
    <!--                        <h6 class="p-l-30 p-t-10">{{ township_mm($data->township_id) }}</h6>-->
    <!--                    </div>-->
    <!--                    @endif-->
    <!--                    <div class="text-right p-t-10">-->
    <!--                        <h6>ရက်စွဲ။<span class="p-l-20">။</span> {{ mmNum(date('d-m-Y', strtotime($data->date))) }}</h6>-->
    <!--                    </div>-->
    <!--                    <div class="p-t-10">-->
    <!--                        <h6>အကြောင်းအရာ။<span class="p-l-40">။</span> <b>အိမ်သုံးပါ၀ါမီတာ တပ်ဆင်ခွင့်ပြုပါရန် လျှောက်ထားခြင်း။</b></h6>-->
    <!--                    </div>-->
    <!--                    <div class="p-t-10">-->
    <!--                        <p class="l-h-35">-->
    <!--                            ၁။<span class="p-l-30"></span><span class="p-l-30"></span>-->
    <!--                            {{ address_mm($data->id) }}ရှိ {{ $data->fullname }}({{ $data->nrc }})၏ နေအိမ်တွင် 'အလင်းရောင်'သုံးစွဲရန် ၃သွင်၊ ၄ကြိုး {{ power_meter_type($data->id) }} ပါဝါမီတာ(၁)လုံး တပ်ဆင်သုံးစွဲခွင့်ပြုပါရန် လျှောက်ထားလာပါသည်။-->
    <!--                        </p>-->
    <!--                        <p class="l-h-35">-->
    <!--                            ၂။<span class="p-l-30"></span><span class="p-l-30"></span>-->
    <!--                            အဆိုပါ {{ address_mm($data->id) }}ရှိ {{ $data->fullname }}({{ $data->nrc }})၏ နေအိမ်တွင် 'အလင်းရောင်သုံး' ဓာတ်အားရရှိရေးအတွက် {{ $survey_result->t_info }}မှ ဓာတ်အားပေးရမည် ဖြစ်ပါသည်။ ၎င်း၏ လက်ရှိ (၄၀၀)ဗို့ ဓာတ်အားလိုင်းမှာ {{ $survey_result->cable_size_type }}ဖြင့် တည်ဆောက်ထား၍ နေအိမ်အဆောက်အအုံနှင့် (၄၀၀)ဗို့ဓာတ်အားလိုင်းမှာ ({{ mmNum($survey_result->distance) }})ပေခန့် ကွာဝေးပါသည်။-->
    <!--                        </p>-->
    <!--                        <p class="l-h-35">-->
    <!--                            ၃။<span class="p-l-30"></span><span class="p-l-30"></span>-->
    <!--                            သို့ဖြစ်ပါ၍ {{ address_mm($data->id) }}ရှိ {{ $data->fullname }}({{ $data->nrc }})၏ နေအိမ်တွင် 'အလင်းရောင်သုံး' သုံးစွဲရန်အတွက် ၃သွင်၊ ၄ကြိုး {{ power_meter_type($data->id) }} ပါဝါမီတာ လျှောက်ထားခြင်းအား လိုအပ်သလို ဆောင်ရွက်နိုင်ပါရန် စိစစ်တင်ပြအပ်ပါသည်။-->
    <!--                        </p>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--@endif-->
    {{--  user profile  --}}
    <div class="card mb-1">
        <div class="card-header d-flex" role="tab" id="headingOne">
            <h5 class="mb-0">
                <a data-toggle="collapse" data-parent="#app_show" href="#info" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.user_info') }}</a>
            </h5>
        </div>
        <div id="info" class="collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="container">
                <div class="card-body mm">
                    <h5 class="text-center"><b>စက်မှုသုံးပါဝါမီတာ</b></h5>
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
                        <h6>အကြောင်းအရာ။<span class="p-l-40">။</span> <b>စက်မှုသုံးပါဝါမီတာ တပ်ဆင်ခွင့်ပြုပါရန် လျှောက်ထားခြင်း။</b></h6>
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
    {{--  meter type  --}}
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
                            @if ($col_name != 'building_fee' && $col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'service_fee' && $col_name != 'incheck_fee' && $col_name != 'sub_type')
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
    {{--  nrc  --}}
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
    {{--  form 10  --}}
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
    {{--  recommanded letter  --}}
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
    {{--  ownership  --}}
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
    {{-- commercial license  --}}
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
                    <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
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

    {{-- if yangon --}}
    @if($data->apply_division == 1)
        {{--  power list  --}}
        <div class="card mb-1">
            <div class="card-header d-flex" role="tab" id="headingOne">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-parent="#app_show" href="#electric_power" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.applied_electricpower_photo') }}</a>
                </h5>
            </div>
            <div id="electric_power" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                @foreach ($files as $file)
                @if($file->electric_power != '')
                    <div class="row text-center mt-2">
                        @php
                            $fotos = explode(',', $file->electric_power);
                            $i = 1;
                        @endphp
                        @foreach ($fotos as $foto)
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                <p class="m-t-10 m-b-10">{{ __('lang.applied_electricpower_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                            </div>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </div>
                @else
                    <h4 class="mt-5 mb-5 text-center text-danger">ဓါတ်ပုံတင်ထားခြင်း မရှိပါ</h4>
                @endif
                @endforeach
            </div>
        </div>
        {{--  prev bill  --}}
        <div class="card mb-1">
            <div class="card-header d-flex" role="tab" id="headingOne">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-parent="#app_show" href="#prev_bill" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.prev_bill2') }}</a>
                </h5>
            </div>
            <div id="prev_bill" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                @foreach ($files as $file)
                @if($file->prev_bill != '')
                    <div class="row text-center mt-2">
                        @php
                            $fotos = explode(',', $file->prev_bill);
                            $i = 1;
                        @endphp
                        @foreach ($fotos as $foto)
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                <p class="m-t-10 m-b-10">{{ __('lang.prev_bill2') }}</p>
                            </div>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </div>
                @else
                    <h4 class="mt-5 mb-5 text-center text-danger">ဓါတ်ပုံတင်ထားခြင်း မရှိပါ</h4>
                @endif
                @endforeach
            </div>
        </div>
        {{--  farmland  --}}
        <div class="card mb-1">
            <div class="card-header d-flex" role="tab" id="headingOne">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-parent="#app_show" href="#farmland" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.farmland_permit') }}</a>
                </h5>
            </div>
            <div id="farmland" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                @foreach ($files as $file)
                @if($file->farmland != '')
                    <div class="row text-center mt-2">
                        @php
                            $farmlands = explode(',', $file->farmland);
                            $i = 1;
                        @endphp
                        @foreach ($farmlands as $foto)
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                <p class="m-t-10 m-b-10">{{ __('lang.farmland_permit') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                            </div>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </div>
                @else
                    <h4 class="mt-5 mb-5 text-center text-danger">ဓါတ်ပုံတင်ထားခြင်း မရှိပါ</h4>
                @endif
                @endforeach
            </div>
        </div>
        {{--  building_photo  --}}
        <div class="card mb-1">
            <div class="card-header d-flex" role="tab" id="headingOne">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-parent="#app_show" href="#building" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.building_photo') }}</a>
                </h5>
            </div>
            <div id="building" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                @foreach ($files as $file)
                @if($file->building != '')
                    <div class="row text-center mt-2">
                        @php
                            $buildings = explode(',', $file->building);
                            $i = 1;
                        @endphp
                        @foreach ($buildings as $foto)
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                <p class="m-t-10 m-b-10">{{ __('lang.building_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                            </div>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </div>
                @else
                    <h4 class="mt-5 mb-5 text-center text-danger">ဓါတ်ပုံတင်ထားခြင်း မရှိပါ</h4>
                @endif
                @endforeach
            </div>
        </div>
    @endif

    @if($data->apply_division == 3) {{-- if mandalay --}}
        {{-- city license  --}}
        <div class="card mb-1">
            <div class="card-header d-flex" role="tab" id="headingOne">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-parent="#app_show" href="#city_license" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.city_license') }}</a>
                </h5>
            </div>
            <div id="city_license" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                @foreach ($files as $file)
                <div class="row text-center mt-2">
                    @php
                        $fotos = explode(',', $file->city_license);
                        $i = 1;
                    @endphp
                    @foreach ($fotos as $foto)
                    <div class="col-md-6 text-center">
                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                        <p class="m-t-10 m-b-10">{{ __('lang.city_license') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                    </div>
                    @php
                        $i++;
                    @endphp
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
        {{-- ministry permit  --}}
        <div class="card mb-1">
            <div class="card-header d-flex" role="tab" id="headingOne">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-parent="#app_show" href="#ministry_permit" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.ministry_permit') }}</a>
                </h5>
            </div>
            <div id="ministry_permit" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                @foreach ($files as $file)
                <div class="row text-center mt-2">
                    @php
                        $fotos = explode(',', $file->ministry_permit);
                        $i = 1;
                    @endphp
                    @foreach ($fotos as $foto)
                    <div class="col-md-6 text-center">
                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                        <p class="m-t-10 m-b-10">{{ __('lang.ministry_permit') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                    </div>
                    @php
                        $i++;
                    @endphp
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    @endif
    
    @if (isset($error) && $error->count() > 0)
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
    @if (isset($pending) && $pending->count() > 0)
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

    @if (isset($survey_result) && $survey_result->count() > 0)
    <div class="card mb-1">
        <div class="card-header d-flex" role="tab" id="headingOne">
            <h5 class="mb-0">
                <a data-toggle="collapse" data-parent="#app_show" href="#technical" aria-expanded="true" aria-controls="collapseOne">{{ __('မြေပြင်စစ်ဆေးချက်') }}</a>
            </h5>
            @if (chk_userForm($data->id)['to_confirm_survey'])
                @if (hasPermissions(['commercialPowerTownshipChkGrd-edit']))
                <div class="ml-auto">
                    <a href="{{ route('commercialPowerMeterGroundCheckDoneList.edit', $data->id) }}" class="btn-edit text-danger ">{{ __('lang.edit') }}</a>
                </div>
                @endif
            @endif
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
                                    {{ $survey_result->t_info }}
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
                                <td>{{ __('လက်ရှိ ဓာတ်အားခွဲရုံ၊ ဓာတ်အားပေးစက်ရုံ အခြေအနေ') }}</td>
                                <td>
                                    <table class="text-center">
                                        <tbody>
                                            <tr>
                                                <td style="border: 1px solid black; vertical-align: middle;" rowspan="2">တိုင်းတာသည့်နေ့</td>
                                                <td style="border: 1px solid black; vertical-align: middle;" rowspan="2">တိုင်းတာသည့်အချိန်</td>
                                                <td style="border: 1px solid black; vertical-align: middle;" rowspan="2">ဗို့</td>
                                                <td style="border: 1px solid black;" colspan="4">ဝန်အား(Amper)</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;">R</td>
                                                <td style="border: 1px solid black;">Y</td>
                                                <td style="border: 1px solid black;">B</td>
                                                <td style="border: 1px solid black;">N</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;">
                                                    @if ($survey_result->curr_transmitter_date)
                                                    {{ checkMM() == 'mm' ? mmMonth(date('m', strtotime($survey_result->curr_transmitter_date))).' '.mmNum(date('d', strtotime($survey_result->curr_transmitter_date))).', '.mmNum(date('Y', strtotime($survey_result->curr_transmitter_date))) : date('M d, Y', strtotime($survey_result->curr_transmitter_date)) }}
                                                    @else
                                                    -
                                                    @endif
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    @if ($survey_result->curr_transmitter_date)
                                                    {{ checkMM() == 'mm' ? mmNum(date('H:i', strtotime($survey_result->curr_transmitter_date))) : date('H:i', strtotime($survey_result->curr_transmitter_date)) }}
                                                    @else
                                                    -
                                                    @endif
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    @if ($survey_result->curr_transmitter_volt)
                                                    {{ checkMM() ? mmNum($survey_result->curr_transmitter_volt) : $survey_result->curr_transmitter_volt }}
                                                    @endif
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    @if ($survey_result->amper_r)
                                                    {{ checkMM() ? mmNum($survey_result->amper_r) : $survey_result->amper_r }}
                                                    @endif
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    @if ($survey_result->amper_y)
                                                    {{ checkMM() ? mmNum($survey_result->amper_y) : $survey_result->amper_y }}
                                                    @endif
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    @if ($survey_result->amper_b)
                                                    {{ checkMM() ? mmNum($survey_result->amper_b) : $survey_result->amper_b }}
                                                    @endif
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    @if ($survey_result->amper_n)
                                                    {{ checkMM() ? mmNum($survey_result->amper_n) : $survey_result->amper_n }}
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('ဓာတ်အားလိုင်း တိုးချဲ့ရန် လို/မလို') }}</td>
                                <td>
                                    @if ($survey_result->cable_extend == true)
                                        <p>{{ __('လိုပါသည်') }}</p>
                                    @elseif ($survey_result->cable_extend == false)
                                        <p>{{ __('မလိုပါ') }}</p>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('လက်ရှိလျှပ်တာပြောင်းသည် ယခင်က ချို့ယွင်းခဲ့ဖူးခြင်း ရှိ/မရှိ') }}</td>
                                <td>
                                    @if ($survey_result->transmitter_error == true)
                                        <p>{{ __('lang.radio_yes') }}</p>
                                    @elseif ($survey_result->transmitter_error == false)
                                        <p>{{ __('lang.radio_no') }}</p>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('လျှပ်တာပြောင်းမှ ဓာတ်အားသုံးစွဲမည့်နေရာသို့ ဆွဲထားသော လိုင်းကြိုး၊ ကြေးကြိုးအရွယ်အစားနှင့် အရေအတွက်') }}</td>
                                <td>
                                    @if ($survey_result->cable_size_type)
                                    {{ $survey_result->cable_size_type }}
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('နောက်ဆုံး(၆)လအတွင်း စစ်ဆေးရရှိခဲ့သော လျှပ်တာပြောင်း အင်စူလေးရှင်းအခြေအနေနှင့် စစ်ဆေးသောနေ့') }}</td>
                                <td>
                                    @if ($survey_result->insulation_date)
                                    {{ checkMM() == 'mm' ? mmMonth(date('m', strtotime($survey_result->insulation_date))).' '.mmNum(date('d', strtotime($survey_result->insulation_date))).', '.mmNum(date('Y', strtotime($survey_result->insulation_date))) : date('M d, Y', strtotime($survey_result->insulation_date)) }}
                                    <br>
                                    <table class="text-center">
                                        <tbody>
                                            <tr>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;" colspan="4">Continuity</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;" colspan="12">Insulation</td>
                                            </tr>
                                            <tr>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;"></td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">R-Y</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">Y-B</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">B-R</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;"></td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">R-E</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">Y-E</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">B-E</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">N-E</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">R-Y</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">H-T-E</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">H-T-L-T</td>
                                            </tr>
                                            <tr>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">H-T</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->chtry }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->chtyb }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->chtbr }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">H-T</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->ihtre }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->ihtye }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->ihtbe }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->ihtne }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->ihtry }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->ihthte }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->ihthtlt }}</td>
                                            </tr>
                                            <tr>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">L-T</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->cltry }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->cltyb }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->cltbr }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">L-T</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->iltre }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->iltye }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->iltbe }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->iltne }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->iltry }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->ilthte }}</td>
                                                <td class="px-0 py-2" width="8%" style="border: 1px solid black;">{{ $survey_result->ilthtlt }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                                <td>{{ __('lang.loaded_cdt') }}</td>
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
                            {{-- လျှောက်ထားသည့် ဝန်အားစာရင်း --}}
                            <tr>
                                <td>{{ __('lang.applied_load_list') }}</td>
                                <td>
                                    @foreach ($files as $file)
                                        @if($file->electric_power != '')
                                            <div class="row text-center mt-2">
                                                @php
                                                    $fotos = explode(',', $file->electric_power);
                                                    $i = 1;
                                                @endphp
                                                @foreach ($fotos as $foto)
                                                    <div class="col-md-3 text-center">
                                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                                    </div>
                                                @php
                                                    $i++;
                                                @endphp
                                                @endforeach
                                            </div>
                                        @else
                                            <h4 class="mt-5 mb-5 text-center text-danger">ဓါတ်ပုံတင်ထားခြင်း မရှိပါ</h4>
                                        @endif
                                        @endforeach
                                </td>
                            </tr>
                            {{-- ခွင့်ပြုပေးမည့် ဝန်အားစာရင်း --}}
                            <tr>
                                <td>{{ __('lang.allowed_load_list') }}</td>
                                <td>
                                    @if ($survey_result->r_power_files)
                                    <div class="row">
                                        @php
                                            $r_power_files = explode(',', $survey_result->r_power_files);
                                            $i = 1;
                                        @endphp
                                        @foreach ($r_power_files as $foto)
                                        <?php 
                                            $filename = asset('storage/user_attachments/'.$data->id.'/'.$foto);
                                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                            ;
                                        ?>
                                        @if($ext != 'pdf')
                                        <div class="col-md-3 text-center">
                                            <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                        </div>
                                        @else
                                            <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" target="_blank">{{ $foto }}</a>
                                        @endif
                                        @php
                                            $i++;
                                        @endphp
                                        @endforeach
                                    </div>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @if($survey_result->r_building_files != "")
                            <tr>
                                <td>{{ __('အဆောက်အဦ ဓါတ်ပုံ') }}</td>
                                <td>
                                    @if ($survey_result->r_building_files)
                                    <div class="row">
                                        @php
                                            $r_building_files = explode(',', $survey_result->r_building_files);
                                            $i = 1;
                                        @endphp
                                        @foreach ($r_building_files as $foto)
                                        <?php 
                                            $filename = asset('storage/user_attachments/'.$data->id.'/'.$foto);
                                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                            ;
                                        ?>
                                        @if($ext != 'pdf')
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                            </div>
                                        @else
                                            <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" target="_blank" >{{ $foto }}</a>
                                        @endif
                                        @php
                                            $i++;
                                        @endphp
                                        @endforeach
                                    </div>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @endif

                            {{-- location map --}}
                            <tr>
                                <td>{{ __('lang.location_map_2') }}</td>
                                <td>
                                    @if ($survey_result->location_map)
                                        <?php 
                                        $filename = asset('storage/user_attachments/'.$data->id.'/'.$survey_result->location_map);
                                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                        ;
                                        ?>
                                        @if($ext != 'pdf')
                                        <div class="col-md-3 text-center">
                                            <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->location_map) }}" alt="{{ $survey_result->location_map }}" class="img-thumbnail imgViewer">
                                        </div>
                                        @else
                                        <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->location_map) }}" target="_blank">{{ $survey_result->location_map }}</a>
                                        @endif
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            
                            {{-- ဓာတ်အားပေးမည့် ထရန်စဖော်မာအမည် --}}
                            <tr>
                                <td>{{ __('lang.power_tranformer') }}</td>
                                <td>
                                    {{ $survey_result->power_tranformer ? $survey_result->power_tranformer : '-' }}
                                </td>
                            </tr>

                            {{-- ၄၀၀ဗို့ ဓာတ်အားလိုင်းပြမြေပုံ --}}
                            <tr>
                                <td>{{ __('lang.line_map_400') }}</td>
                                <td>
                                    @if ($survey_result->line_map_400)
                                        <?php 
                                        $filename = asset('storage/user_attachments/'.$data->id.'/'.$survey_result->line_map_400);
                                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                        ;
                                        ?>
                                        @if($ext != 'pdf')
                                        <div class="col-md-3 text-center">
                                            <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->line_map_400) }}" alt="{{ $survey_result->line_map_400 }}" class="img-thumbnail imgViewer">
                                        </div>
                                        @else
                                        <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->line_map_400) }}" target="_blank">{{ $survey_result->line_map_400 }}</a>
                                        @endif
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>


                            <tr>
                                <td>{{ __('တပ်ဆင်ခွင့်ပြုသည့် မီတာအမျိုးအစား') }}</td>
                                <td>
                                    {{ checkMM() == 'mm' ? mmNum(p_meter($survey_result->allow_p_meter)).' ကီလိုဝပ်' : p_meter($survey_result->allow_p_meter).' KW' }}
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('lang.remark') }}</td>
                                <td>
                                    {{ $survey_result->remark ? $survey_result->remark : '-' }}
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if (isset($install) && $install->count() > 0)
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
                                <td width="30%">{{__('တပ်ဆင်ပြီးသည့် နေ့စွဲ')}}</td>
                                <td>{{ mmMonth(date('m', strtotime($install_date))).' '.mmNum(date('d', strtotime($install_date))).', '.mmNum(date('Y', strtotime($install_date))) }}</td>
                            </tr>
                            {{-- <tr>
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
                            </tr> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- install confirm --}}
    @if (isset($ei_data) && $ei_data->count() > 0)
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
                                    <div class="row">
                                        @foreach ($ei as $foto)
                                            @if ($foto)
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
                                            @else
                                            -
                                            @endif
                                        @php
                                            $i++;
                                        @endphp
                                        @endforeach
                                    </div>
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

@elseif ($data->apply_type == 4) {{-- transformer --}}
    <!--@if (chk_userForm($data->id)['to_confirm_dist'])-->
    <!--<div class="card mb-1">-->
    <!--    <div class="card-header d-flex" role="tab" id="headingOne">-->
    <!--        <h5 class="mb-0">-->
    <!--            <a data-toggle="collapse" data-parent="#app_show" href="#heading_letter" aria-expanded="true" aria-controls="collapseOne">{{ __('မြို့နယ်ရုံးမှ ခရိုင်ရုံးသို့ လျှောက်လွှာတင်ပြခြင်း') }}</a>-->
    <!--        </h5>-->
    <!--    </div>-->
    <!--    <div id="heading_letter" class="collapse show" role="tabpanel" aria-labelledby="headingOne">-->
    <!--        <div class="container">-->
    <!--            <div class="card-body mm">-->
    <!--                <div class="p-t-10 p-b-10">-->
    <!--                    <h6>သို့</h6>-->
    <!--                    <h6 class="p-l-30 p-t-10">ခရိုင်လျှပ်စစ်မန်နေဂျာ</h6>-->
    <!--                    @if ($data->div_state_id == 3)-->
    <!--                    <h6 class="p-l-30 p-t-10">မန္တလေးလျှပ်စစ်ဓာတ်အားပေးရေးကော်ပိုရေးရှင်း</h6>-->
    <!--                    @else-->
    <!--                    <h6 class="p-l-30 p-t-10">လျှပ်စစ်ဓာတ်အားဖြန့်ဖြူးရေးလုပ်ငန်း</h6>-->
    <!--                    @endif-->
    <!--                    <h6 class="p-l-30 p-t-10">{{ district_mm($data->district_id) }}၊ {{ div_state_mm($data->div_state_id) }}</h6>-->
    <!--                </div>-->
    <!--                <div class="text-right p-t-10">-->
    <!--                    <h6>ရက်စွဲ။<span class="p-l-20">။</span> {{ mmNum(date('d-m-Y', strtotime($data->date))) }}</h6>-->
    <!--                </div>-->
    <!--                <div class="p-t-10">-->
    <!--                    <h6>အကြောင်းအရာ။<span class="p-l-40">။</span> <b>အိမ်သုံးပါ၀ါမီတာ တပ်ဆင်ခွင့်ပြုပါရန် လျှောက်ထားခြင်း။</b></h6>-->
    <!--                </div>-->
    <!--                <div class="p-t-10">-->
    <!--                    <p class="l-h-35">-->
    <!--                        ၁။<span class="p-l-30"></span><span class="p-l-30"></span>-->
    <!--                        {{ address_mm($data->id) }}ရှိ {{ $data->fullname }}({{ $data->nrc }})၏ နေအိမ်တွင် 'အလင်းရောင်'သုံးစွဲရန် ၃သွင်၊ ၄ကြိုး {{ power_meter_type($data->id) }} ပါဝါမီတာ(၁)လုံး တပ်ဆင်သုံးစွဲခွင့်ပြုပါရန် လျှောက်ထားလာပါသည်။-->
    <!--                    </p>-->
    <!--                    <p class="l-h-35">-->
    <!--                        ၂။<span class="p-l-30"></span><span class="p-l-30"></span>-->
    <!--                        အဆိုပါ {{ address_mm($data->id) }}ရှိ {{ $data->fullname }}({{ $data->nrc }})၏ နေအိမ်တွင် 'အလင်းရောင်သုံး' ဓာတ်အားရရှိရေးအတွက် {{ $survey_result->t_info }}မှ ဓာတ်အားပေးရမည် ဖြစ်ပါသည်။ ၎င်း၏ လက်ရှိ (၄၀၀)ဗို့ ဓာတ်အားလိုင်းမှာ {{ $survey_result->cable_size_type }}ဖြင့် တည်ဆောက်ထား၍ နေအိမ်အဆောက်အအုံနှင့် (၄၀၀)ဗို့ဓာတ်အားလိုင်းမှာ ({{ mmNum($survey_result->distance) }})ပေခန့် ကွာဝေးပါသည်။-->
    <!--                    </p>-->
    <!--                    <p class="l-h-35">-->
    <!--                        ၃။<span class="p-l-30"></span><span class="p-l-30"></span>-->
    <!--                        သို့ဖြစ်ပါ၍ {{ address_mm($data->id) }}ရှိ {{ $data->fullname }}({{ $data->nrc }})၏ နေအိမ်တွင် 'အလင်းရောင်သုံး' သုံးစွဲရန်အတွက် ၃သွင်၊ ၄ကြိုး {{ power_meter_type($data->id) }} ပါဝါမီတာ လျှောက်ထားခြင်းအား လိုအပ်သလို ဆောင်ရွက်နိုင်ပါရန် စိစစ်တင်ပြအပ်ပါသည်။-->
    <!--                    </p>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    <!--@endif-->
    {{--  user profile  --}}
    <div class="card mb-1">
        <div class="card-header d-flex" role="tab" id="headingOne">
            <h5 class="mb-0">
                <a data-toggle="collapse" data-parent="#app_show" href="#info" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.user_info') }}</a>
            </h5>
        </div>
        <div id="info" class="collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="container">
                <div class="card-body mm">
                    <h5 class="text-center"><b>
                        @if($data->apply_division == 1)
                            @if($data->apply_tsf_type == 1)
                                အိမ်သုံးထရန်စဖော်မာ လျှောက်လွှာပုံစံ
                            @else
                                လုပ်ငန်းသုံးထရန်စဖော်မာ လျှောက်လွှာပုံစံ
                            @endif
                        @else
                            ထရန်စဖော်မာ လျှောက်လွှာပုံစံ
                        @endif
                    </b></h5>
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
                        <h6>အကြောင်းအရာ။<span class="p-l-40">။</span> <b> 
                            {{ tsf_type($data->id) }} 
                            တည်ဆောက် တပ်ဆင် ခွင့်ပြုပါရန် လျှောက်ထားခြင်း။
                        </b></h6>
                    </div>
                    <div class="p-t-10">
                        <h6 class="l-h-35">
                            <span class="p-l-40"></span><span class="p-l-40"></span>
                            အထက်ပါကိစ္စနှင့်ပတ်သက်၍ {{ address_mm($data->id) }}နေ ကျွန်တော်/ကျွန်မ၏ <b>{{ $data->applied_building_type ? $data->applied_building_type : '<span class="p-l-40"></span>' }}</b> တွင် 
                            @if($data->business_name != '')
                                {{ $data->business_name }}လုပ်ငန်းအတွက်
                            @endif
                            {{ tsf_type($data->id) }} တပ်ဆင်သုံးစွဲခွင့်ပြုပါရန် လျှောက်ထားအပ်ပါသည်။
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
    {{--  meter type  --}}
    <div class="card mb-1">
        <div class="card-header d-flex" role="tab" id="headingOne">
            <h5 class="mb-0">
                <a data-toggle="collapse" data-parent="#app_show" href="#typeOfMeter" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.applied_plan_tsf') }}</a>
            </h5>
        </div>
        <div id="typeOfMeter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="container">
                <div class="talbe-responsive p-20">
                    <p>
                        ထရန်စဖော်မာအမျိုးအစား - 
                        @if($data->pole_type == 1)
                            {{ __('lang.one_pole') }} အမျိုးအစား
                        @elseif($data->pole_type == 2)
                            {{ __('lang.two_pole') }} အမျိုးအစား
                        @elseif($data->pole_type == 3)
                            {{ __('lang.three_pole') }} အမျိုးအစား
                        @endif
                    </p>
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
                            @if (($col_name != 'building_fee' || $data->apply_division == 3) && $col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'composit_box' && $col_name != 'sub_type' && $col_name != 'incheck_fee')
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
    {{--  nrc  --}}
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
    {{--  form 10  --}}
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
                @else
            <h4 class="mt-5 mb-5 text-center text-danger">{{ __('ဓါတ်ပုံတင်ထားခြင်း မရှိပါ') }}</h4>
                @endif
            @endforeach
        </div>
    </div>
    {{--  recommanded letter  --}}
    <div class="card mb-1">
        <div class="card-header d-flex" role="tab" id="headingOne">
            <h5 class="mb-0">
                <a data-toggle="collapse" data-parent="#app_show" href="#recommanded_letter" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.recomm') }}</a>
            </h5>
        </div>
        <div id="recommanded_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
            @foreach ($files as $file)
                @if ($file->occupy_letter)
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
                @else
            <h4 class="mt-5 mb-5 text-center text-danger">{{ __('ဓါတ်ပုံတင်ထားခြင်း မရှိပါ') }}</h4>
                @endif
            @endforeach
        </div>
    </div>
    {{--  ownership  --}}
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
    {{-- commercial license  --}}
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
                    <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
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
    {{-- dc recommanded letter --}}
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
                    <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                    <p class="m-t-10 m-b-10">{{ __('lang.applied_dc_recomm_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
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
    {{-- if yangon --}}
    @if($data->apply_division == 1)
        {{--  farmland  --}}
        <div class="card mb-1">
            <div class="card-header d-flex" role="tab" id="headingOne">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-parent="#app_show" href="#farmland" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.farmland_permit') }}</a>
                </h5>
            </div>
            <div id="farmland" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                @foreach ($files as $file)
                @if($file->farmland != '')
                    <div class="row text-center mt-2">
                        @php
                            $farmlands = explode(',', $file->farmland);
                            $i = 1;
                        @endphp
                        @foreach ($farmlands as $foto)
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                <p class="m-t-10 m-b-10">{{ __('lang.farmland_permit') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                            </div>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </div>
                @else
                    <h4 class="mt-5 mb-5 text-center text-danger">ဓါတ်ပုံတင်ထားခြင်း မရှိပါ</h4>
                @endif
                @endforeach
            </div>
        </div>
        {{--  industry  --}}
        <div class="card mb-1">
            <div class="card-header d-flex" role="tab" id="headingOne">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-parent="#app_show" href="#industry" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.industry_zone') }}</a>
                </h5>
            </div>
            <div id="industry" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                @foreach ($files as $file)
                @if($file->industry != '')
                    <div class="row text-center mt-2">
                        @php
                            $fotos = explode(',', $file->industry);
                            $i = 1;
                        @endphp
                        @foreach ($fotos as $foto)
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                <p class="m-t-10 m-b-10">{{ __('lang.industry_zone') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                            </div>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </div>
                @else
                    <h4 class="mt-5 mb-5 text-center text-danger">ဓါတ်ပုံတင်ထားခြင်း မရှိပါ</h4>
                @endif
                @endforeach
            </div>
        </div>
        {{--  electric power  --}}
        <div class="card mb-1">
            <div class="card-header d-flex" role="tab" id="headingOne">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-parent="#app_show" href="#electric_power" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.applied_electricpower_photo') }}</a>
                </h5>
            </div>
            <div id="electric_power" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                @foreach ($files as $file)
                @if($file->electric_power != '')
                    <div class="row text-center mt-2">
                        @php
                            $fotos = explode(',', $file->electric_power);
                            $i = 1;
                        @endphp
                        @foreach ($fotos as $foto)
                            <div class="col-md-6 text-center">
                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                <p class="m-t-10 m-b-10">{{ __('lang.applied_electricpower_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                            </div>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </div>
                @else
                    <h4 class="mt-5 mb-5 text-center text-danger">ဓါတ်ပုံတင်ထားခြင်း မရှိပါ</h4>
                @endif
                @endforeach
            </div>
        </div>
    @endif
    @if (isset($error) && $error->count() > 0)
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
    @if (isset($pending) && $pending->count() > 0)
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
    @if (isset($survey_result) && $survey_result->count() > 0)
        @if ($survey_result->survey_remark)
    <div class="card mb-1">
        <div class="card-header d-flex" role="tab" id="headingOne">
            <h5 class="mb-0">
                <a data-toggle="collapse" data-parent="#app_show" href="#technical" aria-expanded="true" aria-controls="collapseOne">{{ __('မြေပြင်စစ်ဆေးချက်များ') }}</a>
            </h5>
            @if (chk_userForm($data->id)['to_confirm_survey'])
                @if (hasPermissions(['transformerTownshipChkGrd-edit']))
                <div class="ml-auto">
                    <a href="{{ route('transformerGroundCheckDoneList.edit', $data->id) }}" class="btn-edit text-danger ">{{ __('lang.edit') }}</a>
                </div>
                @endif
            @endif
        </div>
        <div id="technical" class="card-body collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="row justify-content-center m-t-20">
                @isset($survey_result->survey_engineer)
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
                @endisset
                
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
                                    <th>{{ __('ဓါတ်အားပေးမည့် Primary Source') }}</th>
                                    <td>
                                        @if ($survey_result->p_tsf_name)
                                        {{ $survey_result->p_tsf_type.' KV' }} {{ '/ 11 KV' }} {{ $survey_result->p_tsf_name }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ $survey_result->p_main_ct_ratio.' KV Main CT Ratio' }}</td>
                                    <td>
                                        @if ($survey_result->p_main_ct_ratio_amt)
                                            {{ $survey_result->p_main_ct_ratio_amt }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ '11 KV Main CT Ratio' }}</td>
                                    <td>
                                        @if ($survey_result->p_11_main_ct_ratio)
                                            {{ $survey_result->p_11_main_ct_ratio }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ 'ဓါတ်အားခွဲရုံ Capacity' }}</td>
                                    <td>
                                        @if ($survey_result->p_capacity)
                                            {{ $survey_result->p_capacity }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ 'Peak Load (Day)' }}</td>
                                    <td>
                                        @if ($survey_result->p_11_peak_load_day)
                                            {{ $survey_result->p_11_peak_load_day }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ 'Peak Load (Night)' }}</td>
                                    <td>
                                        @if ($survey_result->p_11_peak_load_night)
                                            {{ $survey_result->p_11_peak_load_night }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ 'Installed Capacity' }}</td>
                                    <td>
                                        @if ($survey_result->p_11_installed_capacity)
                                            {{ $survey_result->p_11_installed_capacity }}
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
                                    <td>{{ '11KV/6.6KV Main CT Ratio' }}</td>
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
                                        @elseif ($survey_result->string_change == 'no')
                                            {{ 'မလိုပါ' }}
                                        @else
                                            -
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
                                    <td>{{ 'အသစ်တည်ဆောက်ရမည့်ဓါတ်အားလိုင်းပေအရှည်
                                        ' }}</td>
                                    <td>{{ $survey_result->string_new_type_length }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ 'ဝန်အားနိုင်နင်းမှု ရာခိုင်နှုန်း' }}</td>
                                    <td>{{ $survey_result->load_percent }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>{{ __('ဓါတ်အားခွဲရုံမှူး၏ ထောက်ခံချက်') }}</td>
                                    <td>
                                        @if ($survey_result->power_station_recomm)
                                            <?php 
                                            $filename = asset('storage/user_attachments/'.$data->id.'/'.$survey_result->power_station_recomm);
                                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                            ;
                                            ?>
                                            @if($ext != 'pdf')
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->power_station_recomm) }}" alt="{{ $survey_result->power_station_recomm }}" class="img-thumbnail imgViewer">
                                            </div>
                                            @else
                                            <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->power_station_recomm) }}" target="_blank">{{ $survey_result->power_station_recomm }}</a>
                                            @endif
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.one_line_diagram') }}</td>
                                    <td>
                                        @if ($survey_result->one_line_diagram)
                                            <?php 
                                            $filename = asset('storage/user_attachments/'.$data->id.'/'.$survey_result->one_line_diagram);
                                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                            ;
                                            ?>
                                            @if($ext != 'pdf')
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->one_line_diagram) }}" alt="{{ $survey_result->one_line_diagram }}" class="img-thumbnail imgViewer">
                                            </div>
                                            @else
                                            <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->one_line_diagram) }}" target="_blank">{{ $survey_result->one_line_diagram }}</a>
                                            @endif
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('lang.location_map') }}</td>
                                    <td>
                                        @if ($survey_result->location_map)
                                            <?php 
                                            $filename = asset('storage/user_attachments/'.$data->id.'/'.$survey_result->location_map);
                                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                            ;
                                            ?>
                                            @if($ext != 'pdf')
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->location_map) }}" alt="{{ $survey_result->location_map }}" class="img-thumbnail imgViewer">
                                            </div>
                                            @else
                                            <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->location_map) }}" target="_blank">{{ $survey_result->location_map }}</a>
                                            @endif
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Google Map') }}</td>
                                    <td>
                                        @if ($survey_result->google_map)
                                            <?php 
                                            $filename = asset('storage/user_attachments/'.$data->id.'/'.$survey_result->google_map);
                                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                            ;
                                            ?>
                                            @if($ext != 'pdf')
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->google_map) }}" alt="{{ $survey_result->google_map }}" class="img-thumbnail imgViewer">
                                            </div>
                                            @else
                                            <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->google_map) }}" target="_blank">{{ $survey_result->google_map }}</a>
                                            @endif
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                
                                {{-- လျှောက်ထားသည့် ဝန်အားစာရင်း --}}
                                <tr>
                                    <td>{{ __('lang.applied_load_list') }}</td>
                                    <td>
                                        @foreach ($files as $file)
                                            @if($file->electric_power != '')
                                                <div class="row text-center mt-2">
                                                    @php
                                                        $fotos = explode(',', $file->electric_power);
                                                        $i = 1;
                                                    @endphp
                                                    @foreach ($fotos as $foto)
                                                        <div class="col-md-3 text-center">
                                                            <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                                        </div>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                    @endforeach
                                                </div>
                                            @else
                                                -
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                
                                {{-- အသုံးပြုမည့် ဝန်အားစာရင်း --}}
                                <tr>
                                    <td>{{ __('lang.allowed_load_list') }}</td>
                                    <td>
                                        @if ($survey_result->comsumed_power_list)
                                            <?php 
                                            $filename = asset('storage/user_attachments/'.$data->id.'/'.$survey_result->comsumed_power_list);
                                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                            ;
                                            ?>
                                            @if($ext != 'pdf')
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->comsumed_power_list) }}" alt="{{ $survey_result->comsumed_power_list }}" class="img-thumbnail imgViewer">
                                            </div>
                                            @else
                                            <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->comsumed_power_list) }}" target="_blank">{{ $survey_result->comsumed_power_list }}</a>
                                            @endif
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>{{ 'ခွင့်ပြုသည့် ထရန်စဖော်မာအမျိုးအစား (KVA)' }}</td>
                                    <td>
                                        {{ tsf_kva($survey_result->allowed_tsf) }}
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
                                @if ($survey_result->tsp_recomm)
                                <tr>
                                    <td>{{ 'မြိုနယ်ရုံးထောက်ခံချက်' }}</td>
                                    <td>
                                        @if ($survey_result->tsp_recomm)
                                            <?php 
                                            $filename = asset('storage/user_attachments/'.$data->id.'/'.$survey_result->tsp_recomm);
                                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                            ;
                                            ?>
                                            @if($ext != 'pdf')
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->tsp_recomm) }}" alt="{{ $survey_result->tsp_recomm }}" class="img-thumbnail imgViewer">
                                            </div>
                                            @else
                                            <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->tsp_recomm) }}" target="_blank">{{ $survey_result->tsp_recomm }}</a>
                                            @endif
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
                                @if ($survey_result->dist_recomm)
                                <tr>
                                    <td>{{ 'ခရိုင်ရုံးထောက်ခံချက်' }}</td>
                                    <td>
                                        @if ($survey_result->dist_recomm)
                                            <?php 
                                            $filename = asset('storage/user_attachments/'.$data->id.'/'.$survey_result->dist_recomm);
                                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                            ;
                                            ?>
                                            @if($ext != 'pdf')
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->dist_recomm) }}" alt="{{ $survey_result->dist_recomm }}" class="img-thumbnail imgViewer">
                                            </div>
                                            @else
                                            <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->dist_recomm) }}" target="_blank">{{ $survey_result->dist_recomm }}</a>
                                            @endif
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @if ($survey_result->capacitor_bank != '')
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
                                @if ($survey_result->outfit_meter != '')
                                <tr>
                                    <td>{{ 'Outfit Meter လို/မလို' }}</td>
                                    <td>
                                        @if ($survey_result->outfit_meter == 'yes')
                                            {{ 'လိုပါသည်' }}
                                        @else
                                            {{ 'မလိုပါ' }}
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @if ($survey_result->vcd != '')
                                <tr>
                                    <td>{{ 'VCD လို/မလို' }}</td>
                                    <td>
                                        @if ($survey_result->vcd == 'yes')
                                            {{ 'လိုပါသည်' }}
                                        @else
                                            {{ 'မလိုပါ' }}
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @if ($survey_result->load_break_switch != '')
                                <tr>
                                    <td>{{ 'Load Break Switch လို/မလို' }}</td>
                                    <td>
                                        @if ($survey_result->load_break_switch == 'yes')
                                            {{ 'လိုပါသည်' }}
                                        @else
                                            {{ 'မလိုပါ' }}
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
                                @if ($survey_result->div_state_recomm)
                                <tr>
                                    <td>{{ 'တိုင်းဒေသကြီး/ပြည်နယ်ရုံးထောက်ခံချက်' }}</td>
                                    <td>
                                        @if ($survey_result->div_state_recomm)
                                            <?php 
                                            $filename = asset('storage/user_attachments/'.$data->id.'/'.$survey_result->div_state_recomm);
                                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                            ;
                                            ?>
                                            @if($ext != 'pdf')
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->div_state_recomm) }}" alt="{{ $survey_result->div_state_recomm }}" class="img-thumbnail imgViewer">
                                            </div>
                                            @else
                                            <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->div_state_recomm) }}" target="_blank">{{ $survey_result->div_state_recomm }}</a>
                                            @endif
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
                                @if ($survey_result->head_office_recomm)
                                <tr>
                                    <td>{{ 'ရုံးချုပ်ထောက်ခံချက်' }}</td>
                                    <td>
                                        @if ($survey_result->head_office_recomm)
                                            <?php 
                                            $filename = asset('storage/user_attachments/'.$data->id.'/'.$survey_result->head_office_recomm);
                                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                            ;
                                            ?>
                                            @if($ext != 'pdf')
                                            <div class="col-md-3 text-center">
                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->head_office_recomm) }}" alt="{{ $survey_result->head_office_recomm }}" class="img-thumbnail imgViewer">
                                            </div>
                                            @else
                                            <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->head_office_recomm) }}" target="_blank">{{ $survey_result->head_office_recomm }}</a>
                                            @endif
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
    @endif
    @if (isset($install) && $install->count() > 0)
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
                                <td width="30%">{{__('တပ်ဆင်ပြီးသည့် နေ့စွဲ')}}</td>
                                <td>{{ mmMonth(date('m', strtotime($install_date))).' '.mmNum(date('d', strtotime($install_date))).', '.mmNum(date('Y', strtotime($install_date))) }}</td>
                            </tr>
                           {{-- <tr>
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
                           </tr> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if (isset($ei_data) && $ei_data->count() > 0)
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
                                    <div class="row">
                                        @foreach ($ei as $foto)
                                            @if ($foto)
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
                                            @else
                                            -
                                            @endif
                                        @php
                                            $i++;
                                        @endphp
                                        @endforeach
                                    </div>
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
    
@else {{-- contractor meter --}}
    
@endif

