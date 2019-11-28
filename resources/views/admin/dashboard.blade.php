@extends('layouts.admin_app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{ __('lang.dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>You are logged in as {{ Auth::guard('admin')->user()->name }}!</p>

                    {{--  <h4 class="card-title">Monthly Report</h4>  --}}
                    {{--  <div id="bar-chart" style="width:100%; height:400px;"></div>  --}}
                </div>
            </div>
        </div>
    </div>
@endsection
