<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="theme-color" content="#4A00FF" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="author" content="Bina Nusantara University" />
    <meta name="copyright" content="Bina Nusantara University" />
    <meta name="language" content="Indonesia" />
    <meta name="description" content="Bina Nusantara University - School of Information Systems Contests" />
    <meta name="keywords" content="basic, binus, bina nusantara" />
    <meta property="og:locale" content="id_ID" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="SIS Contests - Bina Nusantara University" />
    <meta property="og:title" content="SIS Contests - Bina Nusantara University" />
    <meta property="og:description" content="Bina Nusantara University - School of Information Systems Contests" />
    <meta property="og:url" content="{{ config('app.url', 'localhost') }}" />
    <meta property="og:image" content="https://ik.imagekit.io/stfnxvrbzwa/ispm-siscontest_zrlFOI2-j.jpg" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="503" />
    <meta property="fb:app_id" content="588417572889301" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:domain" content="{{ config('app.url', 'localhost') }}" />
    <meta name="twitter:image" content="https://ik.imagekit.io/stfnxvrbzwa/ispm-siscontest_zrlFOI2-j.jpg" />
    <meta name="msapplication-TileColor" content="#4A00FF" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/icon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/icon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/icon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SIS Contests - Bina Nusantara University</title>

    <!-- Alpine JS -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.8.0/alpine.js"></script>

    <!-- Styles -->
    @yield('styles')
    
    <livewire:styles />
    <link href="{{ asset(mix('css/app.min.css')) }}" rel="stylesheet">
    <link href="{{ asset(mix('css/laravel-views.css')) }}" rel="stylesheet">
    @bukStyles
</head>

<body>
    @yield('navbar')
    @sectionMissing('navbar')
        <x-topbar />
    @endif

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('layouts.components.footer')
    @include('layouts.components.toast')

    <!-- Scripts -->
    <livewire:scripts />
    <script src="{{ asset(mix('js/app.min.js')) }}" defer></script>
    <script src="{{ asset(mix('js/laravel-views.js')) }}"></script>
    @bukScripts

    @yield('scripts')
</body>

</html>
