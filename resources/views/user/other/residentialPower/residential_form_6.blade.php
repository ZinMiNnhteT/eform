@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-success">
                <h4 class="card-title text-center text-white m-0">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5><br/>

                <div class="container">
                {!! Form::open(['route' => 'resident_power_owner_store', 'files' => true]) !!}
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
                <div class="card-footer text-center">
                    <a href="remove" onclick="event.preventDefault();" class="col-md-3 btn btn-rounded btn-warning btn-remove d-none">{{ __('lang.remove') }}</a>
                    <a href="{{ route('all_meter_forms') }}" class="col-md-3 btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                    <input type="submit" class="col-md-3 btn btn-rounded btn-primary" name='submitImage' value="{{ __('lang.submit') }}"/>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
