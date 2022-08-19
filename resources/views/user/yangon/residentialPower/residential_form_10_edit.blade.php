@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="card-title text-center text-white m-0">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                @php
                    $required = '';
                    $star = '';
                @endphp
                @if($required == 'required')
                    <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                    <br/>
                @endif

                {!! Form::open(['route' => 'resident_power_bill_update_ygn','method' => 'PATCH', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id) !!}
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="form-group m-0">
                            <h4 class="card-title">{{ __('lang.prev_bill2') }}  {!! $star !!}</h4>
                        </div>
                        <div class="form-group">
                            {!! Form::file('front', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'onchange' => 'readURL(this, "front")', $required]) !!}
                        </div>

                        <div class="preview-wrapper">
                            <div class="front_preview text-center d-none">
                                <img id="front_preview" src="" alt="Image Preview" class="img-responsive" />
                                <p class="m-t-10"><a href="" class="delete_front text-danger">Remove</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($files->count() > 0)
                <hr/>
                <div class="row m-t-10 m-b-10">
                    @foreach ($files as $file)
                        @if ($file->prev_bill)
                            @php $data = explode(',', $file->prev_bill); @endphp
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
            <div class="card-footer text-center">
                <a href="{{ route('resident_power_applied_form_ygn', $form->id) }}" class="waves-effect waves-light btn btn-secondary btn-rounded">{{ __('lang.cancel') }}</a>
                <button type="submit" class="waves-effect waves-light btn btn-primary btn-rounded">{{ __('lang.submit') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection