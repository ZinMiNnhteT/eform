@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('contractorMeterGroundCheckList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
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
                                        
                                        @if ($data->div_state_id == 2)
                                        <div class="p-t-10 p-b-10">
                                            <h6>သို့</h6>
                                            <h6 class="p-l-30 p-t-10">မြို့နယ်လျှပ်စစ်မန်နေဂျာရုံး</h6>
                                            <h6 class="p-l-30 p-t-10">ရန်ကုန်လျှပ်စစ်ဓာတ်အားပေးရေးကော်ပိုရေးရှင်း</h6>
                                            <h6 class="p-l-30 p-t-10">{{ township_mm($data->township_id) }}</h6>
                                        </div>
                                        @elseif ($data->div_state_id == 3)
                                        <div class="p-t-10 p-b-10">
                                            <h6>သို့</h6>
                                            <h6 class="p-l-30 p-t-10">မြို့နယ်လျှပ်စစ်မန်နေဂျာရုံး</h6>
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

                    @if(hasSurvey($data->id))
                        @if (hasPermissions(['contractorGrdChk-create'])) {{--  if login-user is from township  --}}
                            {{--  @if (admin()->id == hasSurvey($data->id)->survey_engineer)  --}}
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0 text-info">{{ __('မြေပြင်စစ်ဆေးချက် ဖြည့်သွင်းရန်') }}</h5>
                            </div>
                            <div class="card-body">
                                <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5><br/>
                                {!! Form::open(['route' => 'contractorMeterGroundCheckList.store', 'files' => true]) !!}
                                {!! Form::hidden('form_id', $data->id) !!}
                                <div class="row justify-content-center m-t-20">
                                    <div class="col-md-8">
                                      
                                        {{--  Meter Type  --}}
                                        <div class="form-group">
                                            <label for="" class="text-info">
                                                {{__('lang.confirm_meter_list')}}
                                            </label>
                                            <div class="bg-secondary p-20">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <input type="hidden" name="room" id="roomCount" value="{{$c_form->room_count}}" />
                                                        <label for="">10/60 HHU</label>
                                                        <input type="number" name="meter_count" class="form-control" value="{{ $c_form->meter }}" min="0" id="surveyMeter" readonly/>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">10 KW</label>
                                                        <input type="number" name="pMeter10_count" value="{{ $c_form->pMeter10 }}" class="form-control" id="surveyPmeter10" min="0" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">20 KW</label>
                                                        <input type="number" name="pMeter20_count" value="{{ $c_form->pMeter20 }}" class="form-control" id="surveyPmeter20" min="0" />
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">30 KW</label>
                                                        <input type="number" name="pMeter30_count" value="{{ $c_form->pMeter30 }}" class="form-control" id="surveyPmeter30" min="0" />
                                                    </div>
                                                    <div class="col-md-6 m-t-20">
                                                        <label for="">Water Pump (10/60 HHU)</label>
                                                        <input type="number" name="water_meter_count" value="{{ $c_form->water_meter }}" class="form-control" min="0" />
                                                    </div>
                                                    <div class="col-md-6 m-t-20">
                                                        <label>Meter Type</label><br/>
                                                        <input type="radio" class="check" name="water_meter_type" value="1060" id="square-radio-1" data-radio="iradio_square-red" {{ $c_form->water_meter ? 'checked' : '' }}>
                                                        <label for="square-radio-1">10/60 HHU</label>
                                                        <input type="radio" class="check" name="water_meter_type" value="530" id="square-radio-2" data-radio="iradio_square-red">
                                                        <label for="square-radio-2">5/30 HHU</label>
                                                    </div>
                                                    <div class="col-md-6 m-t-20">
                                                        <label for="">Elevator</label>
                                                        <input type="number" name="elevator_meter_count" value="{{ $c_form->elevator_meter }}" class="form-control" min="0" />
                                                    </div>
                                                    <div class="col-md-6 m-t-20">
                                                        <label>Meter Type</label><br/>
                                                        <input type="radio" class="check" id="elevatorType-1" name="elevator_meter_type" value="10" data-radio="iradio_square-red" {{ $c_form->elevator_meter ? 'checked' : '' }}>
                                                        <label for="elevatorType-1">10-KW</label>
                                                        <input type="radio" class="check" id="elevatorType-2" name="elevator_meter_type" value="20" data-radio="iradio_square-red">
                                                        <label for="elevatorType-2">20-KW</label>
                                                        <input type="radio" class="check" id="elevatorType-3" name="elevator_meter_type" value="30" data-radio="iradio_square-red">
                                                        <label for="elevatorType-3">30-KW</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{--  ဓါတ်အားပေးနိုင်မည့် အကွာအဝေး  --}}
                                        <div class="form-group">
                                            <label class="text-info">{{ __('lang.tsf_transmit_distance') }}</label>
                                            <div class="bg-secondary p-20">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="">{{ __('lang.feet') }} (FT) <span class="text-danger f-s-15">&#10039;</span></label>
                                                        <input required type="number" name="tsf_transmit_distance_feet" class="form-control inner-form" id="tsf_transmit_distance" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="">{{ __('lang.kv') }} (KV) <span class="text-danger f-s-15">&#10039;</span></label>
                                                        <input required type="text" name="tsf_transmit_distance_kv" class="form-control" placeholder="{{ __('lang.kv_format') }}" id="tsf_transmit_distance" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--  ဓါတ်အားရယူမည့် ထရန်စဖေါ်မာ  --}}
                                        <div class="form-group">
                                            <label for="exist_transformer" class="text-info">{{ __('lang.exist_transformer') }} <span class="text-danger f-s-15">&#10039;</span></label>
                                            <textarea required name="exist_transformer" class="form-control" id="exist_transformer" rows="3"></textarea>
                                        </div>

                                        {{--  under 18 Rooms  --}}
                                        @if ($data->apply_division == 1)
                                            @if ($data->apply_sub_type == 1)
                                        <div class="form-group m-b-20">
                                            <label class="text-info">
                                                {{ __('lang.loaded_cdt') }}
                                            </label>
                                            <div class="bg-secondary p-20">
                                                <div class="row">
                                                    <div class="col-md-6 m-b-20">
                                                        <label for="">Amp / ရာခိုင်နှုန်း (%) ဖြင့်ဖေါ်ပြပေးရန် </label>
                                                        <input type="text" name="amp" class="form-control" placeholder="{{ __('lang.load_percent_format') }}"/>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="d-block">ဝန်အားနိုင်နင်းမှု ရွေးချယ်ပေးရန်</label>
                                                        <input type="radio" class="check" name="loaded" value="on" id="square-radio-1" data-radio="iradio_square-red" checked>
                                                        <label for="square-radio-1">နိုင်နင်းမှု ရှိသည်</label>
                                                        <input type="radio" class="check" name="loaded" value="off" id="square-radio-1" data-radio="iradio_square-red">
                                                        <label for="square-radio-1">နိုင်နင်းမှု မရှိပါ</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            @else
                                        <div class="form-group m-b-20">
                                            <label class="text-info">
                                                {{ __('lang.loaded_cdt') }}
                                            </label>
                                            <div class="bg-secondary p-20">
                                                <div class="row">
                                                    <div class="col-md-6 m-b-20">
                                                        <label for="">Amp / ရာခိုင်နှုန်း (%) ဖြင့်ဖေါ်ပြပေးရန် </label>
                                                        <input type="text" name="amp" class="form-control" placeholder="{{ __('lang.load_percent_format') }}" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="d-block">ဝန်အားနိုင်နင်းမှု ရွေးချယ်ပေးရန်</label>
                                                        <input type="radio" class="check" name="loaded" value="on" id="square-radio-1" data-radio="iradio_square-red">
                                                        <label for="square-radio-1">နိုင်နင်းမှု ရှိသည်</label>
                                                        <input type="radio" class="check" name="loaded" value="off" id="square-radio-1" data-radio="iradio_square-red">
                                                        <label for="square-radio-1">နိုင်နင်းမှု မရှိပါ</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            @endif
                                        @elseif ($data->apply_division == 2)
                                        <div class="form-group m-b-20">
                                            <label class="text-info">
                                                {{ __('lang.loaded_cdt') }}
                                            </label>
                                            <div class="bg-secondary p-20">
                                                <div class="row">
                                                    <div class="col-md-6 m-b-20">
                                                        <label for="">Amp / ရာခိုင်နှုန်း (%) ဖြင့်ဖေါ်ပြပေးရန် </label>
                                                        <input type="text" name="amp" class="form-control" placeholder="{{ __('lang.load_percent_format') }}" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="d-block">ဝန်အားနိုင်နင်းမှု ရွေးချယ်ပေးရန်</label>
                                                        <input type="radio" class="check" name="loaded" value="on" id="square-radio-1" data-radio="iradio_square-red" disabled>
                                                        <label for="square-radio-1">နိုင်နင်းမှု ရှိသည်</label>
                                                        <input type="radio" class="check" name="loaded" value="off" id="square-radio-1" data-radio="iradio_square-red" checked>
                                                        <label for="square-radio-1">နိုင်နင်းမှု မရှိပါ</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="form-group">
                                            <label for="remark" class="text-info">
                                                {{ __('lang.location_map_2') }}
                                            </label>
                                            <input type="file" name="location_map" accept=".jpg,.png,.pdf" class="form-control"/>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="remark" class="text-info">
                                                {{ __('lang.remark') }}
                                            </label>
                                                {!! Form::textarea('remark', null, ['id' => 'remark', 'class' => 'form-control', 'rows' => '3']) !!}
                                        </div>
                                                
                                    </div>
                                        {{-- ============================== If No Loaded Power ============================== --}}
                                </div>
                                <div class="text-center">
                                    <input type="submit" name="survey_request" value="{{ __('lang.submit') }}" class="btn btn-rounded btn-info">                    
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                            {{--  @endif  --}}
                        @endif
                    @else
                        @if (chk_userForm($data->id)['to_survey'])
                            @if (hasPermissions(['contractorGrdChk-create'])) {{--  if login-user is from township  --}}
                            <div class="card mb-1">
                                <div class="card-header d-flex" role="tab" id="headingOne">
                                    <h5 class="mb-0 text-info">{{ __('lang.choose_engineer') }}</h5>
                                </div>
                                <div class="card-body">
                                    <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                                    <br/>
                                    {!! Form::open(['route' => 'contractorMeterGroundCheckChoose.store','files' => true]) !!}
                                    {!! Form::hidden('form_id', $data->id) !!}
                                    <div class="row justify-content-center">
                                        <div class="col-md-8">
                                            <div class="form-group p-20">
                                                <label for="engineer_id" class="text-info">
                                                    {{ __('lang.eng_choose') }} <span class="text-danger f-s-15">&#10039;</span>
                                                </label>
                                                <select required name="engineer_id" id="engineer_name" class="form-control inner-form {{ checkMM() }}" required>
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
