@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('residentialPowerMeterCheckInstallList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body card-body-pb-div">

                @include('layouts.form-progressbar')

                <div class="container-fluid">
                    <div id="app_show" class="accordion" role="tablist" aria-multiselectable="true">
                        
                        @include('layouts.user_apply_form')
                        
                    </div>
                    <div class="card mb-1">
                        @if (chk_userForm($data->id)['to_chk_install'])
                            @if (hasPermissions(['residentialPowerChkInstall-create']))
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('မီတာတပ်ဆင်ရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                            <br/>
                            {!! Form::open(['route' => 'residentialPowerMeterCheckInstallList.store']) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <div class="row justify-content-center">
                                <div class="col-md-8 form-group">
                                    <label>မီတာတပ်ဆင်ပြီးသည့် နေ့ <span class="text-danger f-s-15">&#10039;</span></label>
                                    <input type="text" name="accept_date" class="form-control mydatepicker" placeholder="မီတာတပ်ဆင်ပြီးသည့် နေ့ ဖြည့်သွင်းရန်" required>
                                </div>
                            </div>
                            <div class="text-center mt-5">
                                <button type="submit" name="form138_submit" class="waves-effect waves-light btn btn-rounded btn-info">{{ __('lang.submit') }}</button>
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
