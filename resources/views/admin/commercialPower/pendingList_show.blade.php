@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('commercialPowerMeterPendingForm.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body card-body-pb-div">

                @include('layouts.form-progressbar')

                <div class="container-fluid">
                    <div id="app_show" class="accordion" role="tablist" aria-multiselectable="true">

                        @include('layouts.user_apply_form')
                        
                    </div>
                    <div class="card mb-1">
                        @if (chk_userForm($data->id)['pending'])
                            @if (hasPermissions(['commercialPowerPending-create'])) {{--  if login-user is from township  --}}
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('စောင့်ဆိုင်းစာရင်းမှ ပယ်ဖျက်ရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => 'commercialPowerMeterPendingForm.store', 'files' => true]) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <p class="text-center text-info">{{ 'လျှောက်လွှာအား ပြန်လည်လုပ်ဆောင်မည်ဆိုပါက ဆက်လက်လုပ်ဆောင်မည် အားနှိပ်နိုင်ပါသည်။' }}</p>
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-md-3">
                                        <button type="submit" name="restore" class="waves-effect waves-light btn btn-rounded btn-primary btn-block">{{ __('lang.continue') }}</button>
                                    </div>
                                </div>
                            </div>
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
