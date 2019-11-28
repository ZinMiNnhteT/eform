@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('contractorMeterRegisterMeterList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>

            <div class="card-body mm">
                <h5 class="text-center">လျှပ်စစ်ပုံစံ (၆၆)</h5>
                <h5 class="text-center">လျှပ်စစ်ဓါတ်အားဖြန့်ဖြူးရေးလုပ်ငန်း</h5>
                <h5 class="text-center">{{ township_mm($form->township_id) }}</h5>

                {!! Form::open(['route' => 'contractorMeterRegisterMeterList.store']) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                <div class="container-fluid">
                    <div class="row form-group mb-1">
                        <label for="serial" class="control-label l-h-35 text-md-right text-info col-md-3">လျှောက်လွှာအမှတ်</label>
                        <div class="col-md-7">
                            {!! Form::text('serial', $form->serial_code, ['id' => 'serial', 'class' => 'form-control inner-form', 'readonly']) !!}
                        </div>
                    </div>
                    
                    <br/>

                    <div class="row form-group mb-1">
                        <label for="serial" class="control-label l-h-35 text-md-right text-primary col-md-4"><strong>အခန်း({{ checkMM() == 'mm' ? mmNum($c_form->room_count) : $c_form->room_count }})ခန်းအတွက် မီတာအမှတ်များ ဖြည့်သွင်းရန် -</strong></label>
                    </div>

                    @for ($n = 1; $n <= $c_form->room_count; $n++)
                        <div class="row form-group mb-20 justify-content-center">
                            <div class="col-2">
                                <label for="room_no" class="control-label text-info">အခန်းအမှတ်</label>
                                {!! Form::text('room_no[]', null, ['id' => 'room_no', 'class' => 'form-control inner-form']) !!}
                            </div>
                            <div class="col-2">
                                <label for="meter_no" class="control-label text-info">မီတာအမှတ်</label>
                                {!! Form::text('meter_no[]', null, ['id' => 'meter_no', 'class' => 'form-control inner-form']) !!}
                            </div>
                            <div class="col-2">
                                <label for="meter_seal_no" class="control-label text-info">မီတာစီးအမှတ်</label>
                                {!! Form::text('meter_seal_no[]', null, ['id' => 'meter_seal_no', 'class' => 'form-control inner-form']) !!}
                            </div>
                            <div class="col-2">
                                <label for="who_made_meter" class="control-label text-info">မီတာလုပ်သူ</label>
                                {!! Form::text('who_made_meter[]', null, ['id' => 'who_made_meter', 'class' => 'form-control inner-form']) !!}
                            </div>
                            <div class="col-2">
                                <label for="ampere" class="control-label text-info">အမ်ပီယာ</label>
                                {!! Form::text('ampere[]', null, ['id' => 'ampere', 'class' => 'form-control inner-form']) !!}
                            </div>
                        </div>
                    @endfor

                    @for ($nn = 1; $nn <= $c_form->water_meter; $nn++)
                        <div class="row form-group mb-20 justify-content-center">
                            <div class="col-3">
                                <label for="water_meter_no" class="control-label text-md-right text-info">ရေစက်မီတာအမှတ်</label>
                                {!! Form::text('water_meter_no[]', null, ['id' => 'water_meter_no', 'class' => 'form-control inner-form']) !!}
                            </div>
                            <div class="col-3">
                                <label for="water_meter_seal_no" class="control-label text-md-right text-info">မီတာစီးအမှတ်</label>
                                {!! Form::text('water_meter_seal_no[]', null, ['id' => 'water_meter_seal_no', 'class' => 'form-control inner-form']) !!}
                            </div>
                            <div class="col-3">
                                <label for="water_who_made_meter" class="control-label text-info">မီတာလုပ်သူ</label>
                                {!! Form::text('water_who_made_meter[]', null, ['id' => 'who_made_meter', 'class' => 'form-control inner-form']) !!}
                            </div>
                            <div class="col-3">
                                <label for="water_ampere" class="control-label text-info">အမ်ပီယာ</label>
                                {!! Form::text('water_ampere[]', null, ['id' => 'ampere', 'class' => 'form-control inner-form']) !!}
                            </div>
                        </div>
                    @endfor

                    @for ($nnn = 1; $nnn <= $c_form->elevator_meter; $nnn++)
                        <div class="row form-group mb-20 justify-content-center">
                            <div class="col-3">
                                <label for="elevator_meter_no" class="control-label text-md-right text-info">ပါဝါမီတာအမှတ်</label>
                                {!! Form::text('elevator_meter_no[]', null, ['id' => 'elevator_meter_no', 'class' => 'form-control inner-form']) !!}
                            </div>
                            <div class="col-3">
                                <label for="elevator_meter_seal_no" class="control-label text-md-right text-info">မီတာစီးအမှတ်</label>
                                {!! Form::text('elevator_meter_seal_no[]', null, ['id' => 'elevator_meter_seal_no', 'class' => 'form-control inner-form']) !!}
                            </div>
                            <div class="col-3">
                                <label for="elevator_who_made_meter" class="control-label text-info">မီတာလုပ်သူ</label>
                                {!! Form::text('elevator_who_made_meter[]', null, ['id' => 'who_made_meter', 'class' => 'form-control inner-form']) !!}
                            </div>
                            <div class="col-3">
                                <label for="elevator_ampere" class="control-label text-info">အမ်ပီယာ</label>
                                {!! Form::text('elevator_ampere[]', null, ['id' => 'ampere', 'class' => 'form-control inner-form']) !!}
                            </div>
                        </div>
                    @endfor
                    <br/>

                    <div class="row form-group mb-1">
                        <label for="meter_get_date" class="control-label l-h-35 text-md-right col-md-3">ဌာနချုပ်မှရသောနေ့</label>
                        <div class="col-md-7">
                            {!! Form::text('meter_get_date', null, ['id' => 'meter_get_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="pay_date" class="control-label l-h-35 text-md-right col-md-3">ထုတ်ပေးသောနေ့</label>
                        <div class="col-md-7">
                            {!! Form::text('pay_date', null, ['id' => 'pay_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="mark_user_no" class="control-label l-h-35 text-md-right col-md-3">အမှတ်အသားနှင့် သုံးစွဲသူအမှတ်</label>
                        <div class="col-md-7">
                            {!! Form::text('mark_user_no', null, ['id' => 'mark_user_no', 'class' => 'form-control inner-form']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="budget" class="control-label l-h-35 text-md-right col-md-3">ဘတ်ဂျက်</label>
                        <div class="col-md-7">
                            {!! Form::text('budget', null, ['id' => 'budget', 'class' => 'form-control inner-form']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="move_date" class="control-label l-h-35 text-md-right col-md-3">ရွှေ့ပြောင်းရက်စွဲ</label>
                        <div class="col-md-7">
                            {!! Form::text('move_date', null, ['id' => 'move_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="move_budget" class="control-label l-h-35 text-md-right col-md-3">ရွှေ့ပြောင်းဘတ်ဂျက်</label>
                        <div class="col-md-7">
                            {!! Form::text('move_budget', null, ['id' => 'move_budget', 'class' => 'form-control inner-form']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="move_order" class="control-label l-h-35 text-md-right col-md-3">ရွှေ့ပြောင်းခြင်းရာအမိန့်</label>
                        <div class="col-md-7">
                            {!! Form::text('move_order', null, ['id' => 'move_order', 'class' => 'form-control inner-form']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="test_date" class="control-label l-h-35 text-md-right col-md-3">စမ်းသပ်သောနေ့</label>
                        <div class="col-md-7">
                            {!! Form::text('test_date', null, ['id' => 'test_date', 'class' => 'form-control inner-form mydatepicker']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="test_no" class="control-label l-h-35 text-md-right col-md-3">စမ်းသပ်ချက်မှတ်တမ်းအမှတ်</label>
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
                    <a href="{{ route('contractorMeterRegisterMeterList.index') }}" class="btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                    <input type="submit" name="form66_submit" value="{{ __('lang.submit') }}" class="btn btn-rounded btn-info">
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>

@endsection