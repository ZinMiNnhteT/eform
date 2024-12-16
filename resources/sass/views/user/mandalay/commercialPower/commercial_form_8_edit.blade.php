@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="card-title text-center text-white m-0">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                <div class="container">
                {!! Form::open(['route' => 'commercial_electricpower_update_mdy', 'method' => 'PATCH', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form_id, ['id' => 'form_id']) !!}
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">{{ __('lang.applied_electricpower_photo') }}</h4>
                            {!! Form::file('front[]', ['class' => 'cursor-p front', 'accept' => '.jpg,.png', 'id' => 'uploadFile', 'multiple']) !!}
                                
                            <div class="preview-wrapper m-t-10">
                                <div id="image_preview" class="row m-t-10 m-b-10"></div>
                            </div>
                        </div>
                    </div>
                    
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
                
            </div>
            <div class="card-footer text-center">
                <a href="" onclick="event.preventDefault();" class="col-md-3 waves-effect waves-light btn btn-rounded btn-warning btn-remove d-none">{{ __('lang.remove') }}</a>
                <a href="{{ route('commercial_applied_form_mdy', $form->id) }}" class="col-md-3 waves-effect waves-light btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                <button type="submit" class="col-md-3 waves-effect waves-light btn btn-rounded btn-primary" name='submitImage'>{{ __('lang.submit') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
