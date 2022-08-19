@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title text-center text-white m-0">{{ __('lang.'.$heading) }}</h5>
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
                {!! Form::open(['route' => 'resident_power_owner_update_mdy', 'method' => 'PATCH', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id, ['id' => 'form_id']) !!}
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">{{ __('lang.owner_photo') }} {!! $star !!}</h4>
                            <p class="card-title ">{{ __('lang.owner_photo1') }}</p>
                            
                            {!! Form::file('front[]', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'id' => 'uploadFile', 'multiple', $required]) !!}
                            <p class="px-1 py-1 text-danger m-t-10">{{ __('lang.upload_photo_multi') }}</p>
                            <div class="preview-wrapper m-t-10">
                                <div id="image_preview" class="row m-t-10 m-b-10"></div>
                            </div>
                        </div>
                    </div>

                    <hr/>
                    <div class="row m-t-10 m-b-10">
                        @foreach ($files as $file)
                            @if ($file->ownership)
                        @php $data = explode(',', $file->ownership); @endphp
                                @foreach ($data as $item)
                        <div class="col-md-2 text-center">
                            <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$item) }}" alt="{{ $item }}"  width="175" height="150" alt="" class="img-thumbnail custom-img-thumbnail">
                        </div>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="remove" onclick="event.preventDefault();" class="col-md-3 btn btn-rounded btn-warning btn-remove d-none">{{ __('lang.remove') }}</a>
                <a href="{{ route('resident_power_applied_form_mdy', $form->id) }}" class="col-md-3 btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                <input type="submit" class="col-md-3 btn btn-rounded btn-primary" name='submitImage' value="{{ __('lang.submit') }}"/>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
