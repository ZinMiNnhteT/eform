@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="card-title text-center text-white m-0 ">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5><br/>
                {!! Form::open(['route' => 'tsf_recomm_store_ygn', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id, ['id' => 'form_id']) !!}
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="form-group m-0">
                                    <p class="card-title ">{{ __('lang.occupy_letter') }} <span class="text-danger f-s-15">&#10039;</span></p>
                            </div>
                            <div class="form-group">
                                {!! Form::file('front', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'onchange' => 'readURL(this, "front")', 'required']) !!}
                            </div>
                            <div class="preview-wrapper">
                                <div class="front_preview text-center d-none">
                                    <img id="front_preview" src="" alt="Image Preview" class="img-responsive" />
                                    <p class="m-t-10"><a href="" class="delete_front text-danger">Remove</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row m-0">
                                <p class="card-title ">{{ __('lang.noinvade_letter') }} <span class="text-danger f-s-15">&#10039;</span></p>
                            </div>
                            <div class="form-group">
                                {!! Form::file('back', ['class' => 'cursor-p back', 'accept' => '.jpg,.png', 'onchange' => 'readURL(this, "back")', 'required']) !!}
                            </div>
                            <div class="preview-wrapper">
                                <div class="back_preview text-center d-none">
                                    <img id="back_preview" src="" alt="Image Preview" class="img-responsive" />
                                    <p class="m-t-10"><a href="" class="delete_back text-danger">Remove</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center m-t-20">
                            <a href="{{ route('all_meter_forms') }}" class="waves-effect waves-light btn btn-secondary btn-rounded ">{{ __('lang.cancel') }}</a>
                            <button type="submit" class="waves-effect waves-light btn btn-primary btn-rounded ">{{ __('lang.submit') }}</button>
                        </div>
                    </div>
                {!! Form::close() !!}
                <div id="image_preview" class="row m-t-10 m-b-10"></div>
                <br>
            </div>
        </div>
    </div>
</div>
@endsection
