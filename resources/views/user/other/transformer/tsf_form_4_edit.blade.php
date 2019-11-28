@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="card-title text-center text-white">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                @php
                    if (count($files) > 0) {
                        foreach ($files as $file) {
                            $form_id = $form->id;
                            $name = $form->serial_code;
                            $data1 = $file->form_10_front;
                            if ($file->form_10_back) {
                                $data2 = $file->form_10_back;
                            } else {
                                $data2 = null;
                            }
                        }
                    } else {
                        $data1 = $data2 = NULL;
                    }
                @endphp
                {!! Form::open(['route' => ['tsf_form10_update'], 'method' => 'PATCH', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id) !!}
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-group m-0">
                            <p class="card-title ">{{ __('lang.form10_front') }}</p>
                        </div>
                        <div class="form-group">
                            {!! Form::file('front', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'onchange' => 'readURL(this, "front")']) !!}
                            @if ($data1)
                            {!! Form::hidden('old_front', $data1) !!}
                            <div class="p-t-20 text-center">
                                <img src="{{ asset('storage/user_attachments/'.$form_id.'/'.$data1) }}" alt="{{ $data1 }}"  width="175" height="150" class="img-responsive">
                            </div>
                            @endif
                        </div>
                        <div class="preview-wrapper">
                            <div class="front_preview text-center d-none">
                                <img id="front_preview" src="" alt="Image Preview" class="img-responsive" />
                                <p class="m-t-10"><a href="" class="delete_front text-danger">Remove</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group m-0">
                            <p class="card-title ">{{ __('lang.form10_back') }}</p>
                        </div>
                        <div class="form-group">
                            {!! Form::file('back', ['class' => 'cursor-p back', 'accept' => '.jpg,.png', 'onchange' => 'readURL(this, "back")']) !!}
                            @if ($data2)
                            {!! Form::hidden('old_back', $data2, ['id' => 'old_back']) !!}
                            <div class="p-t-20 text-center preview_old_back">
                                <img src="{{ asset('storage/user_attachments/'.$form_id.'/'.$data2) }}" alt="{{ $data2 }}"  width="175" height="150" class="img-responsive">
                                <p class="text-muted ">{{ __('lang.prve_photo') }}</p>
                                <p class="m-t-10"><a href="" class="delete_old_back text-danger" data-id="{{ $form_id }}">Remove</a></p>
                            </div>
                            @endif
                        </div>
                        <div class="preview-wrapper">
                            <div class="back_preview text-center d-none">
                                <img id="back_preview" src="" alt="Image Preview" class="img-responsive" />
                                <p class="m-t-10"><a href="" class="delete_back text-danger">Remove</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('tsf_applied_form', $form_id) }}" class="col-3 waves-effect waves-light btn btn-secondary btn-rounded ">{{ __('lang.cancel') }}</a>
                <button type="submit" class="col-3 waves-effect waves-light btn btn-primary btn-rounded ">{{ __('lang.submit') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
