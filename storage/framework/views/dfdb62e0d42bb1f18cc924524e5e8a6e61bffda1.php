<nav class="topbar mx-auto" style="background-color: rgba(0,0,0,.85); padding: 15px;">
    <div>
        <form method="get" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-secondary">Logout</button>
        </form>
    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\presentador-laravel\resources\views/includes/navbar.blade.php ENDPATH**/ ?>