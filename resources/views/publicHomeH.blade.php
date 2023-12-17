@extends('layouts.landing')

@section('style')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('custom/style.bundle.css') }}" />
@endsection

@section('content')


        @auth
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-md-4"style="text-align:center;">
                                <img src="{{ asset('images/book.png') }}" alt="Girl in a jacket" width="100%" height="250">
                            </div>
                            <div class="col-md-8">    
                                <div style="margin-top: 200px; margin-left: 55px;">
                                    <h1 style="; margin-left: 80px; font-size: 35px; font-weight: 600;">স্মার্ট জেনারেল সার্টিফিকেট আদালত</h1>
                                </div>
                            </div>
                            <div class="col-md-12 mt-5">
                                গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের জেনারেল সার্টিফিকেট আদালত ব্যবস্থার অনলাইন প্ল্যাটফর্মে আপনাকে স্বাগতম। সিস্টেমটির মাধ্যমে প্রতিষ্ঠান মামলার আবেদন করতে পারবে, আপীল করতে পারবে এবং আপীলের সর্বশেষ অবস্থা সম্পর্কে জানতে পারবে। পাশাপাশি প্রতিষ্ঠান মামলা দাখিল করার পর মামলার সর্বশেষ অবস্থা সম্পর্কে সিস্টেম কর্তৃক স্বয়ংক্রিয়ভাবে SMS ও ই-মেইলের মাধ্যমে জানানো হবে। প্রতিষ্টানের ও জনগণের সময় ও শ্রম লাঘবকল্পে একটি ইলেক্ট্রনিক সিস্টেমের মাধ্যমে তাদেরকে মামলার নকল সরবরাহ ও সেবা প্রদানের বিষয়ে গুরুত্বপূর্ণ ভূমিকা রাখবে।
                            </div>
                            {{-- <div class="col-md-6 mt-5">
                                <a href=""><button type="button" class="px-15 btn btn-success" >বিস্তারিত</button></a>
                                <a href="">
                                    <span class="svg-icon svg-home-play svg-icon-primary svg-icon-2x">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M9.82866499,18.2771971 L16.5693679,12.3976203 C16.7774696,12.2161036 16.7990211,11.9002555 16.6175044,11.6921539 C16.6029128,11.6754252 16.5872233,11.6596867 16.5705402,11.6450431 L9.82983723,5.72838979 C9.62230202,5.54622572 9.30638833,5.56679309 9.12422426,5.7743283 C9.04415337,5.86555116 9,5.98278612 9,6.10416552 L9,17.9003957 C9,18.1765381 9.22385763,18.4003957 9.5,18.4003957 C9.62084305,18.4003957 9.73759731,18.3566309 9.82866499,18.2771971 Z" fill="#000000"/>
                                            </g>
                                        </svg><!--end::Svg Icon-->
                                    </span>Watch Video
                                </a>
                            </div> --}}
                        </div>

                    </div>
                </div>
            
                <div class="col-md-12 mt-10 row" style="background-color:#f0f1ef ;">
                    <div class="col-md-1 mt-5">
                      <p  type="text">খবরঃ</p>
                    </div>
                    <div class="col-md-11 mt-5">
                        <marquee style="font-size: 18px" direction="left" scrollamount="3" onmouseover="this.stop()"
                            onmouseout="this.start()">
                            @foreach ($short_news as $row)
                                {{ $row->news_details }}
                            @endforeach
                        </marquee>
                    </div>
                </div>
            </div>
        @else
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-md-4"style="text-align:center;">
                                <img src="{{ asset('images/book.png') }}" alt="Girl in a jacket" width="400" height="250">
                            </div>
                            <div class="col-md-8">    
                                
                            </div>
                            <div class="col-md-12 py-2">
                                
                            <h1 style="font-weight: 700">স্মার্ট জেনারেল সার্টিফিকেট আদালত</h1>
                               
                            </div>
                            <div class="col-md-12" style="font-size: 16px;
                            text-align: justify;
                            line-height: 30px;">
                               গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের জেনারেল সার্টিফিকেট আদালত ব্যবস্থার অনলাইন প্ল্যাটফর্মে আপনাকে স্বাগতম। সিস্টেমটির মাধ্যমে প্রতিষ্ঠান মামলার আবেদন করতে পারবে, আপীল করতে পারবে এবং আপীলের সর্বশেষ অবস্থা সম্পর্কে জানতে পারবে। পাশাপাশি প্রতিষ্ঠান মামলা দাখিল করার পর মামলার সর্বশেষ অবস্থা সম্পর্কে সিস্টেম কর্তৃক স্বয়ংক্রিয়ভাবে SMS ও ই-মেইলের মাধ্যমে জানানো হবে। প্রতিষ্টানের ও জনগণের সময় ও শ্রম লাঘবকল্পে একটি ইলেক্ট্রনিক সিস্টেমের মাধ্যমে তাদেরকে মামলার নকল সরবরাহ ও সেবা প্রদানের বিষয়ে গুরুত্বপূর্ণ ভূমিকা রাখবে।
                            </div>
                            {{-- <div class="col-md-6 mt-5">
                                <a href=""><button type="button" class="px-15 btn btn-success" >বিস্তারিত</button></a>
                                <a class="svg-home-play" href="">
                                    <span class="svg-icon  svg-icon-primary svg-icon-2x">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M9.82866499,18.2771971 L16.5693679,12.3976203 C16.7774696,12.2161036 16.7990211,11.9002555 16.6175044,11.6921539 C16.6029128,11.6754252 16.5872233,11.6596867 16.5705402,11.6450431 L9.82983723,5.72838979 C9.62230202,5.54622572 9.30638833,5.56679309 9.12422426,5.7743283 C9.04415337,5.86555116 9,5.98278612 9,6.10416552 L9,17.9003957 C9,18.1765381 9.22385763,18.4003957 9.5,18.4003957 C9.62084305,18.4003957 9.73759731,18.3566309 9.82866499,18.2771971 Z" fill="#000000"/>
                                            </g>
                                        </svg><!--end::Svg Icon-->
                                    </span>
                                    <strong>Watch Video</strong>
                                </a>
                            </div> --}}
                        </div>

                    </div>
                    <div class="col-lg-3" style="margin-top:70px;">

                        <div class="card"  style=" height:350px; background: #f6f6f7 !important;">
                             <div class="card-body" style="margin-top:80px;text-align:center;">
                                {{-- <input type="button" id="loginID" class="btn btn-success btn-block active" value="{{ __('লগইন') }}"
                                data-toggle="modal" data-target="#exampleModalLong">
                                <input type="button" id="loginID2" class="btn btn-success btn-block active"
                                value="{{ __('CDAP দিয়ে লগইন') }}" data-toggle="modal" data-target="#exampleModalLong2">
                                <a href="{{ url('/registration') }}" type="button" class="btn btn-success btn-block active"
                                value="">{{ __('নিবন্ধন') }}</a> --}}
                                <a href="{{ url('/login/page') }}" type="button" class="btn btn-success btn-block active"
                                value="">{{ __('লগইন') }}</a>
                                <a href="{{ url('/registration') }}" type="button" class="btn btn-success btn-block active"
                                value="">{{ __('নিবন্ধন') }}</a>
                          
                             </div>
                        </div> 
                    </div>
                </div>
            
                <div class="row mt-5" style="background-color:#f0f1ef;margin-left:-2px;margin-right:-2px">
                    <div class="col-md-1 mt-5">
                        <p type="text">খবরঃ</p>
                    </div>
                    <div class="col-md-11 mt-5">
                        <marquee style="font-size: 18px" direction="left" scrollamount="3" onmouseover="this.stop()"
                            onmouseout="this.start()">
                            @foreach ($short_news as $row)
                                {{ $row->news_details }}
                            @endforeach
                        </marquee>
                    </div>
                </div>
            </div>
        @endauth
    
        @include('_information_help_center_links')
    
   
    {{-- <div class="py-10 py-lg-15 " id="startSection">
        <!--begin::Container-->
        <div class="container" style="margin-bottom: -50px">
                <h2 class="mb-6" style="color: green;">জনপ্রিয় খবর</h2>

                @include('_sliders')
               
        </div>
    </div>  --}}

   
    <!--end::Wrapper-->
    @include('layouts.landing._tools')
    @endsection
    @section('scripts')
        <script src="{{ asset('js/initiate/init.js') }}"></script>
        <script src="{{ asset('js/location/location.js') }}"></script>
        <script src="{{ asset('js/englishToBangla/convertEngToBangla.js') }}"></script>
        <script src="{{ asset('js/home.js') }}"></script>
        <script>
            $(document).ready(function() {
                $("a.h2.btn.btn-info").on('click', function(event) {
                    if (this.hash !== "") {
                        event.preventDefault();
                        var hash = this.hash;
                        $('html, body').animate({
                            scrollTop: $(hash).offset().top
                        }, 800, function() {
                            window.location.hash = hash;
                        });
                    } // End if
                });
            });
        </script>
        <script type="text/javascript">
            function labelmk(){
                var _token = $("input[name='_token']").val();
                var email = $("input[name='email']").val();
                var password = $("input[name='password']").val();
                $("input[name='button']").val('অপেক্ষা করুন...');
                if(email == '' || password == ''){
                    $("input[name='email']").removeClass('border-info');
                    $("input[name='password']").removeClass('border-info');
                    toastr.warning('Email or password not will be null!', "Error");
                    setTimeout(function(){
                        $("input[name='button']").val('লগইন ইন');
                    }, 300);
                    return;
                }
                $("input[name='email']").addClass('border-info');
                $("input[name='password']").addClass('border-info');

                $.ajax({
                    url: "{{ url('') }}/csLogin",
                    type: 'POST',
                    data: {
                        _token: _token,
                        email: email,
                        password: password,
                    },
                    success: function(data) {
                        console.log(data);
                        if ($.isEmptyObject(data.error)) {
                            toastr.success(data.success, "Success");
                            $('#exampleModalLong').modal('toggle');
                            console.log(data.success);
                            setTimeout(function(){
                                // location.reload();
                                $(location).attr('href', "{{ url('') }}/dashboard");
                            }, 1000);
                        } else {
                            toastr.error(data.error, "Error");
                            $("input[name='button']").val('লগইন ইন');
                            // console.log(data.error);
                        }
                    }
                });
            }
            $("input.form-control").on('keypress', function(e) {
                // e.preventDefault();
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    $("input[name='button']").trigger("click");
                    return;
                }
            });

            jQuery(document).ready(function() {
                if ( window.location.hash ) {
                    function showVideo(hash) {
                    console.log(hash);
                    $('#loginID').modal('show');
                    }

                    jQuery(document).click(showVideo(window.location.hash));
                    console.log('hash');


                }
            });
        </script>
    @endsection
