@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title m-0">{{ __('lang.residential') }} {{ __('lang.power') }} {{ __('lang.meter') }} {{ __('lang.'.$heading) }}</h5>
            </div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ __('lang.'.session('status')) }}
                    </div>
                @endif

                {!! Form::open(['route' => 'residentialPowerMeterRegisterMeterList.index', 'method' => 'get']) !!}
                <div class="row mb-3">
                    <div class="col-md-2">
                        <input type="text" name="serial" value="" placeholder="{{__('lang.serial')}}" id="serial" class="form-control inner-form">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="name" value="" placeholder="{{__('lang.name')}}" id="name" class="form-control inner-form">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-rounded btn-info"><i class="fa fa-search"></i></button>
                        <button type="reset" class="btn btn-rounded btn-danger"><i class="fa fa-ban text-white"></i></button>
                        {{--  <button type="reset" class="btn btn-rounded btn-warning"><i class="fa fa-refresh text-white"></i></button>  --}}
                        <a href="{{ route('residentialPowerMeterRegisterMeterList.index') }}" class="btn btn-rounded btn-warning"><i class="fa fa-refresh text-white"></i></a>
                    </div>
                </div>
                {!! Form::close() !!}

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">#</th>
                                <th>{{ __('lang.serial') }}</th>
                                <th>{{ __('lang.name') }}</th>
                                <th>{{ __('lang.township') }}</th>
                                <th>{{ __('lang.district') }}</th>
                                <th>{{ __('lang.div_state') }}</th>
                                <th class="text-center">{{ __('lang.date') }}</th>
                                <th>{{ __('lang.status') }}</th>
                                @if (hasPermissions(['residentialPowerRegisteredMeter-create', 'residentialPowerRegisteredMeter-show']))
                                <th class="text-center">{{ __('lang.actions') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        
                        @if ($form->count() > 0)
                        @foreach ($form as $data)

                            {{--  chk same div/state  --}}
                            @if (admin()->div_state == $data->div_state_id || admin()->group_lvl <= 1)

                            @if (chk_send($data->id)) {{--  chk user send already  --}}
                            <tr>
                                <td class="align-middle text-center">{{ checkMM() == 'mm' ? mmNum(++$i) : (++$i) }}</td>
                                <td class="align-middle text-danger">{{ $data->serial_code }}</td>
                                <td class="align-middle">{{ $data->fullname }}</td>
                                <td class="align-middle">{{ township($data->township_id) }}</td>
                                <td class="align-middle">{{ district($data->district_id) }}</td>
                                <td class="align-middle">{{ div_state($data->div_state_id) }}</td>
                                <td class="align-middle text-center">
                                    {{ install_accepted_date($data->id) }}
                                </td>
                                <td class="align-middle {{ chk_userForm($data->id)['color'] }}">
                                    {{ __('lang.'.chk_userForm($data->id)['msg']) }}
                                </td>

                                @if (hasPermissions(['residentialPowerRegisteredMeter-create', 'residentialPowerRegisteredMeter-show']))
                                <td class="text-center">
                                    @if (hasPermissions(['residentialPowerRegisteredMeter-show']))
                                    <a href="{{ route('residentialPowerMeterRegisterMeterList.show', $data->id) }}" class="btn btn-{{ chk_userForm($data->id)['to_register'] ? 'warning' : 'info' }} btn-sm btn-rounded" data-toggle="tooltip" data-title="View"><i class="fa fa-search fa-fw"></i></a>
                                    @endif
                                </td>
                                @endif

                            </tr>
                            @endif {{--  end chk user send already  --}}

                            @endif
                            {{--  end chk same div/state  --}}

                        @endforeach
                        @else
                            <tr class="text-center">
                                <td colspan="7">{{ 'There is nothing to show!' }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection