<?php $__env->startSection('page_title', 'My Wallet | AddMagPro'); ?>

<?php $__env->startSection('extra_css'); ?>
<style>
    .sidebar-dash-link {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .7rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        color: var(--title-color);
        transition: background .15s;
    }

    .sidebar-dash-link:hover,
    .sidebar-dash-link.active {
        background: rgba(255, 153, 0, .1);
        color: var(--theme-color);
    }

    .sidebar-dash-link i {
        font-size: 1.1rem;
        color: var(--theme-color);
    }

    .dash-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, .07);
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mainsection'); ?>
<section class="section-b-space">
    <div class="custom-container">
        <div class="row g-4">

            
            <div class="col-lg-3 col-xl-2">
                <div class="dash-card p-0 overflow-hidden">
                    <div class="p-3 text-center" style="background:linear-gradient(135deg,var(--theme-color) 0%,#7a2800 100%);">
                        <div class="rounded-circle mx-auto mb-2 overflow-hidden" style="width:64px;height:64px;background:rgba(255,255,255,.2);">
                            <i class="ri-user-line" style="font-size:2.5rem;color:#fff;line-height:64px;"></i>
                        </div>
                        <?php if(isset($user_details)): ?>
                        <h6 class="text-white fw-bold mb-0"><?php echo e($user_details[0]->member_name ?? 'Member'); ?></h6>
                        <small class="text-white">ID: <?php echo e($user_details[0]->service_id ?? ''); ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="p-2">
                        <a href="<?php echo e(route('user_dashboard')); ?>" class="sidebar-dash-link">
                            <i class="ri-dashboard-line"></i>Dashboard
                        </a>
                        <a href="<?php echo e(route('generate_coupon')); ?>" class="sidebar-dash-link">
                            <i class="ri-coupon-line"></i>Generate Coupons
                        </a>
                        <a href="<?php echo e(route('user_wallet')); ?>" class="sidebar-dash-link active">
                            <i class="ri-wallet-line"></i>My Wallet
                        </a>
                        <a href="<?php echo e(route('team_details')); ?>" class="sidebar-dash-link">
                            <i class="ri-team-line"></i>Team Details
                        </a>
                        <a href="<?php echo e(route('account_profile')); ?>" class="sidebar-dash-link">
                            <i class="ri-user-settings-line"></i>Profile
                        </a>
                        <a href="<?php echo e(route('account_orders')); ?>" class="sidebar-dash-link">
                            <i class="ri-shopping-bag-line"></i>My Orders
                        </a>
                        <a href="<?php echo e(route('discount_shop_orders')); ?>" class="sidebar-dash-link">
                            <i class="ri-discount-percent-line"></i>Discount Orders
                        </a>
                        <a href="<?php echo e(route('customer_payments')); ?>" class="sidebar-dash-link">
                            <i class="ri-bank-card-line"></i>Payments
                        </a>
                        <a href="<?php echo e(route('service_user_logout')); ?>" class="sidebar-dash-link text-danger" onclick="return confirm('Logout?')">
                            <i class="ri-logout-box-line"></i>Logout
                        </a>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-9 col-xl-10">
                <h4 class="fw-bold mb-4">My Wallet</h4>
                <?php $total = ($user_back_two_back_amount ?? 0) + ($user_commission_amount ?? 0) + ($user_pool_commission_amount ?? 0); ?>

                <!-- Balance Header -->
                <div class="p-4 mb-4 text-white text-center rounded" style="background:linear-gradient(135deg,var(--theme-color),#7a2800);">
                    <p class="mb-0">Total Wallet Balance</p>
                    <h1 class="fw-bold my-2">₹<?php echo e(number_format($total, 2)); ?></h1>
                </div>

                <!-- Action Buttons -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <a href="/wallet/topup" class="btn w-100" style="background:var(--theme-color);color:#fff;font-weight:700;padding:0.75rem;">
                            <i class="ri-add-line"></i> Add Money to Wallet
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?php echo e(route('withdraw_amount')); ?>" class="btn w-100 btn-outline-warning" style="font-weight:700;padding:0.75rem;color:var(--theme-color);border-color:var(--theme-color);">
                            <i class="ri-money-withdraw-line"></i> Withdraw Money
                        </a>
                    </div>
                </div>

                <!-- Balance Breakdown Cards -->
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-4 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);border-top:4px solid var(--theme-color);">
                            <p class="text-muted mb-1">Commission Balance</p>
                            <h4 class="fw-bold mb-0">₹<?php echo e(number_format($user_commission_amount ?? 0, 2)); ?></h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);border-top:4px solid #1976d2;">
                            <p class="text-muted mb-1">Pool Commission</p>
                            <h4 class="fw-bold mb-0">₹<?php echo e(number_format($user_pool_commission_amount ?? 0, 2)); ?></h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);border-top:4px solid #388e3c;">
                            <p class="text-muted mb-1">B2B Balance</p>
                            <h4 class="fw-bold mb-0">₹<?php echo e(number_format($user_back_two_back_amount ?? 0, 2)); ?></h4>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('service_user_dashboard_layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admagpro\resources\views/service_users/user_wallet.blade.php ENDPATH**/ ?>