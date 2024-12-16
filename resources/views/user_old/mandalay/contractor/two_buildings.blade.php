@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="text-center text-white m-0">
                    {{__('lang.room_count_meter_type')}}
                </h4>
            </div>
            <div class="card-body">
                <h5 class="py-2 text-danger text-center ">{{ __('lang.required_msg') }}</h5><br/>
                {!! Form::open(['route' => ['contractor_choose_form_mdy']]) !!}
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="text-info">{{ __('lang.room_count') }} <span class="text-danger f-s-15">&#10039;</span></label>
                            <input type="number" name="room_count" class="form-control" placeholder="{{ __('lang.room_count') }}" id="room" required />
                        </div>
                        {{-- Power Meter --}}
                        <div class="form-group">
                            <label class="text-info">{{ __('lang.power_meter') }}</label>
                            <div class="bg-secondary p-20">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="pMeter10">10 KW</label>
                                        <input type="number" name="pMeter10" class="form-control" placeholder="{{ __('lang.power_meter') }}" id="pMeter10" />
                                    </div>
                                    <div class="col-md-4">
                                        <label for="pMeter20">20 KW</label>
                                        <input type="number" name="pMeter20" class="form-control" placeholder="{{ __('lang.power_meter') }}" id="pMeter20" />
                                    </div>
                                    <div class="col-md-4">
                                        <label for="pMeter30">30 KW</label>
                                        <input type="number" name="pMeter30" class="form-control" placeholder="{{ __('lang.power_meter') }}" id="pMeter30" />
                                    </div>
                                </div>
                                <div class="text-danger text-justify p-10">
                                    <i class="fa fa-hand-o-right"></i>
                                    {{ __('lang.include_number') }}
                                </div>
                            </div>
                        </div>

                        {{-- Normal Meter --}}
                        <div class="form-group">
                            <label class="text-info">{{ __('lang.residential_meter') }}</label>
                            <input type="number" name="meter" class="form-control" placeholder="{{ __('lang.residential_meter') }}" id="residentialMeter" readonly/>
                        </div>

                        {{-- Other Meter --}}
                        <div class="form-group">
                            <label class="text-info">{{ __('lang.other_meter') }}</label>
                            <div class="bg-secondary p-20">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="water_meter" class="text-dark m-l-10">
                                            <input name="water_meter" type="checkbox" class="check" id="flat-checkbox-1" data-checkbox="icheckbox_flat-red">
                                            {{ __('lang.water_meter')}}
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="elevator_meter" class="text-dark m-l-10">
                                            <input name="elevator_meter" type="checkbox" class="check" id="flat-checkbox-1" data-checkbox="icheckbox_flat-red">
                                            {{ __('lang.elevator')}}
                                        </label>
                                    </div>
                                </div>
                                <div class="text-danger text-justify p-10">
                                    <i class="fa fa-hand-o-right"></i>
                                    {{ __('lang.other_meter_notice')}}
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>

            </div>
            <div class="card-footer text-center">
                <a href="{{ route('contract_rule_regulation_mdy') }}" class="col-md-3 waves-effect waves-light btn btn-secondary btn-rounded mb-1">{{ __('lang.cancel') }}</a>
                <button type="submit" class="col-md-3 waves-effect waves-light btn btn-rounded btn-info text-white">{{ __('lang.apply') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    
</div>
@endsection