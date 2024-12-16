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
                    $required = 'required';
                    $star = '<span class="text-danger f-s-15">&#10039;</span>';
                    if ($files->count() > 0){
                        foreach ($files as $file){
                            if ($file->electric_power){
                                $data = explode(',', $file->electric_power);
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
                {!! Form::open(['route' => 'tsf_electricpower_update_ygn', 'method' => 'PATCH', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id, ['id' => 'form_id']) !!}
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">{{ __('lang.electricpower_photo') }} {!! $star !!}</h4>
                            {!! Form::file('front[]', ['class' => 'cursor-p front', 'accept' => '.pdf.jpg,.png', 'id' => 'uploadFile', 'multiple',$required]) !!}
                            <p class="px-1 py-1 m-t-10 text-danger">{{ __('lang.owner_photo_msg') }}</p>
                            
                            <div class="preview-wrapper m-t-10">
                                <div id="image_preview" class="row m-t-10 m-b-10"></div>
                            </div>
                        </div>
                    </div>
                
                @if ($files->count() > 0)
                <hr/>
                <div class="row m-t-10 m-b-10">
                    @foreach ($files as $file)
                        @if ($file->electric_power)
                    @php $data = explode(',', $file->electric_power); @endphp
                            @foreach ($data as $item)
                    <div class="col-md-2 col-sm-3 text-center">
                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$item) }}" alt="{{ $item }}"  width="175" height="150" alt="" class="img-thumbnail custom-img-thumbnail">
                    </div>
                            @endforeach
                        @endif
                    @endforeach
                </div>
                @endif
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="" onclick="event.preventDefault();" class="col-3 btn btn-rounded btn-warning btn-remove d-none">{{ __('lang.remove') }}</a>
                <a href="{{ route('resident_power_applied_form_ygn', $form->id) }}" class="col-3 btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                <input type="submit" class="col-3 btn btn-rounded btn-primary" name='submitImage' value="{{ __('lang.submit') }}"/>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
