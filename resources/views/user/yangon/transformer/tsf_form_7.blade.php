@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="card-title text-center text-white m-0">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                @if($form->apply_tsf_type == 2)
                    <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5><br/>
                @endif
                <div class="container">
                {!! Form::open(['route' => 'tsf_worklicence_store_ygn', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id, ['id' => 'form_id']) !!}
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">{{ __('lang.applied_transactionlicence_photo') }}</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {!! Form::file('front[]', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'id' => 'uploadFile', 'multiple','required']) !!}
                            <p class="px-1 py-1 text-danger m-t-10">{{ __('lang.upload_photo_multi') }}</p>

                        </div>
                    </div>
                    <div class="preview-wrapper">
                        <div id="image_preview" class="row m-t-10 m-b-10"></div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 alert alert-danger m-t-20">
                    <p class="card-title text-danger font-weight-bold m-0"><i class="fa fa-certificate"></i> {{ __('lang.continue_if_not_commercial') }}</p>
                </div>
            </div>
            <div class="text-center card-footer">
                <a href="remove" onclick="event.preventDefault();" class="waves-effect waves-light btn btn-rounded btn-warning btn-remove d-none">{{ __('lang.remove') }}</a>
                <a href="{{ route('all_meter_forms') }}" class="waves-effect waves-light btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                <button type="submit" class="waves-effect waves-light btn btn-rounded btn-primary" name='submitImage'>{{ __('lang.submit') }}</button>

                @if($form->apply_tsf_type != 2)
                    <a href="{{ route('tsf_dcrecomm_create_ygn',$form_id) }}" class="waves-effect waves-light btn btn-rounded btn-info">{{ __('lang.continue') }}</a>
                @endif
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
