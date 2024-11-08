@extends('layouts.app')

@section('content')
<main id="main-container">
    <div class="content">
        <div class="block block-rounded">
            <div class="block-content">
                <div class="row items-push">
                    <div class="col-md-8 col-lg-7 col-xl-9">
                        <!-- Contenedor del Calendario -->
                        <div id="js-calendar-pagos"></div>
                    </div>
                    <div class="col-md-4 col-lg-5 col-xl-3">
                        <!-- Formulario de Filtros -->
                        <form id="filtro-calendario-pagos" class="push" method="GET">
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
                            <button type="submit" class="btn btn-primary w-100 mb-3">Filtrar</button>
                            <button type="button" class="btn btn-danger w-100" onclick="exportarPDF()">Exportar a PDF</button>
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
    let calendarEl = document.getElementById('js-calendar-pagos');
    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: {
            url: '{{ url("/reporte/obtener-pagos") }}',
            extraParams: function() {
                return {
                    anio: document.getElementById('anio').value,
                    mes: document.getElementById('mes').value,
                };
            }
        },
        locale: 'es',
    });
    
    calendar.render();

    // Actualizar calendario con filtros al enviar el formulario
    document.getElementById('filtro-calendario-pagos').addEventListener('submit', function (e) {
        e.preventDefault();
        calendar.refetchEvents();
    });
});

// Función para exportar a PDF
function exportarPDF() {
    const anio = document.getElementById('anio').value;
    const mes = document.getElementById('mes').value;
    window.open(`{{ url('/reporte/exportar-pagos-pdf') }}?anio=${anio}&mes=${mes}`, '_blank');
}
</script>
@endsection
