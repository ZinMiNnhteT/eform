@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title m-0">{{ __('lang.contractor') }} {{ __('lang.meter') }} {{ __('lang.'.$heading) }}</h5>
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
                                <th class="text-center">{{ __('lang.send_date') }}</th>
                                <th>{{ __('lang.status') }}</th>
                                @if (hasPermissions(['residentApplication-create', 'residentApplication-show']))
                                <th class="text-center">{{ __('lang.actions') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @if ($form->count() > 0)
                        @foreach ($form as $data)

                            {{--  chk same div/state | same district | same township | system --}}
                            @if ((admin()->div_state == $data->div_state_id && admin()->district == $data->district_id && admin()->township == $data->township_id) || admin()->group_lvl <= 1)

                            @if (chk_send($data->id)) {{--  chk user send already  --}}
                            <tr>
                                <td class="align-middle text-center">{{ checkMM() == 'mm' ? mmNum(++$i) : (++$i) }}</td>
                                <td class="align-middle">{{ $data->fullname }}</td>
                                <td class="align-middle">{{ $data->serial_code }}</td>
                                <td class="align-middle">{{ township($data->township_id) }}</td>
                                <td class="align-middle">{{ district($data->district_id) }}</td>
                                <td class="align-middle">{{ div_state($data->div_state_id) }}</td>
                                <td class="align-middle text-center">
                                    {{ sent_date($data->id) }}
                                </td>
                                <td class="align-middle {{ chk_userForm($data->id)['color'] }}">
                                    {{ __('lang.'.chk_userForm($data->id)['msg']) }}
                                </td>

                                @if (hasPermissions(['residentApplication-show']))
                                <td class="text-center align-middle">
                                    <a href="{{ route('contractorMeterApplicationList.show', $data->id) }}" class="btn btn-rounded btn-sm btn-{{ chk_userForm($data->id)['to_confirm'] ? 'warning' : 'info' }}" data-toggle="tooltip" data-title="View"><i class="fa fa-search fa-fw"></i></a>
                                </td>
                                @endif

                            </tr>
                            @endif {{--  end chk user send already  --}}

                            @endif
                            {{--  end chk same div/state  --}}

                        @endforeach
                        @else
                            <tr class="text-center">
                                <td colspan="9">{{ 'There is nothing to show!' }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{--  <div class="col-lg-3 m-b-30">
    <div data-label="10%" class="css-bar css-bar-10"></div>
</div>  --}}
@endsection