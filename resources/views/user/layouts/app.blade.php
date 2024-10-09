<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>

    @include('user.includes.metas')

    <!-- Scripts -->
    @vite([
        'resources/css/user/bootstrap.min.css',
        'resources/css/user/fontawesome.css',
        'resources/css/user/animate.css',
        'resources/css/user/swiper.min.css',
        'resources/css/user/odometer.css',
        'resources/css/user/nice-select.css',
        'resources/css/user/jquery-ui.min.css',
        'resources/css/user/magnific-popup.css',
        'resources/css/user/main.css'
    ])

    

    @stack('styles_top')
    @stack('scripts_top')

</head>

<body class="app">

    <!-- backtotop - start -->
    <div class="xb-backtotop">
        <a href="#" class="scroll">
            <i class="far fa-arrow-up"></i>
        </a>
    </div>
    <!-- backtotop - end -->

    <!-- preloader start -->
    <div id="xb-loadding">
        <div class="loader">
            <div class="plane">
                <img class="plane-img" src="{{ asset('user/assets/img/icon/plane.gif') }}" alt="">
            </div>
            <div class="earth-wrapper">
                <div class="earth"></div>
            </div>
        </div>
    </div>
    <!-- preloader end -->

    <div class="body_wrap">

        @include('user.includes.header')

        <div class="body-overlay"></div>

        <main>

            @yield('content')

        </main>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>

    <!-- Scripts -->
    @vite([
        'resources/js/user/jquery-3.7.1.min.js',
        'resources/js/user/bootstrap.bundle.min.js',
        'resources/js/user/swiper.min.js',
        //'resources/js/user/wow.min.js',
        'resources/js/user/appear.js',
        'resources/js/user/odometer.min.js',
        'resources/js/user/jquery.nice-select.min.js',
        'resources/js/user/imagesloaded.pkgd.min.js',
        'resources/js/user/isotope.pkgd.min.js',
        'resources/js/user/jquery.magnific-popup.min.js',
        'resources/js/user/jquery-ui.min.js',
        'resources/js/user/parallax-scroll.js',
        'resources/js/user/main.js'
    ])

    @include('user.includes.footer')

    @stack('styles_bottom')
    @stack('scripts_bottom')

</body>

</html>