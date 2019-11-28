@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="card-title text-center text-white">{{ __('lang.'.$heading) }}</h5>
            </div>
            <div class="card-body">
                <div class="container">
                {!! Form::open(['route' => 'tsf_electricpower_update', 'method' => 'PATCH', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id, ['id' => 'form_id']) !!}
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">{{ __('lang.dc_recomm') }}</h4>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            {!! Form::file('front[]', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'id' => 'uploadFile', 'multiple']) !!}
                            <p class="px-1 py-1 text-danger">{{ __('lang.owner_photo_msg') }}</p>
                        </div>
                    </div>
                <div class="preview-wrapper">
                    <div id="image_preview" class="row m-t-10 m-b-10"></div>
                </div>
                @if ($files->count() > 0)
                    @foreach ($files as $file)
                        @if ($file->electric_power)
                            @php $data = explode(',', $file->electric_power); @endphp
                            @foreach ($data as $item)
                <div class="row m-t-10 m-b-10">
                    <div class="col-2 text-center">
                        <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$item) }}" alt="{{ $item }}"  width="175" height="150" alt="" class="img-thumbnail custom-img-thumbnail">
                    </div>
                </div>
                            @endforeach
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="" onclick="event.preventDefault();" class="col-3 waves-effect waves-light btn btn-rounded btn-warning btn-remove d-none">{{ __('lang.remove') }}</a>
            <a href="{{ route('tsf_applied_form', $form->id) }}" class="col-3 waves-effect waves-light btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
            <button type="submit" class="col-3 waves-effect waves-light btn btn-rounded btn-primary" name='submitImage'>{{ __('lang.submit') }}</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
