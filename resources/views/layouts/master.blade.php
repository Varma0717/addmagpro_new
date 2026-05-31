<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', 'AddMagPro Admin')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="{{ asset('assets/kartify/css/vendors/bootstrap.css') }}">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/kartify/css/vendors/iconsax.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/kartify/css/vendors/remixicon.css') }}">
    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('assets/kartify-admin/admin.css') }}">
    <style>
        .admin-page-title {
            margin: 0;
            color: #1f2937;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .admin-page-subtitle {
            margin: .2rem 0 0;
            color: #64748b;
            font-size: .88rem;
        }

        .admin-table-wrap {
            border-radius: 0;
        }

        .admin-table {
            min-width: 980px;
            color: #1f2937;
        }

        .admin-table thead th {
            color: #334155;
            background: #f8fafc;
            white-space: nowrap;
        }

        .admin-table tbody td {
            color: #334155;
        }

        .admin-table-long {
            min-width: 220px;
            max-width: 360px;
        }

        .admin-thumb {
            width: 58px;
            height: 58px;
            border-radius: 8px;
            object-fit: cover;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .admin-card,
        .dropdown-menu,
        .modal-content {
            background: #fff;
            color: #1f2937;
        }

        .btn-theme,
        .btn-theme:hover,
        .status-badge.badge-approved,
        .status-badge.badge-rejected {
            color: #fff;
        }

        .badge-pending {
            background: #fff3cd;
            color: #664d03;
        }

        .badge-approved {
            background: #198754;
            color: #fff;
        }

        .badge-rejected {
            background: #dc3545;
            color: #fff;
        }

        @media (max-width: 767.98px) {
            .admin-main {
                padding: 1rem;
            }

            .admin-page-title {
                font-size: 1.2rem;
            }

            .admin-card-header,
            .admin-card-body,
            .admin-card-footer {
                padding-inline: .85rem;
            }
        }
    </style>
    @yield('extra_css')
</head>
<body>
    @include('layouts.sidebar')
    @include('layouts.header')
    <main class="admin-main" id="adminMain">
        @yield('mainsection')
    </main>
    @include('layouts.footer')
</body>
</html>
