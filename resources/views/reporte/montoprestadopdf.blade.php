<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Monto Prestado</title>
    <style>
        /* Estilos del PDF */
        body { font-family: Arial, sans-serif; font-size: 10px; background-color: #f9f9f9; }
        .container { width: 100%; padding: 20px; background-color: white; }
        h1 { text-align: center; color: #333; }
        .date-time { text-align: right; font-size: 10px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #ddd; padding: 5px; text-align: center; }
        th { background-color: #128bc4; color: white; }
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
        <h1>Reporte de Monto Prestado</h1>

        @foreach ($prestamos as $mes => $mes_prestamos)
            <h2>{{ $meses_espanol[$mes] }}</h2>
            <table>
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Prenda</th>
                        <th>Descripción</th>
                        <th>Monto (Bs)</th>
                        <th>Fecha de Inicio</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mes_prestamos as $prestamo)
                        <tr>
                            <td>{{ $prestamo->cliente->nombre }} {{ $prestamo->cliente->papellido }} {{ $prestamo->cliente->sapellido }}</td>
                            <td>{{ $prestamo->prenda->codigo }}</td>
                            <td>{{ $prestamo->prenda->descripcion }}</td>
                            <td>Bs. {{ number_format($prestamo->monto, 2) }}</td>
                            <td>{{ $prestamo->fecha_inicio}}</td>
                            <td>{{ $prestamo->estado }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </div>

    <!-- Pie de página -->
    <div class="footer">
        <p>Préstamos El Amanecer - Cochabamba, Bolivia | Tel: 555-1234</p>
    </div>
</body>
</html>
