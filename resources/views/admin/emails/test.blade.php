@extends('layouts.login')

@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="row justify-content-center">
                    <div class="col-lg-9 col-md-8 bg-light border-left mail-detail-div">
                        <div class="card mb-0 mail-view m-l-10 m-r-10">
                            <div class="card-body">
                                <div class="d-flex m-b-40">
                                    <div class="single-mail">
                                        <small class="text-muted mail_from"><span>From: {{ 'no-reply@moee.gov.mm' }}</span></small>
                                        <br/>
                                        <small class="text-muted mail_to"><span>To: {{ 'htetaung@thenexthop.net' }}</span></small>
                                    </div>
                                    <div class="ml-auto">
                                        <small class="text-muted mail_date_time">
                                            <span>
                                                {{ date('d-m-Y H:i:s a') }}
                                            </span>
                                        </small>
                                    </div>
                                </div>
                                <div class="mail_uname">
                                    <span>{{ 'Dear Customer '.$mail_detail['name'] }},</span>
                                </div>
                                <div class="mail_body">
                                    <div>
                                        @php echo $mail_detail['mail_body']; @endphp
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span>လျှပ်စစ်နှင့်စွမ်းအင် ဝန်ကြီးဌာန</span><br/>
                                    <span>e-Meter Support Team</span><br/>
                                    <span><a href="http://www.moee.gov.mm">moee.gov.mm</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection