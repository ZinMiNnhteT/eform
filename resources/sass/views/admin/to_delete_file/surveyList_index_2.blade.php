@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title m-0 {{ lang() }}">{{ __('lang.residential') }} {{ __('lang.power') }} {{ __('lang.meter') }} {{ __('lang.'.$heading) }}</h5>
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
                                <th class="text-center {{ lang() }}">{{ __('lang.form_accepted_date') }}</th>
                                <th class="{{ lang() }}">{{ __('lang.status') }}</th>
                                @if (hasPermissions(['residentialGrdChk-create', 'residentialGrdChk-show']))
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
                                <td class="text-center">{{ checkMM() == 'mm' ? mmNum(++$i) : (++$i) }}</td>
                                <td class="align-middle {{ checkMM() }}">{{ $data->fullname }}</td>
                                <td class="align-middle">{{ $data->serial_code }}</td>
                                <td class="align-middle {{ checkMM() }}">{{ township($data->township_id) }}</td>
                                <td class="align-middle {{ checkMM() }}">{{ district($data->district_id) }}</td>
                                <td class="align-middle {{ checkMM() }}">{{ div_state($data->div_state_id) }}</td>
                                <td class="align-middle text-center {{ checkMM() }}">
                                    {{ accepted_date($data->id) }}
                                </td>
                                <td class="align-middle {{ lang() }} {{ chk_userForm($data->id)['color'] }}">
                                    @if(hasSurvey($data->id))
                                        {{ __('lang.'.chk_userForm($data->id)['msg']) }}
                                    @else
                                        {{ __('lang.choose_engineer') }}
                                    @endif
                                </td>

                                @if (hasPermissions(['residentialGrdChk-create', 'residentialGrdChk-show']))
                                <td class="text-center">
                                    @if(hasSurvey($data->id))
                                    {{--  @if(Auth::user()->id==hasSurvey($data->id)->survey_engineer)  --}}
                                    <a href="{{ route('residentialMeterGroundCheckList.create', $data->id) }}" class="btn btn-warning" data-toggle="tooltip" data-title="To Fill Survey Result">
                                        <i class="fa fa-pencil-square-o fa-fw"></i>
                                    </a>
                                    {{--  @endif  --}}
                                    @else
                                    @if (chk_userForm($data->id)['to_survey'])
                                    @if (hasPermissionsAndGroupLvl(['residentialGrdChk-create'],admin()->group_lvl)) {{--  if login-user is from township  --}}


                                    <a href="{{ route('residentialMeterGroundCheckChoose.create', $data->id) }}" class="btn btn-warning" data-toggle="tooltip" data-title="To Choose Engineer">
                                        <i class="fa fa-pencil-square-o fa-fw"></i>
                                    </a>
                                    @endif
                                    @endif
                                    @endif
                                    
                                    @if (hasPermissions(['residentialGrdChk-show']))
                                    <a href="{{ route('residentialPowerMeterGroundCheckList.show', $data->id) }}" class="btn btn-info" data-toggle="tooltip" data-title="View"><i class="fa fa-search fa-fw"></i></a>
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