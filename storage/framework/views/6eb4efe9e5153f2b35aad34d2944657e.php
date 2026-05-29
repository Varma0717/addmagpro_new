<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('page_title', 'AddMagPro'); ?></title>
    <link rel="icon" href="<?php echo e(asset('assets/user_assets/images/favicon-32x32.webp')); ?>" type="image/webp">

    <script>
        window.KARTIFY_ASSET_URL = "<?php echo e(asset('')); ?>";
    </script>
    
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/kartify/fonts/br-hendrix/stylesheet.css')); ?>">
    
    <link rel="stylesheet" id="rtl-link" type="text/css" href="<?php echo e(asset('assets/kartify/css/vendors/bootstrap.css')); ?>">
    
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/kartify/css/vendors/iconsax.css')); ?>">
    
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/kartify/css/vendors/remixicon.css')); ?>">
    
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/kartify/css/vendors/swiper.css')); ?>">
    
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/kartify/css/style.css')); ?>">
    <style>
        :root {
            --primary-color: 170, 85, 0;
            /* #aa5500 — 5.24:1 contrast with white (WCAG AA) */
            --theme-color: rgb(var(--primary-color));
            --theme-color-soft: rgba(var(--primary-color), 0.12);
        }

        /* Preloader text container must be wide enough for SplitType-expanded "WELCOME ADDMAGPRO" */
        .preloader .text-container {
            width: min(90vw, 30rem);
        }

        /* Keep body content visually separated from header on all inner pages */
        .header-style-1+* {
            margin-top: 14px;
        }

        /* Compensate for fixed main header when sticky mode is active */
        .header-style-1.sticky-header+* {
            margin-top: 96px;
        }

        @media (max-width: 1199.98px) {
            .header-style-1.sticky-header+* {
                margin-top: 82px;
            }
        }

        .base-bg-color {
            color: rgba(var(--title-color), 1);
        }

        .section-b-space {
            padding-block: 28px;
        }

        .card,
        .dash-card,
        .form-card,
        .checkout-card,
        .order-card,
        .auth-card,
        .offcanvas,
        .dropdown-menu {
            background-color: #fff;
            color: rgba(var(--title-color), 1);
        }

        .card p,
        .dash-card p,
        .form-card p,
        .checkout-card p,
        .order-card p,
        .offcanvas p,
        .dropdown-menu p {
            color: rgba(var(--content-color), 1);
        }

        .text-white,
        .text-white *,
        [style*="color:#fff"],
        [style*="color: #fff"] {
            color: #fff !important;
        }

        [style*="background:var(--theme-color)"],
        [style*="background: var(--theme-color)"],
        [style*="background-color:var(--theme-color)"],
        [style*="background-color: var(--theme-color)"],
        [style*="background:linear-gradient"],
        [style*="background: linear-gradient"] {
            color: #fff;
        }

        .table {
            color: rgba(var(--title-color), 1);
        }

        .table thead th {
            color: rgba(var(--title-color), .92);
            background-color: rgba(var(--base-gray), 1);
        }

        .table tbody td {
            color: rgba(var(--content-color), 1);
        }

        .btn[style*="background:#fff"],
        .btn[style*="background: #fff"],
        .btn[style*="background-color:#fff"],
        .btn[style*="background-color: #fff"],
        .btn.btn-light,
        .btn.btn-white {
            color: rgba(var(--title-color), 1);
        }

        .btn.btn-light:hover,
        .btn.btn-white:hover,
        .btn.btn-outline-dark {
            color: rgba(var(--title-color), 1);
        }

        .custom-container {
            width: 100%;
        }

        img {
            max-width: 100%;
        }

        @media (max-width: 767.98px) {
            .section-b-space {
                padding-block: 18px;
            }

            .custom-container {
                padding-inline: 14px;
            }

            .dash-card,
            .form-card,
            .checkout-card,
            .order-card {
                padding: 1rem !important;
            }

            .table-responsive {
                border-radius: 10px;
            }
        }
    </style>
    <?php echo $__env->yieldContent('extra_css'); ?>
</head>

<body class="base-bg-color">

    
    <div class="preloader">
        <div class="progress-container">
            <div class="progress-bar preloader-progress-bar"></div>
        </div>
        <div class="text-container">
            <div class="loading-text initial">Loading</div>
            <div class="loading-text complete">
                <span>Welcome</span>
                <span>AddMagPro</span>
            </div>
        </div>
        <div class="percentage">0</div>
    </div>

    <?php echo $__env->make('service_user_dashboard_layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldContent('mainsection'); ?>

    
    <script src="<?php echo e(asset('assets/kartify/js/bootstrap/bootstrap.bundle.js')); ?>"></script>
    
    <script src="<?php echo e(asset('assets/kartify/js/swiper.js')); ?>"></script>
    
    <script src="<?php echo e(asset('assets/kartify/js/iconsax.js')); ?>"></script>
    
    <script src="<?php echo e(asset('assets/kartify/js/lazyload.js')); ?>"></script>
    
    <script src="<?php echo e(asset('assets/kartify/js/gsap/gsap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/kartify/js/gsap/split-type.js')); ?>"></script>
    
    <script src="<?php echo e(asset('assets/kartify/js/script.js')); ?>"></script>
    <?php echo $__env->yieldContent('extra_js'); ?>
</body>

</html><?php /**PATH C:\xampp\htdocs\admagpro\resources\views/service_user_dashboard_layouts/master.blade.php ENDPATH**/ ?>