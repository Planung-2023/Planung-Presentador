<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content={{ csrf_token() }}>
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <title>Listado de Eventos</title>
</head>

<body style="background-color: #3a3a3a;">
    
    @include('includes.navbar')

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
                    @foreach ($eventos as $evento)
                        <tr>
                            <td style='color: #ffffff'>{{ $evento->nombre }}</td>
                            <td style='color: #ffffff'>{{ $evento->fecha }}</td>
                            <td style='color: #ffffff'>{{ $evento->descripcion }}</td>
                            <td>
                                <button style='margin-right:4px' onclick='subirPresentacion({{ $evento->id }})'>Subir Presentaciones</button>
                                <button type="button" onclick="mostrarPresentacionesModal()">Ver Presentaciones</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('includes.popups.subir-presentacion')
    @include('includes.popups.ver-presentacion')

    @include('includes.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <script>
        function subirPresentacion(eventId) {
            $('#subirPresentacionModal').modal('show');
        }
    </script>

    <script>
        function mostrarPresentacionesModal() {
            $('#verPresentacionesModal').modal('show');

            // Limpiar y llenar el dropdown con todas las presentaciones disponibles
            $('#presentacionesDropdown').empty();

            // Agregar la opción preseleccionada y deshabilitada
            var defaultOption = '<option value="" disabled selected>Elige una presentación</option>';
            $('#presentacionesDropdown').append(defaultOption);

            // Agregar las opciones de presentación
            @foreach ($presentaciones as $presentacion)
                var option = '<option value="{{ $presentacion->referencia_archivo }}">{{ $presentacion->nombre }}</option>';
                $('#presentacionesDropdown').append(option);
            @endforeach
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
                    url: '{{ url("/guardar-referencia-archivo") }}',
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
                var urlCompleta = '{{ url("/presentador") }}';
                window.location.href = urlCompleta;
            } else {
                // Mostrar un mensaje o realizar alguna acción si no se seleccionó nada
                console.log('Por favor, selecciona una presentación antes de continuar.');
            }
        }
    </script>


</body>

</html>