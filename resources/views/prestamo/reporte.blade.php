@extends('layouts.app')

@section('content')
<div class="content content-boxed">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Reporte de Préstamos <small>Exportar Reporte</small></h3>
            <a href="{{ route('prestamos.pdf', ['estado' => request('estado')]) }}" class="btn btn-primary" target="_blank">Exportar a PDF</a>
        </div>
        <div class="block-content block-content-full overflow-x-auto">
            <!-- Formulario de filtro de estado -->
            <form action="{{ route('prestamos.reporte') }}" method="GET">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="estado" class="form-label">Seleccionar Estado</label>
                        <select class="form-control" id="estado" name="estado">
                            <option value="">Todos</option>
                            <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="vencido" {{ request('estado') == 'vencido' ? 'selected' : '' }}>Vencido</option>
                            <option value="liquidado" {{ request('estado') == 'liquidado' ? 'selected' : '' }}>Liquidado</option>
                            <option value="venta" {{ request('estado') == 'venta' ? 'selected' : '' }}>Venta</option>
                        </select>
                    </div>
                    <div class="col-md-4 align-self-end">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                    </div>
                    <div class="col-md-4 align-self-end"></div>
                </div>
            </form>

            <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">ID</th>
                        <th class="d-none d-sm-table-cell">Cliente</th>
                        <th class="d-none d-sm-table-cell">Prenda</th>
                        <th class="d-none d-sm-table-cell">Monto</th>
                        <th class="d-none d-sm-table-cell">Fecha de Inicio</th>
                        <th class="d-none d-sm-table-cell">Fecha de Vencimiento</th>
                        <th class="d-none d-sm-table-cell">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prestamos as $prestamo)
                    <tr>
                        <td class="text-center fs-sm">{{ $loop->iteration }}</td>
                        <td class="fw-semibold fs-sm">{{ $prestamo->cliente->nombre }}</td>
                        <td class="d-none d-sm-table-cell fs-sm">{{ $prestamo->prenda->descripcion }}</td>
                        <td class="d-none d-sm-table-cell fs-sm">{{ $prestamo->monto }} Bs</td>
                        <td class="d-none d-sm-table-cell fs-sm">{{ $prestamo->fecha_inicio }}</td>
                        <td class="d-none d-sm-table-cell fs-sm">{{ $prestamo->fecha_fin }}</td>
                        <td class="d-none d-sm-table-cell fs-sm">{{ ucfirst($prestamo->estado) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('js')
<script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables-buttons/buttons.colVis.min.js') }}"></script>
@endpush
@endsection
