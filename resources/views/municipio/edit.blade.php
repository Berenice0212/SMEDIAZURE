@extends('layouts.base')

@push('styles')

@endpush

@section('navbar')
  @include('layouts.navbar')
@endsection

@section('sidebar')
  @include('layouts.sidebar')
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
                <h3 class="mb-0">Editar Municipio</h3>
                <div class="mb-4">
                    <a href="{{ route('municipios.index') }}"><span class="text-muted">Municipios</span></a>
                    <a href="#"><span class="text-muted">/Editar Municipio</span></a>
                </div>

                <form action="{{ route('municipios.update', $municipio->id_municipio) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nombre del Municipio -->
                    <div class="form-group">
                        <label for="municipio">Nombre del Municipio</label>
                        <input type="text" name="municipio" class="form-control" value="{{ old('municipio', $municipio->municipio) }}" required>
                    </div>

                    <!-- Botones -->
                    <div>
                        <a href="{{ route('municipios.index') }}" class="btn btn-outline-danger">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
