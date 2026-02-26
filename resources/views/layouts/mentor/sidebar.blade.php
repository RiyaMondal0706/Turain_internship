  <nav class="nxl-navigation">
      <div class="navbar-wrapper">
          <div class="m-header">
              <a href="index.html" class="b-brand">
                  <img src="{{ asset('assets/images/logo.jpg') }}" alt="Logo" class="logo logo-lg"
                      style="height: 70px; width: 70px;">

              </a>
          </div>
          <div class="navbar-content">
              <ul class="nxl-navbar">
                  <li class="nxl-item nxl-caption">
                      <label>Navigation</label>
                  </li>
                  <li class="nxl-item nxl-hasmenu">
                      <a class="nxl-link" href="{{ route('mentor.dashboard') }}">
                          <span class="nxl-micon">
                              <i class="feather feather-airplay"></i>
                          </span>
                          <span class="nxl-text">Dashboard</span>
                      </a>
                  </li>
                  <li class="nxl-item">
                      <a class="nxl-link" href="{{ route('mentor.intern.list') }}">
                          <span class="nxl-micon">
                              <i class="feather feather-users"></i>
                          </span>
                          <span class="nxl-text">Candidate List</span>
                      </a>
                  </li>
          </div>
      </div>
      </div>
  </nav>
