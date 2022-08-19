@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0"> {{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('residentialPowerMeterInstallationDoneList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body card-body-pb-div">

                @include('layouts.form-progressbar')

                <div class="container-fluid">
                    <div id="app_show" class="accordion" role="tablist" aria-multiselectable="true">
                        @include('layouts.user_apply_form')
                        @if (chk_userForm($data->id)['ei_confirm'])
                            @if (hasPermissions(['residentialPowerInstallDone-create']))
                            <div class="card mb-1">
                                <div class="card-header d-flex" role="tab" id="headingOne">
                                    <h5 class="mb-0 text-info">{{ __('EI စစ်ဆေးခြင်း') }}</h5>
                                </div>
                                <div class="card-body">
                                    <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                                    <br/>
                                    {!! Form::open(['route' => 'residentialPowerMeterInstallationDoneList.create', 'files' => true]) !!}
                                    {!! Form::hidden('form_id', $data->id) !!}
                                    <div class="container">
                                        <div class="row form-group mb-1">
                                            <label for="front" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.attach_files') }}  <span class="text-danger f-s-15">&#10039;</span></label>
                                            <div class="col-md-7">
                                                <input type="file" required name="front[]" class="form-control" id="front" accept=".png,.jpg,.pdf" multiple>
                                            </div>
                                        </div>
                                        <div class="row form-group mb-1">
                                            <label for="ei_remark" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.remark') }} <span class="text-danger f-s-15">&#10039;</span></label>
                                            <div class="col-md-7">
                                                <textarea name="ei_remark" required class="form-control inner-form" id="ei_remark" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center mt-5">
                                        {{-- <a href="{{ route('transformerRegisterMeterList.index') }}" class="btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a> --}}
                                        <input type="submit" name="ei_submit" value="{{ __('lang.submit') }}" class="btn btn-rounded btn-info">
                                    </div>
                                    {!! Form::close() !!}
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

<div class="modal" id="confirm_install" tabindex="-1" role="dialog" aria-labelledby="announceModel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5 class="modal-title mt-3 mb-3" id="announceModel">{{ __("lang.confirm_install") }}</h5>
                <hr/>
                <p class="mt-5 mb-5">{{ __("lang.confirm_install_msg") }}</p>
                <hr/>
                <button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">Close</button>
                <a href="{{ route('residentialPowerMeterInstallationDoneList.create', $data->id) }}" class="btn btn-rounded btn-info">{{ __('lang.send') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
