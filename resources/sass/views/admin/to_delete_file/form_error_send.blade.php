@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }} {{ __('lang.form') }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('transformerApplicationList.show', $form_id) }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body">

                {!! Form::open(['url' => 'residentialMeterFormErrorSend']) !!}
                <div class="row justify-content-center form-group">
                    <div class="col-md-8">
                        <label for="remark" class="text-info mt-3 mb-2">{{ __('lang.remark') }} :</label>
                        {!! Form::textarea('remark', null, ['class' => 'textarea_editor form-control', 'required']) !!}
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <a href="{{ route('transformerApplicationList.show', $form_id) }}" class="btn btn-block btn-rounded btn-secondary">{{ __("lang.cancel") }}</a>
                    </div>
                    <div class="col-md-3">
                        {!! Form::hidden('form_id', $form_id) !!}
                        <input type="submit" name="reject_submit" value="{{ __('lang.resend') }}" class="btn btn-block btn-rounded btn-danger">
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>
@endsection
