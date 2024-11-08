@extends('layouts.app')

@section('title', 'Prendas')

@push('css')
<!-- CSS para DataTables y SweetAlert -->
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
@include('layouts.partials.alert')

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-1">Prendas</h1>
                <h2 class="fs-base lh-base fw-medium text-muted mb-0">Listado de Prendas</h2>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('panel') }}">Inicio</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Prendas</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="content content-full">
        <input type="text" id="search" placeholder="Buscar prenda..." class="form-control mb-3">

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Listado de Prendas</h3>
            </div>
            <div class="block-content block-content-full overflow-x-auto">
                <table id="prendasTable" class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prendas as $prenda)
                        <tr class="prenda-row">
                            <td>{{ $prenda->codigo }}</td>
                            <td>{{ $prenda->descripcion }}</td>
                            <td>{{ $prenda->categoriaProducto->caracteristica->nombre }}</td>
                            <td>{{ $prenda->estado }}</td>
                            <td>
                                <a href="{{ route('prendas.edit', $prenda->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $prenda->id }})">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Paginación -->
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        @if($prendas->currentPage() > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $prendas->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">
                                    <i class="fa fa-angle-left"></i>
                                </span>
                                <span class="visually-hidden">Anterior</span>
                            </a>
                        </li>
                        @endif
                        @for($i = 1; $i <= $prendas->lastPage(); $i++)
                        <li class="page-item {{ $i == $prendas->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $prendas->url($i) }}">{{ $i }}</a>
                        </li>
                        @endfor
                        @if($prendas->currentPage() < $prendas->lastPage())
                        <li class="page-item">
                            <a class="page-link" href="{{ $prendas->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">
                                    <i class="fa fa-angle-right"></i>
                                </span>
                                <span class="visually-hidden">Siguiente</span>
                            </a>
                        </li>
                        @endif
                    </ul>
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
        const prendaRows = document.querySelectorAll('.prenda-row');

        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.toLowerCase();

            prendaRows.forEach(row => {
                const rowData = row.textContent.toLowerCase();
                row.style.display = rowData.includes(searchTerm) ? 'table-row' : 'none';
            });
        });
    });

    function confirmDelete(prendaId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                submitDeleteForm(prendaId);
            }
        });
    }

    function submitDeleteForm(prendaId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/prendas/${prendaId}`;

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
    }
</script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
@endpush
