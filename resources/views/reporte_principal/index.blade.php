@extends('layouts.base')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}">
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
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h2 class="h5 page-title mb-0">Listado de Reportes (Nuevo módulo)</h2>
        <a href="{{ route('reporte-principal.create') }}" class="btn btn-primary mb-2">+ Nuevo Reporte</a>
      </div>

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

      <div class="col-md-12">
        <div class="card shadow">
          <div class="card-body">
            <div id="dataTable-1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
              <div class="row">
                <div class="col-sm-12">
                  <table class="table datatables dataTable no-footer" id="dataTable-1">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Técnico</th> 
                        <th>IP Antena</th>
                        <th>Localidad</th>
                        <th>Municipio</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($reportes as $reporte)
                        <tr>
                          <td>{{ $reporte->id }}</td>
                          <td>{{ $reporte->tecnico->name ?? '—' }}</td>
                          <td>{{ $reporte->ip_antena }}</td>
                          <td>{{ $reporte->antena?->localidad?->localidad ?? '—' }}</td>
                          <td>{{ $reporte->antena?->municipio?->municipio ?? '—' }}</td>
                          <td>
                            @php
                              $badge = $reporte->estado === 'pendiente' ? 'warning' :
                                       ($reporte->estado === 'en_proceso' ? 'info' : 'success');
                            @endphp
                            <span class="p-2 badge badge-{{ $badge }}">
                              {{ ucfirst($reporte->estado) }}
                            </span>
                          </td>
                          <td class="d-flex gap-1">
                            <a href="{{ route('reporte-principal.show', $reporte->id) }}"
                               class="btn btn-sm btn-outline-info mr-1">Ver reporte</a>
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="6" class="text-center">No hay reportes disponibles.</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div> <!-- wrapper -->
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
  <script>
    $(document).ready(function () {
      $('#dataTable-1').DataTable({
        autoWidth: true,
        order: [[0, 'desc']],
        lengthMenu: [[16, 32, 64, -1], [16, 32, 64, "Todos"]],
        language: {
          search: "Buscar:",
          lengthMenu: "Mostrar _MENU_ entradas",
          info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
          paginate: { previous: "Anterior", next: "Siguiente" },
          zeroRecords: "No se encontraron resultados",
          infoEmpty: "Mostrando 0 a 0 de 0 entradas",
          infoFiltered: "(filtrado de _MAX_ entradas totales)"
        }
      });
    });
  </script>
@endpush
