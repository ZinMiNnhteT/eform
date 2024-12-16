@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('residentialMeterRegisterMeterList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>

            <div class="card-body mm">
                <h5 class="text-center">လျှပ်စစ်ပုံစံ (၆၆)</h5>
                <h5 class="text-center">လျှပ်စစ်ဓါတ်အားဖြန့်ဖြူးရေးလုပ်ငန်း</h5>
                <h5 class="text-center">{{ township_mm($form->township_id) }}</h5>

                {!! Form::open(['route' => 'residentialMeterRegisterMeterList.store']) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                <div class="container">
                    <div class="row form-group mb-1">
                        <label for="serial" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.serial') }}</label>
                        <div class="col-md-7">
                            {!! Form::text('serial', $form->serial_code, ['id' => 'serial', 'class' => 'form-control inner-form', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="meter_no" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.meter_no') }}</label>
                        <div class="col-md-7">
                            {!! Form::text('meter_no', null, ['id' => 'meter_no', 'class' => 'form-control inner-form']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="meter_seal_no" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.meter_seal_no') }}</label>
                        <div class="col-md-7">
                            {!! Form::text('meter_seal_no', null, ['id' => 'meter_seal_no', 'class' => 'form-control inner-form']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="meter_get_date" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.meter_get_date') }}</label>
                        <div class="col-md-7">
                            {!! Form::text('meter_get_date', null, ['id' => 'meter_get_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="who_made_meter" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.who_made_meter') }}</label>
                        <div class="col-md-7">
                            {!! Form::text('who_made_meter', null, ['id' => 'who_made_meter', 'class' => 'form-control inner-form']) !!}
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
                        <label for="mark_user_no" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.mark_user_no') }}</label>
                        <div class="col-md-7">
                            {!! Form::text('mark_user_no', null, ['id' => 'mark_user_no', 'class' => 'form-control inner-form']) !!}
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
                        <label for="remark" class="control-label l-h-35 text-md-right col-md-3">မှတ်ချက်</label>
                        <div class="col-md-7">
                            {!! Form::text('remark', null, ['id' => 'remark', 'class' => 'form-control inner-form']) !!}
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <a href="{{ route('residentialMeterRegisterMeterList.index') }}" class="btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                    <input type="submit" name="form66_submit" value="{{ __('lang.submit') }}" class="btn btn-rounded btn-info">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection