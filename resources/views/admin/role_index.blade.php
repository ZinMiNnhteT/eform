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
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ __('lang.'.session('status')) }}
                    </div>
                @endif

                <div class="row">
                    <div class="col-6">
                        <p class="text-right">{{ $roles->links() }}</p>
                    </div>
                </div>

                <div class="row">
                    {{-- create / edit --}}
                @if (hasPermissions(['roleSetting-create']))
                    <div class="col-md-3">
                        <h4 class="text-info">{{ __('lang.create') }}</h4>
                        <hr/>
                        {!! Form::open(['route' => 'roles.store']) !!}
                        {!! Form::hidden('role_id', null, ['id' => 'role_id']) !!}
                        <div class="form-group">
                            <input type="text" name="role_name" id="role_name" class="form-control inner-form {{ $errors->has('role_name') ? ' is-invalid' : '' }}" placeholder="{{ __('lang.role_placeholder') }}" required>
                        </div>
                        <div class="form-group text-right">
                            <a class="btn btn-rounded btn-outline-secondary btnRoleCancel d-none">{{ __('lang.cancel') }}</a>
                            <input type="submit" value="{{ __('lang.create') }}" class="btn btn-rounded btn-outline-info btnCreateDel">
                        </div>
                        {!! Form::close() !!}
                    </div>
                @endif

                    {{-- show data --}}
                    @if (hasPermissions(['roleSetting-create']))
                    <div class="col-md-9 border-left border-info">
                    @endif
                        <div class="table-responsive custom-tbl">
                            <table class="table table-hovered">
                                <thead>
                                    <tr class="text-capitalize">
                                        <th width="10%" class="text-center">#</th>
                                        <th>{{ __('lang.role_name') }}</th>
                                        <th width="20%">{{ __('lang.created_at') }}</th>
                                        @if (hasPermissions(['roleSetting-show', 'roleSetting-edit', 'roleSetting-delete']))
                                        <th width="30%" class="text-center">{{ __('lang.actions') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                            @if ($roles->count() > 0)
                                @foreach ($roles as $role)
                                    <tr>
                                        <td class="text-center">{{ checkMM() == 'mm' ? mmNum(++$i) : ++$i }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ checkMM() == 'mm' ? mmMonth(date_format($role->created_at, 'm')).' '.mmNum(date_format($role->created_at, 'd')).', '.mmNum(date_format($role->created_at, 'Y')) : date_format($role->created_at, 'M d, Y') }}</td>
                                        @if (hasPermissions(['roleSetting-show', 'roleSetting-edit', 'roleSetting-delete']))
                                        <td class="text-center">
                                            {{--  show  --}}
                                            @if (hasPermissions('roleSetting-show'))
                                            <a href="{{ route('roles.show', $role->id) }}" class="btn btn-rounded btn-outline-primary"><i class="fa-fw fa fa-wrench"></i></a>
                                            @endif

                                            {{--  edit  --}}
                                            @if (hasPermissions('roleSetting-edit'))
                                            <a href="roles/edit" onclick="event.preventDefault();" class="btn btn-rounded btn-outline-warning btnRoleEdit" data-rolename="{{ $role->name }}" data-roleid="{{ $role->id }}"><i class="fa-fw fa fa-edit"></i></a>
                                            @endif

                                            {{--  delete  --}}
                                            @if (hasPermissions('roleSetting-delete'))
                                            {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id], 'style'=>'display:inline']) !!}
                                            <button type="submit" class="btn btn-rounded btn-outline-danger"><i class="fa-fw fa fa-trash"></i></button>
                                            {!! Form::close() !!}
                                            @endif
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

@endsection