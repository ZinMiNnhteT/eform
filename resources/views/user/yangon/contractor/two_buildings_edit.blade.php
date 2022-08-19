@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="text-center text-white m-0">
                    {{__('lang.room_count_meter_type')}}
                </h4>
            </div>
            <div class="card-body">
                
                {!! Form::open(['route' => ['contract_building_room_update_ygn'], 'method' => 'PATCH', 'files' => true]) !!}
                {!! Form::hidden('form_id', $c_form->application_form_id) !!}
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-info">{{ __('lang.apartment_count') }} <span class="text-danger f-s-15">&#10039;</span></label>
                                    <input type="number" value="{{$c_form->apartment_count}}" name="apartment_count" class="form-control" placeholder="{{ __('lang.apartment_count') }}" id="apartment_count" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="text-info">{{ __('lang.floor_count') }} <span class="text-danger f-s-15">&#10039;</span></label>
                                    <input type="number" value="{{$c_form->floor_count}}" name="floor_count" class="form-control" placeholder="{{ __('lang.floor_count') }}" id="floor_count" required />
                                </div>
                            </div>
                        </div>

                        {{-- အခန်းအရေအတွက် --}}
                        <input type="hidden" value="{{$c_form->room_count}}" name="room_count" class="form-control" placeholder="Number of Rooms" id="room" required/>

                        {{-- Power Meter --}}
                        <div class="form-group">
                            <label class="text-info">{{ __('lang.power_meter') }}</label>
                            <div class="bg-secondary p-20">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="pMeter10">10 KW</label>
                                        <input type="number" value="{{$c_form->pMeter10}}" name="pMeter10" class="form-control" placeholder="Number of Power Meter" id="pMeter10" />
                                    </div>
                                    <div class="col-md-4">
                                        <label for="pMeter20">20 KW</label>
                                        <input type="number" value="{{$c_form->pMeter20}}" name="pMeter20" class="form-control" placeholder="Number of Power Meter" id="pMeter20" />
                                    </div>
                                    <div class="col-md-4">
                                        <label for="pMeter30">30 KW</label>
                                        <input type="number" value="{{$c_form->pMeter30}}" name="pMeter30" class="form-control" placeholder="Number of Power Meter" id="pMeter30" />
                                    </div>
                                </div>
                                <div class="text-danger text-justify p-10">
                                    <i class="fa fa-hand-o-right"></i>
                                    ပါဝါမီတာ ထည့်သွင်းလျှောက်ထားလိုလျှင် မိမိလျှောက်ထားလိုသော မီတာအမျိုးအစားတွင် အရေအတွက် ထည့်သွင်းပေးပါရန်
                                </div>
                            </div>
                        </div>

                        {{-- Normal Meter --}}
                        <div class="form-group">
                            <label class="text-info">{{ __('lang.residential_meter') }}</label>
                            <input type="number" value="{{$c_form->meter}}" name="meter" class="form-control" placeholder="Number of residential meters" id="residentialMeter" readonly/>
                        </div>

                        {{-- Other Meter --}}
                        <div class="form-group">
                            <label class="text-info">{{ __('lang.other_meter') }}</label>
                            <div class="bg-secondary p-20">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="water_meter" class="text-dark m-l-10">
                                            <input <?php if ($c_form->water_meter): echo "checked"; endif ?> name="water_meter" type="checkbox" class="check" id="flat-checkbox-1" data-checkbox="icheckbox_flat-red">
                                            {{ __('lang.water_meter')}}
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="elevator_meter" class="text-dark m-l-10">
                                            <input <?php if ($c_form->elevator_meter): echo "checked"; endif ?> name="elevator_meter" type="checkbox" class="check" id="flat-checkbox-1" data-checkbox="icheckbox_flat-red">
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
                <a href="{{ route('contractor_applied_form_ygn',$c_form->application_form_id) }}" class="col-md-3 waves-effect waves-light btn btn-secondary btn-rounded mb-1">{{ __('lang.cancel') }}</a>
                <button type="submit" class="col-md-3 waves-effect waves-light btn btn-rounded btn-primary text-white">{{ __('lang.edit') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    
</div>
@endsection