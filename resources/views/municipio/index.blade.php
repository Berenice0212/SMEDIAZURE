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
                <h2 class="h5 page-title">Welcome!</h2>
              </div>
              <div class="col-auto">
                <form class="form-inline">
                  <div class="form-group d-none d-lg-inline">
                    <label for="reportrange" class="sr-only">Date Ranges</label>
                    <div id="reportrange" class="px-2 py-2 text-muted">
                      <span class="small"></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="button" class="btn btn-sm"><span class="fe fe-refresh-ccw fe-16 text-muted"></span></button>
                    <button type="button" class="btn btn-sm mr-2"><span class="fe fe-filter fe-16 text-muted"></span></button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

        <div class="card-body">
            <!-- table -->
            <div id="dataTable-1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="dataTable-1_length"><label><font _mstmutation="1" _msttexthash="97786" _msthash="83">Mostrar </font><select name="dataTable-1_length" aria-controls="dataTable-1" class="custom-select custom-select-sm form-control form-control-sm"><option value="16" _msttexthash="10075" _msthash="84">16</option><option value="32" _msttexthash="9841" _msthash="85">32</option><option value="64" _msttexthash="10322" _msthash="86">64</option><option value="-1" _msttexthash="29783" _msthash="87">Todo</option></select><font _mstmutation="1" _msttexthash="112905" _msthash="88"> Entradas</font></label></div></div><div class="col-sm-12 col-md-6"><div id="dataTable-1_filter" class="dataTables_filter"><label><font _mstmutation="1" _msttexthash="85956" _msthash="89">Buscar:</font><input type="search" class="form-control form-control-sm" placeholder="" aria-controls="dataTable-1"></label></div></div></div><div class="row"><div class="col-sm-12"><table class="table datatables dataTable no-footer" id="dataTable-1" role="grid" aria-describedby="dataTable-1_info">
            <thead>
                <tr role="row">
                    <th class="sorting" tabindex="0" aria-controls="dataTable-1" rowspan="1" colspan="1" aria-label="#: activar para ordenar la columna ascendente" _mstaria-label="941499" _msthash="91" style="width: 9.5625px;">#</th>
                    <th class="sorting" tabindex="0" aria-controls="dataTable-1" rowspan="1" colspan="1" aria-label="Nombre: activar para ordenar la columna de forma ascendente" _mstaria-label="1105559" _msthash="92" _msttexthash="76193" style="width: 69.5469px;">Nombre Municipio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($municipios as $municipio)
                <tr role="row" class="odd">
                    <td>{{ $municipio->id_municipio }}</td>
                    <td>{{ $municipio->municipio }}</td>
                </tr>
            @endforeach
            </tbody>
            </table></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="dataTable-1_info" role="status" aria-live="polite" _msttexthash="750360" _msthash="292">Mostrando del 1 al 16 de 63 entradas</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="dataTable-1_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="dataTable-1_previous"><a href="#" aria-controls="dataTable-1" data-dt-idx="0" tabindex="0" class="page-link" _msttexthash="116246" _msthash="293">Anterior</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="dataTable-1" data-dt-idx="1" tabindex="0" class="page-link" _msttexthash="4459" _msthash="294">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="dataTable-1" data-dt-idx="2" tabindex="0" class="page-link" _msttexthash="4550" _msthash="295">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="dataTable-1" data-dt-idx="3" tabindex="0" class="page-link" _msttexthash="4641" _msthash="296">3</a></li><li class="paginate_button page-item "><a href="#" aria-controls="dataTable-1" data-dt-idx="4" tabindex="0" class="page-link" _msttexthash="4732" _msthash="297">4</a></li><li class="paginate_button page-item next" id="dataTable-1_next"><a href="#" aria-controls="dataTable-1" data-dt-idx="5" tabindex="0" class="page-link" _msttexthash="113945" _msthash="298">Próximo</a></li></ul></div></div></div></div>
        </div>
  @endsection
