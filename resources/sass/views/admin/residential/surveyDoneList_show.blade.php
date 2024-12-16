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

                        @include('layouts.user_apply_form')
                        
                    </div>
                    @if (chk_userForm($data->id)['to_confirm_survey'])
                        @if (hasPermissionsAndGroupLvl(['residentialChkGrdTownship-create'], admin()->group_lvl)) {{--  if login-user is from township  --}}
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('မြို့နယ်အဆင့် စစ်ဆေးရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                            <br/>
                            {!! Form::open(['route' => 'residentialMeterGroundCheckDoneList.store','files'=>true]) !!}
                            {!! Form::hidden('form_id', $data->id) !!}
                            <div class="row justify-content-center m-t-20">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="remark_tsp" class="text-info">မှတ်ချက် <span class="text-danger f-s-15">&#10039;</span></label>
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
                    <textarea name="remark_tsp" id="reject_remark" class="textarea_editor form-control" required></textarea>
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
