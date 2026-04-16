<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Visa Admin') }} — Admin</title>

    {{-- Standalone admin entry — does NOT load the user theme stylesheets. --}}
    @vite(['resources/js/dashboard/main.js'])
</head>

<body>
    <div id="dashboard-app"></div>
</body>

</html>
