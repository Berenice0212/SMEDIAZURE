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
          <strong class="card-title">Detalles del Reporte</strong>
        </div>
        <div class="card-body">
          <form method="POST" action="#">
            @csrf

            <!-- Información del Administrador (quién creó el reporte) -->
            <div class="form-group mb-3">
              <label for="creado_por">Creado por (Administrador)</label>
              <input type="text" id="creado_por" value="{{ $reporte->creador->name }}" class="form-control" disabled>
            </div>

            <!-- Información del Técnico (quién resolvió el reporte) -->
            <div class="form-group mb-3">
              <label for="tecnico_id">Técnico encargado</label>
              <input type="text" id="tecnico_id" value="{{ $reporte->tecnico->name }}" class="form-control" disabled>
            </div>

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

            <!-- Información del técnico (solo lectura) -->
            <div class="form-group mb-3">
              <label for="descripcion_tecnico">Descripción del Técnico</label>
              <textarea id="descripcion_tecnico" class="form-control" rows="4" disabled>{{ $reporte->descripcion_tecnico ?? 'N/D' }}</textarea>
            </div>

            <div class="form-group mb-3">
              <label for="solucion">Solución</label>
              <textarea id="solucion" class="form-control" rows="4" disabled>{{ $reporte->solucion ?? 'N/D' }}</textarea>
            </div>

            <div class="form-group mb-3">
              <label for="fecha_finalizacion">Fecha de Finalización</label>
              <input type="text" id="fecha_finalizacion" value="{{ $reporte->fecha_finalizacion ? $reporte->fecha_finalizacion : 'N/D' }}" class="form-control" disabled>
            </div>

            <div class="form-group mt-4">
              <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary">Volver a la lista</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
