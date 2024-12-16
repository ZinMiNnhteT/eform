@extends('layouts.app')

@section('content')
{{--  {{ dd($tbl_col_name) }}  --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="container-fluid">
                <div class="card-body">
                    <div class="text-md-right m-b-5">
                        <a href="{{ route('tsf_applied_form_mdy', $form->id) }}" class="waves-effect waves-light btn btn-rounded btn-info"><< {{ __('lang.back') }}</a>
                    </div>
                    @if ($fee_names->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th></th>
                                    <th width="30%" class="align-middle ">{{ __('lang.descriptions') }}</th>
                                    <th colspan="8">{{ '၁၁/၀.၄ ကေဗွီ ထရန်စဖော်မာ Rating အလိုက်' }} {{ __('lang.initial_cost') }}</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>{{ __('lang.types') }} ({{ __('lang.kva') }})</th>
                                    @foreach ($tbl_col_name as $col_name)
                                        @if ($col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'composit_box' && $col_name != 'sub_type' && $col_name != 'incheck_fee')
                                    <th>{{ __('lang.'.$col_name) }}</th>
                                        @endif
                                    @endforeach
                                    <th>{{ __('lang.total') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach ($fee_names as $fee)
                                    @php $t_count = 0;
                                        $bg = '';
                                        $type = false;
                                        if ($fee->sub_type == $form->apply_sub_type) {
                                            $bg = 'bg-warning';
                                            $type = true;
                                        }
                                    @endphp
                                <tr>
                                    <td>{{ checkMM() === 'mm' ? mmNum(number_format($i)) : number_format($i) }}<?php $i++;?></td>
                                    @foreach($tbl_col_name as $col_name)
                                        @if ($col_name != 'id' && $col_name != 'type' && $col_name != 'incheck_fee' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'composit_box' && $col_name != 'sub_type')
                                    <td class="text-center {{ $bg }}">
                                            @if ($col_name == 'name')
                                        <strong>{{ checkMM() === 'mm' ? mmNum($fee->$col_name) : $fee->$col_name }}</strong>
                                            @else
                                        {{ checkMM() === 'mm' ? mmNum(number_format($fee->$col_name)) : number_format($fee->$col_name) }}/-
                                            @php $t_count += $fee->$col_name; @endphp
                                            @endif
                                    </td>
                                        @endif
                                    @endforeach
                                    <td class="text-center {{ $bg }}">
                                        {{ checkMM() === 'mm' ? mmNum(number_format($t_count)) : number_format($t_count) }}/-
                                    </td>
                                    <td class="text-center">
                                        {!! Form::open(['route' => ['tsf_update_meter_type_mdy'], 'method' => 'PATCH']) !!}
                                        {!! Form::hidden('sub_type', $fee->sub_type) !!}
                                        {!! Form::hidden('form_id', $form->id) !!}
                                        <button type="submit" class="btn btn-rounded btn-outline-{{ $bg ? 'warning' : 'info' }} ">{{ __('lang.choose') }}</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <h5 class="text-danger">not yet</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
