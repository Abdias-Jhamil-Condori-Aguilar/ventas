@extends('layouts.app')

@section('title', 'Clientes')

@push('css')
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
@include('layouts.partials.alert')

<!-- Main Container -->
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">Clientes</h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">Lista de Clientes</h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('panel') }}">Inicio</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Clientes</li>
                    </ol>
                </nav>
            </div>
        </div>
    
        @can('crear-cliente')
        <div class="content content-full">
            <a href="{{ route('clientes.create') }}">
                <button type="button" class="btn btn-dark btn-lg">Añadir nuevo registro</button>
            </a>
        </div>
        @endcan

        <!-- Búsqueda -->
        <div class="content content-full">
            <input type="text" id="search" placeholder="Buscar cliente..." class="form-control mb-3">
            <div class="row" id="client-list">
                @foreach($clientes->slice(0, 6) as $cliente)
                <div class="col-lg-4 client-card">
                    <a class="block block-rounded block-link-pop overflow-hidden" href="{{ route('clientes.show', $cliente->id) }}">
                        <div class="block-content">
                            <h4 class="mb-1"> {{ $cliente->nombre }} {{ $cliente->papellido }} {{ $cliente->sapellido }}</h4>
                            <p class="fs-sm text-muted">Teléfono: {{ $cliente->telefono }}
                                <br>
                                {{ $cliente->tipo_documento->caracteristica->nombre }}: {{ $cliente->numero_identificacion }}
                            </p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    @if($clientes->currentPage() > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $clientes->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">
                                <i class="fa fa-angle-left"></i>
                            </span>
                            <span class="visually-hidden">Anterior</span>
                        </a>
                    </li>
                    @endif
                    @for($i = 1; $i <= $clientes->lastPage(); $i++)
                    <li class="page-item {{ $i == $clientes->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $clientes->url($i) }}">{{ $i }}</a>
                    </li>
                    @endfor
                    @if($clientes->currentPage() < $clientes->lastPage())
                    <li class="page-item">
                        <a class="page-link" href="{{ $clientes->nextPageUrl() }}" aria-label="Next">
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
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const clientCards = document.querySelectorAll('.client-card');

    searchInput.addEventListener('input', function() {
        const searchTerm = searchInput.value.toLowerCase();

        clientCards.forEach(card => {
            const clientName = card.querySelector('h4').textContent.toLowerCase();
            const clientTel = card.querySelector('p').textContent.toLowerCase();

            // Verifica si el nombre o el teléfono contienen el término de búsqueda
            if (clientName.includes(searchTerm) || clientTel.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
</script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
@endpush
