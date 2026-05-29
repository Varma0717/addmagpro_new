
<?php $__env->startSection('mainsection'); ?>

<div class="admin-page">
  <section class="admin-section">
    <div class="admin-section-body">

      
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Dashboard</h2>
          <p class="text-muted mb-0 small">Welcome back, <?php echo e(session('admin_username')); ?></p>
        </div>
        <span class="status-badge badge-theme"><i class="ri-dashboard-line me-1"></i>Overview</span>
      </div>

      
      <div class="row g-3">

        
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
          <div class="stat-card">
            <div class="stat-icon orange"><i class="ri-user-line"></i></div>
            <div class="stat-info">
              <div class="stat-label">Active Users</div>
              <div class="stat-value"><?php echo e($active_users_count); ?></div>
            </div>
          </div>
        </div>

        
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
          <div class="stat-card">
            <div class="stat-icon blue"><i class="ri-money-dollar-circle-line"></i></div>
            <div class="stat-info">
              <div class="stat-label">Business Turn Over</div>
              <div class="stat-value"><?php echo e($total_turn_over); ?></div>
            </div>
          </div>
        </div>

        
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
          <div class="stat-card">
            <div class="stat-icon green"><i class="ri-wallet-3-line"></i></div>
            <div class="stat-info">
              <div class="stat-label">Commission Wallet</div>
              <div class="stat-value"><?php echo e($admin_commission); ?></div>
            </div>
          </div>
        </div>

        
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
          <div class="stat-card">
            <div class="stat-icon red"><i class="ri-heart-line"></i></div>
            <div class="stat-info">
              <div class="stat-label">Charity Wallet</div>
              <div class="stat-value"><?php echo e($admin_wallet['charity']); ?></div>
            </div>
          </div>
        </div>

        
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
          <div class="stat-card">
            <div class="stat-icon purple"><i class="ri-group-line"></i></div>
            <div class="stat-info">
              <div class="stat-label">Pool Commission</div>
              <div class="stat-value"><?php echo e($admin_wallet['monthly_pool']); ?></div>
            </div>
          </div>
        </div>

        
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
          <div class="stat-card">
            <div class="stat-icon teal"><i class="ri-store-2-line"></i></div>
            <div class="stat-info">
              <div class="stat-label">Vendor Wallet</div>
              <div class="stat-value">0</div>
            </div>
          </div>
        </div>

        
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
          <div class="stat-card">
            <div class="stat-icon orange"><i class="ri-exchange-funds-line"></i></div>
            <div class="stat-info">
              <div class="stat-label">B2B Wallet</div>
              <div class="stat-value"><?php echo e($admin_wallet['backtwoback']); ?></div>
            </div>
          </div>
        </div>

        
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
          <div class="stat-card">
            <div class="stat-icon blue"><i class="ri-funds-line"></i></div>
            <div class="stat-info">
              <div class="stat-label">B2B Outstanding</div>
              <div class="stat-value"><?php echo e($back2back_outstanding); ?></div>
            </div>
          </div>
        </div>

        
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
          <div class="stat-card">
            <div class="stat-icon purple"><i class="ri-gift-line"></i></div>
            <div class="stat-info">
              <div class="stat-label">Reward</div>
              <div class="stat-value">0</div>
            </div>
          </div>
        </div>

        
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
          <div class="stat-card">
            <div class="stat-icon red"><i class="ri-time-line"></i></div>
            <div class="stat-info">
              <div class="stat-label">Pending Withdrawal</div>
              <div class="stat-value">0</div>
            </div>
          </div>
        </div>

      </div>
      

    </div>
  </section>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admagpro\resources\views/admin_pages/index.blade.php ENDPATH**/ ?>