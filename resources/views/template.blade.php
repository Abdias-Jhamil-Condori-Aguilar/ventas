<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Sistema de prestamos - @yield('title')</title>
    <meta name="description" content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave">
    <meta name="author" content="Jhamil">
    <meta name="robots" content="index, follow">
    <!-- Open Graph Meta -->
    <meta property="og:title" content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework">
    <meta property="og:site_name" content="OneUI">
    <meta property="og:description" content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">
    <!-- Stylesheets -->
    <link rel="stylesheet" id="css-main" href="{{ asset('css/oneui.min.css') }}">
    @stack('css')
</head>
@auth
<body>
    <div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
        <!-- Side Overlay-->
        <aside id="side-overlay">
            <div class="content-header border-bottom">
                <a class="img-link me-1" href="javascript:void(0)">
                    <img class="img-avatar img-avatar32" src="{{ asset('media/avatars/avatar10.jpg') }}" alt="">
                </a>
                <div class="ms-2">
                    <a class="text-dark fw-semibold fs-sm" href="javascript:void(0)">John Smith</a>
                </div>
                <a class="ms-auto btn btn-sm btn-alt-danger" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_close">
                    <i class="fa fa-fw fa-times"></i>
                </a>
            </div>
        </aside>

        <x-navigation-menu/>
        <x-navigation-header/>
        <main id="main-container">
            @yield('content')
        </main>
        <x-footer/>
    </div>

    <script src="{{ asset('js/oneui.app.min.js') }}"></script>
    <script src="{{ asset('js/plugins/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('js/pages/be_pages_dashboard.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Function to set the theme
        function setTheme(theme) {
            const themeFile = {
                'default': 'css/themes/default.min.css',
                'amethyst': 'css/themes/amethyst.min.css',
                'city': 'css/themes/city.min.css',
                'flat': 'css/themes/flat.min.css',
                'modern': 'css/themes/modern.min.css',
                'smooth': 'css/themes/smooth.min.css',
            };

            // Change the theme
            document.getElementById('css-theme').setAttribute('href', themeFile[theme]);
            // Save the theme in localStorage
            localStorage.setItem('theme', theme);
        }

        // Change theme and dark mode on page load
        window.onload = function() {
            const savedTheme = localStorage.getItem('theme') || 'default';
            setTheme(savedTheme);

            // Dark mode
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            document.body.classList.toggle('dark-mode', isDarkMode);
            document.getElementById('dark-mode-icon').className = isDarkMode ? 'far fa-sun' : 'far fa-moon';
        }

        // Toggle dark mode
        document.getElementById('dark-mode-toggle').addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            const isDarkMode = document.body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isDarkMode);
            document.getElementById('dark-mode-icon').className = isDarkMode ? 'far fa-sun' : 'far fa-moon';
        });
    </script>
    
    @stack('js')
</body>
@endauth
@guest
    @include('pages.401')
@endguest
</html>
