<div class="modal fade" id="subirPresentacionModal" tabindex="-1" aria-labelledby="subirPresentacionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subirPresentacionModalLabel">Subir Presentación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Verificar si $evento está definido -->
            <?php if(isset($evento)): ?>
                <form method="POST" action="<?php echo e(route('eventos.guardarPresentacion')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="idEvento" id="idEvento">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="pdf" class="form-label">Seleccionar PDF</label>
                            <input type="file" class="form-control" id="pdf" name="pdf" accept=".pdf" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Subir</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\presentador-laravel\resources\views/includes/popups/subir-presentacion.blade.php ENDPATH**/ ?>