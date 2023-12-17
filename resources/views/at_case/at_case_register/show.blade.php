@php
   $user = Auth::user();
   $roleID = Auth::user()->role_id;
@endphp

@extends('layouts.default')

@section('content')

<style type="text/css">
   .tg {border-collapse:collapse;border-spacing:0;width: 100%;}
   .tg td{border-color:black;border-style:solid;border-width:1px;font-size:14px;overflow:hidden;padding:6px 5px;word-break:normal;}
   .tg th{border-color:black;border-style:solid;border-width:1px;font-size:14px;font-weight:normal;overflow:hidden;padding:6px 5px;word-break:normal;}
   .tg .tg-nluh{background-color:#dae8fc;border-color:#cbcefb;text-align:left;vertical-align:top}
   .tg .tg-19u4{background-color:#ecf4ff;border-color:#cbcefb;font-weight:bold;text-align:right;vertical-align:top}
</style>

<!--begin::Card-->
<div class="card card-custom">
   <div class="card-header flex-wrap py-5">
      {{-- <div class="card-title"> --}}
          <div class="container">
              <div class="row">
                  <div class="col-10"><h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3></div>
                  {{-- <div class="col-8">fdsafsad</div> --}}
                  {{-- <div class="col-2"><a href="{{ route('messages_group') }}" class="btn btn-primary float-right">Message</a></div> --}}
                 <!--  <div class="col-2">
                      @if(Auth::user()->role_id == 2)
                      <a href="{{ route('messages_group') }}?c={{ $info->id }}" class="btn btn-primary float-right">বার্তা</a>
                        @endif
                    </div> -->
              </div>
          </div>
         {{-- <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>

         <table>
             <tr align="right">
                 <th>
                     <a  href="" class="btn btn-primary float-right">Message</a>

                 </th>
             </tr>
         </table> --}}
      {{-- </div> --}}
      @if ($roleID == 5 || $roleID == 7 || $roleID == 8 || $roleID == 19)
      <div class="card-toolbar text-left">
         <a href="{{ route('atcase.edit', $info->id) }}" class="btn btn-sm btn-primary font-weight-bolder">
            <i class="la la-edit"></i>মামলা সংশোধন করুন
         </a>
         <!-- &nbsp;
         <a href="{{ url('case/create') }}" class="btn btn-sm btn-primary font-weight-bolder">
            <i class="la la-plus"></i>পুরাতন চলমান মামলা এন্ট্রি
         </a>   -->
      </div>
      @endif
   </div>
   <div class="card-body">
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
         {{ $message }}
      </div>
      @endif

      <div class="row">
         <div class="col-md-6">
            <h4 class="font-weight-bolder">সাধারণ তথ্য</h4>
            <table class="tg">
               <thead>
                  <tr>
                     <th class="tg-19u4" width="130">আদালতের নাম</th>
                     <td class="tg-nluh">{{ $info->court->court_name ?? ''}}</td>
                  </tr>
                  <tr>
                     <th class="tg-19u4">বিভাগ</th>
                     <td class="tg-nluh">{{ $info->division->division_name_bn ?? ''}}</td>
                  </tr>
                  <tr>
                     <th class="tg-19u4">জেলা</th>
                     <td class="tg-nluh">{{ $info->district->district_name_bn ?? ''}}</td>
                  </tr>
                  
                  <tr>
                     <th class="tg-19u4">অ্যাডভোকেট</th>
                     <td class="tg-nluh">{{ $info->advocate->name ?? ''}}</td>
                  </tr>
                  <tr>
                     <th class="tg-19u4">মামলা নং</th>
                     <td class="tg-nluh">{{ $info->case_no ?? ''}}</td>
                  </tr>
                  <tr>
                     <th class="tg-19u4">মামলা রুজুর তারিখ</th>
                     <td class="tg-nluh">{{ en2bn($info->case_date) ?? ''}}</td>
                  </tr>


                  <tr>
                     <th class="tg-19u4">ফলাফল</th>
                     <td class="tg-nluh">@if($info->case_result == '1')
                                              জয়!
                                         @elseif($info->case_result == '0')
                                              পরাজয়!
                                          @else
                                              চলমান
                                          @endif
                     </td>
                     {{-- @dd($info->case_result) --}}
                  </tr>
                  @if (!empty($info->lost_reason))
                  <tr>
                     <th class="tg-19u4">পরাজয়ের কারণ</th>
                     <td class="tg-nluh">{{ $info->lost_reason ?? ''}}</td>
                  </tr>
                  @endif
                  <tr>
                     <th class="tg-19u4">মামলায় হেরে গিয়ে কি আপিল করা হয়েছে</th>
                     <td class="tg-nluh">@if ($info->is_lost_appeal == 1)
                                              হ্যা!
                                          @else
                                              না!
                                          @endif
                     </td>
                  </tr>
                  @if(!empty( $info->ref_id))
                  <tr>
                     <th class="tg-19u4">পূর্বের মামলা নং</th>
                     <td class="tg-nluh"><a href="{{ route('case.details', $info->ref_id) }}" target="_blank">{{ $info->ref_case_no }}</a> </td>
                  </tr>
                  @endif
                  <tr>
                     <th class="tg-19u4">মামলার বর্তমান অবস্থান</th>
                     <td class="tg-nluh">{{ $info->status_name }}, এর জন্য {{ $info->role_name }} এর কাছে</td>
                  </tr>
                  <tr>
                     <th class="tg-19u4">বর্তমান ষ্ট্যাটাস</th>
                     <td class="tg-nluh"> @if ($info->status == 1)
                                              নতুন চলমান!
                                          @elseif ($info->status == 2)
                                              আপিল করা হয়েছে!
                                          @elseif ($info->status == 3)
                                              সম্পাদিত !
                                          @endif

                     </td>
                  </tr>
               </thead>
            </table>
             <br>
            <h4 class="font-weight-bolder">বিচারক প্যানেলের</h4>
            <table class="tg">
               <thead>
                  <tr>
                     <th class="tg-19u4" width="10">ক্রম</th>
                     <th class="tg-19u4 text-center" width="200">বিচারকের নাম</th>
                     <th class="tg-19u4 text-center">পদবি</th>
                  </tr>
               </thead>
               <tbody>
            @php $k = 1; @endphp
            @foreach ($judges as $judge)

                  <tr>
                     <td class="tg-nluh">{{ en2bn($k) }}.</td>
                     <td class="tg-nluh">{{ $judge->justis_name }}</td>
                     <td class="tg-nluh">{{ $judge->designation }}</td>
                  </tr>
             @php $k++; @endphp
            @endforeach
               </tbody>
            </table>

      </div>
      <div class="col-md-6">
            <h4 class="font-weight-bolder">বাদীর বিবরণ</h4>
            <table class="tg">
               <thead>
                  <tr>
                     <th class="tg-19u4" width="10">ক্রম</th>
                     <th class="tg-19u4 text-center" width="200">নাম</th>
                     <th class="tg-19u4 text-center">পিতা/স্বামীর নাম</th>
                     <th class="tg-19u4 text-center">ঠিকানা</th>
                  </tr>
               </thead>
               <tbody>
              @php $k = 1; @endphp
         @foreach ($badis as $badi)
            <tr>
               <td class="tg-nluh">{{en2bn($k)}}.</td>
               <td class="tg-nluh">{{ $badi->name }}</td>
               <td class="tg-nluh">{{ $badi->designation }}</td>
               <td class="tg-nluh">{{ $badi->address }}</td>
            </tr>
         @php $k++; @endphp
         @endforeach
               </tbody>
            </table>

            
            <br>
            <h4 class="font-weight-bolder">বিবাদীর বিবরণ</h4>
            <table class="tg">
               <thead>
                  <tr>
                     <th class="tg-19u4" width="10">ক্রম</th>
                     <th class="tg-19u4 text-center" width="200">নাম</th>
                     <th class="tg-19u4 text-center">পিতা/স্বামীর নাম</th>
                     <th class="tg-19u4 text-center">ঠিকানা</th>
                  </tr>
               </thead>
               <tbody>
            @php $k = 1; @endphp
            @foreach ($bibadis as $bibadi)

                  <tr>
                     <td class="tg-nluh">{{ en2bn($k) }}.</td>
                     <td class="tg-nluh">{{ $bibadi->name }}</td>
                     <td class="tg-nluh">{{ $bibadi->designation }}</td>
                     <td class="tg-nluh">{{ $bibadi->address }}</td>
                  </tr>
             @php $k++; @endphp
            @endforeach
               </tbody>
            </table>

            <br>
            <h4 class="font-weight-bolder">আদেশের বিবরণ</h4>
            <table class="tg">
               <thead>
                  <tr>
                     <th class="tg-19u4" width="10">ক্রম</th>
                     <th class="tg-19u4 text-center" width="200">আদেশ দাতার নাম</th>
                     <th class="tg-19u4 text-center">সেকশন</th>
                     <th class="tg-19u4 text-center">তারিখ</th>
                  </tr>
               </thead>
               <tbody>
            @php $k = 1; @endphp
            @foreach ($orders as $order)

                  <tr>
                     <td class="tg-nluh">{{ en2bn($k) }}.</td>
                     <td class="tg-nluh">{{ $order->order_by }}</td>
                     <td class="tg-nluh">{{ $order->section }}</td>
                     <td class="tg-nluh">{{ $order->date }}</td>
                  </tr>
             @php $k++; @endphp
            @endforeach
               </tbody>
            </table>
           
      </div>
   </div>
   <br>
   <br>
   <br>
   <br>

   <div class="row">
      <div class="col-md-5">
         @if($info->order_date != NULL)
          <h4 class="font-weight-bolder">আদেশের তারিখ সমুহ</h4>
            <table class="tg">
               <tr>
                  <th class="tg-19u4 text-left" width="150">আদেশের তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($info->order_date) }}</td>
               </tr>
               @endif
               @if($info->next_assign_date != NULL)
               <tr>
                  <th class="tg-19u4 text-left" width="150">পরবর্তী ধার্য তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($info->next_assign_date) }}</td>
               </tr>
               @endif
               @if($info->past_order_date != NULL)
               <tr>
                  <th class="tg-19u4 text-left" width="150">বিগত তারিখের আদেশ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($info->past_order_date) }}</td>
               </tr>
               @endif
            </table>
      </div>
   </div>
   <br>

   
    

   <div class="row">
      <div class="col-md-4">
         <h4 class="font-weight-bolder">কারণ দর্শাইবার স্ক্যান কপি</h4>
         <a href="#" class="btn btn-success btn-shadow font-weight-bold font-size-h4" data-toggle="modal" data-target="#showCauseModal">
            <i class="fa fas fa-file-pdf icon-md"></i> কারণ দর্শাইবার স্ক্যান কপি
         </a>

         <!-- Modal-->
         <div class="modal fade" id="showCauseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title font-weight-bolder font-size-h3" id="exampleModalLabel">কারণ দর্শাইবার স্ক্যান কপি</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                     </button>
                  </div>
                  <div class="modal-body">

                     <embed src="{{ asset($info->notice_file) }}" type="application/pdf" width="100%" height="400px" />

                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold font-size-h5" data-dismiss="modal">বন্ধ করুন</button>
                     </div>
                  </div>
               </div>
            </div> <!-- /modal -->
      </div>
     
   </div>
   <br>
   <div class="row">
    @if($info->sf_report != NULL)
         <div class="col-md-4">
            <h4 class="font-weight-bolder">এস এফ এর চূড়ান্ত প্রতিবেদন</h4>
            <a href="#" class="btn btn-success btn-shadow font-weight-bold font-size-h4" data-toggle="modal" data-target="#sfFinalFile">
               <i class="fa fas fa-file-pdf icon-md"></i> এস এফ এর চূড়ান্ত প্রতিবেদন
            </a>

            <!-- Modal-->
            <div class="modal fade" id="sfFinalFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-xl" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title font-weight-bolder font-size-h3" id="exampleModalLabel">এস এফ এর চূড়ান্ত প্রতিবেদন</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                     </div>
                     <div class="modal-body">

                        <embed src="{{ asset('uploads/sf_report/'.$info->sf_report) }}" type="application/pdf" width="100%" height="400px" />

                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-light-primary font-weight-bold font-size-h5" data-dismiss="modal">বন্ধ করুন</button>
                        </div>
                     </div>
                  </div>
               </div> <!-- /modal -->
         </div>
         @endif
         @if($info->order_file != NULL)

         <div class="col-md-4">
            <h4 class="font-weight-bolder">আদেশের ফাইল</h4>
            <a href="#" class="btn btn-success btn-shadow font-weight-bold font-size-h4" data-toggle="modal" data-target="#orderFile">
               <i class="fa fas fa-file-pdf icon-md"></i> আদেশের ফাইল
            </a>

            <!-- Modal-->
            <div class="modal fade" id="orderFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-xl" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title font-weight-bolder font-size-h3" id="exampleModalLabel">আদেশের ফাইল</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                     </div>
                     <div class="modal-body">

                        <embed src="{{ asset('uploads/order/'.$info->order_file) }}" type="application/pdf" width="100%" height="400px" />

                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-light-primary font-weight-bold font-size-h5" data-dismiss="modal">বন্ধ করুন</button>
                        </div>
                     </div>
                  </div>
               </div> <!-- /modal -->
         </div>
   </div>
    @endif

</div>
<!--end::Card-->

@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page--}}
@section('scripts')
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
<!--end::Page Scripts-->
@endsection


