<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/animation.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="<?php echo e(asset('js/three.r134.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/vanta.globe.min.js')); ?>"></script>
</head>

<body style="margin: 0; padding: 0; overflow: hidden;">

    <div style="height: 100vh; width: 100%" class="box" id="box"></div>

    <div class="login-card text-center">
        <!-- Contenido de la tarjeta de login -->
        <h2>Bienvenido Presentador</h2>
        <form method="get" action="<?php echo e(url('/auth0/login')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" style="margin-top:60px; margin-bottom:30px; padding: 5px; border-radius:10px" name="iniciar_sesion">Inicie Sesión</button>
        </form>
    </div>

    <script>
        VANTA.GLOBE({
            el: "#box",
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            minHeight: window.innerHeight,
            minWidth: window.innerWidth,
            scale: 1.00,
            scaleMobile: 1.00,
            color: 0xeb464f,
            size: 1,
            backgroundColor: 0x1d1d1e
        });
    </script>
</body>

</html>
<?php /**PATH C:\Users\Angelina\Desktop\presentador-laravel\resources\views/login.blade.php ENDPATH**/ ?>