<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', 'AddMagPro Vendor')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/vendor_assets/images/favicon.ico') }}">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="{{ asset('assets/kartify/css/vendors/bootstrap.css') }}">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/kartify/css/vendors/iconsax.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/kartify/css/vendors/remixicon.css') }}">
    <!-- Admin CSS (shared admin/vendor) -->
    <link rel="stylesheet" href="{{ asset('assets/kartify-admin/admin.css') }}">
    <style>
        :root {
            --primary-color: 170, 85, 0;
            /* #aa5500 — 5.24:1 contrast with white (WCAG AA) */
            --theme-color: rgb(var(--primary-color));
        }
    </style>
    @yield('extra_css')
</head>

<body>
    @include('vendor_layouts.sidebar')
    @include('vendor_layouts.navbar')
    <main class="admin-main" id="adminMain">
        @yield('mainsection')
    </main>
    @include('vendor_layouts.footer')
</body>

</html>