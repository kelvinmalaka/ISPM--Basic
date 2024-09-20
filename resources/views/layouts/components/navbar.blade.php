<header class="section page-header">
    <div class="rd-navbar-wrap">
        <nav class="rd-navbar rd-navbar-classic" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed"
            data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static"
            data-lg-device-layout="rd-navbar-static" data-xl-layout="rd-navbar-static"
            data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static"
            data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px"
            data-xxl-stick-up-offset="76px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">

            <div class="rd-navbar-collapse-toggle rd-navbar-fixed-element-1"
                data-rd-navbar-toggle=".rd-navbar-collapse">
                <span></span>
            </div>

            <div class="rd-navbar-main-outer">
                <div class="rd-navbar-main">
                    <div class="rd-navbar-panel">
                        <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap">
                            <span class="bg-gray-700"></span>
                        </button>
                        <div class="rd-navbar-brand">
                            <div class="flex items-center">
                                @include('layouts.components.binus-ribbon', [
                                    'class' => 'relative hidden md:block',
                                    'style' => 'top: -1rem',
                                ])

                                <a class="brand ml-3" href="{{ route('home') }}">
                                    <img src="{{ asset('img/logo/logo-sm.png') }}" alt="SIS Contest"
                                        class="brand-logo-dark h-12" />
                                    <img src="{{ asset('img/logo/logo-sm-white.png') }}" alt="SIS Contest"
                                        class="brand-logo-light h-12" />
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="rd-navbar-main-element">
                        <div class="rd-navbar-nav-wrap">
                            <ul class="rd-navbar-nav">
                                <li class="rd-nav-item">
                                    <a class="rd-nav-link" href="{{ config('app.url') . '/#home' }}">Home</a>
                                </li>
                                <li class="rd-nav-item">
                                    <a class="rd-nav-link" href="{{ config('app.url') . '/#about' }}">About Us</a>
                                </li>
                                <li class="rd-nav-item">
                                    <a class="rd-nav-link" href="{{ config('app.url') . '/#events' }}">Events</a>
                                </li>
                                <li class="rd-nav-item">
                                    <a class="rd-nav-link" href="{{ config('app.url') . '/#partners' }}">Partners</a>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <div class="rd-navbar-collapse">
                        @guest
                            <a class="button button-primary uppercase mt-0 mr-2" href="{{ route('login') }}"
                                data-triangle=".button-overlay">
                                <span>Login</span>
                                <span class="button-overlay"></span>
                            </a>
                            <a class="button button-secondary uppercase mt-0" href="{{ route('register') }}">
                                <span>Register</span>
                                <span class="button-overlay"></span>
                            </a>
                        @else
                            <a class="button button-primary uppercase mt-0" href="{{ route('application') }}"
                                data-triangle=".button-overlay">
                                <span>
                                    Dashboard
                                    <i class="bi-arrow-right ml-2"></i>
                                </span>
                                <span class="button-overlay"></span>
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
