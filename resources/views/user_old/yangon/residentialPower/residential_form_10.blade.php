@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="card-title text-center text-white m-0">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5><br/>
                {!! Form::open(['route' => 'resident_power_bill_store_ygn', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id) !!}
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="form-group m-0">
                            <h4 class="card-title">{{ __('lang.prev_bill2') }} <span class="text-danger f-s-15">&#10039;</span></h4>
                        </div>
                        <div class="form-group">
                            {!! Form::file('front', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'onchange' => 'readURL(this, "front")', 'required']) !!}
                        </div>

                        <div class="preview-wrapper">
                            <div class="front_preview text-center d-none">
                                <img id="front_preview" src="" alt="Image Preview" class="img-responsive" />
                                <p class="m-t-10"><a href="" class="delete_front text-danger">Remove</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="alert alert-danger text-center">
                        <p class="card-title text-danger font-weight-bold m-0"><i class="fa fa-certificate"></i> {{ __('lang.escape_prev_bill') }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('all_meter_forms') }}" class="waves-effect waves-light btn btn-secondary btn-rounded">{{ __('lang.cancel') }}</a>
                <button type="submit" class="waves-effect waves-light btn btn-primary btn-rounded">{{ __('lang.submit') }}</button>
                <a href="{{ route('resident_power_farmland_create_ygn',$form_id) }}" class="waves-effect waves-light btn btn-info btn-rounded col-md-3">{{ __('lang.continue') }}</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="modal" id="myImg" tabindex="-1" role="dialog" aria-labelledby="myLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-right">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="" alt="" width="700">
                <p class="mt-5"></p>
            </div>
        </div>
    </div>
</div>
@endsection