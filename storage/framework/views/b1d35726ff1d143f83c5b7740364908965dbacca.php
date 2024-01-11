<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Bienvenido</title>
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css/style2.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>

<body class="background-image d-flex align-items-center justify-content-center" style="margin: 0; padding: 0; overflow: hidden; background-image: url('<?php echo e(asset('images/login/login_background7.jpg')); ?>'); background-size: cover; background-repeat: no-repeat; height: 100vh;">

    <div class="login-card text-center bg-secondary">
        <div style="margin-bottom: 30px">
            <img src="<?php echo e(asset('favicon.ico')); ?>" alt="" class="img-fluid" style="width: 60px; height: 60px; margin-left: 5px;">
        </div>
        <h2 class="text-white">Bienvenido Presentador</h2>
        <form method="get" action="<?php echo e(url('/auth0/login')); ?>">
            <?php echo csrf_field(); ?>
            <button class="btn btn-dark" type="submit" style="margin-top:30px; margin-bottom:30px; padding: 10px; border-radius:10px" name="iniciar_sesion">Iniciar Sesión</button>
        </form>
    </div>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\presentador-laravel\resources\views/login.blade.php ENDPATH**/ ?>