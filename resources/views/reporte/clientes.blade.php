@extends('layouts.app')

@section('content')
<div class="content content-boxed">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Clientes por orden alfabético <small>Exportar</small></h3>
            <!-- Botón para exportar PDF -->
            <a href="{{ route('reportes.clientespdf', ['ordenarPor' => $ordenarPor, 'direccion' => $direccion]) }}" class="btn btn-primary" target="_blank">Exportar a PDF</a>
        </div>
        <div class="block-content block-content-full overflow-x-auto">
          

            <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">ID</th>
                        <th class="d-none d-sm-table-cell">
                            <a href="{{ route('reporte.clientes', ['ordenarPor' => 'nombre', 'direccion' => $ordenarPor == 'nombre' && $direccion == 'asc' ? 'desc' : 'asc']) }}">
                                Nombre @if($ordenarPor == 'nombre') &#x21D5; @endif
                            </a>
                        </th>
                        <th class="d-none d-sm-table-cell">
                            <a href="{{ route('reporte.clientes', ['ordenarPor' => 'papellido', 'direccion' => $ordenarPor == 'papellido' && $direccion == 'asc' ? 'desc' : 'asc']) }}">
                                Primer Apellido @if($ordenarPor == 'papellido') &#x21D5; @endif
                            </a>
                        </th>
                        <th class="d-none d-sm-table-cell">
                            <a href="{{ route('reporte.clientes', ['ordenarPor' => 'sapellido', 'direccion' => $ordenarPor == 'sapellido' && $direccion == 'asc' ? 'desc' : 'asc']) }}">
                                Segundo Apellido @if($ordenarPor == 'sapellido') &#x21D5; @endif
                            </a>
                        </th>
                            <th class="d-none d-sm-table-cell">Fecha de Nacimiento</th>
                        <th class="d-none d-sm-table-cell">Teléfono</th>
                        <th class="d-none d-sm-table-cell">Correo Electrónico</th>
                        <th class="d-none d-sm-table-cell">Tipo de Identificación</th>
                        <th class="d-none d-sm-table-cell">No. Identificación</th>
                        <th class="d-none d-sm-table-cell">Fecha de Registro</th>
                    </tr>
                </thead>
                <tbody id="clientes-tbody">
                    @foreach($clientes as $cliente)
                    <tr>
                        <td class="text-center fs-sm">{{ $loop->iteration }}</td>
                        <td class="fw-semibold fs-sm">{{ $cliente->nombre }}</td>
                        <td class="d-none d-sm-table-cell fs-sm">{{ $cliente->papellido }}</td>
                        <td class="d-none d-sm-table-cell fs-sm">{{ $cliente->sapellido }}</td>
                        <td class="d-none d-sm-table-cell fs-sm">{{ $cliente->fecha_nacimiento }}</td>
                        <td class="d-none d-sm-table-cell fs-sm">{{ $cliente->telefono }}</td>
                        <td class="d-none d-sm-table-cell fs-sm">{{ $cliente->correo_electronico }}</td>
                        <td class="d-none d-sm-table-cell fs-sm">{{ $cliente->tipo_documento->caracteristica->nombre ?? 'N/A' }}</td>
                        <td class="d-none d-sm-table-cell fs-sm">{{ $cliente->numero_identificacion }}</td>
                        <td class="d-none d-sm-table-cell fs-sm">{{ $cliente->created_at->format('Y-m') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function ordenarPor(campo) {
        const table = document.getElementById('clientes-tbody');
        const rows = Array.from(table.rows);

        // Alternar entre ascendente y descendente
        const esAscendente = table.getAttribute('data-order') === 'asc';
        table.setAttribute('data-order', esAscendente ? 'desc' : 'asc');

        // Determinar el índice de la columna a ordenar
        let indiceColumna;
        switch(campo) {
            case 'nombre':
                indiceColumna = 1;  // Segunda columna (nombre)
                break;
            case 'papellido':
                indiceColumna = 2;  // Tercera columna (primer apellido)
                break;
            case 'sapellido':
                indiceColumna = 3;  // Cuarta columna (segundo apellido)
                break;
        }

        // Ordenar las filas según el campo seleccionado
        rows.sort((a, b) => {
            const aText = a.cells[indiceColumna].innerText.toLowerCase();
            const bText = b.cells[indiceColumna].innerText.toLowerCase();
            return esAscendente ? aText.localeCompare(bText) : bText.localeCompare(aText);
        });

        // Eliminar y volver a agregar las filas en el orden correcto
        rows.forEach(row => table.appendChild(row));
    }
</script>

@endsection
