<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">
      <!-- Left Section -->
      <div class="d-flex align-items-center">
        <!-- Toggle Sidebar -->
        <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
        <button type="button" class="btn btn-sm btn-alt-secondary me-2 d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
          <i class="fa fa-fw fa-bars"></i>
        </button>
        <!-- END Toggle Sidebar -->

        <!-- Open Search Section (visible on smaller screens) -->
        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
        <button type="button" class="btn btn-sm btn-alt-secondary d-md-none" data-toggle="layout" data-action="header_search_on">
          <i class="fa fa-fw fa-search"></i>
        </button>
        <!-- END Open Search Section -->

        <!-- Search Form (visible on larger screens) -->
        <form class="d-none d-md-inline-block" action="be_pages_generic_search.html" method="POST">
          <div class="input-group input-group-sm">
            <input type="text" class="form-control form-control-alt" placeholder="Search.." id="page-header-search-input2" name="page-header-search-input2">
            <span class="input-group-text border-0">
              <i class="fa fa-fw fa-search"></i>
            </span>
          </div>
        </form>
        <!-- END Search Form -->
      </div>
      <!-- END Left Section -->

      <!-- Right Section -->
      <div class="d-flex align-items-center">
        <!-- User Dropdown -->
        <div class="dropdown d-inline-block ms-2">
          <button type="button" class="btn btn-sm btn-alt-secondary d-flex align-items-center" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="rounded-circle" src="{{ asset('media/avatars/avatar10.jpg') }}" alt="Avatar de {{ Auth::user()->name }}" style="width: 21px;">
            <span class="d-none d-sm-inline-block ms-2">{{ Auth::user()->name }}</span>
            <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block opacity-50 ms-1 mt-1"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0" aria-labelledby="page-header-user-dropdown">
            <div class="p-3 text-center bg-body-light border-bottom rounded-top">
              <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{ asset('media/avatars/avatar10.jpg') }}" alt="">
              <p class="mt-2 mb-0 fw-medium">{{ Auth::user()->name }}</p>
              <p class="mb-0 text-muted fs-sm fw-medium">{{ Auth::user()->role ?? 'Usuario' }}</p>
            </div>
            
              
     
              <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ route('logout') }}">
                <span class="fs-sm fw-medium">Cerrar sesión</span>
              </a>
            </div>
          </div>
        </div>
        
        <!-- END User Dropdown -->

       
  </header>