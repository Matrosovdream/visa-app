<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        
        @include('user.includes.metas')

        @stack('styles_top')
        @stack('scripts_top')

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>

    <body class="app">
        
        @include('user.includes.header')

        @yield('content')

        @include('user.includes.footer')

        @stack('styles_bottom')
        @stack('scripts_bottom')

    </body>

</html>
