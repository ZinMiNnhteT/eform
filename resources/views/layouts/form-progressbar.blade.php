@php
    if (isset($form->id)) {
        $id = $form->id;
        $data = $form;
    } elseif (isset($data->id)) {
        $id = $data->id;
        $form = $data;
    } else {
        $id = null;
        $form = $data = null;
    }

    //print_r('<pre>');
    //print_r(progress($id));
    //print_r('</pre>');
@endphp 
@if ($id !== null)
    @if (chk_send($id) == 'first')
        @if (progress($id)['send'])
            <div class="d-none d-md-block">
                <div class="row mt-5 mb-5">
                    <div class="col-12">
                        <ul class="custom-progressbar">
                            {{--  class = pb-accept pb-reject pb-pending --}}
                            @php
                                $class1 = progress($id)['send'] ? 'pb-accept' : '';
                                $class2 = progress($id)['accept'] ? 'pb-accept' : '';
                                $class3 = progress($id)['survey'] ? 'pb-accept' : '';
                                if (progress($id)['c_survey_div_state']) {
                                    $class4 = 'pb-accept';
                                } elseif (progress($id)['c_survey_dist']) {
                                    $class4 = 'pb-accept';
                                } elseif (progress($id)['c_survey']) {
                                    $class4 = 'pb-accept';
                                } else {
                                    $class4 = '';
                                }
                                $class5 = progress($id)['ann'] ? 'pb-accept' : '';
                                $class6 = progress($id)['payment'] ? 'pb-accept' : '';
                                // $class7 = progress($id)['c_payment'] ? 'pb-accept' : '';
                                $class7 = progress($id)['install'] ? 'pb-accept' : '';

                                if($form->apply_type > 1){
                                    $class8 = progress($id)['install_confirm'] ? 'pb-accept' : '';
                                    $class9 = progress($id)['reg'] ? 'pb-accept' : '';
                                }else{
                                    $class8 = progress($id)['reg'] ? 'pb-accept' : '';
                                }

                            @endphp
                            <li class="{{ $class1 }}">
                                @if (progress($id)['send'])
                                <span class="mytooltip tooltip-effect-4">
                                    <span class="tooltip-item custom-tt-item">{{ __('lang.step1') }}</span>
                                    <span class="tooltip-content custom-tt-content clearfix">
                                        <span class="tooltip-text py-4 px-4">{{ __('lang.alrdy_send') }}</span>
                                    </span>
                                </span>
                                @else
                                {{ __('lang.step1') }}
                                @endif
                            </li>
                            <li class="{{ $class2 }}">
                                @if (progress($id)['accept'])
                                <span class="mytooltip tooltip-effect-4">
                                    <span class="tooltip-item custom-tt-item">{{ __('lang.step2') }}</span>
                                    <span class="tooltip-content custom-tt-content clearfix">
                                        <span class="tooltip-text py-4 px-4">{{ __('lang.alrdy_accept') }}</span>
                                    </span>
                                </span>
                                @else
                                {{ __('lang.step2') }}
                                @endif
                            </li>
                            <li class="{{ $class3 }}">
                                @if (progress($id)['survey'])
                                <span class="mytooltip tooltip-effect-4">
                                    <span class="tooltip-item custom-tt-item">{{ __('lang.step3') }}</span>
                                    <span class="tooltip-content custom-tt-content clearfix">
                                        <span class="tooltip-text py-4 px-4">{{ __('lang.alrdy_survey') }}</span>
                                    </span>
                                </span>
                                @else
                                {{ __('lang.step3') }}
                                @endif
                            </li>
                            <li class="{{ $class4 }}">
                                @if (progress($id)['c_survey_div_state'])
                                <span class="mytooltip tooltip-effect-4">
                                    <span class="tooltip-item custom-tt-item">{{ __('lang.step4') }}</span>
                                    <span class="tooltip-content custom-tt-content clearfix">
                                        <span class="tooltip-text py-4 px-4">{{ __('lang.alrdy_c_survey_div_state') }}</span>
                                    </span>
                                </span>
                                @elseif (progress($id)['c_survey_dist'])
                                <span class="mytooltip tooltip-effect-4">
                                    <span class="tooltip-item custom-tt-item">{{ __('lang.step4') }}</span>
                                    <span class="tooltip-content custom-tt-content clearfix">
                                        <span class="tooltip-text py-4 px-4">{{ __('lang.alrdy_c_survey_dist') }}</span>
                                    </span>
                                </span>
                                @elseif (progress($id)['c_survey'])
                                <span class="mytooltip tooltip-effect-4">
                                    <span class="tooltip-item custom-tt-item">{{ __('lang.step4') }}</span>
                                    <span class="tooltip-content custom-tt-content clearfix">
                                        <span class="tooltip-text py-4 px-4">{{ __('lang.alrdy_c_survey') }}</span>
                                    </span>
                                </span>
                                @else
                                {{ __('lang.step4') }}
                                @endif
                            </li>
                            <li class="{{ $class5 }}">
                                @if (progress($id)['ann'])
                                <span class="mytooltip tooltip-effect-4">
                                    <span class="tooltip-item custom-tt-item">{{ __('lang.step5') }}</span>
                                    <span class="tooltip-content custom-tt-content clearfix">
                                        <span class="tooltip-text py-4 px-4">{{ __('lang.alrdy_anno') }}</span>
                                    </span>
                                </span>
                                @else
                                {{ __('lang.step5') }}
                                @endif
                            </li>
                            <li class="{{ $class6 }}">
                                @if (progress($id)['payment'])
                                <span class="mytooltip tooltip-effect-4">
                                    <span class="tooltip-item custom-tt-item">{{ __('lang.step6') }}</span>
                                    <span class="tooltip-content custom-tt-content clearfix">
                                        <span class="tooltip-text py-4 px-4">{{ __('lang.alrdy_payment') }}</span>
                                    </span>
                                </span>
                                @else
                                {{ __('lang.step6') }}
                                @endif
                            </li>
                            {{-- <li class="{{ $class7 }}">
                                @if (progress($id)['c_payment'])
                                <span class="mytooltip tooltip-effect-4">
                                    <span class="tooltip-item custom-tt-item">{{ __('lang.step7') }}</span>
                                    <span class="tooltip-content custom-tt-content clearfix">
                                        <span class="tooltip-text py-4 px-4">{{ __('lang.alrdy_c_payment') }}</span>
                                    </span>
                                </span>
                                @else
                                {{ __('lang.step7') }}
                                @endif
                            </li> --}}
                            <li class="{{ $class7 }}">
                                @if (progress($id)['install'])
                                <span class="mytooltip tooltip-effect-4">
                                    <span class="tooltip-item custom-tt-item">{{ __('lang.step7') }}</span>
                                    <span class="tooltip-content custom-tt-content clearfix">
                                        <span class="tooltip-text py-4 px-4">{{ __('lang.alrdy_install') }}</span>
                                    </span>
                                </span>
                                @else
                                {{ __('lang.step7') }}
                                @endif
                            </li>

                            @if ($form->apply_type > 1)
                                <li class="{{ $class8 }}">
                                    @if (progress($id)['install_confirm'])
                                    <span class="mytooltip tooltip-effect-4">
                                        <span class="tooltip-item custom-tt-item">{{ __('lang.step8') }}</span>
                                        <span class="tooltip-content custom-tt-content clearfix">
                                            <span class="tooltip-text py-4 px-4">{{ __('lang.ei_finish') }}</span>
                                        </span>
                                    </span>
                                    @else
                                    {{ __('lang.step8') }}
                                    @endif
                                </li>
                                <li class="{{ $class9 }}">
                                    @if (progress($id)['reg'])
                                    <span class="mytooltip tooltip-effect-4">
                                        <span class="tooltip-item custom-tt-item">{{ __('lang.step9') }}</span>
                                        <span class="tooltip-content custom-tt-content clearfix">
                                            <span class="tooltip-text py-4 px-4">{{ __('lang.alrdy_reg') }}</span>
                                        </span>
                                    </span>
                                    @else
                                    {{ __('lang.step9') }}
                                    @endif
                                </li>
                            @else
                                <li class="{{ $class8 }}">
                                    @if (progress($id)['reg'])
                                    <span class="mytooltip tooltip-effect-4">
                                        <span class="tooltip-item custom-tt-item">{{ __('lang.step8') }}</span>
                                        <span class="tooltip-content custom-tt-content clearfix">
                                            <span class="tooltip-text py-4 px-4">{{ __('lang.alrdy_reg') }}</span>
                                        </span>
                                    </span>
                                    @else
                                    {{ __('lang.step8') }}
                                    @endif
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endif