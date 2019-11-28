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

                {!! Form::open(['route' => 'contractorMeterGroundCheckDoneList.index', 'method' => 'get']) !!}
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
                        <a href="{{ route('contractorMeterGroundCheckDoneList.index') }}" class="btn btn-rounded btn-warning"><i class="fa fa-refresh text-white"></i></a>
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
                                <th class="text-center">{{ __('lang.survey_date') }}</th>
                                <th>{{ __('lang.status') }}</th>
                                @if (hasPermissions(['contractorDivStateChkGrd-create', 'contractorDivStateChkGrd-show']))
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
                                    {{ survey_accepted_date($data->id) }}
                                </td>

                                <td class="align-middle text-{{ chk_resend($data->id)['type'] == 'resend' ? 'danger' : 'info' }}" width="20%">
                                    @if (chk_resend($data->id)['type'] == 'resend')
                                        {{ 'ပြန်လည်စစ်ဆေးရန်' }}
                                    @else
                                        {{ __('lang.'.chk_userForm($data->id)['msg']) }}
                                    @endif
                                </td>

                                @if (hasPermissions(['contractorDivStateChkGrd-create', 'contractorDivStateChkGrd-show']))
                                <td class="text-center">
                                    @if (hasPermissions(['contractorDivStateChkGrd-show']))
                                    <a href="{{ route('contractorMeterGroundCheckDoneListByDivisionState.show', $data->id) }}" class="btn btn-{{ (chk_userForm($data->id)['to_confirm_div_state'] || chk_userForm($data->id)['to_dist_approve']) ? 'warning' : 'info' }} btn-rounded btn-sm" data-toggle="tooltip" data-title="View"><i class="fa fa-search fa-fw"></i></a>
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