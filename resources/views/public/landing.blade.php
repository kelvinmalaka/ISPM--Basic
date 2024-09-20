@extends('layouts.public')

@section('content')
    <section id="home" class="section-swiper-absoulte text-center min-h-screen flex items-center wow fadeIn">
        <canvas class="waves" data-speed="5" data-wave-width="150%" data-animation="SineInOut"></canvas>

        <div class="section-swiper-content">
            <div class="container px-12 md:px-24 lg:px-80 mx-auto">
                <div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold uppercase text-white wow fadeScale"
                        data-caption-animate="fadeInUp" data-caption-delay="100" data-caption-duration="900">
                        School of Information Systems Contests
                    </h1>
                    <h4 class="my-10 text-2xl lg:text-3xl font-semibold uppercase text-white wow fadeInUp"
                        data-wow-delay=".8s" data-caption-animate="fadeInUp" data-caption-delay="300"
                        data-caption-duration="900">
                        Bina Nusantara University
                    </h4>
                </div>
            </div>

            <div class="video-link-wrapper">
                <div class="flex flex-col md:flex-row gap-4 items-center">
                    <div class="text-right">
                        <span class="text-lg lg:text-2xl uppercase text-white">
                            Our Profile
                        </span>
                    </div>

                    <div>
                        <a class="video-link" href="https://youtu.be/QV-lUxKXOZU" data-lightgallery="item">
                            <div class="video-link-bg" data-triangle=".video-link-overlay">
                                <span class="video-link-overlay"></span>
                            </div>
                            <span class="icon">
                                <i class="bi-play"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="swiper-container swiper-slider swiper-slider-1" data-loop="true" data-simulate-touch="false"
            data-autoplay="8500" data-direction="horizontal" data-effect="fade">
            <div class="swiper-wrapper">
                <div class="swiper-slide" data-slide-bg="{{ asset('img/hero-01.jpg') }}"></div>
                <div class="swiper-slide" data-slide-bg="{{ asset('img/hero-02.jpg') }}"></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <section id="about" class="py-16 lg:py-32 bg-white wow fadeIn">
        <div class="container px-12 md:px-24 lg:px-40 mx-auto">
            <div class="grid lg:grid-cols-7 gap-8 lg:gap-16 items-center">
                <div class="lg:col-span-4">
                    <h6 class="font-bold uppercase">About Us</h6>
                    <h3 class="text-2xl lg:text-5xl font-bold uppercase">
                        School of Information Systems.
                    </h3>
                    <p class="font-normal text-gray-500">
                        School of Information Systems offers six programs within, they are Information Systems, Information
                        Systems Accounting and Auditing, Business Information Technology, Business Analytics and two double
                        degree programs are Information Systems & Accounting and Information Systems & Management.
                        <br />
                        <br />
                        Domain of Studies at School of Information Systems are Information Technology and Business. All
                        programs under School of Information Systems focus on these two domains of studies, the basic
                        competency of graduate from School of Information Systems is the ability to deploy and manage
                        Information Technology in Business.
                    </p>

                    <a class="button button-primary mt-10" href="https://sis.binus.ac.id/" data-triangle=".button-overlay"
                        target="_blank">
                        <span>
                            Read More
                            <i class="bi-arrow-right ml-2"></i>
                        </span>
                        <span class="button-overlay"></span>
                    </a>
                </div>
                <div class="lg:col-span-3">
                    <div class="wow fadeScale">
                        <figure class="w-full">
                            <img src="{{ asset('img/sisbanner.jpg') }}" class="w-full h-full object-contain"
                                alt="School of Information Systems" />
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="events" class="py-16 lg:py-32 bg-white text-center">
        <div class="container px-6 md:px-20 lg:px-40 mx-auto">
            <h6 class="font-bold uppercase">Available Contests</h6>
            <h3 class="text-3xl font-bold uppercase">Ongoing Events.</h3>

            <div class="mb-5 mt-10">
                @foreach ($contests as $contest)
                    <article class="grid lg:grid-cols-5 border border-gray-200 rounded-lg overflow-hidden mb-5 text-left">
                        <figure class="lg:col-span-2 skeleton bg-gray-200 w-full h-full rounded-none overflow-hidden">
                            <img src="{{ asset($contest->banner_img_path) }}" alt="Banner {{ $contest->title }}"
                                class="object-cover w-full h-full" />
                        </figure>

                        <div class="lg:col-span-3 p-8 bg-white">
                            <div class="mb-5">
                                <h4 class="text-2xl font-bold mb-3">
                                    {{ $contest->title }}
                                </h4>
                                <p class="text-gray-500">
                                    {{ $contest->description }}
                                </p>
                            </div>

                            <div class="mb-5">
                                <h5 class="font-semibold mb-1 text-base">
                                    Available Categories
                                </h5>
                                <ul class="list-none">
                                    @foreach ($contest->categories as $category)
                                        <li class="text-gray-500">{{ $category->title }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <a href="{{ route($contests_path . '.show', ['contest' => $contest->id]) }}"
                                class="button button-secondary">
                                View Detail
                                <i class="bi-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
            <a class="button button-primary mt-10" href="{{ route($contests_path . '.index') }}"
                data-triangle=".button-overlay">
                <span>
                    View All Contests
                    <i class="bi-arrow-right ml-1"></i>
                </span>
                <span class="button-overlay"></span>
            </a>
        </div>
    </section>

    <section id="gallery" class="parallax-container" data-parallax-img="{{ asset('img/bg-parallax-01.jpg') }}">
        <div class="parallax-content py-16 lg:py-32 text-center parallax-overlay-gradient-primary-1">
            <div class="container px-12 md:px-24 mx-auto">
                <h6 class="font-bold uppercase text-white">Memory Album</h6>
                <h3 class="text-3xl font-bold uppercase text-white">Photo Gallery.</h3>

                <div class="grid md:grid-flow-col auto-cols-auto gap-4 mt-10" data-lightgallery="group">
                    <div class="wow">
                        <div>
                            <a class="thumbnail" href="{{ asset('img/placeholder.jpg') }}" data-lightgallery="item"
                                data-triangle=".thumbnail-overlay">
                                <span class="thumbnail-overlay"></span>
                                <span class="thumbnail-icon"></span>
                                <img src="{{ asset('img/placeholder.jpg') }}" class="w-full h-full object-cover"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="wow">
                        <div>
                            <a class="thumbnail" href="{{ asset('img/placeholder.jpg') }}" data-lightgallery="item"
                                data-triangle=".thumbnail-overlay">
                                <span class="thumbnail-overlay"></span>
                                <span class="thumbnail-icon"></span>
                                <img src="{{ asset('img/placeholder.jpg') }}" class="w-full h-full object-cover"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="wow">
                        <div>
                            <a class="thumbnail" href="{{ asset('img/placeholder.jpg') }}" data-lightgallery="item"
                                data-triangle=".thumbnail-overlay">
                                <span class="thumbnail-overlay"></span>
                                <span class="thumbnail-icon"></span>
                                <img src="{{ asset('img/placeholder.jpg') }}" class="w-full h-full object-cover"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="wow">
                        <div>
                            <a class="thumbnail" href="{{ asset('img/placeholder.jpg') }}" data-lightgallery="item"
                                data-triangle=".thumbnail-overlay">
                                <span class="thumbnail-overlay"></span>
                                <span class="thumbnail-icon"></span>
                                <img src="{{ asset('img/placeholder.jpg') }}" class="w-full h-full object-cover"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="wow">
                        <div>
                            <a class="thumbnail" href="{{ asset('img/placeholder.jpg') }}" data-lightgallery="item"
                                data-triangle=".thumbnail-overlay">
                                <span class="thumbnail-overlay"></span>
                                <span class="thumbnail-icon"></span>
                                <img src="{{ asset('img/placeholder.jpg') }}" class="w-full h-full object-cover"
                                    alt="" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section parallax-js py-16 lg:py-32 bg-white text-center">
        <div class="container px-12 md:px-24 lg:px-80 mx-auto">
            <h6 class="font-bold uppercase">Motivation</h6>
            <h3 class="text-3xl font-bold uppercase">Quote of the day.</h3>

            <div class="mt-10">
                <div class="slick-slider child-slick-slider" id="child-carousel" data-for=".carousel-parent"
                    data-arrows="true" data-loop="false" data-dots="false" data-swipe="true" data-items="3"
                    data-sm-items="3" data-md-items="3" data-lg-items="3" data-xl-items="3" data-slide-to-scroll="1">
                    <div class="item">
                        <a>
                            <img src="{{ asset('img/quotes.png') }}" class="h-full w-full object-cover"
                                alt="" />
                        </a>
                    </div>
                    <div class="item">
                        <a>
                            <img src="{{ asset('img/quotes.png') }}" class="h-full w-full object-cover"
                                alt="" />
                        </a>
                    </div>
                    <div class="item">
                        <a>
                            <img src="{{ asset('img/quotes.png') }}" class="h-full w-full object-cover"
                                alt="" />
                        </a>
                    </div>
                </div>
                <div class="slick-slider carousel-parent" data-arrows="false" data-loop="true" data-autoplay="true"
                    data-dots="false" data-swipe="true" data-items="1" data-child="#child-carousel"
                    data-for="#child-carousel">
                    <div class="item">
                        <div class="quote">
                            <div class="wow fadeIn">
                                <p class="quote-text heading-4">
                                    Competition is not about beating others, it's about pushing yourself to be better
                                    than you were yesterday.
                                </p>
                                <div class="quote-footer">
                                    <a class="quote-name" href="#">Rudy</a>
                                    <span class="quote-cite text-gray-500">- Dean of School of Information
                                        Systems</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="quote">
                            <div class="wow fadeIn">
                                <p class="quote-text heading-4">
                                    The real competition is between what you've done and what you're capable of doing.
                                    Compete against that.
                                </p>
                                <div class="quote-footer">
                                    <a class="quote-name" href="#">Nur Anisa</a>
                                    <span class="quote-cite text-gray-500">- Head of Information Systems
                                        Laboratory</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="quote">
                            <div class="wow fadeIn">
                                <p class="quote-text heading-4">
                                    In the battle of competition, your strongest weapon is your unwavering determination
                                    to succeed.
                                </p>
                                <div class="quote-footer">
                                    <a class="quote-name" href="#">Muhammad Wildan</a>
                                    <span class="quote-cite text-gray-500">- Research and Product Development
                                        Coordinator</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layer layer-01">
            <svg width="126" height="126" viewbox="0 0 126 126" fill="none" xmlns="http://www.w3.org/2000/svg">
                <mask id="mask0" maskunits="userSpaceOnUse" x="0" y="0" width="126" height="126">
                    <path
                        d="M126 63C126 97.7939 97.7939 126 63 126C28.2061 126 0 97.7939 0 63C0 28.2061 28.2061 0 63 0C97.7939 0 126 28.2061 126 63Z">
                    </path>
                </mask>
                <g mask="url(#mask0)">
                    <path d="M61.2694 -27.0047L-26.9917 61.2563L-22.5793 65.6687L65.6817 -22.5924L61.2694 -27.0047Z">
                    </path>
                    <path d="M71.0589 -17.2147L-17.2021 71.0464L-12.7898 75.4587L75.4712 -12.8023L71.0589 -17.2147Z">
                    </path>
                    <path d="M80.8724 -7.39484L-7.38867 80.8662L-2.97632 85.2786L85.2847 -2.98249L80.8724 -7.39484Z">
                    </path>
                    <path d="M90.6785 2.42205L2.41748 90.6831L6.82983 95.0955L95.0909 6.83441L90.6785 2.42205Z"></path>
                    <path d="M100.485 12.215L12.2236 100.476L16.636 104.888L104.897 16.6274L100.485 12.215Z"></path>
                    <path d="M110.298 22.0353L22.0371 110.296L26.4495 114.709L114.711 26.4476L110.298 22.0353Z"></path>
                    <path d="M120.095 31.8322L31.8335 120.093L36.2458 124.506L124.507 36.2445L120.095 31.8322Z"></path>
                    <path d="M129.901 41.6452L41.6401 129.906L46.0525 134.319L134.314 46.0575L129.901 41.6452Z"></path>
                    <path d="M139.698 51.4421L51.4365 139.703L55.8489 144.115L144.11 55.8544L139.698 51.4421Z"></path>
                    <path d="M149.521 61.2721L61.2598 149.533L65.6721 153.946L153.933 65.6845L149.521 61.2721Z"></path>
                </g>
            </svg>
        </div>
        <div class="layer layer-02">
            <svg width="95" height="65" viewbox="0 0 95 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="2.50049" cy="62.5005" r="2.5"></circle>
                <circle cx="20.5005" cy="62.5005" r="2.5"></circle>
                <circle cx="38.5005" cy="62.5005" r="2.5"></circle>
                <circle cx="56.5005" cy="62.5005" r="2.5"></circle>
                <circle cx="74.5005" cy="62.5005" r="2.5"></circle>
                <circle cx="92.5005" cy="62.5005" r="2.5"></circle>
                <circle cx="2.50049" cy="42.5005" r="2.5"></circle>
                <circle cx="20.5005" cy="42.5005" r="2.5"></circle>
                <circle cx="38.5005" cy="42.5005" r="2.5"></circle>
                <circle cx="56.5005" cy="42.5005" r="2.5"></circle>
                <circle cx="74.5005" cy="42.5005" r="2.5"></circle>
                <circle cx="92.5005" cy="42.5005" r="2.5"></circle>
                <circle cx="2.50049" cy="22.5005" r="2.5"></circle>
                <circle cx="20.5005" cy="22.5005" r="2.5"></circle>
                <circle cx="38.5005" cy="22.5005" r="2.5"></circle>
                <circle cx="56.5005" cy="22.5005" r="2.5"></circle>
                <circle cx="74.5005" cy="22.5005" r="2.5"></circle>
                <circle cx="92.5005" cy="22.5005" r="2.5"></circle>
                <circle cx="2.50049" cy="2.50049" r="2.5"></circle>
                <circle cx="20.5005" cy="2.50049" r="2.5"></circle>
                <circle cx="38.5005" cy="2.50049" r="2.5"></circle>
                <circle cx="56.5005" cy="2.50049" r="2.5"></circle>
                <circle cx="74.5005" cy="2.50049" r="2.5"></circle>
                <circle cx="92.5005" cy="2.50049" r="2.5"></circle>
            </svg>
        </div>
        <div class="layer layer-03">
            <svg width="26" height="18" viewbox="0 0 26 18" xmlns="http://www.w3.org/2000/svg">
                <path d="M13 0L25.1244 18H0.875645L13 0Z"></path>
            </svg>
        </div>
        <div class="layer layer-04">
            <svg width="83" height="83" viewbox="0 0 83 83" xmlns="http://www.w3.org/2000/svg">
                <rect y="41.0122" width="58" height="58" transform="rotate(-45 0 41.0122)"></rect>
            </svg>
        </div>
        <div class="layer layer-05">
            <svg width="103" height="103" viewbox="0 0 103 103" xmlns="http://www.w3.org/2000/svg">
                <circle cx="60.9647" cy="98.604" r="2.5" transform="rotate(-45 60.9647 98.604)"></circle>
                <circle cx="73.6928" cy="85.876" r="2.5" transform="rotate(-45 73.6928 85.876)"></circle>
                <circle cx="86.4208" cy="73.1479" r="2.5" transform="rotate(-45 86.4208 73.1479)"></circle>
                <circle cx="99.1483" cy="60.4204" r="2.5" transform="rotate(-45 99.1483 60.4204)"></circle>
                <circle cx="46.8226" cy="84.4619" r="2.5" transform="rotate(-45 46.8226 84.4619)"></circle>
                <circle cx="59.5507" cy="71.7339" r="2.5" transform="rotate(-45 59.5507 71.7339)"></circle>
                <circle cx="72.2787" cy="59.0059" r="2.5" transform="rotate(-45 72.2787 59.0059)"></circle>
                <circle cx="85.0062" cy="46.2783" r="2.5" transform="rotate(-45 85.0062 46.2783)"></circle>
                <circle cx="32.6806" cy="70.3198" r="2.5" transform="rotate(-45 32.6806 70.3198)"></circle>
                <circle cx="45.4086" cy="57.5918" r="2.5" transform="rotate(-45 45.4086 57.5918)"></circle>
                <circle cx="58.1366" cy="44.8638" r="2.5" transform="rotate(-45 58.1366 44.8638)"></circle>
                <circle cx="18.5385" cy="56.1777" r="2.5" transform="rotate(-45 18.5385 56.1777)"></circle>
                <circle cx="31.2665" cy="43.4497" r="2.5" transform="rotate(-45 31.2665 43.4497)"></circle>
                <circle cx="4.39637" cy="42.0356" r="2.5" transform="rotate(-45 4.39637 42.0356)"></circle>
            </svg>
        </div>
        <div class="layer layer-06">
            <div class="layer-06-inner">
                <svg width="18" height="18" viewbox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="9" cy="9" r="9"></circle>
                </svg>
            </div>
        </div>
        <div class="layer layer-07">
            <div class="layer-07-inner">
                <svg width="18" height="18" viewbox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="9" cy="9" r="9"></circle>
                </svg>
            </div>
        </div>
        <div class="layer layer-08">
            <svg width="127" height="91" viewbox="0 0 127 91" xmlns="http://www.w3.org/2000/svg">
                <line x1="24.544" y1="0.646447" x2="113.639" y2="89.7419"></line>
                <line x1="36.6392" y1="0.646447" x2="125.735" y2="89.7419"></line>
                <line x1="0.353553" y1="0.646447" x2="89.449" y2="89.7419"></line>
                <line x1="12.4488" y1="0.646447" x2="101.544" y2="89.7419"></line>
            </svg>
        </div>
        <div class="layer layer-09">
            <svg width="122" height="122" viewbox="0 0 122 122" xmlns="http://www.w3.org/2000/svg">
                <mask id="mask1" maskunits="userSpaceOnUse" x="17" y="17" width="87" height="87">
                    <path
                        d="M91.2168 30.4054C108.009 47.198 108.009 74.4241 91.2168 91.2166C74.4242 108.009 47.1981 108.009 30.4056 91.2166C13.613 74.4241 13.613 47.198 30.4056 30.4054C47.1981 13.6129 74.4242 13.6129 91.2168 30.4054Z">
                    </path>
                </mask>
                <g mask="url(#mask1)">
                    <path d="M16.5371 18.2077V103.402H20.7962V18.2077H16.5371Z"></path>
                    <path d="M25.9868 18.2078V103.402H30.2459V18.2078H25.9868Z"></path>
                    <path d="M35.4624 18.2107V103.405H39.7215V18.2107H35.4624Z"></path>
                    <path d="M44.9331 18.2161V103.411H49.1922V18.2161H44.9331Z"></path>
                    <path d="M54.3921 18.2097V103.404H58.6511V18.2097H54.3921Z"></path>
                    <path d="M63.8677 18.2126V103.407H68.1267V18.2126H63.8677Z"></path>
                    <path d="M73.3242 18.2131V103.408H77.5833V18.2131H73.3242Z"></path>
                    <path d="M82.7935 18.216V103.411H87.0525V18.216H82.7935Z"></path>
                    <path d="M92.2495 18.2165V103.411H96.5086V18.2165H92.2495Z"></path>
                    <path d="M101.735 18.2199V103.415H105.994V18.2199H101.735Z"></path>
                </g>
            </svg>
        </div>
        <div class="layer layer-10">
            <svg width="53" height="48" viewbox="0 0 53 48" xmlns="http://www.w3.org/2000/svg">
                <path d="M21.5295 5.85179L52.1481 36.4704L10.3223 47.6776L21.5295 5.85179Z"></path>
            </svg>
        </div>
    </section>

    <section id="partners" class="parallax-container" data-parallax-img="{{ asset('img/bg-parallax-02.jpg') }}">
        <div class="parallax-content py-16 lg:py-32 text-center">
            <div class="container px-10 md:px-16 lg:px-24 mx-auto">
                <h6 class="font-bold uppercase text-white">Our Partners</h6>
                <h3 class="text-3xl font-bold uppercase text-white">Official Partners.</h3>

                <div class="grid md:grid-flow-col auto-cols-max justify-center gap-4 mt-10">
                    <div class="wow">
                        <a class="partner w-72" href="https://binus.ac.id" data-triangle=".partner-overlay"
                            target="_blank">
                            <div class="partner-overlay"></div>
                            <div class="partner-img">
                                <img src="{{ asset('img/logo/logo-binus.svg') }}" class="h-full w-full object-cover"
                                    alt="Bina Nusantara University" />
                            </div>
                        </a>
                    </div>
                    <div class="wow">
                        <a class="partner w-72" href="https://sis.binus.ac.id" data-triangle=".partner-overlay"
                            target="_blank">
                            <div class="partner-overlay"></div>
                            <div class="partner-img">
                                <img src="{{ asset('img/logo/logo-sm.png') }}" class="h-full w-full object-cover"
                                    alt="School of Information Systems" />
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset(mix('js/vendors.min.js')) }}"></script>
    <script src="{{ asset(mix('js/home.min.js')) }}"></script>
@endsection
