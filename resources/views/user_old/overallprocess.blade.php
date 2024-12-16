@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="card-title text-white">{{ __('lang.'.$heading) }}</h4>
            </div>
            <div class="card-body">
                @if ($user_data->count() > 0)
                @php
                    $not_finish = false;
                    foreach ($user_data as $data) {
                        if (chk_send($data->id) == 'second') {
                            $not_finish = true;
                        }
                    }
                @endphp
                @if (count(chk_cdt(null)['id']) > 0)
                <div class="alert alert-danger alert-rounded">
                    <p class="text-danger m-0"><i class="fa fa-info fa-2x fa-fw"></i> {{ __('lang.applied_form_msg') }}</p>
                </div>
                @endif
                @if ($not_finish)
                <div class="alert alert-danger alert-rounded">
                    <p class="text-danger m-0"><i class="fa fa-info fa-2x fa-fw"></i> {{ __('lang.resend_form_msg') }}</p>
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover m-0">
                        <thead class="bg-secondary">
                            <tr>
                                <th width="10%" class="text-center">{{ __('lang.actions') }}</th>
                                <th width="13%">{{ __('lang.applied_meter_type') }}</th>
                                <th width="12%">{{ __('lang.serial') }}</th>
                                <th width="10%">{{ __('lang.name') }}</th>
                                <th>{{ __('lang.applied_address') }}</th>
                                <th width="10%" class="text-center">{{ __('lang.date') }}</th>
                                {{--  <th class="text-center">{{ __('lang.progress') }}</th>  --}}
                                <th width="20%" class="text-center">{{ __('lang.status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user_data as $data)
                                @php
                                    $status = cdt($data->id)[0];
                                    $route = route(cdt($data->id)[1], $data->id);
                                    $color = cdt($data->id)[2];
                                @endphp
                            <tr>
                                <td class="text-center">
                                    <a href="{{ $route }}" class="text-right"><strong>{{ __('lang.show') }}</strong></a>
                                </td>
                                <td>{{ $data->apply_type ? type($data->apply_type) : '' }}</td>
                                <td class="text-danger">{{ $data->fullname ? $data->serial_code : '' }}</td>
                                <td>{{ $data->fullname ? $data->fullname : '' }}</td>
                                <td>{{ $data->fullname ? address($data->id) : '' }}</td>
                                <td class="text-center">
                                    @if ($data->fullname)
                                    {{ checkMM() == 'mm' ? mmMonth(date('m', strtotime($data->date))).' '.mmNum(date('d', strtotime($data->date))).', '.mmNum(date('Y', strtotime($data->date))) : date('M d, Y', strtotime($data->date)) }}
                                    @endif
                                </td>
                                @if (chk_send($data->id) == 'first')
                                    <td class="text-center"><span class="text-info">{{ __('lang.'.chk_userForm($data->id)['msg']) }}</span></td>
                                @elseif (chk_send($data->id) == 'second')
                                <td class="text-center"><span class="text-danger">{{ __('lang.resend_form') }}</span></td>
                                @else
                                <td class="text-center"><span class="{{ $color }}">{{ __('lang.'.$status) }}</span></td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="float-md-right">
                        {{ $user_data->links() }}
                    </div>
                </div>
                @else
                    <h6 class="text-center">There is nothig to show!</h6>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
