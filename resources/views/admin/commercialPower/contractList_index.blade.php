@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title m-0">{{ __('lang.commercial') }} {{ __('lang.power') }} {{ __('lang.meter') }} {{ __('lang.'.$heading) }}</h5>
            </div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ __('lang.'.session('status')) }}
                    </div>
                @endif

                {!! Form::open(['route' => 'commercialPowerMeterContractList.index', 'method' => 'get']) !!}
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
                        <a href="{{ route('commercialPowerMeterContractList.index') }}" class="btn btn-rounded btn-warning"><i class="fa fa-refresh text-white"></i></a>
                    </div>
                </div>
                {!! Form::close() !!}

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">#</th>
                                <th>{{ __('lang.name') }}</th>
                                <th>{{ __('lang.serial') }}</th>
                                <th>{{ __('lang.township') }}</th>
                                <th>{{ __('lang.district') }}</th>
                                <th>{{ __('lang.div_state') }}</th>
                                <th class="text-center">{{ __('lang.date') }}</th>
                                <th>{{ __('lang.status') }}</th>
                                @if (hasPermissions(['commercialPowerContract-create', 'commercialPowerContract-show']))
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
                                <td class="align-middle">{{ $data->fullname }}</td>
                                <td class="align-middle">{{ $data->serial_code }}</td>
                                <td class="align-middle">{{ township($data->township_id) }}</td>
                                <td class="align-middle">{{ district($data->district_id) }}</td>
                                <td class="align-middle">{{ div_state($data->div_state_id) }}</td>
                                <td class="align-middle text-center">
                                    {{ checkMM() == 'mm' ? mmMonth(date('m', strtotime($data->created_at))).' '.
                                    mmNum(date('d', strtotime($data->created_at))).', '.
                                    mmNum(date('y', strtotime($data->created_at))) : date('M d, y', strtotime($data->created_at)) }}
                                </td>
                                <td class="align-middle {{ chk_userForm($data->id)['color'] }}">
                                    {{ chk_userForm($data->id)['msg'] }}
                                </td>

                                @if (hasPermissions(['commercialPowerContract-create', 'commercialPowerContract-show']))
                                <td class="text-center">
                                    
                                    @if (chk_userForm($data->id)['to_contract'])
                                        @if (hasPermissions(['commercialPowerContract-create']))
                                    <a href="{{ route('commercialPowerMeterContractList.create', $data->id) }}" class="btn btn-warning" data-toggle="tooltip" data-title="To Contract">
                                        <i class="fa fa-pencil-square-o fa-fw"></i>
                                    </a>
                                        @endif
                                    @endif
                                    
                                    @if (hasPermissions(['commercialPowerContract-show']))
                                    <a href="{{ route('commercialPowerMeterContractList.show', $data->id) }}" class="btn btn-info" data-toggle="tooltip" data-title="View"><i class="fa fa-search fa-fw"></i></a>
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