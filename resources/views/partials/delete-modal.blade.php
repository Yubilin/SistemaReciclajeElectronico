{{--
    Modal de confirmación de eliminación reutilizable.
    Cada botón disparador debe llevar:
      data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
      data-delete-url="{{ route('...destroy', $registro) }}"
      data-delete-label="Texto descriptivo del registro"
--}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="#" id="confirmDeleteForm" class="modal-content">
            @csrf
            @method('DELETE')

            <div class="modal-header border-0 pb-0">
                <h2 class="modal-title fs-5" id="confirmDeleteTitle">Confirmar eliminación</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <div class="d-flex gap-3">
                    <span class="raee-kpi__icon raee-kpi__icon--amber">
                        <i class="bi bi-exclamation-triangle" aria-hidden="true"></i>
                    </span>
                    <div>
                        <p class="mb-1">¿Seguro que deseas eliminar <strong id="confirmDeleteLabel">este registro</strong>?</p>
                        <p class="small text-body-secondary mb-0">Esta acción no se puede deshacer.</p>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash me-1" aria-hidden="true"></i>Eliminar
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        (function () {
            const modal = document.getElementById('confirmDeleteModal');
            if (!modal) return;

            modal.addEventListener('show.bs.modal', function (event) {
                const trigger = event.relatedTarget;
                if (!trigger) return;

                document.getElementById('confirmDeleteForm').action = trigger.dataset.deleteUrl;
                document.getElementById('confirmDeleteLabel').textContent =
                    trigger.dataset.deleteLabel || 'este registro';
            });
        })();
    </script>
@endpush
