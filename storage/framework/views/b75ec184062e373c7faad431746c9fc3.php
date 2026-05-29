
<?php $__env->startSection('mainsection'); ?>
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">ID Activation For Products</h2>
        </div>
      </div>
            <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>ID Activation For Products</h4>
                  </div>
                  <div class="card-body admin-card-body p-0">
                  <form action="<?php echo e(route('activate_id_in_products')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                  
                    <div class="admin-form-group">
                      <label>Phone Number (US Format)</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-phone"></i>
                          </div>
                        </div>
                        <input type="number" class="form-control phone-number" id="user_mobile" name="user_mobile" required>
                      </div>
                    </div>
                    <div class="admin-form-group">
                      <button class="btn btn-primary daterange-btn icon-left btn-icon"><i
                          class="fas fa-calendar"></i>Activate ID
                      </button>
                    </div>
                  </form>
                  </div>
                  <div class="card-footer admin-card-footer d-flex justify-content-end">
                  
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Service Users</h4>
                  </div>
                  <div class="card-body admin-card-body p-0">
                    <div class="table-responsive">
                      <table class="table admin-table align-middle mb-0">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>Mobile Number</th>
                            <th>Pan Card</th>
                            <th>Address</th>
                            <th>Service Type</th>
                            <th>Business Image</th>
                            <th>Service Status</th>
                            <th>Update Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $services_business_listing_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$service_users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                          <td><?php echo e($index+1); ?></td>
                          <td><?php echo e($service_users->member_name); ?></td>
                          <td><?php echo e($service_users->member_phone); ?></td>
                          <td><?php echo e($service_users->pan_number); ?></td>
                          <td><?php echo e($service_users->address); ?></td>
                          <td><?php echo e($service_users->service_name); ?></td>
                          <td><img src="<?php echo e($service_users->business_image); ?>" alt="" width="60px" height="60px"></td>
                          <!-- <td><?php echo e($service_users->status); ?></td> -->
                          <td>
                            <?php if($service_users->status=='0'): ?>
                              <div class="status-badge badge-rejected">Not Approved</div>
                            <?php elseif($service_users->status=='1'): ?>
                              <div class="status-badge badge-theme">Approved</div>
                            <?php endif; ?>
                          </td>
                          <td>
                              <a href="<?php echo e(route('id_activation_update', ['id' => $service_users->service_user_id])); ?>" class="status-badge badge-theme">Update</a>
                          </td>

                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php $__empty_2 = true; $__currentLoopData = $stores_business_listing_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$service_users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                        <tr>
                          <td><?php echo e($index+1); ?></td>
                          <td><?php echo e($service_users->member_name); ?></td>
                          <td><?php echo e($service_users->member_phone); ?></td>
                          <td><?php echo e($service_users->pan_number); ?></td>
                          <td><?php echo e($service_users->address); ?></td>
                          <td><?php echo e($service_users->StoreName); ?></td>
                          <td><img src="<?php echo e($service_users->business_image); ?>" alt="" width="60px" height="60px"></td>
                          <!-- <td><?php echo e($service_users->status); ?></td> -->
                          <td>
                            <?php if($service_users->status=='0'): ?>
                              <div class="status-badge badge-rejected">Not Approved</div>
                            <?php elseif($service_users->status=='1'): ?>
                              <div class="status-badge badge-theme">Approved</div>
                            <?php endif; ?>
                          </td>
                          <td>
                              <a href="<?php echo e(route('id_activation_update', ['id' => $service_users->service_user_id])); ?>" class="status-badge badge-theme">Update</a>
                          </td>

                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                        <tr><td colspan="9" class="text-center text-muted py-4">No records found.</td></tr>
                      <?php endif; ?>
                      </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer admin-card-footer d-flex justify-content-end">
                    <nav>
                      <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                          <a class="page-link" href="#"><i class="ri-arrow-left-s-line"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#"><i class="ri-arrow-right-s-line"></i></a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>

              
            </div>
          </div>
        </section>
      </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admagpro\resources\views/admin_pages/id_activation.blade.php ENDPATH**/ ?>