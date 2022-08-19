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
                {{--  {{ dd(public_path()) }}  --}}
                {!! Form::open(['route' => 'commercial_form10_store_ygn', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id) !!}
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-group m-0">
                            <h4 class="card-title ">{{ __('lang.form10_front') }} <span class="text-danger f-s-15">&#10039;</span></h4>
                        </div>
                        <div class="form-group">
                            {{-- {!! Form::file('front[]', ['class' => 'cursor-p front', 'accept' => '.jpeg,.jpg,.png', 'onchange' => 'readURL(this, "front")', 'required','multiple']) !!} --}}
                            {!! Form::file('front[]', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'id' => 'uploadFile2', 'multiple', 'required']) !!} <br>
                            <div class="text-danger m-t-10">{{ __('lang.upload_photo_multi') }}</div>
                        </div>
                        <div class="preview-wrapper">
                            <div id="image_preview2" class="row m-t-10 m-b-10"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group m-0">
                            <h4 class="card-title ">{{ __('lang.form10_back') }}</h4>
                        </div>
                        <div class="form-group">
                            {!! Form::file('back[]', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'id' => 'uploadFile3', 'multiple']) !!} <br>
                            <div class="text-danger m-t-10">{{ __('lang.upload_photo_multi') }}</div>
                        </div>
                        <div class="preview-wrapper">
                            <div id="image_preview3" class="row m-t-10 m-b-10"></div>
                        </div>
                        {{-- <div class="preview-wrapper">
                            <div class="back_preview text-center d-none">
                                <img id="back_preview" src="" alt="Image Preview" class="img-responsive" />
                                <p class="m-t-10"><a href="" class="delete_back text-danger">Remove</a></p>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('all_meter_forms') }}" class="col-md-3 waves-effect waves-light btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                <button type="submit" class="col-md-3 waves-effect waves-light btn btn-rounded btn-primary">{{ __('lang.submit') }}</button>
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
