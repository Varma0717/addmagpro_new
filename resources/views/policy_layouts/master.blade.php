<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', 'AddMagPro')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/kartify/css/vendors/iconsax.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/kartify/css/vendors/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/kartify/css/style.css') }}">
    <style>
        :root {
            --theme-color: rgb(var(--primary-color));
        }
    </style>
</head>

<body>
    @include('policy_layouts.header')
    <main>
        @yield('mainsection')
    </main>
    @include('policy_layouts.footer')
    <script src="{{ asset('assets/kartify/js/bootstrap/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('assets/kartify/js/script.js') }}"></script>
</body>

</html>