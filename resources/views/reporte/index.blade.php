@extends('layouts.app')

@section('title', 'Reportes')

@push('css')
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .block {
        padding: 10px;
        font-size: 12px;
    }

    .block-content {
        padding: 10px 15px;
    }

    .block h4 {
        font-size: 14px;
        margin-bottom: 5px;
    }

    .icon-style {
        font-size: 18px;
        margin-bottom: 5px;
    }

    .col-lg-3 {
        max-width: 20%;
    }

    .h1, .h2 {
        font-size: 16px;
    }

    .section-title {
        font-size: 14px;
        margin-bottom: 10px;
    }
</style>
@endpush

@section('content')
@include('layouts.partials.alert')

<!-- Main Container -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-1">Reportes</h1>
                <h2 class="fs-base lh-base fw-medium text-muted mb-0">Gestión de Reportes</h2>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('panel') }}">Inicio</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Reportes</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Reportes -->
    <div class="content content-full">
        <h4 class="section-title">Caja</h4>
        <div class="row">
            <div class="col-lg-3">
                <a class="block block-rounded block-link-pop overflow-hidden" href="{{ route('reporte.montoPrestado') }}">
                    <div class="block-content">
                        <i class="fas fa-exchange-alt icon-style"></i>
                        <h4 class="mb-1">Monto Prestado</h4>
                    </div>
                </a>
            </div>

            <div class="col-lg-3">
                <a class="block block-rounded block-link-pop overflow-hidden" href="{{ route('reporte.montoPagado') }}">
                    <div class="block-content">
                        <i class="fas fa-book icon-style"></i>
                        <h4 class="mb-1">Reporte Pagos</h4>
                    </div>
                </a>
            </div>

            <div class="col-lg-3">
                <a class="block block-rounded block-link-pop overflow-hidden" href="{{ route('reporte.flujocaja') }}">
                    <div class="block-content">
                        <i class="fas fa-arrow-right icon-style"></i>
                        <h4 class="mb-1">Reporte Caja</h4>
                    </div>
                </a>
            </div>
        </div>

        <!-- Sección Clientes -->
        <h4 class="section-title">Clientes</h4>
        <div class="row">
            <div class="col-lg-3">
                <a class="block block-rounded block-link-pop overflow-hidden" href="{{ route('reporte.clientes') }}">
                    <div class="block-content">
                        <i class="fas fa-sort-alpha-down icon-style"></i>
                        <h4 class="mb-1">Por Orden Alfabético</h4>
                    </div>
                </a>
            </div>
        </div>

        <!-- Sección Préstamos -->
        <h4 class="section-title">Préstamos</h4>
        <div class="row">
            <div class="col-lg-3">
                <a class="block block-rounded block-link-pop overflow-hidden" href="{{ route('prestamos.reporte') }}">
                    <div class="block-content">
                        <i class="fas fa-check icon-style"></i>
                        <h4 class="mb-1">Estado de Préstamos</h4>
                    </div>
                </a>
            </div>

            <div class="col-lg-3">
                <a class="block block-rounded block-link-pop overflow-hidden" href="{{ route('prestamos.por_vencer') }}">
                    <div class="block-content">
                        <i class="fas fa-calendar-alt icon-style"></i>
                        <h4 class="mb-1">Préstamos por Vencer</h4>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
// Aquí podrías agregar scripts adicionales según sea necesario.
</script>
@endpush
