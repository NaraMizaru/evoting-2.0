<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa-regular fa-bars"></i>
  </button>

  <h5 class="text-primary d-none d-md-block">E-Voting | SMK Negeri 2 Sukabumi</h5>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
          <span class="badge badge-danger badge-counter">10+</span>
      </a>
      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
          <h6 class="dropdown-header">
              Alerts Center
          </h6>
          <a class="dropdown-item d-flex align-items-center" href="#">
              <div class="mr-3">
                  <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                  </div>
              </div>
              <div>
                  <div class="small text-gray-500">December 12, 2019</div>
                  <span class="font-weight-bold">M1zaru telah voting</span>
              </div>
          </a>
      </div>
    </li>
    <div class="topbar-divider d-none d-sm-block"></div>
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">NaraMizaru</span>
          <img src="{{ asset('assets/img/avatar-1.png') }}" class="img-profile rounded-circle font-weight-bold"></img>
      </a>
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="">
              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
              Profile
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
          </a>
      </div>
  </li>
  </ul>
</nav>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{ __('Ready to Leave?') }}</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
              </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
              <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
              <form action="">
                <button class="btn btn-danger">Logout</button>
              </form>
          </div>
      </div>
  </div>
</div>