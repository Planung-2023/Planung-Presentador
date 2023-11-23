<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content=<?php echo e(csrf_token()); ?>>
    <title>Listado de Eventos</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/styles2.css')); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body style="background-color: #3a3a3a;">
    
    <?php echo $__env->make('includes.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="container" style="background-color:#6a6d71; padding:20px; border-radius: 10px; margin-top: 5%; color: #ffffff;">
        <h2 class="mt-4 mb-4 text-center">Listado de Eventos</h2>
        <div class="col-md-12 text-center">
            <table class="table table-bordered">
                <thead style="color: #ffffff">
                    <tr class="table-dark" style="border-radius:50%">
                        <th>Evento</th>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Presentaciones subidas</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $eventos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style='color: #ffffff'><?php echo e($evento->nombre); ?></td>
                            <td style='color: #ffffff'><?php echo e($evento->fecha); ?></td>
                            <td style='color: #ffffff'><?php echo e($evento->descripcion); ?></td>
                            <td style='color: #ffffff'><?php echo e($evento->cantidad_presentaciones); ?></td>
                            <td>
                                <button class="btn btn-secondary" style='margin-right:4px' onclick='console.log("ID del Evento:", <?php echo e($evento->id); ?>); abrirModalConEvento(<?php echo e($evento->id); ?>)'>Subir Presentaciones</button>
                                
                                <?php if($evento->cantidad_presentaciones > 0): ?>
                                    <button class="btn btn-secondary" type="button" onclick="mostrarPresentacionesModal(<?php echo e($evento->id); ?>)">Ver Presentaciones</button>
                                <?php else: ?>
                                    <button class="btn btn-secondary" type="button" disabled>Ver Presentaciones</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <?php echo $__env->make('includes.popups.subir-presentacion', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('includes.popups.ver-presentacion', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <script>
        // Asignar un valor predeterminado a idEvento
        $('#idEvento').val(1);
        // Función para abrir el modal y establecer el valor de idEvento
        function abrirModalConEvento(eventoId) {
        // Setear el valor de idEvento en el input oculto del formulario
        $('#idEvento').val(eventoId);
        console.log('Valor de idEvento:', eventoId);
        // Mostrar el modal
        $('#subirPresentacionModal').modal('show');
        }
        // Función para ejecutar cuando el modal se muestra
        $('#subirPresentacionModal').on('shown.bs.modal', function () {
            // Lógica adicional que puedes agregar cuando el modal se muestra
            console.log('El modal se ha mostrado');
        });
    </script>

    <script>
        function mostrarPresentacionesModal(eventoId) {
            // Realiza una solicitud Ajax para obtener las presentaciones del evento
            $.ajax({
                url: "<?php echo e(url('/presentaciones/')); ?>" + "/" + eventoId,
                type: 'GET',
                success: function(response) {
                    // Limpiar y llenar el dropdown con las presentaciones obtenidas
                    $('#presentacionesDropdown').empty();
                    var defaultOption = '<option value="" disabled selected>Elige una presentación</option>';
                    $('#presentacionesDropdown').append(defaultOption);

                    // Agregar las opciones de presentación
                    response.forEach(function(presentacion) {
                        var option = '<option value="' + presentacion.referencia_archivo + '">' + presentacion.nombre + '</option>';
                        $('#presentacionesDropdown').append(option);
                    });

                    // Mostrar el modal
                    $('#verPresentacionesModal').modal('show');
                },
                error: function(error) {
                    console.error('Error al obtener las presentaciones del evento', error);
                }
            });
        }
    </script>

    <script>
        function redirigirAPresentador() {
            // Obtener la referencia del archivo seleccionado
            var referenciaArchivo = $('#presentacionesDropdown').val();
            // Verificar si se seleccionó una presentación
            if (referenciaArchivo) {
                // Obtener el token CSRF
                var token = $('meta[name="csrf-token"]').attr('content');
                // Hacer la solicitud Ajax con el token CSRF
                $.ajax({
                    url: '<?php echo e(url("/guardar-referencia-archivo")); ?>',
                    type: 'POST',
                    data: {
                        _token: token,
                        referenciaArchivo: referenciaArchivo
                    },
                    success: function(response) {
                        console.log('Solicitud exitosa');
                        console.log(response);
                    },
                    error: function(error) {
                        console.error('Error en la solicitud');
                        console.error(error);
                    }
                });
                // Redirigir al presentador
                var urlCompleta = '<?php echo e(url("/presentador")); ?>';
                window.location.href = urlCompleta;
            } else {
                // Mostrar un mensaje o realizar alguna acción si no se seleccionó nada
                console.log('Por favor, selecciona una presentación antes de continuar.');
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#subirBtn').one('click', function() {
                // Obtiene el ID del evento (asegúrate de tener el valor correcto aquí)
                var idEvento = $('#idEvento').val();

                // Obtiene el token CSRF
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Crea un objeto FormData para enviar el formulario
                var formData = new FormData();
                formData.append('pdf', $('#pdf')[0].files[0]);
                formData.append('idEvento', idEvento);

                // Agrega el token CSRF a la solicitud
                formData.append('_token', csrfToken);

                // Realiza la solicitud Ajax con la URL correcta
                $.ajax({
                    url: '<?php echo e(route("eventos.guardarPresentacion", ["idEvento" => "_idEvento_"])); ?>'.replace('_idEvento_', idEvento),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Maneja la respuesta del servidor
                        console.log(response);
                        
                        // Cierra el modal si la carga es exitosa
                        $('#subirPresentacionModal').modal('hide');

                        // Puedes redirigir al usuario a la página deseada aquí
                        window.location.href = '<?php echo e(route("eventos.index")); ?>';
                    },
                    error: function(error) {
                        // Maneja el error
                        console.log(error);
                    }
                });
            });
        });
    </script>

</body>

</html><?php /**PATH C:\xampp\htdocs\presentador-laravel\resources\views/index.blade.php ENDPATH**/ ?>