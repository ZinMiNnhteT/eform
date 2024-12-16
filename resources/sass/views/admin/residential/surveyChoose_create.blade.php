@extends('layouts.admin_app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex">
                <h5 class="card-title m-0 {{ lang() }}">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('residentialMeterGroundCheckList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5 {{ lang() }}"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>

            <div class="card-body">
                <h3 class="text-center {{ lang() }}">{{ __('lang.residentSurvey') }} ({{ div_state($form->div_state_id) }}{{ checkMM() == 'mm' ? '၊' : ',' }} {{ district($form->district_id) }})</h3>

                {!! Form::open(['route' => 'residentialMeterGroundCheckChoose.store']) !!}
                {!! Form::hidden('form_id', $form->id) !!}
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-group p-20">
                            <label for="engineer_id" class="text-info">
                                {{ __('lang.eng_choose') }}
                            </label>
                            <select name="engineer_id" id="engineer_name" class="form-control inner-form {{ checkMM() }}" required>
                                    <option value="">{{ __('lang.choose1') }}</option>
                                    {{--  @foreach ($engineerLists as $list)  --}}
                                    {{--  @if($list->hasRole('JuniorEngineer(Township)'))  --}}
                                    {{--  <option value="{{ $list->id }}">{{ checkMM() == 'mm' ? $list->name : $list->name }}</option>  --}}
                                    {{--  @endif  --}}
                                    {{--  @endforeach  --}}
                                    <option value="4">{{ 'အင်ယာ၁' }}</option>
                                    <option value="6">{{ 'အင်ယာ၂' }}</option>
                                    <option value="7">{{ 'အင်ယာ၃' }}</option>
                                </select>
                        </div>
                    </div>
                    
                </div>
                <div class="text-center">
                    <a href="{{ route('residentialMeterGroundCheckList.index') }}" class="btn btn-rounded btn-secondary {{ lang() }}">@lang('lang.cancel')</a>
                    <input type="submit" name="survey_submit" value="@lang('lang.choose')" class="btn btn-rounded btn-info {{ lang() }}">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection