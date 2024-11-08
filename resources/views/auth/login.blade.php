<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <title>Iniciar Sesión &amp; UI Framework</title>

  <meta name="description" content="Iniciar Sesión en Prestamos el Amanecer">
  <meta name="author" content="Prestamos el Amanecer">
  <meta name="robots" content="index, follow">

  <!-- Open Graph Meta -->
  <meta property="og:title" content="Iniciar Sesión - Prestamos el Amanecer">
  <meta property="og:site_name" content="Prestamos el Amanecer">
  <meta property="og:description" content="Iniciar Sesión en Prestamos el Amanecer">
  <meta property="og:type" content="website">
  <meta property="og:url" content="">
  <meta property="og:image" content="">

  <!-- Icons -->
  <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('media/favicons/favicon-192x192.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

  <!-- Stylesheets -->
  <link rel="stylesheet" id="css-main" href="{{ asset('css/oneui.min.css') }}">
</head>

<body>
  <div id="page-container">
    <main id="main-container">
      <div class="hero-static d-flex align-items-center">
        <div class="w-100">
          <!-- Sign In Section -->
          <div class="bg-body-extra-light">
            <div class="content content-full">
              <div class="row g-0 justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4 py-4 px-4 px-lg-5">
                  <!-- Header -->
                  <div class="text-center">
                    <p class="mb-2">
                      <!-- Cambiar el ícono de FontAwesome a una imagen personalizada -->
                      <img src="{{ asset('images/logo.JPG') }}" alt="Logo" class="img-fluid" style="max-width: 150px;">
                    </p>
                    <h1 class="h4 mb-1">Iniciar Sesión</h1>
                    <p class="fw-medium text-muted mb-3">Bienvenido, por favor inicia sesión.</p>
                  </div>
                  <!-- END Header -->

                  <!-- SweetAlert Error -->
                  @if ($errors->any())
                    <script>
                      Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '{{ $errors->first() }}',
                      });
                    </script>
                  @endif

                  <!-- Sign In Form -->
                  <form class="js-validation-signin" action="/login" method="POST">
                    @csrf
                    <div class="py-3">
                      <div class="mb-4">
                        <input type="email" class="form-control form-control-lg form-control-alt" id="login-email" name="email" placeholder="Correo Electrónico" required>
                      </div>
                      <div class="mb-4">
                        <input type="password" class="form-control form-control-lg form-control-alt" id="login-password" name="password" placeholder="Contraseña" required>
                      </div>
                      <div class="mb-4">
                        <div class="d-md-flex align-items-md-center justify-content-md-between">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="login-remember" name="login-remember">
                            <label class="form-check-label" for="login-remember">Recuérdame</label>
                          </div>
                          <div class="py-2">
                            <a class="fs-sm fw-medium" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row justify-content-center">
                      <div class="col-lg-6 col-xxl-5">
                        <button type="submit" class="btn w-100 btn-alt-primary">
                          <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i> Iniciar Sesión
                        </button>
                      </div>
                    </div>
                  </form>
                  <!-- END Sign In Form -->
                </div>
              </div>
            </div>
          </div>
          <!-- END Sign In Section -->

          <div class="fs-sm text-center text-muted py-3">
            <strong>Prestamos el Amanecer</strong> &copy; <span data-toggle="year-copy"></span>
          </div>
          <!-- END Footer -->

          <!-- SweetAlert -->
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

          <!-- OneUI JS -->
          <script src="{{ asset('js/oneui.app.min.js') }}"></script>
          <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
          <script src="{{ asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
          <script src="{{ asset('js/pages/op_auth_signin.min.js') }}"></script>

          @if ($errors->any())
            <script>
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ $errors->first() }}',
              });
            </script>
          @endif
        </div>
      </div>
    </main>
  </div>
</body>
</html>
