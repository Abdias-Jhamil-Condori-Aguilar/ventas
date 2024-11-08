@extends('layouts.app')

@section('title', 'Tipos de Documentos')

@push('css')
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')

<div class="bg-body-light">
    <div class="content content-full">
        @include('configuracion.index')

    @can('crear-tipo_documento')
    <div class="container w-100 p-4 mt-3">
        <div class="mb-4">
            <a href="{{ route('tipo_documentos.create') }}">
                <button type="button" class="btn btn-dark btn-lg">Añadir nuevo tipo</button>
            </a>
        </div>
    @endcan
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Lista de Tipos de Documentos</h3>
        </div>
        <div class="block-content block-content-full">
            <table id="categoriasTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tipo_documentos as $tipo)
                    <tr>
                        <td>{{ $tipo->caracteristica->nombre }}</td>
                        <td>{{ $tipo->caracteristica->descripcion }}</td>
                        <td>
                            <a href="{{ route('tipo_documentos.edit', $tipo->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('tipo_documentos.destroy', $tipo->id) }}" method="POST" style="display:inline-block;" id="deleteForm-{{ $tipo->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $tipo->id }}', '{{ $tipo->caracteristica->nombre }}')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script>
    // Función para mostrar la confirmación de eliminación
    function confirmDelete(tipoId, tipoNombre) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Estás a punto de eliminar el tipo de documento: " + tipoNombre,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar el formulario de eliminación
                document.getElementById('deleteForm-' + tipoId).submit();
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
