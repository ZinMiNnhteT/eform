@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('transformerRegisterMeterList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>

            <div class="card-body mm">
                

                {!! Form::open(['route' => 'transformerInstallationDoneList.store', 'files' => true]) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                <div class="container">
                    <div class="row form-group mb-1">
                        <label for="serial" class="control-label l-h-35 text-md-right col-md-3">လျှောက်လွှာအမှတ်</label>
                        <div class="col-md-7">
                            {!! Form::text('serial', $form->serial_code, ['id' => 'serial', 'class' => 'form-control inner-form', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="fullname" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.fullname') }}</label>
                        <div class="col-md-7">
                            {!! Form::text('fullname', $form->fullname, ['id' => 'fullname', 'class' => 'form-control inner-form', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="front" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.attach_files') }}</label>
                        <div class="col-md-7">
                            <input type="file" name="front[]" class="form-control" id="front" accept=".png,.jpg,.pdf" multiple required>
                        </div>
                    </div>
                    <div class="row form-group mb-1">
                        <label for="ei_remark" class="control-label l-h-35 text-md-right col-md-3">{{ __('lang.remark') }}</label>
                        <div class="col-md-7">
                            <textarea name="ei_remark" class="form-control inner-form" id="ei_remark" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <a href="{{ route('transformerRegisterMeterList.index') }}" class="btn btn-rounded btn-secondary">{{ __('lang.cancel') }}</a>
                    <input type="submit" name="ei_submit" value="{{ __('lang.submit') }}" class="btn btn-rounded btn-info">
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>

@endsection