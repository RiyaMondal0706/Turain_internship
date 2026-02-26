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
                      <a class="nxl-link" href="{{ route('candidate.dashboard') }}">
                          <span class="nxl-micon">
                              <i class="feather feather-airplay"></i>
                          </span>
                          <span class="nxl-text">Dashboard</span>
                      </a>
                  </li>
                  <li class="nxl-item nxl-hasmenu">
                      <a href="javascript:void(0);" class="nxl-link">
                          <span class="nxl-micon">
                              <i class="feather feather-clipboard"></i>
                          </span>
                          <span class="nxl-text">Project</span>
                          <span class="nxl-arrow">
                              <i class="feather feather-chevron-right"></i>
                          </span>
                      </a>

                      <!-- Sub Menu -->
                      <ul class="nxl-submenu">
                          <li class="nxl-item">
                              <a class="nxl-link" href="{{ route('candidate.project.list') }}">
                                  <span class="nxl-text">Ongoing Projects</span>
                              </a>
                          </li>

                          <li class="nxl-item">
                              <a class="nxl-link" href="{{ route('candidate.project.submitted') }}">
                                  <span class="nxl-text">Submitted Projects</span>
                              </a>
                          </li>
                      </ul>
                  </li>
          </div>
      </div>
      </div>
  </nav>
