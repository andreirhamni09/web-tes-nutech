

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary bg-danger elevation-4">
        <!-- Brand Logo -->
        
        <a href="{{ route('dashboard') }}" class="brand-link bg-danger border-bottom-0">
          <img
            src="{{ asset('CMS Assets/Handbag.png') }}"
            alt="AdminLTE Logo"
            class="brand-image img-circle"
            style="opacity: 0.8;"
            width="128" height="128"
          />
          <span class="brand-text font-weight-bold text-white">SIMS Web App</span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar bg-danger">
          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul
              class="nav nav-pills nav-sidebar flex-column"
              data-widget="treeview"
              role="menu"
              data-accordion="false"
            >
              <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                  <img src="{{ asset('CMS Assets/Package.png') }}" class="nav-icon mr-2"/>
                  <p class="mr-2 font-weight-bold text-white">Produk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('profile') }}" class="nav-link">
                  <img src="{{ asset('CMS Assets/User.png') }}" class="nav-icon mr-2"/>
                  <p class="mr-2 font-weight-bold text-white">Profile</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link">
                  <img src="{{ asset('CMS Assets/SignOut.png') }}" class="nav-icon mr-2"/>
                  <p class="mr-2 font-weight-bold text-white">Logout</p>
                </a>
              </li>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>