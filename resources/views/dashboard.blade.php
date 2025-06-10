@extends('layouts.base')

@push('styles')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
      .dashboard-container {
          padding: 1.5rem;
          max-width: 100%;
          margin: 0 auto;
      }
      .dashboard-title {
          font-size: 1.75rem;
          font-weight: 700;
          color: #1e293b;
          display: flex;
          align-items: center;
          gap: 0.75rem;
          margin-bottom: 1rem;
      }
      .stats-container {
          display: grid;
          grid-template-columns: repeat(4, 1fr);
          gap: 1.25rem;
          margin-bottom: 2rem;
      }

      @media (max-width: 1024px) {
          .stats-container {
              grid-template-columns: repeat(2, 1fr);
          }
      }

      @media (max-width: 640px) {
          .stats-container {
              grid-template-columns: 1fr;
          }
      }

      .stat-card {
          background-color: #fff;
          border-radius: 12px;
          padding: 1.25rem;
          box-shadow: 0 4px 6px rgba(0,0,0,0.1);
          display: flex;
          flex-direction: column;
          gap: 0.5rem;
          border-left: 6px solid transparent;
          transition: all 0.3s ease;
      }

      /* Colores específicos para cada tarjeta */
      .total-antenas { border-left-color: #3b82f6; }     /* Azul */
      .funcionando   { border-left-color: #10b981; }     /* Verde */
      .falla         { border-left-color: #ef4444; }     /* Rojo */
      .panel-solar   { border-left-color: #f59e0b; }     /* Naranja */

      .stat-card h5 {
          font-weight: 600;
          color: #334155;
          font-size: 0.95rem;
          display: flex;
          align-items: center;
          gap: 0.5rem;
      }

      .stat-card p {
          font-size: 1.75rem;
          font-weight: bold;
          color: #1f2937;
          margin: 0;
      }

      .map-container {
          height: 600px;
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

      <div class="container-fluid">
          <div class="dashboard-container">
              <div class="dashboard-title">
                  <i class="fas fa-tachometer-alt"></i>
                  <span class="h2 page-title">Dashboard de Antenas</span>
              </div>

              <!-- Estadísticas -->
              <div class="stats-container">
                  <div class="stat-card total-antenas">
                      <h5><i class="fas fa-signal"></i> Total de Antenas</h5>
                      <p>{{ $totalAntenas }}</p>
                  </div>
                  <div class="stat-card funcionando">
                      <h5><i class="fas fa-check-circle"></i> Funcionando</h5>
                      <p>{{ $funcionando }}</p>
                  </div>
                  <div class="stat-card falla">
                      <h5><i class="fas fa-exclamation-triangle"></i> Con Falla</h5>
                      <p>{{ $falla }}</p>
                  </div>
                  <div class="stat-card panel-solar">
                      <h5><i class="fas fa-solar-panel"></i> Panel Solar</h5>
                      <p>{{ $panelSolar }}</p>
                  </div>
              </div>

              <!-- Mapa -->
              <div class="card shadow mb-4">
                  <div class="card-body">
                      <h5 class="card-title">Ubicación de Antenas</h5>
                      <div id="map" class="map-container"></div>
                  </div>
              </div>
          </div>
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
                      <strong>Antena:</strong> ${antena.id_antena} <br>
                      <strong>Localidad:</strong> ${antena.localidad?.localidad || ''} <br>
                      <strong>Municipio:</strong> ${antena.municipio?.municipio || ''} <br>
                      <strong>Dispositivo:</strong> ${antena.dispositivo?.modelo || ''} <br>
                      <strong>Estado Energía:</strong> ${antena.estado_energia?.estado_energia || ''} <br>
                      <strong>IP:</strong> ${antena.ip}
                  `;

                  L.marker([lat, lng], { icon: customIcon })
                      .addTo(map)
                      .bindPopup(popupContent);
              }
          });
      });
  </script>
@endpush