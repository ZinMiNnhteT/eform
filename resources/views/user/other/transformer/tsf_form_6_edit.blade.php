@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-success">
                <h4 class="card-title text-center text-white  m-0">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                <div class="container">
                @php
                    $required = 'required';
                    $star = '<span class="text-danger f-s-15">&#10039;</span>';
                    if ($files->count() > 0){
                        foreach ($files as $file){
                            if ($file->ownership){
                                $data = explode(',', $file->ownership);
                                foreach ($data as $item){
                                    $required = '';
                                    $star = '';
                                }
                            }
                        }
                    }
                @endphp
                @if($required == 'required')
                    <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                    <br/>
                @endif
                {!! Form::open(['route' => 'tsf_owner_update', 'method' => 'PATCH', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id, ['id' => 'form_id']) !!}
                <div class="row">
                    <div class="col-12">
                        <h4 class="card-title ">{{ __('lang.owner_photo') }} {!! $star !!}</h4>
                        <p class="card-title ">{{ __('lang.owner_photo1') }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! Form::file('front[]', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'id' => 'uploadFile', 'multiple', $required]) !!}
                        <p class="px-1 py-1 text-danger ">{{ __('lang.owner_photo_msg') }}</p>
                    </div>
                </div>
                <div class="preview-wrapper">
                    <div id="image_preview" class="row m-t-10 m-b-10"></div>
                </div>
            
                @if ($files->count() > 0)
                <div class="row m-t-10 m-b-10">
                    @foreach ($files as $file)
                        @if ($file->ownership)
                    @php $data = explode(',', $file->ownership); @endphp
                            @foreach ($data as $item)
                    <div class="col-md-2 col-sm-3 text-center">
                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$item) }}" alt="{{ $item }}" width="175" height="150" alt="" class="img-thumbnail custom-img-thumbnail">
                    </div>
                            @endforeach
                        @endif
                    @endforeach
                </div>
                @endif
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="" onclick="event.preventDefault();" class="col-md-3 waves-effect waves-light btn btn-warning btn-rounded btn-remove  d-none">{{ __('lang.remove') }}</a>
                <a href="{{ route('tsf_applied_form', $form->id) }}" class="col-md-3 waves-effect waves-light btn btn-secondary btn-rounded ">{{ __('lang.cancel') }}</a>
                <button type="submit" class="col-md-3 waves-effect waves-light btn btn-primary btn-rounded " name='submitImage'>{{ __('lang.submit') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
