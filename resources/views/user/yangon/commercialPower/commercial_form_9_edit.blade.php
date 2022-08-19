@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="card-title text-center text-white m-0">{{ __('lang.'.$heading) }}</h5>
            </div>
            <div class="card-body">
                <div class="container">
                @php
                    $required = '';
                    $star = '';
                @endphp
                @if($required == 'required')
                    <h5 class="py-2 text-danger text-center ">{{ __('lang.farmland_permit_escape') }}</h5>
                    <br/>
                @endif
                {!! Form::open(['route' => 'commercial_farmland_update_ygn', 'method' => 'PATCH', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id, ['id' => 'form_id']) !!}
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title ">{{ __('lang.farmland_permit') }} {!! $star !!}</h4>

                            {!! Form::file('front[]', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'id' => 'uploadFile', 'multiple', $required]) !!}
                            <p class="px-1 py-1 text-danger m-t-10">{{ __('lang.owner_photo_msg') }}</p>

                            <div class="preview-wrapper my-3">
                                <div id="image_preview" class="row m-t-10 m-b-10"></div>
                            </div>
                        </div>
                    </div>
                
                
                @if ($files->count() > 0)
                <hr/>
                <div class="row m-t-10 m-b-10">
                    @foreach ($files as $file)
                        @if ($file->farmland)
                            @php $data = explode(',', $file->farmland); @endphp
                            @foreach ($data as $item)
                                <div class="col-2 text-center">
                                    <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$item) }}" alt="{{ $item }}"  width="175" height="150" alt="" class="img-thumbnail custom-img-thumbnail" data-toggle="modal" data-target="#myImg">
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                </div>
                @endif
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="" onclick="event.preventDefault();" class="waves-effect waves-light btn btn-warning btn-rounded btn-remove  d-none col-md-3">{{ __('lang.remove') }}</a>
                <a href="{{ route('commercial_applied_form_ygn', $form->id) }}" class="waves-effect waves-light btn btn-secondary btn-rounded col-md-3">{{ __('lang.cancel') }}</a>
                <button type="submit" class="waves-effect waves-light btn btn-primary btn-rounded col-md-3" name='submitImage'>{{ __('lang.submit') }}</button>
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
