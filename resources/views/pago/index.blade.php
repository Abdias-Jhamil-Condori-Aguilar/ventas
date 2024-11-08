@extends('layouts.app')

@section('title', 'Pagos')

@push('css')
<!-- CSS para DataTables y SweetAlert -->
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-1">Pagos</h1>
                <h2 class="fs-base lh-base fw-medium text-muted mb-0">Listado de Pagos</h2>
            </div>
        </div>
    </div>

    <div class="content content-full">
        <input type="text" id="search" placeholder="Buscar pago..." class="form-control mb-3">

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Listado de Pagos</h3>
            </div>
            <div class="block-content block-content-full overflow-x-auto">
                <table id="pagosTable" class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Préstamo</th>
                            <th>Prenda</th>
                            <th>Monto Pagado</th>
                            <th>Fecha de Pago</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pagos as $pago)
    <tr>
        <td>{{ $pago->prestamo->id }}</td>
        <td>{{ $pago->prestamo->prenda->descripcion }}</td>
        <td>{{ $pago->monto_pagado }}</td>
        <td>{{ $pago->fecha_pago }}</td>
        <td>{{ $pago->user_id }}</td> <!-- Aquí se muestra el nombre del usuario -->

    </tr>
@endforeach

                    </tbody>
                </table>

                <!-- Paginación -->
                <nav aria-label="Page navigation">
                    {{ $pagos->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const pagoRows = document.querySelectorAll('.pago-row');

        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.toLowerCase();

            pagoRows.forEach(row => {
                const rowData = row.textContent.toLowerCase();
                row.style.display = rowData.includes(searchTerm) ? 'table-row' : 'none';
            });
        });
    });

    $(document).ready(function() {
        $('#pagosTable').DataTable({
            paging: false,
            info: false,
            searching: false,
            ordering: true
        });
    });
</script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
@endpush
