@extends('layouts.base')

@push('styles')
<style>
  .navbar { justify-content: end; }
  .badge-status { font-size: .9rem; }
  .media-thumb { width: 120px; height: 90px; object-fit: cover; border-radius: .5rem; }
  .media-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: .75rem; }
  .muted { color: #6c757d; }
  .preview-item { position: relative; width: 120px; }
  .preview-item img { width: 120px; height: 90px; object-fit: cover; border-radius: .5rem; }
  .preview-remove {
    position: absolute; top: -8px; right: -8px; border:0; border-radius: 50%;
    width: 24px; height: 24px; line-height: 24px; text-align:center;
  }
</style>
@endpush

@section('navbar')
  @include('layouts.navbar')
@endsection

@section('sidebar')
@endsection

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-9">

      {{-- Encabezado --}}
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h5 mb-0">Reporte #{{ $reporte_principal->id }}</h2>
        <div>
          @php
            $badge = $reporte_principal->estado === 'pendiente' ? 'warning' :
                     ($reporte_principal->estado === 'en_proceso' ? 'info' : 'success');
          @endphp
          <span class="badge badge-{{ $badge }} badge-status text-uppercase">
            {{ ucfirst($reporte_principal->estado) }}
          </span>
          <a href="{{ route('reporte-principal.index') }}" class="btn btn-sm btn-outline-secondary ml-2">Volver</a>
        </div>
      </div>

      {{-- Mensajes --}}
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="fe fe-check-circle fe-16 mr-2"></span>{{ session('success') }}
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span></button>
        </div>
      @endif
      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $e)
              <li>{{ $e }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- RESUMEN DEL REPORTE PRINCIPAL --}}
      <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <strong>Resumen del Reporte</strong>
          @if($reporte_principal->fecha_finalizacion)
            <span class="muted">Cerrado: {{ $reporte_principal->fecha_finalizacion }}</span>
          @endif
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="mb-0">Creado por</label>
              <div class="form-control" disabled>{{ $reporte_principal->creador->name ?? '—' }}</div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="mb-0">Técnico asignado</label>
              <div class="form-control" disabled>{{ $reporte_principal->tecnico->name ?? '—' }}</div>
            </div>

            <div class="col-md-4 mb-3">
              <label class="mb-0">IP Antena</label>
              <div class="form-control" disabled>{{ $reporte_principal->ip_antena }}</div>
            </div>
            <div class="col-md-4 mb-3">
              <label class="mb-0">Localidad</label>
              <div class="form-control" disabled>{{ $reporte_principal->antena?->localidad?->localidad ?? '—' }}</div>
            </div>
            <div class="col-md-4 mb-3">
              <label class="mb-0">Municipio</label>
              <div class="form-control" disabled>{{ $reporte_principal->antena?->municipio?->municipio ?? '—' }}</div>
            </div>

            <div class="col-md-4 mb-3">
              <label class="mb-0">Latitud</label>
              <div class="form-control" disabled>{{ $reporte_principal->latitud }}</div>
            </div>
            <div class="col-md-4 mb-3">
              <label class="mb-0">Longitud</label>
              <div class="form-control" disabled>{{ $reporte_principal->longitud }}</div>
            </div>
            <div class="col-md-4 mb-3">
              <label class="mb-0">Fecha del fallo</label>
              <div class="form-control" disabled>{{ $reporte_principal->fecha_fallo }}</div>
            </div>

            <div class="col-12">
              <label class="mb-1">Descripción</label>
              <textarea class="form-control" rows="4" disabled>{{ $reporte_principal->descripcion_admin }}</textarea>
            </div>
          </div>
        </div>
      </div>

      {{-- LISTA DE SUBREPORTES (TÉCNICO) --}}
      <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <strong>Subreportes del técnico</strong>
          <span class="muted">{{ $reporte_principal->subreportes->count() }} registro(s)</span>
        </div>
        <div class="card-body">
          @forelse($reporte_principal->subreportes->sortByDesc('fecha_visita') as $sub)
            <div class="border rounded p-3 mb-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                  <strong>#{{ $sub->id }}</strong>
                  <span class="muted">por {{ $sub->tecnico->name ?? '—' }}</span>
                </div>
                @php
                  $b = $sub->estado_after === 'pendiente' ? 'warning' :
                       ($sub->estado_after === 'en_proceso' ? 'info' : 'success');
                @endphp
                <span class="badge badge-{{ $b }}">{{ ucfirst($sub->estado_after) }}</span>
              </div>

              <div class="row">
                <div class="col-md-4 mb-2">
                  <label class="mb-0">Fecha visita</label>
                  <div class="form-control" disabled>{{ $sub->fecha_visita }}</div>
                </div>
                <div class="col-md-8 mb-2">
                  <label class="mb-0">Descripción del técnico</label>
                  <textarea class="form-control" rows="2" disabled>{{ $sub->descripcion_tecnico }}</textarea>
                </div>
                <div class="col-12 mb-2">
                  <label class="mb-0">Solución</label>
                  <textarea class="form-control" rows="2" disabled>{{ $sub->solucion ?? '—' }}</textarea>
                </div>
              </div>

              {{-- Galería de imágenes --}}
              @if($sub->medias->count())
                <div class="mt-2">
                  <label class="mb-1">Imágenes</label>
                  <div class="media-grid">
                    @foreach($sub->medias as $m)
                      @php
                        $url = Storage::url($m->path);
                        $esImagen = Str::startsWith($m->mime, 'image/');
                      @endphp
                      <div>
                        @if($esImagen)
                          <a href="{{ $url }}" target="_blank">
                            <img src="{{ $url }}" class="media-thumb" alt="Evidencia">
                          </a>
                        @else
                          <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                            Ver archivo
                          </a>
                        @endif
                        <div class="small muted mt-1">{{ $m->mime ?? 'archivo' }}</div>
                      </div>
                    @endforeach
                  </div>
                </div>
              @endif

            </div>
          @empty
            <div class="text-center muted">Aún no hay subreportes.</div>
          @endforelse
        </div>
      </div>

      {{-- FORMULARIO: NUEVO SUBREPORTE (solo técnico asignado y no finalizado) --}}
        @if($reporte_principal->estado !== 'finalizado' && auth()->id() === (int) $reporte_principal->tecnico_id)
            <div class="card shadow mb-5">
                <div class="card-header">
                    <strong>Registrar subreporte (técnico)</strong>
                </div>
                <div class="card-body">
                <form method="POST"
                        action="{{ route('subreportes.store', $reporte_principal->id) }}"
                        enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="fecha_visita">Fecha de visita</label>
                        <input type="datetime-local" name="fecha_visita" id="fecha_visita" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="estado_after">Estado después</label>
                        <select name="estado_after" id="estado_after" class="form-control" required>
                        <option value="en_proceso">En proceso</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="finalizado">Finalizado</option>
                        </select>
                    </div>
                    </div>

                    <div class="form-group">
                    <label for="descripcion_tecnico">Descripción del técnico</label>
                    <textarea name="descripcion_tecnico" id="descripcion_tecnico" rows="3" class="form-control" required></textarea>
                    </div>

                    <div class="form-group">
                    <label for="solucion">Solución (opcional)</label>
                    <textarea name="solucion" id="solucion" rows="2" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                    <label>Imágenes (múltiples) — opcional</label>
                    <input type="file" class="form-control-file" name="archivos[]" id="archivos" multiple
                            accept=".jpg,.jpeg,.png,.webp,.pdf">
                    <small class="form-text text-muted">
                        Formatos: jpg, jpeg, png, webp, pdf. Máx 5MB c/u.
                    </small>

                    {{-- Previsualización --}}
                    <div id="previewGrid" class="d-flex flex-wrap mt-3" style="gap:10px;"></div>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar subreporte</button>
                </form>
                </div>
            </div>
        @endif

    </div>
  </div>
