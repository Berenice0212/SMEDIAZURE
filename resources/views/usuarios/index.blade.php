@extends('layouts.base')

@section('navbar')
  @include('layouts.navbar')
@endsection

@section('sidebar')
  @include('layouts.sidebar')
@endsection

  {{-- Contenido principal --}}
  @section('content')
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="row align-items-center mb-2">
              <div class="col">
                <h2 class="h5 page-title">Listado de Localidades</h2>
              </div>
            </div>

            <div class="card shadow">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table datatables table-striped">
                    <caption>Usuarios</caption>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role ? $user->role->rol : 'Sin rol asignado' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align:center;">No hay usuarios registrados</td>
                                </tr>
                            @endforelse
                        </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
  @endsection
