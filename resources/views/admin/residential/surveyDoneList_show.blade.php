@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('residentialMeterGroundCheckDoneList.index') }}" class="waves-effect waves-light btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
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
                                                အထက်ပါကိစ္စနှင့်ပတ်သက်၍ {{ address_mm($data->id) }}နေ ကျွန်တော်/ကျွန်မ၏ <b>{{ $data->applied_building_type ? $data->applied_building_type : '<span class="p-l-40"></span>' }}</b> တွင် အိမ်သုံးမီတာတစ်လုံး တပ်ဆင်သုံးစွဲခွင့်ပြုပါရန် လျှောက်ထားအပ်ပါသည်။
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
                                @if (chk_send($data->id) !== 'first')
                                <div class="ml-auto">
                                    <a href="{{ route('residential_file_recomm.edit', $data->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                                </div>
                                @endif
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
                            @if (chk_userForm($data->id)['to_confirm_survey'])
                            <div class="ml-auto">
                                <a href="{{ route('residentialMeterGroundCheckDoneListEdit.edit', $data->id) }}" class="btn-edit text-danger">{{ __('lang.edit') }}</a>
                            </div>
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
                                                        @if ($survey_result->loaded == true)
                                                            <p>{{ __('lang.radio_yes') }}</p>
                                                        @elseif ($survey_result->loaded == false)
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
                                                <tr>
                                                    <td>{{ __('lang.applied_electricpower_photo') }}</td>
                                                    <td>
                                                        @if ($survey_result->comsumed_power_file)
                                                        <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$survey_result->comsumed_power_file) }}" alt="{{ $survey_result->comsumed_power_file }}" class="img-thumbnail" width="150" height="150">
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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @if (chk_userForm($data->id)['to_confirm_survey'])
                        @if (hasPermissionsAndGroupLvl(['residentialChkGrdTownship-create'],admin()->group_lvl)) {{--  if login-user is from township  --}}
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('မြို့နယ်အဆင့် စစ်ဆေးရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => 'residentialMeterGroundCheckDoneList.store']) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <div class="row justify-content-center m-t-20">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="remark_tsp" class="text-info">မှတ်ချက်</label>
                                        <textarea required name="remark_tsp" rows="5" class="form-control" id="remark_tsp" placeholder="မှတ်ချက်ပေးရန်"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-md-2">
                                        <button type="submit" name="survey_submit" value="approve" class="waves-effect waves-light btn btn-rounded btn-primary btn-block">{{ __('lang.send_dist_tsp') }}</button>
                                    </div>
                                   {{--   <div class="col-md-2">
                                        <button type="submit" name="survey_submit" value="pending" class="waves-effect waves-light btn btn-rounded btn-warning btn-block">{{ __('lang.send_pending') }}</button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" name="survey_submit" value="reject" class="waves-effect waves-light btn btn-rounded btn-danger btn-block">{{ __('lang.send_reject') }}</button>
                                    </div>  --}}
                                    <div class="col-2">
                                        <a class="waves-effect waves-light btn btn-block btn-rounded btn-warning text-white" data-toggle="modal" data-target="#myPendingModal" data-backdrop="static" data-keyboard="false" data-id="{{ $data->id }}" data-type="2">{{ __('lang.send_pending') }}</a> 
                                    </div>
                                    <div class="col-2">
                                        <a class="waves-effect waves-light btn btn-block btn-rounded btn-danger text-white" data-toggle="modal" data-target="#myRejectModal" data-backdrop="static" data-keyboard="false" data-id="{{ $data->id }}" data-type="2">{{ __('lang.send_reject') }}</a>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        @endif
                    @endif
                </div>
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
                {!! Form::open(['route' => 'residentialMeterGroundCheckDoneList.store']) !!}
                {!! Form::hidden('form_id', null, ['id' => 'p_form_id_dist']) !!}
                <div class="form-group">
                    <label for="pending_remark" class="text-info mt-3 mb-2">{{ __('lang.remark') }} :</label>
                    {!! Form::textarea('remark_tsp', null, ['class' => 'textarea_editor1 form-control', 'id' => 'pending_remark', 'required']) !!}
                </div>
                <div class="text-center">
                    <button type="button" class="waves-effect waves-light btn btn-rounded btn-secondary" data-dismiss="modal">{{ __('lang.cancel') }}</button>
                    <button type="submit" name="survey_submit" value="pending" class="waves-effect waves-light btn btn-rounded btn-warning">{{ __('ပို့မည်') }}</button>
                </div>
                {!! Form::close() !!}
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
                {!! Form::open(['route' => 'residentialMeterGroundCheckDoneList.store']) !!}
                {!! Form::hidden('form_id', null, ['id' => 'r_form_id_dist']) !!}
                <div class="form-group">
                    <label for="reject_remark" class="text-info mt-3 mb-2">{{ __('lang.remark') }} :</label>
                    <textarea name="remark_tsp" id="reject_remark" class="textarea_editor form-control"></textarea>
                </div>
                <div class="text-center">
                    <button type="button" class="waves-effect waves-light btn btn-rounded btn-secondary" data-dismiss="modal">{{ __('lang.cancel') }}</button>
                    <button type="submit" name="survey_submit" value="reject" class="waves-effect waves-light btn btn-rounded btn-danger">{{ __('ပို့မည်') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
