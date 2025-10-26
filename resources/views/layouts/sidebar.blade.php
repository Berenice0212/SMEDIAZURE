@php
/**
 * Devuelve 'active' si la ruta actual coincide con cualquiera de los patrones.
 * Soporta comodines: reportes.*, usuarios.*, etc.
 */
function nav_active($patterns){
    foreach ((array)$patterns as $p) {
        if (request()->routeIs($p)) return 'active';
    }
    return '';
}
@endphp
<aside class="sidebar-left border-right shadow" id="leftSidebar" data-simplebar style="background-color: #2A5C8A;">
  <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-white ml-2 mt-3" data-toggle="toggle">
    <i class="fe fe-x"><span class="sr-only"></span></i>
  </a>
  <nav class="vertnav navbar navbar-dark">
    <div class="w-100 mb-4 d-flex">
      <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ route('dashboard') }}">
        <img 
          src="{{ asset('img/login/logo_smedi.jpg') }}" 
          alt="SMEDI Logo" 
          class="navbar-brand-img brand-sm" 
          style="height: 60px; width: auto; max-width: 100%; object-fit: contain; padding: 4px;"
        >
      </a>
    </div>
    <ul class="navbar-nav flex-fill w-100 mb-2">
        <li class="nav-item">
            <a class="nav-link pl-3 text-white sidebarHover {{ nav_active(['dashboard']) }}"
            href="{{ route('dashboard') }}">
            <i class="fe fe-home fe-16"></i>
            <span class="ml-1 item-text">Dashboard</span>
            </a>
        </li>
        <!--
        <li class="nav-item">
            <a class="nav-link pl-3 text-white sidebarHover {{ nav_active(['reportes.*']) }}"
            href="{{ route('reportes.index') }}">
            <i class="fe fe-clipboard fe-16"></i>
            <span class="ml-1 item-text">Reportes</span>
            </a>
        </li>
      -->
        <li class="nav-item">
            <a class="nav-link pl-3 text-white sidebarHover {{ nav_active(['reporte-principal.*']) }}"
            href="{{ route('reporte-principal.index') }}">
            <i class="fe fe-clipboard fe-16"></i>
            <span class="ml-1 item-text">Reportes</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link pl-3 text-white sidebarHover {{ nav_active(['ubicacion_antenas.*']) }}"
            href="{{ route('ubicacion_antenas.index') }}">
            <i class="fe fe-wifi fe-16"></i>
            <span class="ml-1 item-text">Ubicacion Antenas</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link pl-3 text-white sidebarHover {{ nav_active(['municipios.*']) }}"
            href="{{ route('municipios.index') }}">
            <i class="fe fe-map-pin fe-16"></i>
            <span class="ml-1 item-text">Municipios</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link pl-3 text-white sidebarHover {{ nav_active(['localidades.*']) }}"
            href="{{ route('localidades.index') }}">
            <i class="fe fe-navigation fe-16"></i>
            <span class="ml-1 item-text">Localidades</span>
            </a>
        </li>
        <!--
        <li class="nav-item">
            <a class="nav-link pl-3 text-white sidebarHover" href="{{ route('estado-energia.index') }}">
            <i class="fe fe-battery fe-16"></i>
            <span class="ml-1 item-text">Estado de Energia</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link pl-3 text-white sidebarHover" href="{{ route('dispositivos.index') }}">
            <i class="fe fe-hard-drive fe-16"></i>
            <span class="ml-1 item-text">Dispositivos</span>
            </a>
        </li>
        -->
        <li class="nav-item">
            <a class="nav-link pl-3 text-white sidebarHover {{ nav_active(['usuarios.*']) }}"
            href="{{ route('usuarios.index') }}">
            <i class="fe fe-user fe-16"></i>
            <span class="ml-1 item-text">Usuarios</span>
            </a>
        </li>
    </ul>
  </nav>
</aside>

<style>
  #leftSidebar {
    --sidebar-blue: #2A5C8A;
    --hover-blue: #1E4A6D;
    --active-blue: #3A7BAA;
    --indicator-blue: #3F8FC5;
  }
  .sidebarHover:hover {
    background-color: var(--active-blue);
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 10px;
    box-shadow:
      inset 0 1px 2px rgba(255, 255, 255, 0.2),
      0 4px 6px rgba(0, 0, 0, 0.3);
    color: #fff;
    transition: all 0.3s ease;
  }
  #leftSidebar .nav-link {
    position: relative;
    border-radius: 8px;
  }
  #leftSidebar .nav-link.active {
    background: linear-gradient(145deg, rgba(74, 163, 216, 0.35), rgba(58, 123, 170, 0.8));
    border-radius: 10px;
    box-shadow:
      inset 0 1px 3px rgba(255, 255, 255, 0.15),
      0 2px 4px rgba(0, 0, 0, 0.25);
    color: #fff;
    }
</style>