@extends('layouts.base')

@push('styles')
  <style>
    .navbar {
        justify-content: end;
    }
    .form-label-static {
        display: block;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .form-control-static {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-radius: .375rem;
        padding: 0.5rem 0.75rem;
        color: #495057;
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
        <div class="card shadow mb-4">
            <div class="card-body">
                <h3 class="mb-4">Detalles de la Antena</h3>

                <!-- IP -->
                <div class="form-group mb-3">
                    <label class="form-label-static">IP</label>
                    <div class="form-control-static">{{ $antena->ip }}</div>
                </div>

                <!-- Latitud -->
                <div class="form-group mb-3">
                    <label class="form-label-static">Latitud</label>
                    <div class="form-control-static">{{ $antena->latitud }}</div>
                </div>

                <!-- Longitud -->
                <div class="form-group mb-3">
                    <label class="form-label-static">Longitud</label>
                    <div class="form-control-static">{{ $antena->longitud }}</div>
                </div>

                <!-- Localidad -->
                <div class="form-group mb-3">
                    <label class="form-label-static">Localidad</label>
                    <div class="form-control-static">{{ $antena->localidad->localidad ?? 'N/A' }}</div>
                </div>

                <!-- Municipio -->
                <div class="form-group mb-3">
                    <label class="form-label-static">Municipio</label>
                    <div class="form-control-static">{{ $antena->municipio->municipio ?? 'N/A' }}</div>
                </div>

                <!-- Estado de Energía -->
                <div class="form-group mb-3">
                    <label class="form-label-static">Estado de Energía</label>
                    <div class="form-control-static">{{ $antena->estadoEnergia->estado_energia ?? 'N/A' }}</div>
                </div>

                <!-- Botón regresar -->
                <div class="mt-4">
                    <a href="{{ route('ubicacion_antenas.index') }}" class="btn btn-outline-primary">Regresar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
