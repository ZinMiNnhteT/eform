@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('residentialMeterApplicationList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body card-body-pb-div">

                @include('layouts.form-progressbar')

                <div class="container-fluid">
                    <div id="app_show" class="accordion" role="tablist" aria-multiselectable="true">

                        @include('layouts.user_apply_form')
                        
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
                        @if (isset($survey_result) && $survey_result->count() > 0)
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
                    </div>
                    
                @if (chk_userForm($data->id)['to_confirm'])
                    @if (hasPermissions(['residentApplication-create'])) {{--  if login-user is from township  --}}
                    <div class="row justify-content-center m-t-20 m-b-10">
                        <div class="col-3">
                            <button class="waves-effect waves-light btn btn-block btn-rounded btn-danger" data-toggle="modal" data-target="#myResendModal" data-backdrop="static" data-keyboard="false" data-id="{{ $data->id }}">{{ __('lang.send_to_user') }}</button> 
                        </div>
                        <div class="col-3">
                            <button class="waves-effect waves-light btn btn-block btn-rounded btn-info" data-toggle="modal" data-target="#myAcceptModal" data-backdrop="static" data-keyboard="false">{{ __('lang.form_accept') }}</button>
                        </div>
                    </div>
                    @endif
                @endif

                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal" id="myAcceptModal" tabindex="-1" role="dialog" aria-labelledby="acceptModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5 class="modal-title mt-3 mb-3" id="acceptModalLabel">{{ __("lang.accept_title") }}</h5>
                <hr/>
                <p class="mt-5 mb-5">{{ __("lang.accept_msg") }}</p>
                <hr/>
                <button type="button" class="waves-effect waves-light btn btn-rounded btn-secondary" data-dismiss="modal">{{ __('lang.cancel') }}</button>
                <a href="{{ route('residentialMeterFormAccept.store', $data->id) }}" class="waves-effect waves-light btn btn-rounded btn-info">{{ __('lang.approve') }}</a>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="myResendModal" tabindex="-1" role="dialog" aria-labelledby="resendModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title mt-3 mb-3 text-center" id="resendModalLabel">{{ __("lang.resend_title") }}</h5>
                <hr/>
                <p class="mt-5 mb-5">{{ __("lang.resend_msg") }}</p>
                {!! Form::open(['route' => 'residentialMeterFormErrorSend.store']) !!}
                {!! Form::hidden('form_id', null, ['id' => 'form_id']) !!}
                <div class="form-group">
                    <label for="remark" class="text-info mt-3 mb-2">{{ __('lang.remark') }} :</label>
                    {!! Form::textarea('remark', null, ['class' => 'textarea_editor form-control', 'required']) !!}
                </div>
                <div class="text-center">
                    <button type="button" class="waves-effect waves-light btn btn-rounded btn-secondary" data-dismiss="modal">{{ __('lang.cancel') }}</button>
                    <button type="submit" class="waves-effect waves-light btn btn-rounded btn-danger">{{ __('lang.resend') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection
