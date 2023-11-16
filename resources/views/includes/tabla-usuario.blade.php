<table class="table">
    <thead style="color: #ffffff">
        <tr>
            <th>Evento</th>
            <th>Fecha</th>
            <th>Descripción</th>
            <th>Operaciones</th> <!-- Nueva columna para los botones -->
        </tr>
    </thead>
    <tbody>
        <!-- PHP Prueba -->
        <?php
            $query = "SELECT e.nombre AS nombre_evento, e.fecha AS fecha, e.descripcion AS descripcion, e.id AS id_evento
            FROM evento e
            JOIN asistente a ON e.id = a.evento_id
            JOIN rol r ON a.rol_id = r.id
            JOIN usuario u ON a.participante_id = u.id
            WHERE e.tipo_evento = 'Formal' AND r.nombre = 'presentador' AND u.idAuth0 = '$token';";

            $result = mysqli_query($connection, $query);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td style='color: #ffffff'>" . $row["nombre_evento"] . "</td>";
                        echo "<td style='color: #ffffff'>" . $row["fecha"] . "</td>";
                        echo "<td style='color: #ffffff'>" . $row["descripcion"] . "</td>";
                        echo "<td>";
                        echo "<button style='margin-right:4px' onclick='subirPresentacion(" . $row["id_evento"] . ")'>Subir Presentaciones</button>";
                        echo "<button style='margin-left:4px' onclick='verPresentacion(" . $row["id_evento"] . ")'>Ver Presentaciones</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr> <td colspan='7'>No records found</td> </tr>";
                }
            } else {
                echo "Error executing query: " . mysqli_error($connection);
            }
        ?>
    </tbody>
</table>