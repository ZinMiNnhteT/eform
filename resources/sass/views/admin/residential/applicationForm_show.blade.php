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

                {{-- user form show --}}
                @include('layouts.form-progressbar')

                <div class="container-fluid">
                    <div id="app_show" class="accordion" role="tablist" aria-multiselectable="true">

                        @include('layouts.user_apply_form')
                        
                    </div>
                    
                @if (chk_userForm($data->id)['to_confirm'])
                    @if (hasPermissions(['residentApplication-create'])) {{--  if login-user is from township  --}}
                    <div class="row justify-content-center m-t-20 m-b-10">
                        <div class="col-3">
                            <a class="waves-effect waves-light btn btn-block btn-rounded btn-danger text-white" data-toggle="modal" data-target="#myRejectFormModal" data-backdrop="static" data-keyboard="false" data-id="{{ $data->id }}">{{ __('lang.send_reject') }}</a>
                        </div>
                        <div class="col-3">
                            <button class="waves-effect waves-light btn btn-block btn-rounded btn-warning" data-toggle="modal" data-target="#myResendModal" data-backdrop="static" data-keyboard="false" data-id="{{ $data->id }}">{{ __('lang.send_to_user') }}</button> 
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
                <!--<h5 class="py-2 text-danger text-center">{{ __('lang.required_msg') }}</h5>-->
                <p class="mt-5">{{ __("lang.resend_msg") }}</p>
                
                {!! Form::open(['route' => 'residentialMeterFormErrorSend.store']) !!}
                {!! Form::hidden('form_id', null, ['id' => 'form_id']) !!}
                <div class="form-group">
                    <!--<label for="remark" class="text-info mt-3 mb-2">{{ __('lang.remark') }} <span class="text-danger f-s-15">&#10039;</span> :</label>-->
                    <label for="remark" class="text-info mt-3 mb-2">{{ __('lang.remark') }}:</label>
                    {!! Form::textarea('remark', null, ['class' => 'textarea_editor form-control', 'required']) !!}
                </div>
                <div class="text-center">
                    <button type="button" class="waves-effect waves-light btn btn-rounded btn-secondary" data-dismiss="modal">{{ __('lang.cancel') }}</button>
                    <button type="submit" class="waves-effect waves-light btn btn-rounded btn-warning">{{ __('lang.resend') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div class="modal" id="myRejectFormModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title mt-3 mb-3 text-center" id="rejectModalLabel">{{ __("lang.reject_title") }}</h5>
                <hr/>
                <p class="mt-5">{{ __("lang.reject_msg") }}</p>
                <!--<h6 class="text-danger">{{ __('lang.required_msg') }}</h6>-->
                <!--<br/>-->
                {!! Form::open(['route' => 'residentialMeterFormRejectSend.store']) !!}
                {!! Form::hidden('form_id', null, ['id' => 'form_id']) !!}
                <div class="form-group">
                    <label for="reject_remark" class="text-info mt-3 mb-2">{{ __('lang.remark') }}:</label>
                    <textarea name="reject_remark" class="textarea_editor1 form-control" required></textarea>
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