</div>
@endsection

<!-- Modal de Confirmación de Cierre -->
<div class="modal fade" id="confirmCloseModal" tabindex="-1" role="dialog" aria-labelledby="confirmCloseLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="confirmCloseLabel">Confirmar guardado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        ¿Estás seguro de que deseas guardar este subreporte?
        <br>
        <strong>Si seleccionas “Finalizado”:</strong> no podrás agregar más información ni imágenes a este reporte.
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="confirmarGuardarSubreporte">Aceptar</button>
      </div>

    </div>
  </div>
</div>

@push('scripts')
<script>
// ======== PREVIEW + REMOVE ========
(function() {
const input = document.getElementById('archivos');
const grid  = document.getElementById('previewGrid');

if (!input || !grid) return;

function renderPreviews(files) {
    grid.innerHTML = '';
    Array.from(files).forEach((file, idx) => {
    const item = document.createElement('div');
    item.className = 'preview-item';

    // Botón quitar
    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'btn btn-sm btn-danger preview-remove';
    removeBtn.innerHTML = '×';
    removeBtn.title = 'Quitar archivo';
    removeBtn.addEventListener('click', () => removeFileAt(idx));

    // Vista imagen/pdf
    let thumb;
    if (file.type.startsWith('image/')) {
        thumb = document.createElement('img');
        const reader = new FileReader();
        reader.onload = e => (thumb.src = e.target.result);
        reader.readAsDataURL(file);
    } else {
        // No imagen (pdf u otro) -> ícono simple
        thumb = document.createElement('div');
        thumb.className = 'd-flex align-items-center justify-content-center border rounded';
        thumb.style.width = '120px';
        thumb.style.height = '90px';
        thumb.innerHTML = '<span class="small text-muted">Archivo</span>';
    }

    item.appendChild(thumb);
    item.appendChild(removeBtn);
    grid.appendChild(item);
    });
}

function removeFileAt(index) {
    // FileList no es mutable: recreamos con DataTransfer
    const dt = new DataTransfer();
    const { files } = input;

    Array.from(files).forEach((file, idx) => {
    if (idx !== index) dt.items.add(file);
    });
    input.files = dt.files;
    renderPreviews(input.files);
}

input.addEventListener('change', function() {
    renderPreviews(this.files);
});
})();


// ======== CONFIRMACIÓN AL ENVIAR SUBREPORTE ========
(function() {
  const form = document.querySelector('form[action*="subreportes"][method="POST"]');
  if (!form) return;

  const estadoSelect = document.getElementById('estado_after');
  const confirmModal = $('#confirmCloseModal');
  const confirmBtn   = document.getElementById('confirmarGuardarSubreporte');

  let shouldSubmit = false;

  form.addEventListener('submit', function(e) {
    // Evitar submit la primera vez
    if (shouldSubmit) return; // ya confirmado

    e.preventDefault();

    const estado = (estadoSelect?.value || '').toLowerCase();

    // B) Solo confirmar si es finalizado:
    if (estado === 'finalizado') {
      confirmModal.modal('show');
    } else {
      // A) Para mostrar SIEMPRE: descomenta la siguiente línea y borra el if anterior.
      // confirmModal.modal('show'); return;

      // Si no es finalizado, envía de una vez
      shouldSubmit = true;
      form.submit();
    }
  });

  // Confirmación del modal
  confirmBtn?.addEventListener('click', function() {
    confirmModal.modal('hide');
    shouldSubmit = true;
    form.submit();
  });
})();
</script>
@endpush
