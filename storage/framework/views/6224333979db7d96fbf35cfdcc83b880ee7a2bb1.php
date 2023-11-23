<div class="modal fade" id="verPresentacionesModal" tabindex="-1" aria-labelledby="verPresentacionesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verPresentacionesModalLabel">Presentaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="presentacionesDropdown">Selecciona una presentación:</label>
                <select id="presentacionesDropdown" class="form-select">
                    <option value="" disabled selected>Elige una presentación</option>
                    <?php $__currentLoopData = $evento->presentaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $presentacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($presentacion->idevento_presentacion); ?>"><?php echo e($presentacion->nombre); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="redirigirAPresentador()">Siguiente</button>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\presentador-laravel\resources\views/includes/popups/ver-presentacion.blade.php ENDPATH**/ ?>