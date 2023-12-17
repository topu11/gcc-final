@extends('layouts.default')

@section('content')

    <style>
        .blink {
            animation: blinker 1.5s linear infinite;
            color: red;
            font-family: sans-serif;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
            </div>
            @if (Request::is('appeal/trial_date_list'))
                @if (Auth::user()->role_id == 27 ||
                        Auth::user()->role_id == 6 ||
                        Auth::user()->role_id == 34 ||
                        Auth::user()->role_id == 25)
                    <div class="card-toolbar">
                        <a href="{{ route('appeal.hearingTimeUpdate') }}" class="btn btn-sm btn-primary font-weight-bolder">
                            <i class="la la-edit"></i>শুনানির সময় পরিবর্তন
                        </a>
                    </div>
                @endif
            @endif

            @if (Auth::user()->role_id == 5)
                <div class="card-toolbar">
                    <a href="{{ url('case/add') }}" class="btn btn-sm btn-primary font-weight-bolder">
                        <i class="la la-plus"></i>নতুন মামলা এন্ট্রি
                    </a>
                </div>
            @endif
        </div>
        <div class="card-body overflow-auto">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif

            @include('appeal.search')
            @php
                $today = date('Y-m-d', strtotime(now()));
                $today_time = date('H:i:s', strtotime(now()));
            @endphp
            <table class="table table-hover mb-6 font-size-h5">
                <thead class="thead-customStyle2 font-size-h6">
                    <tr>
                        <th scope="col" width="30">ক্রমিক নং</th>
                        {{-- <th scope="col">ক্রমিক নং</th> --}}
                        <th scope="col">সার্টিফিকেট অবস্থা</th>
                        <th scope="col">মামলা নম্বর</th>
                        @if (globalUserInfo()->role_id == 34)
                            <th scope="col">জেলা</th>
                        @elseif(globalUserInfo()->role_id == 6)
                            <th scope="col">উপজেলা</th>
                        @endif
                        <th scope="col">ম্যানুয়াল মামলা নম্বর</th>
                        <th scope="col">আবেদনকারীর নাম</th>
                        <th scope="col">জেনারেল সার্টিফিকেট আদালত</th>
                        <th scope="col">পরবর্তী তারিখ</th>
                        <th scope="col" width="70">পদক্ষেপ</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($results as $key => $row)
                        <tr>

                            <td scope="row" class="tg-bn">{{ en2bn($key + $results->firstItem()) }}.</td>
                            <td> {{ appeal_status_bng($row->appeal_status) }}</td> {{-- Helper Function for Bangla Status --}}
                            <td>{{ $row->case_no }}</td>
                            <td>{{ $row->manual_case_no }}</td>
                            @if (globalUserInfo()->role_id == 34)
                                <td>{{ isset($row->district->district_name_bn) ? $row->district->district_name_bn : ' ' }}
                                </td>
                            @elseif(globalUserInfo()->role_id == 6)
                                <td>{{ isset($row->upazila->upazila_name_bn) ? $row->upazila->upazila_name_bn : ' ' }}</td>
                            @endif
                            @if ($row->is_applied_for_review == 0)
                                <td>
                                    {{-- @dd($row->id); --}}
                                    @php
                                        $applicant_name = DB::table('gcc_appeal_citizens')
                                            ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                                            ->where('gcc_appeal_citizens.appeal_id', $row->id)
                                            ->where('gcc_appeal_citizens.citizen_type_id', 1)
                                            ->select('gcc_citizens.citizen_name')
                                            ->first();
                                    @endphp
                                    {{ $applicant_name->citizen_name }}
                                </td>
                            @else
                                <td>{{ $row->reviewerName->name }}</td>
                            @endif
                            <td>@php
                                if (isset($row->court_id)) {
                                    echo DB::table('court')
                                        ->where('id', $row->court_id)
                                        ->first()->court_name;
                                }
                            @endphp</td>
                            <td>{{ $row->next_date == '1970-01-01' ? '-' : en2bn($row->next_date) }}</td>

                            <td>
                                <div class="btn-group float-right">
                                    <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item"
                                            href="{{ route('appeal.appealView', encrypt($row->id)) }}">বিস্তারিত তথ্য</a>
                                        @if (globalUserInfo()->role_id != 35)
                                            @if ($row->appeal_status != 'SEND_TO_ASST_GCO' && $row->appeal_status != 'SEND_TO_GCO')
                                                <a class="dropdown-item"
                                                    href="{{ route('appeal.nothiView', encrypt($row->id)) }}">নথি দেখুন</a>
                                            @endif

                                            @if ($row->next_date == $today && $row->next_date_trial_time <= $today_time && $row->appeal_status != 'CLOSED' && $row->is_hearing_required == 1)
                                                <a class="dropdown-item blink"
                                                    href="{{ route('jitsi.meet', ['appeal_id' => encrypt($row->id)]) }}"
                                                    style="color: red;" target="_blank">অনলাইন শুনানি</a>
                                            @endif

                                            @if (globalUserInfo()->role_id == 28)
                                                @if ($row->action_required == 'GCO' && $row->appeal_status != 'CLOSED')
                                                    <a class="dropdown-item" href="#">জিসিও এর আদেশের অপেক্ষায়</a>
                                                @else
                                                    @if ($row->appeal_status == 'SEND_TO_ASST_GCO')
                                                        <a class="dropdown-item"
                                                            href="{{ route('appeal.edit', encrypt($row->id)) }}">সংশোধন ও
                                                            প্রেরণ</a>
                                                    @elseif($row->action_required == 'ASST' && $row->appeal_status != 'CLOSED')
                                                        <a class="dropdown-item"
                                                            href="{{ route('appeal.edit', encrypt($row->id)) }}">সংশোধন ও
                                                            প্রেরণ</a>
                                                    @endif
                                                @endif
                                            @endif
                                            @if ($row->action_required == 'ASST' && $row->appeal_status != 'CLOSED' && globalUserInfo()->role_id != 28)
                                                <a class="dropdown-item" href="#">সহকারীর অপেক্ষায়</a>
                                            @else
                                                @if (globalUserInfo()->role_id == 6 ||
                                                        globalUserInfo()->role_id == 25 ||
                                                        globalUserInfo()->role_id == 27 ||
                                                        globalUserInfo()->role_id == 34)
                                                    @if ($row->appeal_status == 'SEND_TO_GCO')
                                                        {{-- <a class="dropdown-item" href="{{ route('appeal.status_change', encrypt($row->id)) }}?status=REJECTED">মামলা বর্জন  করুন</a> --}}
                                                        <a class="dropdown-item"
                                                            href="{{ route('appeal.trial', encrypt($row->id)) }}">মামলা
                                                            গ্রহণ
                                                            করুন</a>
                                                    @elseif (
                                                        $row->appeal_status == 'SEND_TO_DC' ||
                                                            $row->appeal_status == 'SEND_TO_DIV_COM' ||
                                                            $row->appeal_status == 'SEND_TO_LAB_CM')
                                                        @if (globalUserInfo()->role_id == 6 || globalUserInfo()->role_id == 25 || globalUserInfo()->role_id == 34)
                                                            <a class="dropdown-item"
                                                                href="{{ route('appeal.trial', encrypt($row->id)) }}">মামলা
                                                                গ্রহণ করুন</a>
                                                        @endif
                                                    @elseif (
                                                        $row->appeal_status == 'ON_TRIAL' ||
                                                            $row->appeal_status == 'ON_TRIAL_DC' ||
                                                            $row->appeal_status == 'ON_TRIAL_DIV_COM' ||
                                                            $row->appeal_status == 'ON_TRIAL_LAB_CM')
                                                        <a class="dropdown-item"
                                                            href="{{ route('appeal.trial', encrypt($row->id)) }}">কার্যক্রম
                                                            পরিচালনা করুন</a>
                                                    @endif
                                                    @if (Request::url() === route('appeal.collectPaymentList'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('appeal.collectPayment', encrypt($row->id)) }}">অর্থ
                                                            আদায়</a>
                                                    @endif
                                                @endif
                                            @endif

                                            
                                        @else
                                            @if ($row->appeal_status == 'DRAFT')
                                                <a class="dropdown-item"
                                                    href="{{ route('appeal.edit', encrypt($row->id)) }}">সংশোধন করুন</a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {!! $results->links() !!}
            </div>
        </div>
        <!--end::Card-->

    @endsection

    {{-- Includable CSS Related Page --}}
    @section('styles')
        <!-- <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> -->
        <!--end::Page Vendors Styles-->
    @endsection

    {{-- Scripts Section Related Page --}}
    @section('scripts')
        <!-- <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
               <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
             -->


        <!--end::Page Scripts-->
    @endsection
