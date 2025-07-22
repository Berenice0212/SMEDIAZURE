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
          <strong class="card-title">Registrar nuevo Reporte</strong>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('reportes.store') }}">
            @csrf

            <!-- Campo oculto para el usuario que crea el reporte (creado_por) -->
            <input type="hidden" name="creado_por" value="{{ auth()->user()->id }}">

            <!-- Campo oculto para el id_antena -->
            <input type="hidden" name="id_antena" id="id_antena">

            <div class="form-group mb-3">
              <label for="creado_por">Creado por</label>
              <input type="text" value="{{ auth()->user()->name }}" class="form-control" disabled>
            </div>

            <div class="form-group mb-3">
                <label for="tecnico_id">Técnico asignado</label>
                <select name="tecnico_id" class="form-control" required>
                @foreach($usuarios as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="ip_antena">Selecciona la IP de la Antena</label>
                <select name="ip_antena" id="ip_antena" class="form-control" required>
                <option value="">-- Selecciona una IP --</option>
                @foreach($antenas as $antena)
                    <option value="{{ $antena->ip }}" data-id="{{ $antena->id_antena }}">{{ $antena->ip }}</option>
                @endforeach
                </select>
            </div>

            <!-- Campos ocultos para los datos autocompletados -->
            <input type="hidden" name="id_localidad" id="id_localidad">
            <input type="hidden" name="id_municipio" id="id_municipio">
            <input type="hidden" name="latitud" id="latitud">
            <input type="hidden" name="longitud" id="longitud">

            <div class="form-group mb-3">
                <label>Localidad</label>
                <input type="text" id="localidad" class="form-control" disabled>
            </div>

            <div class="form-group mb-3">
                <label>Municipio</label>
                <input type="text" id="municipio" class="form-control" disabled>
            </div>

            <div class="form-group mb-3">
                <label for="fecha_fallo">Fecha del fallo</label>
                <input type="datetime-local" name="fecha_fallo" id="fecha_fallo" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="descripcion_admin">Descripción del Reporte</label>
                <textarea name="descripcion_admin" id="descripcion_admin" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group mt-4">
                <a href="{{ route('reportes.index') }}" class="btn btn-outline-danger">Cancelar</a>
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
  const antenas = @json($antenas);

    document.getElementById('ip_antena').addEventListener('change', function () {
        const selectedIP = this.value;
        const antena = antenas.find(a => a.ip === selectedIP);

        if (antena) {
            document.getElementById('localidad').value = antena.localidad?.localidad || 'N/D';
            document.getElementById('municipio').value = antena.municipio?.municipio || 'N/D';
            document.getElementById('latitud').value = antena.latitud;
            document.getElementById('longitud').value = antena.longitud;

            // Asignar valores a los campos ocultos
            document.getElementById('id_localidad').value = antena.id_localidad;
            document.getElementById('id_municipio').value = antena.id_municipio;
            document.getElementById('id_antena').value = antena.id_antena;  // Actualizar id_antena
        }
    });
    </script>
@endpush
