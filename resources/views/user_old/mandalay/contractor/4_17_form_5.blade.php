@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="card-title text-center text-white m-0">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                <div class="container">
                {!! Form::open(['route' => '417_owner_store_mdy', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id, ['id' => 'form_id']) !!}
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">{{ __('lang.owner_photo') }} <span class="text-danger f-s-15">&#10039;</span></h4>
                            <p class="card-title">{{ __('lang.owner_photo1') }}</p>
                            {!! Form::file('front[]', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'id' => 'uploadFile', 'multiple', 'required']) !!}
                            <p class="px-1 py-1 m-t-10 text-danger">{{ __('lang.owner_photo_msg') }}</p>
                                
                            <div class="preview-wrapper">
                                <div id="image_preview" class="row m-t-10 m-b-10"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="" onclick="event.preventDefault();" class="col-md-3 waves-effect waves-light btn btn-warning btn-rounded btn-remove d-none">{{ __('lang.remove') }}</a>
                <a href="{{ route('all_meter_forms') }}" class="col-md-3 waves-effect waves-light btn btn-secondary btn-rounded">{{ __('lang.cancel') }}</a>
                <button type="submit" class="col-md-3 waves-effect waves-light btn btn-primary btn-rounded" name='submitImage'>{{ __('lang.submit') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
