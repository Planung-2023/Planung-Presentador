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
<?php /**PATH C:\xampp\htdocs\presentador-laravel\resources\views/includes/tabla-eventos.blade.php ENDPATH**/ ?>