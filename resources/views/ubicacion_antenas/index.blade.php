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
                <h2 class="h5 page-title">Listado de Localidades</h2>
              </div>
            </div>

            <div class="card shadow">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table datatables table-striped">
                    <thead>
                        <tr>
                            <th>ID Antena</th>
                            <th>Localidad</th>
                            <th>Municipio</th>
                            <th>Estado Energía</th>
                            <th>Dispositivo</th>
                            <th>IP</th>
                            <th>Latitud</th>
                            <th>Longitud</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($antenas as $antena)
                            <tr>
                            <td>{{ $antena->id_antena }}</td>
                            <td>{{ $antena->localidad->localidad ?? 'N/A' }}</td>
                            <td>{{ $antena->municipio->municipio ?? 'N/A' }}</td>
                            <td>{{ $antena->estadoEnergia->estado_energia ?? 'N/A' }}</td>
                            <td>{{ $antena->dispositivo->modelo ?? 'N/A' }}</td>
                            <td>{{ $antena->ip }}</td>
                            <td>{{ $antena->latitud }}</td>
                            <td>{{ $antena->longitud }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </main>
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
</body>
</html>
