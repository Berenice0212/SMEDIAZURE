@extends('layouts.base')

@push('styles')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <style>
      /* Colores específicos para cada tarjeta */
      .total-antenas { border-left: 6px solid #3b82f6; }     /* Azul */
      .funcionando   { border-left: 6px solid #10b981; }     /* Verde */
      .falla         { border-left: 6px solid #ef4444; }     /* Rojo */
      .panel-solar   { border-left: 6px solid #f59e0b; }     /* Naranja */

      .map-container {
          height: 450px;
          width: 100%;
          border-radius: 12px;
          overflow: hidden;
      }
  </style>
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
            <div class="row align-items-center mb-4">
              <div class="col">
                <span class="h2 page-title">Ubicación de antenas</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="container-fluid">
        <!-- Inicio de la cards de información -->
        <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="total-antenas card shadow">
                <div class="card-body">
                    <div class="row align-items-center">
                    <div class="col-3 text-center">
                        <span class="circle circle-sm bg-primary">
                        <i class="fe fe-16 fe-bar-chart text-white mb-0"></i>
                        </span>
                    </div>
                    <div class="col pr-0">
                        <p class="mb-0">Total de Antenas</p>
                        <span class="h3 mb-0">{{ $totalAntenas }}</span>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="funcionando card shadow">
                <div class="card-body">
                    <div class="row align-items-center">
                    <div class="col-3 text-center">
                        <span class="circle circle-sm bg-primary">
                        <i class="fe fe-16 fe-check text-white mb-0"></i>
                        </span>
                    </div>
                    <div class="col pr-0">
                        <p class="mb-0">Funcionando</p>
                        <span class="h3 mb-0">{{ $funcionando }}</span>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="falla card shadow">
                <div class="card-body">
                    <div class="row align-items-center">
                    <div class="col-3 text-center">
                        <span class="circle circle-sm bg-primary">
                        <i class="fe fe-16 fe-alert-triangle text-white mb-0"></i>
                        </span>
                    </div>
                    <div class="col pr-0">
                        <p class="mb-0">Fuera de servicio</p>
                        <span class="h3 mb-0">{{ $falla }}</span>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="panel-solar card shadow">
                <div class="card-body">
                    <div class="row align-items-center">
                    <div class="col-3 text-center">
                        <span class="circle circle-sm bg-primary">
                        <i class="fe fe-16 fe-sunrise text-white mb-0"></i>
                        </span>
                    </div>
                    <div class="col pr-0">
                        <p class="mb-0">Panel Solar</p>
                        <span class="h3 mb-0">{{ $panelSolar }}</span>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- Fin de las cards de información -->

        <!-- Mapa -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="card-title">Ubicación de Antenas</h5>
                <div id="map" class="map-container"></div>
            </div>
        </div>
        <!-- Fin del mapa -->
    </div>
  @endsection

@push('scripts')
  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <script>
      document.addEventListener("DOMContentLoaded", function () {
          // Inicializar mapa
          const map = L.map('map').setView([19.5, -88.5], 8);

          // Capa base
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
              maxZoom: 19,
              attribution: '© OpenStreetMap contributors'
          }).addTo(map);

          // Obtener datos de antenas
          const antenas = @json($antenas);

          // Función para iconos personalizados
          function getIconUrl(estado) {
              switch (estado) {
                  case 'funcionando':
                      return "{{ asset('img/antena_verde.jpeg') }}";
                  case 'falla':
                      return "{{ asset('img/antena_roja.jpeg') }}";
                  case 'panel_solar':
                      return "{{ asset('img/antena_amarilla.jpeg') }}";
                  default:
                      return "{{ asset('img/antena_azul.jpeg') }}";
              }
          }

          // Agregar marcadores
          antenas.forEach(antena => {
              const lat = parseFloat(antena.latitud);
              const lng = parseFloat(antena.longitud);
              if (!isNaN(lat) && !isNaN(lng)) {
                  const iconUrl = getIconUrl(antena.estado_energia?.estado_energia);
                  const customIcon = L.icon({
                      iconUrl: iconUrl,
                      iconSize: [40, 40],
                      iconAnchor: [20, 40],
                      popupAnchor: [0, -35]
                  });

                  const popupContent = `
                      <b>Antena:</b> ${antena.id_antena} <br>
                      <b>Localidad:</b> ${antena.localidad?.localidad || ''} <br>
                      <b>Municipio:</b> ${antena.municipio?.municipio || ''} <br>
                      <b>Dispositivo:</b> ${antena.dispositivo?.modelo || ''} <br>
                      <b>Estado Energía:</b> ${antena.estado_energia?.estado_energia || ''} <br>
                      <b>IP:</b> ${antena.ip}
                  `;

                  L.marker([lat, lng], { icon: customIcon })
                      .addTo(map)
                      .bindPopup(popupContent);
              }
          });
      });
  </script>
@endpush