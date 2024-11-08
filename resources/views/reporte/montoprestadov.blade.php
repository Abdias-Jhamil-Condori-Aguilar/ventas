@extends('layouts.app')

@section('content')
<main id="main-container">
    <div class="content">
        <div class="block block-rounded">
            <div class="block-content">
                <div class="row items-push">
                    <div class="col-md-8 col-lg-7 col-xl-9">
                        <!-- Contenedor del Calendario -->
                        <div id="js-calendar"></div>
                    </div>
                    <div class="col-md-4 col-lg-5 col-xl-3">
                        <!-- Formulario de Filtros -->
                        <form id="filtro-calendario" class="push">
                            <div class="input-group mb-3">
                                <select id="anio" class="form-select" name="anio">
                                    <option value="">Seleccione Año</option>
                                    @foreach(range(date('Y'), date('Y') - 5) as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <select id="mes" class="form-select" name="mes">
                                    <option value="">Seleccione Mes</option>
                                    @foreach(range(1, 12) as $month)
                                        <option value="{{ $month }}">{{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <select id="estado" class="form-select" name="estado">
                                    <option value="">Seleccione Estado</option>
                                    <option value="Activo">Activo</option>
                                    <option value="Liquidado">Liquidado</option>
                                    <option value="Venta">Venta</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                        </form>
                        <!-- Formulario de Exportación a PDF -->
                        <form id="exportar-pdf-form" action="{{ route('reporte.exportarMontoPrestadoPDF') }}" method="GET" target="_blank">
                            <input type="hidden" name="anio" id="export-anio">
                            <input type="hidden" name="mes" id="export-mes">
                            <input type="hidden" name="estado" id="export-estado">
                            <button type="submit" class="btn btn-secondary w-100">Exportar PDF</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Page JS Plugins -->
<script src="{{ asset('js/plugins/fullcalendar/index.global.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('js-calendar');
    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: {
            url: '{{ url("/reporte/obtener-prestamos") }}',
            extraParams: function() {
                return {
                    anio: document.getElementById('anio').value,
                    mes: document.getElementById('mes').value,
                    estado: document.getElementById('estado').value,
                };
            }
        },
        locale: 'es',
    });
    
    calendar.render();

    // Actualizar calendario con filtros al enviar el formulario
    document.getElementById('filtro-calendario').addEventListener('submit', function (e) {
        e.preventDefault();
        calendar.refetchEvents();
    });

    // Sincronizar los valores de los filtros al formulario de exportación PDF antes de enviar
    document.getElementById('exportar-pdf-form').addEventListener('submit', function (e) {
        document.getElementById('export-anio').value = document.getElementById('anio').value;
        document.getElementById('export-mes').value = document.getElementById('mes').value;
        document.getElementById('export-estado').value = document.getElementById('estado').value;
    });
});
</script>
@endsection
