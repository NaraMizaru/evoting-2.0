<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fa-regular fa-fw fa-envelope"></i>
    </div>
    <div class="sidebar-brand-text mx-3">E-Voting <sup>2.0</sup></div>
  </a>

  <hr class="sidebar-divider my-0">

  <li class="nav-item {{ $menu_type == 'dashboard' ? 'active' : '' }}">
    <a href="" class="nav-link">
      <i class="fa-regular fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <hr class="sidebar-divider">
  <div class="sidebar-heading">Manage</div>

  <li class="nav-item {{ $menu_type == 'manage-user' ? 'active' : '' }}">
    <a href="" class="nav-link">
      <i class="fa-regular fa-fw fa-users"></i>
      <span>Manage User</span>
    </a>
  </li>
  <li class="nav-item {{ $menu_type == 'manage-pemilu' ? 'active' : '' }}">
    <a href="" class="nav-link">
      <i class="fa-regular fa-fw fa-check-to-slot"></i>
      <span>Manage Pemilu</span>
    </a>
  </li>
  <li class="nav-item {{ $menu_type == 'vote-logs' ? 'active' : '' }}">
    <a href="" class="nav-link">
      <i class="fa-regular fa-fw fa-clock-rotate-left"></i>
      <span>Vote Logs</span>
    </a>
  </li>

  <hr class="sidebar-divider d-none d-md-block">

  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>