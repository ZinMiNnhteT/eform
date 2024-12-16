@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-success">
                <h4 class="card-title text-center text-white mb-0 m-0">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5><br/>

                <div class="container">
                    {!! Form::open(['route' => 'tsf_worklicence_store', 'files' => true]) !!}
                    {!! Form::hidden('form_id', $form_id, ['id' => 'form_id']) !!}
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title">{{ __('lang.applied_transactionlicence_photo') }} <span class="text-danger f-s-15">&#10039;</span></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::file('front[]', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'id' => 'uploadFile', 'multiple','required']) !!}
                                <p class="px-1 py-1 text-danger mb-1 mt-2">{{ __('lang.owner_photo_msg') }}</p>
                            </div>
                        </div>
                    <div class="preview-wrapper">
                        <div id="image_preview" class="row m-t-10 m-b-10"></div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-group alert alert-danger">
                        <p class="card-title text-danger font-weight-bold m-0"><i class="fa fa-certificate"></i> {{ __('lang.continue_if_not_business') }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="remove" onclick="event.preventDefault();" class="waves-effect waves-light btn btn-rounded btn-warning btn-remove d-none">{{ __('lang.remove') }}</a>
                <a href="{{ route('all_meter_forms') }}" class="waves-effect waves-light btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                <button type="submit" class="waves-effect waves-light btn btn-rounded btn-primary" name='submitImage'>{{ __('lang.submit') }}</button>
                <a href="{{ route('tsf_electricpower_create',$form_id) }}" class="waves-effect waves-light btn btn-rounded btn-info">{{ __('lang.continue') }}</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
