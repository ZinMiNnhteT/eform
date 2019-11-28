@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
            </div>

            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ __('lang.'.session('status')) }}
                </div>
                @endif

                {{--  create / edit  --}}
                <div class="row mb-3">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="d-flex">
                                    <p class="mb-0 text-info">{{ __('lang.active_accounts') }}</p>
                                    <div class="ml-auto pl-3">
                                        <span class="badge badge-pill badge-info float-right">{{ checkMM() == 'mm' ? mmNum(account_summary()['a_all']) : account_summary()['a_all'] }}</span>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-3"> --}}
                                {{-- <a href="" onclick="event.preventDefault();">
                                    <div class="row">
                                        <div class="col-9">
                                            <p class="mb-0">{{ __('lang.email_verified_accounts') }}</p>
                                        </div>
                                        <div class="col-3">
                                            <span class="badge badge-pill badge-info float-right">{{ checkMM() == 'mm' ? mmNum(account_summary()['v_all']) : account_summary()['v_all'] }}</span>
                                        </div>
                                    </div>
                                </a> --}}
                            {{-- </div> --}}
                            {{-- <div class="col-md-3"> --}}
                                {{-- <a href="" onclick="event.preventDefault();">
                                    <div class="row">
                                        <div class="col-9">
                                            <p class="mb-0">{{ __('lang.non_verified_accounts') }}</p>
                                        </div>
                                        <div class="col-3">
                                            <span class="badge badge-pill badge-info float-right">{{ checkMM() == 'mm' ? mmNum(account_summary()['unv_all']) : account_summary()['unv_all'] }}</span>
                                        </div>
                                    </div>
                                </a> --}}
                            {{-- </div> --}}
                            <div class="col-md-3">
                                <div class="d-flex">
                                    <p class="mb-0 text-info">{{ __('lang.disabled_accounts') }}</p>
                                    <div class="ml-auto pl-3">
                                        <span class="badge badge-pill badge-info float-right">{{ checkMM() == 'mm' ? mmNum(account_summary()['d_all']) : account_summary()['d_all'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        @if (hasPermissions(['accountSetting-create']))
                        <a href="{{ route('accounts.create') }}" class="btn btn-block btn-rounded btn-info">{{ __('lang.create') }}</a>
                        @endif
                    </div>
                </div>

                {{--  show data  --}}
                <div class="float-right">{{ $accounts->links() }}</div>
                <div class="table-reponsive">
                    <table class="table table-hover {{ checkMM() }}">
                        <thead>
                            <tr class="text-capitalize">
                                <th width="5%" class="text-center">#</th>
                                <th width="10%">{{ __('lang.account') }} {{ __('lang.name') }}</th>
                                <th width="10%">{{ __('lang.name') }}</th>
                                <th width="15%">{{ __('lang.role_name') }}</th>
                                <th width="10%">{{ __('lang.group') }}</th>
                                <th width="12%">{{ __('lang.position') }}</th>
                                <th width="13%">{{ __('lang.department') }}</th>
                                <th width="15%">{{ __('lang.township') }}, {{ __('lang.district') }}, {{ __('lang.div_state') }}</th>
                                {{-- <th>{{ __('lang.created_at') }}</th> --}}
                                @if (hasPermissions(['accountSetting-show', 'accountSetting-edit', 'accountSetting-delete']))
                                <th width="10%" class="text-center">{{ __('lang.actions') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                    @if ($accounts->count() > 0)
                        @foreach ($accounts as $account)
                            <tr>
                                <td class="text-center">{{ checkMM() == 'mm' ? mmNum(++$i) : ++$i }}</td>
                                <td>{{ $account->username }}</td>
                                <td>{{ $account->name }}</td>
                                <td>
                                    @php $nn = 0; @endphp
                                    @foreach (accountHasRole($account->id) as $item)
                                        @php ++$nn; @endphp
                                        {{ $item->name }}
                                        @if (count(accountHasRole($account->id)) >= 2 && count(accountHasRole($account->id)) !== $nn)
                                            <br/>
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ group($account->group_lvl) }}</td>
                                <td>{{ $account->position }}</td>
                                <td>{{ $account->department }}</td>
                                <td>
                                    @if ($account->township)
                                    {{ township($account->township) }},
                                    @endif
                                    @if ($account->district)
                                    {{ district($account->district) }},
                                    @endif
                                    {{ div_state($account->div_state) }}
                                </td>
                                {{-- <td>{{ checkMM() == 'mm' ? mmMonth(date_format($account->created_at, 'm')).' '.mmNum(date_format($account->created_at, 'd')).', '.mmNum(date_format($account->created_at, 'Y')) : date_format($account->created_at, 'M d, Y') }}</td> --}}
                                <td class="text-center">
                                @if (hasPermissions(['accountSetting-show', 'accountSetting-edit', 'accountSetting-delete']))
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            {{--  show  --}}
                                            {{-- @if (hasPermissions('accountSetting-show'))
                                            <a href="{{ route('accounts.show', $account->id) }}" onclick="event.preventDefault();" class="dropdown-item">{{ __('lang.show') }}</a>
                                            @endif --}}
                                            {{--  edit  --}}
                                            @if (hasPermissions('accountSetting-edit'))
                                            <a href="{{ route('accounts.edit', $account->id) }}" class="dropdown-item">{{ __('lang.edit') }}</a>
                                            @endif
                                            
                                            {{--  delete  --}}
                                            @if (hasPermissions('accountSetting-delete'))
                                            {{--  {!! Form::open(['method' => 'DELETE','route' => ['accounts.destroy', $account->id], 'style'=>'display:inline']) !!}  --}}
                                            <button type="submit" class="dropdown-item" style="cursor: not-allowed;">{{ __('lang.delete') }}</button>
                                            {!! Form::close() !!}
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                        </tbody>
                    </table>
                </div>
                <div class="float-right">{{ $accounts->links() }}</div>
            </div>
                
        </div>
    </div>
</div>

@endsection