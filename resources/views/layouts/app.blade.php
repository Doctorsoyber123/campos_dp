<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'REGINDE · Registro de Inventario de la Subgerencia de Deporte')</title>
<link rel="icon" type="image/png" href="{{ asset('images/reginde_logo.png') }}">
<link rel="stylesheet" href="{{ asset('css/reginde.css') }}">
@stack('styles')
</head>
<body>

@auth
<div class="app-shell">
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
      <img src="{{ asset('images/reginde_logo.png') }}" alt="REGINDE">
      <span>REGINDE</span>
      <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-label="Abrir menú">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20"><path d="M3 6h18"/><path d="M3 12h18"/><path d="M3 18h18"/></svg>
      </button>
    </div>
    <nav class="sidebar-nav">
      <a href="{{ route('reginde.panel') }}" class="{{ request()->routeIs('reginde.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
        Panel principal
      </a>
      {{-- Próximas secciones se agregan aquí --}}
    </nav>
    <div class="sidebar-footer">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout-corner">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="15" height="15"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
          Cerrar sesión
        </button>
      </form>
    </div>
  </aside>
  <main class="app-main">
    <div class="wrap">
        @yield('content')
    </div>
  </main>
</div>
@else
<div class="wrap">
    @yield('content')
</div>
@endauth

<script src="{{ asset('js/reginde-ui.js') }}"></script>
<script>
  const sidebarToggle = document.getElementById('sidebarToggle');
  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', () => {
      document.getElementById('sidebar').classList.toggle('open');
    });
  }
</script>
@stack('scripts')
</body>
</html>
