@extends('template')

@section('title', 'Tipos de Pago')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
      @include('configuracion.index')

        <div class="container w-100 p-4 mt-3">
            <div class="mb-4">
                <a href="{{ route('tipo_pagos.create') }}">
                    <button type="button" class="btn btn-dark btn-lg">Añadir un nuevo tipo de pago</button>
                </a>
            </div>

            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Lista de Tipos de Pago</h3>
                </div>
                <div class="block-content block-content-full">
                    <table id="tiposPagoTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tipo_pagos as $tipoPago)
                                <tr>
                                  <td>{{ $tipoPago->caracteristica->nombre }}</td>
                                  <td>{{ $tipoPago->caracteristica->descripcion }}</td>
                                  <td>
                                        <div class="btn-group" role="group" aria-label="Acciones básicas">
                                            <a href="{{ route('tipo_pagos.edit', $tipoPago->id) }}" class="btn btn-warning">Editar</a>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#confirModal-{{ $tipoPago->id }}">Eliminar</button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal de Confirmación -->
                                <div class="modal fade" id="confirModal-{{ $tipoPago->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmación</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Seguro que quieres eliminar este tipo de pago?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                                <form action="{{ route('tipo_pagos.destroy', $tipoPago->id) }}"
                                                    method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Confirmar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new simpleDatatables.DataTable("#tiposPagoTable");
        });
    </script>
@endpush
