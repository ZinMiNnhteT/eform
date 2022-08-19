@extends('layouts.app')

@section('content')
{{--  {{ dd($tbl_col_name) }}  --}}

<div class="row justify-content-center py-5">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="text-center text-white m-0">{{__('lang.transformer_apply_type')}}</h4>
            </div>
            <div class="container-fluid">
                <div class="card-body">
                    
                    @if ($fee_names->count() > 0)
                    
                    {!! Form::open(['route' => ['commercial_tsf_store_meter_type_ygn']]) !!}

                    {!! Form::hidden('sub_type', null) !!}

                    <div class="form-group">
                        <label class="text-info">{{ __('lang.pole_type') }}</label>
                        <div class="bg-secondary p-20">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="pole_type" class="text-dark m-l-10">
                                        <input name="pole_type" type="radio" value="1" class="check" id="flat-checkbox-1" data-checkbox="icheckbox_flat-red" required>
                                        {{ __('lang.one_pole')}}
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label for="pole_type" class="text-dark m-l-10">
                                        <input name="pole_type" type="radio" value="2" class="check" id="flat-checkbox-1" data-checkbox="icheckbox_flat-red" required>
                                        {{ __('lang.two_pole')}}
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label for="pole_type" class="text-dark m-l-10">
                                        <input name="pole_type" type="radio" value="3" class="check" id="flat-checkbox-1" data-checkbox="icheckbox_flat-red" required>
                                        {{ __('lang.package_pole')}}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                    @php $i = 1; @endphp
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
                                        </td>
                                            @endif
                                        @endforeach
                                        <td class="text-center">
                                            {{ checkMM() === 'mm' ? mmNum(number_format($t_count)) : number_format($t_count) }}/-
                                        </td>
                                        <td class="text-center">
                                            <button type="submit" class="btn btn-rounded btn-outline-info tsf-meter-type-choose" subtype="{{ $fee->sub_type }}">{{ __('lang.choose') }}</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    {!! Form::close() !!}
                    @else
                    <h5 class="text-danger">not yet</h5>
                    @endif
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('tsf_rule_regulation_ygn') }}" class="btn btn-rounded btn-info col-3"><i class="fa fa-chevron-left"></i> {{ __('lang.back') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
