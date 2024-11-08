@extends('layouts.app')

@section('content')
<div class="content content-boxed">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Préstamos por Vencer <small>Exportar Reporte</small></h3>
        </div>
        <div class="block-content block-content-full overflow-x-auto">
            <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">ID</th>
                        <th>Cliente</th>
                        <th>Monto</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Vencimiento</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prestamos as $prestamo)
                    <tr>
                        <td class="text-center fs-sm">{{ $loop->iteration }}</td>
                        <td class="fw-semibold fs-sm">{{ $prestamo->cliente->nombre }}</td>
                        <td class="fs-sm">{{ $prestamo->monto }}</td>
                        <td class="fs-sm">{{ $prestamo->fecha_inicio }}</td>
                        <td class="fs-sm">{{ $prestamo->fecha_fin}}</td>
                        <td class="fs-sm">{{ $prestamo->estado }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
