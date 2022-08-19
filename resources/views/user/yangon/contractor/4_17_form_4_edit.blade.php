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
                    if (count($files) > 0) {
                        foreach ($files as $file) {
                            $form_id = $form->id;
                            $name = $form->serial_code;
                            $data1 = $file->occupy_letter;
                            $data2 = $file->no_invade_letter;
                        }
                    } else {
                        $data1 = $data2 = NULL;
                    }
                    if($data1 == NULL){
                        $required = 'required';
                        $star = '<span class="text-danger f-s-15">&#10039;</span>';
                    }else{
                        $required = '';
                        $star = '';
                    }
                @endphp
                @if($required == 'required')
                    <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5>
                    <br/>
                @endif
                {!! Form::open(['route' => '417_recomm_update_ygn', 'method' => 'PATCH', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id, ['id' => 'form_id']) !!}
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="form-group m-0">
                                <p class="card-title">{{ __('lang.occupy_letter') }}{!! $star !!}</p>
                            </div>
                            <div class="form-group">
                                {!! Form::file('front', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'onchange' => 'readURL(this, "front")', $required]) !!}
                                @if ($data1)
                                {!! Form::hidden('old_front', $data1) !!}
                                @endif
                            </div>

                            <div class="preview-wrapper">
                                <div class="front_preview text-center d-none">
                                    <img id="front_preview" src="" alt="Image Preview" class="img-responsive" />
                                    <p class="m-t-10"><a href="" class="delete_front text-danger">Remove</a></p>
                                </div>
                            </div>
                            @if ($data1)
                            <div class="p-t-20 text-center">
                                <img src="{{ asset('storage/user_attachments/'.$form_id.'/'.$data1) }}" alt="{{ $data1 }}"  width="175"  class="img-responsive">
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-0">
                                <p class="card-title">{{ __('lang.noinvade_letter') }} {!! $star !!}</p>
                            </div>
                            <div class="form-group">
                                {!! Form::file('back', ['class' => 'cursor-p back', 'accept' => '.jpg,.png', 'onchange' => 'readURL(this, "back")', $required]) !!}
                                @if ($data2)
                                {!! Form::hidden('old_back', $data2) !!}
                                @endif
                            </div>

                            <div class="preview-wrapper">
                                <div class="back_preview text-center d-none">
                                    <img id="back_preview" src="" alt="Image Preview" class="img-responsive" />
                                    <p class="m-t-10"><a href="" class="delete_back text-danger">Remove</a></p>
                                </div>
                            </div>
                            @if ($data2)
                            <div class="p-t-20 text-center">
                                <img src="{{ asset('storage/user_attachments/'.$form_id.'/'.$data2) }}" alt="{{ $data2 }}"  width="175" class="img-responsive">
                            </div>
                            @endif
                        </div>
                    </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('contractor_applied_form_ygn', $form->id) }}" class="col-md-3 waves-effect waves-light btn btn-secondary btn-rounded">{{ __('lang.cancel') }}</a>
                <button type="submit" class="col-md-3 waves-effect waves-light btn btn-primary btn-rounded">{{ __('lang.submit') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
