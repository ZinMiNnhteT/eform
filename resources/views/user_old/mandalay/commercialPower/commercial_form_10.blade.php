@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="card-title text-center text-white m-0">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                <div class="container">
                {!! Form::open(['route' => 'commercial_power_ministry_permit_store_mdy', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id, ['id' => 'form_id']) !!}
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title ">{{ __('lang.ministry_permit') }}</h4>
                            {!! Form::file('front[]', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'id' => 'uploadFile', 'multiple', 'required']) !!}
                            <p class="px-1 py-1 text-danger m-t-10">{{ __('lang.owner_photo_msg') }}</p>

                            <div class="preview-wrapper">
                                <div id="image_preview" class="row m-t-10 m-b-10"></div>
                            </div>
                        </div>
                    </div>
                    
                
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="" onclick="event.preventDefault();" class="waves-effect waves-light btn btn-warning btn-rounded btn-remove col-md-2 d-none">{{ __('lang.remove') }}</a>
                <a href="{{ route('all_meter_forms') }}" class="waves-effect waves-light btn btn-secondary btn-rounded col-md-2">{{ __('lang.cancel') }}</a>
                <button type="submit" class="waves-effect waves-light btn btn-primary btn-rounded col-md-2" name='submitImage'>{{ __('lang.submit') }}</button>
                <a href="{{ route('commercial_applied_form_mdy', $form_id) }}" class="waves-effect waves-light btn btn-info btn-rounded col-md-3">{{ __('lang.continue') }}</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
