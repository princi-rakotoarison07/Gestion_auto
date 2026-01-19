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
      <ul id="vehicules-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ url('/vehicules') }}">
            <i class="bi bi-circle"></i><span>Liste</span>
          </a>
        </li>
        <li>
          <a href="{{ url('/vehicules/create') }}">
            <i class="bi bi-circle"></i><span>Nouveau</span>
          </a>
        </li>
      </ul>
    </li>



  </ul>

</aside>
