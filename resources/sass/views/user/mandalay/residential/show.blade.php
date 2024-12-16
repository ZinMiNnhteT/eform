@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex display-flex">
                <h5 class="card-title m-0 ">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{route('overall_process')}}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5 "><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body card-body-pb-div">
                @if (chk_send($form->id) == 'first')
                <div class="alert alert-success alert-rounded">
                    <p class="text-success m-0 "><i class="fa fa-check-circle fa-2x fa-fw"></i> {{ __('lang.applied_form_msg_1') }} <a href="{{ route('overall_process') }}">{{ __('lang.process_menu') }}</a> {{ __('lang.applied_form_msg_2') }}</p>
                </div>
                @else
                    @if (chk_form_finish($form->id, $form->apply_type)['state'])
                <div class="alert alert-danger alert-rounded">
                    <p class="text-danger m-0 "><i class="fa fa-exclamation-circle fa-2x fa-fw"></i> {{ __('lang.unapplied_form_msg_1') }} <a href="#btn_send">{{ __('lang.send') }}</a> {{ __('lang.unapplied_form_msg_2') }}</p>
                </div>
                    @else
                <div class="alert alert-danger alert-rounded">
                    <p class="text-danger m-0"><i class="fa fa-exclamation-circle fa-2x fa-fw"></i> {{ __('lang.unfinish_form_msg') }}</p>
                </div>
                    @endif
                @endif

                @include('layouts.form-progressbar')
                
                <div class="container-fluid">
                    <div id="app_show" class="accordion" role="tablist" aria-multiselectable="true">
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0 ">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#info" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.user_info') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if ($form->serial_code)
                                <div class="ml-auto">
                                    <a href="{{ route('resident_edit_user_info_mdy', $form->id) }}" class="btn-edit text-danger ">{{ __('lang.edit') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('resident_edit_user_info_mdy', $form->id) }}" class="btn-edit text-info ">{{ __('lang.create') }}</a>
                                </div>
                                    @endif
                                @endif
                            </div>
                            <div id="info" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="card-body mm">
                                        <h5 class="text-center"><b>အိမ်သုံးမီတာလျှောက်လွှာပုံစံ</b></h5>
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
                                            <h6>အကြောင်းအရာ။<span class="p-l-40">။</span> <b>အိမ်သုံးမီတာ တပ်ဆင်ခွင့်ပြုပါရန် လျှောက်ထားခြင်း။</b></h6>
                                        </div>
                                        <div class="p-t-10">
                                            <h6 class="l-h-35">
                                                <span class="p-l-40"></span><span class="p-l-40"></span>
                                                အထက်ပါကိစ္စနှင့်ပတ်သက်၍ @if (address_mm($form->id)) {{ address_mm($form->id) }} @else <span class="p-l-40"></span> @endifနေ ကျွန်တော်/ကျွန်မ၏ <b>@if ($form->applied_building_type) {{ $form->applied_building_type }} @else <span class="p-l-40"></span> @endif</b> တွင် အိမ်သုံးမီတာတစ်လုံး တပ်ဆင်သုံးစွဲခွင့်ပြုပါရန် လျှောက်ထားအပ်ပါသည်။
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
                                <h5 class="mb-0 ">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#typeOfMeter" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.applied_plan') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                <div class="ml-auto">
                                    <a href="{{ route('resident_edit_meter_type_mdy', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                @endif
                            </div>
                            <div id="typeOfMeter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="talbe-responsive p-20">
                                        <table class="table">
                                            <thead>
                                                <tr class="text-center">
                                                    <th rowspan="2" class="align-middle ">{{ __('lang.descriptions') }}</th>
                                                    <th colspan="3" class="">{{ __('lang.initial_cost') }}</th>
                                                </tr>
                                                <tr class="text-center">
                                                    @foreach ($fee_names as $item)
                                                    <?php var_dump($item->slug); ?>
                                                    
                                                    <th class="">{{ __('lang.'.$item->slug) }}</th>
                                                    
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $total = 0; @endphp
                                                @foreach ($tbl_col_name as $col_name)
                                                @if ($col_name != 'building_fee' && $col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'composit_box' && $col_name != 'sub_type')
                                                <tr>
                                                    <td class="">{{ __('lang.'.$col_name) }}</td>
                                                    @foreach ($fee_names as $fee)
                                                    <td class="text-center">{{ checkMM() === 'mm' ? mmNum(number_format($fee->$col_name)) : number_format($fee->$col_name) }}</td>
                                                    @php $total += $fee->$col_name; @endphp
                                                    @endforeach

                                                </tr>
                                                @endif
                                                @endforeach
                                                <tr class="text-center">
                                                    <td class="">{{ __('lang.total') }}</td>
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
                                <h5 class="mb-0 ">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#nrc" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.nrc') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if (chk_form_finish($form->id, $form->apply_type)['nrc'])
                                <div class="ml-auto">
                                    <a href="{{ route('resident_nrc_edit_mdy', $form->id) }}" class="btn-edit text-info">{{ __('lang.create') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('resident_nrc_edit_mdy', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
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
                                        <p class=" m-t-10 m-b-10">{{ __('lang.nrc_front') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->nrc_copy_back) }}" alt="{{ __('lang.nrc_back') }}" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
                                        <p class=" m-t-10 m-b-10">{{ __('lang.nrc_back') }}</p>
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
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0 ">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#form10" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.form10') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if (chk_form_finish($form->id, $form->apply_type)['form10'])
                                <div class="ml-auto">
                                    <a href="{{ route('resident_form10_edit_mdy', $form->id) }}" class="btn-edit text-info">{{ __('lang.create') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('resident_form10_edit_mdy', $form->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                    @endif
                                @endif
                            </div>
                            <div id="form10" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @if ($files->count() > 0)
                                    @foreach ($files as $file)
                                        @if ($file->form_10_front)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->form_10_front) }}" alt="{{ __('lang.form10_front') }}" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
                                        <p class=" m-t-10 m-b-10">{{ __('lang.form10_front') }}</p>
                                    </div>
                                        @if ($file->form_10_back)
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->form_10_back) }}" alt="{{ __('lang.form10_back') }}" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
                                        <p class=" m-t-10 m-b-10">{{ __('lang.form10_back') }}</p>
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
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0 ">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#recommanded_letter" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('lang.recomm') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if (chk_form_finish($form->id, $form->apply_type)['occupy'])
                                <div class="ml-auto">
                                    <a href="{{ route('resident_recomm_edit_mdy', $form->id) }}" class="btn-edit text-info ">{{ __('lang.create') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('resident_recomm_edit_mdy', $form->id) }}" class="btn-edit text-danger ">{{ __('lang.edit') }}</a>
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
                                        <p class=" m-t-10 m-b-10">{{ __('lang.occupy_letter') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->no_invade_letter) }}" alt="{{ __('lang.noinvade_letter') }}" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
                                        <p class=" m-t-10 m-b-10">{{ __('lang.noinvade_letter') }}</p>
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
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0 ">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#owner_letter" aria-expanded="true" aria-controls="collapseOne">
                                    {{ __('lang.owner') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if (chk_form_finish($form->id, $form->apply_type)['ownership'])
                                <div class="ml-auto">
                                    <a href="{{ route('resident_owner_edit_mdy', $form->id) }}" class="btn-edit text-info ">{{ __('lang.create') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('resident_owner_edit_mdy', $form->id) }}" class="btn-edit text-danger ">{{ __('lang.edit') }}</a>
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
                                        <p class=" m-t-10 m-b-10">{{ __('lang.owner_photo') }} ({{ checkMM()=='mm'?mmNum($i):$i }})</p>
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
                        {{-- <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0 ">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#prev_bill" aria-expanded="true" aria-controls="collapseOne">
                                    {{ __('lang.neighbour_bill') }}
                                    </a>
                                </h5>
                                @if (chk_send($form->id) !== 'first')
                                    @if (chk_form_finish($form->id, $form->apply_type)['bill'])
                                <div class="ml-auto">
                                    <a href="{{ route('resident_bill_edit', $form->id) }}" class="btn-edit text-info ">{{ __('lang.create') }}</a>
                                </div>
                                    @else
                                <div class="ml-auto">
                                    <a href="{{ route('resident_bill_edit', $form->id) }}" class="btn-edit text-danger ">{{ __('lang.edit') }}</a>
                                </div>
                                    @endif
                                @endif
                            </div>
                            <div id="prev_bill" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                @if ($files->count() > 0)
                                    @foreach ($files as $file)
                                        @if ($file->prev_bill)
                                <div class="row text-center mt-2">
                                    <div class="col-md-6 text-center">
                                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file->prev_bill) }}" alt="{{ __('lang.neighbour_bill') }}" class="img-thumbnail" width="150" height="150" data-toggle="modal" data-target="#myImg">
                                        <p class=" m-t-10 m-b-10">{{ __('lang.neighbour_bill') }}</p>
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
                        </div> --}}
                    </div>
                </div>

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
                <h5 class="modal-title  title-msg-reject mt-4 mb-5" id="myLabel">{{ __("lang.send_form_confirm") }}</h5>
                {!! Form::open(['route' => 'resident_user_send_form']) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                <button type="button" class="btn btn-secondary " data-dismiss="modal">{{ __('lang.cancel') }}</button>
                <input type="submit" name="user_send" id="send" value="{{ __('lang.send') }}" class="btn btn-success ">
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
