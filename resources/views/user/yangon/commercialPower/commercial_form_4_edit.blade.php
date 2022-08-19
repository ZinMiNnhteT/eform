@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="card-title text-center text-white m-0">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                {{--  {{ dd(public_path()) }}  --}}
                @php
                    $required = 'required';
                    $star = '<span class="text-danger f-s-15">&#10039;</span>';
                    if (count($files) > 0) {
                        foreach ($files as $file) {
                            $form_id = $form->id;
            
                            $name = $form->serial_code;
                            $data1 = explode(',', $file->form_10_front);
                            foreach ($data1 as $item){
                                if($item != ""){
                                    $required = '';
                                    $star = '';
                                }
                            }
            
                            if ($file->form_10_back) {
                                $data2 = explode(',', $file->form_10_back);
                            } else {
                                $data2 = null;
                            }
                        }
                    } else {
                        $data1 = $data2 = NULL;
                    }
                @endphp
                @if($required == 'required')
                    <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                    <br/>
                @endif
                {!! Form::open(['route' => ['commercial_form10_update_ygn'], 'method' => 'PATCH', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id) !!}
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-group m-0">
                            <h4 class="card-title ">{{ __('lang.form10_front') }} {!! $star !!}</h4>
                        </div>
                        <div class="form-group">
                            {!! Form::file('front[]', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'id' => 'uploadFile2', 'multiple', $required]) !!} <br>
                            <div class="text-danger m-t-10">{{ __('lang.upload_photo_multi') }}</div>
                        </div>
                        <div class="preview-wrapper">
                            <div id="image_preview2" class="row m-t-10 m-b-10"></div>
                        </div>
                        @if ($files->count() > 0)
                        <hr/>
                        <div class="row m-t-10 m-b-10">
                            @foreach ($files as $file)
                                @if ($file->form_10_front)
                                    @php $data = explode(',', $file->form_10_front); @endphp
                                    @foreach ($data as $item)
                                        <div class="col-4 text-center">
                                            <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$item) }}" alt="{{ $item }}"  width="175" height="150" alt="" class="img-thumbnail custom-img-thumbnail" data-toggle="modal" data-target="#myImg">
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                        @endif
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
                        @if ($files->count() > 0)
                        <hr/>
                        <div class="row m-t-10 m-b-10">
                            @foreach ($files as $file)
                                @if ($file->form_10_back)
                                    @php $data = explode(',', $file->form_10_back); @endphp
                                    @foreach ($data as $item)
                                        <div class="col-4 text-center">
                                            <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$item) }}" alt="{{ $item }}"  width="175" height="150" alt="" class="img-thumbnail custom-img-thumbnail" data-toggle="modal" data-target="#myImg">
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('commercial_applied_form_ygn', $form_id) }}" class="col-md-3 waves-effect waves-light btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
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
