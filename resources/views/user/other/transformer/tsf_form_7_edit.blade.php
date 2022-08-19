@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-success">
                <h5 class="card-title text-center text-white m-0">{{ __('lang.'.$heading) }}</h5>
            </div>
            <div class="card-body">
                <div class="container">
                @php
                    $required = 'required';
                    $star = '<span class="text-danger f-s-15">&#10039;</span>';
                    if ($files->count() > 0){
                        foreach ($files as $file){
                            if ($file->transaction_licence){
                                $data = explode(',', $file->transaction_licence);
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
                {!! Form::open(['route' => 'tsf_worklicence_update', 'method' => 'PATCH', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id, ['id' => 'form_id']) !!}
                <div class="row">
                    <div class="col-12">
                        <h4 class="card-title">{{ __('lang.applied_transactionlicence_photo') }} {!! $star !!}</h4>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        {!! Form::file('front[]', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'id' => 'uploadFile', 'multiple', $required]) !!}
                    </div>
                </div>
                <div class="preview-wrapper">
                    <div id="image_preview" class="row m-t-10 m-b-10"></div>
                </div>
                @if ($files->count() > 0)
                @foreach ($files as $file)
                @if ($file->transaction_licence)
                @php $data = explode(',', $file->transaction_licence); @endphp
                <div class="row m-t-10 m-b-10">
                @foreach ($data as $item)
                    <div class="col-md-2 text-center">
                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$item) }}" alt="{{ $item }}"  width="175" height="150" alt="" class="img-thumbnail custom-img-thumbnail">
                    </div>
                @endforeach
                </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="" onclick="event.preventDefault();" class="col-md-3 waves-effect waves-light btn btn-rounded btn-warning btn-remove d-none">{{ __('lang.remove') }}</a>
            <a href="{{ route('tsf_applied_form', $form->id) }}" class="col-md-3 waves-effect waves-light btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
            <button type="submit" class="col-md-3 waves-effect waves-light btn btn-rounded btn-primary" name='submitImage'>{{ __('lang.submit') }}</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
