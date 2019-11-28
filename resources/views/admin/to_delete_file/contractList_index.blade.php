@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title m-0 {{ lang() }}">{{ __('lang.residential') }} {{ __('lang.meter') }} {{ __('lang.'.$heading) }}</h5>
            </div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ __('lang.'.session('status')) }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">#</th>
                                <th class="{{ lang() }}">{{ __('lang.name') }}</th>
                                <th class="{{ lang() }}">{{ __('lang.serial') }}</th>
                                <th class="{{ lang() }}">{{ __('lang.township') }}</th>
                                <th class="{{ lang() }}">{{ __('lang.district') }}</th>
                                <th class="{{ lang() }}">{{ __('lang.div_state') }}</th>
                                <th class="text-center {{ lang() }}">{{ __('lang.date') }}</th>
                                <th class="{{ lang() }}">{{ __('lang.status') }}</th>
                                @if (hasPermissions(['residentialContract-create', 'residentialContract-show']))
                                <th class="text-center {{ lang() }}">{{ __('lang.actions') }}</th>
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
                                <td class="align-middle {{ checkMM() }}">{{ $data->fullname }}</td>
                                <td class="align-middle">{{ $data->serial_code }}</td>
                                <td class="align-middle {{ checkMM() }}">{{ township($data->township_id) }}</td>
                                <td class="align-middle {{ checkMM() }}">{{ district($data->district_id) }}</td>
                                <td class="align-middle {{ checkMM() }}">{{ div_state($data->div_state_id) }}</td>
                                <td class="align-middle text-center {{ checkMM() }}">
                                    {{ user_paid_date($data->id) }}
                                </td>
                                <td class="align-middle {{ lang() }} {{ chk_userForm($data->id)['color'] }}">
                                    {{ __('lang.'.chk_userForm($data->id)['msg']) }}
                                </td>

                                @if (hasPermissions(['residentialContract-create', 'residentialContract-show']))
                                <td class="text-center">
                                    
                                    @if (chk_userForm($data->id)['to_contract'])
                                        @if (hasPermissions(['residentialContract-create']))
                                    <a href="{{ route('residentialMeterContractList.create', $data->id) }}" class="btn btn-warning" data-toggle="tooltip" data-title="To Contract">
                                        <i class="fa fa-pencil-square-o fa-fw"></i>
                                    </a>
                                        @endif
                                    @endif
                                    
                                    @if (hasPermissions(['residentialContract-show']))
                                    <a href="{{ route('residentialMeterContractList.show', $data->id) }}" class="btn btn-info" data-toggle="tooltip" data-title="View"><i class="fa fa-search fa-fw"></i></a>
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