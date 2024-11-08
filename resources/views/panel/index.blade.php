@extends('template')

@section('title', 'Panel')

@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
    <!-- Main Container -->
        <!-- Hero -->
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                    <div class="flex-grow-1">
                        <h1 class="h3 fw-bold mb-1">Panel de Control</h1>
                        <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                            Resumen de información importante.
                        </h2>
                    </div>
                    <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">
                                <a class="link-fx" href="javascript:void(0)">Inicio</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Panel</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content">
            <!-- Ratio 16:9 -->
            <h2 class="content-heading">Datos del Sistema</h2>
            <div class="row push">
                <div class="col-6 col-md-4 col-xxl-2">
                    <a class="block block-rounded block-link-pop text-center" href="javascript:void(0)">
                        <div class="block-content block-content-full ratio ratio-16x9">
                            <div class="d-flex justify-content-center align-items-center">
                                <div>
                                    <div class="fs-2 fw-bold text-body-color-dark">{{ $clientes->count() }}</div>
                                    <div class="fs-sm fw-semibold mt-1 text-uppercase text-muted">Clientes</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-xxl-2">
                    <a class="block block-rounded block-link-pop text-center" href="javascript:void(0)">
                        <div class="block-content block-content-full ratio ratio-16x9">
                            <div class="d-flex justify-content-center align-items-center">
                                <div>
                                    <div class="fs-2 fw-bold text-body-color-dark">{{ $prendas->count() }}</div>
                                    <div class="fs-sm fw-semibold mt-1 text-uppercase text-muted">Prendas</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-xxl-2">
                    <a class="block block-rounded text-center bg-modern" href="javascript:void(0)">
                        <div class="block-content block-content-full ratio ratio-16x9">
                            <div class="d-flex justify-content-center align-items-center">
                                <div>
                                    <div class="fs-2 fw-bold text-modern-lighter">{{ $prestamos->count() }}</div>
                                    <div class="fs-sm fw-semibold mt-1 text-uppercase text-white-75">Préstamos</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-xxl-2">
                    <a class="block block-rounded text-center bg-primary" href="javascript:void(0)">
                        <div class="block-content block-content-full ratio ratio-16x9">
                            <div class="d-flex justify-content-center align-items-center">
                                <div>
                                    <div class="fs-2 fw-bold text-white">{{ $usuarios->count() }}</div>
                                    <div class="fs-sm fw-semibold mt-1 text-uppercase text-white-75">Usuarios</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-xxl-2">
                    <a class="block block-rounded text-center bg-image" style="background-image: url('assets/media/photos/photo14.jpg');" href="javascript:void(0)">
                        <div class="block-content block-content-full bg-amethyst-op ratio ratio-16x9">
                            <div class="d-flex justify-content-center align-items-center">
                                <div>
                                    <i class="far fa-2x fa-bookmark text-white"></i>
                                    <div class="fs-sm fw-semibold mt-3 text-uppercase text-white">Categorías</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-xxl-2">
                    <a class="block block-rounded text-center bg-image" style="background-image: url('assets/media/photos/photo14.jpg');" href="javascript:void(0)">
                        <div class="block-content block-content-full bg-modern-op ratio ratio-16x9">
                            <div class="d-flex justify-content-center align-items-center">
                                <div>
                                    <i class="far fa-2x fa-chart-bar text-white"></i>
                                    <div class="fs-sm fw-semibold mt-3 text-uppercase text-white">Tipos de Documentos</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->

    @if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let message = "{{ session('success') }}";
            Swal.fire(message);
        });
    </script>
    @endif
@endsection

@push('js')
@endpush
