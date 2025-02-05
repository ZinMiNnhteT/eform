@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="row px-2">
                    <div class="col-lg-3 col-md-4 p-0 my_scroll">
                        <div class="card">
                            <div class="card-header px-3 bg-info text-white pt-3">
                                <h4 class="card-title mb-0">{{ __('lang.all_mails') }}</h4>
                            </div>
                            <div class="card-body px-0 pt-0 inbox-panel">
                                <ul class="list-group list-group-full">

                                @if (isset($mail) && $mail->count() > 0)
                                    @foreach ($mail as $item)
                                    <li class="list-group-item {{ $item->mail_read ? : 'mail_un_read' }} clk-mail <?php if ($mail_data && $mail_data->id == $item->id): echo "$click_active"; endif ?>" data-id="{{ $item->id }}">
                                        {{ mail_type($item->send_type) }}
                                        <small class="float-right">{{ date('d-m-Y', strtotime($item->mail_send_date)) }}</small>
                                    </li>
                                    @endforeach
                                @endif

                                </ul>
                            </div>
                        </div>
                    </div>
                    @if ($mail_data && $mail_data->count() > 0)
                    <div class="col-lg-9 col-md-8 bg-light border-left mail-detail-div">
                        <div class="card mb-0 mail-view m-l-10 m-r-10">
                            <div class="card-body">
                                <h3 class="card-title send_type m-b-0"><span>{{ mail_type($mail_data->send_type) }}</span></h3>
                            </div>

                            <div><hr class="m-t-0"></div>
                            
                            <div class="card-body">
                                <div class="d-flex m-b-40">
                                    <div class="single-mail">
                                        <small class="text-muted mail_from"><span>From: {{ 'no-reply@moee.gov.mm' }}</span></small>
                                        <br/>
                                        <small class="text-muted mail_to"><span>To: {{ $user->email }}</span></small>
                                    </div>
                                    <div class="ml-auto">
                                        <small class="text-muted mail_date_time">
                                            <span>
                                                {{ date('d-m-Y', strtotime($mail_data->mail_send_date)) }} {{ date('H i a', strtotime($mail_data->mail_send_date)) }}
                                            </span>
                                        </small>
                                    </div>
                                </div>
                                <div class="mail_uname">
                                    <span>{{ $form->fullname }},</span>
                                </div>
                                <div class="mail_body">
                                    <div>
                                        @php echo $mail_data->mail_body; @endphp
                                    </div>
                                    {{-- <div class="row"> --}}
                                    <?php 
                                        // $fpa = DB::table("form_process_actions")->where("application_form_id", $form->id)->first();
                                        // $files = explode(",",$fpa->payment_accepted_slips);
                                        // foreach ($files as $file) {
                                        //     $filename = asset('storage/user_attachments/'.$form->id.'/'.$file);
                                        //     $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                        //     ;
                                        ?>
                                            {{-- @if($ext != 'pdf')
                                            <div class="col-md-2">
                                                <img src="{{ asset('storage/user_attachments/'.$form->id.'/'.$file) }}" alt="{{ $file }}" class="img-thumbnail"  data-toggle="modal" data-target="#myImg">
                                            </div>
                                            @else
                                                <a href="{{ asset('storage/user_attachments/'.$form->id.'/'.$file) }}" target="_blank" class="pdf-block">{{ $file }}</a>
                                            @endif --}}
                                        <?php //}
                                    ?>
                                    {{-- </div> --}}
                                </div>
                                
                                <div class="text-right">
                                    <span>{{divType($form->div_state_id)}}</span><br/>
                                    <span>e-Meter Support Team</span><br/>
                                    <span><a href="http://www.moee.gov.mm">www.moee.gov.mm</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-lg-9 col-md-8 bg-light border-left mail-detail-div">
                        <div class="card mb-0 select-to-read-view m-l-10 m-r-10 min-h-100p">
                            <div class="card-body text-center p-t-100">
                                <i class="ti-email size-lg text-fade"></i>
                                <p class="text-fade">{{ __('lang.select_to_read')}}</p>
                            </div>
                        </div>
                        <div class="card mb-0 mail-view m-l-10 m-r-10 d-none">
                            <div class="card-body">
                                <h3 class="card-title send_type m-b-0"></h3>
                            </div>

                            <div><hr class="m-t-0"></div>
                            
                            <div class="card-body">
                                <div class="d-flex m-b-40">
                                    <div class="single-mail">
                                        <small class="text-muted mail_from"></small>
                                        <br/>
                                        <small class="text-muted mail_to"></small>
                                    </div>
                                    <div class="ml-auto">
                                        <small class="text-muted mail_date_time"></small>
                                    </div>
                                </div>
                                <div class="mail_uname"></div>
                                <div class="mail_body"></div>
                                <div class="text-right">
                                    <p>လျှပ်စစ်နှင့်စွမ်းအင် ဝန်ကြီးဌာန</p>
                                    <p>e-Meter Support Team</p>
                                    <p><a href="http://www.moee.gov.mm">www.moee.gov.mm</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <div class="modal" id="myImg" tabindex="-1" role="dialog" aria-labelledby="myLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-right">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="" alt="" width="700">
                    <p class="mt-5"></p>
                </div>
            </div>
        </div>
    </div>

@endsection
