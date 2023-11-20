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
                    <button style='margin-left:4px' onclick='verPresentacion({{ $evento->id }})'>Ver Presentaciones</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
