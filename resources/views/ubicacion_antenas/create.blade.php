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
<div class="container d-flex justify-content-center align-items-start mt-0">

    <div class="col-md-7">
        <!-- Mensajes de error -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Hubo algunos errores:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <h3 class="mb-4">Registrar Nueva Antena</h2>

                <form action="{{ route('ubicacion_antenas.store') }}" method="POST">
                    @csrf

                    <!-- IP -->
                    <div class="form-group">
                        <label for="ip">IP</label>
                        <input type="text" name="ip" class="form-control" placeholder="Ej: 192.168.1.10" required>
                    </div>
            
                    <!-- Latitud -->
                    <div class="form-group">
                        <label for="latitud">Latitud</label>
                        <input type="text" name="latitud" class="form-control" placeholder="Ej: 19.4326" required>
                    </div>
            
                    <!-- Longitud -->
                    <div class="form-group">
                        <label for="longitud">Longitud</label>
                        <input type="text" name="longitud" class="form-control" placeholder="Ej: -99.1332" required>
                    </div>
            
                    <!-- Localidad -->
                    <div class="form-group">
                        <label for="id_localidad">Localidad</label>
                        <select name="id_localidad" class="form-control" required>
                            <option value="">Seleccione una localidad</option>
                            @foreach($localidades as $localidad)
                                <option value="{{ $localidad->id_localidad }}">{{ $localidad->localidad }}</option>
                            @endforeach
                        </select>
                    </div>
            
                    <!-- Municipio -->
                    <div class="form-group">
                        <label for="id_municipio">Municipio</label>
                        <select name="id_municipio" class="form-control" required>
                            <option value="">Seleccione un municipio</option>
                            @foreach($municipios as $municipio)
                                <option value="{{ $municipio->id_municipio }}">{{ $municipio->municipio }}</option>
                            @endforeach
                        </select>
                    </div>
            
                    <!-- Estado Energía -->
                    <div class="form-group">
                        <label for="id_estado_energia">Estado de Energía</label>
                        <select name="id_estado_energia" class="form-control" required>
                            <option value="">Seleccione un estado</option>
                            @foreach($estadosEnergia as $estado)
                                <option value="{{ $estado->id_estado_energia }}">{{ $estado->estado_energia }}</option>
                            @endforeach
                        </select>
                    </div>
            
                    <!-- Dispositivo -->

                    <!-- Botones -->
                    <div>
                        <a href="{{ route('ubicacion_antenas.index') }}" class="btn btn-outline-danger">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
