@extends('layouts.app')

@section('content')
{{--  {{ dd($tbl_col_name) }}  --}}

<div class="row justify-content-center py-5">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header bg-success">
                <h4 class="text-center text-white m-0">{{__('lang.transformer_apply_type')}}</h4>
            </div>
            <div class="container-fluid">
                <div class="card-body">
                    
                    @if ($fee_names->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th></th>
                                    <th width="30%" class="align-middle font-weight-bold">{{ __('lang.descriptions') }}</th>
                                    <th colspan="8" class="font-weight-bold">{{ '၁၁/၀.၄ ကေဗွီ ထရန်စဖော်မာ Rating အလိုက်' }} {{ __('lang.initial_cost') }}</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th class="font-weight-bold">{{ __('lang.types') }} ({{ __('lang.kva') }})</th>
                                    @foreach ($tbl_col_name as $col_name)
                                        @if ($col_name != 'building_fee' && $col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'composit_box' && $col_name != 'sub_type' && $col_name != 'incheck_fee')
                                    <th class="font-weight-bold">{{ __('lang.'.$col_name) }}</th>
                                        @endif
                                    @endforeach
                                    <th class="font-weight-bold">{{ __('lang.total') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp

                                @foreach ($fee_names as $fee)
                                    @php $t_count = 0; @endphp
                                <tr>
                                    <td>{{ checkMM() === 'mm' ? mmNum(number_format($i)) : number_format($i) }}<?php $i++;?></td>

                                    @foreach($tbl_col_name as $col_name)
                                        @if ($col_name != 'building_fee' && $col_name != 'id' && $col_name != 'type' && $col_name != 'incheck_fee' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'composit_box' && $col_name != 'sub_type')
                                    <td class="text-center">
                                            @if ($col_name == 'name')
                                        <strong>{{ checkMM() === 'mm' ? mmNum($fee->$col_name) : $fee->$col_name }}</strong>
                                            @else
                                        {{ checkMM() === 'mm' ? mmNum(number_format($fee->$col_name)) : number_format($fee->$col_name) }}/-
                                            @php $t_count += $fee->$col_name; @endphp
                                            @endif
                                            <!--{{ $fee->sub_type }}-->
                                    </td>
                                        @endif
                                    @endforeach
                                    <td class="text-center">
                                        {{ checkMM() === 'mm' ? mmNum(number_format($t_count)) : number_format($t_count) }}/-
                                    </td>
                                    <td class="text-center">
                                        {!! Form::open(['route' => ['tsf_store_meter_type',$div]]) !!}
                                        {!! Form::hidden('sub_type', $fee->sub_type) !!}
                                        <button type="submit" class="btn btn-rounded btn-outline-info ">{{ __('lang.choose') }}</button>
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
            <div class="card-footer text-center">
                <a href="{{ route('tsf_rule_regulation') }}" class="btn btn-rounded btn-info col-md-3"><i class="fa fa-chevron-left"></i> {{ __('lang.back') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
