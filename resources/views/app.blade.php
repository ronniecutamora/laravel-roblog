<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    <!-- Font Awesome Pro -->
    <link rel="stylesheet" href="/vendor/font-awesome-pro/css/all.min.css">

    <!-- Web Awesome Pro -->
    <link rel="stylesheet" href="/vendor/web-awesome-pro/styles/webawesome.css">
    <script type="module" src="/vendor/web-awesome-pro/webawesome.loader.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>