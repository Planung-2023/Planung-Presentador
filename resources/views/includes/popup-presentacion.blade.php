{{-- Corregir / Pasar a laravel --}}
<div>
    <form action="presentador/presentador.php" method="GET" id="miPopup" class="popup" style="display: none; background-color: white; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);">
        <div class="popup-contenido">
            <span class="cerrar" id="cerrarPopup">&times;</span>
            <ul id="listaUrls">
                <h2>Presentaciones</h2>
                <!-- Reemplaza la tabla con un dropdown -->
                <label for="archivoDropdown">Selecciona un archivo:</label>
                <select id="archivoDropdown" class="form-select" name="archivoSeleccionado">
                    <option value="" disabled selected>Elige un archivo</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["url"] . "'>" . $row["nombre"] . "</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No hay datos disponibles</option>";
                    }
                    ?>
                </select>
                 <!-- Botón "Siguiente" -->
                 <button type="sumbit" class="btn btn-primary mt-2">Siguiente</button>

                <?php
                // Cerrar la conexión a la base de datos
                $conn->close();
                ?>
            </ul>
        </div>
    </form>
</div>