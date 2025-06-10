<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="{{ asset('assets/favicon.ico') }}">
  <title>SMEDI</title>

  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="{{ asset('css/simplebar.css') }}">
  
  <!-- Fonts CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  
  <!-- Icons CSS -->
  <link rel="stylesheet" href="{{ asset('css/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
  <link rel="stylesheet" href="{{ asset('css/uppy.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jquery.steps.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jquery.timepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('css/quill.snow.css') }}">
  
  <!-- Date Range Picker CSS -->
  <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
  
  <!-- App CSS -->
  <link rel="stylesheet" href="{{ asset('css/app-light.css') }}" id="lightTheme">
  <link rel="stylesheet" href="{{ asset('css/app-dark.css') }}" id="darkTheme" disabled>

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
</head>

<body class="vertical light">
  <div class="wrapper">

    {{-- Navbar superior --}}
    @include('layouts.navbar')

    {{-- Sidebar lateral --}}
    @include('layouts.sidebar')

    {{-- Contenido principal --}}
    <main role="main" class="main-content">
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

    </main> <!-- main -->
  </div> <!-- .wrapper -->

  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/popper.min.js') }}"></script>
  <script src="{{ asset('js/moment.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/simplebar.min.js') }}"></script>
  <script src="{{ asset('js/daterangepicker.js') }}"></script>
  <script src="{{ asset('js/jquery.stickOnScroll.js') }}"></script>
  <script src="{{ asset('js/tinycolor-min.js') }}"></script>
  <script src="{{ asset('js/config.js') }}"></script>
  <script src="{{ asset('js/d3.min.js') }}"></script>
  <script src="{{ asset('js/topojson.min.js') }}"></script>
  <script src="{{ asset('js/datamaps.all.min.js') }}"></script>
  <script src="{{ asset('js/datamaps-zoomto.js') }}"></script>
  <script src="{{ asset('js/datamaps.custom.js') }}"></script>
  <script src="{{ asset('js/Chart.min.js') }}"></script>
  <script>
    /* defind global options */
    Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
    Chart.defaults.global.defaultFontColor = colors.mutedColor;
  </script>
  <script src="{{ asset('js/gauge.min.js') }}"></script>
  <script src="{{ asset('js/jquery.sparkline.min.js') }}"></script>
  <script src="{{ asset('js/apexcharts.min.js') }}"></script>
  <script src="{{ asset('js/apexcharts.custom.js') }}"></script>
  <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
  <script src="{{ asset('js/select2.min.js') }}"></script>
  <script src="{{ asset('js/jquery.steps.min.js') }}"></script>
  <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('js/jquery.timepicker.js') }}"></script>
  <script src="{{ asset('js/dropzone.min.js') }}"></script>
  <script src="{{ asset('js/uppy.min.js') }}"></script>
  <script src="{{ asset('js/quill.min.js') }}"></script>
  <script src="{{ asset('js/apps.js') }}"></script>

  <!-- Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', 'UA-56159088-1');
  </script>

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
</body>
</html>
