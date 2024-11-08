<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="content-header">
   
        <p class="mb-2">
          <!-- Cambiar el ícono de FontAwesome a una imagen personalizada -->
          <img src="{{ asset('images/PA.JPG') }}" alt="Logo" class="img-fluid" style="max-width: 80px;">
        </p>
      
      <!-- END Logo -->

      <!-- Extra -->
      <div>
        <!-- Dark Mode -->
        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
        <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="layout" data-action="dark_mode_toggle">
          <i class="far fa-moon"></i>
        </button>
        <!-- END Dark Mode -->

        <!-- Options -->
        <div class="dropdown d-inline-block ms-1">
          <button type="button" class="btn btn-sm btn-alt-secondary" id="sidebar-themes-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-brush"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end fs-sm smini-hide border-0" aria-labelledby="sidebar-themes-dropdown">
            <!-- Color Themes -->
            <!-- Layout API, functionality initialized in Template._uiHandleTheme() -->
            <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="default" href="#">
              <span>Default</span>
              <i class="fa fa-circle text-default"></i>
            </a>
            <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="{{ asset('css/themes/amethyst.min.css') }}" href="#">
              <span>Amethyst</span>
              <i class="fa fa-circle text-amethyst"></i>
            </a>
            <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="{{ asset('css/themes/city.min.css') }}" href="#">
              <span>City</span>
              <i class="fa fa-circle text-city"></i>
            </a>
            <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="{{ asset('css/themes/flat.min.css') }}" href="#">
              <span>Flat</span>
              <i class="fa fa-circle text-flat"></i>
            </a>
            <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="{{ asset('css/themes/modern.min.css') }}" href="#">
              <span>Modern</span>
              <i class="fa fa-circle text-modern"></i>
            </a>
            <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="{{ asset('css/themes/smooth.min.css') }}" href="#">
              <span>Smooth</span>
              <i class="fa fa-circle text-smooth"></i>
            </a>
            <!-- END Color Themes -->

            <div class="dropdown-divider"></div>

            <!-- Sidebar Styles -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <a class="dropdown-item fw-medium" data-toggle="layout" data-action="sidebar_style_light" href="javascript:void(0)">
              <span>Sidebar Light</span>
            </a>
            <a class="dropdown-item fw-medium" data-toggle="layout" data-action="sidebar_style_dark" href="javascript:void(0)">
              <span>Sidebar Dark</span>
            </a>
            <!-- END Sidebar Styles -->

            <div class="dropdown-divider"></div>

            <!-- Header Styles -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <a class="dropdown-item fw-medium" data-toggle="layout" data-action="header_style_light" href="javascript:void(0)">
              <span>Header Light</span>
            </a>
            <a class="dropdown-item fw-medium" data-toggle="layout" data-action="header_style_dark" href="javascript:void(0)">
              <span>Header Dark</span>
            </a>
            <!-- END Header Styles -->
          </div>
        </div>
        <!-- END Options -->

        <!-- Close Sidebar, Visible only on mobile screens -->
        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
        <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
          <i class="fa fa-fw fa-times"></i>
        </a>
        <!-- END Close Sidebar -->
      </div>
      <!-- END Extra -->
    </div>
    <!-- END Side Header -->

   <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
    <!-- Side Navigation -->
         <div class="content-side">
            <ul class="nav-main">
               <li class="nav-main-item">
                <a class="nav-main-link active" href="{{ route('panel') }}">
                    <i class="nav-main-link-icon si si-speedometer"></i>
                    <span class="nav-main-link-name">Panel</span>
                </a>
            </li>
            
            <li class="nav-main-heading">MÓDULOS</li>
            
            @can('ver-cliente')
            <!-- Clientes -->
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('clientes.index') }}">
                    <i class="nav-main-link-icon si si-user"></i>
                    <span class="nav-main-link-name">Clientes</span>
                </a>
            </li>
            @endcan
            
            @can('ver-prestamo')
            <!-- Préstamos -->
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('prestamos.index') }}">
                    <i class="nav-main-link-icon si si-wallet"></i>
                    <span class="nav-main-link-name">Préstamos</span>
                </a>
            </li>
            @endcan

            @can('ver-prenda')
            <!-- Prendas -->
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('prendas.index') }}">
                    <i class="nav-main-link-icon si si-tag"></i>
                    <span class="nav-main-link-name">Prendas</span>
                </a>
            </li>
            @endcan
          <!-- Prendas -->
          <li class="nav-main-item">
            <a class="nav-main-link" href="{{ route('pagos.index') }}">
                <i class="nav-main-link-icon si si-tag"></i>
                <span class="nav-main-link-name">Pagos</span>
            </a>
        </li>
          

         
            <!-- Reportes -->
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('reportes.index') }}">
                    <i class="nav-main-link-icon si si-chart"></i>
                    <span class="nav-main-link-name">Reportes</span>
                </a>
            </li>
         
               <!-- Example additional item -->
               <li class="nav-main-heading">OTROS</li>
               <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('intereses.index') }}">
                    <i class="nav-main-link-icon si si-settings"></i>
                    <span class="nav-main-link-name">Configuración</span>
                </a>
            </li>
            

               @can('ver-user')
                   <!-- Usuarios -->
                <li class="nav-main-item">
                 <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                     <i class="nav-main-link-icon si si-people"></i>
                     <span class="nav-main-link-name">Usuarios</span>
                 </a>
                 <ul class="nav-main-submenu">
                     <li class="nav-main-item">
                         <a class="nav-main-link" href="{{ route('users.create') }}">
                             <span class="nav-main-link-name">Agregar Usuario</span>
                         </a>
                     </li>
                     <li class="nav-main-item">
                         <a class="nav-main-link" href="{{ route('users.index') }}">
                             <span class="nav-main-link-name">Lista de Usuarios</span>
                         </a>
                     </li>
                 </ul>
             </li>
               @endcan
                
              <!-- Roles -->
              @can('ver-role')
                <li class="nav-main-item">
                 <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                     <i class="nav-main-link-icon si si-people"></i>
                     <span class="nav-main-link-name">Roles</span>
                 </a>
                 <ul class="nav-main-submenu">
                     <li class="nav-main-item">
                         <a class="nav-main-link" href="{{ route('roles.create') }}">
                             <span class="nav-main-link-name">Agregar Rol</span>
                         </a>
                     </li>
                     <li class="nav-main-item">
                         <a class="nav-main-link" href="{{ route('roles.index') }}">
                             <span class="nav-main-link-name">Lista de Roles</span>
                         </a>
                     </li>
                 </ul>
             </li>   
              @endcan
            </ul>
      </div>
</div>

    <!-- END Sidebar Scrolling -->
  </nav>
 