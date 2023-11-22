<style>
    .foto-perfil {
    border-radius: 20%;
    overflow: hidden;
    width: 50px;
    height: 50px;
    border: 2px solid black;
    padding: 0%;
    }

    .foto-perfil img{
        object-fit: cover;
    }

    .container-perfil{
        padding: 6px;
        border-radius: 10px;
        background: white;
        max-height: 60px;
    }
</style>

<nav class="topbar navbar mx-auto" style="background-color: rgba(0,0,0,.85); padding: 15px; position: relative;">
    <div class="container-fluid d-flex justify-content-between align-items-center text-center">
        <div class="navbar-brand">
            <form method="get" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-secondary">Logout</button>
            </form>
        </div>
        <div class="position-absolute top-50 start-50 translate-middle">
            <img class="logo" style="width: 25%; height: 25%;" src="<?php echo e(asset('favicon.ico')); ?>">
        </div>
        <div class="navbar-brand">
            <div class="container-perfil" style="">
                <div class="card-body d-flex align-items-center">
                    <div class="foto-perfil">
                        <img style="width:100%; height:100%;" src="<?php echo e(asset('images/' . $fotoPerfilUsuario)); ?>" alt="Foto de perfil">
                    </div>
                    <p class="ms-3 mb-0"><?php echo e($nombreUsuario); ?></p>
                </div>
            </div>
        </div>
    </div>
</nav><?php /**PATH C:\xampp\htdocs\presentador-laravel\resources\views/includes/navbar.blade.php ENDPATH**/ ?>