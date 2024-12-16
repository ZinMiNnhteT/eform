@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-white bg-info d-flex">
                <h5 class="card-title m-0">{{ __('lang.'.$heading) }}</h5>
                <div class="ml-auto">
                    <a href="{{ route('transformerAnnounceList.index') }}" class="btn btn-rounded btn-info text-white l-h-ini p-t-5 p-b-5"><i class="fa-fw fa fa-angle-double-left"></i>{{ __('lang.back') }}</a>
                </div>
            </div>
            <div class="card-body card-body-pb-div">

                @include('layouts.form-progressbar')

                <div class="container-fluid">
                    <div id="app_show" class="accordion" role="tablist" aria-multiselectable="true">
                        
                        @include('layouts.user_apply_form')

                    </div>
                    @if (chk_userForm($data->id)['to_announce'])
                    @if (hasPermissions(['transformerAnnounce-create']))
                    <div class="card mb-1">
                        <div class="card-header d-flex" role="tab" id="headingOne">
                            <h5 class="mb-0 text-info">{{ __('ငွေသွင်းခြင်းအတွက် အကြောင်းကြားရန်') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center m-t-20 m-b-10">
                                <div class="col-3">
                                    <button class="btn btn-rounded btn-block btn-warning" data-toggle="modal" data-target="#announce" data-backdrop="static" data-keyboard="false" title="To Announce To User">
                                            {{ __('lang.announce') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="announce" tabindex="-1" role="dialog" aria-labelledby="announceModel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5 class="modal-title mt-3 mb-3" id="announceModel">{{ __("lang.announce") }}</h5>
                <hr/>
                <p class="mt-5 mb-5">{{ __("lang.announce_msg") }}</p>
                <hr/>
                <button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">{{ __('lang.cancel') }}</button>
                <a href="{{ route('transformerAnnounceList.create', $data->id) }}" class="btn btn-rounded btn-warning">{{ __('lang.send') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
