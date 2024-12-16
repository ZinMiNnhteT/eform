@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex display-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                    <div class="ml-auto m-0">
                        <a href="{{ route('registered_form.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                    </div>
                
            </div>
            <div class="card-body card-body-pb-div">
                <div class="container-fluid">
                    <div id="app_show" class="accordion" role="tablist" aria-multiselectable="true">
                        @if($data->apply_type == 1)
                            {{-- type 1 အိမ်သုံးမီတာလျှောက်လွှာပုံစံ --}}
                        
                            @include('layouts.user_apply_form')
                            
                            @if(isset($meter_infos) && $meter_infos->count() > 0)
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
                                                        {{ __('lang.meter_no') }}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_no ? $meter_infos->meter_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{ __('ထုတ်လုပ်သူအမှတ်') }}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->who_made_meter ? $meter_infos->who_made_meter : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{ __('မီတာပြ ဂဏာန်း') }}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_unit_no ? $meter_infos->meter_unit_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{ __('Cover Seal') }}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->cover_seal_no ? $meter_infos->cover_seal_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{ __('Terminal Seal') }}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->terminal_seal_no ? $meter_infos->terminal_seal_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{ __('Box Seal') }}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->box_seal_no ? $meter_infos->box_seal_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{ __('lang.ladger_no') }}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->ledger_no ? $meter_infos->ledger_no : '-'}}
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
                                                <tr>
                                                    <td width="30%">
                                                        တပ်ဆင်သူအမည်
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->installer_name ? $meter_infos->installer_name : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        တပ်ဆင်သူရာထူး
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->installer_post ? $meter_infos->installer_post : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        မှတ်ချက်
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->remark ? $meter_infos->remark : '-'}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                            @endif
                        @elseif($data->apply_type == 2)
                            {{-- type 2 အိမ်သုံးပါ၀ါမီတာလျှောက်လွှာပုံစံ --}}
                            @include('layouts.user_apply_form')
                            @if(isset($meter_infos) && $meter_infos->count() > 0)
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
                                                        မီတာအမှတ်
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_no ? $meter_infos->meter_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        ထုတ်လုပ်သူအမှတ်
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->who_made_meter ? $meter_infos->who_made_meter : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        မီတာပြ ဂဏာန်း
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_unit_no ? $meter_infos->meter_unit_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        Cover Seal
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->cover_seal_no ? $meter_infos->cover_seal_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        Terminal Seal
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->terminal_seal_no ? $meter_infos->terminal_seal_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        Box Seal
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->box_seal_no ? $meter_infos->box_seal_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{ __('lang.ladger_no') }}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->ledger_no ? $meter_infos->ledger_no : '-'}}
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
                                                <tr>
                                                    <td width="30%">
                                                        တပ်ဆင်သူအမည်
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->installer_name ? $meter_infos->installer_name : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        တပ်ဆင်သူရာထူး
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->installer_post ? $meter_infos->installer_post : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        မှတ်ချက်
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->remark ? $meter_infos->remark : '-'}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                            @endif
                        @elseif($data->apply_type == 3)
                            {{-- type 3 စက်မှုသုံး ပါဝါ မီတာ --}}
                            @include('layouts.user_apply_form')
                            @if(isset($meter_infos) && $meter_infos->count() > 0)
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
                                                        မီတာအမှတ်
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_no ? $meter_infos->meter_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        ထုတ်လုပ်သူအမှတ်
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->who_made_meter ? $meter_infos->who_made_meter : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        မီတာပြ ဂဏာန်း
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_unit_no ? $meter_infos->meter_unit_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        Cover Seal
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->cover_seal_no ? $meter_infos->cover_seal_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        Terminal Seal
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->terminal_seal_no ? $meter_infos->terminal_seal_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        Box Seal
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->box_seal_no ? $meter_infos->box_seal_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{ __('lang.ladger_no') }}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->ledger_no ? $meter_infos->ledger_no : '-'}}
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
                                                <tr>
                                                    <td width="30%">
                                                        တပ်ဆင်သူအမည်
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->installer_name ? $meter_infos->installer_name : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        တပ်ဆင်သူရာထူး
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->installer_post ? $meter_infos->installer_post : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        မှတ်ချက်
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->remark ? $meter_infos->remark : '-'}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                            @endif
                        @elseif($data->apply_type == 4)
                            {{-- type 4 ထရန်စဖော်မာ လျှောက်လွှာပုံစံ --}}
                            @include('layouts.user_apply_form')
                            @if(isset($meter_infos) && $meter_infos->count() > 0)
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
                                                        မီတာအမှတ်
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_no ? $meter_infos->meter_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        ထုတ်လုပ်သူအမှတ်
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->who_made_meter ? $meter_infos->who_made_meter : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        မီတာပြ ဂဏာန်း
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_unit_no ? $meter_infos->meter_unit_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        Cover Seal
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->cover_seal_no ? $meter_infos->cover_seal_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        Terminal Seal
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->terminal_seal_no ? $meter_infos->terminal_seal_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        Box Seal
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->box_seal_no ? $meter_infos->box_seal_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        {{ __('lang.ladger_no') }}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->ledger_no ? $meter_infos->ledger_no : '-'}}
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
                                                <tr>
                                                    <td width="30%">
                                                        တပ်ဆင်သူအမည်
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->installer_name ? $meter_infos->installer_name : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        တပ်ဆင်သူရာထူး
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->installer_post ? $meter_infos->installer_post : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%">
                                                        မှတ်ချက်
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->remark ? $meter_infos->remark : '-'}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                            @endif
                        @elseif($data->apply_type == 5)
                            {{-- type 5 ကန်ထရိုက်တိုက် အိမ်သုံးမီတာ လျှောက်လွှာပုံစံ --}}
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
                                        <h5 class="text-center"><b>ကန်ထရိုက်တိုက်မီတာ လျှောက်လွှာပုံစံ</b></h5>
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

                        @if(isset($meter_infos) && $meter_infos->count() > 0)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show" href="#registered" aria-expanded="true" aria-controls="collapseOne">{{__('lang.registered_meter_info')}}</a>
                                </h5>
                            </div>
                            <div id="registered" class="card-body collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <?php
                                            $room_meters_count = 0;
                                            $water_meters_count = 0;
                                            $elevator_meters_count = 0;
                                        ?>
                                        @if($c_form->room_count > 0)
                                            <label for="serial" class="control-label l-h-35 text-md-right text-primary"><strong>အခန်း({{ checkMM() == 'mm' ? mmNum($c_form->room_count) : $c_form->room_count }})ခန်းအတွက် မီတာအချက်အလက်များ-</strong></label>

                                            <table class="table table-bordered table-small-padding">
                                                <thead>
                                                    <tr>
                                                        <th>အခန်းအမှတ်</th>
                                                        <th>မီတာအမှတ် </th>
                                                        <th>မီတာစီးအမှတ်</th>
                                                        <th>မီတာလုပ်သူ</th>
                                                        <th>အမ်ပီယာ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $room_meters = App\Admin\Form66::where('application_form_id', $data->id)->limit($c_form->room_count)->get();
                                                    $room_meters_count = count($room_meters);
                                                    ?>
                                                    @foreach ($room_meters as $room_meter)
                                                    <tr>
                                                        <td><?=$room_meter->room_no ?></td>
                                                        <td><?=$room_meter->meter_no ?></td>
                                                        <td><?=$room_meter->meter_seal_no ?></td>
                                                        <td><?=$room_meter->who_made_meter ?></td>
                                                        <td><?=$room_meter->ampere ?></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif

                                        @if($c_form->water_meter > 0)
                                            <label for="serial" class="control-label l-h-35 text-md-right text-primary"><strong>ရေစက်မီတာ({{ checkMM() == 'mm' ? mmNum($c_form->water_meter) : $c_form->water_meter }})လုံးအတွက် မီတာအချက်အလက်များ-</strong></label>

                                            <table class="table table-bordered table-small-padding">
                                                <thead>
                                                    <tr>
                                                        <th>ရေစက်မီတာအမှတ် </th>
                                                        <th>မီတာစီးအမှတ်</th>
                                                        <th>မီတာလုပ်သူ</th>
                                                        <th>အမ်ပီယာ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $water_meters = App\Admin\Form66::where('application_form_id', $data->id)
                                                    ->offset($room_meters_count)
                                                    ->limit($c_form->water_meter)->get();
                                                    $water_meters_count = count($water_meters);
                                                    ?>
                                                    @foreach ($water_meters as $water_meter)
                                                    <tr>
                                                        <td><?=$water_meter->water_meter_no ?></td>
                                                        <td><?=$water_meter->water_meter_seal_no ?></td>
                                                        <td><?=$water_meter->water_who_made_meter ?></td>
                                                        <td><?=$water_meter->water_ampere ?></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif

                                        @if($c_form->elevator_meter > 0)
                                            <label for="serial" class="control-label l-h-35 text-md-right text-primary"><strong> ဓါတ်လှေကားအသုံးပြုရန် ပါဝါမီတာ({{ checkMM() == 'mm' ? mmNum($c_form->elevator_meter) : $c_form->elevator_meter }})လုံးအတွက် မီတာအချက်အလက်များ-</strong></label>

                                            <table class="table table-bordered table-small-padding">
                                                <thead>
                                                    <tr>
                                                        <th>ပါဝါမီတာအမှတ် </th>
                                                        <th>မီတာစီးအမှတ်</th>
                                                        <th>မီတာလုပ်သူ</th>
                                                        <th>အမ်ပီယာ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $elevator_meters = App\Admin\Form66::where('application_form_id', $data->id)
                                                    ->offset($room_meters_count+ $water_meters_count)
                                                    ->limit($c_form->elevator_meter)->get();
                                                    $elevator_meters_count = count($elevator_meters);
                                                    ?>
                                                    @foreach ($elevator_meters as $ele_meter)
                                                    <tr>
                                                        <td><?=$ele_meter->elevator_meter_no ?></td>
                                                        <td><?=$ele_meter->elevator_meter_seal_no ?></td>
                                                        <td><?=$ele_meter->elevator_who_made_meter ?></td>
                                                        <td><?=$ele_meter->elevator_ampere ?></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif

                                        <table class="table no-border table-small-padding">
                                            <tbody>
                                                <tr>
                                                    <td width="40%">
                                                        {{__('lang.meter_get_date')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->meter_get_date ? mmNum(date('d-m-Y', strtotime($meter_infos->meter_get_date))) : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="40%">
                                                        {{__('lang.pay_date')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->pay_date ? mmNum(date('d-m-Y', strtotime($meter_infos->pay_date))) : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="40%">
                                                        {{__('အမှတ်အသားနှင့် သုံးစွဲသူအမှတ်')}}
                                                    </td>
                                                    <td>
                                                        {{ $meter_infos->mark_user_no }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="40%">
                                                        {{__('lang.budget')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->budget ? $meter_infos->budget : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="40%">
                                                        {{__('lang.move_date')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->move_date ? mmNum(date('d-m-Y', strtotime($meter_infos->move_date))) : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="40%">
                                                        {{__('lang.move_budget')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->move_budget ? $meter_infos->move_budget : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="40%">
                                                        {{__('lang.move_order')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->move_order ? $meter_infos->move_order : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="40%">
                                                        {{__('lang.test_date')}}
                                                    </td>
                                                    <td>
                                                        {{ $meter_infos->test_date ? mmNum(date('d-m-Y', strtotime($meter_infos->test_date))) : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="40%">
                                                        {{__('lang.test_no')}}
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->test_no ? $meter_infos->test_no : '-'}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="40%">
                                                        မှတ်ချက်
                                                    </td>
                                                    <td>
                                                        {{$meter_infos->remark ? $meter_infos->remark : '-'}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        


                        @endif

                        
                    </div>

                    <div id="app_show2" class="accordion m-t-30" role="tablist" aria-multiselectable="true">
                        @if($adminActionData->form_accept)
                        <div class="card mb-1">
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#app_show2" href="#appForm" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.accept_title') }}</a>
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
                                    <a data-toggle="collapse" data-parent="#app_show2" href="#residentSurvey" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.ground') }} {{ __('lang.to_survey') }}</a>
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
                                    <a data-toggle="collapse" data-parent="#app_show2" href="#residentSurvey" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.ground') }} {{ __('lang.to_survey') }}</a>
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
                                    <a data-toggle="collapse" data-parent="#app_show2" href="#residentSurveyTown" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.residentSurveyDoneTsp') }} </a>
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
                                    <a data-toggle="collapse" data-parent="#app_show2" href="#residentSurveyDis" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.residentSurveyDoneDist') }} </a>
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
                                    <a data-toggle="collapse" data-parent="#app_show2" href="#residentSurveyDiv" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.residentSurveyDoneDivstate') }} </a>
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
                                    <a data-toggle="collapse" data-parent="#app_show2" href="#announce" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.announce') }}</a>
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
                                    <a data-toggle="collapse" data-parent="#app_show2" href="#ConfrimPayment" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.confirm_payment') }}</a>
                                </h5>
                             
                            </div>
                            <div id="ConfrimPayment" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="container">
                                    <div class="card-body mm">
                                        <table class="table">
                                            <tr>
                                                <th width="50%">{{__('lang.payment_accept_date')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{$formActionData->payment_accepted_date}}</td>
                                            </tr>
                                            <tr>
                                                <th width="50%"> {{__('ပြေစာအမှတ်')}}</th>
                                                <td width="5%">:</td>
                                                <td>{{$formActionData->payment_accepted_slip_nos}}</td>
                                            </tr>
                                            @if($formActionData->payment_accepted_slips != "")
                                            <tr>
                                                <th width="50%"> {{__('ပြေစာဖြတ်ပိုင်းများ')}}</th>
                                                <td width="5%">:</td>
                                                <td>
                                                    <div class="row">
                                                    <?php 
                                                    $files = explode(',',$formActionData->payment_accepted_slips);
                                                    foreach ($files as $foto) {
                                                        $filename = asset('storage/user_attachments/'.$data->id.'/'.$foto);
                                                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                                        ;
                                                        if($ext != 'pdf'){ ?>
                                                        <div class="col-md-3 text-center">
                                                            <img src="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" alt="{{ $foto }}" class="img-thumbnail imgViewer" width="150" height="150">
                                                        </div>
                                                        <?php }else{ ?>
                                                            <a href="{{ asset('storage/user_attachments/'.$data->id.'/'.$foto) }}" target="_blank" class="pdf-block">{{ $foto }}</a>
                                                        <?php }
                                                    }
                                                    ?>  
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
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
                                    <a data-toggle="collapse" data-parent="#app_show2" href="#install" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.check_to_install') }}</a>
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
                                    <a data-toggle="collapse" data-parent="#app_show2" href="#ei" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.to_ei_confirm_div_state') }}</a>
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
                                    <a data-toggle="collapse" data-parent="#app_show2" href="#reg_meter" aria-expanded="true" aria-controls="collapseOne">{{ __('lang.to_register') }}</a>
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
