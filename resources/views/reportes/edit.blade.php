@extends('layouts.base')

@push('styles')
  <style>
    .navbar {
        justify-content: end;
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
    <div class="col-12 col-md-8">
      <div class="card shadow">
        <div class="card-header">
          <strong class="card-title">Editar Reporte</strong>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('reportes.update', $reporte->id) }}" id="guardarFormulario">
            @csrf
            @method('PUT')

            <!-- Información del Administrador (solo lectura) -->
            <div class="form-group mb-3">
              <label for="ip_antena">IP de la Antena</label>
              <input type="text" id="ip_antena" value="{{ $reporte->ip_antena }}" class="form-control" disabled>
            </div>

            <div class="form-group mb-3">
              <label for="localidad">Localidad</label>
              <input type="text" id="localidad" value="{{ $reporte->ubicacionAntena->localidad->localidad ?? 'N/D' }}" class="form-control" disabled>
            </div>

            <div class="form-group mb-3">
              <label for="municipio">Municipio</label>
              <input type="text" id="municipio" value="{{ $reporte->ubicacionAntena->municipio->municipio ?? 'N/D' }}" class="form-control" disabled>
            </div>

            <div class="form-group mb-3">
              <label for="latitud">Latitud</label>
              <input type="text" id="latitud" value="{{ $reporte->latitud }}" class="form-control" disabled>
            </div>

            <div class="form-group mb-3">
              <label for="longitud">Longitud</label>
              <input type="text" id="longitud" value="{{ $reporte->longitud }}" class="form-control" disabled>
            </div>

            <div class="form-group mb-3">
              <label for="descripcion_admin">Descripción del Reporte</label>
              <textarea id="descripcion_admin" class="form-control" rows="4" disabled>{{ $reporte->descripcion_admin }}</textarea>
            </div>

            <!-- Información editable para el técnico -->
            <div class="form-group mb-3">
              <label for="descripcion_tecnico">Descripción del Técnico</label>
              <textarea name="descripcion_tecnico" id="descripcion_tecnico" class="form-control" rows="4" required>{{ old('descripcion_tecnico', $reporte->descripcion_tecnico) }}</textarea>
            </div>

            <div class="form-group mb-3">
              <label for="solucion">Solución</label>
              <textarea name="solucion" id="solucion" class="form-control" rows="4" required>{{ old('solucion', $reporte->solucion) }}</textarea>
            </div>

            <div class="form-group mb-3">
              <label for="fecha_finalizacion">Fecha de Finalización</label>
              <input type="datetime-local" name="fecha_finalizacion" id="fecha_finalizacion" class="form-control" value="{{ old('fecha_finalizacion', $reporte->fecha_finalizacion ? $reporte->fecha_finalizacion : '') }}" required>
            </div>

            <div class="form-group mt-4">
              <a href="{{ route('reportes.index') }}" class="btn btn-outline-danger">Cancelar</a>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmModal">Guardar Reporte</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">Confirmar Guardado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        ¿Estás seguro de que deseas guardar este reporte? Después de guardar, no podrás editarlo.
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="confirmarGuardar">Aceptar</button>
      </div>

    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  document.getElementById('confirmarGuardar').addEventListener('click', function () {
    // Confirmar y enviar el formulario
    document.getElementById('guardarFormulario').submit();
  });
</script>
@endpush
