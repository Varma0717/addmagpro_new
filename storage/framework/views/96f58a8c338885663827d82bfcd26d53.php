    <!-- Bootstrap 5 JS -->
    <script src="<?php echo e(asset('assets/kartify/js/bootstrap/bootstrap.bundle.js')); ?>"></script>
    <!-- Kartify Script -->
    <script src="<?php echo e(asset('assets/kartify/js/script.js')); ?>"></script>
    <?php echo $__env->yieldContent('extra_js'); ?>
    <script>
        // Sidebar toggle
        const adminSidebar = document.getElementById('adminSidebar');
        const adminTopbar = document.getElementById('adminTopbar');
        const adminMain = document.getElementById('adminMain');

        function toggleSidebar() {
            adminSidebar.classList.toggle('collapsed');
            if (adminSidebar.classList.contains('collapsed')) {
                adminTopbar.style.left = '72px';
                adminMain.style.marginLeft = '72px';
            } else {
                adminTopbar.style.left = '260px';
                adminMain.style.marginLeft = '260px';
            }
        }

        // Mobile: start collapsed if narrow
        if (window.innerWidth < 768) {
            adminSidebar.classList.add('collapsed');
            if (adminTopbar) adminTopbar.style.left = '72px';
            if (adminMain) adminMain.style.marginLeft = '72px';
        }
    </script><?php /**PATH C:\xampp\htdocs\admagpro\resources\views/layouts/footer.blade.php ENDPATH**/ ?>