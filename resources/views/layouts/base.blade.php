<!DOCTYPE html>
<html lang="es">
  <head>
    @include('layouts.head')
    @stack('styles')
  </head>
  <body class="vertical light @hasSection('sidebar') has-sidebar @else no-sidebar @endif">
    <div class="wrapper">
      
      {{-- Navbar (opcional) --}}
      @hasSection('navbar')
        @yield('navbar')
      @endif

      {{-- Sidebar (opcional) --}}
      @hasSection('sidebar')
        @yield('sidebar')
      @endif

      {{-- Contenido principal --}}
      <main role="main" class="main-content">
        @yield('content')
      </main>

    </div>

    @include('layouts.scripts')
    @stack('scripts')
  </body>
</html>
