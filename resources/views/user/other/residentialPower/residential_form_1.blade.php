@extends('layouts.app')

@section('content')
{{--  {{ dd($tbl_col_name) }}  --}}
<div class="row justify-content-center">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header bg-success">
                <h4 class="text-white text-center m-0">@lang('lang.meter_apply_type')</h4>
            </div>
            <div class="container">

                <div class="card-body">
                    <div class="text-md-right m-b-5">
                        <a href="{{ route('resident_power_rule_regulation') }}" class="btn btn-rounded btn-info"><i class="fa fa-chevron-left"></i> @lang('lang.back')</a>
                    </div>
                    @if ($fee_names->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th rowspan="2" class="align-middle">{{ __('lang.descriptions') }}</th>
                                    <th colspan="3">{{ __('lang.initial_cost') }}</th>
                                </tr>
                                <tr class="text-center">
                                    @foreach($fee_names as $item)
                                    <th>{{ __('lang.'.$item->slug) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php $country = 0; $small = 0; $city = 0; @endphp
                                @foreach ($tbl_col_name as $col_name)
                                @if ($col_name != 'building_fee' && $col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug' && $col_name != 'service_fee' && $col_name != 'incheck_fee' && $col_name != 'sub_type')
                                <tr>
                                    <td class="">{{ __('lang.'.$col_name) }}</td>
                                    @foreach ($fee_names as $fee)
                                    <td class="text-center">{{ checkMM() === 'mm' ? mmNum(number_format($fee->$col_name)) : number_format($fee->$col_name) }}</td>
                                        @if ($fee->slug == '10kw')
                                            @php $country += $fee->$col_name; @endphp
                                        @elseif ($fee->slug == '20kw')
                                            @php $small += $fee->$col_name @endphp
                                        @elseif ($fee->slug == '30kw')
                                            @php $city += $fee->$col_name @endphp
                                        @endif
                                    @endforeach

                                </tr>
                                @endif
                                @endforeach
                                <tr class="text-center">
                                    <td class="">{{ __('lang.total') }}</td>
                                    <td class="">{{ checkMM() == 'mm' ? mmNum(number_format($country)): number_format($country) }}</td>
                                    <td class="">{{ checkMM() == 'mm' ? mmNum(number_format($small)) : number_format($small) }}</td>
                                    <td class="">{{ checkMM() == 'mm' ? mmNum(number_format($city)) : number_format($city) }}</td>
                                </tr>
                                <tr class="text-center">
                                    <td></td>
                                    <td>
                                        {!! Form::open(['route' => ['resident_power_store_meter_type',$div]]) !!}
                                        {!! Form::hidden('type', 1) !!}
                                        <button type="submit" class="btn btn-rounded btn-outline-info ">{{ __('lang.choose') }}</button>
                                        {!! Form::close() !!}
                                    </td>
                                    <td>
                                        {!! Form::open(['route' => ['resident_power_store_meter_type',$div]]) !!}
                                        {!! Form::hidden('type', 2) !!}
                                        <button type="submit" class="btn btn-rounded btn-outline-info ">{{ __('lang.choose') }}</button>
                                        {!! Form::close() !!}
                                    </td>
                                    <td>
                                        {!! Form::open(['route' => ['resident_power_store_meter_type',$div]]) !!}
                                        {!! Form::hidden('type', 3) !!}
                                        <button type="submit" class="btn btn-rounded btn-outline-info ">{{ __('lang.choose') }}</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
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
