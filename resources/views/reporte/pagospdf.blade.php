<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Pagos</title>
    <style>
        /* Estilos del PDF */
        body { font-family: Arial, sans-serif; font-size: 10px; background-color: #f9f9f9; }
        .container { width: 100%; padding: 20px; background-color: white; }
        h1 { text-align: center; color: #333; }
        .date-time { text-align: right; font-size: 10px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #ddd; padding: 5px; text-align: center; }
        th { background-color: #159731; color: white; }
        .footer { text-align: center; font-size: 12px; color: #555; position: fixed; bottom: 0; left: 0; right: 0; }
        img.logo { display: block; margin: 0 auto 10px; width: 150px; }
    </style>
</head>
<body>
    <div class="date-time">
        <?php date_default_timezone_set('America/La_Paz'); ?>
        Fecha de impresión: <?php echo date('d/m/Y H:i:s'); ?>
    </div>

    <div class="container">
        <!-- Encabezado -->
        <img src="{{ public_path('images/logo.JPG') }}" alt="Logo Préstamos El Amanecer" class="logo">
        <h1>Reporte de Pagos</h1>

        @foreach($pagosPorMes as $mes => $pagos)
            <h2>{{ $meses_espanol[$mes] }}</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre del Cliente</th>
                        <th>Prenda</th>
                        <th>Descripción</th>
                        <th>Monto Pagado (Bs)</th>
                        <th>Fecha de Pago</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pagos as $pago)
                        <tr>
                            <td>{{ $pago->prestamo->cliente->nombre }} {{ $pago->prestamo->cliente->papellido }} {{ $pago->prestamo->cliente->sapellido }}</td>
                            <td>{{ $pago->prestamo->prenda->codigo }}</td>
                            <td>{{ $pago->prestamo->prenda->descripcion }}</td>
                            <td>{{ number_format($pago->monto_pagado, 2, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach

        <div class="footer">
            <p>Préstamos El Amanecer - Cochabamba, Bolivia | Tel: 555-1234</p>
        </div>
    </div>
</body>
</html>
