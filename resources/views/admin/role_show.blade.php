@extends('layouts.admin_app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <div class="row">
                    <div class="col-6 p-0">
                        <h5 class="card-title m-0">{{ __('lang.'.$heading) }} [{{ $name }}]</h5>
                    </div>
                    <div class="col-6 p-0 text-right">
                        <a href="{{ route('roles.index') }}" class="text-white btn btn-info btn-rounded"><< {{ __('lang.back') }}</a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="20%"></th>
                                <th class="text-center" width="12%">{{ __('lang.read') }}</th>
                                <th class="text-center" width="12%">{{ __('lang.write') }}</th>
                                <th class="text-center" width="12%">{{ __('lang.edit') }}</th>
                                <th class="text-center" width="12%">{{ __('lang.delete') }}</th>
                                <th class="text-center" width="12%">{{ __('lang.detailread') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Dashboard --}}
                            <tr class="bg-secondary">
                                <td>{{ __('lang.dashboard') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'dashboard') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" checked disabled>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr>
                                <td>{{ __('lang.inbox') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'inbox') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-secondary">
                                <td>{{ __('lang.applying_form_list') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'applyingForm') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr>
                                <td>{{ __('lang.performing_form_list') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'performingForm') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-secondary">
                                <td>{{ __('lang.reject_form_list') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'rejectForm') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr>
                                <td>{{ __('lang.pending_form_list') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'pendingForm') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-secondary">
                                <td>{{ __('lang.registered_form_list') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'registeredForm') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <!-- -------------- Residential Meter -------------- -->
                            <tr>
                                <td class="text-center text-primary font-weight-bold bg-custom-info">{{ __('lang.residential') }} {{ __('lang.meter') }}</td>
                                <td colspan="5"></td>
                            </tr>
                            <tr class="bg-custom-info">
                                <td>{{ __('lang.residentApplication') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'residentApplication') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div>
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-info">
                                <td>{{ __('lang.residentSurvey') }}</td>

                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'residentialGrdChk') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-info">
                                <td>{{ __('lang.residentSurveyDoneTsp') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'residentialChkGrdTownship') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-info">
                                <td>{{ __('lang.residentPending') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'residentPending') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div>
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-info">
                                <td>{{ __('lang.residentReject') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'residentReject') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div>
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-info">
                                <td>{{ __('lang.announce') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'residentialAnnounce') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-info">
                                <td>{{ __('lang.residentConfrimPayment') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'residentialConfirmPayment') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-info">
                                <td>{{ __('lang.chk_install') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'residentialChkInstall') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-info">
                                <td>{{ __('lang.reg_meter') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'residentialRegister') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <!-- -------------- End Residential Meter -------------- -->
                            <!-- -------------- Residential Power Meter -------------- -->
                            <tr>
                                <td class="text-center text-primary font-weight-bold bg-custom-success">{{ __('lang.residential') }} {{ __('lang.power') }} {{ __('lang.meter') }}</td>
                                <td colspan="5"></td>
                            </tr>
                            <tr class="bg-custom-success">
                                <td>{{ __('lang.residentApplication') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'residentPowerApplication') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div>
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-success">
                                <td>{{ __('lang.residentSurvey') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'residentialPowerGrdChk') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-success">
                                <td>{{ __('lang.residentSurveyDoneTsp') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'residentialPowerTownshipChkGrd') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-success">
                                <td>{{ __('lang.residentSurveyDoneDist') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'residentialPowerDistrictChkGrd') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-success">
                                <td>{{ __('lang.residentPending') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'residentPowerPending') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div>
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-success">
                                <td>{{ __('lang.residentReject') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'residentPowerReject') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div>
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-success">
                                <td>{{ __('lang.announce') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'residentialPowerAnnounce') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-success">
                                <td>{{ __('lang.residentConfrimPayment') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'residentialPowerConfirmPayment') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-success">
                                <td>{{ __('lang.chk_install') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'residentialPowerChkInstall') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-success">
                                <td>{{ __('lang.reg_meter') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'residentialPowerRegister') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <!-- -------------- End Residential Power Meter -------------- -->
                            <!-- -------------- Commercial Power Meter -------------- -->
                            <tr>
                                <td class="text-center text-primary font-weight-bold bg-custom-warning">{{ __('lang.commercial') }} {{ __('lang.power') }} {{ __('lang.meter') }}</td>
                                <td colspan="5"></td>
                            </tr>
                            <tr class="bg-custom-warning">
                                <td>{{ __('lang.residentApplication') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'commercialPowerApplication') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div>
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-warning">
                                <td>{{ __('lang.residentSurvey') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'commercialPowerGrdChk') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-warning">
                                <td>{{ __('lang.residentSurveyDone') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'commercialPowerTownshipChkGrd') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-warning">
                                <td>{{ __('lang.residentSurveyDone') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'commercialPowerDistrictChkGrd') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-warning">
                                <td>{{ __('lang.residentPending') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'commercialPowerPending') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div>
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-warning">
                                <td>{{ __('lang.residentReject') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'commercialPowerReject') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div>
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-warning">
                                <td>{{ __('lang.announce') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'commercialPowerAnnounce') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-warning">
                                <td>{{ __('lang.residentConfrimPayment') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'commercialPowerConfirmPayment') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-warning">
                                <td>{{ __('lang.chk_install') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'commercialPowerChkInstall') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-warning">
                                <td>{{ __('lang.reg_meter') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'commercialPowerRegister') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <!-- -------------- End Commercial Power Meter -------------- -->
                            <!-- -------------- Contractor Meter -------------- -->
                            <tr>
                                <td class="text-center text-primary font-weight-bold bg-custom-danger">{{ __('lang.contractor') }} {{ __('lang.meter') }}</td>
                                <td colspan="5"></td>
                            </tr>
                            <tr class="bg-custom-danger">
                                <td>{{ __('lang.residentApplication') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'contractorApplication') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div>
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-danger">
                                <td>{{ __('lang.residentSurvey') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'contractorGrdChk') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-danger">
                                <td>{{ __('lang.residentSurveyDoneTsp') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'contractorTownshipChkGrd') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-danger">
                                <td>{{ __('lang.residentSurveyDoneDist') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'contractorDistrictChkGrd') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-danger">
                                <td>{{ __('lang.residentSurveyDoneDivstate') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'contractorDivStateChkGrd') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-danger">
                                <td>{{ __('lang.residentPending') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'contractorPending') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div>
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-danger">
                                <td>{{ __('lang.residentReject') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'contractorReject') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div>
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-danger">
                                <td>{{ __('lang.announce') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'contractorAnnounce') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-danger">
                                <td>{{ __('lang.residentConfrimPayment') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'contractorConfirmPayment') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-danger">
                                <td>{{ __('lang.chk_install') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'contractorChkInstall') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-danger">
                                <td>{{ __('lang.ei_chk_install') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'contractorInstallDone') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-danger">
                                <td>{{ __('lang.reg_meter') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'contractorRegisteredMeter') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <!-- -------------- End Contractor Meter -------------- -->
                            <!-- -------------- Transformer Meter -------------- -->
                            <!-- -------------- End Transformer Meter -------------- -->
                            <!-- -------------- Setting -------------- -->
                            <tr>
                                <td class="text-center text-primary font-weight-bold bg-custom-secondary">{{ __('lang.setting') }}</td>
                                <td colspan="5"></td>
                            </tr>
                            <tr class="bg-custom-secondary">
                                <td>{{ __('lang.accountSetting') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'accountSetting') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-secondary">
                                <td>{{ __('lang.roleSetting') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'roleSetting') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <tr class="bg-custom-secondary">
                                <td>{{ __('lang.userAccounts') }}</td>
                                @foreach ($permissions as $value)
                                @if (strpos($value->name, 'userAccount') !== false)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox p-l-0">
                                        <input name="{{ chkbox_name($value->name) }}" type="checkbox" class="custom-control-input {{ chkbox_name($value->name) }}{{ $id }}{{ $value->id }}" id="{{ $value->name }}" data-role="{{ $id }}" data-per="{{ $value->id }}" {{ roleHasPermission($id, $value->id) ? 'checked' : '' }} {{ $id > 1 ? '' : 'disabled' }}>
                                        <label class="custom-control-label" for="{{ $value->name }}"></label>
                                    </div
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            <!-- -------------- End Setting -------------- -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection