@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('contractorMeterCheckInstallList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
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
                                    <a data-toggle="collapse" data-parent="#app_show" href="#permit_letter" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.permit') }}
                                    </a>
                                </h5>
                            </div>
                            <div id="permit_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->building_permit) }}" alt="{{ $file->building_permit }}" class="img-thumbnail" width="150" height="150">
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
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->bcc) }}" alt="{{ $file->bcc }}" class="img-thumbnail" width="150" height="150">

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
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->dc_recomm) }}" alt="{{ $file->dc_recomm }}" class="img-thumbnail" width="150" height="150">

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
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$file->prev_bill) }}" alt="{{ $file->prev_bill }}" class="img-thumbnail" width="150" height="150">

                                        <p class="m-t-10 m-b-10">{{ __('lang.applied_bill_photo') }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        {{-- bq --}}
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0 ">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#bq" aria-expanded="true" aria-controls="collapseOne">
                                    {{ __('lang.bq_photo') }}
                                    </a>
                                </h5>
                            </div>
                            <div id="bq" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @if ($files->count() > 0)
                                    @foreach ($files as $file)
                                        @if ($file->bq)
                                <div class="row text-center mt-2">
                                    @php
                                        $fotos = explode(',', $file->bq);
                                        $i = 1;
                                    @endphp
                                            @foreach ($fotos as $foto)
                                    <div class="col-md-6 text-center">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ __('lang.building_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})" class="img-thumbnail imgViewer" width="150" height="150">
                                        <p class=" m-t-10 m-b-10">{{ __('lang.bq_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
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
                                @else
                                <h4 class="mt-5 mb-5 text-center text-danger">{{ __('ဓါတ်ပုံတင်ထားခြင်း မရှိပါ') }}</h4>
                                @endif
                            </div>
                        </div>

                        {{-- drawing --}}
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0 ">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#drawing" aria-expanded="true" aria-controls="collapseOne">
                                    {{ __('lang.drawing_photo') }}
                                    </a>
                                </h5>
                            </div>
                            <div id="drawing" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @if ($files->count() > 0)
                                    @foreach ($files as $file)
                                        @if ($file->drawing)
                                <div class="row text-center mt-2">
                                    @php
                                        $fotos = explode(',', $file->drawing);
                                        $i = 1;
                                    @endphp
                                            @foreach ($fotos as $foto)
                                    <div class="col-md-6 text-center">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ __('lang.building_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})" class="img-thumbnail imgViewer" width="150" height="150">
                                        <p class=" m-t-10 m-b-10">{{ __('lang.drawing_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
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
                                @else
                                <h4 class="mt-5 mb-5 text-center text-danger">{{ __('ဓါတ်ပုံတင်ထားခြင်း မရှိပါ') }}</h4>
                                @endif
                            </div>
                        </div>

                        {{-- map --}}
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0 ">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#map" aria-expanded="true" aria-controls="collapseOne">
                                    {{ __('lang.map_photo') }}
                                    </a>
                                </h5>
                            </div>
                            <div id="map" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @if ($files->count() > 0)
                                    @foreach ($files as $file)
                                        @if ($file->map)
                                <div class="row text-center mt-2">
                                    @php
                                        $fotos = explode(',', $file->map);
                                        $i = 1;
                                    @endphp
                                            @foreach ($fotos as $foto)
                                    <div class="col-md-6 text-center">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ __('lang.building_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})" class="img-thumbnail imgViewer" width="150" height="150">
                                        <p class=" m-t-10 m-b-10">{{ __('lang.map_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
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
                                @else
                                <h4 class="mt-5 mb-5 text-center text-danger">{{ __('ဓါတ်ပုံတင်ထားခြင်း မရှိပါ') }}</h4>
                                @endif
                            </div>
                        </div>

                        {{-- ရေစက်မီတာလျှောက်ထားရာတွင် ကန်ထရိုက်ရှိ အခန်းစေ့နေသူများ၏ ကန့်ကွက်မှုမရှိကြောင်း လက်မှတ်ရေးထိုးထားမှုစာ (မူရင်း)  --}}
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0 ">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#sign" aria-expanded="true" aria-controls="collapseOne">
                                    {{ __('lang.sign_header') }}
                                    </a>
                                </h5>
                            </div>
                            <div id="sign" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @if ($files->count() > 0)
                                    @foreach ($files as $file)
                                        @if ($file->sign)
                                <div class="row text-center mt-2">
                                    @php
                                        $sign_photo = explode(',', $file->sign);
                                        $i = 1;
                                    @endphp
                                            @foreach ($sign_photo as $foto)
                                    <div class="col-md-6 text-center">
                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ __('lang.building_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})" class="img-thumbnail imgViewer" width="150" height="150">
                                        <p class=" m-t-10 m-b-10">{{ __('lang.building_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
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
                                @else
                                <h4 class="mt-5 mb-5 text-center text-danger">{{ __('ဓါတ်ပုံတင်ထားခြင်း မရှိပါ') }}</h4>
                                @endif
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
                                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
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
                                                                    <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
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
                                                                    <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
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
                                                                    <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
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
                    @if (chk_userForm($data->id)['to_chk_install'])
                        @if (hasPermissions(['contractorChkInstall-create']))
                    <div class="card mb-1">
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('တပ်ဆင်ရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => 'contractorMeterCheckInstallList.store']) !!}
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
                                        {!! Form::number('cash_kyat', null, ['id' => 'cash_kyat', 'class' => 'form-control inner-form']) !!}
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
