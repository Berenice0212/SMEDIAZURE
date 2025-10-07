@extends('layouts.base')

@push('styles')
<style>
  .muted { color: #6c757d; }
</style>
@endpush

@section('navbar')
  @include('layouts.navbar')
@endsection

@section('sidebar')
  @include('layouts.sidebar')
@endsection

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-9">

      <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h5 mb-0">Nuevo Reporte (Administrador)</h2>
        <div>
          <a href="{{ route('reporte-principal.index') }}" class="btn btn-sm btn-outline-secondary">Volver</a>
        </div>
      </div>

      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $e)
              <li>{{ $e }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="card shadow">
        <div class="card-header">
          <strong class="card-title">Datos del reporte</strong>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('reporte-principal.store') }}">
            @csrf

            {{-- Creado por --}}
            <input type="hidden" name="creado_por" value="{{ auth()->user()->id }}">
            {{-- id_antena --}}
            <input type="hidden" name="id_antena" id="id_antena">

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="mb-0">Creado por</label>
                <div class="form-control" disabled>{{ auth()->user()->name }}</div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="tecnico_id" class="mb-0">Técnico asignado</label>
                <select name="tecnico_id" id="tecnico_id" class="form-control" required>
                  <option value="">-- Selecciona un técnico --</option>
                  @foreach($usuarios as $user)
                    <option value="{{ $user->id }}" @selected(old('tecnico_id')==$user->id)>{{ $user->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-6 mb-3">
                <label for="ip_antena" class="mb-0">Selecciona la IP de la Antena</label>
                <select name="ip_antena" id="ip_antena" class="form-control" required>
                  <option value="">-- Selecciona una IP --</option>
                  @foreach($antenas as $antena)
                    <option value="{{ $antena->ip }}" data-id="{{ $antena->id_antena }}"
                            @selected(old('ip_antena')==$antena->ip)>
                      {{ $antena->ip }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label class="mb-0">Fecha del fallo</label>
                <input type="datetime-local" name="fecha_fallo" id="fecha_fallo"
                       class="form-control" value="{{ old('fecha_fallo') }}" required>
              </div>

              {{-- Hidden snapshot --}}
              <input type="hidden" name="id_localidad" id="id_localidad" value="{{ old('id_localidad') }}">
              <input type="hidden" name="id_municipio" id="id_municipio" value="{{ old('id_municipio') }}">
              <input type="hidden" name="latitud" id="latitud" value="{{ old('latitud') }}">
              <input type="hidden" name="longitud" id="longitud" value="{{ old('longitud') }}">

              {{-- Vista snapshot solo-lectura --}}
              <div class="col-md-6 mb-3">
                <label class="mb-0">Localidad</label>
                <input type="text" id="localidad" class="form-control" value="{{ old('localidad') }}" disabled>
              </div>
              <div class="col-md-6 mb-3">
                <label class="mb-0">Municipio</label>
                <input type="text" id="municipio" class="form-control" value="{{ old('municipio') }}" disabled>
              </div>
              <div class="col-md-6 mb-3">
                <label class="mb-0">Latitud</label>
                <input type="text" id="latitud_view" class="form-control" value="{{ old('latitud') }}" disabled>
              </div>
              <div class="col-md-6 mb-3">
                <label class="mb-0">Longitud</label>
                <input type="text" id="longitud_view" class="form-control" value="{{ old('longitud') }}" disabled>
              </div>

              <div class="col-12">
                <label for="descripcion_admin" class="mb-1">Descripción del Reporte</label>
                <textarea name="descripcion_admin" id="descripcion_admin" class="form-control" rows="4" required>{{ old('descripcion_admin') }}</textarea>
              </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
              <a href="{{ route('reporte-principal.index') }}" class="btn btn-outline-danger mr-2">Cancelar</a>
              <button type="submit" class="btn btn-primary">Crear Reporte</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // Antenas desde backend
  const antenas = @json($antenas);

  const selIp       = document.getElementById('ip_antena');
  const idAntena    = document.getElementById('id_antena');
  const idLoc       = document.getElementById('id_localidad');
  const idMun       = document.getElementById('id_municipio');
  const lat         = document.getElementById('latitud');
  const lon         = document.getElementById('longitud');

  const vLoc        = document.getElementById('localidad');
  const vMun        = document.getElementById('municipio');
  const vLat        = document.getElementById('latitud_view');
  const vLon        = document.getElementById('longitud_view');

  selIp.addEventListener('change', function () {
    const selectedIP = this.value;
    const antena = antenas.find(a => a.ip === selectedIP);
    if (!antena) return;

    // llenar hidden
    idAntena.value = antena.id_antena;
    idLoc.value    = antena.id_localidad;
    idMun.value    = antena.id_municipio;
    lat.value      = antena.latitud;
    lon.value      = antena.longitud;

    // vista
    vLoc.value = antena.localidad?.localidad || 'N/D';
    vMun.value = antena.municipio?.municipio || 'N/D';
    vLat.value = antena.latitud;
    vLon.value = antena.longitud;
  });
</script>
@endpush
