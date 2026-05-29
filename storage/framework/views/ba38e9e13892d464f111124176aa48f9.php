
<?php $__env->startSection('mainsection'); ?>
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Convert Back2Back Income To Product Wallet</h2>
        </div>
      </div>
            <div class="row">
                <div class="col-12">
                  <div class="card admin-card">
                    <div class="card-header admin-card-header">
                      <h4>Convert Back2Back Income To Product Wallet</h4>
                    </div>
                    <div class="card-body admin-card-body p-0">
                      <div class="table-responsive">
                        <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>phone Number</th>
                              <th>Address</th>
                              <th>City</th>
                              <th>Back2Back Income</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php $__empty_1 = true; $__currentLoopData = $back2back_income_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $back2back_income_user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($back2back_income_user->member_name); ?></td>
                                    <td><?php echo e($back2back_income_user->member_phone); ?></td>
                                    <td><?php echo e($back2back_income_user->address); ?></td>
                                    <td><?php echo e($back2back_income_user->city); ?></td>
                                    <td><?php echo e($back2back_income_user->balance); ?></td>
                                    <td>
                                        <a href="back2back_to_product_wallet/<?php echo e($back2back_income_user->user_id); ?>" class="btn btn-primary text-white" style="text-decoration: none;">
                                            Convert to Product Wallet
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </section>
      </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admagpro\resources\views/admin_pages/product_wallet_conversion.blade.php ENDPATH**/ ?>