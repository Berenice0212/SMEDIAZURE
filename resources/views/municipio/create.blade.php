@extends('layouts.base')

@section('navbar')
  @include('layouts.navbar')
@endsection

@section('sidebar')
  @include('layouts.sidebar')
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8">
        <div class="card shadow">
          <div class="card-header">
            <h3 class="card-title">Registrar nuevo Municipio</h3>
            <div>
                <a href="{{ route('municipios.index') }}"><span class="text-muted">Municipios</span></a>
                <a href="#"><span class="text-muted">/Nuevo Municipio</span></a>
            </div>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('municipios.store') }}">
              @csrf
              
              <div class="form-group mb-3">
                <label for="municipio">Nombre del Municipio</label>
                <input type="text" id="municipio" name="municipio" class="form-control" placeholder="Escribe el nombre del municipio" required>
              </div>

              <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('municipios.index') }}" class="btn btn-secondary">Cancelar</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
