@extends('layouts.app')

@section('content')
{{--  {{ dd($tbl_col_name) }}  --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="container">
                <div class="card-body">
                    <div class="text-md-right m-b-5">
                        <a href="{{ route('resident_applied_form', $form->id) }}" class="waves-effect waves-light btn btn-rounded btn-info "><i class="fa fa-chevron-left"></i> @lang('lang.back')</a>
                    </div>
                    @if ($fee_names->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th rowspan="2" class="align-middle ">{{ __('lang.descriptions') }}</th>
                                    <th colspan="3" class="">{{ __('lang.initial_cost') }}</th>
                                </tr>
                                <tr class="text-center">
                                    @foreach ($fee_names as $item)
                                        @if ($item->id === 3)
                                        <th class=" {{ $item->id == $form->apply_sub_type ? 'bg-warning' : '' }}">{{ __('lang.'.$item->slug."_yangon") }}</th>
                                        @endif
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php $country = 0; $small = 0; $city = 0; @endphp
                                @foreach ($tbl_col_name as $col_name)
                                @if ($col_name != 'building_fee' && $col_name != 'id' && $col_name != 'type' && $col_name != 'name' && $col_name != 'created_at' && $col_name != 'updated_at' && $col_name != 'slug')
                                <tr>
                                    <td class="">{{ __('lang.'.$col_name) }}</td>
                                    @foreach ($fee_names as $fee)
                                    @php
                                        $bg = '';
                                        $type = false;
                                        if ($fee->sub_type == $form->apply_sub_type) {
                                            $bg = 'bg-warning';
                                            $type = true;
                                        }
                                    @endphp
                                    <td class="text-center {{ $bg }}">{{ checkMM() === 'mm' ? mmNum(number_format($fee->$col_name)) : number_format($fee->$col_name) }}</td>
                                    @if ($fee->slug == 'type_three')
                                        @php $city += $fee->$col_name @endphp
                                    @endif
                                    @endforeach

                                </tr>
                                @endif
                                @endforeach
                                <tr class="text-center">
                                    <td class="">{{ __('lang.total') }}</td>
                                    <td class=" {{ $form->apply_sub_type == 1 ? 'bg-warning' : '' }}">{{ checkMM() == 'mm' ? mmNum(number_format($country)): number_format($country) }}</td>
                                    <td class=" {{ $form->apply_sub_type == 2 ? 'bg-warning' : '' }}">{{ checkMM() == 'mm' ? mmNum(number_format($small)) : number_format($small) }}</td>
                                    <td class=" {{ $form->apply_sub_type == 3 ? 'bg-warning' : '' }}">{{ checkMM() == 'mm' ? mmNum(number_format($city)) : number_format($city) }}</td>
                                </tr>
                                <tr class="text-center">
                                    <td></td>
                                    <td>
                                        {!! Form::open(['route' => ['resident_update_meter_type_ygn'], 'method' => 'PATCH']) !!}
                                        {!! Form::hidden('sub_type', 3) !!}
                                        {!! Form::hidden('form_id', $form->id) !!}
                                        <button type="submit" class="waves-effect waves-light btn btn-rounded btn-outline-info ">{{ __('lang.choose') }}</button>
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
