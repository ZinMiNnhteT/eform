@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('commercialPowerMeterRegisterMeterList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body card-body-pb-div">

                @include('layouts.form-progressbar')

                <div class="container-fluid">
                    <div id="app_show" class="accordion" role="tablist" aria-multiselectable="true">

                        @include('layouts.user_apply_form')
                        
                    </div>
                    <div class="card mb-1">
                        @if (chk_userForm($data->id)['to_register'])
                            @if (hasPermissions(['commercialPowerRegisteredMeter-create']))
                            <div class="card-header d-flex" role="tab" id="headingOne">
                                <h5 class="mb-0 text-info">{{ __('မီတာမှတ်ပုံတင်ရန်') }}</h5>
                            </div>
                            <br><h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                            <div class="card-body mm">
                                {!! Form::open(['route' => 'commercialPowerMeterRegisterMeterList.store']) !!}
                                {!! Form::hidden('form_id', $data->id) !!}
                                <div class="container">
                                    <div class="row form-group mb-1">
                                        <label for="meter_no" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.meter_no') }} <span class="text-danger f-s-15">&#10039;</span></label>
                                        <div class="col-md-7">
                                            {!! Form::text('meter_no', null, ['id' => 'meter_no', 'class' => 'form-control inner-form','required']) !!}
                                        </div>
                                    </div>
                                    <div class="row form-group mb-1">
                                        <label for="who_made_meter" class="control-label l-h-35 text-md-right col-md-3">{{ __('ထုတ်လုပ်သူအမှတ်') }} <span class="text-danger f-s-15">&#10039;</span></label>
                                        <div class="col-md-7">
                                            {!! Form::text('who_made_meter', null, ['id' => 'who_made_meter', 'class' => 'form-control inner-form','required']) !!}
                                        </div>
                                    </div>
                                    <div class="row form-group mb-1">
                                        <label for="meter_no" class="control-label l-h-35 text-md-right col-md-3">{{ __('မီတာပြ ဂဏာန်း') }} <span class="text-danger f-s-15">&#10039;</span></label>
                                        <div class="col-md-7">
                                            {!! Form::text('meter_unit_no', null, ['id' => 'meter_unit_no', 'class' => 'form-control inner-form','required']) !!}
                                        </div>
                                    </div>
        
                                    <div class="row form-group mb-1">
                                        <label for="cover_seal_no" class="control-label l-h-35 text-md-right col-md-3">{{ __('Cover Seal') }} <span class="text-danger f-s-15">&#10039;</span></label>
                                        <div class="col-md-7">
                                            {!! Form::text('cover_seal_no', null, ['id' => 'cover_seal_no', 'class' => 'form-control inner-form','required']) !!}
                                        </div>
                                    </div>
                                    <div class="row form-group mb-1">
                                        <label for="terminal_seal_no" class="control-label l-h-35 text-md-right col-md-3">{{ __('Terminal Seal') }} <span class="text-danger f-s-15">&#10039;</span></label>
                                        <div class="col-md-7">
                                            {!! Form::text('terminal_seal_no', null, ['id' => 'terminal_seal_no', 'class' => 'form-control inner-form','required']) !!}
                                        </div>
                                    </div>
                                    <div class="row form-group mb-1">
                                        <label for="box_seal_no" class="control-label l-h-35 text-md-right col-md-3">{{ __('Box Seal') }}</label>
                                        <div class="col-md-7">
                                            {!! Form::text('box_seal_no', null, ['id' => 'box_seal_no', 'class' => 'form-control inner-form']) !!}
                                        </div>
                                    </div>
                                    <div class="row form-group mb-1">
                                        <label for="ledger_no" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.ladger_no') }}</label>
                                        <div class="col-md-7">
                                            {!! Form::text('ledger_no', null, ['id' => 'ledger_no', 'class' => 'form-control inner-form']) !!}
                                        </div>
                                    </div>
        
                                    <div class="row form-group mb-1">
                                        <label for="meter_get_date" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.meter_get_date') }}</label>
                                        <div class="col-md-7">
                                            {!! Form::text('meter_get_date', null, ['id' => 'meter_get_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                                        </div>
                                    </div>
                                    <div class="row form-group mb-1">
                                        <label for="ampere" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.ampere') }}</label>
                                        <div class="col-md-7">
                                            {!! Form::text('ampere', null, ['id' => 'ampere', 'class' => 'form-control inner-form']) !!}
                                        </div>
                                    </div>
                                    <div class="row form-group mb-1">
                                        <label for="pay_date" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.pay_date') }}</label>
                                        <div class="col-md-7">
                                            {!! Form::text('pay_date', null, ['id' => 'pay_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                                        </div>
                                    </div>
                                    <div class="row form-group mb-1">
                                        <label for="budget" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.budget') }}</label>
                                        <div class="col-md-7">
                                            {!! Form::text('budget', null, ['id' => 'budget', 'class' => 'form-control inner-form']) !!}
                                        </div>
                                    </div>
                                    <div class="row form-group mb-1">
                                        <label for="move_date" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.move_date') }}</label>
                                        <div class="col-md-7">
                                            {!! Form::text('move_date', null, ['id' => 'move_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                                        </div>
                                    </div>
                                    <div class="row form-group mb-1">
                                        <label for="move_budget" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.move_budget') }}</label>
                                        <div class="col-md-7">
                                            {!! Form::text('move_budget', null, ['id' => 'move_budget', 'class' => 'form-control inner-form']) !!}
                                        </div>
                                    </div>
                                    <div class="row form-group mb-1">
                                        <label for="move_order" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.move_order') }}</label>
                                        <div class="col-md-7">
                                            {!! Form::text('move_order', null, ['id' => 'move_order', 'class' => 'form-control inner-form']) !!}
                                        </div>
                                    </div>
                                    <div class="row form-group mb-1">
                                        <label for="test_date" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.test_date') }}</label>
                                        <div class="col-md-7">
                                            {!! Form::text('test_date', null, ['id' => 'test_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                                        </div>
                                    </div>
                                    <div class="row form-group mb-1">
                                        <label for="test_no" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.test_no') }}</label>
                                        <div class="col-md-7">
                                            {!! Form::text('test_no', null, ['id' => 'test_no', 'class' => 'form-control inner-form']) !!}
                                        </div>
                                    </div>
                                    <div class="row form-group mb-1">
                                        <label for="installer_name" class="control-label l-h-35 text-md-right col-md-3">{{ __('တပ်ဆင်သူအမည်') }}</label>
                                        <div class="col-md-7">
                                            {!! Form::text('installer_name', null, ['id' => 'installer_name', 'class' => 'form-control inner-form']) !!}
                                        </div>
                                    </div>
                                    <div class="row form-group mb-1">
                                        <label for="installer_post" class="control-label l-h-35 text-md-right col-md-3">{{ __('တပ်ဆင်သူရာထူး') }}</label>
                                        <div class="col-md-7">
                                            {!! Form::text('installer_post', null, ['id' => 'installer_post', 'class' => 'form-control inner-form']) !!}
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
                                    <button type="submit" name="form66_submit" class="waves-effect waves-light btn btn-rounded btn-info">{{ __('lang.submit') }}</button>
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
</div>
@endsection
