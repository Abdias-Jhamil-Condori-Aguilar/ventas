@extends('layouts.app')

@section('content')
<h2 class="content-heading">Generar Gráfica de Flujo de Caja</h2>

<div class="row">
    <div class="col-md-4">
        <form id="filtro-flujo-caja">
            <select id="anio" class="form-select mb-2">
                <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                @foreach(range(date('Y'), date('Y') - 5) as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
            <select id="mes" class="form-select mb-2">
                <option value="">Todos los Meses</option>
                @foreach(range(1, 12) as $month)
                    <option value="{{ $month }}">{{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary w-100">Generar Gráfica</button>
            <button type="button" onclick="exportarPDF()" class="btn btn-danger w-100 mt-2">Exportar PDF</button>
        </form>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <canvas id="flujoDeCajaChart" width="400" height="150"></canvas>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <h5>Total Monto de Préstamos: <span id="total-prestamos">0</span> Bs</h5>
        <h5>Total Monto Pagado en Pagos: <span id="total-pagos">0</span> Bs</h5>
        <h5>Resta (Pagos - Prestamos): <span id="diferencia">0</span> Bs</h5>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('flujoDeCajaChart').getContext('2d');
        let flujoDeCajaChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                datasets: [
                    {
                        label: 'Monto de Préstamos',
                        data: Array(12).fill(0),
                        backgroundColor: '#3498db'
                    },
                    {
                        label: 'Monto Pagado en Pagos',
                        data: Array(12).fill(0),
                        backgroundColor: '#2ecc71'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Monto en Bs'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mes'
                        }
                    }
                }
            }
        });

        document.getElementById('filtro-flujo-caja').addEventListener('submit', function (e) {
            e.preventDefault();
            const anio = document.getElementById('anio').value;
            const mes = document.getElementById('mes').value;

            fetch(`/reporte/obtener-flujo-caja?anio=${anio}&mes=${mes}`)
                .then(response => response.json())
                .then(data => {
                    const prestamosData = mes ? Array(12).fill(0) : data.prestamos;
                    const pagosData = mes ? Array(12).fill(0) : data.pagos;

                    if (mes) {
                        prestamosData[mes - 1] = data.prestamos[mes - 1];
                        pagosData[mes - 1] = data.pagos[mes - 1];
                    }

                    flujoDeCajaChart.data.datasets[0].data = prestamosData;
                    flujoDeCajaChart.data.datasets[1].data = pagosData;
                    flujoDeCajaChart.update();

                    document.getElementById('total-prestamos').textContent = data.totalPrestamos;
                    document.getElementById('total-pagos').textContent = data.totalPagos;
                    document.getElementById('diferencia').textContent = data.diferencia;
                });
        });
    });

    function exportarPDF() {
        const anio = document.getElementById('anio').value;
        const mes = document.getElementById('mes').value;
        const url = new URL(window.location.origin + '/reporte/exportar-flujo-caja-pdf');
        url.searchParams.append('anio', anio);
        url.searchParams.append('mes', mes);

        window.open(url.toString(), '_blank');
    }
</script>
@endsection
                  