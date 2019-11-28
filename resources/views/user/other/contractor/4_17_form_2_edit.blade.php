@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="card-title text-center text-white">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                <br/>
                @php
                    if (count($files) > 0) {
                        foreach ($files as $file) {
                            $form_id = $form->id;
                            $name = $form->serial_code;
                            $data1 = $file->nrc_copy_front;
                            $data2 = $file->nrc_copy_back;
                        }
                    } else {
                        $data1 = $data2 = NULL;
                    }
                @endphp
                {!! Form::open(['route' => '417_nrc_update', 'method' => 'PATCH', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id) !!}
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-group m-0">
                            <p class="card-title">{{ __('lang.nrc_front') }}</p>
                        </div>
                        <div class="form-group">
                            {!! Form::file('front', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'onchange' => 'readURL(this, "front")']) !!}
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
                            <img src="{{ asset('storage/user_attachments/'.$form_id.'/'.$data1) }}" alt="{{ $data1 }}"  width="175" height="150" class="img-responsive">
                        </div>
                        @endif
                    </div>
                    <div class="col-6">
                        <div class="form-group m-0">
                            <p class="card-title">{{ __('lang.nrc_back') }}</p>
                        </div>
                        <div class="form-group">
                            {!! Form::file('back', ['class' => 'cursor-p back', 'accept' => '.jpg,.png', 'onchange' => 'readURL(this, "back")']) !!}
                            @if ($data1)
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
                            <img src="{{ asset('storage/user_attachments/'.$form_id.'/'.$data2) }}" alt="{{ $data2 }}"  width="175" height="150" class="img-responsive">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('contractor_applied_form', $form->id) }}" class="col-3 waves-effect waves-light btn btn-secondary btn-rounded">{{ __('lang.cancel') }}</a>
                <button type="submit" class="col-3 waves-effect waves-light btn btn-primary btn-rounded">{{ __('lang.submit') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
