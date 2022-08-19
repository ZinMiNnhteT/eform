@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex display-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{route('overall_process')}}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body card-body-pb-div">
                @if (chk_send($form->id) == 'first')
                <div class="alert alert-success alert-rounded">
                    <p class="text-success m-0"><i class="fa fa-check-circle fa-2x fa-fw"></i> {{ __('lang.applied_form_msg_1') }} <a href="{{ route('overall_process') }}">{{ __('lang.process_menu') }}</a> {{ __('lang.applied_form_msg_2') }}</p>
                </div>
                @else
                    @if (chk_form_finish($form->id, $form->apply_type)['state'])
                <div class="alert alert-danger alert-rounded">
                    <p class="text-danger m-0"><i class="fa fa-exclamation-circle fa-2x fa-fw"></i> {{ __('lang.unapplied_form_msg_1') }} <a href="#btn_send">{{ __('lang.send') }}</a> {{ __('lang.unapplied_form_msg_2') }}</p>
                </div>
                    @else
                <div class="alert alert-danger alert-rounded">
                    <p class="text-danger m-0"><i class="fa fa-exclamation-circle fa-2x fa-fw"></i> {{ __('lang.unfinish_form_msg') }}</p>                    
                </div>
                    @endif
                @endif

                @include('layouts.form-progressbar')
                
                {{--  @if ($form->apply_type == 5 && $form->apply_sub_type == 1)  --}}
                <div class="container-fluid">
                    <div id="app_show" class="accordion" role="tablist" aria-multiselectable="true">
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#info" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.user_info') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if ($form->serial_code)
                                <div class="ml-auto">
                                    <a href="{{ route('417_edit_user_info_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('417_edit_user_info_ygn', $form->id) }}" class="btn-edit text-info">{{ __('lang.create') }}</a>
                                </div>
                                    @endif
                                @endif
                            </div>
                            <div id="info" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="card-body mm">
                                        <h5 class="text-center"><b>ကန်ထရိုက်တိုက်မီတာ လျှောက်လွှာပုံစံ</b></h5>
                                        <h6 class="text-right">အမှတ်စဥ် - <b>{{ $form->serial_code }}</b></h6>
                                        @if ($form->div_state_id == 2)
                                        <div class="p-t-10 p-b-10">
                                            <h6>သို့</h6>
                                            <h6 class="p-l-30 p-t-10">မြို့နယ်လျှပ်စစ်မန်နေဂျာ</h6>
                                            <h6 class="p-l-30 p-t-10">ရန်ကုန်လျှပ်စစ်ဓာတ်အားပေးရေးကော်ပိုရေးရှင်း</h6>
                                            <h6 class="p-l-30 p-t-10">{{ township_mm($form->township_id) }}</h6>
                                        </div>
                                        @elseif ($form->div_state_id == 3)
                                        <div class="p-t-10 p-b-10">
                                            <h6>သို့</h6>
                                            <h6 class="p-l-30 p-t-10">မြို့နယ်လျှပ်စစ်မန်နေဂျာ</h6>
                                            <h6 class="p-l-30 p-t-10">မန္တလေးလျှပ်စစ်ဓာတ်အားပေးရေးကော်ပိုရေးရှင်း</h6>
                                            <h6 class="p-l-30 p-t-10">{{ township_mm($form->township_id) }}</h6>
                                        </div>
                                        @else
                                        <div class="p-t-10 p-b-10">
                                            <h6>သို့</h6>
                                            <h6 class="p-l-30 p-t-10">မြို့နယ်လျှပ်စစ်မှူး/မြို့နယ်လျှပ်စစ်အင်ဂျင်နီယာ</h6>
                                            <h6 class="p-l-30 p-t-10">လျှပ်စစ်ဓာတ်အားဖြန့်ဖြူးရေးလုပ်ငန်း</h6>
                                            <h6 class="p-l-30 p-t-10">{{ township_mm($form->township_id) }}</h6>
                                        </div>
                                        @endif
                                        <div class="text-right p-t-10">
                                            <h6>ရက်စွဲ။<span class="p-l-20">။</span> {{ mmNum(date('d-m-Y', strtotime($form->date))) }}</h6>
                                        </div>
                                        <div class="p-t-10">
                                            <h6>အကြောင်းအရာ။<span class="p-l-40">။</span> <b>ကန်ထရိုက်တိုက်မီတာ တပ်ဆင်ခွင့်ပြုပါရန် လျှောက်ထားခြင်း။</b></h6>
                                        </div>
                                        <div class="p-t-10">
                                            <h6 class="l-h-35">
                                                <span class="p-l-40"></span><span class="p-l-40"></span>
                                                အထက်ပါကိစ္စနှင့်ပတ်သက်၍ {{ address_mm($form->id) }}တွင် <b>{{ contrator_meter_count($form->id) }}</b> တပ်ဆင်သုံးစွဲခွင့်ပြုပါရန် လျှောက်ထားအပ်ပါသည်။
                                            </h6>
                                            <h6 class="l-h-35">
                                                <span class="p-l-40"></span><span class="p-l-40"></span> တပ်ဆင်သုံးစွဲခွင့်ပြုပါက လျှပ်စစ်ဓာတ်အားဖြန့်ဖြူးရေးလုပ်ငန်းမှ သတ်မှတ်ထားသော အခွန်အခများကို အကြေပေးဆောင်မည့်အပြင် တည်ဆဲဥပဒေများအတိုင်း လိုက်နာဆောင်ရွက်မည်ဖြစ်ပါကြောင်းနှင့် အိမ်တွင်းဝါယာသွယ်တန်းခြင်းလုပ်ငန်းများကို လျှပ်စစ်ကျွမ်းကျင်လက်မှတ်ရှိသူများနှင့်သာ ဆောင်ရွက်မည်ဖြစ်ကြောင်း ဝန်ခံကတိပြုလျှောက်ထားအပ်ပါသည်။
                                            </h6>
                                        </div>
                                        <div class="row justify-content-start m-t-30">
                                            <div class="col-md-4">
                                                <h6 class="l-h-35"><b>တပ်ဆင်သုံးစွဲလိုသည့် လိပ်စာ</b></h6>
                                                <h6 class="l-h-35">
                                                    {{ address_mm($form->id) }}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="row justify-content-around m-t-30">
                                            <div class="col-md-6 offset-md-6">
                                                <h6><b>လေးစားစွာဖြင့်</b></h6>
                                                <h6 style="padding-left: 90px; line-height: 35px;">
                                                    <p class="mb-0">{{ $form->fullname }}</p>
                                                    <p class="mb-0">{{ $form->nrc }}</p>
                                                    <p class="mb-0">{{ $form->applied_phone }}</p>
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
                                    <a data-toggle="collapse" data-parent="#app_show" href="#meter" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.room_count_meter_type') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                <div class="ml-auto">
                                    <a href="{{ route('contract_building_room_edit_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                @endif
                            </div>
                            <div id="meter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="card-body mm row">
                                        <div class="col-md-6">
                                            <table class="table no-border">
                                                <tr>
                                                    <td>{{ __('lang.room_count')}}</td>
                                                    <td>
                                                        {{ mmNum($c_form->room_count) }} {{ __('ခန်း') }}
                                                        @if ($c_form->apartment_count && $c_form->floor_count)
                                                            ( {{ mmNum($c_form->apartment_count) }} {{ __('ခန်းတွဲ') }} x
                                                            {{ mmNum($c_form->floor_count) }} {{ __('ထပ်') }} )
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if ($c_form->meter)
                                                <tr>
                                                    <td>{{ __('lang.residential_meter')}}</td>
                                                    <td>{{ mmNum($c_form->meter) }} {{ __('လုံး') }}</td>
                                                </tr>
                                                @endif
                                                @if($c_form->pMeter10 || $c_form->pMeter20 || $c_form->pMeter30)
                                                <tr>
                                                    <td>{{ __('lang.power_meter')}}</td>
                                                </tr>
                                                @endif
                                                @if($c_form->pMeter10)
                                                <tr>
                                                    <td>{!! space(8) !!}{{ __('10 KW')}}</td>
                                                    <td>{!! space(8) !!}{{ mmNum($c_form->pMeter10)}} {{ __('လုံး') }}</td>
                                                </tr>
                                                @endif
                                                @if($c_form->pMeter20)
                                                <tr>
                                                    <td>{!! space(8) !!}{{ __('20 KW')}}</td>
                                                    <td>{!! space(8) !!}{{ mmNum($c_form->pMeter20)}} {{ __('လုံး') }}</td>
                                                </tr>
                                                @endif
                                                @if($c_form->pMeter30)
                                                <tr>
                                                    <td>{!! space(8) !!}{{ __('30 KW')}}</td>
                                                    <td>{!! space(8) !!}{{ mmNum($c_form->pMeter30)}} {{ __('လုံး') }}</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td>{{ __('ရေစက်မီတာ')}}</td>
                                                    <td>
                                                        @if($c_form->water_meter)
                                                        {{ __('ပါသည်')}}
                                                        @else
                                                        {{ __('မပါပါ')}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('ဓါတ်လှေကားမီတာ')}}</td>
                                                    <td>
                                                        @if($c_form->elevator_meter)
                                                        {{ __('ပါသည်')}}
                                                        @else
                                                        {{ __('မပါပါ')}}
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Nrc --}}
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#nrc" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.nrc') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if (chk_form_finish($form->id, $form->apply_type)['nrc'])
                                <div class="ml-auto">
                                    <a href="{{ route('417_nrc_edit_ygn', $form->id) }}" class="btn-edit text-info">{{ __('lang.create') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('417_nrc_edit_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                    @endif
                                @endif
                            </div>
                            <div id="nrc" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @if ($files->count() > 0)
                                    @foreach ($files as $file)
                                        @if ($file->nrc_copy_front)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->nrc_copy_front) }}" alt="{{ __('lang.nrc_front') }}" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
                                        <p class="m-t-10 m-b-10">{{ __('lang.nrc_front') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->nrc_copy_back) }}" alt="{{ __('lang.nrc_back') }}" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
                                        <p class="m-t-10 m-b-10">{{ __('lang.nrc_back') }}</p>
                                    </div>
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

                        {{-- From 10 --}}
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#form10" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.form10') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if (chk_form_finish($form->id, $form->apply_type)['form10'])
                                <div class="ml-auto">
                                    <a href="{{ route('417_form10_edit_ygn', $form->id) }}" class="btn-edit text-info">{{ __('lang.create') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('417_form10_edit_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                    @endif
                                @endif
                            </div>
                            <div id="form10" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @if ($files->count() > 0)
                                    @foreach ($files as $file)
                                        @if ($file->form_10_front)
                                            <div class="row text-center mt-2">
                                                @php
                                                    $fronts = explode(',', $file->form_10_front);
                                                    $i = 1;
                                                @endphp
                                                
                                                <div class="col-md-6 text-center">
                                                    @foreach ($fronts as $foto)
                                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$foto) }}" alt="{{ __('lang.form10_front') }} ({{ checkMM()=='mm'?mmNum($i):$i }})" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
                                                            <p class=" m-t-10 m-b-10">{{ __('lang.form10_front') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                                                        
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach
                                                </div>
                            
                                                @if ($file->form_10_back)
                                                    @php
                                                        $fronts = explode(',', $file->form_10_back);
                                                        $i = 1;
                                                    @endphp
                                                    <div class="col-md-6 text-center">
                                                    @foreach ($fronts as $foto)
                                                        <img src="{{ asset      ('storage/user_attachments/'.$form->id.'/'.$foto) }}" alt="{{ __('lang.form10_back') }} ({{ checkMM()=='mm'?mmNum($i):$i }})" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
                                                        <p class=" m-t-10 m-b-10">{{ __('lang.form10_back') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach
                                                </div>
                                                @endif  
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

                        {{-- recomm --}}
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#recommanded_letter" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.recomm') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if (chk_form_finish($form->id, $form->apply_type)['occupy'])
                                <div class="ml-auto">
                                    <a href="{{ route('417_recomm_edit_ygn', $form->id) }}" class="btn-edit text-info">{{ __('lang.create') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('417_recomm_edit_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                    @endif
                                @endif
                            </div>
                            <div id="recommanded_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @if ($files->count() > 0)
                                    @foreach ($files as $file)
                                        @if ($file->occupy_letter)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->occupy_letter) }}" alt="{{ __('lang.occupy_letter') }}" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
                                        <p class="m-t-10 m-b-10">{{ __('lang.occupy_letter') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->no_invade_letter) }}" alt="{{ __('lang.noinvade_letter') }}" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
                                        <p class="m-t-10 m-b-10">{{ __('lang.noinvade_letter') }}</p>
                                    </div>
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

                        {{-- ownership --}}
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#owner_letter" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.owner') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if (chk_form_finish($form->id, $form->apply_type)['ownership'])
                                <div class="ml-auto">
                                    <a href="{{ route('417_owner_edit_ygn', $form->id) }}" class="btn-edit text-info">{{ __('lang.create') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('417_owner_edit_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                    @endif
                                @endif
                            </div>
                            <div id="owner_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @if ($files->count() > 0)
                                    @foreach ($files as $file)
                                        @if ($file->ownership)
                                <div class="row text-center mt-2">
                                    @php
                                        $owner_foto = explode(',', $file->ownership);
                                        $i = 1;
                                    @endphp
                                            @foreach ($owner_foto as $foto)
                                    <div class="col-md-6 text-center">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$foto) }}" alt="{{ __('lang.owner_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
                                        <p class="m-t-10 m-b-10">{{ __('lang.owner_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                                    </div>
                                    @php $i++; @endphp
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

                        {{-- permit ဆောက်လုပ်ခွင့်ပုံ--}}
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#permit_letter" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.permit') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if (chk_form_finish($form->id, $form->apply_type)['permit'])
                                <div class="ml-auto">
                                    <a href="{{ route('417_permit_edit_ygn', $form->id) }}" class="btn-edit text-info">{{ __('lang.create') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('417_permit_edit_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                    @endif
                                @endif
                            </div>
                            <div id="permit_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @if ($files->count() > 0)
                                    @foreach ($files as $file)
                                        @if ($file->building_permit)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->building_permit) }}" alt="{{ __('lang.applied_permit_photo') }}" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
                                        <p class="m-t-10 m-b-10">{{ __('lang.applied_permit_photo') }}</p>
                                    </div>
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

                        {{-- bcc လူနေထိုင်ခွင့် --}}
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#bcc_letter" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.bcc') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if (chk_form_finish($form->id, $form->apply_type)['bcc'])
                                <div class="ml-auto">
                                    <a href="{{ route('417_bcc_edit_ygn', $form->id) }}" class="btn-edit text-info">{{ __('lang.create') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('417_bcc_edit_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                    @endif
                                @endif
                            </div>
                            <div id="bcc_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @if ($files->count() > 0)
                                    @foreach ($files as $file)
                                        @if ($file->bcc)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->bcc) }}" alt="{{ __('lang.applied_bcc_photo') }}" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
                                        <p class="m-t-10 m-b-10">{{ __('lang.applied_bcc_photo') }}</p>
                                    </div>
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

                        {{-- dc_recomm စည်ပင်ထောက်ခံစာ --}}
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#dc_recomm_letter" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.dc_recomm') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if (chk_form_finish($form->id, $form->apply_type)['dc'])
                                <div class="ml-auto">
                                    <a href="{{ route('417_dc_recomm_edit_ygn', $form->id) }}" class="btn-edit text-info">{{ __('lang.create') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('417_dc_recomm_edit_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                    @endif
                                @endif
                            </div>
                            <div id="dc_recomm_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @if ($files->count() > 0)
                                    @foreach ($files as $file)
                                        @if ($file->dc_recomm)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->dc_recomm) }}" alt="{{ __('lang.applied_dc_recomm_photo') }}" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
                                        <p class="m-t-10 m-b-10">{{ __('lang.applied_dc_recomm_photo') }}</p>
                                    </div>
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

                        {{-- prev bill --}}
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#prev_bill_letter" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.prev_bill') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if (chk_form_finish($form->id, $form->apply_type)['bill'])
                                <div class="ml-auto">
                                    <a href="{{ route('417_bill_edit_ygn', $form->id) }}" class="btn-edit text-info">{{ __('lang.create') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('417_bill_edit_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                    @endif
                                @endif
                            </div>
                            <div id="prev_bill_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @if ($files->count() > 0)
                                    @foreach ($files as $file)
                                        @if ($file->prev_bill)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->prev_bill) }}" alt="{{ __('lang.applied_bill_photo') }}" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
                                        <p class="m-t-10 m-b-10">{{ __('lang.applied_bill_photo') }}</p>
                                    </div>
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

                        {{-- လယ်ယာပိုင်မြေအားအခြားနည်းဖြင့်သုံးဆွဲရန်ခွင့်ပြုချက် --}}
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0 ">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#farmland" aria-expanded="true" aria-controls="collapseOne">
                                    {{ __('lang.farmland_permit') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if (chk_form_finish($form->id, $form->apply_type)['farmland'])
                                <div class="ml-auto">
                                    <a href="{{ route('contractor_farmland_edit_ygn', $form->id) }}" class="btn-edit text-info ">{{ __('lang.create') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('contractor_farmland_edit_ygn', $form->id) }}" class="btn-edit text-danger ">{{ __('lang.edit') }}</a>
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
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$foto) }}" alt="{{ __('lang.permit') }} ({{ checkMM()=='mm'?mmNum($i):$i }})" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
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
                                @if (chk_send($form->id) !== 'first')
                                    @if (chk_form_finish($form->id, $form->apply_type)['building'])
                                <div class="ml-auto">
                                    <a href="{{ route('contractor_building_photo_edit_ygn', $form->id) }}" class="btn-edit text-info ">{{ __('lang.create') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('contractor_building_photo_edit_ygn', $form->id) }}" class="btn-edit text-danger ">{{ __('lang.edit') }}</a>
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
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$foto) }}" alt="{{ __('lang.building_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
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

                        {{-- တိုက်ပုံစံတိုက်ပုံစံဓါတ်ပုံ --}}
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0 ">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#bq" aria-expanded="true" aria-controls="collapseOne">
                                    {{ __('lang.bq_photo') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if (chk_form_finish($form->id, $form->apply_type)['bq'])
                                <div class="ml-auto">
                                    <a href="{{ route('contractor_BQ_photo_edit_ygn', $form->id) }}" class="btn-edit text-info ">{{ __('lang.create') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('contractor_BQ_photo_edit_ygn', $form->id) }}" class="btn-edit text-danger ">{{ __('lang.edit') }}</a>
                                </div>
                                    @endif
                                @endif
                            </div>
                            <div id="bq" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @if ($files->count() > 0)
                                    @foreach ($files as $file)
                                        @if ($file->bq)
                                <div class="row text-center mt-2">
                                    @php
                                        $bq_foto = explode(',', $file->bq);
                                        $i = 1;
                                    @endphp
                                            @foreach ($bq_foto as $foto)
                                    <div class="col-md-6 text-center">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$foto) }}" alt="{{ __('lang.bq_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
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

                        {{-- အဆောက်အဦးပုံဓါတ်ပုံ --}}
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0 ">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#drawing" aria-expanded="true" aria-controls="collapseOne">
                                    {{ __('lang.drawing_photo') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if (chk_form_finish($form->id, $form->apply_type)['drawing'])
                                <div class="ml-auto">
                                    <a href="{{ route('contractor_Drawing_photo_edit_ygn', $form->id) }}" class="btn-edit text-info ">{{ __('lang.create') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('contractor_Drawing_photo_edit_ygn', $form->id) }}" class="btn-edit text-danger ">{{ __('lang.edit') }}</a>
                                </div>
                                    @endif
                                @endif
                            </div>
                            <div id="drawing" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @if ($files->count() > 0)
                                    @foreach ($files as $file)
                                        @if ($file->drawing)
                                <div class="row text-center mt-2">
                                    @php
                                        $drawing_foto = explode(',', $file->drawing);
                                        $i = 1;
                                    @endphp
                                            @foreach ($drawing_foto as $foto)
                                    <div class="col-md-6 text-center">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$foto) }}" alt="{{ __('lang.drawing_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
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

                        {{-- တည်နေရာဓါတ်ပုံ --}}
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0 ">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#map" aria-expanded="true" aria-controls="collapseOne">
                                    {{ __('lang.map_photo') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if (chk_form_finish($form->id, $form->apply_type)['map'])
                                <div class="ml-auto">
                                    <a href="{{ route('contractor_Map_photo_edit_ygn', $form->id) }}" class="btn-edit text-info ">{{ __('lang.create') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('contractor_Map_photo_edit_ygn', $form->id) }}" class="btn-edit text-danger ">{{ __('lang.edit') }}</a>
                                </div>
                                    @endif
                                @endif
                            </div>
                            <div id="map" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @if ($files->count() > 0)
                                    @foreach ($files as $file)
                                        @if ($file->map)
                                <div class="row text-center mt-2">
                                    @php
                                        $map_foto = explode(',', $file->map);
                                        $i = 1;
                                    @endphp
                                            @foreach ($map_foto as $foto)
                                    <div class="col-md-6 text-center">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$foto) }}" alt="{{ __('lang.map_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
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

                        {{-- Sign Photo --}}
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0 ">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#sign" aria-expanded="true" aria-controls="collapseOne">
                                    {{ __('lang.sign_photo') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if (chk_form_finish($form->id, $form->apply_type)['sign'])
                                <div class="ml-auto">
                                    <a href="{{ route('contractor_sign_edit_ygn', $form->id) }}" class="btn-edit text-info ">{{ __('lang.create') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('contractor_sign_edit_ygn', $form->id) }}" class="btn-edit text-danger ">{{ __('lang.edit') }}</a>
                                </div>
                                    @endif
                                @endif
                            </div>
                            <div id="sign" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @if ($files->count() > 0)
                                    @foreach ($files as $file)
                                        @if ($file->sign)
                                <div class="row text-center mt-2">
                                    @php
                                        $sign_foto = explode(',', $file->sign);
                                        $i = 1;
                                    @endphp
                                            @foreach ($sign_foto as $foto)
                                    <div class="col-md-6 text-center">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$foto) }}" alt="{{ __('lang.map_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
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
                    </div>
                </div>



                {{--  @endif  --}}

                {{--  @if ($form->apply_type == 5 && $form->apply_sub_type == 2)
                <div class="container-fluid">
                    <div id="app_show" class="accordion" role="tablist" aria-multiselectable="true">
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#info" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.user_info') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                <div class="ml-auto">
                                    <a href="{{ route('417_edit_user_info_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                @endif
                            </div>
                            <div id="info" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="card-body mm">
                                        <h5 class="text-center"><b>ကန်ထရိုက်တိုက် အိမ်သုံးမီတာ လျှောက်လွှာပုံစံ</b></h5>
                                        <h6 class="text-right">အမှတ်စဥ် - <b>{{ $form->serial_code }}</b></h6>
                                        <div class="p-t-10 p-b-10">
                                            <h6>သို့</h6>
                                            <h6 class="p-l-30 p-t-10">မြို့နယ်လျှပ်စစ်မှူး/မြို့နယ်လျှပ်စစ်အင်ဂျင်နီယာ</h6>
                                            <h6 class="p-l-30 p-t-10">လျှပ်စစ်ဓာတ်အားဖြန့်ဖြူးရေးလုပ်ငန်း</h6>
                                            <h6 class="p-l-30 p-t-10">{{ township_mm($form->township_id) }}</h6>
                                        </div>
                                        <div class="text-right p-t-10">
                                            <h6>ရက်စွဲ။<span class="p-l-20">။</span> {{ mmNum(date('d-m-Y', strtotime($form->date))) }}</h6>
                                        </div>
                                        <div class="p-t-10">
                                            <h6>အကြောင်းအရာ။<span class="p-l-40">။</span> <b>ကန်ထရိုက်တိုက် အိမ်သုံးမီတာ တပ်ဆင်ခွင့်ပြုပါရန် လျှောက်ထားခြင်း။</b></h6>
                                        </div>
                                        <div class="p-t-10">
                                            <h6 class="l-h-35">
                                                <span class="p-l-40"></span><span class="p-l-40"></span>
                                                အထက်ပါကိစ္စနှင့်ပတ်သက်၍ {{ address_mm($form->id) }}တွင် <b>{{ 'ကန်ထရိုက်တိုက်' }}</b> အတွက် <b>{{ contrator_meter_count($form->id) }}</b> တပ်ဆင်သုံးစွဲခွင့်ပြုပါရန် လျှောက်ထားအပ်ပါသည်။
                                            </h6>
                                            <h6 class="l-h-35">
                                                <span class="p-l-40"></span><span class="p-l-40"></span> တပ်ဆင်သုံးစွဲခွင့်ပြုပါက လျှပ်စစ်ဓာတ်အားဖြန့်ဖြူးရေးလုပ်ငန်းမှ သတ်မှတ်ထားသော အခွန်အခများကို အကြေပေးဆောင်မည့်အပြင် တည်ဆဲဥပဒေများအတိုင်း လိုက်နာဆောင်ရွက်မည်ဖြစ်ပါကြောင်းနှင့် အိမ်တွင်းဝါယာသွယ်တန်းခြင်းလုပ်ငန်းများကို လျှပ်စစ်ကျွမ်းကျင်လက်မှတ်ရှိသူများနှင့်သာ ဆောင်ရွက်မည်ဖြစ်ကြောင်း ဝန်ခံကတိပြုလျှောက်ထားအပ်ပါသည်။
                                            </h6>
                                        </div>
                                        <div class="row justify-content-start m-t-30">
                                            <div class="col-md-4">
                                                <h6 class="l-h-35"><b>တပ်ဆင်သုံးစွဲလိုသည့် လိပ်စာ</b></h6>
                                                <h6 class="l-h-35">
                                                    {{ address_mm($form->id) }}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="row justify-content-around m-t-30">
                                            <div class="col-md-6 offset-md-6">
                                                <h6><b>လေးစားစွာဖြင့်</b></h6>
                                                <h6 style="padding-left: 90px; line-height: 35px;">
                                                    <p class="mb-0">{{ $form->fullname }}</p>
                                                    <p class="mb-0">{{ $form->nrc }}</p>
                                                    <p class="mb-0">{{ $form->applied_phone }}</p>
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
                                    <a data-toggle="collapse" data-parent="#app_show" href="#meter" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.room_count_meter_type') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                <div class="ml-auto">
                                    <a href="{{ route('contract_building_room_edit_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                @endif
                            </div>
                            <div id="meter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="card-body mm row">
                                        <div class="col-md-6">
                                            <table class="table no-border">
                                                <tr>
                                                    <td colspan="2">{{ __('lang.room_count') }}</td>
                                                    <td>{{ mmNum($c_form->room_count) }} @if ($c_form->room_count != 0) {{ __('ခန်း') }} @endif</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">{{ __('lang.residential_meter') }}</td>
                                                    <td>{{ mmNum($c_form->meter) }} @if ($c_form->meter != 0) {{ __('ခန်း') }} @endif</td>
                                                </tr>
                                                @if($c_form->pMeter10 || $c_form->pMeter20 || $c_form->pMeter30)
                                                <tr>
                                                    <td colspan="3">{{ __('lang.power_meter') }}</td>
                                                </tr>
                                                @endif
                                                @if($c_form->pMeter10)
                                                <tr>
                                                    <td>{{ __('10 KW') }}</td>
                                                    <td>{{ mmNum($c_form->pMeter10) }} {{ __('ခန်း') }}</td>
                                                </tr>
                                                @endif
                                                @if($c_form->pMeter20)
                                                <tr>
                                                    <td>{{ __('20 KW') }}</td>
                                                    <td>{{ mmNum($c_form->pMeter20) }} {{ __('ခန်း') }}</td>
                                                </tr>
                                                @endif
                                                @if($c_form->pMeter30)
                                                <tr>
                                                    <td>{{ __('30 KW') }}</td>
                                                    <td>{{ mmNum($c_form->pMeter30) }} {{ __('ခန်း') }}</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="2">{{ __('ရေစက်မီတာ') }}</td>
                                                    <td>
                                                        @if($c_form->water_meter)
                                                        {{ __('ပါသည်')}}
                                                        @else
                                                        {{ __('မပါပါ')}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">{{ __('ဓါတ်လှေကားမီတာ')}}</td>
                                                    <td>
                                                        @if($c_form->elevator_meter)
                                                        {{ __('ပါသည်')}}
                                                        @else
                                                        {{ __('မပါပါ')}}
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#nrc" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.nrc') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                <div class="ml-auto">
                                    <a href="{{ route('417_nrc_edit_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                @endif
                            </div>
                            <div id="nrc" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->nrc_copy_front) }}" alt="{{ $file->nrc_copy_front }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.nrc_front') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->nrc_copy_back) }}" alt="{{ $file->nrc_copy_back }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.nrc_back') }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#form10" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.form10') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                <div class="ml-auto">
                                    <a href="{{ route('417_form10_edit_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                @endif
                            </div>
                            <div id="form10" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->form_10_front) }}" alt="{{ $file->form_10_front }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.form10_front') }}</p>
                                    </div>
                                    @if ($file->form_10_back)
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->form_10_back) }}" alt="{{ $file->form_10_back }}" class="img-thumbnail" width="150" height="150">
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
                                    <a data-toggle="collapse" data-parent="#app_show" href="#recommanded_letter" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.recomm') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                <div class="ml-auto">
                                    <a href="{{ route('417_recomm_edit_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                @endif
                            </div>
                            <div id="recommanded_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->occupy_letter) }}" alt="{{ $file->occupy_letter }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.occupy_letter') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->no_invade_letter) }}" alt="{{ $file->noinvade_letter }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.noinvade_letter') }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#owner_letter" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.owner') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                <div class="ml-auto">
                                    <a href="{{ route('417_owner_edit_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                @endif
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
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.owner_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
                                    </div>
                                    @php $i++; @endphp
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
                                @if (chk_send($form->id) !== 'first')
                                <div class="ml-auto">
                                    <a href="{{ route('417_permit_edit_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                @endif
                            </div>
                            <div id="permit_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->building_permit) }}" alt="{{ $file->building_permit }}" class="img-thumbnail" width="150" height="150">
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
                                @if (chk_send($form->id) !== 'first')
                                <div class="ml-auto">
                                    <a href="{{ route('417_bcc_edit_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                @endif
                            </div>
                            <div id="bcc_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->bcc) }}" alt="{{ $file->bcc }}" class="img-thumbnail" width="150" height="150">
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
                                @if (chk_send($form->id) !== 'first')
                                <div class="ml-auto">
                                    <a href="{{ route('417_dc_recomm_edit_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                @endif
                            </div>
                            <div id="dc_recomm_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->dc_recomm) }}" alt="{{ $file->dc_recomm }}" class="img-thumbnail" width="150" height="150">
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
                                @if (chk_send($form->id) !== 'first')
                                <div class="ml-auto">
                                    <a href="{{ route('417_bill_edit_ygn', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                @endif
                            </div>
                            <div id="prev_bill_letter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @foreach ($files as $file)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->prev_bill) }}" alt="{{ $file->prev_bill }}" class="img-thumbnail" width="150" height="150">
                                        <p class="m-t-10 m-b-10">{{ __('lang.applied_bill_photo') }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif  --}}

                @if (chk_form_finish($form->id, $form->apply_type)['state'])
                    @if (chk_send($form->id) !== 'first' && $form->serial_code)
                <div class="m-t-30 m-b-10 row justify-content-center">
                    <div class="col-6" id="btn_send">
                        <button class="btn btn-block btn-lg btn-success" data-toggle="modal" data-target="#sendForm" data-backdrop="static" data-keyboard="false">{{ __('lang.send') }}</button>
                    </div>
                </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal" id="sendForm" tabindex="-1" role="dialog" aria-labelledby="myLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5 class="modal-title title-msg-reject mt-4 mb-5" id="myLabel">{{ __("lang.send_form_confirm") }}</h5>
                {!! Form::open(['route' => 'resident_user_send_form']) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('lang.cancel') }}</button>
                <input type="submit" name="user_send" id="send" value="{{ __('lang.send') }}" class="btn btn-success">
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div class="modal" id="myImg" tabindex="-1" role="dialog" aria-labelledby="myLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-right">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="" alt="" width="700">
                <p class="mt-5"></p>
            </div>
        </div>
    </div>
</div>
@endsection
