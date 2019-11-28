@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title m-0 ">{{ __('lang.'.$heading) }}</h5>
            </div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ __('lang.'.session('status')) }}
                    </div>
                @endif

                {!! Form::open(['route' => 'pending_form.index','method'=>'get']) !!}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group" id="searchDivision">
                                <select name="div_state_id" class="form-control s2 {{ checkMM() }}" id="filter_div_state">
                                    <option value="">{{ __('lang.div_state') }}{{ __('lang.choose1') }}</option>
                                    @foreach ($div_states as $div_state)
                                    <option value="{{ 'div-'.$div_state->id }}">
                                        {{ checkMM() == 'mm' ? $div_state->name : $div_state->eng }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="hiddenData">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select name="meterType" class="form-control inner-form" id="type">
                                <option value="">{{ __('lang.applied_meter_type') }}</option> 
                                <option value="1">{{ __('lang.residential') }} {{ __('lang.meter') }}</option>
                                <option value="2">{{ __('lang.residential') }} {{ __('lang.power') }} {{ __('lang.meter') }}</option>
                                <option value="3">{{ __('lang.commercial') }} {{ __('lang.power') }} {{ __('lang.meter') }}</option>
                                <option value="5">{{ __('lang.contractor') }} {{ __('lang.meter') }}</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="serial" value="" placeholder="{{__('lang.serial')}}" id="serial" class="form-control inner-form">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="name" value="" placeholder="{{__('lang.name')}}" id="name" class="form-control inner-form">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="date" placeholder="{{__('lang.date')}}" id="from" class="form-control inner-form daterange" value="">
                        </div>
                        <div class="col-md-1">
                            <a class="btn btn-rounded btn-outline-secondary btnRoleCancel d-none">{{ __('lang.cancel') }}</a>
                            <button type="submit" class="btn btn-rounded btn-info"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                {!! Form::close() !!}

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">#</th>
                                <th class="">{{ __('lang.name') }}</th>
                                <th class="">{{ __('lang.serial') }}</th>
                                <th class="">{{ __('lang.township') }}</th>
                                <th class="">{{ __('lang.district') }}</th>
                                <th class="">{{ __('lang.div_state') }}</th>
                                <th class="text-center ">{{ __('lang.send_date') }}</th>
                                <th class="">{{ __('lang.applied_meter_type') }}</th>
                                @if (hasPermissions(['pendingForm-create', 'pendingForm-show']))
                                <th class="text-center ">{{ __('lang.actions') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @if ($form->count() > 0)
                        @foreach ($form as $data)

                            {{--  chk same div/state | same district | same township | system --}}
                            @if ((admin()->div_state == $data->div_state_id && admin()->district == $data->district_id && admin()->township == $data->township_id) || admin()->group_lvl <= 2)

                            @if (chk_send($data->id)) {{--  chk user send already  --}}
                            <tr>
                                <td class="align-middle text-center">{{ checkMM() == 'mm' ? mmNum(++$i) : (++$i) }}</td>
                                <td class="align-middle {{ checkMM() }}">{{ $data->fullname }}</td>
                                <td class="align-middle">{{ $data->serial_code }}</td>
                                <td class="align-middle {{ checkMM() }}">{{ township($data->township_id) }}</td>
                                <td class="align-middle {{ checkMM() }}">{{ district($data->district_id) }}</td>
                                <td class="align-middle {{ checkMM() }}">{{ div_state($data->div_state_id) }}</td>
                                <td class="align-middle text-center {{ checkMM() }}">
                                    {{ sent_date($data->id) }}
                                </td>
                                <td class="align-middle">
                                    {{ apply_meter_type($data->apply_type) }}
                                </td>
                           

                                @if (hasPermissions(['pendingForm-show']))
                                <td class="text-center align-middle">
                                    <a href="{{ route('pending_form.show', $data->id) }}" class="btn btn-rounded btn-sm btn-{{ chk_userForm($data->id)['to_confirm'] ? 'warning' : 'info' }}" data-toggle="tooltip" data-title="View"><i class="fa fa-search fa-fw"></i></a>
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
                    <div class="pull-right m-b-30">
                        {{ $form->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--  <div class="col-lg-3 m-b-30">
    <div data-label="10%" class="css-bar css-bar-10"></div>
</div>  --}}
@endsection