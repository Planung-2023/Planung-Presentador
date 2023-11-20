<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content=<?php echo e(csrf_token()); ?>>
    <link rel="stylesheet" href="<?php echo e(asset('css/styles2.css')); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <title>Listado de Eventos</title>
</head>

<body style="background-color: #3a3a3a;">
    <?php echo $__env->make('includes.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="container" style="background-color:#6a6d71; padding:10px; border-radius: 10px; margin-top: 5%; color: #ffffff;">
        <h2 class="mt-4 mb-4 text-center">Listado de Eventos</h2>
        <div class="col-md-12 text-center">
            <table class="table">
                <thead style="color: #ffffff">
                    <tr>
                        <th>Evento</th>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $eventos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style='color: #ffffff'><?php echo e($evento->nombre); ?></td>
                            <td style='color: #ffffff'><?php echo e($evento->fecha); ?></td>
                            <td style='color: #ffffff'><?php echo e($evento->descripcion); ?></td>
                            <td>
                                <button style='margin-right:4px' onclick='subirPresentacion(<?php echo e($evento->id); ?>)'>Subir Presentaciones</button>
                                <button style='margin-left:4px' onclick='verPresentacion(<?php echo e($evento->id); ?>)'>Ver Presentaciones</button>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="<?php echo e(asset('js/tabla.js')); ?>"></script>
    <script>
        function verPresentacion(eventId) {
            // Assuming ROUTE_URL_PRESENTADOR is defined as the base URL
            var baseUrl = "<?php echo e(config('app.url')); ?>";

            // Construct the URL for the desired route
            var routeUrl = baseUrl + "/"; // Add your desired route here

            // Redirect to the URL
            window.location.href = routeUrl;
        }
    </script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\presentador-laravel\resources\views/index.blade.php ENDPATH**/ ?>