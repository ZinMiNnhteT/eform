@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-8">
        <div class="card-header bg-primary">
            <h4 class="card-title text-center text-white">{{ __('lang.'.$heading) }}</h4>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="container">
                {!! Form::open(['route' => 'tsf_electricpower_store_ygn', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id, ['id' => 'form_id']) !!}
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">{{ __('lang.dc_recomm') }}</h4>
                            <!-- <p class="card-title">{{ __('lang.owner_photo1') }}</p> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            {!! Form::file('front[]', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'id' => 'uploadFile', 'multiple', 'required']) !!}
                            <p class="px-1 py-1 text-danger">{{ __('lang.owner_photo_msg') }}</p>
                        </div>
                        
                    </div>
                    <div class="preview-wrapper">
                        <div id="image_preview" class="row m-t-10 m-b-10"></div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-center">
                <a href="remove" onclick="event.preventDefault();" class="waves-effect waves-light btn btn-rounded btn-warning btn-remove d-none">{{ __('lang.remove') }}</a>
                <a href="{{ route('all_meter_forms') }}" class="waves-effect waves-light btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                <button type="submit" class="waves-effect waves-light btn btn-rounded btn-primary" name='submitImage'>{{ __('lang.submit') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
