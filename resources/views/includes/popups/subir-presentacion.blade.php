<div class="modal fade" id="subirPresentacionModal" tabindex="-1" aria-labelledby="subirPresentacionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subirPresentacionModalLabel">Subir Presentación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Verificar si $evento está definido -->
            @isset($evento)
            {{--
                <form method="POST" action="{{ route('eventos.guardarPresentacion') }}" enctype="multipart/form-data">
            --}}
                    @csrf
                    <input type="hidden" name="idEvento" id="idEvento">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="pdf" class="form-label">Seleccionar PDF</label>
                            <input type="file" class="form-control" id="pdf" name="pdf" accept=".pdf" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="subirBtn">Subir</button>
                    </div>
            {{--
                </form>
            --}}
            @endisset
        </div>
    </div>
</div>
