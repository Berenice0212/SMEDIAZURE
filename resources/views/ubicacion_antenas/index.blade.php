@extends('layouts.base')

@push('styles')
  <!-- DataTables Bootstrap 4 CSS -->
  <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}">
@endpush

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
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h2 class="h5 page-title mb-0">Listado de Localidades</h2>
              <a href="{{ route('ubicacion_antenas.create') }}" class="btn btn-primary mb-2">
                + Nueva Antena
              </a>
            </div>

            <!-- Alertas de la tabla -->
            @if(session('success'))
                <div class="alert alert-{{ session('alert_type', 'success') }} alert-dismissible fade show" role="alert">
                    @if(session('alert_type') === 'danger')
                        <span class="fe fe-alert-triangle fe-16 mr-2"></span>
                        <b>¡Eliminado!</b>
                    @else
                        <span class="fe fe-check-circle fe-16 mr-2"></span>
                        <b>¡Éxito!</b>
                    @endif
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif

            <!-- Samall table -->
            <div class="col-md-12">
              <div class="card shadow">
                <div class="card-body">
                  <!-- Comienzo table -->
                  <div id="dataTable-1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <!-- Sección de la tabla -->
                    <div class="row">
                      <div class="col-sm-12">
                        <table class="table datatables dataTable no-footer" id="dataTable-1" role="grid" aria-describedby="dataTable-1_info">
                          <thead>
                              <tr role="row">
                                  <th>ID</th>
                                  <th>IP</th>
                                  <th>Localidad</th>
                                  <th>Municipio</th>
                                  <th>Estado Energía</th>
                                  <th>Latitud</th>
                                  <th>Longitud</th>
                                  <th>Actividades</th>
                              </tr>
                              </thead>
                              <tbody>
                              @foreach ($antenas as $antena)
                                  <tr role="row" class="odd">
                                    <td>{{ $antena->id_antena }}</td>
                                    <td>{{ $antena->ip }}</td>
                                    <td>{{ $antena->localidad->localidad ?? 'N/A' }}</td>
                                    <td>{{ $antena->municipio->municipio ?? 'N/A' }}</td>
                                    <td>{{ $antena->estadoEnergia->estado_energia ?? 'N/A' }}</td>
                                    <td>{{ $antena->latitud }}</td>
                                    <td>{{ $antena->longitud }}</td>
                                    <td>
                                      <a href="{{ route('ubicacion_antenas.edit', $antena->id_antena) }}" class="btn btn-sm btn-outline-warning">Editar</a>
                                      <a href="{{ route('ubicacion_antenas.show', $antena->id_antena) }}" class="btn btn-sm btn-outline-info">Ver</a>

                                      <!-- Botón que lanza el modal -->
                                      <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#confirmModal{{ $antena->id_antena }}">
                                        Eliminar
                                      </button>

                                      <!-- Modal -->
                                      <div class="modal fade" id="confirmModal{{ $antena->id_antena }}" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel{{ $antena->id_antena }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                          <div class="modal-content">

                                            <div class="modal-header">
                                              <h5 class="modal-title" id="confirmModalLabel{{ $antena->id_antena }}">Confirmar Eliminación</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>

                                            <div class="modal-body">
                                              ¿Estás seguro de que deseas eliminar esta antena con IP <strong>{{ $antena->ip }}</strong>?
                                            </div>

                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                                              <form action="{{ route('ubicacion_antenas.destroy', $antena->id_antena) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                              </form>
                                            </div>

                                          </div>
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                              @endforeach
                              </tbody>
                        </table>
                      </div>
                    </div>
                    <!-- Fin Sección de la tabla -->
                  </div>
                  <!-- Fin table -->
                </div>
              </div>
            </div>
            <!-- Fin Samall table -->

          </div>
        </div>
      </div>
  @endsection

@push('scripts')
  <script src="js/jquery.dataTables.min.js"></script> <!-- DataTables core -->
  <script src="js/dataTables.bootstrap4.min.js"></script> <!-- Estilo Bootstrap 4 para DataTables -->

  <!-- Scripts de las tablas -->
  <script>
    $(document).ready(function () {
      $('#dataTable-1').DataTable({
        autoWidth: true,
        "lengthMenu": [
          [16, 32, 64, -1],
          [16, 32, 64, "All"]
        ],
        "language": {
          "search": "Buscar:",
          "lengthMenu": "Mostrar _MENU_ entradas",
          "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
          "paginate": {
            "previous": "Anterior",
            "next": "Siguiente"
          },
          "zeroRecords": "No se encontraron resultados",
          "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
          "infoFiltered": "(filtrado de _MAX_ entradas totales)"
        }
      });
    });
  </script>
@endpush