@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title m-0">{{ __('lang.residential') }} {{ __('lang.meter') }} {{ __('lang.'.$heading) }}</h5>
            </div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ __('lang.'.session('status')) }}
                    </div>
                @endif

                {!! Form::open(['route' => 'residentialMeterGroundCheckList.index', 'method' => 'get']) !!}
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
                        <a href="{{ route('residentialMeterGroundCheckList.index') }}" class="btn btn-rounded btn-warning"><i class="fa fa-refresh text-white"></i></a>
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
                                <th class="text-center">{{ __('lang.form_accepted_date') }}</th>
                                <th>{{ __('lang.status') }}</th>
                                @if (hasPermissions(['residentialGrdChk-create', 'residentialGrdChk-show']))
                                <th class="text-center">{{ __('lang.actions') }}</th>
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
                                <td class="align-middle text-danger">{{ $data->serial_code }}</td>
                                <td class="align-middle">{{ $data->fullname }}</td>
                                <td class="align-middle">{{ township($data->township_id) }}</td>
                                <td class="align-middle">{{ district($data->district_id) }}</td>
                                <td class="align-middle">{{ div_state($data->div_state_id) }}</td>
                                <td class="align-middle text-center">
                                    {{ accepted_date($data->id) }}
                                </td>
                                <td class="align-middle {{ chk_userForm($data->id)['color'] }}">
                                    @if(hasSurvey($data->id))
                                        {{ __('lang.'.chk_userForm($data->id)['msg']) }}
                                    @else
                                        {{ __('lang.choose_engineer') }}
                                    @endif
                                </td>

                                @if (hasPermissions(['residentialGrdChk-create', 'residentialGrdChk-show']))
                                <td class="text-center">
                                    @if (hasPermissions(['residentialGrdChk-show']))
                                    <a href="{{ route('residentialMeterGroundCheckList.show', $data->id) }}" class="waves-effect waves-light btn btn-{{ chk_userForm($data->id)['to_survey'] ? 'warning' : 'info' }} btn-rounded btn-sm" data-toggle="tooltip" data-title="View"><i class="fa fa-search fa-fw"></i></a>
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