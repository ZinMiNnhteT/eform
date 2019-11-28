@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="card-title text-center text-white">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                <br/>
                <div class="container">
                {!! Form::open(['route' => '417_owner_store', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id, ['id' => 'form_id']) !!}
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">{{ __('lang.owner_photo') }}</h4>
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
                <a href="" onclick="event.preventDefault();" class="col-3 waves-effect waves-light btn btn-warning btn-rounded btn-remove d-none">{{ __('lang.remove') }}</a>
                <a href="{{ route('all_meter_forms') }}" class="col-3 waves-effect waves-light btn btn-secondary btn-rounded">{{ __('lang.cancel') }}</a>
                <button type="submit" class="col-3 waves-effect waves-light btn btn-primary btn-rounded" name='submitImage'>{{ __('lang.submit') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
