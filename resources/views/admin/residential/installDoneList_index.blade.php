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
                                <th>{{ __('lang.name') }}</th>
                                <th>{{ __('lang.serial') }}</th>
                                <th>{{ __('lang.township') }}</th>
                                <th>{{ __('lang.district') }}</th>
                                <th>{{ __('lang.div_state') }}</th>
                                <th class="text-center {{ lang() }}">{{ __('lang.date') }}</th>
                                <th>{{ __('lang.status') }}</th>
                                @if (hasPermissions(['residentialInstallDone-create', 'residentialInstallDone-show']))
                                <th class="text-center {{ lang() }}">{{ __('lang.actions') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        
                        @if ($form->count() > 0)
                        @foreach ($form as $data)

                            @if (chk_send($data->id)) {{--  chk user send already  --}}

                            @if (check_div_dist_town($data->div_state_id, $data->district_id, $data->township_id) || admin()->group_lvl <= 2) {{--  chk permissions  --}}
                            <tr>
                                <td class="align-middle text-center">{{ checkMM() == 'mm' ? mmNum(++$i) : (++$i) }}</td>
                                <td class="align-middle {{ checkMM() }}">{{ $data->fullname }}</td>
                                <td class="align-middle">{{ $data->serial_code }}</td>
                                <td class="align-middle {{ checkMM() }}">{{ township($data->township_id) }}</td>
                                <td class="align-middle {{ checkMM() }}">{{ district($data->district_id) }}</td>
                                <td class="align-middle {{ checkMM() }}">{{ div_state($data->div_state_id) }}</td>
                                <td class="align-middle text-center {{ checkMM() }}">
                                    {{ contracted_date($data->id) }}
                                </td>
                                <td class="align-middle {{ lang() }} {{ chk_userForm($data->id)['color'] }}">
                                    {{ __('lang.'.chk_userForm($data->id)['msg']) }}
                                </td>

                                @if (hasPermissions(['residentialInstallDone-create', 'residentialInstallDone-show']))
                                <td class="text-center">
                                    
                                    @if (hasPermissions(['residentialInstallDone-show']))
                                    <a href="{{ route('residentialMeterInstallationDoneList.show', $data->id) }}" class="btn btn-{{ chk_userForm($data->id)['to_confirm_install'] ? 'warning' : 'info' }}" data-toggle="tooltip" data-title="View"><i class="fa fa-search fa-fw"></i></a>
                                    @endif
                                </td>
                                @endif

                            </tr>
                            @endif {{--  end chk same div/state  --}}
                            
                            @endif {{--  end chk user send already  --}}

                        @endforeach
                        @else
                            <tr class="text-center">
                                <td colspan="7">{{ 'There is nothing to show!' }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="pull-right m-b-30">
                    {{ $form->links() }}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection