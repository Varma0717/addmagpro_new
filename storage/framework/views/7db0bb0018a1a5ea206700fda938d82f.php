<?php $__env->startSection('page_title', 'Team Details | AddMagPro'); ?>
<?php $__env->startSection('mainsection'); ?>
<section class="section-b-space">
    <div class="custom-container">
        <h4 class="fw-bold mb-4">My Team</h4>
        <div class="row g-4">
            <div class="col-12">
                <div class="p-4 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);">
                    <h6 class="fw-bold mb-3" style="border-bottom:2px solid var(--theme-color);padding-bottom:.5rem;">
                        <i class="ri-user-add-line me-2"></i>Direct Referrals (<?php echo e($referred_users_by_login_person->count()); ?>)
                    </h6>
                    <?php if($referred_users_by_login_person->isEmpty()): ?>
                    <p class="text-muted text-center py-3">No direct referrals yet. Share your referral link to grow your team!</p>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead style="background:rgba(255,153,0,.08);">
                                <tr><th>#</th><th>Name</th><th>Mobile</th><th>Location</th><th>Joined</th></tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $referred_users_by_login_person; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($i+1); ?></td>
                                    <td class="fw-semibold"><?php echo e($member->member_name); ?></td>
                                    <td><?php echo e($member->member_phone); ?></td>
                                    <td><?php echo e($member->location ?? '-'); ?></td>
                                    <td><?php echo e($member->created_at ?? '-'); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if(!empty($chain_users)): ?>
            <div class="col-12">
                <div class="p-4 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);">
                    <h6 class="fw-bold mb-3" style="border-bottom:2px solid var(--theme-color);padding-bottom:.5rem;">
                        <i class="ri-team-line me-2"></i>Network Chain (<?php echo e(count($chain_users)); ?>)
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead style="background:rgba(255,153,0,.08);">
                                <tr><th>#</th><th>Name</th><th>Mobile</th><th>Location</th></tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $chain_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($i+1); ?></td>
                                    <td class="fw-semibold"><?php echo e($member['member_name']); ?></td>
                                    <td><?php echo e($member['member_phone']); ?></td>
                                    <td><?php echo e($member['location'] ?? '-'); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('service_user_dashboard_layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admagpro\resources\views/service_users/team_details.blade.php ENDPATH**/ ?>