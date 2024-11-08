@extends('template')

@section('title', 'Categorías de Producto')

@push('css')
<!-- SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

@endpush

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        @include('configuracion.index')

        <div class="container w-100 p-4 mt-3">
            <div class="mb-4">
                <a href="{{ route('categoria_productos.create') }}">
                    <button type="button" class="btn btn-dark btn-lg">Añadir una nueva categoría</button>
                </a>
            </div>

            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Lista de Categorías de Producto</h3>
                </div>
                <div class="block-content block-content-full">
                    <table id="categoriasTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categoria_productos as $categoria)
                                <tr>
                                    <td>{{ $categoria->caracteristica->nombre }}</td>
                                    <td>{{ $categoria->caracteristica->descripcion }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Acciones básicas">
                                            <a href="{{ route('categoria_productos.edit', $categoria->id) }}" class="btn btn-warning">Editar</a>
                                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $categoria->id }}, '{{ $categoria->caracteristica->nombre }}')">Eliminar</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Formulario de eliminación (oculto) -->
                    <form id="deleteForm" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Simple DataTables JS -->
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>

<script>
 

    // Función para mostrar la confirmación de eliminación
    function confirmDelete(categoriaId, categoriaNombre) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Estás a punto de eliminar la categoría: " + categoriaNombre,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar el formulario de eliminación
                var form = document.getElementById('deleteForm');
                form.action = '/categoria_productos/' + categoriaId;
                form.submit();
            }
        });
    }

    // Mostrar mensajes de éxito o error con SweetAlert
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            timer: 5000,
            showConfirmButton: false
        });
    @endif
</script>
@endpush
