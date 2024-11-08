    <h2>Configuración</h2>
    <div id="main-navigation" class="d-none d-lg-block mt-2 mt-lg-0">
        <ul class="nav-main nav-main-dark nav-main-horizontal nav-main-hover">
            @can('ver-interes')
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('intereses.index') }}">
                    <i class="nav-main-link-icon si si-wallet"></i>
                    <span class="nav-main-link-name">Interés</span>
                </a>
            </li>
            @endcan

            @can('ver-categoria_producto')
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('categoria_productos.index') }}">
                    <i class="nav-main-link-icon si si-puzzle"></i>
                    <span class="nav-main-link-name">Categoría Producto</span>
                </a>
            </li>
            @endcan

            @can('ver-tipo_documento')
            <li class="nav-main-item">
                <a class="nav-main-link" href="{{ route('tipo_documentos.index') }}">
                    <i class="nav-main-link-icon si si-wallet"></i>
                    <span class="nav-main-link-name">Tipo Documento</span>
                </a>
            </li>
            @endcan
        </ul>
    </div>
