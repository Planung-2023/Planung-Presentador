<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content={{ csrf_token() }}>
    <title>Listado de Eventos</title>
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
</head>

<body style="background-color: #3a3a3a;">
    
    @include('includes.navbar')

    <div class="col-md-11 text-center mx-auto" style="background-color:#6a6d71; padding:20px; border-radius: 10px; margin-top: 4%; color: #ffffff;">
        <h2 class="mb-4 text-center">Listado de Eventos</h2>
        <div class="col-md-12 text-center">
            <table class="table table-striped table-hover table-bordered table-rounded">
                <thead style="color: #ffffff;">
                    <tr class="table-dark">
                        <th>Evento</th>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Presentaciones subidas</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($eventos as $evento)
                        <tr>
                            <td style='color: #ffffff'>{{ $evento->nombre }}</td>
                            <td style='color: #ffffff'>{{ $evento->fecha }}</td>
                            <td style='color: #ffffff; white-space: normal !important;'>{{ $evento->descripcion }}</td>
                            <td style='color: #ffffff'>{{ $evento->cantidad_presentaciones }}</td>
                            <td>
                                <button class="btn btn-dark" style='margin-right:4px' onclick='console.log("ID del Evento:", {{ $evento->id }}); abrirModalConEvento({{ $evento->id }})'>Subir Presentaciones</button>
                                
                                @if ($evento->cantidad_presentaciones > 0)
                                    <button class="btn btn-dark" type="button" onclick="mostrarPresentacionesModal({{ $evento->id }})">Ver Presentaciones</button>
                                @else
                                    <button class="btn btn-dark" type="button" disabled>Ver Presentaciones</button>
                                @endif
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('.dropdown-toggle').dropdown();
            console.log('Dropdown inicializado');

            $('.dropdown-toggle').on('click', function() {
                console.log('Clic en el dropdown');
            });
        });
    </script>

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
                url: "{{ url('/presentaciones/') }}" + "/" + eventoId,
                type: 'GET',
                success: function(response) {
                    // Limpiar y llenar el dropdown con las presentaciones obtenidas
                    $('#presentacionesDropdown').empty();
                    var defaultOption = '<option value="" disabled selected>Elige una presentación</option>';
                    $('#presentacionesDropdown').append(defaultOption);

                    // Agregar las opciones de presentación
                    response.forEach(function(presentacion) {
                        var option = '<option value="' + presentacion.idevento_presentacion + '">' + presentacion.nombre + '</option>';
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
            var idevento_presentacion = $('#presentacionesDropdown').val();
            
            // Verificar si se seleccionó una presentación
            if (idevento_presentacion !== null) {
                // Construir la URL sin incluir el fragmento del archivo
                var urlCompleta = '{{ url("/presentador/") }}' + '/' + idevento_presentacion;
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
                    url: '{{ route("eventos.guardarPresentacion", ["idEvento" => "_idEvento_"]) }}'.replace('_idEvento_', idEvento),
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
                        window.location.href = '{{ route("eventos.index") }}';
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

</html>