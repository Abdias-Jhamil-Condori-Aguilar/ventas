@extends('layouts.app')

@section('content')
<div class="content content-boxed">
    <div class="block block-rounded">
        <div class="block-header block-header-default d-flex justify-content-between align-items-center">
            <h3 class="block-title">Cumpleañeros del Mes</h3>
            <button type="button" class="btn-block-option btn btn-secondary" onclick="window.print();">
                <i class="si si-printer me-1"></i> Imprimir Reporte
            </button>
        </div>
        <div class="block-content">
            <div class="p-sm-4 p-xl-7">
                <!-- Formulario para selección del mes -->
                <form method="GET" action="{{ route('cumpleanieros.mes') }}">
                    <div class="form-group mb-4">
                        <label for="mes">Seleccione el mes:</label>
                        <select name="mes" id="mes" class="form-control">
                            @foreach(range(1, 12) as $numMes)
                                <option value="{{ $numMes }}" {{ $numMes == $mes ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::createFromDate(null, $numMes)->locale('es')->monthName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>

                <!-- Tabla para mostrar los cumpleañeros -->
                @if($clientes->isEmpty())
                    <div class="alert alert-info mt-4">
                        No hay cumpleañeros en este mes.
                    </div>
                @else
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clientes as $cliente)
                                    <tr>
                                        <td>{{ $cliente->nombre }}</td>
                                        <td>{{ $cliente->apellidos }}</td>
                                        <td>{{ $cliente->fecha_nacimiento}}</td>
                                        <td>{{ $cliente->telefono }}</td>
                                        <td>{{ $cliente->correo_electronico }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Sección de impresión personalizada (oculta en la vista, visible solo en impresión) -->
<div id="print-header" class="d-none">
    <div class="text-center">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo de la Empresa" style="width: 100px; height: auto;">
        <h2>Préstamos el Amanecer</h2>
        <p>Ubicada en Cercado, Cochabamba, sobre la avenida Panamericana entre Santa Barbara y San Joaquín, frente al Banco PRODEM</p>
        <p>Teléfono: +591 74103219</p>
    </div>
</div>

@endsection

@push('css')
<style>
    /* Estilos para la impresión */
    @media print {
        /* Ocultar todo menos el contenido relevante */
        body * {
            visibility: hidden;
        }
        #print-header, #print-header * {
            visibility: visible;
        }
        .block-content, .block-content * {
            visibility: visible;
        }
        #print-header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
        }

        /* Asegurar que el contenido se vea bien en la impresión */
        .table {
            font-size: 12px;
        }
    }
</style>
@endpush

@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ajuste adicional para la impresión
        window.onbeforeprint = function() {
            document.querySelectorAll('th, td').forEach(function(el) {
                el.style.fontSize = '10px'; // Ajusta para impresión
            });
        };
        
        window.onafterprint = function() {
            document.querySelectorAll('th, td').forEach(function(el) {
                el.style.fontSize = ''; // Restaurar el tamaño después de imprimir
            });
        };
    });
</script>
@endpush
