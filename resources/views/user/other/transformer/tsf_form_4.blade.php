@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="card-title text-center text-white">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                {!! Form::open(['route' => 'tsf_form10_store', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id) !!}
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        
                        <div class="form-group m-0">
                            <h4 class="card-title ">{{ __('lang.form10_front') }}</h4>
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
                    <div class="col-6">
                        <div class="form-group m-0">
                            <h4 class="card-title ">{{ __('lang.form10_back') }}</h4>
                        </div>
                        <div class="form-group">
                            {!! Form::file('back', ['class' => 'cursor-p back', 'accept' => '.jpg,.png', 'onchange' => 'readURL(this, "back")']) !!}
                        </div>

                        <div class="preview-wrapper">
                            <div class="back_preview text-center d-none">
                                <img id="back_preview" src="" alt="Image Preview" class="img-responsive" />
                                <p class="m-t-10"><a href="" class="delete_back text-danger">Remove</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group alert alert-danger m-t-20">
                            <p class="card-title text-danger font-weight-bold"><i class="fa fa-certificate"></i> {{ __('ဘာသာ/သာသနာအတွက် ဖြစ်ပါက ဆက်လက်လုပ်ဆောင်မည်ကို နှိပ်ပါ။') }}</p>
                        </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('all_meter_forms') }}" class="col-3 btn btn-secondary btn-rounded ">{{ __('lang.cancel') }}</a>
                <button type="submit" class="col-3 btn btn-primary btn-rounded ">{{ __('lang.submit') }}</button>
                <a href="{{ route('tsf_recomm_create', $form_id) }}" class="col-3 btn btn-info btn-rounded ">{{ __('lang.continue') }}</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
