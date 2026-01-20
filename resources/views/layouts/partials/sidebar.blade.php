<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link" href="{{ url('/dashboard') }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#vehicules-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-car-front"></i><span>Véhicules</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="vehicules-nav" class="nav-content collapse {{ Request::is('vehicules*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ url('/vehicules') }}" class="{{ Request::is('vehicules') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Liste</span>
          </a>
        </li>
        <li>
          <a href="{{ url('/vehicules/create') }}" class="{{ Request::is('vehicules/create') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Nouveau</span>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#ventes-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-cart-check"></i><span>Ventes</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="ventes-nav" class="nav-content collapse {{ Request::is('ventes*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ url('/ventes') }}" class="{{ Request::is('ventes') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Liste</span>
          </a>
        </li>
        <li>
          <a href="{{ url('/ventes/create') }}" class="{{ Request::is('ventes/create') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Nouveau</span>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#paiements-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-cash-stack"></i><span>Paiements</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="paiements-nav" class="nav-content collapse {{ Request::is('paiements*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ url('/paiements') }}" class="{{ Request::is('paiements') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Liste</span>
          </a>
        </li>
        <li>
          <a href="{{ url('/paiements/create') }}" class="{{ Request::is('paiements/create') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Nouveau</span>
          </a>
        </li>
      </ul>
    </li>



  </ul>

</aside>
