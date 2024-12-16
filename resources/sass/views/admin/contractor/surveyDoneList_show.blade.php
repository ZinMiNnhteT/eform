@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    @if (chk_userForm($data->id)['to_confirm_dist'])
                        <a href="{{ route('contractorMeterGroundCheckDoneListByDistrict.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                    @elseif (chk_userForm($data->id)['to_confirm_div_state'])
                        <a href="{{ route('contractorMeterGroundCheckDoneListByDivisionState.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                    @else   
                        <a href="{{ route('contractorMeterGroundCheckDoneList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                    @endif
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

                        @if($data->apply_division == 1)
                            {{-- လယ်ယာပိုင်မြေအားအခြားနည်းဖြင့်သုံးဆွဲရန်ခွင့်ပြုချက် --}}
                            <div class="card mb-1">
                                <div class="card-header d-flex" role="tab" id="headingOne">
                                    <h5 class="mb-0 ">
                                        <a data-toggle="collapse" data-parent="#app_show" href="#farmland" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.farmland_permit') }}
                                        </a>
                                    </h5>
                                    @if (chk_send($data->id) !== 'first')
                                        @if (chk_form_finish($data->id, $data->apply_type)['farmland'])
                                    <div class="ml-auto">
                                        <a href="{{ route('contractor_farmland_edit_ygn', $data->id) }}" class="btn-edit text-info ">{{ __('lang.create') }}</a>
                                    </div>
                                        @else
                                    <div class="ml-auto">
                                        <a href="{{ route('contractor_farmland_edit_ygn', $data->id) }}" class="btn-edit text-danger ">{{ __('lang.edit') }}</a>
                                    </div>
                                        @endif
                                    @endif
                                </div>
                                <div id="farmland" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                    @if ($files->count() > 0)
                                        @foreach ($files as $file)
                                            @if ($file->farmland)
                                    <div class="row text-center mt-2">
                                        @php
                                            $farmland_foto = explode(',', $file->farmland);
                                            $i = 1;
                                        @endphp
                                                @foreach ($farmland_foto as $foto)
                                        <div class="col-md-6 text-center">
                                            <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ __('lang.permit') }} ({{ checkMM()=='mm'?mmNum($i):$i }})" class="img-thumbnail imgViewer" width="150" height="150">
                                            <p class=" m-t-10 m-b-10">{{ __('lang.permit') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
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

                            {{-- အဆောက်အဦဓါတ်ပုံ --}}
                            <div class="card mb-1">
                                <div class="card-header d-flex" role="tab" id="headingOne">
                                    <h5 class="mb-0 ">
                                        <a data-toggle="collapse" data-parent="#app_show" href="#building" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.building_photo') }}
                                        </a>
                                    </h5>
                                    @if (chk_send($data->id) !== 'first')
                                        @if (chk_form_finish($data->id, $data->apply_type)['building'])
                                    <div class="ml-auto">
                                        <a href="{{ route('contractor_building_edit_ygn', $data->id) }}" class="btn-edit text-info ">{{ __('lang.create') }}</a>
                                    </div>
                                        @else
                                    <div class="ml-auto">
                                        <a href="{{ route('contractor_building_edit_ygn', $data->id) }}" class="btn-edit text-danger ">{{ __('lang.edit') }}</a>
                                    </div>
                                        @endif
                                    @endif
                                </div>
                                <div id="building" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                    @if ($files->count() > 0)
                                        @foreach ($files as $file)
                                            @if ($file->building)
                                    <div class="row text-center mt-2">
                                        @php
                                            $building_foto = explode(',', $file->building);
                                            $i = 1;
                                        @endphp
                                                @foreach ($building_foto as $foto)
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
                        @endif

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
                    <div class="card mb-1">
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0">
                                <a data-toggle="collapse" data-parent="#app_show" href="#technical" aria-expanded="true" aria-controls="collapseOne">{{ __('
                                မြေပြင်စစ်ဆေးချက်များ') }}</a>
                            </h5>
                            @if (chk_userForm($data->id)['to_confirm_survey'])
                                @if (hasPermissions(['contractorTownshipChkGrd-edit']))
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
                                                    <td>{{ who($survey_result->survey_engineer)->username }}</td>
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
                                                            {{ checkMM() == 'mm' ? mmNum($survey_result->tsf_transmit_distance_kv) : $survey_result->tsf_transmit_distance_kv }}v
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
                                                    <td>{{ __('lang.location_map_2') }}</td>
                                                    <td>
                                                        @if ($survey_result->location_map)
                                                            <?php 
                                                                $foto = $survey_result->location_map;
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
                                                                <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer imgViewer">
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
                                                                    <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer imgViewer">
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
                                                                    <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer imgViewer">
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
                                                                    <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer imgViewer">
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

                    <div class="card mb-1">
                        {{--  --------------------------------- Division ---------------------------------  --}}
                        @if (chk_userForm($data->id)['to_confirm_div_state'])
                            @if (hasPermissions(['contractorDivStateChkGrd-create'])) {{--  if login-user is from township  --}}
                                {{-- @if(Auth::user()->hasRole('SeniorEngineer(Township)')) --}}
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('တိုင်းဒေသကြီး/ပြည်နယ်အဆင့် စစ်ဆေးရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => 'contractorMeterGroundCheckDoneListByDivisionState.store', 'files' => true]) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <div class="row justify-content-center m-t-20">
                                @if(!$survey_result->loaded)
                                <div class="col-md-8 m-t-20">
                                    <div class="form-group">
                                        <label for="bq_cost_div_state" class="text-info">{{ __('lang.bq_cost') }} ({{ __('lang.kyat') }}) {{ __('lang.bq_confirm') }}</label>
                                        <input type="number" name="bq_cost_div_state" class="form-control" id="bq_cost" />
                                    </div>
                                    <div class="form-group">
                                        <label for="bq_files" class="text-info">
                                            {{ __('lang.bq_cost') }} ({{ __('lang.attach_files') }})
                                        </label>
                                        <div class="bg-secondary p-20">
                                            <input type="file" name="bq_files[]" accept=".jpg,.png,.pdf" multiple/>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="container">
                                <div class="row justify-content-center">
                                    {{-- <a href="{{ route('transformerGroundCheckDoneListByDivisionState.index') }}" class="btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a> --}}
                                    <!-- <div class="col-md-2">
                                        <button type="submit" name="survey_confirm_by_divstate" value="send" class="btn btn-rounded btn-primary btn-block">{{ __('lang.send_headoffice') }}</button>
                                    </div> -->
                                    <div class="col-md-2">
                                        <button type="submit" name="survey_confirm_by_divstate" value="approve" class="btn btn-rounded btn-primary btn-block">{{ __('lang.send_dist_tsp') }}</button>
                                    </div>
                                    <div class="col-md-2">
                                        <a class="waves-effect waves-light btn btn-block btn-rounded btn-info text-white" data-toggle="modal" data-target="#mySurveyResendModal" data-backdrop="static" data-keyboard="false" data-id="{{ $data->id }}" data-type="3">{{ __('lang.send_tsp_error') }}</a>
                                        <!-- <button type="submit" name="survey_confirm_by_divstate" value="resend" class="btn btn-rounded btn-info btn-block">{{ __('lang.send_tsp_error') }}</button> -->
                                    </div>
                                    <div class="col-md-2">
                                        {{-- <button type="submit" name="survey_confirm_by_divstate" value="pending" class="btn btn-rounded btn-warning btn-block">{{ __('lang.send_pending') }}</button> --}}
                                        <a class="waves-effect waves-light btn btn-block btn-rounded btn-warning text-white" data-toggle="modal" data-target="#myPendingModal" data-backdrop="static" data-keyboard="false" data-id="{{ $data->id }}" data-type="3">{{ __('lang.send_pending') }}</a>
                                    </div>
                                    <div class="col-md-2">
                                        {{-- <button type="submit" name="survey_confirm_by_divstate" value="reject" class="btn btn-rounded btn-danger btn-block">{{ __('lang.send_reject') }}</button> --}}
                                        <a class="waves-effect waves-light btn btn-block btn-rounded btn-danger text-white" data-toggle="modal" data-target="#myRejectModal" data-backdrop="static" data-keyboard="false" data-id="{{ $data->id }}" data-type="3">{{ __('lang.send_reject') }}</a>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                                {{--  @endif  --}}
                            @endif
                        @endif
                        {{--  ----------------------------------------------------------------------------  --}}
                        {{--  --------------------------------- District ---------------------------------  --}}
                        @if (chk_userForm($data->id)['to_confirm_dist'])
                            @if (hasPermissions(['contractorDistrictChkGrd-create'])) {{--  if login-user is from township  --}}
                                {{-- @if(Auth::user()->hasRole('SeniorEngineer(Township)')) --}}
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('ခရိုင်အဆင့် စစ်ဆေးရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                            {!! Form::model($survey_result, ['route' => 'contractorMeterGroundCheckDoneListByDistrict.store', 'files' => true]) !!}
                            {!! Form::hidden('form_id', $data->id) !!}

                            <div class="row justify-content-center m-t-20">
                                @if(!$survey_result->loaded)
                                <div class="col-md-6 m-t-20">
                                    <div class="form-group">
                                        <label for="bq_cost_dist" class="text-info">
                                            {{ __('lang.bq_cost') }} ({{ __('lang.kyat') }}) {{ __('lang.bq_confirm') }}
                                        </label>
                                        <input type="number" name="bq_cost_dist" value="{{ $survey_result->bq_cost }}" class="form-control" id="bq_cost" min="0" />
                                    </div>
                                    <div class="form-group">
                                        <label for="bq_files" class="text-info">{{ __('lang.bq_cost') }} ({{ __('lang.attach_files') }})</label>
                                        <div class="bg-secondary p-20">
                                            <input type="file" name="bq_files[]" accept=".jpeg,.jpg,.png,.pdf" multiple/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="districtRemark" class="text-info">မှတ်ချက်  <span class="text-danger f-s-15">&#10039;</span></label>
                                        <textarea name="remark_dist" required class="form-control" placeholder="မှတ်ချက်ပေးရန်">{{$survey_result->remark_dist}}</textarea>
                                    </div>
                                    <div class="form-group container">
                                        <label for="dist_recomm" class="text-info">{{ __('သက်ဆိုင်ရာ ထောက်ခံချက်တွဲရန်') }}</label><br>
                                        <input type="file" name="dist_recomm" id="dist_recomm" accept=".jpg,.png,.pdf"/>
                                    </div>
                                </div>
                                @else
                                <div class="col-md-6 m-t-20">
                                    <div class="form-group">
                                        <label for="districtRemark" class="text-info">မှတ်ချက် <span class="text-danger f-s-15">&#10039;</span></label>
                                        <textarea name="remark_dist" required class="form-control" placeholder="မှတ်ချက်ပေးရန်">{{$survey_result->remark_dist}}</textarea>
                                    </div>
                                    <div class="form-group container">
                                        <label for="dist_recomm" class="text-info">{{ __('သက်ဆိုင်ရာ ထောက်ခံချက်တွဲရန်') }}</label><br>
                                        <input type="file" name="dist_recomm" id="dist_recomm" accept=".jpg,.png,.pdf"/>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-3">
                                        <button type="submit" name="survey_submit_district" value="send" class="btn btn-rounded btn-block btn-primary">{{ __('lang.send_div_state') }}</button>
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" name="survey_submit_district" value="resend" class="btn btn-rounded btn-block btn-info">{{ __('lang.send_tsp_error') }}</button>
                                        {{-- <a class="waves-effect waves-light btn btn-block btn-rounded btn-info text-white" data-toggle="modal" data-target="#mySurveyResendModal" data-backdrop="static" data-keyboard="false" data-id="{{ $data->id }}" data-type="2">{{ __('lang.send_tsp_error') }}</a> --}}

                                    </div>
                                    <div class="col-3">
                                        {{-- <button type="submit" name="survey_submit_district" value="pending" class="btn btn-rounded btn-block btn-warning">{{ __('lang.send_pending') }}</button> --}}
                                        <a class="waves-effect waves-light btn btn-block btn-rounded btn-warning text-white" data-toggle="modal" data-target="#myPendingModal" data-backdrop="static" data-keyboard="false" data-id="{{ $data->id }}" data-type="2">{{ __('lang.send_pending') }}</a>
                                    </div>
                                    <div class="col-3">
                                        {{-- <button type="submit" name="survey_submit_district" value="reject" class="btn btn-rounded btn-block btn-danger">{{ __('lang.send_reject') }}</button> --}}
                                        <a class="waves-effect waves-light btn btn-block btn-rounded btn-danger text-white" data-toggle="modal" data-target="#myRejectModal" data-backdrop="static" data-keyboard="false" data-id="{{ $data->id }}" data-type="2">{{ __('lang.send_reject') }}</a>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                                {{-- @endif --}}
                            @endif
                        @endif
                        {{--  ----------------------------------------------------------------------------  --}}
                        {{--  --------------------------------- Township ---------------------------------  --}}
                        @if (chk_userForm($data->id)['to_confirm_survey'])
                            @if (hasPermissions(['contractorTownshipChkGrd-create'])) {{--  if login-user is from township  --}}
                                {{-- @if(Auth::user()->hasRole('SeniorEngineer(Township)')) --}}
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('မြို့နယ်အဆင့် စစ်ဆေးရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                            {!! Form::open(['route' => 'contractorMeterGroundCheckDoneList.store', 'files' => true]) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <div class="row justify-content-center">
                                {{-- ============================== If No Loaded Power ============================== --}}
                                <div class="col-md-8">
                                    @php
                                        $chk_none = '';
                                        if ($survey_result->loaded) {
                                            $chk_none = 'd-none';
                                        }
                                    @endphp
                                    {{--  <div class="new_tsf {{ $chk_none }}">
                                        <div class="form-group row">
                                            <label for="new_tsf_name" class="control-label text-md-right col-md-4">
                                                {{ __('lang.new_tsf_name') }}
                                            </label>
                                            <div class="col-md-8">
                                                <p>{{ $survey_result->new_tsf_name }}</p>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="new_tsf_distance" class="control-label text-md-right col-md-4">
                                                {{ __('lang.new_tsf_distance') }} ({{ __('lang.feet') }})
                                            </label>
                                            <div class="col-md-8">
                                                <p>{{ checkMM() == 'mm' ? mmNum($survey_result->new_tsf_distance) : $survey_result->new_tsf_distance }} {{ __('lang.feet') }}</p>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="distance_04" class="control-label text-md-right col-md-4">
                                                {{ __('lang.distance_04') }} ({{ __('lang.feet') }})
                                            </label>
                                            <div class="col-md-8">
                                                <p>{{ checkMM() == 'mm' ? mmNum($survey_result->distance_04) : $survey_result->distance_04 }} {{ __('lang.feet') }}</p>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="new_tsf_info" class="control-label text-md-right col-md-4">
                                                {{ __('lang.new_tsf_info') }} {{ __('lang.volt') }}
                                            </label>
                                            <div class="col-md-8">
                                                <p>@if ($survey_result->new_tsf_info_volt == 1) {{ __('lang.11_0.4') }} @else {{ __('lang.33_0.4') }} @endif</p>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="new_tsf_info" class="control-label text-md-right col-md-4">
                                                {{ __('lang.new_tsf_info') }} {{ __('lang.kva') }}
                                            </label>
                                            <div class="col-md-8">
                                                <p>{{ checkMM() == 'mm' ? mmNum($survey_result->new_tsf_info_kv) : $survey_result->new_tsf_info_kv }} {{ __('lang.kva') }}</p>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="bq_cost" class="control-label text-md-right col-md-4">
                                                {{ __('lang.bq_cost') }} ({{ __('lang.request') }})
                                            </label>
                                            <div class="col-md-8">
                                                <p>{{ checkMM() == 'mm' ? mmNum(number_format($survey_result->bq_cost)) : number_format($survey_result->bq_cost) }} {{ __('lang.kyat') }}</p>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="bq_cost" class="control-label text-md-right col-md-4">
                                                {{ __('lang.bq_cost') }} ({{ __('lang.attach_files') }})
                                            </label>
                                            <div class="col-md-8">
                                                @if ($survey_result->bq_cost_files)
                                                    @php
                                                        $bq_foto = explode(',', $survey_result->bq_cost_files);
                                                    @endphp
                                                    <div class="row">
                                                        @foreach ($bq_foto as $foto)
                                                        <div class="col-md-3 text-center">
                                                            <img src="{{ asset('storagedata->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        @if ($data->apply_sub_type == 1)
                                        <div class="form-group row">
                                            <label for="budget_name" class="control-label text-md-right col-md-4">
                                                {{ __('lang.budget_name') }}
                                            </label>
                                            <div class="col-md-8">
                                                <p>{{ $survey_result->budget_name }}</p>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="form-group row">
                                            <label for="location" class="control-label text-md-right col-md-4">
                                                {{ 'Longitude' }}
                                            </label>
                                            <div class="col-md-8">
                                                <p>{{ $survey_result->longitude }}</p>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="location" class="control-label text-md-right col-md-4">
                                                {{ 'Latitude' }}
                                            </label>
                                            <div class="col-md-8">
                                                <p>{{ $survey_result->latitude }}</p>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="bq_cost" class="control-label text-md-right col-md-4">
                                                {{ __('lang.attach_file_location') }}
                                            </label>
                                            <div class="col-md-8">
                                                @if ($survey_result->location_files)
                                                    @php
                                                        $location_foto = explode(',', $survey_result->location_files);
                                                    @endphp
                                                    <div class="row">
                                                        @foreach ($location_foto as $foto)
                                                        <div class="col-md-3 text-center">
                                                            <img src="{{ asset('storagedata->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>  --}}
                                    @if (!$survey_result->loaded)
                                    <h4 class="text-center p-20">ထရန်စဖေါ်မာအသစ် တည်ဆောက်ရန်</h4>
                                    <div class="form-group">
                                        <label for="new_tsf_name" class="text-info">
                                            {{ __('lang.new_tsf_name') }}
                                        </label>
                                        <textarea name="new_tsf_name" class="form-control" id="new_tsf_name" rows="4">{{ $survey_result->new_tsf_name }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="new_tsf_distance" class="text-info">
                                                    {{ __('lang.new_tsf_distance') }} ({{ __('lang.feet') }})
                                                </label>
                                                <input type="number" value="{{$survey_result->new_tsf_distance}}" name="new_tsf_distance" class="form-control" id="new_tsf_distance" min="0" />
                                            </div>
                                            <div class="col-md-4">
                                                <label for="distance_04" class="text-info">
                                                    {{ __('lang.distance_04') }} ({{ __('lang.feet') }})
                                                </label>
                                                <input type="number" value="{{ $survey_result->distance_04 }}" name="distance_04" class="form-control" id="distance_04" min="0" />
                                            </div>  
                                            <div class="col-md-4">
                                                <label class="text-info">{{ __('lang.new_line_type') }} {{ __('lang.kv') }}</label><br/>
                                                <input type="radio" class="check" name="new_line_type" value="11" id="square-radio-1" data-radio="iradio_square-red" {{ $survey_result->new_line_type == 11 ? 'checked' : '' }}>
                                                <label for="square-radio-1">11 KV</label>
                                                <input type="radio" {{ $survey_result->new_line_type == 33 ? 'checked' : '' }} class="check" name="new_line_type" value="33" id="square-radio-1" data-radio="iradio_square-red">
                                                <label for="square-radio-1">33 KV</label>
                                                <input type="radio" {{ $survey_result->new_line_type == 66 ? 'checked' : '' }} class="check" name="new_line_type" value="66" id="square-radio-1" data-radio="iradio_square-red">
                                                <label for="square-radio-1">66 KV</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_tsf_info" class="text-info">
                                            {{ __('lang.new_tsf_info') }}
                                        </label>
                                        <div class="bg-secondary p-20">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="">(Transformer 1) {{ __('lang.volt') }}</label>
                                                    <select name="new_tsf_info_volt" class="form-control" id="new_tsf_info_volt">
                                                        <option value="11_0.4">{{ __('lang.11_0.4') }}</option>
                                                        <option value="33_0.4" {{ $survey_result->new_tsf_info_volt == "33_0.4" ? 'selected' : '' }}>{{ __('lang.33_0.4') }}</option>
                                                        <option value="66_0.4" {{ $survey_result->new_tsf_info_volt == "66_0.4" ? 'selected' : '' }}>{{ __('lang.66_0.4') }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">(Transformer 1) {{ __('lang.kva') }}</label>
                                                    <input type="number" value="{{ $survey_result->new_tsf_info_kv }}" name="new_tsf_info_kv" class="form-control" id="new_tsf_info_kv" min="0" />
                                                </div>
                                            </div>

                                            <div class="row m-t-10">
                                                <div class="col-md-6">
                                                    <label for="">(Transformer 2) {{ __('lang.volt') }}</label>
                                                    <select name="new_tsf_info_volt_two" class="form-control" id="new_tsf_info_volt_two">
                                                        <option value="11_0.4">{{ __('lang.11_0.4') }}</option>
                                                        <option value="33_0.4" {{ $survey_result->new_tsf_info_volt_two == "33_0.4" ? 'selected' : '' }}>{{ __('lang.33_0.4') }}</option>
                                                        <option value="66_0.4" {{ $survey_result->new_tsf_info_volt_two == "66_0.4" ? 'selected' : '' }}>{{ __('lang.66_0.4') }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">(Transformer 2) {{ __('lang.kva') }}</label>
                                                    <input type="number" value="{{ $survey_result->new_tsf_info_kv_two }}" name="new_tsf_info_kv_two" class="form-control" id="new_tsf_info_kv_two" min="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="text-info">{{ __('lang.bq_cost') }} ({{ __('lang.kyat') }})</label>
                                        <div class="bg-secondary p-20">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="">{{ __('lang.request') }}</label>
                                                    <input type="number" name="bq_cost" value="{{ $survey_result->bq_cost }}" class="form-control inner-form" id="bq_cost" min="0" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">{{ __('lang.attach_files') }}</label>
                                                    <input type="file" value="{{ $survey_result->bq_cost_files }}" name="bq_files[]" class="btn btn-info" id="bq_files" accept=".jpg,.png,.pdf" multiple="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($data->apply_sub_type == 1)
                                    <div class="form-group">
                                        <label for="budget_name" class="text-info">
                                            {{ __('lang.budget_name') }}
                                        </label>
                                        <input type="text" name="budget_name" value="{{ $survey_result->budget_name }}" class="form-control" id="budget_name" />
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="location" class="text-info">
                                            {{ __('lang.location') }}
                                        </label>
                                        <div class="bg-secondary p-20">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="">{{ 'Latitude' }}</label>
                                                    <input type="text" value="{{$survey_result->latitude}}" name="latitude" id="latitude" class="form-control" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">{{ 'Longitude' }}</label>
                                                    <input type="text" value="{{$survey_result->longitude}}" name="longitude" id="longitude" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="location" class="text-info">
                                            {{ __('lang.attach_file_location') }}
                                        </label>
                                        <div class="bg-secondary p-20">
                                            <input type="file" value="{{ $survey_result->location_files }}" name="location_files[]" class="d-block" id="location_files" accept=".jpg,.png,.pdf" multiple="" />
                                        </div>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="remark_tsp" class="text-info">
                                            {{ __('lang.remark') }} <span class="text-danger f-s-15">&#10039;</span>
                                        </label>
                                        <textarea required name="remark_tsp" class="form-control" id="remark_tsp" rows="4">{{ $survey_result->remark_tsp }}</textarea>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="tsp_recomm" class="text-info">{{ __('သက်ဆိုင်ရာ ထောက်ခံချက်တွဲရန်') }}</label><br>
                                        <input type="file" name="tsp_recomm" id="tsp_recomm" accept=".jpeg,.jpg,.png,.pdf"/>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <input type="submit" name="survey_submit_district" value="{{ __('lang.send_district') }}" class="btn btn-rounded btn-info">
                            </div>
                            {!! Form::close() !!}
                        </div>
                                {{-- @endif --}}
                            @endif
                        @endif
                    </div>
                </div
            </div>
        </div>
    </div>
</div>



<div class="modal" id="myPendingModal" tabindex="-1" role="dialog" aria-labelledby="pendingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title mt-3 mb-3 text-center" id="pendingModalLabel">{{ __("lang.pending_title") }}</h5>
                <hr/>
                <p class="mt-5 mb-5">{{ __("lang.pending_msg") }}</p>
                <div class="div_state_form d-none">
                    {!! Form::open(['route' => 'contractorMeterGroundCheckDoneListByDivisionState.store']) !!}
                    {!! Form::hidden('form_id', null, ['id' => 'p_form_id_divstate']) !!}
                    <div class="form-group">
                        <label for="pending_remark" class="text-info mt-3 mb-2">{{ __('lang.remark') }} :</label>
                        {!! Form::textarea('div_state_remark', null, ['class' => 'textarea_editor form-control', 'id' => 'pending_remark', 'required']) !!}
                    </div>
                    <div class="text-center">
                        <button type="button" class="waves-effect waves-light btn btn-rounded btn-secondary" data-dismiss="modal">{{ __('lang.cancel') }}</button>
                        <button type="submit" name="survey_confirm_by_divstate" value="pending" class="waves-effect waves-light btn btn-rounded btn-warning">{{ __('ပို့မည်') }}</button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="dist_form d-none">
                    {!! Form::open(['route' => 'contractorMeterGroundCheckDoneListByDistrict.store']) !!}
                    {!! Form::hidden('form_id', null, ['id' => 'p_form_id_dist']) !!}
                    <div class="form-group">
                        <label for="pending_remark" class="text-info mt-3 mb-2">{{ __('lang.remark') }} :</label>
                        {!! Form::textarea('dist_remark', null, ['class' => 'textarea_editor1 form-control', 'id' => 'pending_remark', 'required']) !!}
                    </div>
                    <div class="text-center">
                        <button type="button" class="waves-effect waves-light btn btn-rounded btn-secondary" data-dismiss="modal">{{ __('lang.cancel') }}</button>
                        <button type="submit" name="survey_submit_district" value="pending" class="waves-effect waves-light btn btn-rounded btn-warning">{{ __('ပို့မည်') }}</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="myRejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title mt-3 mb-3 text-center" id="rejectModalLabel">{{ __("lang.reject_title") }}</h5>
                <hr/>
                <p class="mt-5 mb-5">{{ __("lang.reject_msg") }}</p>
                <div class="div_state_form d-none">
                    {!! Form::open(['route' => 'contractorMeterGroundCheckDoneListByDivisionState.store']) !!}
                    {!! Form::hidden('form_id', null, ['id' => 'r_form_id_divstate']) !!}
                    <div class="form-group">
                        <label for="reject_remark" class="text-info mt-3 mb-2">{{ __('lang.remark') }} :</label>
                        <textarea name="div_state_remark" id="reject_remark" class="textarea_editor2 form-control" required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="button" class="waves-effect waves-light btn btn-rounded btn-secondary" data-dismiss="modal">{{ __('lang.cancel') }}</button>
                        <button type="submit" name="survey_confirm_by_divstate" value="reject" class="waves-effect waves-light btn btn-rounded btn-danger">{{ __('ပို့မည်') }}</button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="dist_form d-none">
                    {!! Form::open(['route' => 'contractorMeterGroundCheckDoneListByDistrict.store']) !!}
                    {!! Form::hidden('form_id', null, ['id' => 'r_form_id_dist']) !!}
                    <div class="form-group">
                        <label for="reject_remark" class="text-info mt-3 mb-2">{{ __('lang.remark') }} :</label>
                        <textarea name="dist_remark" id="reject_remark" class="textarea_editor3 form-control" required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="button" class="waves-effect waves-light btn btn-rounded btn-secondary" data-dismiss="modal">{{ __('lang.cancel') }}</button>
                        <button type="submit" name="survey_submit_district" value="reject" class="waves-effect waves-light btn btn-rounded btn-danger">{{ __('ပို့မည်') }}</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="mySurveyResendModal" tabindex="-1" role="dialog" aria-labelledby="resendModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title mt-3 mb-3 text-center" id="resendModalLabel">{{ __("ပြန်လည်စစ်ဆေးခြင်းသို့ ပို့်ရန်") }}</h5>
                <hr/>
                <p class="mt-5 mb-5">{{ __("ပြန်လည်စစ်ဆေးရန် သက်ဆိုင်ရာဌာနသို့ ပို့ပါမည်။") }}</p>
                <div class="div_state_form d-none">
                    {!! Form::open(['route' => 'contractorMeterGroundCheckDoneListByDivisionState.store']) !!}
                    {!! Form::hidden('form_id', null, ['id' => 're_form_id_divstate']) !!}
                    <div class="form-group">
                        <label for="resend_remark" class="text-info mt-3 mb-2">{{ __('lang.remark') }} :</label>
                        <textarea name="div_state_remark" id="resend_remark" class="textarea_editor5 form-control" required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="button" class="waves-effect waves-light btn btn-rounded btn-secondary" data-dismiss="modal">{{ __('lang.cancel') }}</button>
                        <button type="submit" name="survey_confirm_by_divstate" value="resend" class="waves-effect waves-light btn btn-rounded btn-info">{{ __('ပို့မည်') }}</button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="dist_form d-none">
                    {!! Form::open(['route' => 'contractorMeterGroundCheckDoneListByDistrict.store']) !!}
                    <!-- {!! Form::hidden('form_id', $data->id) !!} -->
                    {!! Form::hidden('form_id', null, ['id' => 're_form_id_dist']) !!}
                    <div class="form-group">
                        <label for="resend_remark" class="text-info mt-3 mb-2">{{ __('lang.remark') }} :</label>
                        <textarea name="dist_remark" id="resend_remark" class="textarea_editor6 form-control" required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="button" class="waves-effect waves-light btn btn-rounded btn-secondary" data-dismiss="modal">{{ __('lang.cancel') }}</button>
                        <button type="submit" name="survey_submit_district" value="resend" class="waves-effect waves-light btn btn-rounded btn-info">{{ __('ပို့မည်') }}</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
