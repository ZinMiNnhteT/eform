@extends('layouts.admin_app')

@section('content')
<div class="row waitMe-body">
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

                <div class="row">
                    {{--  create / edit  --}}
                    <div class="col-md-2">
                        <h4>Summary</h4>
                        <hr/>
                        <a href="" onclick="event.preventDefault();">
                            <div class="row">
                                <div class="col-8">
                                    <p>{{ __('lang.active_accounts') }}</p>
                                </div>
                                <div class="col-4">
                                    <span class="badge badge-pill badge-info float-right">{{ checkMM() == 'mm' ? mmNum(user_account_summary()['a_all']) : user_account_summary()['a_all'] }}</span>
                                </div>
                            </div>
                        </a>
                        <a href="" onclick="event.preventDefault();">
                            <div class="row">
                                <div class="col-9">
                                    <p>{{ __('lang.email_verified_accounts') }}</p>
                                </div>
                                <div class="col-3">
                                    <span class="badge badge-pill badge-info float-right">{{ checkMM() == 'mm' ? mmNum(user_account_summary()['v_all']) : user_account_summary()['v_all'] }}</span>
                                </div>
                            </div>
                        </a>
                        <a href="" onclick="event.preventDefault();">
                            <div class="row">
                                <div class="col-9">
                                    <p>{{ __('lang.non_verified_accounts') }}</p>
                                </div>
                                <div class="col-3">
                                    <span class="badge badge-pill badge-info float-right">{{ checkMM() == 'mm' ? mmNum(user_account_summary()['unv_all']) : user_account_summary()['unv_all'] }}</span>
                                </div>
                            </div>
                        </a>
                        <a href="" onclick="event.preventDefault();">
                            <div class="row">
                                <div class="col-9">
                                    <p>{{ __('lang.disabled_accounts') }}</p>
                                </div>
                                <div class="col-3">
                                    <span class="badge badge-pill badge-info float-right">{{ checkMM() == 'mm' ? mmNum(user_account_summary()['d_all']) : user_account_summary()['d_all'] }}</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{--  show data  --}}
                    <div class="col-md-10 border-left border-info">
                        <div class="float-right">{{ $accounts->links() }}</div>
                        <div class="table-reponsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-capitalize">
                                        <th width="5%" class="text-center">#</th>
                                        <th>{{ __('lang.account') }} {{ __('lang.name') }}</th>
                                        <th>{{ __('lang.created_at') }}</th>
                                        <th class="text-center">{{ __('lang.email_verified_at') }}</th>
                                        <th class="text-center">{{ __('lang.active_status') }}</th>
                                        @if (hasPermissions(['userAccount-edit']))
                                        <th width="10%" class="text-center">{{ __('lang.actions') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                            @if ($accounts->count() > 0)
                                @foreach ($accounts as $account)
                                    <tr>
                                        <td class="align-middle text-center">{{ checkMM() == 'mm' ? mmNum(++$i) : ++$i }}</td>
                                        <td class="align-middle">{{ $account->name }}</td>
                                        <td class="align-middle">{{ checkMM() == 'mm' ? mmMonth(date_format($account->created_at, 'm')).' '.mmNum(date_format($account->created_at, 'd')).', '.mmNum(date_format($account->created_at, 'Y')) : date_format($account->created_at, 'M d, Y') }}</td>
                                        <td class="align-middle text-center">
                                            @if ($account->email_verified_at != NULL)
                                            <i class="fa fa-check-circle text-success"></i>
                                            @else
                                            <i class="fa fa-times-circle text-danger"></i>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center status{{ $account->id }}">
                                            @if ($account->active)
                                            <span class="badge badge-success">ACTIVE</span>
                                            @else
                                            <span class="badge badge-danger">BANNED</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center btn{{ $account->id }}">
                                        @if (hasPermissions(['userAccount-edit']))
                                            {{-- @if ($account->active) --}}
                                            <a class="btn btn-rounded btn-warning sa-btn-lock {{ checkMM() }} {{ $account->active ? : 'd-none' }}" data-id="{{ $account->id }}" data-status="1"><i class="fa fa-lock"></i></a>
                                            {{-- @else --}}
                                            <a class="btn btn-rounded btn-warning sa-btn-unlock {{ checkMM() }} {{ !$account->active ? : 'd-none' }}" data-id="{{ $account->id }}" data-status="0"><i class="fa fa-unlock"></i></a>
                                            {{-- @endif --}}
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
    </div>
</div>

@endsection