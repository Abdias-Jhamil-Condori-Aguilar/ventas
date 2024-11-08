<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Préstamos El Amanecer - Restablecer Contraseña</title>
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
          <div class="bg-body-extra-light">
            <div class="content content-full">
              <div class="row g-0 justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4 py-4 px-4 px-lg-5">
                  <div class="text-center">
                    <p class="mb-2">
                        <!-- Cambiar el ícono de FontAwesome a una imagen personalizada -->
                        <img src="{{ asset('images/logo.JPG') }}" alt="Logo" class="img-fluid" style="max-width: 150px;">
                      </p>
                    <h1 class="h4 mb-1">Restablecer Contraseña</h1>
                    <p class="fw-medium text-muted mb-3">
                      Ingresa la nueva contraseña para tu cuenta.
                    </p>
                  </div>
                  <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="mb-4">
                      <label for="email" class="form-label">Correo Electrónico</label>
                      <input type="email" class="form-control form-control-lg form-control-alt" id="email" name="email" value="{{ $email ?? old('email') }}" required>
                      @error('email')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="mb-4">
                      <label for="password" class="form-label">Nueva Contraseña</label>
                      <input type="password" class="form-control form-control-lg form-control-alt" id="password" name="password" required>
                      @error('password')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="mb-4">
                      <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                      <input type="password" class="form-control form-control-lg form-control-alt" id="password-confirm" name="password_confirmation" required>
                    </div>
                    <div class="row justify-content-center mb-4">
                      <div class="col-lg-6 col-xxl-5">
                        <button type="submit" class="btn w-100 btn-primary">
                          <i class="fa fa-fw fa-lock me-1"></i> Restablecer Contraseña
                        </button>
                      </div>
                    </div>
                  </form>
                  <div class="text-center">
                    <a class="fs-sm fw-medium" href="/login">¿Iniciar sesión?</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="fs-sm text-center text-muted py-3">
            <strong>Préstamos El Amanecer</strong> &copy; <span data-toggle="year-copy"></span>
          </div>
        </div>
      </div>
    </main>
  </div>
  <script src="assets/js/oneui.app.min.js"></script>
</body>
</html>
