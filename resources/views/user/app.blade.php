<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Legacy theme CSS (kept to preserve styling 1:1) --}}
    @foreach([
        '/css/user/bootstrap.min.css',
        '/css/user/fontawesome.css',
        '/css/user/animate.css',
        '/css/user/swiper.min.css',
        '/css/user/odometer.css',
        '/css/user/nice-select.css',
        '/css/user/jquery-ui.min.css',
        '/css/user/magnific-popup.css',
        '/css/user/main.css',
        'css/user/extra.css',
    ] as $asset)
        <link rel="stylesheet" href="{{ asset($asset) }}">
    @endforeach

    @vite(['resources/js/user/main.js'])
</head>

<body class="app">

    <!-- backtotop -->
    <div class="xb-backtotop">
        <a href="#" class="scroll">
            <i class="far fa-arrow-up"></i>
        </a>
    </div>

    <!-- Vue mount point -->
    <div id="user-app"></div>

</body>

</html>
